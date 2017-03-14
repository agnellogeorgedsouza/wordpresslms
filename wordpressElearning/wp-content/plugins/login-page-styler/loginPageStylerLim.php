<?php


function lps_getip(){
           if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip =esc_sql($_SERVER['HTTP_CLIENT_IP']);
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = esc_sql($_SERVER['HTTP_X_FORWARDED_FOR']);
        } else {
            $ip =  esc_sql($_SERVER['REMOTE_ADDR']);
             if($ip=='::1'){
                  $ip = '127.0.0.1';
        
             }
        }
        return $ip;
    }



function lps_counts($username = "") {
	global $wpdb;
	//global $loginlockdownOptions;
	$attempt_within = 1 ;
	$table_name = $wpdb->prefix . "lps_login_fails";
	$ip = lps_getip();

	$numFailsquery = "SELECT COUNT(lpslogin_attempt_ID) FROM $table_name " . 
					"WHERE lpslogin_attempt_date + INTERVAL " .
					$attempt_within. " MINUTE > now() AND " . 
					"lpslogin_attempt_IP LIKE '%s'";
	$numFailsquery = $wpdb->prepare( $numFailsquery, $ip . "%");

	$numFails = $wpdb->get_var($numFailsquery);
	return $numFails;
}


function lps_increment($username = "") {
	global $wpdb;
	//global $loginlockdownOptions;
	$table_name = $wpdb->prefix . "lps_login_fails";

	$ip = lps_getip();

	$username = sanitize_user($username);
	$user = get_user_by('login',$username);
	//if ( $user || "yes" == $loginlockdownOptions['lockout_invalid_usernames'] ) {
		if ( $user === false ) { 
			$user_id = -1;
		} else {
			$user_id = $user->ID;
		}
		
		$insert = "INSERT INTO " . $table_name . " (lpsuser_id, lpslogin_attempt_date, lpslogin_attempt_IP) " .
				"VALUES ('" . $user_id . "', now(), '%s')";
		$insert = $wpdb->prepare( $insert, $ip );
		$results = $wpdb->query($insert);
	
}




function lps_lockDown($username = "") {
	global $wpdb;
	//global $loginlockdownOptions;
	$block_time = 2 ;
	$table_name = $wpdb->prefix . "lps_lockdowns";
	$ip = lps_getip();

	$username = sanitize_user($username);
	$user = get_user_by('login',$username);
	//if ( $user || "yes" == $loginlockdownOptions['lockout_invalid_usernames'] ) {
		if ( $user === false ) { 
			$user_id = -1;
		} else {
			$user_id = $user->ID;
		}
		$insert = "INSERT INTO " . $table_name . " (lpsuser_id, lpslockdown_date, lpsrelease_date, lpslockdown_IP) " .
				"VALUES ('" . $user_id . "', now(), date_add(now(), INTERVAL " .
				$block_time . " MINUTE), '%s')";
		$insert = $wpdb->prepare( $insert, $ip );
		$results = $wpdb->query($insert);
	
}




function lps_isLockedDown() {
	global $wpdb;
	$table_name = $wpdb->prefix . "lps_lockdowns";
	$ip = lps_getip();

	$stillLockedquery = "SELECT lpsuser_id FROM $table_name " . 
					"WHERE lpsrelease_date > now() AND " . 
					"lpslockdown_IP LIKE  %s" ;
	$stillLockedquery = $wpdb->prepare($stillLockedquery,$ip . "%");

	$stillLocked = $wpdb->get_var($stillLockedquery);

	return $stillLocked;
}





function lps_listLockedDown() {
	global $wpdb;
	$table_name = $wpdb->prefix . "lps_lockdowns";

	$listLocked = $wpdb->get_results("SELECT lpslockdown_ID, floor((UNIX_TIMESTAMP(lpsrelease_date)-UNIX_TIMESTAMP(now()))/60) AS minutes_left, ".
					"lpslockdown_IP FROM $table_name WHERE lpsrelease_date > now()", ARRAY_A);

	return $listLocked;
}



