<?php
/**
* Core LifterLMS functions file
*/

if ( ! defined( 'ABSPATH' ) ) { exit; }

//include all other function files
require_once 'functions/llms.functions.access.php';
require_once 'functions/llms.functions.certificate.php';
require_once 'functions/llms.functions.course.php';
require_once 'functions/llms.functions.currency.php';
require_once 'functions/llms.functions.log.php';
require_once 'functions/llms.functions.notice.php';
require_once 'functions/llms.functions.page.php';
require_once 'functions/llms.functions.person.php';
require_once 'functions/llms.functions.template.php';

/**
 * Determine if Terms & Conditions agreement is required during registration
 * according to global settings
 * @return   boolean
 * @since    3.0.0
 * @version  3.3.1
 */
function llms_are_terms_and_conditions_required() {

	$enabled = get_option( 'lifterlms_registration_require_agree_to_terms' );
	$page_id = absint( get_option( 'lifterlms_terms_page_id', false ) );

	return ( 'yes' === $enabled && $page_id );

}

/**
 * Retrieve the current time based on specified type.
 *
 * This is a wrapper for the WP Core current_time which can be plugged
 * We plug this during unit testing to allow mocking the current time
 *
 * The 'mysql' type will return the time in the format for MySQL DATETIME field.
 * The 'timestamp' type will return the current timestamp.
 * Other strings will be interpreted as PHP date formats (e.g. 'Y-m-d').
 *
 * If $gmt is set to either '1' or 'true', then both types will use GMT time.
 * if $gmt is false, the output is adjusted with the GMT offset in the WordPress option.
 *
 * @param  string       $type   Type of time to retrieve. Accepts 'mysql', 'timestamp', or PHP date format string (e.g. 'Y-m-d').
 * @param  int|bool     $gmt    Optional. Whether to use GMT timezone. Default false.
 * @return int|string           Integer if $type is 'timestamp', string otherwise.
 *
 * @since    3.4.0
 * @version  3.4.0
 */
if ( ! function_exists( 'llms_current_time' ) ) {
	function llms_current_time( $type, $gmt = 0 ) {
		return current_time( $type, $gmt );
	}
}

/**
 * Provide deprecation warnings
 *
 * Very similar to https://developer.wordpress.org/reference/functions/_deprecated_function/
 *
 * @param   string $function    name of the deprecated class or function
 * @param   string $version     version deprecation ocurred
 * @param   string $replacement function to use in it's place (optional)
 * @return  void
 * @since   2.6.0
 * @version 2.6.0
 */
function llms_deprecated_function( $function, $version, $replacement = null ) {

	// only warn if debug is enabled
	if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {

		if ( function_exists( '__' ) ) {

			if ( ! is_null( $replacement ) ) {
				$string = sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.', 'lifterlms' ), $function, $version, $replacement );
			} else {
				$string = sprintf( __( '%1$s is <strong>deprecated</strong> since version %2$s!', 'lifterlms' ), $function, $version );
			}

		} else {

			if ( ! is_null( $replacement ) ) {
				$string = sprintf( '%1$s is <strong>deprecated</strong> since version %2$s! Use %3$s instead.', $function, $version, $replacement );
			} else {
				$string = sprintf( '%1$s is <strong>deprecated</strong> since version %2$s!', $function, $version );
			}

		}

		// warn on screen
		if ( defined( 'WP_DEBUG_DISPLAY' ) && WP_DEBUG_DISPLAY ) {

			echo '<br>' . $string . '<br>';

		}

		// log to the error logger
		if ( defined( 'WP_DEBUG_DISPLAY' ) && WP_DEBUG_DISPLAY ) {

			llms_log( $string );

		}

	}

}

/**
 * Get themes natively supported by LifterLMS
 * @return array
 * @since 3.0.0
 * @version 3.0.1
 */
