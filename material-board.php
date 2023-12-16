<?php

/**
 * Plugin Name:         Material Board
 * Plugin URI:          https://github.com/fatihbalsoy/material-board
 * Description:         The Material Board plugin for WordPress updates the appearance of your site's dashboard to a sleeker, more contemporary design based on Google's Material Design Guidelines. This plugin preserves your existing dashboard layout, avoids making any significant alterations, and doesn't include any branding or promotional content. It's straightforward to use and comes at no cost.
 * Author: 	            Fatih Balsoy
 * Version: 	        0.3.6
 * Text Domain:         material-board
 * Domain Path:         /languages
 * Author URI:          https://fatih.bal.soy
 * GitHub Plugin URI:   https://github.com/fatihbalsoy/material-board
 * License:             AGPL-3.0+
 * License URI:         https://www.gnu.org/licenses/agpl-3.0.txt
 */

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

$fbwpmdp_author = "Fatih Balsoy";
$fbwpmdp_author_website = "https://fatih.bal.soy";
$fbwpmdp_website = "https://fatih.bal.soy/projects/material-board";

$fbwpmdp_github_slug = "fatihbalsoy/material-board";
$fbwpmdp_github = "https://github.com/" . $fbwpmdp_github_slug;
$fbwpmdp_github_releases = "https://api.github.com/repos/" . $fbwpmdp_github_slug . "/releases";
$fbwpmdp_report_bugs = $fbwpmdp_github . "/issues/new";

$fbwpmdp_crowdin = "https://crowdin.com/project/material-dashboard";

$fbwpmdp_name = "Material Board";
$fbwpmdp_bundle = "material-board";
$fbwpmdp_settings_title = $fbwpmdp_name;

class MaterialBoardPlugin
{
    public string $settings_slug;
    private array $options = array(
        /** Theme **/
        // - Light, Dark, System
        'fbwpmdp_theme' => 'light',
        // - Rounded Corners
        'fbwpmdp_rounded_corners' => 'on',
        // - Large Admin Bar
        'fbwpmdp_large_admin_bar' => 'off',
        // - Admin Bar Variant
        'fbwpmdp_large_admin_bar_variant' => '2',

        /** Colors **/
        // - Primary
        'fbwpmdp_colors_primary' => '#2246CC',
        // - Accent
        'fbwpmdp_colors_accent' => '#FF0085',

        /** Font **/
        // - Body
        'fbwpmdp_font' => 'dm-sans',
        // - Header
        'fbwpmdp_header_serif_font' => 'off',

        /** Icons **/
        'fbwpmdp_icons' => 'md-icons'
    );

    function __construct()
    {
        $this->settings_slug = 'material-board-settings';
        if (is_admin()) {
            if(!function_exists('get_plugin_data')){
                require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
            }
            $plugin_data = get_plugin_data( __FILE__ );
            $GLOBALS["fbwpmdp_version"] = $plugin_data["Version"];
        }

        add_action('wp_enqueue_scripts', array($this, 'fbwpmdp_admin_user_theme_style'));
        add_action('admin_enqueue_scripts', array($this, 'fbwpmdp_admin_theme_style'));
        add_action('login_enqueue_scripts', array($this, 'fbwpmdp_login_theme_style'));
        add_action('admin_menu', array($this, 'fbwpmdp_plugin_menu'));
        add_action('admin_init', array($this, 'settings'));
        add_action('admin_init', array($this, 'setup_languages'));
        add_action('admin_head', array($this, 'change_theme_color_meta'));
        // add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'fbwpmdp_plugin_settings_link');
    }

