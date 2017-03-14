<?php
/* 
 *Plugin Name: Login Page Styler
 *Plugin URI:http://web-settler.com/login-page-styler/
 *Description: This plugin allows you to customize the appearance of the WordPress Login Screen as you like to see.
 *Version: 3.1.5
 *Author: Zia Imtiaz
 *Author URI:http://web-settler.com/login-page-styler/
 *License: GPLv2
 */


function lps_login_template_design(){
    if(get_option('lps_layout') == 'lay1'){
    include("template/template1.php");
}


}

if(get_option('lps_layout') !== ''){
function login_function() {
    add_filter( 'gettext', 'username_change', 20, 3 );
    function username_change( $translated_text, $text, $domain ) 
    {
        if ($text === 'Username or Email') 
        {
            $translated_text = 'Username';
        }
        return $translated_text;
    }
}
add_action( 'login_head', 'login_function' );
}

function lps_login_background_color(){
    
    echo '<style>body { height:100%; background-color: ' . get_option( 'lps_login_background_color' ) . '!important; } </style>';
}


function lps_login_label_color(){

	echo '<style> .login label{ color: ' . get_option( 'lps_login_label_color' ) . '!important; opacity:'.get_option('lps_label_color_opacity').'!important; } </style>';
}


function lps_login_form_input_color_opacity(){

	echo '<style> .login form .input{background: rgba('.get_option('lps_login_form_input_color_opacity').')!important;}</style>';
}

function lps_login_nav_color(){

	echo '<style> .login #login a{ color : '.get_option('lps_login_nav_color' ).'!important;}</style>';
}

function lps_login_nav_hover_color(){

	echo '<style> .login #login a:hover{ color : '.get_option('lps_login_nav_hover_color' ).'!important;}</style>';
}

function lps_login_form_border_radius(){

	echo '<style> .login form{ border-radius:'.get_option('lps_login_form_border_radius' ).'px !important;}</style>';
}

function lps_login_label_size(){

	echo '<style> .login label { font-size:' .get_option('lps_login_label_size').'px !important;}</style>';
}


function lps_login_remember_label_size(){

	echo '<style>  .login form .forgetmenot label {font-size:'.get_option('lps_login_remember_label_size').'px !important ;} </style>';
}


function lps_login_nav_link_hide(){

	if (get_option('lps_login_nav_link_hide') == 1)
	{ 

		echo '<style> .login #nav {display:none !important;}</style>';
	}
	else
	{
	    echo '<style> .login #nav {display:block !important;}</style>';
	}
}


function lps_login_logo_hide(){

	if (get_option('lps_login_logo_hide') == 1)
	{ 

		echo '<style> .login h1 a {display:none !important;}</style>';
	}
	else
	{
	    echo '<style> .login h1 a {display:block !important;}</style>';
	}
}

