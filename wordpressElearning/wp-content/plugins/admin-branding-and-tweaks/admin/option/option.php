<?php

global $plugin_url;
global $plugin_path;

return array(
	'title' => __('Agent Branding Option Panel', 'wp_branding_textdomain'),
	'logo' => $plugin_url . 'img/wp_branding.png',
	'menus' => array(
		array(
			'title' => __('Login', 'wp_branding_textdomain'),
			'name' => 'submenu_1',
			'icon' => 'font-awesome:fa-unlock',
			'controls' => array(
				array(
					'type' => 'section',
					'title' => __('Login Section', 'wp_branding_textdomain'),
					'name' => 'section_1',
					'description' => __('Tweak the look and feel of the login screen', 'wp_branding_textdomain'),
					'fields' => array(
						array(
							'type' => 'upload',
							'name' => 'logo_upload_new',
							'label' => __('Login Logo', 'wp_branding_textdomain'),
							'description' => __('Upload a logo to use in the login screen, size should be 320px/115px', 'wp_branding_textdomain'),
							'default' => $plugin_url . 'img/wp_branding.png',
							),
						array(
							'type' => 'textbox',
							'name' => 'logo_url',
							'label' => __('Logo URL', 'wp_branding_textdomain'),
							'description' => __('Link of the logo in login screen', 'wp_branding_textdomain'),
							'default' => 'http://NiviJah.com',
							),
						array(
							'type' => 'textbox',
							'name' => 'logo_url_alt',
							'label' => __('Logo Alt', 'wp_branding_textdomain'),
							'description' => __('Alt text of the logo image', 'wp_branding_textdomain'),
							'default' => 'Awesome Site Made By Awesome People',
							),
						array(
							'type' => 'upload',
							'name' => 'bg_login_new',
							'label' => __('Login Background', 'wp_branding_textdomain'),
							'description' => __('Upload a background to use in the login screen, best would be to use repeated one', 'wp_branding_textdomain'),
							'default' => $plugin_url . 'img/skulls.png',
							),
						array(
						        'type' => 'radiobutton',
						        'name' => 'login_form_position',
						        'label' => __('Login Form Position', 'wp_branding_textdomain'),
						        'items' => array(
						            array(
						                'value' => 'login_form_position_left',
						                'label' => __('Align Left', 'wp_branding_textdomain'),
						            ),
						            array(
						                'value' => 'login_form_position_center',
						                'label' => __('Align Center', 'wp_branding_textdomain'),
						            ),
						            array(
						                'value' => 'login_form_position_right',
						                'label' => __('Align Right', 'wp_branding_textdomain'),
						            ),
						        ),

						    ),



						),
),

),
),
array(
	'title' => __('Admin Tweaks', 'wp_branding_textdomain'),
	'name' => 'submenu_2',
	'icon' => 'font-awesome:fa-bar-chart-o',
	'controls' => array(
		array(
			'type' => 'section',
			'title' => __('Use Custom Google Font', 'wp_branding_textdomain'),
			'name' => 'use_custom_google_font',
			'description' => __('Select and use a google font for all admin test', 'wp_branding_textdomain'),
			    'dependency' => array(
			        'field' => 'use_custom_font_section_toggle',
			        'function' => 'vp_dep_boolean',
			    ),

			'fields' => array(
array(
    'type' => 'select',
    'name' => 'logo_font_face',
    'label' => __('Logo Font Face', 'vp_textdomain'),
    'description' => __('Select Font', 'vp_textdomain'),
    'items' => array(
        'data' => array(
            array(
                'source' => 'function',
                'value' => 'vp_get_gwf_family',
            ),
        ),
    ),
),
array(
    'type' => 'radiobutton',
    'name' => 'logo_font_style',
    'label' => __('Logo Font Style', 'vp_textdomain'),
    'description' => __('Select Font Style', 'vp_textdomain'),
    'items' => array(
        'data' => array(
            array(
                'source' => 'binding',
                'field' => 'logo_font_face',
                'value' => 'vp_get_gwf_style',
            ),
        ),
    ),
    'default' => array(
        '{{first}}',
    ),
),
array(
    'type' => 'radiobutton',
    'name' => 'logo_font_weight',
    'label' => __('Logo Font Weight', 'vp_textdomain'),
    'description' => __('Select Font Weight', 'vp_textdomain'),
    'items' => array(
        'data' => array(
            array(
                'source' => 'binding',
                'field' => 'logo_font_face',
                'value' => 'vp_get_gwf_weight',
            ),
        ),
    ),
),
),
),
		array(
			'type' => 'section',
			'title' => __('Admin Section', 'wp_branding_textdomain'),
			'name' => 'section_2',
			'description' => __('Admin tweaks', 'wp_branding_textdomain'),
			'fields' => array(
				array(
				    'type' => 'toggle',
				    'name' => 'use_custom_font_section_toggle',
				    'label' => __('Use Custom Google Font', 'vp_textdomain'),
				    'description' => __('Use a google font for all admin test', 'vp_textdomain'),
				),
				
				array(
					'type' => 'wpeditor',
					'name' => 'admin_footer_text',
					'label' => __('Admin Footer Text', 'wp_branding_textdomain'),
					'description' => __('Replace the default wordpress text', 'wp_branding_textdomain'),
					'use_external_plugins' => '0',
					'default' => 'Footer Text <a href="http://www.google.com"> And HTML </a>',
					),
				array(
					'type' => 'textbox',
					'name' => 'meta_box_title',
					'label' => __('Title for custom Meta Box', 'wp_branding_textdomain'),
					'description' => __('Add a title for the custom metabox', 'wp_branding_textdomain'),
					'default' => 'Welcome',
					),
				array(
					'type' => 'wpeditor',
					'name' => 'custom_meta_box',
					'label' => __('Custom Meta Box', 'wp_branding_textdomain'),
					'description' => __('Add a custom metabox to the dashboard', 'wp_branding_textdomain'),
					'use_external_plugins' => '1',
					'default' => '',
					),
				array(
					'type' => 'checkbox',
					'name' => 'remove_meta',
					'label' => __('Remove Admin Metaboxes', 'wp_branding_textdomain'),
					'description' => __('Do you want to remove the dashboard metaboxes ?'),
					'items' => array(
						array(
							'value' => 'remove',
							'label' => __('Yes', 'wp_branding_textdomain'),
							),
						),
					),
				array(
					'type' => 'checkbox',
					'name' => 'add_meta_page_creation',
					'label' => __('Add a page creation metabox', 'wp_branding_textdomain'),
					'description' => __('This metabox allows easy creation of new pages in all custom post types'),
					'items' => array(
						array(
							'value' => 'remove',
							'label' => __('Yes', 'wp_branding_textdomain'),
							),
						),
					),
					array(
					'type' => 'checkbox',
					'name' => 'remove_wp_logo',
					'label' => __('Remove WordPress logo from admin bar', 'wp_branding_textdomain'),
					'description' => __('This will remove the WordPress logo from the admin top bar'),
					'items' => array(
						array(
							'value' => 'remove',
							'label' => __('Yes', 'wp_branding_textdomain'),
							),
						),
					),
					array(
					'type' => 'checkbox',
					'name' => 'add_svg_support',
					'label' => __('Add SVG support to media upload', 'wp_branding_textdomain'),
					'description' => __('This will enable you to upload and use SVG\'s using the native media uploader'),
					'items' => array(
						array(
							'value' => 'remove',
							'label' => __('Yes', 'wp_branding_textdomain'),
							),
						),
					),
					array(
					'type' => 'checkbox',
					'name' => 'remove_admin_bar',
					'label' => __('Remove Admin Bar', 'wp_branding_textdomain'),
					'description' => __('Removes the WordPress admin bar from front end'),
					'items' => array(
						array(
							'value' => 'remove',
							'label' => __('Yes', 'wp_branding_textdomain'),
							),
						),
					),
					array(
					'type' => 'checkbox',
					'name' => 'enable_perfect_body_class',
					'label' => __('Add the "Perfect Body Class"', 'wp_branding_textdomain'),
					'description' => __('This will add a body class to your website based on different browsers. supports: Opera, firefox, Gecko, Safari, Chrome, NS4, IE with versions. '),
					'items' => array(
						array(
							'value' => 'remove',
							'label' => __('Yes', 'wp_branding_textdomain'),
							),
						),
					),

					array(
					'type' => 'checkbox',
					'name' => 'remove_nagging',
					'label' => __('Remove Update Notifications', 'wp_branding_textdomain'),
					'description' => __('This will remove the nagging updae notifications for everyone except Admin '),
					'items' => array(
						array(
							'value' => 'remove',
							'label' => __('Yes', 'wp_branding_textdomain'),
							),
						),
					),
					array(
					'type' => 'checkbox',
					'name' => 'remove_version',
					'label' => __('Remove version number', 'wp_branding_textdomain'),
					'description' => __('This will remove version number from the admin footer'),
					'items' => array(
						array(
							'value' => 'remove',
							'label' => __('Yes', 'wp_branding_textdomain'),
							),
						),
					),
					array(
					'type' => 'checkbox',
					'name' => 'add_posts_ids',
					'label' => __('Add post and pages IDs', 'wp_branding_textdomain'),
					'description' => __('This will add a column to reveal post and pages IDs '),
					'items' => array(
						array(
							'value' => 'remove',
							'label' => __('Yes', 'wp_branding_textdomain'),
							),
						),
					),



				),
),
),
),

array(
	'title' => __('Color Tweaks', 'wp_branding_textdomain'),
	'name' => 'submenu_3',
	'icon' => 'font-awesome:fa-star-half-o',
	'controls' => array(
		array(
			'type' => 'section',
			'title' => __('Color Tweaks', 'wp_branding_textdomain'),
			'name' => 'section_3',
			'description' => __('Colors all around', 'wp_branding_textdomain'),
			'fields' => array(

				array(
					'type' => 'color',
					'name' => 'menu_bg',
					'label' => __('Menu Background', 'wp_branding_textdomain'),
					'description' => __('Main background color for the admin menu items', 'wp_branding_textdomain'),
					'default' => '#3FB14D',
					'format' => 'hex',
					),
				array(
					'type' => 'color',
					'name' => 'text_color',
					'label' => __('Hover Text Color', 'wp_branding_textdomain'),
					'description' => __('Main color for the text in menu items', 'wp_branding_textdomain'),
					'default' => '#3FB14D',
					'format' => 'hex',
					),

									array(
					'type' => 'checkbox',
					'name' => 'use_slate',
					'label' => __('Use the "Slate" theme', 'wp_branding_textdomain'),
					'description' => __('change the admin theme completely, this will overwrite the previous selected colors'),
					'items' => array(
						array(
							'value' => 'remove',
							'label' => __('Yes', 'wp_branding_textdomain'),
							),
						),
					),

					    array(
					        'type' => 'codeeditor',
					        'name' => 'admin_head_css',
					        'label' => __('Custom CSS for Admin Area', 'vp_textdomain'),
					        'description' => __('Write your custom css here.', 'vp_textdomain'),
					        'theme' => 'monokai',
					        'mode' => 'css',
					    ),

				),
			),
		),
	),

),

);

/**
 *EOF
 */