function llms_get_core_supported_themes() {
	return array(
		'canvas',
		'Divi',
		'genesis',
		'twentyseventeen',
		'twentysixteen',
		'twentyfifteen',
		'twentyfourteen',
		'twentythirteen',
		'twentyeleven',
		'twentytwelve',
		'twentyten',
	);
}

/**
 * Get human readable time difference between 2 dates
 *
 * Return difference between 2 dates in year, month, hour, minute or second
 * The $precision caps the number of time units used: for instance if
 * $time1 - $time2 = 3 days, 4 hours, 12 minutes, 5 seconds
 * - with precision = 1 : 3 days
 * - with precision = 2 : 3 days, 4 hours
 * - with precision = 3 : 3 days, 4 hours, 12 minutes
 *
 *
 * @param mixed $time1 a time (string or timestamp)
 * @param mixed $time2 a time (string or timestamp)
 * @param integer $precision Optional precision
 * @return string time difference
 * @source http://www.if-not-true-then-false.com/2010/php-calculate-real-differences-between-two-dates-or-timestamps/
 *
 * @since    ??
 * @version  ??
 */
function llms_get_date_diff( $time1, $time2, $precision = 2 ) {
	// If not numeric then convert timestamps
	if ( ! is_int( $time1 ) ) {
		$time1 = strtotime( $time1 );
	}
	if ( ! is_int( $time2 ) ) {
		$time2 = strtotime( $time2 );
	}
	// If time1 > time2 then swap the 2 values
	if ( $time1 > $time2 ) {
		list( $time1, $time2 ) = array( $time2, $time1 );
	}
	// Set up intervals and diffs arrays
	$intervals = array( 'year', 'month', 'day', 'hour', 'minute', 'second' );
	$l18n_singular = array(
		'year' => __( 'year', 'lifterlms' ),
		'month' => __( 'month', 'lifterlms' ),
		'day' => __( 'day', 'lifterlms' ),
		'hour' => __( 'hour', 'lifterlms' ),
		'minute' => __( 'minute', 'lifterlms' ),
		'second' => __( 'second', 'lifterlms' ),
	);
	$l18n_plural = array(
		'year' => __( 'years', 'lifterlms' ),
		'month' => __( 'months', 'lifterlms' ),
		'day' => __( 'days', 'lifterlms' ),
		'hour' => __( 'hours', 'lifterlms' ),
		'minute' => __( 'minutes', 'lifterlms' ),
		'second' => __( 'seconds', 'lifterlms' ),
	);
	$diffs = array();
	foreach ( $intervals as $interval ) {
		// Create temp time from time1 and interval
		$ttime = strtotime( '+1 ' . $interval, $time1 );
		// Set initial values
		$add = 1;
		$looped = 0;
		// Loop until temp time is smaller than time2
		while ( $time2 >= $ttime ) {
			// Create new temp time from time1 and interval
			$add++;
			$ttime = strtotime( '+' . $add . ' ' . $interval, $time1 );
			$looped++;
		}
		$time1 = strtotime( '+' . $looped . ' ' . $interval, $time1 );
		$diffs[ $interval ] = $looped;
	}
	$count = 0;
	$times = array();
	foreach ( $diffs as $interval => $value ) {
		// Break if we have needed precission
		if ( $count >= $precision ) {
			break;
		}
		// Add value and interval if value is bigger than 0
		if ( $value > 0 ) {
			if ( $value != 1 ) {
				$text = $l18n_plural[ $interval ];
			} else {
				$text = $l18n_singular[ $interval ];
			}
			// Add value and interval to times array
			$times[] = $value . ' ' . $text;
			$count++;
		}
	}
	// Return string with times
	return implode( ', ', $times );
}

/**
 * Get a list of registered engagement triggers
 * @return   array
 * @since    3.1.0
 * @version  3.3.1
 */
