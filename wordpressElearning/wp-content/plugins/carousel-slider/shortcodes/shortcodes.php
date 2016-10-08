<?php

function carousel_slider_wrapper_shortcode($atts, $content=null){

    extract(shortcode_atts(array(
        'id'                    => rand(1, 10),
        'items'                 => '4',
        'items_desktop'         => '4',
        'items_desktop_small'   => '3',
        'items_tablet'          => '2',
        'items_mobile'          => '1',
        'auto_play'             => 'true',
        'stop_on_hover'         => 'true',
        'navigation'            => 'true',
        'pagination'            => 'false',
        'nav_color'             => '#d6d6d6',
        'nav_active_color'      => '#4dc7a0',
        'margin_right'          => '10',
        'inifnity_loop'         => 'true',
        'autoplay_timeout'      => '5000',
        'autoplay_speed'        => '500',
        'slide_by'              => '1',
    ), $atts));

    $html  = '';
    $html .= '<div id="spic" class="row">';
    $html .= '<div id="spic-'.$id.'" class="owl-carousel">';
    $html .= do_shortcode($content);
    $html .= '</div>';
    $html .= '<style type="text/css">
                #spic-'.$id.'.owl-theme .owl-dots .owl-dot span,
                #spic-'.$id.'.owl-theme .owl-nav [class*="owl-"]:first-child,
                #spic-'.$id.'.owl-theme .owl-nav [class*="owl-"]:last-child {
                    background-color: '.$nav_color.';
                }
                #spic-'.$id.'.owl-theme .owl-dots .owl-dot.active span,
                #spic-'.$id.'.owl-theme .owl-dots .owl-dot:hover span,
                #spic-'.$id.'.owl-theme .owl-nav [class*="owl-"]:first-child:hover,
                #spic-'.$id.'.owl-theme .owl-nav [class*="owl-"]:last-child:hover {
                    background-color: '.$nav_active_color.';
                }
            </style>';

    $html .='<script type="text/javascript">
            jQuery(document).ready(function($) {
                $(\'#spic-'.$id.'\').owlCarousel({
                    nav : '.$navigation.',
                    dots: '.$pagination.',
                    margin:'.$margin_right.',
                    loop :'.$inifnity_loop.',
                    autoplay: '.$auto_play.',
                    autoplayTimeout: '.$autoplay_timeout.',
                    autoplaySpeed: '.$autoplay_speed.',
                    autoplayHoverPause: '.$stop_on_hover.',
                    slideBy: '.$slide_by.',
                    responsiveClass:true,
                    responsive:{
                        320:{ items:'.$items_mobile.' },
                        600:{ items:'.$items_tablet.' },
                        768:{ items:'.$items_desktop_small.' },
                        980:{ items:'.$items_desktop.' },
                        1200:{ items:'.$items.' }
                    }
                });
            });
            </script>';
    $html .='</div>';
    return $html;
}
add_shortcode( 'carousel', 'carousel_slider_wrapper_shortcode' );

function sis_carousel_shortcode( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'img_link' =>'',
        'href' =>'',
        'target' =>'_self',
    ), $atts));

    if ($href != '') {
        return '<div class=""><a target="'.$target.'" href="'.$href.'"><img src="'.$img_link.'"></a></div>';
    } else {
        return '<div class=""><img src="'.$img_link.'"></div>';
    }
}
add_shortcode( 'item', 'sis_carousel_shortcode' );

add_filter('widget_text', 'do_shortcode');

