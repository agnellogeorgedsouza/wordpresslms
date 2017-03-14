<?php

/**
 * Plugin Name: Wordpress Branding
 * Plugin URI: Nivijah.com
 * Description: WP Branding let's you tweak all sort of stuff in WordPress admin side so it fits your brand better.
 * Version: 1.0.3
 * Author: nivijah
 * Author URI: NiviJah.com
 * License: GPL2
 */

$plugin_path = plugin_dir_path(__FILE__);
$plugin_url = plugin_dir_url(__FILE__);

/**
 * Include Vafpress Framework
 */
require_once $plugin_path . 'framework/bootstrap.php';

// options
$tmpl_opt = $plugin_path . '/admin/option/option.php';

/**
 * Create instance of Options
 */
$theme_options = new VP_Option(array('is_dev_mode' => false, 'option_key' => 'agnet_branding', 'page_slug' => 'agnet_branding', 'template' => $tmpl_opt, 'menu_page' => 'options-general.php', 'use_auto_group_naming' => true, 'use_util_menu' => true, 'minimum_role' => 'edit_theme_options', 'layout' => 'fixed', 'page_title' => __('WP Branding', 'wp_branding_textdomain'), 'menu_label' => __('WP Branding', 'wp_branding_textdomain'),));

//-------------------------------------------------------

// ADD "Settings" link under the plugin name
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'wp_branding_add_action_links');
function wp_branding_add_action_links($links) {
    $nivijah_plugin_links = array('<a href="' . admin_url('options-general.php?page=agnet_branding') . '">Settings</a>',);
    return array_merge($links, $nivijah_plugin_links);
}

// ADD STYLESHEET TO LOGIN PAGE
function wp_branding_add_login_stylesheet() {
    
    wp_enqueue_style('custom-login', plugins_url('css/login-styles.css', __FILE__));
}
add_action('login_enqueue_scripts', 'wp_branding_add_login_stylesheet');

// ADD CUSTOM STYLESHEET TO ADMIN AREA
function wp_branding_custom_admin_styles() {
?>

    <?php
    $menu_bg = vp_option('agnet_branding.menu_bg');
    $text_color = vp_option('agnet_branding.text_color');
?>

    <style type="text/css">
    
    #adminmenu .wp-has-current-submenu .wp-submenu .wp-submenu-head, #adminmenu .wp-menu-arrow, #adminmenu .wp-menu-arrow div, #adminmenu li.current a.menu-top, #adminmenu li.wp-has-current-submenu a.wp-has-current-submenu, .folded #adminmenu li.current.menu-top, .folded #adminmenu li.wp-has-current-submenu {
        background: <?php
    echo $menu_bg; ?>;
        color: #fff;
    }

    #adminmenu .wp-submenu a:focus, #adminmenu .wp-submenu a:hover, #adminmenu a:hover, #adminmenu li.menu-top>a:focus{
        color: <?php
    echo $text_color; ?> ;
    }
    #adminmenu li:hover div.wp-menu-image:before {
        color: <?php
    echo $text_color; ?> ;
    }
    #wpadminbar .ab-top-menu>li.hover>.ab-item, #wpadminbar .ab-top-menu>li:hover>.ab-item, #wpadminbar .ab-top-menu>li>.ab-item:focus, #wpadminbar.nojq .quicklinks .ab-top-menu>li>.ab-item:focus{
        background: #333;
        color: <?php
    echo $text_color; ?>;

    }
    #wpadminbar>#wp-toolbar a:focus span.ab-label, #wpadminbar>#wp-toolbar li.hover span.ab-label, #wpadminbar>#wp-toolbar li:hover span.ab-label {
        color: <?php
    echo $text_color; ?>;
    }
    #wpadminbar .quicklinks .menupop ul li a:focus, #wpadminbar .quicklinks .menupop ul li a:focus strong, #wpadminbar .quicklinks .menupop ul li a:hover, #wpadminbar .quicklinks .menupop ul li a:hover strong, #wpadminbar .quicklinks .menupop.hover ul li a:focus, #wpadminbar .quicklinks .menupop.hover ul li a:hover, #wpadminbar li .ab-item:focus:before, #wpadminbar li a:focus .ab-icon:before, #wpadminbar li.hover .ab-icon:before, #wpadminbar li.hover .ab-item:before, #wpadminbar li:hover #adminbarsearch:before, #wpadminbar li:hover .ab-icon:before, #wpadminbar li:hover .ab-item:before, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:focus, #wpadminbar.nojs .quicklinks .menupop:hover ul li a:hover {
        color: <?php
    echo $text_color; ?>;
    }
    .dash-logo{
        display: block;
        width: 90%;
    }
    
    </style>

    <?php
}
add_action('admin_head', 'wp_branding_custom_admin_styles');

function remove_wordpress_logo() {
?>
   <style>
    #wp-admin-bar-wp-logo {
    display: none;
    }
    </style>
 <?php
}

if (vp_option('agnet_branding.remove_wp_logo')):
    add_action('admin_head', 'remove_wordpress_logo');