function llms_get_engagement_triggers() {
	return apply_filters( 'lifterlms_engagement_triggers', array(
		'user_registration' => __( 'Student creates a new account', 'lifterlms' ),
		'course_enrollment' => __( 'Student enrolls in a course', 'lifterlms' ),
		'course_purchased' => __( 'Student purchases a course', 'lifterlms' ),
		'course_completed' => __( 'Student completes a course', 'lifterlms' ),
		// 'days_since_login' => __( 'Days since user last logged in', 'lifterlms' ), // @todo
		'lesson_completed' => __( 'Student completes a lesson', 'lifterlms' ),
		'quiz_completed' => __( 'Student completes a quiz', 'lifterlms' ),
		'quiz_passed' => __( 'Student passes a quiz', 'lifterlms' ),
		'quiz_failed' => __( 'Student fails a quiz', 'lifterlms' ),
		'section_completed' => __( 'Student completes a section', 'lifterlms' ),
		'course_track_completed' => __( 'Student comepletes a course track', 'lifterlms' ),
		'membership_enrollment' => __( 'Student enrolls in a membership', 'lifterlms' ),
		'membership_purchased' => __( 'Student purchases a membership', 'lifterlms' ),
	) );
}

/**
 * Get a list of registered engagement types
 * @return   array
 * @since    3.1.0
 * @version  3.1.0
 */
function llms_get_engagement_types() {
	return apply_filters( 'lifterlms_engagement_types', array(
		'achievement' => __( 'Award an Achievement', 'lifterlms' ),
		'certificate' => __( 'Award a Certificate', 'lifterlms' ),
		'email' => __( 'Send an Email' ),
	) );
}

/**
* Get an array of student IDs based on enrollment status a course or memebership
* @param    int           $post_id   WP_Post id of a course or memberhip
* @param    string|array  $statuses  list of enrollment statuses to query by
*                                    status query is an OR relationship
* @param    integer    $limit        number of results
* @param    integer    $skip         number of results to skip (for pagination)
* @return   array
* @since    3.0.0
* @version  3.4.0
*/
function llms_get_enrolled_students( $post_id, $statuses = 'enrolled', $limit = 50, $skip = 0 ) {

	// ensure we have an array if only one status is being queried
	if ( ! is_array( $statuses ) ) {
		$statuses = array( $statuses );
	}

	// drop invalid statuses
	foreach ( $statuses as $key => $status ) {
		if ( ! in_array( $status, array_keys( llms_get_enrollment_statuses() ) ) ) {
			unset( $statuses[ $key ] );
		}
	}

	$query = new LLMS_Student_Query( array(
		'post_id' => $post_id,
		'statuses' => $statuses,
		'page' => ( 0 === $skip ) ? 1 : ( $skip / $limit ) + 1,
		'per_page' => $limit,
		'sort' => array(
			'id' => 'ASC',
		),
	) );

	if ( $query->students ) {
		return wp_list_pluck( $query->students, 'id' );
	}

	return array();
}

/**
 * Get the most recently created coupon ID for a given code
 * @param   string $code        the coupon's code (title)
 * @param   int    $dupcheck_id an optional coupon id that can be passed which will be excluded during the query
 *                              this is used to dupcheck the coupon code during coupon creation
 * @return  int
 * @since   3.0.0
 * @version 3.0.0
 */
function llms_find_coupon( $code = '', $dupcheck_id = 0 ) {

	global $wpdb;
	return $wpdb->get_var( $wpdb->prepare(
		"SELECT ID
		 FROM {$wpdb->posts}
		 WHERE post_title = %s
		 AND post_type = 'llms_coupon'
		 AND post_status = 'publish'
		 AND ID != %d
		 ORDER BY ID desc;
		",
		array( $code, $dupcheck_id )
	) );

}

/**
 * Generate the HTML for a form field
 *
 * this function is used during AJAX calls so needs to be in a core file
 * loaded during AJAX calls!
 *
 * @param    array      $field  field data
 * @param    boolean    $echo   echo the data if true, return otherwise
 * @return   void|string
 * @since    3.0.0
 * @version  3.0.0
 */
