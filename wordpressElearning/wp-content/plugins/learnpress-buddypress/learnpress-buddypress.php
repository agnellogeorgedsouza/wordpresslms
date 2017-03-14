<?php
/*
Plugin Name: LearnPress - BuddyPress Integration
Plugin URI: http://thimpress.com/learnpress
Description: Using the profile system provided by BuddyPress
Author: ThimPress
Version: 2.0
Author URI: http://thimpress.com
Tags: learnpress
Text Domain: learnpress-buddypress
Domain Path: /languages/
*/

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'LP_ADDON_BP_FILE', __FILE__ );
define( 'LP_ADDON_BP_PATH', dirname( __FILE__ ) );
define( 'LP_ADDON_BP_VER', '2.0' );
define( 'LP_ADDON_BP_REQUIRE_VER', '1.0' );


/**
 * Class LP_Addon_BuddyPress_Course_Profile
 */
class LP_Addon_BuddyPress_Course_Profile {

	/**
	 * @var null
	 */
	protected static $_instance = null;

	/**
	 * LP_Addon_BuddyPress_Course_Profile constructor.
	 */
	function __construct() {
		if ( $this->bp_is_active() ) {
			$this->_init_hooks();
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ), 0 );
		}
	}

	public function admin_scripts( $hook ) {
		global $post;
		if ( $post && in_array( $post->post_type, array( LP_COURSE_CPT, LP_LESSON_CPT, LP_QUESTION_CPT, LP_QUIZ_CPT, LP_ORDER_CPT ) ) ) {
			add_filter( 'bp_activity_maybe_load_mentions_scripts', array( $this, 'dequeue_script' ), - 99 );
		}
	}

	public function dequeue_script( $load_mentions ) {
		return false;
	}

	function get_tab_courses_name() {
		return apply_filters( 'learn_press_bp_tab_courses_name', __( 'Courses', 'learnpress-buddypress' ) );
	}

	function get_tab_courses_slug() {
		return apply_filters( 'learn_press_bp_tab_courses_slug', 'courses' /*sanitize_title( $this->get_tab_courses_name() )*/ );
	}

	function get_tab_quizzes_name() {
		return apply_filters( 'learn_press_bp_tab_quizzes_name', __( 'Quizzes', 'learnpress-buddypress' ) );
	}

	function get_tab_quizzes_slug() {
		return apply_filters( 'learn_press_bp_tab_quizzes_slug', 'quizzes' /*sanitize_title( $this->get_tab_quizzes_name() )*/ );
	}

	function get_tab_orders_name() {
		return apply_filters( 'learn_press_bp_tab_orders_name', __( 'Orders', 'learnpress-buddypress' ) );
	}

	function get_tab_orders_slug() {
		return apply_filters( 'learn_press_bp_tab_orders_slug', 'orders' /*sanitize_title( $this->get_tab_orders_name() )*/ );
	}

	private function _init_hooks() {
		add_action( 'wp_loaded', array( $this, 'bp_add_new_item' ) );
		add_action( 'bp_setup_admin_bar', array( $this, 'bp_setup_courses_bar' ) );
		add_action( 'init', array( __CLASS__, 'load_text_domain' ) );
	}

	function bp_add_new_item() {
		$tabs = array(
			array(
				'name'                    => $this->get_tab_courses_name(),
				'slug'                    => $this->get_tab_courses_slug(),
				'show_for_displayed_user' => true,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'default_subnav_slug'     => 'all',
				'position'                => 100
			),
			array(
				'name'                    => $this->get_tab_quizzes_name(),
				'slug'                    => $this->get_tab_quizzes_slug(),
				'show_for_displayed_user' => true,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'default_subnav_slug'     => 'all',
				'position'                => 100
			),
			array(
				'name'                    => $this->get_tab_orders_name(),
				'slug'                    => $this->get_tab_orders_slug(),
				'show_for_displayed_user' => true,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'default_subnav_slug'     => 'all',
				'position'                => 100
			)
		);
		foreach ( $tabs as $tab ) {
			bp_core_new_nav_item( $tab );
		}
		$sub_navs = array(
			array(
				'name'                    => __( 'All', 'learnpress-buddypress' ),
				'slug'                    => 'all',
				'show_for_displayed_user' => true,
				'position'                => 10,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'parent_url'              => $this->bp_get_current_link(),
				'parent_slug'             => $this->get_tab_courses_slug(),
			),
			array(
				'name'                    => __( 'Learning', 'learnpress-buddypress' ),
				'slug'                    => 'learning',
				'show_for_displayed_user' => true,
				'position'                => 10,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'parent_url'              => $this->bp_get_current_link(),
				'parent_slug'             => $this->get_tab_courses_slug(),
			),
			array(
				'name'                    => __( 'Finished', 'learnpress-buddypress' ),
				'slug'                    => 'finished',
				'show_for_displayed_user' => true,
				'position'                => 10,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'parent_url'              => $this->bp_get_current_link(),
				'parent_slug'             => $this->get_tab_courses_slug(),
			),
			array(
				'name'                    => __( 'Own', 'learnpress-buddypress' ),
				'slug'                    => 'own',
				'show_for_displayed_user' => true,
				'position'                => 10,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'parent_url'              => $this->bp_get_current_link(),
				'parent_slug'             => $this->get_tab_courses_slug(),
			),
			////////////////////
			array(
				'name'                    => __( 'All', 'learnpress-buddypress' ),
				'slug'                    => 'all',
				'show_for_displayed_user' => true,
				'position'                => 10,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'parent_url'              => $this->bp_get_current_link( 'quizzes' ),
				'parent_slug'             => $this->get_tab_quizzes_slug(),
			),
			array(
				'name'                    => __( 'Finished', 'learnpress-buddypress' ),
				'slug'                    => 'finished',
				'show_for_displayed_user' => true,
				'position'                => 10,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'parent_url'              => $this->bp_get_current_link( 'quizzes' ),
				'parent_slug'             => $this->get_tab_quizzes_slug(),
			),
			array(
				'name'                    => __( 'Doing', 'learnpress-buddypress' ),
				'slug'                    => 'doing',
				'show_for_displayed_user' => true,
				'position'                => 10,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'parent_url'              => $this->bp_get_current_link( 'quizzes' ),
				'parent_slug'             => $this->get_tab_quizzes_slug(),
			),
			/////////////////////
			array(
				'name'                    => __( 'Orders', 'learnpress-buddypress' ),
				'slug'                    => 'all',
				'show_for_displayed_user' => true,
				'position'                => 10,
				'screen_function'         => array( $this, 'bp_tab_content' ),
				'parent_url'              => $this->bp_get_current_link( 'orders' ),
				'parent_slug'             => $this->get_tab_orders_slug(),
			)
		);
		foreach ( $sub_navs as $sub_nav ) {
			bp_core_new_subnav_item( $sub_nav );
		}
	}

	function bp_tab_content() {
		global $bp;
		switch ( $bp->current_component ) {
			case 'courses':
				add_action( 'bp_template_title', array( $this, 'bp_tab_courses_title' ) );
				add_action( 'bp_template_content', array( $this, 'bp_tab_courses_content' ) );
				bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
				break;
			case 'quizzes':
				add_action( 'bp_template_title', array( $this, 'bp_tab_quizzes_title' ) );
				add_action( 'bp_template_content', array( $this, 'bp_tab_quizzes_content' ) );
				bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
				break;
			case 'orders':
				add_action( 'bp_template_title', array( $this, 'bp_tab_orders_title' ) );
				add_action( 'bp_template_content', array( $this, 'bp_tab_orders_content' ) );
				bp_core_load_template( apply_filters( 'bp_core_template_plugin', 'members/single/plugins' ) );
				break;
		}
	}

	function bp_tab_quizzes_title() {
		// Do nothing here
	}

	function bp_tab_quizzes_content() {
		global $bp;
		learn_press_get_template( 'profile/tabs/quizzes.php', array( 'user' => learn_press_get_current_user() ) );
	}

	function bp_tab_courses_title() {
		// Do nothing here
	}

	function bp_tab_courses_content() {
		global $bp;
		switch ( $bp->current_action ) {
			case 'all':
				learn_press_profile_tab_courses_all( learn_press_get_current_user() );
				break;
			case 'learning':
				learn_press_profile_tab_courses_learning( learn_press_get_current_user() );
				break;
			case 'finished':
				learn_press_profile_tab_courses_finished( learn_press_get_current_user() );
				break;
			case 'own':
				learn_press_profile_tab_courses_own( learn_press_get_current_user() );

		}
	}

	function bp_tab_orders_title() {
		// Do nothing here
	}

	function bp_tab_orders_content() {
		learn_press_get_template( 'profile/tabs/orders.php', array( 'user' => learn_press_get_current_user() ) );
	}

	function bp_setup_courses_bar() {
		// Define the WordPress global
		global $wp_admin_bar;

		global $bp;
		$courses_slug = $this->get_tab_courses_slug();
		$courses_name = $this->get_tab_courses_name();
		$courses_link = $this->bp_get_current_link( 'courses' );
		$items        = array(
			array(
				'parent' => $bp->my_account_menu_id,
				'id'     => 'my-account-' . $courses_slug,
				'title'  => $courses_name,
				'href'   => trailingslashit( $courses_link )
			),
			array(
				'parent' => 'my-account-' . $courses_slug,
				'id'     => 'my-account-' . $courses_slug . '-all',
				'title'  => __( 'All courses', 'learnpress-buddypress' ),
				'href'   => trailingslashit( $courses_link . 'all' )
			),
			array(
				'parent' => 'my-account-' . $courses_slug,
				'id'     => 'my-account-' . $courses_slug . '-enrolled',
				'title'  => __( 'Enrolled courses', 'learnpress-buddypress' ),
				'href'   => trailingslashit( $courses_link . 'enrolled' )
			),
			array(
				'parent' => 'my-account-' . $courses_slug,
				'id'     => 'my-account-' . $courses_slug . '-own',
				'title'  => __( 'Own courses', 'learnpress-buddypress' ),
				'href'   => trailingslashit( $courses_link . 'own' )
			),
			array(
				'parent' => 'my-account-courses',
				'id'     => 'my-account-courses-quiz_results',
				'title'  => __( 'Quiz Results', 'learnpress-buddypress' ),
				'href'   => trailingslashit( $courses_link . 'quiz_results' )
			)
		);
		// Add each admin menu
		foreach ( $items as $item ) {
			$wp_admin_bar->add_menu( $item );
		}
	}

	function bp_get_current_link( $tab = 'courses' ) {

		// Determine user to use
		if ( bp_displayed_user_domain() ) {
			$user_domain = bp_displayed_user_domain();
		} elseif ( bp_loggedin_user_domain() ) {
			$user_domain = bp_loggedin_user_domain();
		} else {
			return;
		}
		$func = "get_tab_{$tab}_slug";
		if ( is_callable( array( $this, $func ) ) ) {
			$slug = call_user_func( array( $this, $func ) );
		} else {
			$slug = '';
		}
		// Link to user courses
		return trailingslashit( $user_domain . $slug );
	}

	function bp_get_link( $link, $user_id, $course_id ) {
		// Determine user to use
		if ( is_null( $user_id ) ) {
			$course  = get_post( $course_id );
			$user_id = $course->post_author;
		}
		$link = bp_core_get_user_domain( $user_id );
		return trailingslashit( $link . 'courses' );
	}

	/**
	 * Return TRUE if BuddyPress plugin is installed and active
	 *
	 * @return bool
	 */
	static function bp_is_active() {
		if ( !function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		return class_exists( 'BuddyPress' ) && is_plugin_active( 'buddypress/bp-loader.php' );
	}

	/**
	 * Load plugin text domain
	 */
	public static function load_text_domain() {
		if ( function_exists( 'learn_press_load_plugin_text_domain' ) ) {
			learn_press_load_plugin_text_domain( LP_ADDON_BP_PATH, true );
		}
	}

	public static function admin_notice() {
		?>
		<div class="error">
			<p><?php printf( __( '<strong>BuddyPress</strong> addon version %s requires LearnPress version %s or higher', 'learnpress-buddypress' ), LP_ADDON_BP_VER, LP_ADDON_BP_REQUIRE_VER ); ?></p>
		</div>
		<?php
	}

	/**
	 * Return unique instance of LP_Addon_BuddyPress_Course_Profile
	 */
	static function instance() {
		if ( !defined( 'LEARNPRESS_VERSION' ) || ( version_compare( LEARNPRESS_VERSION, LP_ADDON_BP_VER, '<' ) ) ) {
			add_action( 'admin_notices', array( __CLASS__, 'admin_notice' ) );
			return false;
		}

		if ( !self::$_instance ) {
			self::$_instance = new self();
//			self::load_text_domain();
		}
		return self::$_instance;
	}
}

add_action( 'plugins_loaded', array( 'LP_Addon_BuddyPress_Course_Profile', 'instance' ) );