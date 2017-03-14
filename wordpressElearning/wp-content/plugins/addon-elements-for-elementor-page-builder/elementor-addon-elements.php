<?php
/**
 * Plugin Name: Elementor Addon Elements
 * Description: Add new elements to Elementor page builder plugin.
 * Plugin URI: http://www.webtechstreet.com/
 * Author: Webtechstreet.com
 * Version: 0.4
 * Author URI: http://www.webtchstreet.com/
 *
 * Text Domain: wts-eae
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

define( 'ELEMENTOR_ADDON_URL', plugins_url( '/', __FILE__ ) );
define( 'ELEMENTOR_ADDON_PATH', plugin_dir_path( __FILE__ ) );


require_once ELEMENTOR_ADDON_PATH.'inc/elementor-helper.php';

function add_new_elements(){


   require_once ELEMENTOR_ADDON_PATH.'inc/helper.php';

   // load elements
   require_once ELEMENTOR_ADDON_PATH.'elements/textseparator.php';
   require_once ELEMENTOR_ADDON_PATH.'elements/pricetable.php';
   require_once ELEMENTOR_ADDON_PATH.'elements/flipbox.php';
   require_once ELEMENTOR_ADDON_PATH.'elements/shape-separator.php';
   require_once ELEMENTOR_ADDON_PATH.'elements/post-list.php';
   require_once ELEMENTOR_ADDON_PATH.'elements/animated-text.php';
}
add_action('elementor/widgets/widgets_registered','add_new_elements');





function eae_scripts(){
   wp_enqueue_style('eae-css',ELEMENTOR_ADDON_URL.'assets/css/eae.css');

   /* animated text css and js file*/
   wp_enqueue_script('animated-main',ELEMENTOR_ADDON_URL.'assets/js/animated-main.js', array('jquery'),'1.0', true);
}
add_action( 'wp_enqueue_scripts', 'eae_scripts' );







