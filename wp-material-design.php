<?php

/**
 * Plugin Name:         Material Dashboard
 * Plugin URI:          https://github.com/fatihbalsoy/wp-material-design
 * Description:         The Material Dashboard plugin for WordPress updates the appearance of your site's dashboard to a sleeker, more contemporary design based on Google's Material Design Guidelines. This plugin preserves your existing dashboard layout, avoids making any significant alterations, and doesn't include any branding or promotional content. It's straightforward to use and comes at no cost.
 * Author: 	            Fatih Balsoy
 * Version: 	        0.3.2-alpha
 * Text Domain:         wp-material-design
 * Domain Path:         /languages
 * Author URI:          https://fatih.bal.soy
 * GitHub Plugin URI:   https://github.com/fatihbalsoy/wp-material-design
 * License:             AGPL-3.0+
 * License URI:         https://www.gnu.org/licenses/agpl-3.0.txt
 */

$fb_mdp_plugin_version = "0.3.2-alpha";
$fb_mdp_plugin_author = "Fatih Balsoy";
$fb_mdp_plugin_author_website = "https://fatih.bal.soy";
$fb_mdp_plugin_website = "https://fatih.bal.soy/projects/wp-material-design";

$fb_mdp_plugin_github_slug = "fatihbalsoy/wp-material-design";
$fb_mdp_plugin_github = "https://github.com/" . $fb_mdp_plugin_github_slug;
$fb_mdp_plugin_github_releases = "https://api.github.com/repos/" . $fb_mdp_plugin_github_slug . "/releases";
$fb_mdp_plugin_report_bugs = $fb_mdp_plugin_github . "/issues/new";

$fb_mdp_plugin_name = "Material Dashboard";
$fb_mdp_plugin_bundle = "wp-material-design";
$fb_mdp_plugin_settings_title = $fb_mdp_plugin_name;
// $fb_mdp_plugin_directory = plugins_url('', dirname(__FILE__)) . "/" . $fb_mdp_plugin_bundle;

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

class MaterialDashboardPlugin
{
    public string $settings_slug;
    private array $options = array(
        /** Theme **/
        // - Light, Dark, System
        'mdp_theme' => 'light',
        // - Rounded Corners
        'mdp_rounded_corners' => 'on',
        // - Large Admin Bar
        'mdp_large_admin_bar' => 'off',
        // - Admin Bar Variant
        'mdp_large_admin_bar_variant' => '2',

        /** Colors **/
        // - Primary
        'mdp_colors_primary' => '#2246CC',
        // - Accent
        'mdp_colors_accent' => '#FF0085',

        /** Font **/
        // - Body
        'mdp_font' => 'dm-sans',
        // - Header
        'mdp_header_serif_font' => 'off',

        /** Icons **/
        'mdp_icons' => 'md-icons'
    );

    function __construct()
    {
        $this->settings_slug = 'material-dashboard-settings';

        add_action('wp_enqueue_scripts', array($this, 'mdp_admin_user_theme_style'));
        add_action('admin_enqueue_scripts', array($this, 'mdp_admin_theme_style'));
        add_action('login_enqueue_scripts', array($this, 'mdp_login_theme_style'));
        add_action('admin_menu', array($this, 'mdp_plugin_menu'));
        add_action('admin_init', array($this, 'settings'));
        add_action('admin_init', array($this, 'setup_languages'));
        add_action('admin_head', array($this, 'change_theme_color_meta'));
        // add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'mdp_plugin_settings_link');
    }

