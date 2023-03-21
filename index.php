<?php

/*
Plugin Name: Material Design Dashboard
Plugin URI: 	https://fatih.bal.soy/projects/wp-material-design
Description: 	Material Dashboard is a WordPress plugin that replaces your site's dashboard design with a more modern look by using Google's Material Design Guidelines. This plugin respects your dashboard layout, does not make any drastic changes, and does not add plugin branding, it is completely free and simple to use.
Author: 	    Fatih Balsoy
Version: 	    0.1.0-alpha
Author URI: 	https://fatih.bal.soy
License:       	AGPL-3.0+
License URI:   	https://www.gnu.org/licenses/agpl-3.0.txt
*/

$fb_mdp_plugin_version = "0.1.0-alpha";
$fb_mdp_plugin_author = "Fatih Balsoy";
$fb_mdp_plugin_author_website = "https://fatih.bal.soy";
$fb_mdp_plugin_website = "https://fatih.bal.soy/projects/wp-material-design";
$fb_mdp_plugin_report_bugs = "https://github.com/fatihbalsoy/wp-material-design/issues/new";
$fb_mdp_plugin_name = "Material Design Dashboard";
$fb_mdp_plugin_settings_title = $fb_mdp_plugin_name;

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

class MaterialDashboardPlugin
{
    public string $settings_slug;

    function __construct()
    {
        $this->settings_slug = 'material-dashboard-settings';

        add_action('wp_enqueue_scripts', array($this, 'mdp_admin_user_theme_style'));
        add_action('admin_enqueue_scripts', array($this, 'mdp_admin_theme_style'));
        add_action('login_enqueue_scripts', array($this, 'mdp_login_theme_style'));
        add_action('admin_menu', array($this, 'mdp_plugin_menu'));
        add_action('admin_init', array($this, 'settings'));
    }

    /** User-facing Admin Theme (Admin Bar) **/
    function mdp_admin_user_theme_style()
    {
        wp_enqueue_style('mdp-user-theme', plugins_url('wp.css', __FILE__));

        $this->load_plugin_options();
    }

    /** Admin Dashboard Theme **/
    function mdp_admin_theme_style()
    {
        wp_enqueue_script('theme-script', plugins_url('script.js', __FILE__), array('jquery'));
        wp_enqueue_style('mdp-admin-theme', plugins_url('wp-admin.css', __FILE__));

        $this->load_plugin_options();
    }

    /** Login Theme **/
    function mdp_login_theme_style()
    {
        wp_enqueue_style('mdp-login-theme', plugins_url('wp-login.css', __FILE__));

        $this->load_plugin_options();
    }

    /** Plugin Menu **/
    function mdp_plugin_menu()
    {
        add_theme_page($GLOBALS["fb_mdp_plugin_name"], $GLOBALS["fb_mdp_plugin_name"], 'manage_options', $this->settings_slug, array($this, 'mdp_plugin_options'));
    }

    /** Load Plugin Options **/
    function load_plugin_options()
    {

        //? -- COLORS -- ?//
        $color_stylesheet = $this->get_local_file_contents("theme.not.css");
        $color_stylesheet_with_primary = str_replace("\"primary-color\"", get_option('mdp_colors_primary'), $color_stylesheet);
        $color_stylesheet_with_primary_and_accent = str_replace("\"accent-color\"", get_option('mdp_colors_accent'), $color_stylesheet_with_primary);
        wp_add_inline_style('mdp-admin-theme', $color_stylesheet_with_primary_and_accent);
        wp_add_inline_style('mdp-user-theme', $color_stylesheet_with_primary_and_accent);
        wp_add_inline_style('mdp-login-theme', $color_stylesheet_with_primary_and_accent);

        //? -- DARK MODE -- ?//
        function enqueue_dark_theme()
        {
            wp_enqueue_style('dark-admin-theme', plugins_url('assets/dark-theme/dark-theme.css', __FILE__));
        }

        // Explicit Dark Mode
        if (get_option('mdp_theme') == 'dark') {
            enqueue_dark_theme();
        }
        // Automatic Dark Mode
        else if (get_option('mdp_theme') == 'auto') {
            // print_r($_COOKIE);
            if ($_COOKIE['system_theme'] == 'dark') {
                enqueue_dark_theme();
            }
        }

        //? -- FONT -- ?//
        switch (get_option('mdp_font')) {
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
    }

    /** Plugin Options **/
    function mdp_plugin_options()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        echo $this->get_local_file_contents('settings/index.php');
    }

    function settings()
    {
        /** Theme **/
        register_setting('material_dashboard_plugin', 'mdp_theme', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'light'));

        /** Colors **/
        // - Primary
        register_setting('material_dashboard_plugin', 'mdp_colors_primary', array('sanitize_callback' => 'sanitize_text_field', 'default' => '#0288D1'));
        // - Accent
        register_setting('material_dashboard_plugin', 'mdp_colors_accent', array('sanitize_callback' => 'sanitize_text_field', 'default' => '#C62828'));

        /** Font **/
        register_setting('material_dashboard_plugin', 'mdp_font', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'mona-sans'));

        /** Icons **/
        register_setting('material_dashboard_plugin', 'mdp_icons', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'md-icons'));

        /** Toolbar **/
        // - Divi Theme Fix
        register_setting('material_dashboard_plugin', 'mdp_toolbar_divi_fix', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'on'));
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