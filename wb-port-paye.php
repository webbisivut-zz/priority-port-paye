<?php
/*
 * Plugin Name: Priority Port Paye
 * Version: 1.0
 * Description: Posti Priority Port Paye Labels.
 * Requires at least: 4.0
 * Tested up to: 4.4.1
 *
 * @package WordPress
 * @author Webbisivut.org
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

	// Include plugin class files
	require_once( 'class-wb-prinetti-priority-port-paye.php' );

	}
?>