function llms_form_field( $field = array(), $echo = true ) {

	$field = wp_parse_args( $field, array(
		'columns' => 12,
		'classes' => '',
		'description' => '',
		'default' => '',
		'disabled' => false,
		'id' => '',
		'label' => '',
		'last_column' => true,
		'match' => '',
		'max_length' => '',
		'min_length' => '',
		'name' => '',
		'options' => array(),
		'placeholder' => '',
		'required' => false,
		'selected' => '',
		'style' => '',
		'type'  => 'text',
		'value' => '',
		'wrapper_classes' => '',
	) );

	// setup the field value (if one exists)
	if ( '' !== $field['value'] ) {
		$field['value'] = $field['value'];
	} elseif ( '' !== $field['default'] ) {
		$field['value'] = $field['default'];
	}
	$value_attr = ( '' !== $field['value'] ) ? ' value="' . $field['value'] . '"' : '';

	// use id as the name if name isn't specified
	$field['name'] = ( '' === $field['name'] ) ? $field['id'] : $field['name'];

	// allow items to not have a name attr (eg: not be posted via form submission)
	// example use case found in Stripe CC fields
	if ( false === $field['name'] ) {
		$name_attr = '';
	} else {
		$name_attr = ' name="' . $field['name'] . '"';
	}

	// duplicate label to placeholder if none is specified
	$field['placeholder'] = ! $field['placeholder'] ? $field['label'] : $field['placeholder'];
	$field['placeholder'] = wp_strip_all_tags( $field['placeholder'] );

	// add inline css if set
	$field['style'] = ( $field['style'] ) ? ' style="' . $field['style'] . '"' : '';

	// add space to classes
	$field['wrapper_classes'] = ( $field['wrapper_classes'] ) ? ' ' . $field['wrapper_classes'] : '';
	$field['classes'] = ( $field['classes'] ) ? ' ' . $field['classes'] : '';

	// add column information to the warpper
	$field['wrapper_classes'] .= ' llms-cols-' . $field['columns'];
	$field['wrapper_classes'] .= ( $field['last_column'] ) ? ' llms-cols-last' : '';

	$desc = $field['description'] ? '<span class="llms-description">' . $field['description'] . '</span>' : '';

	// required attributes and content
	$required_char = apply_filters( 'lifterlms_form_field_required_character', '*', $field );
	$required_span = $field['required'] ? ' <span class="llms-required">' . $required_char . '</span>' : '';
	$required_attr = $field['required'] ? ' required="required"' : '';

	// setup the label
	$label = $field['label'] ? '<label for="' . $field['id'] . '">' . $field['label'] . $required_span . '</label>' : '';

	$r  = '<div class="llms-form-field type-' . $field['type'] . $field['wrapper_classes'] . '">';

	if ( 'hidden' !== $field['type'] && 'checkbox' !== $field['type'] && 'radio' !== $field['type'] ) {
		$r .= $label;
	}

	$disabled_attr = ( $field['disabled'] ) ? ' disabled="disabled"' : '';

	$min_attr = ( $field['min_length'] ) ? ' minlength="' . $field['min_length'] . '"' : '';
	$max_attr = ( $field['max_length'] ) ? ' maxlength="' . $field['max_length'] . '"' : '';

	switch ( $field['type'] ) {

		case 'button':
		case 'reset':
		case 'submit':
			$r .= '<button class="llms-field-button' . $field['classes'] . '" id="' . $field['id'] . '" type="' . $field['type'] . '"' . $disabled_attr . $name_attr . $field['style'] . '>' . $field['value'] . '</button>';
			break;

		case 'checkbox':
		case 'radio':
			$checked = ( true === $field['selected'] ) ? ' checked="checked"' : '';
			$r .= '<input class="llms-field-input' . $field['classes'] . '" id="' . $field['id'] . '" type="' . $field['type'] . '"' . $checked . $disabled_attr . $name_attr . $required_attr . $value_attr . $field['style'] . '>';
			$r .= $label;
			break;

		case 'html':
			$r .= '<div class="llms-field-html' . $field['classes'] . '" id="' . $field['id'] . '"></div>';
			break;

		case 'select':
			$r .= '<select class="llms-field-select' . $field['classes'] . '" id="' . $field['id'] . '" ' . $disabled_attr . $name_attr . $required_attr . $field['style'] . '>';
			foreach ( $field['options'] as $k => $v ) {
				$r .= '<option value="' . $k . '"' . selected( $k, $field['value'], false ) . '>' . $v . '</option>';
			}
			$r .= '</select>';
			break;

		case 'textarea':
			$r .= '<textrea class="llms-field-textarea' . $field['classes'] . '" id="' . $field['id'] . '" placeholder="' . $field['placeholder'] . '"' . $disabled_attr . $name_attr . $required_attr . $field['style'] . '>' . $field['value'] . '</textarea>';
			break;

		default:
			$r .= '<input class="llms-field-input' . $field['classes'] . '" id="' . $field['id'] . '" placeholder="' . $field['placeholder'] . '" type="' . $field['type'] . '"' . $disabled_attr . $name_attr . $min_attr . $max_attr . $required_attr . $value_attr . $field['style'] . '>';

	}

	if ( 'hidden' !== $field['type'] ) {
		$r .= $desc;
	}

	$r .= '</div>';

	if ( $field['last_column'] ) {
		$r .= '<div class="clear"></div>';
	}

	$r = apply_filters( 'llms_form_field', $r, $field );

	if ( $echo ) {

		echo $r;
		return;

	} else {

		return $r;

	}

}

