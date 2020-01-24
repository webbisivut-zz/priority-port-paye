<?php
/*
 * Plugin Name: Priority Port Paye
 * Version: 1.2
 * Description: Posti Priority Port Paye Labels.
 * Requires at least: 4.0
 * Tested up to: 5.9.3
 *
 * @package WordPress
 * @author Webbisivut.org
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	// Include plugin class files
	require_once( 'inc/class-wb-prinetti-priority-port-paye.php' );
	require_once( 'inc/class-wb-prinetti-priority-port-paye-settings.php' );

}

function load_custom_wp_admin_style(){
    wp_register_style( 'pp_priority_css', plugins_url().'/priority-port-paye/assets/css/backend.css', false, '1.0.0' );
    wp_enqueue_style( 'pp_priority_css' );
}
add_action('admin_enqueue_scripts', 'load_custom_wp_admin_style');
?>