<?php

class Carousel_Slider_Admin {

	private $plugin_name;

	private $version;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->includes();
		$this->metaboxs();
	}

	public function admin_submenu()
	{
		add_submenu_page(
	        'edit.php?post_type=carousels',
	        'Documentation',
	        'Documentation',
	        'manage_options',
	        'carousel-slider-documentation',
	        array( $this, 'submenu_page_callback')
        );
	}
	public function submenu_page_callback()
	{
		include 'partials/documentation.php';
	}

	public function carousel_post_type() {
		$labels = array(
			'name'                => _x( 'Carousels', 'Post Type General Name', $this->plugin_name ),
			'singular_name'       => _x( 'Carousel', 'Post Type Singular Name', $this->plugin_name ),
			'menu_name'           => __( 'Carousels', $this->plugin_name ),
			'parent_item_colon'   => __( 'Parent Carousel:', $this->plugin_name ),
			'all_items'           => __( 'All Carousels', $this->plugin_name ),
			'view_item'           => __( 'View Carousel', $this->plugin_name ),
			'add_new_item'        => __( 'Add New Carousel', $this->plugin_name ),
			'add_new'             => __( 'Add New', $this->plugin_name ),
			'edit_item'           => __( 'Edit Carousel', $this->plugin_name ),
			'update_item'         => __( 'Update Carousel', $this->plugin_name ),
			'search_items'        => __( 'Search Carousel', $this->plugin_name ),
			'not_found'           => __( 'Not found', $this->plugin_name ),
			'not_found_in_trash'  => __( 'Not found in Trash', $this->plugin_name ),
		);
		$args = array(
			'label'               => __( 'Carousel', $this->plugin_name ),
			'description'         => __( 'Carousel', $this->plugin_name ),
			'labels'              => $labels,
			'supports'            => array( 'title' ),
			'hierarchical'        => false,
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5.55525,
			'menu_icon'           => 'dashicons-slides',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite'             => false,
			'capability_type'     => 'post',
		);
		register_post_type( 'carousels', $args );
	}

	public function add_meta_box() {
	 
	    add_meta_box( 
	    	"carousel-shortcode-info", 
	    	__("Usage (Shortcode)", $this->plugin_name), 
	    	array( $this, 'render_meta_box_shortcode_info' ),
	    	"carousels",
	    	"side",
	    	"high"
	    );
	}

	public function render_meta_box_shortcode_info()
	{
	    $id = get_the_ID();

	    if ($id){

	        $id = '[carousel_slide id="'.$id.'"]';

	        echo '<p><b>'.__('Copy the following shortcode and paste in post or page where you want to show.', $this->plugin_name).'</b></p>';
	        echo '<p><pre><code>'.$id.'</code></pre></p>';
	        echo "<hr>";
	        echo '<p>'.__('If you like this plugin or if you make money using this or if you want to help me to continue my contribution on open source projects, consider to make a small donation.', $this->plugin_name).'</p>';
	        echo '<a target="_blank" href="https://sayfulit.com/donate">';
	        echo '<img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="">';
	        echo '</a>';
	    }
	}

	public function includes()
	{
		require_once 'partials/MetaBox.php';
	}

	public function metaboxs()
	{	
		$carousel_metabox = array(
		    'id' 			=> 'metabox-carousel-slide',
		    'title' 		=> __('Carousel Slider Settings', $this->plugin_name),
		    'page' 			=> array('carousels'),
		    'context' 		=> 'normal',
		    'priority' 		=> 'high',
		    'fields' 		=> array(
		        array(
		            'id' 	=> '_carousel_images',
		            'type' 	=> 'images',
		            'name' 	=> __('Carousel Images', $this->plugin_name),
		            'desc' 	=> __('Choose carousel images.', $this->plugin_name),
		        ),
		        array(
		            'id' 	=> '_image_size',
		            'type' 	=> 'image_sizes',
		            'name' 	=> __('Carousel Image Size', $this->plugin_name),
		            'desc' 	=> sprintf(__( 'Select "full" for full size image or your desired image size for carousel image. You can change the default size for thumbnail, medium and large from %1$s Settings >> Media %2$s.', $this->plugin_name ),'<a target="_blank" href="'.get_admin_url().'options-media.php">','</a>'),
		        ),
                array(
		            'id' 	=> '_items',
		            'type' 	=> 'number',
		            'name' 	=> __('Carousel items', $this->plugin_name),
		            'desc' 	=> __('To set the maximum amount of items displayed at a time with the widest browser width (window >= 1200)', $this->plugin_name),
		            'std' 	=> 4
		        ),
                array(
		            'id' 	=> '_items_small_desktop',
		            'type' 	=> 'number',
		            'name' 	=> __('Carousel items for small desktop', $this->plugin_name),
		            'desc' 	=> __('This allows you to preset the number of slides visible with (window >= 980) browser width.', $this->plugin_name),
		            'std' 	=> 4
		        ),
                array(
		            'id' 	=> '_items_portrait_tablet',
		            'type' 	=> 'number',
		            'name' 	=> __('Carousel items for portrait Tablet', $this->plugin_name),
		            'desc' 	=> __('This allows you to preset the number of slides visible with (window >= 768) browser width.', $this->plugin_name),
		            'std' 	=> 3
		        ),
                array(
		            'id' 	=> '_items_small_portrait_tablet',
		            'type' 	=> 'number',
		            'name' 	=> __('Carousel items for small portrait Tablet', $this->plugin_name),
		            'desc' 	=> __('This allows you to preset the number of slides visible with (window >= 600) browser width.', $this->plugin_name),
		            'std' 	=> 2
		        ),
                array(
		            'id' 	=> '_items_portrait_mobile',
		            'type' 	=> 'number',
		            'name' 	=> __('Carousel items for portrait Mobile', $this->plugin_name),
		            'desc' 	=> __('This allows you to preset the number of slides visible with (window >= 320) browser width.', $this->plugin_name),
		            'std' 	=> 1
		        ),
                array(
		            'id' 	=> '_slide_by',
		            'type' 	=> 'text',
		            'name' 	=> __('Slide By', $this->plugin_name),
		            'desc' 	=> __('Navigation slide by x number. Write "page" with inverted comma to slide by page. Default value is 1.', $this->plugin_name),
		            'std' 	=> 1
		        ),
                array(
		            'id' 	=> '_margin_right',
		            'type' 	=> 'number',
		            'name' 	=> __('Margin Right(px) on item.', $this->plugin_name),
		            'desc' 	=> __('margin-right(px) on item. Default value is 10. Example: 20', $this->plugin_name),
		            'std' 	=> 10
		        ),
                array(
		            'id' 	=> '_nav_button',
		            'type' 	=> 'checkbox',
		            'name' 	=> __('Display navigation buttons', $this->plugin_name),
		            'label' => __('Display "next" and "previous" buttons', $this->plugin_name),
		            'desc' 	=> __('Check to display "next" and "previous" buttons', $this->plugin_name),
		        ),
                array(
		            'id' 	=> '_dot_nav',
		            'type' 	=> 'checkbox',
		            'name' 	=> __('Show dots navigation', $this->plugin_name),
		            'label' => __('Show dots navigation.', $this->plugin_name),
		            'desc' 	=> __('Check to show dots navigation.', $this->plugin_name),
		        ),
                array(
		            'id' 	=> '_inifnity_loop',
		            'type' 	=> 'checkbox',
		            'name' 	=> __('Inifnity loop', $this->plugin_name),
		            'label' => __('Inifnity loop.', $this->plugin_name),
		            'desc' 	=> __('Check to show inifnity loop. Duplicate last and first items to get loop illusion', $this->plugin_name),
		            'std' 	=> 'on'
		        ),
                array(
		            'id' 	=> '_autoplay',
		            'type' 	=> 'checkbox',
		            'name' 	=> __('Autoplay', $this->plugin_name),
		            'label' => __('Autoplay.', $this->plugin_name),
		            'desc' 	=> __('Check to enable autoplay', $this->plugin_name),
		            'std' 	=> 'on'
		        ),
                array(
		            'id' 	=> '_autoplay_timeout',
		            'type' 	=> 'number',
		            'name' 	=> __('Autoplay Timeout', $this->plugin_name),
		            'desc' 	=> __('Autoplay interval timeout in millisecond. Default: 5000', $this->plugin_name),
		            'std' 	=> 5000
		        ),

                array(
		            'id' 	=> '_autoplay_speed',
		            'type' 	=> 'number',
		            'name' 	=> __('Autoplay Speed', $this->plugin_name),
		            'desc' 	=> __('Autoplay speen in millisecond. Default: 500', $this->plugin_name),
		            'std' 	=> 500
		        ),
                array(
		            'id' 	=> '_autoplay_pause',
		            'type' 	=> 'checkbox',
		            'name' 	=> __('Autoplay Hover Pause', $this->plugin_name),
		            'label' => __('Pause on mouse hover.', $this->plugin_name),
		            'desc' 	=> __('Pause autoplay on mouse hover.', $this->plugin_name),
		        ),
                array(
		            'id' 	=> '_nav_color',
		            'type' 	=> 'color',
		            'name' 	=> __('Navigation Color	', $this->plugin_name),
		            'desc' 	=> __('Enter hex value of color for carousel navigation.', $this->plugin_name),
		            'std' 	=> '#d6d6d6'
		        ),

                array(
		            'id' 	=> '_nav_active_color',
		            'type' 	=> 'color',
		            'name' 	=> __('Navigation Color: Hover & Active', $this->plugin_name),
		            'desc' 	=> __('Enter hex value of color for carousel navigation.', $this->plugin_name),
		            'std' 	=> '#4dc7a0'
		        ),
	        )
		);
		new \CarouselSlider\MetaBox($carousel_metabox);
	}

	public function columns_head(){
	    
	    $columns = array(
	        'cb' 		=> '<input type="checkbox">',
	        'title' 	=> __('Carousel Slide Title', $this->plugin_name),
	        'usage' 	=> __('Shortcode', $this->plugin_name),
	        'images' 	=> __('Carousel Images', $this->plugin_name)
	    );

	    return $columns;

	}


	public function columns_content($column, $post_id) {
	    switch ($column) {

	        case 'usage':

	            $id = $post_id;

	            if ( !empty($id) ){
	                echo '<pre><code>[carousel_slide id="'.$id.'"]</code></pre>';
	            }

	            break;

	        case 'images':
	        	$image_ids 	= explode(',', get_post_meta( get_the_ID(), '_wpdh_image_ids', true) );
	        	$images ='<ul id="carousel-thumbs" class="carousel-thumbs">';
				foreach ( $image_ids as $image ) {
					if(!$image) continue;
					$src = wp_get_attachment_image_src( $image, array(32,32) );
					$images .= "<li style='display:inline;margin-right:5px;'><img src='{$src[0]}' width='{$src[1]}' height='{$src[2]}'></li>";
				}
				$images .= '</ul>';
				echo $images;

	        	break;
	        default :
	            break;
	    }
	}
}