if(get_option('lps_enable_lim') == 1 ){
	remove_filter('authenticate', 'wp_authenticate_username_password', 20, 3);
	add_filter('authenticate', 'lps_wp_authenticate_username_password', 20, 3);
	//Filters
}
	//Functions
	function lps_wp_authenticate_username_password($user, $username, $password) {
		global $wpdb;

		if ( is_a($user, 'WP_User') ) { return $user; }

		if ( empty($username) || empty($password) ) {
			$error = new WP_Error();

			if ( empty($username) )
				$error->add('empty_username', __('<strong>ERROR</strong>: The username field is empty.'));

			if ( empty($password) )
				$error->add('empty_password', __('<strong>ERROR</strong>: The password field is empty.'));

			return $error;
		}

		$userdata = get_user_by('login',$username);
		$attemptstotal = 2 - 1;
		$attemptsremain = $attemptstotal - lps_counts($username);

		if ( !$userdata ) {
			return new WP_Error('invalid_username', sprintf(__('<strong>ERROR</strong>: Invalid username. "'.$attemptsremain.'" Attempts Remaining <a href="%s" title="Password Lost and Found">Lost your password</a>?'), site_url('wp-login.php?action=lostpassword', 'login')));
		}




		$userdata = apply_filters('wp_authenticate_user', $userdata, $password);
		if ( is_wp_error($userdata) ) {
			return $userdata;
		}

		if ( !wp_check_password($password, $userdata->user_pass, $userdata->ID) ) {
			return new WP_Error('incorrect_password', sprintf(__('<strong>ERROR</strong>: Incorrect password. "'.$attemptsremain.'" Attempts Remaining. <a href="%s" title="Password Lost and Found">Lost your password</a>?'), site_url('wp-login.php?action=lostpassword', 'login')));
		}

		$user =  new WP_User($userdata->ID);
		return $user;
	}


if ( !function_exists('wp_authenticate') && get_option('lps_enable_lim') ==1 ) :
	function wp_authenticate($username, $password) {
		global $wpdb, $error;
		//global $loginlockdownOptions;
		$ip = lps_getip();


		$username = sanitize_user($username);
		$password = trim($password);

		$retryafter= 2 ;



		if ( "" != lps_isLockedDown() ) {
			return new WP_Error('incorrect_password', "<strong>ERROR</strong>: We're sorry, but this IP has been blocked due to too many recent " .
					"failed login attempts.<br /><br />Please try again later after <b>'".$retryafter."' minutes</b>.");
		}

		$user = apply_filters('authenticate', null, $username, $password);

		if ( $user == null ) {
			// TODO what should the error message be? (Or would these even happen?)
			// Only needed if all authentication handlers fail to return anything.
			$user = new WP_Error('authentication_failed', __('<strong>ERROR</strong>: Invalid username or incorrect password.'));
		}

		$ignore_codes = array('empty_username', 'empty_password');


		if (is_wp_error($user) && !in_array($user->get_error_code(), $ignore_codes) ) {
			lps_increment($username);
			if ( 2 <= lps_counts($username) ) {
				lps_lockDown($username);
				return new WP_Error('incorrect_password', __("<strong>ERROR</strong>: We're sorry, but this IP  has been blocked due to too many recent " .
						"failed login attempts.<br /><br />Please try again later after <b>'".$retryafter."' minutes</b>."));
			}
			//if ( 'yes' == $loginlockdownOptions['mask_login_errors'] ) {
			//	return new WP_Error('authentication_failed', sprintf(__('<strong>ERROR</strong>: Invalid username or incorrect password. <a href="%s" title="Password Lost and Found">Lost your password</a>?'), site_url('wp-login.php?action=lostpassword', 'login')));
			//} else {
			//	do_action('wp_login_failed', $username);
			//}
		}

		return $user;
	}
	endif;


  


?>