/**
 * Get a list of available course / membership enrollment statuses
 * @return   array
 * @since    3.0.0
 * @version  3.0.0
 */
function llms_get_enrollment_statuses() {

	return apply_filters( 'llms_get_enrollment_statuses', array(
		'cancelled' => __( 'Cancelled', 'lifterlms' ),
		'enrolled' => __( 'Enrolled', 'lifterlms' ),
		'expired' => __( 'Expired', 'lifterlms' ),
	) );

}

/**
 * Get the human readable (and translated) name of an enrollment status
 * @param    string     $status  enrollment status key
 * @return   string
 * @since    3.0.0
 * @version  3.0.0
 */
function llms_get_enrollment_status_name( $status ) {

	$status = strtolower( $status ); // backwards compatibility
	$statuses = llms_get_enrollment_statuses();
	if ( is_array( $statuses ) && isset( $statuses[ $status ] ) ) {
		$status = $statuses[ $status ];
	}
	return apply_filters( 'lifterlms_get_enrollment_status_name ', $status );

}

/**
 * Retrive an IP Address for the current user
 * @source   WooCommerce WC_Geolocation::get_ip_address(), thank you <3
 * @return   string
 * @since    3.0.0
 * @version  3.0.0
 */
function llms_get_ip_address() {

	if ( isset( $_SERVER['X-Real-IP'] ) ) {
		return $_SERVER['X-Real-IP'];
	} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		// Proxy servers can send through this header like this: X-Forwarded-For: client1, proxy1, proxy2
		// Make sure we always only send through the first IP in the list which should always be the client IP.
		return trim( current( explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) );
	} elseif ( isset( $_SERVER['REMOTE_ADDR'] ) ) {
		return $_SERVER['REMOTE_ADDR'];
	}
	return '';

}

/**
 * Retrive an LLMS Order ID by the associated order_key
 * @param    string    $key     the order key
 * @param    string    $return  type of return, "order" for an instance of the LLMS_Order or "id" to return only the order ID
 * @return   null|int           null if none found, order id if found
 * @since    3.0.0
 * @version  3.0.0
 */
