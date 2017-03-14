<?php
/*
Plugin Name: LearnPress Courses Wishlist
Plugin URI: http://thimpress.com/learnpress
Description: Wishlist feature
Author: ThimPress
Version: 2.0
Author URI: http://thimpress.com
Tags: learnpress
Text Domain: learnpress-wishlist
Domain Path: /languages/
*/
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'LP_ADDON_WISHLIST_FILE', __FILE__ );
define( 'LP_ADDON_WISHLIST_PATH', dirname( __FILE__ ) );
define( 'WISHLIST_TMPL', LP_ADDON_WISHLIST_PATH . '/templates/' );

// include class
require_once( LP_ADDON_WISHLIST_PATH . '/incs/class-lp-addon-wishlist.php' );