function lps_login_form_position(){

	if(get_option('lps_login_form_position') == 1)
	{
		echo '<style>div#login { top: 0; right:0; bottom: 0; left: 0; padding: 10% 0 0 0 !important; }</style>';
	}

	if(get_option('lps_login_form_position') == 2)
	{
		echo '<style>div#login { top: 0; right:auto; bottom: 0; left: 0; padding: 10% 70% 0 0 !important; }</style>';
	}
	if(get_option('lps_login_form_position') == 3)
	{
		echo '<style>div#login { top: 0; right:0; bottom: 0; left: auto; padding: 10% 0 0 70% !important; }</style>';
	}
	if(get_option('lps_login_form_position') == 4)
	{
		echo '<style>div#login { top:0; right:auto; bottom: auto; left: auto; padding: 1% 0 0 0 !important; }</style>';
	}

	if(get_option('lps_login_form_position') == 5)
	{
		echo '<style>div#login { top: 0; right:auto; bottom: 0; left: 0; padding: 1% 70% 0 0 !important; }</style>';
	}
	if(get_option('lps_login_form_position') == 6)
	{
		echo '<style>div#login { top: 0; right:0; bottom: 0; left:0; padding: 1% 0 0 70% !important; overflow:hidden; }</style>';
	}
	
	if(get_option('lps_login_form_position') == 7 && get_option('lps_login_blog_link_hide')== 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') == 1 )
	{
		echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 36% 0 0 0 !important; }</style>';
	}

	if(get_option('lps_login_form_position') == 7 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') != 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 23.5% 0 0 0 !important; }</style>';
    }

    if(get_option('lps_login_form_position') == 7 && get_option('lps_login_blog_link_hide') == 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') == 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 36% 0 0 0 !important; }</style>';
    }


    if(get_option('lps_login_form_position') == 7 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') == 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 32% 0 0 0 !important; }</style>';
    }


    if(get_option('lps_login_form_position') == 7 && get_option('lps_login_blog_link_hide') == 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') !=1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 26% 0 0 0 !important; }</style>';
    }


    if(get_option('lps_login_form_position') == 7 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') !=1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 26% 0 0 0 !important; }</style>';
    }



    if(get_option('lps_login_form_position') == 7 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') == 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 30% 0 0 0 !important; }</style>';
    }


    if(get_option('lps_login_form_position') == 7 && get_option('lps_login_blog_link_hide') == 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') != 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 29% 0 0 0 !important; }</style>';
    }


/*
    if(get_option('lps_login_form_position') == 8 && get_option('lps_login_blog_link_hide')== 1 && get_option('lps_login_nav_link_hide') == 1 )
	{
		echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 29% 70% 0 0; }</style>';
	}
*/	

	if(get_option('lps_login_form_position') == 8 && get_option('lps_login_blog_link_hide')== 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') == 1 )
	{
		echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 36% 70% 0 0; }</style>';
	}

	if(get_option('lps_login_form_position') == 8 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') != 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 23.5% 70% 0 0; }</style>';
    }

    if(get_option('lps_login_form_position') == 8 && get_option('lps_login_blog_link_hide') == 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') == 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 36% 70% 0 0; }</style>';
    }


    if(get_option('lps_login_form_position') == 8 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') == 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 32% 70% 0 0; }</style>';
    }


    if(get_option('lps_login_form_position') == 8 && get_option('lps_login_blog_link_hide') == 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') !=1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 26% 70% 0 0; }</style>';
    }


    if(get_option('lps_login_form_position') == 8 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') !=1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 26% 70% 0 0; }</style>';
    }



    if(get_option('lps_login_form_position') == 8 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') == 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 30% 70% 0 0; }</style>';
    }


    if(get_option('lps_login_form_position') == 8 && get_option('lps_login_blog_link_hide') == 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') != 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 29% 70% 0 0; }</style>';

	} 



	if(get_option('lps_login_form_position') == 9 && get_option('lps_login_blog_link_hide')== 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') == 1 )
	{
		echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 36% 0 0 70%; }</style>';
	}

	if(get_option('lps_login_form_position') == 9 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') != 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 23.5% 0 0 70%; }</style>';
    }

    if(get_option('lps_login_form_position') == 9 && get_option('lps_login_blog_link_hide') == 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') == 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 36% 0 0 70%; }</style>';
    }


    if(get_option('lps_login_form_position') == 9 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') == 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 32% 0 0 70%; }</style>';
    }


    if(get_option('lps_login_form_position') == 9 && get_option('lps_login_blog_link_hide') == 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') !=1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 26% 0 0 70%; }</style>';
    }


    if(get_option('lps_login_form_position') == 9 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') !=1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 26% 0 0 70%; }</style>';
    }



    if(get_option('lps_login_form_position') == 9 && get_option('lps_login_blog_link_hide') != 1 && get_option('lps_login_nav_link_hide') != 1 && get_option('lps_login_logo_hide') == 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 30% 0 0 70%; }</style>';
    }


    if(get_option('lps_login_form_position') == 9 && get_option('lps_login_blog_link_hide') == 1 && get_option('lps_login_nav_link_hide') == 1 && get_option('lps_login_logo_hide') != 1 )
	{
	
	    echo '<style>div#login { top: auto; right:auto; bottom:auto; left: autos; padding: 29% 0 0 70%; }</style>';

	}


	else
	{
		echo  '<style> div#login (padding:8% 0 0 0;)</style>';
	}
}

