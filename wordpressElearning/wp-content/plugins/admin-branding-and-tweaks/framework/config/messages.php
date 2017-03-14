<?php

return array(

	////////////////////////////////////////
	// Localized JS Message Configuration //
	////////////////////////////////////////

	/**
	 * Validation Messages
	 */
	'validation' => array(
		'alphabet'     => __('Value needs to be Alphabet', 'wp_branding_textdomain'),
		'alphanumeric' => __('Value needs to be Alphanumeric', 'wp_branding_textdomain'),
		'numeric'      => __('Value needs to be Numeric', 'wp_branding_textdomain'),
		'email'        => __('Value needs to be Valid Email', 'wp_branding_textdomain'),
		'url'          => __('Value needs to be Valid URL', 'wp_branding_textdomain'),
		'maxlength'    => __('Length needs to be less than {0} characters', 'wp_branding_textdomain'),
		'minlength'    => __('Length needs to be more than {0} characters', 'wp_branding_textdomain'),
		'maxselected'  => __('Select no more than {0} items', 'wp_branding_textdomain'),
		'minselected'  => __('Select at least {0} items', 'wp_branding_textdomain'),
		'required'     => __('This is required', 'wp_branding_textdomain'),
	),

	/**
	 * Import / Export Messages
	 */
	'util' => array(
		'import_success'    => __('Import succeed, option page will be refreshed..', 'wp_branding_textdomain'),
		'import_failed'     => __('Import failed', 'wp_branding_textdomain'),
		'export_success'    => __('Export succeed, copy the JSON formatted options', 'wp_branding_textdomain'),
		'export_failed'     => __('Export failed', 'wp_branding_textdomain'),
		'restore_success'   => __('Restoration succeed, option page will be refreshed..', 'wp_branding_textdomain'),
		'restore_nochanges' => __('Options identical to default', 'wp_branding_textdomain'),
		'restore_failed'    => __('Restoration failed', 'wp_branding_textdomain'),
	),

	/**
	 * Control Fields String
	 */
	'control' => array(
		// select2 select box
		'select2_placeholder' => __('Select option(s)', 'wp_branding_textdomain'),
		// fontawesome chooser
		'fac_placeholder'     => __('Select an Icon', 'wp_branding_textdomain'),
	),

);

/**
 * EOF
 */