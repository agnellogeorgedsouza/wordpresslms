<?php

class Carousel_Slider_Public {

	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	public function enqueue_scripts() {
		global $post;
		if( is_a( $post, 'WP_Post' ) && (has_shortcode( $post->post_content, 'carousel_slide') || has_shortcode( $post->post_content, 'carousel')) ) {
			wp_enqueue_style( 'owl-carousel', plugin_dir_url( __FILE__ ) . 'owl-carousel/owl.carousel.css', '', '2.0.0', 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ). 'owl-carousel/style.css', '', $this->version, 'all' );

			wp_enqueue_script( 'owl-carousel', plugin_dir_url( __FILE__ ). 'owl-carousel/owl.carousel.min.js', array( 'jquery' ), '2.0.0', false );
		}
	}
}