    /** Language Support **/
    function setup_languages()
    {
        // Set the theme's text domain
        load_plugin_textdomain($GLOBALS['fb_mdp_plugin_bundle'], false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }

    /** User-facing Admin Theme (Admin Bar) **/
    function mdp_admin_user_theme_style()
    {
        wp_enqueue_style('mdp-user-theme', plugins_url('styles/wp.css', __FILE__));

        $this->load_plugin_options();
    }

    /** Admin Dashboard Theme **/
    function mdp_admin_theme_style()
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
            $primary_color = get_option('mdp_colors_primary');
            echo '<meta name="theme-color" content="' . $primary_color . '">';
        }
    }

    /** Login Theme **/
    function mdp_login_theme_style()
    {
        wp_enqueue_style('mdp-login-theme', plugins_url('styles/wp-login.css', __FILE__));

        $this->load_plugin_options();
    }

    /** Plugin Menu **/
    function mdp_plugin_menu()
    {
        add_theme_page($GLOBALS["fb_mdp_plugin_name"], $GLOBALS["fb_mdp_plugin_name"], 'manage_options', $this->settings_slug, array($this, 'mdp_plugin_options'));
    }

    /** Plugin Settings Menu **/
    function mdp_plugin_settings_link($links)
    {
        $url = get_admin_url() . "themes.php?page=material-dashboard-settings";
        $settings_link = '<a href="' . $url . '">' . __('Settings', 'wp-material-design') . '</a>';
        $links[] = $settings_link;
        return $links;
    }

    /** Load Plugin Options **/
    function load_plugin_options()
    {

        //? -- COLORS -- ?//
        $color_stylesheet = $this->get_local_file_contents("styles/shared.dynamic.css");
        $color_stylesheet_with_primary = str_replace("\"primary-color\"", get_option('mdp_colors_primary'), $color_stylesheet);
        $color_stylesheet_with_primary_and_accent = str_replace("\"accent-color\"", get_option('mdp_colors_accent'), $color_stylesheet_with_primary);
        wp_add_inline_style('mdp-admin-theme', $color_stylesheet_with_primary_and_accent);
        wp_add_inline_style('mdp-user-theme', $color_stylesheet_with_primary_and_accent);
        wp_add_inline_style('mdp-login-theme', $color_stylesheet_with_primary_and_accent);

        //? -- DARK MODE -- ?//
        function enqueue_dark_theme()
        {
            wp_enqueue_style('dark-admin-theme', plugins_url('styles/themes/shared.dark.css', __FILE__));
        }

        // Explicit Dark Mode
        if ($this->get_option_or_default('mdp_theme') == 'dark') {
            enqueue_dark_theme();
        }
        // Automatic Dark Mode
        else if ($this->get_option_or_default('mdp_theme') == 'auto') {
            // print_r($_COOKIE);
            if ($_COOKIE['system_theme'] == 'dark') {
                enqueue_dark_theme();
            }
        }

        //? -- FONT -- ?//
        switch ($this->get_option_or_default('mdp_font')) {
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
        if ($this->get_option_or_default('mdp_header_serif_font') == 'on') {
            wp_enqueue_style('header-serif-font', plugins_url('styles/options/header_serif.css', __FILE__));
        } else {
            wp_dequeue_style('header-serif-font');
        }

        //? -- ROUNDED CORNERS -- ?//
        if ($this->get_option_or_default('mdp_rounded_corners') != 'on') {
            wp_enqueue_style('rounded-corners', plugins_url('styles/options/no_rounded_corners.css', __FILE__));
        } else {
            wp_dequeue_style('rounded-corners');
        }

        //? -- LARGE ADMIN BAR -- ?//
        if ($this->get_option_or_default('mdp_large_admin_bar') == 'on' and is_admin()) {
            wp_enqueue_style('large_admin_bar', plugins_url('styles/options/large_app_bar.css', __FILE__));
            wp_enqueue_script('large_admin_bar_script', plugins_url('styles/options/large_app_bar.js', __FILE__));
            if ($this->get_option_or_default('mdp_large_admin_bar_variant') == '1') {
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
    }

    /** Plugin Options **/
    function mdp_plugin_options()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        echo $this->get_local_file_contents('settings/index.php');
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

    function get_local_file_contents($file_path)
    {
        ob_start();
        include $file_path;
        $contents = ob_get_clean();

        return $contents;
    }
}

$materialDashboardPlugin = new MaterialDashboardPlugin();
