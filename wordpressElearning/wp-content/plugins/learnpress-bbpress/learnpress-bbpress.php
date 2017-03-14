<?php
/*
Plugin Name: LearnPress - bbPress Integration
Plugin URI: http://thimpress.com/learnpress
Description: Using the forum for courses provided by bbPress
Author: ThimPress
Version: 2.0
Author URI: http://thimpress.com
Tags: learnpress, lms
Text Domain: learnpress-bbpress
Domain Path: /languages/
*/

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'LP_ADDON_BBPRESS_FILE', __FILE__ );
define( 'LP_ADDON_BBPRESS_PATH', dirname( __FILE__ ) );

/**
 * Class LP_Addon_BBPress_Forum
 */
class LP_Addon_BBPress_Course_Forum {

	/**
	 * @var null
	 */
	protected static $_instance = null;

	/**
	 * @var bool
	 */
	protected $_start_forum = false;

	/**
	 * LP_Addon_BBPress_Course_Forum constructor.
	 */
	function __construct() {
		if ( self::bbpress_is_active() ) {
			$this->_init_hooks();
		}
	}

	/**
	 * Init hooks
	 */
	private function _init_hooks() {

		add_action( 'add_meta_boxes', array( $this, 'meta_box' ) );
		//add_action( 'post_comment_status_meta_box-options', array( $this, 'meta_box_options' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
		add_action( 'before_delete_post', array( $this, 'remove_forum' ) );

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'init', array( __CLASS__, 'load_text_domain' ) );

		//
		add_action( 'bbp_template_before_single_topic', array( $this, 'before_single_forum' ) );
		add_action( 'bbp_template_before_single_forum', array( $this, 'before_single_forum' ) );
		add_action( 'bbp_template_after_single_topic', array( $this, 'after_single_forum' ) );
		add_action( 'bbp_template_after_single_forum', array( $this, 'after_single_forum' ) );

