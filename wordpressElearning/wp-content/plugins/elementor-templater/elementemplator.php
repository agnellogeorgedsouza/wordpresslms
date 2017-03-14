<?php
/*
 * Plugin Name: Elementor Templater: ElemenTemplator
 * Plugin URI: http://www.wpdevhq.com/plugins/elementor-templator
 * Description: A helper plugin for users of Elementor Pagebuilder. Adds 2 new templates for complete full width experience while using the page builder - support for a number of popular themes is built-in.
 * Version: 1.1.0
 * Author: WPDevHQ
 * Author URI: http://www.wpdevhq.com/
 * Requires at least:   4.4
 * Tested up to:        4.7.2
 */

/* Do not access this file directly */
if ( ! defined( 'WPINC' ) ) { die; }

/* Constants
------------------------------------------ */

/* Set plugin version constant. */
define( 'ET_VERSION', '1.1.0' );

/* Set constant path to the plugin directory. */
define( 'ET_PATH', trailingslashit( plugin_dir_path(__FILE__) ) );

/* Set the constant path to the plugin directory URI. */
define( 'ET_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

/* ElemenTemplater Class */
require_once( ET_PATH . 'elementemplater-class.php' );

/* Custom Post Template Class */
if ( version_compare( floatval($GLOBALS['wp_version']), '4.7', '<' ) ) { // 4.6.1 and older
	require_once( ET_PATH . 'custom-posttype-class.php' );
}

/* Template Functions */
require_once( ET_PATH . 'inc/elementemplater-functions.php' );