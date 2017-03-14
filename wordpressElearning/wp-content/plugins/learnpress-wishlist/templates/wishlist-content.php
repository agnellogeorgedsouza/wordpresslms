<?php
/**
 * Template for displaying the list of course is in wishlist
 *
 * @author ThimPress
 */

defined( 'ABSPATH' ) || exit();
global $post;
?>
<li id="learn-press-tab-wishlist-course-<?php echo $post->ID;?>" data-context="tab-wishlist">
	<a href="<?php echo esc_url( get_permalink() );?>" rel="bookmark"><?php echo get_the_title();?></a>
	<?php LP_Addon_Wishlist::instance()->wishlist_button( $post->ID );?>
</li>