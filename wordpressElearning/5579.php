


<head>
<style type="text/css">


body.inside-navigation { 
    border:outset 0px #000000;
    -moz-border-radius: 0px;
    -webkit-border-radius: 0px;
    border-radius: 0px;
}

#menu-primary_menu ul
{
margin: 0;
padding: 0;
list-style-type: none;
}
		
</style>
</head>
<body>
<?php
/**
 * WordPress User Page
 *
 * Handles authentication, registering, resetting passwords, forgot password,
 * and other user handling.
 *
 * @package WordPress
 */

/** Make sure that the WordPress bootstrap has run before continuing. */
require( dirname(__FILE__) . '/wp-load.php' );

?>

<div class="inside-navigation grid-container grid-parent">
<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
<span class="mobile-menu">Menu</span>
</button>


        <?php
        /**
        start
         * added by agnello for login  menu primary
         *
         */

                      wp_nav_menu(
                                array(
                                        'theme_location' => 'primary',
                                        'container' => 'div',
                                        'container_class' => 'main-nav',
                                        'container_id' => 'primary-menu',
                                        'menu_class' => '',
                                        'fallback_cb' => 'generate_menu_fallback',
                                        'items_wrap' => '<ul id="%1$s" class="%2$s ' . join( ' ', generate_get_menu_class() ) . '">%3$s</ul>'
                                )
                        );
       ?>
</div>
</body>