function lps_login_form_color(){
	
	echo '<style> .login form{background : '.get_option('lps_login_form_color') .' !important;  }</style>';
}

function lps_login_logo_msg_hide(){

	if(get_option('lps_login_logo_msg_hide')== 1)
	{
		echo '<style> #login_error,.login .message{display:none !important;}</style>';
	}
	else
	{
	   
		echo '<style> #login_error,.login .message{display:block !important ;}</style>';
	}
	
}

function lps_login_blog_link_hide(){

	if(get_option('lps_login_blog_link_hide') == 1)
	{
		echo '<style> .login #backtoblog{ display:none !important;}</style>';
	}
	else
	{
		echo '<style> .login #backtoblog{ display:block !important;}</style>';
	}
}

function lps_login_form_input_feild_border_radius(){

	echo '<style> .login form .input {border-radius:'.get_option('lps_login_form_input_feild_border_radius').'px !important;}</style>';
}


function lps_login_form_color_opacity(){

	echo '<style> .login form{ background: rgba('.get_option('lps_login_form_color_opacity').')!important;</style>';
}


function lps_login_custom_css(){

	echo '<style>' .get_option('lps_login_custom_css' ) . '</style>';
}



function lps_login_button_border_radius(){

	echo '<style> .login .button-primary{ border-radius:'.get_option('lps_login_button_border_radius').'px !important; } </style>';
}



function lps_login_form_input_feild_border_color(){

	echo '<style> .login form .input{border-color:'.get_option('lps_login_form_input_feild_border_color').'!important;}</style>';
}

function lps_login_logo_link(){

	return  get_option('lps_login_logo_link');
}


function lps_login_logo_tittle(){

	return get_option('lps_login_logo_tittle');
}


function lps_body_bg_img(){

	echo '<style> body{ background-image:url('.get_option('lps_body_bg_img').')!important;background-position: center top !important;
	background-repeat: '.get_option('lps_login_bg_repeat').'!important; display:block;   background-attachment: fixed !important; background-size:100% 100% !important; }</style>';
}


function lps_login_logo(){
	if(get_option('lps_login_logo') != '')
	{	
	   echo '<style> .login h1 a{ display:block !important; background-size:'.get_option('lps_login_logo_width').'px !important,'.get_option('lps_login_logo_height').'px !important;  background-image:url('.get_option('lps_login_logo').') !important;} </style>';
    }
    
}

function lps_login_logo_width(){

	if(get_option('lps_login_logo_width')!= '')
    {
	   echo '<style> .login h1 a{ width:'.get_option('lps_login_logo_width').'px !important;}</style>';
    }
}

function lps_login_logo_height(){
    if(get_option('lps_login_logo_height')!= '')
    {
	   echo '<style> .login h1 a{ height:'.get_option('lps_login_logo_height').'px !important;}</style>';
    }
}


function lps_login_button_color(){

	echo '<style> .login .button-primary{background-color:'.get_option('lps_login_button_color').'!important;

    border-color:'.get_option('lps_login_button_border_color').'!important; border:1px solid '.get_option('lps_login_button_border_color').'!important;

    color:'.get_option('lps_login_button_text_color').'!important;
 

    }</style>';
}


function lps_login_button_color_hover(){

	echo '<style> .login .button-primary:hover {background-color:'.get_option('lps_login_button_color_hover').'!important;

    border-color:'.get_option('lps_login_button_border_color_hover').'!important; border:1px solid '.get_option('lps_login_button_border_color_hover').'!important;

    color:'.get_option('lps_login_button_text_color_hover').'!important;

    }</style>';
}


function lps_login_form_border_style(){

	echo '<style> .login form{border-style:'.get_option('lps_login_form_border_style').'!important;
     border-width:'.get_option('lps_login_form_border_size').'px !important;
     border-color:'.get_option('lps_login_form_border_color').' !important;}</style>';
}