		add_action( 'learn_press_after_single_course_summary', array( $this, 'forum_link' ) );
	}

	function remove_forum( $course_id ) {
		$forum_id = get_post_meta( $course_id, '_lp_course_forum', true );
		if ( !$forum_id ) {
			return;
		}
		remove_action( 'before_delete_post', array( $this, 'remove_forum' ) );
		wp_delete_post( $forum_id );
	}

	function meta_box() {
		add_meta_box( 'course-forum-id', __( 'Course Forum', 'learnpress-bbpress' ), array( $this, 'meta_box_options' ), 'lp_course', 'advanced', 'high' );
	}

	function forum_link() {
		$course = LP()->course;
		$user   = LP()->user;
		if ( !$course ) {
			return;
		}
		$course_forum = $course->course_forum;
		if ( !$course_forum ) {
			return;
		}
		$post_forum = get_post( $course_forum );
		if ( !$post_forum || !in_array( $post_forum->post_type, array( 'topic', 'forum' ) ) ) {
			return;
		}
		if ( !$this->can_access_forum( $post_forum->ID, $post_forum->post_type ) ) {
			return;
		}
		global $post;
		$post = $post_forum;
		setup_postdata( $post );
		learn_press_get_template( 'forum-link.php', null, learn_press_template_path() . '/addons/bbpress/', LP_ADDON_BBPRESS_PATH . '/templates/' );
		wp_reset_postdata();
	}

	/**
	 * Process limit access forum
	 */
	function before_single_forum() {
		global $post;
		if ( !$this->can_access_forum( $post->ID, $post->post_type ) ) {
			$this->_start_forum = true;
			ob_start();
		}
	}

	/**
	 * Restrict forum content
	 */
	function after_single_forum() {
		global $post;
		if ( $this->_start_forum ) {
			ob_end_clean();
			//wp_enqueue_style( 'lp-dashicons', get_site_url() . '/wp-includes/css/dashicons.css' );
			echo '<div id="restrict-access-form-message">';
			echo '<p>' . __( 'You have to enroll the respective course!', 'learnpress-bbpress' ) . '</p>';
			if ( $course_id = $this->get_forum_course( $post->ID ) ) {
				echo '<p>' . sprintf( __( 'Go back to %s', 'learnpress-bbpress' ), '<a href="' . get_permalink( $course_id ) . '"> ' . get_the_title( $course_id ) . '!</a>' ) . '</p>';
			}
			echo '</div>';
		}
	}

	function enqueue_assets() {
		wp_enqueue_style( 'bbpress-admin', plugins_url( '/', LP_ADDON_BBPRESS_FILE ) . 'assets/style.css' );
	}

	function bbpress_require( $file ) {
		if ( !function_exists( ABSPATH . "wp-content/plugins/buddypress/{$file}" ) ) {
			return;
		}
		require_once ABSPATH . "wp-content/plugins/buddypress/{$file}";
	}

	/**
	 * Return true if a forum is public
	 *
	 * @param $forum_id
	 *
	 * @return bool
	 */
	function is_public_forum( $forum_id ) {
		$restrict = get_post_meta( $forum_id, '_lp_bbpress_forum_enrolled_user', true );
		if ( is_null( $restrict ) || ( $restrict === false ) || ( $restrict == '' ) ) {
			$restrict = false;
		} else {
			$restrict = true;
		}
		return !$restrict;
	}

	/**
	 * Add new settings to meta box of course
	 *
	 * @param $post
	 */
	function meta_box_options( $post ) {
		if ( get_post_type() != 'lp_course' ) {
			return;
		}
		$enable_forum = get_post_meta( $post->ID, '_lp_bbpress_forum_enable', true );

		if ( is_null( $enable_forum ) || ( $enable_forum === false ) || $enable_forum == '' ) {
			$enable_forum = 'no';
		} else {
			$enable_forum = 'yes';
		}

		$restrict = $this->is_public_forum( $post->ID ) ? 'no' : 'yes';

		$this->bbpress_require( "bp-forums/bbpress/bb-includes/functions.bb-forums.php" );
		$this->bbpress_require( "bp-forums/bbpress/bb-includes/functions.bb-template.php" );

		$forum_id = get_post_meta( $post->ID, '_lp_course_forum', true );
		if ( !$forum_id ) {
			$forum_title = get_the_title( $post->ID ) . __( ' Forum', 'learnpress-bbpress' );
		} else {
			$forum_title = '';
		}
		?>
		<br />
		<label for="bbpress_forum_enable" class="selectit"><input name="bbpress_forum_enable" type="checkbox" id="bbpress_forum_enable" value="yes" <?php checked( $enable_forum, 'yes' ); ?> /> <?php _e( 'Enable bbPress forum for this course.', 'learnpress-bbpress' ); ?>
		</label>
		<div id="bbpress-forum-settings" class="<?php echo $enable_forum != 'yes' ? 'hide-if-js' : ''; ?>">
			<?php /*
			<p id="bbpress-forum-select">
				<?php bbp_dropdown( array(
					'post_type'          => bbp_get_forum_post_type(),
					'selected'           => get_post_meta( $post->ID, '_lp_course_forum', true ),
					'numberposts'        => - 1,
					'orderby'            => 'title',
					'order'              => 'ASC',
					'walker'             => '',
					'exclude'            => '',

					// Output-related
					'select_id'          => '_lp_course_forum',
					'tab'                => bbp_get_tab_index(),
					'options_only'       => false,
					'show_none'          => __( '--- Select existing forum or create a new one ---', 'learnpress-bbpress' ),
					'disable_categories' => false,
					'disabled'           => ''
				) ); ?>
				<input type="text" value="<?php echo $forum_title; ?>" id="bbpress_forum_create_new" name="bbpress_forum_create_new" placeholder="<?php _e( 'Enter new forum name', 'learnpress-bbpress' ); ?>" />
			</p>*/ ?>
			<?php if ( $forum_id ): ?>
				<p>
					<strong><?php _e( 'Course forum: ', 'learnpress-bbpress' ); ?></strong><a href="<?php echo get_the_permalink( $forum_id ); ?>"><?php echo get_the_title( $forum_id ); ?></a>
				</p>
			<?php else: ?>
				<p>
					<?php _e( 'Save course to create forum', 'learnpress-bbpress' ); ?>
				</p>
			<?php endif; ?>
			<p>
				<label for="bbpress_forum_enrolled_user" class="selectit">
					<input name="bbpress_forum_enrolled_user" type="checkbox" id="bbpress_forum_enrolled_user" value="yes" <?php checked( $restrict, 'yes' ); ?> />
					<?php _e( 'Only user enrolled course can access this forum.', 'learnpress-bbpress' ); ?>
				</label>
			</p>
		</div>
		<script type="text/javascript">
			jQuery(function ($) {
				$('#bbpress_forum_enable').change(function () {
					$('#bbpress-forum-settings').toggleClass('hide-if-js', !this.checked);
				});

				$('#_lp_course_forum').change(function () {
					$('#bbpress_forum_create_new').prop('disabled', this.value != '');
				}).trigger('change');
			});
		</script>
		<?php
	}

	/**
	 * Process ability to access forum
	 *
	 * @param $id
	 * @param $type
	 *
	 * @return bool
	 */
	function can_access_forum( $id, $type ) {

		// Case: user is Admin, Moderator or Key Master

		if ( current_user_can( 'manage_options' ) || current_user_can( 'bbp_moderator' ) || current_user_can( 'bbp_keymaster' ) ) {
			return true;
		}

		// Case: invalid forum
		if ( !$id ) {
			return false;
		}

		$course_id = 0;
		$forum_id  = $id;
		if ( $type == 'forum' ) {
			$course_id = $this->get_forum_course( $id );
		} elseif ( $type == 'topic' ) {
			$forum_id = get_post_meta( $id, '_bbp_forum_id', true );
			if ( !empty( $forum_id ) ) {
				$course_id = $this->get_forum_course( $forum_id );
			}
		}
		// Case: a normal forum which has no connecting with any courses
		if ( !$course_id || $this->is_public_forum( $course_id ) ) {
			return true;
		}

		$course = LP_Course::get_course( $course_id );

		$is_required = $course->is_require_enrollment();
		// Case: no required course
		if ( !$is_required ) {
			return true;
		}

		$user = learn_press_get_current_user();
		// Case: invalid user or post
		if ( !$user->id ) {
			return false;
		}

		// Case: user is the course author
		$object = get_post( $course_id );
		if ( $user->id == $object->post_author ) {
			return true;
		}

		// Case: users haven't enrolled any one
		if ( $user->has_enrolled_course( $course_id ) ) {
			return true;
		}

		return false;
	}

	function get_forum_course( $forum_id ) {
		global $wpdb;
		static $forum_courses = array();
		if ( empty( $forum_courses[$forum_id] ) ) {
			if ( get_post_type( $forum_id ) == 'topic' ) {
				$forum_id = get_post_meta( $forum_id, '_bbp_forum_id', true );
			}
			if ( $forum_id ) {
				$query                    = $wpdb->prepare( "
					SELECT c.ID
					FROM {$wpdb->posts} c
					INNER JOIN {$wpdb->postmeta} cm ON cm.post_id = c.ID AND cm.meta_key = %s AND cm.meta_value = %d
					INNER JOIN {$wpdb->posts} f ON f.ID = cm.meta_value
					WHERE f.ID = %d
				", '_lp_course_forum', $forum_id, $forum_id );
				$forum_courses[$forum_id] = $wpdb->get_var( $query );
			}
		}
		return !empty( $forum_courses[$forum_id] ) ? $forum_courses[$forum_id] : 0;
	}

	function save_post( $post_id ) {
		if ( get_post_type() != 'lp_course' || wp_is_post_revision( $post_id ) ) {
			return;
		}
		remove_action( 'save_post', array( $this, 'save_post' ) );
		$course = get_post( $post_id );
		if ( !empty( $_REQUEST['bbpress_forum_enable'] ) ) {
			update_post_meta( $post_id, '_lp_bbpress_forum_enable', 'yes' );
			$forum_id = get_post_meta( $post_id, '_lp_course_forum', true );
			if ( !$forum_id ) {
				$new_forum = array(
					'post_title'   => $course->post_title,
					'post_content' => __( 'Forum of course "' . $course->post_title . '"', 'learnpress-bbpress' ),
					'post_author'  => $course->post_author,
				);
				remove_action( 'save_post', array( $this, 'save_post' ) );
				$forum_id = bbp_insert_forum( $new_forum, array() );
				update_post_meta( $post_id, '_lp_course_forum', $forum_id );
			}

		} else {
			//delete_option( 'bbpress_forum_enable' );
			delete_post_meta( $post_id, '_lp_bbpress_forum_enable' );
			//delete_post_meta( $post_id, '_lp_course_forum' );
		}
		/*if ( !empty( $_REQUEST['bbpress_forum_create_new'] ) ) {
			$new_forum                    = array(
				'post_title'   => $_REQUEST['bbpress_forum_create_new'],
				'post_content' => __( '', 'learnpress-bbpress' ),
				'post_author'  => $course->post_author,
			);
			$forum_id                     = bbp_insert_forum( $new_forum, array() );
			$_REQUEST['_lp_course_forum'] = $forum_id;
		}
		if ( !empty( $_REQUEST['_lp_course_forum'] ) ) {
			update_post_meta( $post_id, '_lp_course_forum', $_REQUEST['_lp_course_forum'] );
		} else {
			delete_post_meta( $post_id, '_lp_course_forum' );
		}*/

		if ( !empty( $_REQUEST['bbpress_forum_enrolled_user'] ) ) {
			update_post_meta( $post_id, '_lp_bbpress_forum_enrolled_user', 'yes' );
		} else {
			delete_post_meta( $post_id, '_lp_bbpress_forum_enrolled_user' );
		}
	}

	/**
	 * Return TRUE if bbPress plugin is installed and active
	 *
	 * @return bool
	 */
	static function bbpress_is_active() {
		if ( !function_exists( 'is_plugin_active' ) ) {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}
		return class_exists( 'bbPress' ) && is_plugin_active( 'bbpress/bbpress.php' );
	}

	/**
	 * Load plugin text domain
	 */
	public static function load_text_domain() {
		if ( function_exists( 'learn_press_load_plugin_text_domain' ) ) {
			learn_press_load_plugin_text_domain( LP_ADDON_BBPRESS_PATH, true );
		}
	}

	/**
	 * Return unique instance of LP_Addon_BBPress_Forum
	 */
	static function instance() {
		if ( !self::$_instance ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
}

add_action( 'learn_press_ready', array( 'LP_Addon_BBPress_Course_Forum', 'instance' ) );