function llms_get_order_by_key( $key, $return = 'order' ) {

	global $wpdb;

	$key = sanitize_text_field( $key );

	$id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key = '_llms_order_key' AND meta_value = %s", $key ) );

	if ( 'order' === $return ) {
		return new LLMS_Order( $id );
	}

	return $id;

}

/**
 * Get the human readable status for a LifterLMS status
 * @param    string $status LifterLMS Order Status
 * @return   string
 * @since    3.0.0
 * @version  3.0.0
 */
function llms_get_order_status_name( $status ) {
	$statuses = llms_get_order_statuses();
	if ( is_array( $statuses ) && isset( $statuses[ $status ] ) ) {
		$status = $statuses[ $status ];
	}
	return apply_filters( 'lifterlms_get_order_status_name ', $status );
}

/**
 * Retrieve an array of registered and available LifterLMS Order Post Statuses
 * @param    string  $order_type  filter stauses which are specific to the supplied order type, defaults to any statuses
 * @return   array
 * @since    3.0.0
 * @version  3.0.0
 */
function llms_get_order_statuses( $order_type = 'any' ) {

	$statuses = array(
		'llms-active'    => __( 'Active', 'lifterlms' ),
		'llms-cancelled' => __( 'Cancelled', 'lifterlms' ),
		'llms-completed' => __( 'Completed', 'lifterlms' ),
		'llms-expired'   => __( 'Expired', 'lifterlms' ),
		'llms-failed'    => __( 'Failed', 'lifterlms' ),
		'llms-pending'   => __( 'Pending', 'lifterlms' ),
		'llms-refunded'  => __( 'Refunded', 'lifterlms' ),
	);

	// remove types depending on order type
	switch ( $order_type ) {
		case 'recurring':
			unset( $statuses['llms-completed'] );
		break;

		case 'single':
			unset( $statuses['llms-active'] );
			unset( $statuses['llms-expired'] );
		break;
	}

	return apply_filters( 'llms_get_order_statuses', $statuses, $order_type );
}

/**
 * Retrieve the LLMS Post Model for a give post by ID or WP_Post Object
 * @param    obj|int     $post  instance of WP_Post or a WP Post ID
 * @return   obj|false
 * @since    3.3.0
 * @version  3.3.1
 */
function llms_get_post( $post ) {

	if ( ! empty( $post ) && is_numeric( $post ) ) {
		$post = get_post( $post );
	} elseif ( ! is_a( $post, 'WP_Post' ) ) {
		return false;
	}

	switch ( $post->post_type ) {

		case 'llms_access_plan':
			$post = new LLMS_Access_Plan( $post );
		break;

		case 'llms_coupon':
			$post = new LLMS_Coupon( $post );
		break;

		case 'course':
			$post = new LLMS_Course( $post );
		break;

		case 'lesson':
			$post = new LLMS_Lesson( $post );
		break;

		case 'section':
			$post = new LLMS_Section( $post );
		break;

		case 'llms_membership':
			$post = new LLMS_Membership( $post );
		break;

		case 'llms_order':
			$post = new LLMS_Order( $post );
		break;

		case 'llms_quiz':
			$post = new LLMS_Quiz( $post );
		break;

		case 'llms_question':
			$post = new LLMS_Question( $post );
		break;

		case 'llms_transaction':
			$post = new LLMS_Transaction( $post );
		break;

	}

	return $post;

}

/**
 * Retrieve an array of existing transaction statuses
 * @return   array
 * @since    3.0.0
 * @version  3.0.0
 */
function llms_get_transaction_statuses() {
	return apply_filters( 'llms_get_transaction_statuses', array(
		'llms-txn-failed',
		'llms-txn-pending',
		'llms-txn-refunded',
		'llms-txn-succeeded',
	) );
}

/**
 * Determine is request is an ajax request
 * @return   bool
 * @since    3.0.1
 * @version  3.0.1
 */