    /** Language Support **/
    function setup_languages()
    {
        // Set the theme's text domain
        load_plugin_textdomain($GLOBALS['fbwpmdp_bundle'], false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /** User-facing Admin Theme (Admin Bar) **/
    function fbwpmdp_admin_user_theme_style()
    {
        wp_enqueue_style('mdp-user-theme', plugins_url('styles/wp.css', __FILE__));

        $this->load_plugin_options();
    }

    /** Admin Dashboard Theme **/
    function fbwpmdp_admin_theme_style()
    {
        // wp_enqueue_script('theme-script', plugins_url('app.js', __FILE__), array('jquery'));
        wp_enqueue_style('mdp-admin-theme', plugins_url('styles/wp-admin.css', __FILE__));

        $split_wp_version = explode(".", $GLOBALS['wp_version']);
        $wp_ver_major = intval($split_wp_version[0]);
        $wp_ver_minor = intval($split_wp_version[1]);
        if ($wp_ver_major >= 6 || ($wp_ver_major == 5 && $wp_ver_minor >= 9)) {
            wp_enqueue_style('mdp-admin-theme-5-9', plugins_url('styles/compatibility/5.9/wp-admin.css', __FILE__));
        }

        $this->load_plugin_options();
    }

    /** Safari and Chrome Browser Theme Color **/
    function change_theme_color_meta()
    {
        if (is_admin()) {
            $primary_color = get_option('fbwpmdp_colors_primary');
            echo '<meta name="theme-color" content="' . esc_attr($primary_color) . '">';
        }
    }

    /** Login Theme **/
    function fbwpmdp_login_theme_style()
    {
        wp_enqueue_style('mdp-login-theme', plugins_url('styles/wp-login.css', __FILE__));

        $this->load_plugin_options();
    }

    /** Plugin Menu **/
    function fbwpmdp_plugin_menu()
    {
        add_theme_page($GLOBALS["fbwpmdp_name"], $GLOBALS["fbwpmdp_name"], 'manage_options', $this->settings_slug, array($this, 'fbwpmdp_plugin_options'));
    }

    /** Plugin Settings Menu **/
    function fbwpmdp_plugin_settings_link($links)
    {
        $url = get_admin_url() . "themes.php?page=material-board-settings";
        $settings_link = '<a href="' . $url . '">' . esc_html_e('Settings', 'material-board') . '</a>';
        $links[] = $settings_link;
        return $links;
    }

    /** Load Plugin Options **/
    function load_plugin_options()
    {

        //? -- COLORS -- ?//
        $color_stylesheet = $this->fbwpmdp_get_local_file_contents("styles/shared.dynamic.css");
        $color_stylesheet_with_primary = str_replace("\"primary-color\"", get_option('fbwpmdp_colors_primary'), $color_stylesheet);
        $color_stylesheet_with_primary_and_accent = str_replace("\"accent-color\"", get_option('fbwpmdp_colors_accent'), $color_stylesheet_with_primary);
        wp_add_inline_style('mdp-admin-theme', $color_stylesheet_with_primary_and_accent);
        wp_add_inline_style('mdp-user-theme', $color_stylesheet_with_primary_and_accent);
        wp_add_inline_style('mdp-login-theme', $color_stylesheet_with_primary_and_accent);

        //? -- DARK MODE -- ?//
        function fbwpmdp_enqueue_dark_theme()
        {
            wp_enqueue_style('dark-admin-theme', plugins_url('styles/themes/shared.dark.css', __FILE__));
        }

        // Explicit Dark Mode
        if ($this->get_option_or_default('fbwpmdp_theme') == 'dark') {
            fbwpmdp_enqueue_dark_theme();
        }
        // Automatic Dark Mode
        else if ($this->get_option_or_default('fbwpmdp_theme') == 'auto') {
            // print_r($_COOKIE);
            if ($_COOKIE['system_theme'] == 'dark') {
                fbwpmdp_enqueue_dark_theme();
            }
        }

        //? -- FONT -- ?//
        switch ($this->get_option_or_default('fbwpmdp_font')) {
            case 'dm-sans':
                wp_enqueue_style('dm-sans-font', plugins_url('assets/fonts/dm-sans.css', __FILE__));
                break;
            case 'mona-sans':
                wp_enqueue_style('mona-sans-font', plugins_url('assets/fonts/mona-sans.css', __FILE__));
                break;
            case 'hubot-sans':
                wp_enqueue_style('hubot-sans-font', plugins_url('assets/fonts/hubot-sans.css', __FILE__));
                break;
            case 'roboto':
                wp_enqueue_style('roboto-sans-font', plugins_url('assets/fonts/roboto.css', __FILE__));
                break;
            default:
                wp_enqueue_style('default-font', plugins_url('assets/fonts/default.css', __FILE__));
                break;
        }

        // Header Serif Font
        if ($this->get_option_or_default('fbwpmdp_header_serif_font') == 'on') {
            wp_enqueue_style('header-serif-font', plugins_url('styles/options/header_serif.css', __FILE__));
        } else {
            wp_dequeue_style('header-serif-font');
        }

        //? -- ROUNDED CORNERS -- ?//
        if ($this->get_option_or_default('fbwpmdp_rounded_corners') != 'on') {
            wp_enqueue_style('rounded-corners', plugins_url('styles/options/no_rounded_corners.css', __FILE__));
        } else {
            wp_dequeue_style('rounded-corners');
        }

        //? -- LARGE ADMIN BAR -- ?//
        if ($this->get_option_or_default('fbwpmdp_large_admin_bar') == 'on' and is_admin()) {
            wp_enqueue_style('large_admin_bar', plugins_url('styles/options/large_app_bar.css', __FILE__));
            wp_enqueue_script('large_admin_bar_script', plugins_url('styles/options/large_app_bar.js', __FILE__));
            if ($this->get_option_or_default('fbwpmdp_large_admin_bar_variant') == '1') {
                // Admin Bar on top
                wp_enqueue_style('large_admin_bar_variant', plugins_url('styles/options/large_app_bar_1.css', __FILE__));
            } else {
                // Admin Menu on top
                wp_enqueue_style('large_admin_bar_variant', plugins_url('styles/options/large_app_bar_2.css', __FILE__));
            }
        } else {
            wp_dequeue_style('large_admin_bar');
            wp_dequeue_style('large_admin_bar_variant');
            wp_dequeue_script('large_admin_bar_script');
        }

        //? -- ICONS -- ?//
        // TODO: be able to disable material icons on login page
        if ($this->get_option_or_default('fbwpmdp_icons') == 'md-icons' && !is_login()) {
            wp_enqueue_style('material-icons', plugins_url('styles/icons/material-icons.css', __FILE__));
        } else {
            wp_dequeue_style('material-icons');
        }
    }

    /** Plugin Options **/
    function fbwpmdp_plugin_options()
    {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html_e('You do not have sufficient permissions to access this page.'));
        }
        echo $this->fbwpmdp_get_local_file_contents('settings/index.php');
    }

    function get_option_or_default($option)
    {
        return get_option($option, $this->options[$option]);
    }

    function settings()
    {
        foreach ($this->options as $key => $value) {
            add_option($key, $value);
            register_setting('material_dashboard_plugin', $key, array('sanitize_callback' => 'sanitize_text_field', 'default' => $value));
        }
    }

    // TODO: Replace this function
    function fbwpmdp_get_local_file_contents($file_path)
    {
        ob_start();
        include $file_path;
        $contents = ob_get_clean();

        return $contents;
    }
}

$materialBoardPlugin = new MaterialBoardPlugin();
