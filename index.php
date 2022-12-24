<?php

/*
Plugin Name: Material Design Dashboard
Plugin URI: 	https://fatih.bal.soy/projects/wp-material-design
Description: 	Material Dashboard is a WordPress plugin that replaces your site's dashboard design with a more modern look by using Google's Material Design Guidelines. This plugin respects your dashboard layout, does not make any drastic changes, and does not add plugin branding, it is completely free and simple to use.
Author: 	    Fatih Balsoy
Version: 	    1.0
Author URI: 	https://fatih.bal.soy
License:       	AGPL-3.0+
License URI:   	https://www.gnu.org/licenses/agpl-3.0.txt
*/

// If this file is called directly, abort.
if (!defined('ABSPATH'))
    exit;

class MaterialDashboardPlugin
{
    public string $settings_slug;

    function __construct()
    {
        $this->settings_slug = 'material-dashboard-settings';

        add_action('admin_enqueue_scripts', array($this, 'my_admin_theme_style'));
        add_action('login_enqueue_scripts', array($this, 'my_login_theme_style'));
        add_action('admin_menu', array($this, 'my_plugin_menu'));
        add_action('admin_init', array($this, 'settings'));
    }

    /** Admin Dashboard Theme **/
    function my_admin_theme_style()
    {
        wp_enqueue_style('my-admin-theme', plugins_url('wp-admin.css', __FILE__));
        wp_enqueue_style('dark-admin-theme', plugins_url('assets/dark-theme/blank.css', __FILE__));
        wp_enqueue_script('theme-script', plugins_url('assets/properties.js', __FILE__), array('jquery'));
    }

    /** Login Theme **/
    function my_login_theme_style()
    {
        wp_enqueue_style('my-login-theme', plugins_url('wp-login.css', __FILE__));
    }

    /** Plugin Menu **/
    function my_plugin_menu()
    {
        add_theme_page('Material Design Dashboard', 'Material Design Dashboard', 'manage_options', $this->settings_slug, array($this, 'my_plugin_options'));
    }

    /** Plugin Options **/
    function my_plugin_options()
    {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        echo $this->get_local_file_contents('settings/index.php');
    }

    function settings()
    {
        add_settings_section('mdp_appearance', 'Appearance', null, $this->settings_slug);

        /** Theme **/
        add_settings_field('mdp_theme', 'Theme', array($this, 'theme_HTML'), $this->settings_slug, 'mdp_appearance');
        register_setting('material_dashboard_plugin', 'mdp_theme', array('sanitize_callback' => 'sanitize_text_field', 'default' => 'light'));

        /** Colors **/
        add_settings_section('mdp_colors', 'Colors', null, $this->settings_slug);

        add_settings_field('mdp_colors_primary', 'Primary', array($this, 'primaryColor_HTML'), $this->settings_slug, 'mdp_colors');
        register_setting('material_dashboard_plugin', 'mdp_colors_primary', array('sanitize_callback' => 'sanitize_text_field', 'default' => '#0288D1'));

        add_settings_field('mdp_colors_accent', 'Accent', array($this, 'accentColor_HTML'), $this->settings_slug, 'mdp_colors');
        register_setting('material_dashboard_plugin', 'mdp_colors_accent', array('sanitize_callback' => 'sanitize_text_field', 'default' => '#C62828'));
    }

    function theme_HTML()
    {
        echo $this->get_local_file_contents('settings/options/theme.php');
    }

    function primaryColor_HTML()
    {
        echo $this->get_local_file_contents('settings/options/color_primary.php');
    }
    function accentColor_HTML()
    {
        echo $this->get_local_file_contents('settings/options/color_accent.php');
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