function llms_is_ajax() {
	return ( defined( 'DOING_AJAX' ) && DOING_AJAX );
}

/**
 * Check if the home URL is https. If it is, we don't need to do things such as 'force ssl'.
 * @thanks woocommerce <3
 * @return   bool
 * @since    3.0.0
 * @version  3.0.0
 */
function llms_is_site_https() {
	return false !== strstr( get_option( 'home' ), 'https:' );
}

/**
 * Create an array that can be passed to metabox select elements
 * configured as an llms-select2-post query-ier
 * @param    array      $post_ids  indexed array of WordPress Post IDs
 * @param    string     $template  an optional template to customize the way the results look
 *                                 {title} and {id} can be passed into the template
 *                                 and will be replaced with the post title and post id respectively
 * @return   array
 * @since    3.0.0
 * @version  3.0.0
 */
function llms_make_select2_post_array( $post_ids = array(), $template = '' ) {

	if ( ! $template ) {
		$template = '{title} (' . __( 'ID#', 'lifterlms' ) . ' {id})';
	}

	if ( ! is_array( $post_ids ) ) {
		$post_ids = array( $post_ids );
	}

	$r = array();
	foreach ( $post_ids as $id ) {

		$title = str_replace( array( '{title}', '{id}' ), array( get_the_title( $id ), $id ), $template );

		$r[] = array(
			'key' => $id,
			'title' => $title,
		);
	}
	return apply_filters( 'llms_make_select2_post_array', $r, $post_ids );

}

/**
 * Trim a string and append a suffix.
 * @source thank you WooCommerce <3
 * @param  string  $string  input string
 * @param  int     $chars   max number of characters
 * @param  string  $suffix  optionally append a suffix
 * @return string
 * @since  3.0.0
 * @version  3.0.0
 */
function llms_trim_string( $string, $chars = 200, $suffix = '...' ) {
	if ( strlen( $string ) > $chars ) {
		if ( function_exists( 'mb_substr' ) ) {
			$string = mb_substr( $string, 0, ( $chars - mb_strlen( $suffix ) ) ) . $suffix;
		} else {
			$string = substr( $string, 0, ( $chars - strlen( $suffix ) ) ) . $suffix;
		}
	}
	return $string;
}















/*
	       /$$                                                     /$$
	      | $$                                                    | $$
	  /$$$$$$$  /$$$$$$   /$$$$$$   /$$$$$$   /$$$$$$$  /$$$$$$  /$$$$$$    /$$$$$$
	 /$$__  $$ /$$__  $$ /$$__  $$ /$$__  $$ /$$_____/ |____  $$|_  $$_/   /$$__  $$
	| $$  | $$| $$$$$$$$| $$  \ $$| $$$$$$$$| $$        /$$$$$$$  | $$    | $$$$$$$$
	| $$  | $$| $$_____/| $$  | $$| $$_____/| $$       /$$__  $$  | $$ /$$| $$_____/
	|  $$$$$$$|  $$$$$$$| $$$$$$$/|  $$$$$$$|  $$$$$$$|  $$$$$$$  |  $$$$/|  $$$$$$$
	 \_______/ \_______/| $$____/  \_______/ \_______/ \_______/   \___/   \_______/
	                    | $$
	                    | $$
	                    |__/
*/





/**
 * Add product-id to WP query variables
 *
 * @param array $vars [WP query variables]
 * @return array $vars [WP query variables]
 *
 * @todo  deprecate?
 */
function llms_add_query_var_product_id( $vars ) {
	$vars[] = 'product-id';
	return $vars;
}
add_filter( 'query_vars', 'llms_add_query_var_product_id' );


/**
 * Sanitize text field
 * @param  string $var [raw text field input]
 * @return string [clean string]
 *
 * @todo  deprecate b/c sanitize_text_field() already exists....
 */
function llms_clean( $var ) {
	return sanitize_text_field( $var );
}