function carousel_slide_shortcode($atts, $content = null)
{
    extract(shortcode_atts(array(
                    'id' =>'',
            ), $atts));

    $attachment_ids = get_post_meta( $id, '_wpdh_image_ids', true );
    // convert string into array
    $attachment_ids = explode( ',', $attachment_ids );
    // clean the array (remove empty values)
    $attachment_ids = array_filter( $attachment_ids );

    if ( $attachment_ids ) {
        $_items_small_desktop           = get_post_meta( $id, '_items_small_desktop', true );
        $_items_portrait_tablet         = get_post_meta( $id, '_items_portrait_tablet', true );
        $_items_small_portrait_tablet   = get_post_meta( $id, '_items_small_portrait_tablet', true );
        $_items_portrait_mobile         = get_post_meta( $id, '_items_portrait_mobile', true );
        $_items             = get_post_meta( $id, '_items', true );
        $_image_size        = get_post_meta( $id, '_image_size', true );
        $_slide_by          = get_post_meta( $id, '_slide_by', true );
        $_margin_right      = get_post_meta( $id, '_margin_right', true );
        $_nav_button        = get_post_meta( $id, '_nav_button', true );
        $_nav_button        = ($_nav_button == 'on') ? 'true' : 'false';
        $_dot_nav           = get_post_meta( $id, '_dot_nav', true );
        $_dot_nav           = ($_dot_nav == 'on') ? 'true' : 'false';
        $_inifnity_loop     = get_post_meta( $id, '_inifnity_loop', true );
        $_inifnity_loop     = ($_inifnity_loop == 'on') ? 'true' : 'false';
        $_autoplay          = get_post_meta( $id, '_autoplay', true );
        $_autoplay          = ($_autoplay == 'on') ? 'true' : 'false';
        $_autoplay_timeout  = get_post_meta( $id, '_autoplay_timeout', true );
        $_autoplay_speed    = get_post_meta( $id, '_autoplay_speed', true );
        $_autoplay_pause    = get_post_meta( $id, '_autoplay_pause', true );
        $_autoplay_pause    = ($_autoplay_pause == 'on') ? 'true' : 'false';
        $_nav_color         = get_post_meta( $id, '_nav_color', true );
        $_nav_active_color  = get_post_meta( $id, '_nav_active_color', true );

        $html  = '';
        $html .= '<div id="spic" class="row">';
        $html .='<div id="spic-'.$id.'" class="owl-carousel">';

            foreach ( $attachment_ids as $attachment_id ) {

                $image = wp_get_attachment_image( $attachment_id, $_image_size, 0, array( 'alt' => trim( strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ) ) ) );

                $image_url = wp_get_attachment_image_src( $attachment_id, 'full' );
                $image_title = get_post( $attachment_id )->post_title ? get_post( $attachment_id )->post_title : '';
                $image_caption = get_post( $attachment_id )->post_excerpt ? get_post( $attachment_id )->post_excerpt : '';
                $image_description = get_post( $attachment_id )->post_content ? get_post( $attachment_id )->post_content : '';

                
                if (!filter_var($image_description, FILTER_VALIDATE_URL) === false) {
                        $html .='<div><a href="'.$image_description.'">'.$image.'</a></div>';
                } else {
                        $html .='<div>'.$image.'</div>';
                }
            }
        $html .= '</div>';
        $html .= '<style type="text/css">
                    #spic-'.$id.'.owl-theme .owl-dots .owl-dot span,
                    #spic-'.$id.'.owl-theme .owl-nav [class*="owl-"]:first-child,
                    #spic-'.$id.'.owl-theme .owl-nav [class*="owl-"]:last-child {
                        background-color: '.$_nav_color.';
                    }
                    #spic-'.$id.'.owl-theme .owl-dots .owl-dot.active span,
                    #spic-'.$id.'.owl-theme .owl-dots .owl-dot:hover span,
                    #spic-'.$id.'.owl-theme .owl-nav [class*="owl-"]:first-child:hover,
                    #spic-'.$id.'.owl-theme .owl-nav [class*="owl-"]:last-child:hover {
                        background-color: '.$_nav_active_color.';
                    }
                </style>';

        $html .='<script type="text/javascript">
                jQuery(document).ready(function($) {
                    $(\'#spic-'.$id.'\').owlCarousel({
                        nav : '.$_nav_button.',
                        dots: '.$_dot_nav.',
                        margin:'.$_margin_right.',
                        loop :'.$_inifnity_loop.',
                        autoplay: '.$_autoplay.',
                        autoplayTimeout: '.$_autoplay_timeout.',
                        autoplaySpeed: '.$_autoplay_speed.',
                        autoplayHoverPause: '.$_autoplay_pause.',
                        slideBy: '.$_slide_by.',
                        responsiveClass:true,
                        responsive:{
                            320:{ items:'.$_items_portrait_mobile.' },
                            600:{ items:'.$_items_portrait_tablet.' },
                            768:{ items:'.$_items_portrait_tablet.' },
                            980:{ items:'.$_items_small_desktop.' },
                            1200:{ items:'.$_items.' }
                        }
                    });
                });
                </script>';
        $html .='</div>';

        return $html;
    }
}
add_shortcode('carousel_slide', 'carousel_slide_shortcode');