endif;

// CHANGE THE LOGO
function wp_branding_my_login_logo() {
    $image = vp_option('agnet_branding.logo_upload_new');
    $form_position = vp_option('agnet_branding.login_form_position');
?>

        <style type="text/css">
        body.login div#login h1 a {
            background-image: url( <?php
    echo $image; ?> );
            background-size: 320px 115px;
        }
        </style>

        <?php
    if ($form_position == 'login_form_position_left'): ?>
         <style type="text/css">
         #login {margin-left: 50px;} 
         </style>
         <?php
    elseif ($form_position == 'login_form_position_right'): ?>
         <style type="text/css">
         #login {margin-right: 50px;} 
         </style>
     <?php
    endif; ?>


<?php
}

add_action('login_enqueue_scripts', 'wp_branding_my_login_logo');

// Background Image
function wp_branding_bg_login() {
    $bg = vp_option('agnet_branding.bg_login_new');
?>
            <style type="text/css">
            body.login {
                background-image: url(<?php
    echo $bg; ?>);
            }
            </style>
            <?php
}
add_action('login_enqueue_scripts', 'wp_branding_bg_login');

// CHANGE URL OF LOGO
function wp_branding_my_login_logo_url() {
    $logo_url = vp_option('agnet_branding.logo_url');
    return $logo_url;
}
add_filter('login_headerurl', 'wp_branding_my_login_logo_url');

// CHANGE LOGO IMG ALT
function wp_branding_my_login_logo_url_title() {
    $logo_alt = vp_option('agnet_branding.logo_url_alt');
    return $logo_alt;
}
add_filter('login_headertitle', 'wp_branding_my_login_logo_url_title');

//CHANGE THE DEFAULT FOOTER TEXT IN ADMIN
function wp_branding_admin_footer_text() {
    $admin_footer_text = vp_option('agnet_branding.admin_footer_text');
    
    echo $admin_footer_text;
}
add_filter('admin_footer_text', 'wp_branding_admin_footer_text');

$remove_metaboxes = vp_option('agnet_branding.remove_meta');
if ($remove_metaboxes == true) {
    
    function wp_branding_tidy_dashboard() {
        global $wp_meta_boxes, $current_user;
        
        // remove incoming links info for authors or editors
        if (in_array('author', $current_user->roles) || in_array('editor', $current_user->roles)) {
            unset($wp_meta_boxes['dashboard']['normal ']['core']['dashboard_incoming_links']);
        }
        
        //Right Now - Comments, Posts, Pages at a glance
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
        
        //Recent Comments
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
        
        //Incoming Links
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
        
        //Plugins - Popular, New and Recently updated Wordpress Plugins
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['icl_dashboard_widget']);
        
        //Wordpress Development Blog Feed
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
        
        //Other Wordpress News Feed
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
        
        //Quick Press Form
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
        
        //Recent Drafts List
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
    }
    
    //add our function to the dashboard setup hook
    add_action('wp_dashboard_setup', 'wp_branding_tidy_dashboard');
}

// add new dashboard widgets
function agenti_add_dashboard_widgets() {
    $custom_title = vp_option('agnet_branding.meta_box_title');
    wp_add_dashboard_widget('agenti_dashboard_welcome', $custom_title, 'agenti_add_welcome_widget');
}

// ADD CONTENT TO THE NEW DASHBOAD WIDGET

function agenti_add_welcome_widget() {
    
    $custom_meta_box = vp_option('agnet_branding.custom_meta_box');
    
    echo $custom_meta_box;
}

if (vp_option('agnet_branding.custom_meta_box')) {
    add_action('wp_dashboard_setup', 'agenti_add_dashboard_widgets');
}

// ADD A "CREATE PAGE" WIDGET/SHORTCUT
$add_shortcuts = vp_option('agnet_branding.add_meta_page_creation');
if ($add_shortcuts == true) {
    function dashboard_widget_function($post, $callback_args) {
        
        $args = array('public' => true, '_builtin' => false);
        
        $output = 'names';
        
        // names or objects, note names is the default
        $operator = 'and';
        
        // 'and' or 'or'
        $base_url = admin_url();
        
        $post_types = get_post_types($args, $output, $operator);
        
        foreach ($post_types as $post_type) { ?>

    <a href="<?php
            echo $base_url; ?>post-new.php?post_type=<?php
            echo $post_type; ?>">
<button class="wp-core-ui button-primary">
    Add <?php
            echo $post_type; ?>
</button>
    </a>
    
<?php
        } ?>

    <a href="<?php
        echo $base_url; ?>post-new.php?post_type=page">
<button class="wp-core-ui button-primary">
    Add Page
</button>
    </a>

<?php
    }
    
    function wp_branding_add_dashboard_widgets() {
        wp_add_dashboard_widget('dashboard_widget', 'Quick Post', 'dashboard_widget_function');
    }
    
    // Register the new dashboard widget with the 'wp_dashboard_setup' action
    add_action('wp_dashboard_setup', 'wp_branding_add_dashboard_widgets');
}

