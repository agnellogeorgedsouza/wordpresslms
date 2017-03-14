<?php

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Class LP_Addon_Wishlist
 */
class LP_Addon_Wishlist {
	/**
	 * @var bool
	 */
	protected static $_instance = false;

	/**
	 * @var string
	 */
	protected $_tab_slug = 'wishlist';

	/**
	 * LP_Addon_Wishlist constructor.
	 */
	function __construct() {

		if ( !function_exists( 'learn_press_load_plugin_text_domain' ) ) {
			return;
		}

		$this->_tab_slug = sanitize_title( __( 'wishlist', 'learnpress-wishlist' ) );
		add_action( 'init', array( $this, 'init' ) );

		//add_action( 'learn_press_entry_footer_archive', array( $this, 'wishlist_button' ), 10 );
		//add_action( 'learn_press_course_landing_content', array( $this, 'wishlist_button' ), 10 );
		//add_action( 'learn_press_course_learning_content', array( $this, 'wishlist_button' ), 10 );

		add_action( 'learn_press_content_learning_summary', array( $this, 'wishlist_button' ), 100 );
		add_filter( 'learn_press_user_profile_tabs', array( $this, 'wishlist_tab' ), 100, 2 );
		add_filter( 'learn_press_profile_tab_endpoints', array( $this, 'profile_tab_endpoints' ) );
		add_action( 'plugins_loaded', array( __CLASS__, 'load_text_domain' ) );
		add_action( 'init', array( $this, 'require_functions' ) );
		//add_action( 'learn_press_after_wishlist_course_title', array( $this, 'wishlist_button' ), 10 );

		// assets
		add_action( 'wp_enqueue_scripts', array( $this, 'wishlist_scripts' ) );

		// ajax actions
		//add_action( 'wp_ajax_learn_press_toggle_course_wishlist', array( $this, 'toggle_course_wishlist' ) );
		LP_Request_Handler::register_ajax( 'toggle_course_wishlist', array( $this, 'toggle_course_wishlist' ) );

	}

	function require_functions() {
		include_once dirname( __FILE__ ) . '/lp-wishlist-functions.php';
	}

	function init() {
		define( 'WISHLIST_THEME_TMPL', learn_press_template_path() . '/addons/wishlist/' );

		$endpoint                   = preg_replace( '!_!', '-', $this->get_tab_slug() );
		LP()->query_vars[$endpoint] = $endpoint;
		add_rewrite_endpoint( $endpoint, EP_ROOT | EP_PAGES );
	}

	function profile_tab_endpoints( $endpoints ) {
		$endpoints[] = $this->get_tab_slug();
		return $endpoints;
	}

	function toggle_course_wishlist() {
		sleep( 1 );
		$nonce = !empty( $_POST['nonce'] ) ? $_POST['nonce'] : null;
		if ( !wp_verify_nonce( $nonce, 'course-toggle-wishlist' ) ) {
			die ( __( 'You have not permission to do this action', 'learnpress-wishlist' ) );
		}

		$course_id = !empty( $_POST['course_id'] ) ? absint( $_POST['course_id'] ) : 0;
		$user_id   = get_current_user_id();

		if ( ( get_post_type( $course_id ) != 'lp_course' ) || !$user_id ) {
			return;
		}
		$state    = !empty( $_POST['state'] ) ? $_POST['state'] : false;
		$wishlist = (array) get_user_meta( $user_id, '_lpr_wish_list', true );
		if ( $state === false ) {
			$state = in_array( $course_id, $wishlist ) ? 'off' : 'on';
		}
		$pos = array_search( $course_id, $wishlist );
		if ( $state == 'on' ) {
			if ( $pos === false ) {
				$wishlist[] = $course_id;
			}
		} else {
			if ( $pos !== false ) {
				unset( $wishlist[$pos] );
			}
		}
		if ( sizeof( $wishlist ) ) {
			update_user_meta( $user_id, '_lpr_wish_list', $wishlist );
		} else {
			delete_user_meta( $user_id, '_lpr_wish_list' );
		}
		learn_press_send_json(
			array(
				'state'       => $state,
				'course_id'   => $course_id,
				'user_id'     => $user_id,
				'title'       => $this->_get_state_title( $state ),
				'message'     => '',
				'button_text' => $state != 'on' ? __( 'Add to Wishlist', 'learnpress-wishlist' ) : __( 'Remove from Wishlist', 'learnpress-wishlist' )
			)
		);
	}

