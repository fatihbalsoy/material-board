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
if ( ! defined( 'ABSPATH' ) ) exit;

function my_admin_theme_style() {
    wp_enqueue_style('my-admin-theme', plugins_url('wp-admin.css', __FILE__));
    wp_enqueue_style('dark-admin-theme', plugins_url('assets/dark-theme/blank.css', __FILE__));
    wp_enqueue_script( 'theme-script', plugins_url('assets/properties.js', __FILE__), array( 'jquery' ));
}
function my_login_theme_style() {
    wp_enqueue_style('my-login-theme', plugins_url('wp-login.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'my_admin_theme_style');
add_action('login_enqueue_scripts', 'my_login_theme_style');

/** Step 2 (from text above). */
add_action( 'admin_menu', 'my_plugin_menu' );

/** Step 1. */
function my_plugin_menu() {
	add_theme_page( 'Material Design Dashboard', 'Material Design Dashboard', 'manage_options', 'bits-material-design-admin-theme-settings', 'my_plugin_options' );
}

/** Step 3. */
function my_plugin_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
 	echo get_local_file_contents('settings/index.html');
}

function get_local_file_contents( $file_path ) {
    ob_start();
    include $file_path;
    $contents = ob_get_clean();

    return $contents;
}
?>