function lps_login_form_input_border_style(){

	echo '<style> .login form .input{border-style:'.get_option('lps_login_form_input_border_style').'!important;
	 border-width:'.get_option('lps_login_form_input_border_size').'px !important;}</style>';
}

function lps_login_form_bg(){

	
	echo '<style> .login form {background-image:url('.get_option('lps_login_form_bg').')!important; display:block !important;}</style>';
	
}

function lps_login_nav_size(){

	echo '<style> .login #nav,
.login #backtoblog{font-size:'.get_option('lps_login_nav_size').'px !important;}</style>';
}

function lps_font_label(){
	$font = str_replace(" ", "+", get_option('lps_gfontlab'));
	echo '<style> 

@import url(https://fonts.googleapis.com/css?family=' . $font . ' );

.login label {
font-family:'. get_option('lps_gfontlab').'!important;


	</style>';
}

add_action('login_head' , 'lps_font_label' );


function lps_font_btn(){

	
	echo '<style> 
.login .button-primary {
font-family:Arial;!important;
}
</style>';

}

add_action('login_head' , 'lps_font_btn' );


//if(get_option('lps_enable_private_site') == 1){
add_action('template_redirect', 'lps_redirect_to_login');
//}

function lps_redirect_to_login(){

 
 if(!is_user_logged_in() && is_page(get_option('lps_private_login_url')) && get_option('lps_private_login_url') != '' ){
   wp_redirect(home_url('/wp-login.php/?redirect_to =' . $_SERVER["REQUEST_URI"])); exit;
 }

 if(!is_user_logged_in() && is_page(get_option('lps_private_login_url2')) && get_option('lps_private_login_url2') != '' ){
   wp_redirect(home_url('/wp-login.php/?redirect_to =' . $_SERVER["REQUEST_URI"])); exit;
 }


}



function my_login_redirect( $redirect_to, $request, $user ) {
	//is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		//check for admins
		if ( in_array( 'administrator', $user->roles ) ) {
			// redirect them to the default place
			return admin_url();
		} 
		else {
			return home_url();
		}
	} else {
		return $redirect_to;
	}
}

//add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );



function lps_action_links( $links, $file ) {
	if ( $file == plugin_basename( dirname(__FILE__).'/loginPageStyler.php' ) ) {
		$links[] = '<a href="' . get_bloginfo('url') . '/wp-admin/admin.php?page=lps_option">Settings</a>';;
	}
	return $links;
}


if (get_option('lps_login_on_off')==1) {
	require 'lpsReCaptcha.php';
}



function lps_loginLockdown_install() {
	global $wpdb;
	
	$table_name = $wpdb->prefix . "lps_login_fails";

	if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {
		$sql = "CREATE TABLE " . $table_name . " (
			`lpslogin_attempt_ID` bigint(20) NOT NULL AUTO_INCREMENT,
			`lpsuser_id` bigint(20) NOT NULL,
			`lpslogin_attempt_date` datetime NOT NULL default '0000-00-00 00:00:00',
			`lpslogin_attempt_IP` varchar(100) NOT NULL default '',
			PRIMARY KEY  (`lpslogin_attempt_ID`)
			);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}

	$table_name = $wpdb->prefix . "lps_lockdowns";

	if( $wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name ) {
		$sql = "CREATE TABLE " . $table_name . " (
			`lpslockdown_ID` bigint(20) NOT NULL AUTO_INCREMENT,
			`lpsuser_id` bigint(20) NOT NULL,
			`lpslockdown_date` datetime NOT NULL default '0000-00-00 00:00:00',
			`lpsrelease_date` datetime NOT NULL default '0000-00-00 00:00:00',
			`lpslockdown_IP` varchar(100) NOT NULL default '',
			PRIMARY KEY  (`lpslockdown_ID`)
			);";

		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		dbDelta($sql);
	}
}	
register_activation_hook(__FILE__,'lps_loginLockdown_install');




require('loginPageStylerOption.php'); 

require('loginPageStylerLim.php');

if (get_option('lps_login_on_off')==1) {
	require 'lpsFiltersAndActions.php';
	
}


 ?>