	/**
	 * @param string $state
	 *
	 * @return mixed
	 */
	private function _get_state_title( $state = 'on' ) {
		return $state == 'on' ? __( 'Remove this course from your wishlist', 'learnpress-wishlist' ) : __( 'Add this course to your wishlist', 'learnpress-wishlist' );
	}

	/**
	 * @param string $state
	 *
	 * @return mixed
	 */
	private function _get_state_message( $state = 'on' ) {
		return $state == 'on' ? __( 'This course added to your wishlist', 'learnpress-wishlist' ) : __( 'This course removed from your wishlist', 'learnpress-wishlist' );
	}

	/**
	 * Wishlist scripts processing
	 */
	function wishlist_scripts() {
		wp_enqueue_style( 'course-wishlist-style', untrailingslashit( plugins_url( '/', LP_ADDON_WISHLIST_FILE ) ) . '/source/wishlist.css' );
		wp_enqueue_script( 'course-wishlist-script', untrailingslashit( plugins_url( '/', LP_ADDON_WISHLIST_FILE ) ) . '/source/wishlist.js', array( 'jquery' ) );
	}

	/*
 	 * Show wishlist button
 	 */
	function wishlist_button( $course_id = null ) {
		$user_id = get_current_user_id();
		if ( !$course_id ) {
			$course_id = get_the_ID();
		}

		//	 If user or course are invalid then return.
		if ( !$user_id || !$course_id ) {
			return;
		}

		$classes = array( 'course-wishlist' /* dashicons dashicons-heart heartbeat'*/ );
		$state   = learn_press_user_wishlist_has_course( $course_id, $user_id ) ? 'on' : 'off';

		if ( $state == 'on' ) {
			$classes[] = 'on';
		}
		$classes = apply_filters( 'learn_press_course_wishlist_button_classes', $classes, $course_id );
		$title   = $this->_get_state_title( $state );

		// fetch template
		learn_press_course_wishlist_template( 'button.php', compact( 'user_id', 'course_id', 'classes', 'title', 'state' ) );
	}

	function get_tab_slug() {
		return apply_filters( 'learn_press_course_wishlist_tab_slug', $this->_tab_slug, $this );
	}

	/**
	 * Add Wishlist tab to user profile
	 *
	 * @param $tabs
	 * @param $user
	 *
	 * @return mixed
	 */
	function wishlist_tab( $tabs, $user ) {
		$tabs[$this->get_tab_slug()] = array(
			'title'    => __( 'Wishlist', 'learnpress-wishlist' ),
			'callback' => array( $this, 'wishlist_tab_content' )
		);
		return $tabs;
	}

	/**
	 * Display content of tab Wishlist
	 *
	 * @param $tab
	 * @param $user
	 * @param $tabs
	 */
	function wishlist_tab_content( $tab, $tabs, $user ) {
		learn_press_course_wishlist_template(
			'user-wishlist.php',
			array(
				'user'     => $user,
				'wishlist' => $this->get_wishlist_courses( $user->id )
			)
		);
	}

	function get_wishlist_courses( $user_id ) {
		$pid = (array) get_user_meta( $user_id, '_lpr_wish_list', true );

		$args     = array(
			'post_type'           => 'lp_course',
			'post__in'            => $pid,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
			'posts_per_page'      => - 1
		);
		$query    = new WP_Query( $args );
		$wishlist = array();
		global $post;
		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) : $query->the_post();
				$wishlist[$post->ID] = $post;
			endwhile;
		endif;
		wp_reset_postdata();

		return $wishlist;
	}

	/**
	 * @return bool|LP_Addon_Wishlist
	 */
	static function instance() {
		if ( !self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Load text domain for addon
	 */
	static function load_text_domain() {
		if( function_exists('learn_press_load_plugin_text_domain')){ learn_press_load_plugin_text_domain(LP_ADDON_WISHLIST_PATH, true ); }
	}
}

add_action( 'learn_press_ready', array( 'LP_Addon_Wishlist', 'instance' ) );

function learn_press_course_wishlist_template( $name, $args = null ) {
	learn_press_get_template( $name, $args, WISHLIST_THEME_TMPL, WISHLIST_TMPL );
}