// ADD SVG SUPPORT
function wp_branding_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
if (vp_option('agnet_branding.add_svg_support')) {
    add_filter('upload_mimes', 'wp_branding_mime_types');
}

//REMOVE ADMIN BAR FROM FRONT
if (vp_option('agnet_branding.remove_admin_bar')) {
    add_filter('show_admin_bar', '__return_false');
}

if (vp_option('agnet_branding.use_slate')) {
    include_once $plugin_path . 'css/slate-admin-theme/slate-admin-theme.php';
    remove_action('admin_head', 'wp_branding_custom_admin_styles');
}

/*  Browser detection body_class() output
/* ------------------------------------ */
function wp_branding_browser_body_class($classes) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    
    if ($is_lynx) $classes[] = 'lynx';
    elseif ($is_gecko) $classes[] = 'gecko';
    elseif ($is_opera) $classes[] = 'opera';
    elseif ($is_NS4) $classes[] = 'ns4';
    elseif ($is_safari) $classes[] = 'safari';
    elseif ($is_chrome) $classes[] = 'chrome';
    elseif ($is_IE) {
        $browser = $_SERVER['HTTP_USER_AGENT'];
        $browser = substr("$browser", 25, 8);
        if ($browser == "MSIE 7.0") {
            $classes[] = 'ie7';
            $classes[] = 'ie';
        } 
        elseif ($browser == "MSIE 6.0") {
            $classes[] = 'ie6';
            $classes[] = 'ie';
        } 
        elseif ($browser == "MSIE 8.0") {
            $classes[] = 'ie8';
            $classes[] = 'ie';
        } 
        elseif ($browser == "MSIE 9.0") {
            $classes[] = 'ie9';
            $classes[] = 'ie';
        } 
        else {
            $classes[] = 'ie';
        }
    } 
    else $classes[] = 'unknown';
    
    if ($is_iphone) $classes[] = 'iphone';
    
    return $classes;
}
if (vp_option('agnet_branding.enable_perfect_body_class')) {
    add_filter('body_class', 'wp_branding_browser_body_class');
}

function wp_branding_hide_update_notice_to_all_but_admin_users() {
    if (!current_user_can('update_core')) {
        remove_action('admin_notices', 'update_nag', 3);
    }
}

if (vp_option('agnet_branding.remove_nagging')) {
    add_action('admin_head', 'wp_branding_hide_update_notice_to_all_but_admin_users', 1);
}

function wp_branding_revealid_add_id_column($columns) {
    $columns['revealid_id'] = 'ID';
    return $columns;
}
function wp_branding_revealid_id_column_content($column, $id) {
    if ('revealid_id' == $column) {
        echo $id;
    }
}

if (vp_option('agnet_branding.add_posts_ids')) {
    add_filter('manage_posts_columns', 'wp_branding_revealid_add_id_column', 5);
    add_action('manage_posts_custom_column', 'wp_branding_revealid_id_column_content', 5, 2);
    add_filter('manage_pages_columns', 'wp_branding_revealid_add_id_column', 5);
    add_action('manage_pages_custom_column', 'wp_branding_revealid_id_column_content', 5, 2);
}

// add google font
$font_face = vp_option('agnet_branding.logo_font_face');
$font_weight = vp_option('agnet_branding.vp_get_gwf_weight');
$font_style = vp_option('agnet_branding.logo_font_style');
VP_Site_GoogleWebFont::instance()->add($font_face, $font_weight, $font_style);

function wp_branding_embed_google_font() {
    VP_Site_GoogleWebFont::instance()->register();
    wp_register_style('custom-goole-font', '/css/googlefont.css', VP_Site_GoogleWebFont::instance()->get_names());
    wp_enqueue_style('custom-goole-font');
}
add_action('admin_head', 'wp_branding_embed_google_font');

function wp_branding_use_google_font() {
    $font_face = vp_option('agnet_branding.logo_font_face');
    $font_weight = vp_option('agnet_branding.vp_get_gwf_weight');
    $font_style = vp_option('agnet_branding.logo_font_style');
    
    $gwf = new VP_Site_GoogleWebFont();
    $gwf->add($font_face, $font_style, $font_weight);
    $links = $gwf->get_font_links();
    $link = reset($links);
?>
    <style type="text/css">
    body {
        font-family: <?php
    echo $font_face; ?> !important;
        font-style: <?php
    echo $font_style; ?> !important;
        font-weight: <?php
    echo $font_weight; ?> !important;
    }
    </style>
    

<?php
}

add_action('admin_head', 'wp_branding_use_google_font');

function wp_branding_remove_version() {
    remove_filter('update_footer', 'core_update_footer');
}

if (vp_option('agnet_branding.remove_version')) {
    add_filter('admin_menu', 'wp_branding_remove_version');
}

function wp_branding_use_custom_css() {
    $admin_head_css = vp_option('agnet_branding.admin_head_css');
?>
    <style type="text/css">
        <?php
    echo $admin_head_css; ?> 
    </style>
    
<?php
}
add_action('admin_head', 'wp_branding_use_custom_css');