/**
 * Schedule expired membership cron
 * @return void
 */
function llms_expire_membership_schedule() {
	if ( ! wp_next_scheduled( 'llms_check_for_expired_memberships' )) {
		  wp_schedule_event( time(), 'daily', 'llms_check_for_expired_memberships' );
	}
}
add_action( 'wp', 'llms_expire_membership_schedule' );

/**
 * Expire Membership
 * @return void
 */
function llms_expire_membership() {
	global $wpdb;

	//find all memberships wth an expiration date
	$args = array(
	'post_type'     => 'llms_membership',
	'posts_per_page'  => 500,
	'meta_query'    => array(
	  'key' => '_llms_expiration_interval',
	  ),
	);

	$posts = get_posts( $args );

	if ( empty( $posts ) ) {
		return;
	}

	foreach ($posts as $post) {

		//make sure interval and period exist before continuing.
		$interval = get_post_meta( $post->ID, '_llms_expiration_interval', true );
		$period = get_post_meta( $post->ID, '_llms_expiration_period', true );

		if ( empty( $interval ) || empty( $period ) ) {
			continue;
		}

		// query postmeta table and find all users enrolled
		$table_name = $wpdb->prefix . 'lifterlms_user_postmeta';
		$meta_key_status = '_status';
		$meta_value_status = 'Enrolled';

		$results = $wpdb->get_results( $wpdb->prepare(
		'SELECT * FROM ' . $table_name . ' WHERE post_id = %d AND meta_key = "%s" AND meta_value = %s ORDER BY updated_date DESC', $post->ID, $meta_key_status, $meta_value_status ) );

		for ($i = 0; $i < count( $results ); $i++) {
			$results[ $results[ $i ]->post_id ] = $results[ $i ];
			unset( $results[ $i ] );
		}

		$enrolled_users = $results;

		foreach ( $enrolled_users as $user ) {

			$user_id = $user->user_id;
			$meta_key_start_date = '_start_date';
			$meta_value_start_date = 'yes';

			$start_date = $wpdb->get_results( $wpdb->prepare(
			'SELECT updated_date FROM ' . $table_name . ' WHERE user_id = %d AND post_id = %d AND meta_key = %s AND meta_value = %s ORDER BY updated_date DESC', $user_id, $post->ID, $meta_key_start_date, $meta_value_start_date) );

			//add expiration terms to start date
			$exp_date = date( 'Y-m-d',strtotime( date( 'Y-m-d', strtotime( $start_date[0]->updated_date ) ) . ' +' . $interval . ' ' . $period ) );

			// get current datetime
			$today = current_time( 'mysql' );
			$today = date( 'Y-m-d', strtotime( $today ) );

			//if a date parse causes exp date to be unmodified then return.
			if ( $exp_date == $start_date[0]->updated_date ) {
				LLMS_log( 'An error occured modifying the date value. Function: llms_expire_membership, interval: ' . $interval . ' period: ' . $period );
				continue;
			}

			//compare expiration date to current date.
			if ( $exp_date < $today ) {
				$set_user_expired = array(
					'post_id' => $post->ID,
					'user_id' => $user_id,
					'meta_key' => '_status',
				);

				$status_update = array(
					'meta_value' => 'Expired',
					'updated_date' => current_time( 'mysql' ),
				);

				// change enrolled to expired in user_postmeta
				$update_user_meta = $wpdb->update( $table_name, $status_update, $set_user_expired );

				// remove membership id from usermeta array
				$users_levels = get_user_meta( $user_id, '_llms_restricted_levels', true );
				if ( in_array( $post->ID, $users_levels ) ) {
					$key = array_search( $post->ID, $users_levels );
					unset( $users_levels[ $key ] );

					update_user_meta( $user_id, '_llms_restricted_levels', $users_levels );
				}
			}

		}

	}

}
add_action( 'llms_check_for_expired_memberships', 'llms_expire_membership' );
