<?php
/**
 * Plugin Name: Responsive Accordion And Collapse
 * Version: 1.8.7
 * Description: Responsive Accordion is the most easiest drag & drop accordion builder for WordPress. You can generate multiple accordion and collapse with multiple colour.
 * Author: wpshopmart
 * Author URI: http://www.wpshopmart.com
 * Plugin URI: http://www.wpshopmart.com
 *
 */

/**
 * DEFINE PATHS
 */
define("wpshopmart_accordion_directory_url", plugin_dir_url(__FILE__));
define("wpshopmart_accordion_text_domain", "wpsm_accordion");

/**
 * PLUGIN Install
 */
require_once("lib/installation/installation.php");

add_action('admin_menu' , 'wpsm_ac_help_page_manu');
function wpsm_ac_help_page_manu() {
	$submenu = add_submenu_page('edit.php?post_type=responsive_accordion', __('More_Free_Plugins', wpshopmart_accordion_text_domain), __('More Free Plugins', wpshopmart_accordion_text_domain), 'administrator', 'wpsm_ac_help_page', 'wpsm_ac_help_page_funct');
	
	//add hook to add styles and scripts for Responsive Accordion plugin admin page
    add_action( 'admin_print_styles-' . $submenu, 'wpsm_ac_help_js_css' );
	}
	function wpsm_ac_help_js_css(){
		wp_enqueue_style('wpsm_ac_bootstrap_css', wpshopmart_accordion_directory_url.'css/bootstrap.css');
		wp_enqueue_style('wpsm_ac_help_css', wpshopmart_accordion_directory_url.'css/help.css');
	}
function wpsm_ac_help_page_funct(){
	require_once('lib/help.php');
}
 
/**
 * CPT CLASS
 */
require_once("lib/admin/menu.php");
/**
 * SHORTCODE
 */
require_once("front/shortcode.php"); 
 
?>