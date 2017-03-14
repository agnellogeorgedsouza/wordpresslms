<?php

add_action( 'admin_menu', 'lps_menu');

function lps_menu(){
	add_menu_page( 'Login Page Styler', 'Login Page Styler','manage_options', 'lps_option', 'lps_settings_page', '', 15);
	add_action( 'admin_init', 'lps_register_settings' );

}



function lps_register_settings(){
	register_setting('lps-settings-group', 'lps_login_background_color' );
	register_setting('lps-settings-group', 'lps_login_label_color' );
	register_setting('lps-settings-group', 'lps_login_nav_color');
	register_setting('lps-settings-group', 'lps_login_nav_hover_color');
	register_setting('lps-settings-group', 'lps_login_form_border_radius');
	register_setting('lps-settings-group', 'lps_login_label_size' );
	register_setting('lps-settings-group', 'lps_login_nav_link_hide' );
	register_setting('lps-settings-group', 'lps_login_logo_hide' );
	register_setting('lps-settings-group', 'lps_login_form_position' );
	register_setting('lps-settings-group', 'lps_login_form_color' );
	register_setting('lps-settings-group', 'lps_login_logo_msg_hide');
	register_setting('lps-settings-group', 'lps_login_on_off');
	register_setting('lps-settings-group', 'lps_login_blog_link_hide');
	register_setting('lps-settings-group', 'lps_login_form_input_feild_border_radius' );


	register_setting('lps-settings-group', 'lps_login_form_color_opacity');
	register_setting('lps-settings-group', 'lps_login_custom_css');
	register_setting('lps-settings-group', 'lps_login_button_border_radius');
	register_setting('lps-settings-group', 'lps_login_form_border_color');
	register_setting('lps-settings-group', 'lps_login_form_input_feild_border_color');
	register_setting('lps-settings-group', 'lps_login_remember_label_size') ;
	register_setting('lps-settings-group', 'lps_login_logo_link');
	register_setting('lps-settings-group', 'lps_login_logo_tittle');
	register_setting('lps-settings-group', 'lps_body_bg_img');
	register_setting('lps-settings-group', 'lps_login_logo');
	register_setting('lps-settings-group', 'lps_login_logo_width');
	register_setting('lps-settings-group', 'lps_login_logo_height');
	register_setting('lps-settings-group', 'lps_login_button_color');
	register_setting('lps-settings-group', 'lps_login_button_border_color');
	register_setting('lps-settings-group', 'lps_login_button_color_hover');
	register_setting('lps-settings-group', 'lps_login_button_text_color');
	register_setting('lps-settings-group', 'lps_login_button_text_color_hover');
	register_setting('lps-settings-group', 'lps_login_button_border_color_hover');
	register_setting('lps-settings-group', 'lps_login_bg_repeat');
	register_setting('lps-settings-group', 'lps_login_form_input_color_opacity');
	register_setting('lps-settings-group', 'lps_login_form_border_style');
	register_setting('lps-settings-group', 'lps_login_form_input_border_style');
	register_setting('lps-settings-group', 'lps_login_form_input_border_size');
	register_setting('lps-settings-group', 'lps_login_form_border_size');
	register_setting('lps-settings-group', 'lps_login_form_bg');
	register_setting('lps-settings-group', 'lps_login_form_label_font');
	register_setting('lps-settings-group', 'lps_login_nav_size');
  
    register_setting('lps-settings-group', 'lps_login_captcha');
    register_setting('lps-settings-group', 'rs_site_key');
    register_setting('lps-settings-group', 'rs_private_key');
  
    register_setting('lps-settings-group', 'lps_gfontlab');

    register_setting('lps-settings-group', 'lps_layout');

  register_setting('lps-settings-group', 'lps_enable_private_site');
  register_setting('lps-settings-group', 'lps_private_login_url');
  register_setting('lps-settings-group', 'lps_private_login_url2');
  

  register_setting('lps-settings-group', 'lps_enable_lim');
  


	
	
}

add_action( 'admin_enqueue_scripts', 'lps_enqueue_scripts' );
function lps_enqueue_scripts( ) {

  if ( isset( $_GET['page']) && $_GET['page'] == 'lps_option' ){
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_style( 'thickbox' );
    wp_enqueue_script( 'thickbox' );
    wp_enqueue_script( 'media-upload' );


  //wp_enqueue_style( 'custom_wp_admin_css', plugins_url('css/loginPageStylercss.css', __FILE__) );
  wp_enqueue_style( 'custom_wp_admin_css', plugins_url('css/style.css', __FILE__) );


   wp_enqueue_style('font_select',  plugins_url('fontselect.css', __FILE__ ) );

    wp_enqueue_script( 'wp-color-picker-script', plugins_url('loginPageStyler.js', __FILE__), array('wp-color-picker') );
    wp_enqueue_script( 'g-fonts-script',  plugins_url('jquery.fontselect.js' , __FILE__) );
  }
}

 function lps_settings_page(){?>
 <style type="text/css">






 </style>

 <div class="main">
  
      <input class="tabin" id="tab1" type="radio" name="tabs" checked>
      <label class="tabla" for="tab1">Styling</label>
  
      <input class="tabin" id="tab2" type="radio" name="tabs">
      <label class="tabla" for="tab2">Template</label>
  
      <input class="tabin" id="tab3" type="radio" name="tabs">
      <label class="tabla" for="tab3">Google ReCaptcha</label>

      <input class="tabin" id="tab4" type="radio" name="tabs">
      <label class="tabla" for="tab4">Login/Logout Menu Item</label>

      <input class="tabin" id="tab5" type="radio" name="tabs">
      <label class="tabla" for="tab5">Login Logout Redirect </label>
  
      <input class="tabin" id="tab6" type="radio" name="tabs">
      <label class="tabla" for="tab6">Login Protected</label>

      <input class="tabin" id="tab7" type="radio" name="tabs">
      <label class="tabla" for="tab7">Limit Login</label>

       <input class="tabin" id="tab8" type="radio" name="tabs">
      <label class="tabla" for="tab8">Blocked IP </label>
  
      <div class="content">  
        
        <div id="content1">
        
           <div class='wrap'> 
    
    <h1><?php _e('Login Page Styler')?></h1>
    <h3><strong><ul><li><?php _e('In free version you can use 30 features. ')?> </li> 
    <li> <?php _e('In  <a href=http://web-settler.com/login-page-styler/> Premium Version</a> you can use 60 features ')?></li>
    </ul></strong></h3></br>

    <strong>
    <?php _e('<a href="http://web-settler.com/login-page-styler/" target="_blank" class="button_pro">Go Premium</a>')?>
    <?php _e('<a href="https://wordpress.org/plugins/scrollbar-designer//" target="_blank" class="button_pro">Try Scrollbar Designer</a>')?>
    </strong>

    
     <h3><strong><?php _e('If you want us to Style your login page or facing any issue  contact us : ziaimtiaz21@gmail.com'); ?></strong></h3>
       <?php settings_errors(); ?>
       <form method="post" action="options.php" >
           <?php settings_fields('lps-settings-group');?>
           <div id="headings-data">

            <div id="hed3"><h3><?php _e('Login Settings') ?></h3></div>

           <table class="form-table">


        <p>Change enable switch to Yes, then plugin will take effect on your login page </p>
        <tr valign='top'>
        <th scope='row'><?php _e('Enable Plugin :');?></th>
        <td>
            <div class="onoffswitch">
                     <input type="checkbox" name="lps_login_on_off" class="onoffswitch-checkbox"  id="myonoffswitch" value='1'<?php checked(1, get_option('lps_login_on_off')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>


        </td>
      </tr>
        
      
      <tr valign='top'>
        <th scope='row'><?php _e('Hide Login Logo');?></th>
        <td>
            <div class="onoffswitch">
                     <input type="checkbox" name="lps_login_logo_hide" class="onoffswitch-checkbox"  id="myonoffswitch2" value='1'<?php checked(1, get_option('lps_login_logo_hide')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch2">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>


        </td>
      </tr>


      <tr valign='top'>
        <th scope='row'><?php _e('Hide Login Error Msg');?></th>
        <td>
            <div class="onoffswitch">
                     <input type="checkbox"   name="lps_login_logo_msg_hide" class="onoffswitch-checkbox"  id="myonoffswitch3" value='1'<?php checked(1, get_option('lps_login_logo_msg_hide')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch3">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>


        </td>
      </tr>



      <tr valign='top'>
        <th scope='row'><?php _e('Hide Lost Password Link');?></th>
        <td>
            <div class="onoffswitch">
                     <input type="checkbox" name="lps_login_nav_link_hide" class="onoffswitch-checkbox"  id="myonoffswitch4" value='1'<?php checked(1, get_option('lps_login_nav_link_hide')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch4">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                    

        </td>
      </tr>


      <tr valign='top'>
        <th scope='row'><?php _e('Hide Back to Blog Link');?></th>
        <td>
            <div class="onoffswitch">
                     <input type="checkbox" name="lps_login_blog_link_hide" class="onoffswitch-checkbox"  id="myonoffswitch5" value='1'<?php checked(1, get_option('lps_login_blog_link_hide')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitch5">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                    
        </td>
      </tr>

            
             </table>
        </div>





<div id="headings-data">
           <div id="hed3"><h3><?php _e('Logo Settings') ?></h3></div>
           <table class="form-table">

      <tr valign="top">
        <th scope="row"><?php _e('Logo Link'); ?></th>
        <td><label for="lps_login_logo_link">
          <input type="text" id="lps_login_logo_link"  name="lps_login_logo_link" size="40" value="<?php echo get_option( 'lps_login_logo_link' ); ?>"/>
          <p class="description"><?php _e( 'Enter site url eg: www.google.com ,It will redirect user when logo is clicked'); ?></p>
          </label>
       </td>
        </tr>


        <tr valign="top">
        <th scope="row"><?php _e('Logo Title'); ?></th>
        <td><label for="lps_login_logo_tittle">
          <input type="text" id="lps_login_logo_tittle"  name="lps_login_logo_tittle" value="<?php echo get_option( 'lps_login_logo_tittle' ); ?>" />
          <p class="description"><?php _e( 'Enter Tittle for logo eg:Powered by abcd. '); ?></p>
          </label>
       </td>
        </tr>


        <tr valign="top">
        <th scope="row"><?php _e('Logo Image'); ?></th>
        <td><label for="lps_login_logo">
          <input id="image_location" type="text" name="lps_login_logo" value="<?php echo get_option('lps_login_logo') ?>" size="50" />
                    <input class="onetarek-upload-button button" type="button" value="Upload Image" />
          <p class='description'><?php _e('Upload or Select Logo Image,Use 80px X 80px logo,<br>To Use bigger logo <b> <a href="http://web-settler.com/login-page-styler/">Buy Premium Version</a> </b> ') ;?></p>
         </lable>
       </td>
        </tr>


        <tr valign="top">
        <th scope="row"><?php _e('Logo Width'); ?></th>
        <td><label for="lps_login_logo_width">
          <input type='range'  id='lps_login_logo_width' name='lps_login_logo_width' min='0' disabled max='350' value='<?php echo get_option('lps_login_logo_width') ?>' oninput="this.form.amountInputW.value=this.value" /> <input type="number"  name="amountInputW" min="0" max="350" value='<?php echo get_option('lps_login_logo_width') ?>' size='4' oninput="this.form.lps_login_logo_width.value=this.value" disabled/>
          <p class="description"><?php _e( 'Slide to select  logo width. <b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
         </lable>
       </td>
        </tr>


        <tr valign="top">
        <th scope="row"><?php _e('Logo Height'); ?></th>
        <td><label for="lps_login_logo_height">
          <input type='range'  id='lps_login_logo_height' name='lps_login_logo_height' min='0' disabled max='200' value='<?php echo get_option('lps_login_logo_height') ?>' oninput="this.form.amountInputH.value=this.value" /> <input type="number"  name="amountInputH" min="0" max="200" value='<?php echo get_option('lps_login_logo_height') ?>' size='4' oninput="this.form.lps_login_logo_height.value=this.value" disabled />
          <p class="description"><?php _e( 'Slide to select  logo height .<b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
         </lable>
       </td>
        </tr>

</table></div>


<div id="headings-data">

           <div id="hed3"><h3><?php _e('Login Background Settings') ?></h3></div>
           <table class="form-table">


        <tr valign="top">
        <th scope="row"><?php _e( 'Background Color' ); ?></th>
        <td><label for="lps_login_background_color">
          <input type="text" class="color_picker" id="lps_login_background_color"  name="lps_login_background_color" value="<?php echo get_option( 'lps_login_background_color' ); ?>" />
          <p class="description"><?php _e( 'Change background color'); ?></p>
          </label>
       </td>
        </tr>


        <tr valign="top">
        <th scope="row"><?php _e('Login Background Image'); ?></th>
        <td><label for="lps_body_bg_img">
          <input id="image_location" type="text" name="lps_body_bg_img" value="<?php echo get_option('lps_body_bg_img') ?>" size="50" disabled/>
                    <input  class="onetarek-upload-button button" type="button" value="Upload Image" disabled />
          <p class='description'><?php _e('Upload or Select  Background Image,<b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a></b>') ;?></p>
        </label>
        </td>
        </tr>


            <tr valign="top">
        <th scope="row"><?php _e('Login Body Background Image Repeat'); ?></th>
        <td><label for="lps_body_bg_repeat">
          <select name='lps_login_bg_repeat'>
               <option value='no-repeat' <?php selected( get_option('lps_login_bg_repeat'),'no-repeat'); ?> >No Repeat</option>
                         <option value='repeat-x' <?php selected( get_option('lps_login_bg_repeat'),'repeat-x'); ?> >Repeat X</option>
                         <option value='repeat-y' <?php selected( get_option('lps_login_bg_repeat'),'repeat-y'); ?> >Repeat Y</option>
          </select>
          <p class="description"><?php _e('Background image repeat');?></p>
              </label>
       </td>
        </tr>
<table></div>


<div id="headings-data">

          <div id="hed3"><h3><?php _e('Form Settings') ?></h3></div>

           <table class="form-table">


        <tr valign='top'>
        <th scope='row'><?php _e('Change Login Form Position');?></th>
        <td><label for='lps_login_form_position'>
        <select name="lps_login_form_position">
          <option value='1' <?php selected( get_option('lps_login_form_position'),'1'); ?> >Middle-Center</option> 
          <option value='2' <?php selected( get_option('lps_login_form_position'),'2' ); ?> >Middle-Left</option>
          <option value='3' <?php selected( get_option('lps_login_form_position'),'3' ); ?> >Middle-Right</option>
          <option value='4' <?php selected( get_option('lps_login_form_position'),'4' ); ?> >Top-Center</option>
          <option value='5' <?php selected( get_option('lps_login_form_position'),'5' ); ?> >Top-Left</option>
          <option value='6' <?php selected( get_option('lps_login_form_position'),'6' ); ?> >Top-Right</option>
          <option value='7' <?php selected( get_option('lps_login_form_position'),'7' ); ?> >Bottom-Center</option>
          <option value='8' <?php selected( get_option('lps_login_form_position'),'8' ); ?> >Bottom-Left</option>
          <option value='9' <?php selected( get_option('lps_login_form_position'),'9' ); ?> >Bottom-Right</option>

        </select>
        <p class="description"> <?php _e('Select option to change Login Form Position'); ?></p>           
        <p class="description"> <?php _e('While using bottom positioning, Hide error msg  on top of this plugin'); ?></p>
        <p class="description"> <?php _e('While using custom template , left right and center positions will work '); ?></p>
        
        </label>
        </td>
      </tr>

            
            <tr valign="top">
        <th scope="row"><?php _e('Login Form Background Image'); ?></th>
        <td><label for="lps_login_form_bg">
          <input id="image_location" type="text" disabled size='50' name="lps_login_form_bg" value="<?php echo get_option('lps_login_form_bg'); ?>"/>
                    <input  class="onetarek-upload-button button" type="button" value="Upload Image" disabled />
          <p class='description'><?php _e('Upload or Select Form Background Image <br><b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a></b>') ;?></p>
        </label>
        </td>
        </tr>

      
      <tr>
        <th scope='row'><?php _e('Login Form Color');?></th>
        <td><label for='lps_login_form_color'>
          <input type='text' class='color_picker' id='lps_login_form_color' name='lps_login_form_color' value='<?php echo get_option('lps_login_form_color' ); ; ?>'/>
          <p class='description'><?php _e('Change Form color') ;?></p>
        </label>
        </td>
      </tr>


      <tr>
        <th scope='row'><?php _e('Login Form Color with Opacity');?></th>
        <td><label for='lps_login_form_color_opacity'>
          <input type='text' id='lps_login_form_color_opacity' name='' value='<?php echo get_option('lps_login_form_color_opacity' ); ; ?>' disabled />
          <p class='description'> <?php _e( 'Add RGBA color value eg: 255 , 255 , 255 ,0.5 last value in decimal is the Opacity .<b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
        </label>
        </td>
      </tr>


      <tr valign='top'>
        <th scope='row'><?php _e('Label Color');?></th>
        <td><label for='lps_login_label_color'>
          <input type='text' class='color_picker' id='lps_login_label_color' name='lps_login_label_color' value='<?php echo get_option('lps_login_label_color'); ?>' /> 
          <p class='description'> <?php _e( 'Change form label(Username /Password) color'); ?></p>
            </label>
          </td>
      </tr>

      <tr valign='top'>
        <th scope='row'><?php _e('Login Form Label Size');?></th>
        <td><label for='lps_login_label_size'>
          <input type='range'  id='lps_login_label_size' name='lps_login_label_size' min='14' max='30' value='<?php echo get_option('lps_login_label_size') ?>' oninput="this.form.amountInput.value=this.value" /> <input type="number"  name="amountInput" min="0" max="25" value='<?php echo get_option('lps_login_label_size') ?>' size='4' oninput="this.form.lps_login_label_size.value=this.value" />
          <p class='description'> <?php _e( 'Change form label size '); ?></p>
            </label>
          </td>
      </tr>



      <tr valign='top'>
        <th scope='row'><?php _e('Login Form  Remember Me Label Size');?></th>
        <td><label for='lps_login_remember_label_size'>
          <input type='range'  id='lps_login_remember_label_size' name='lps_login_remember_label_size'  min='12' max='25' value='<?php echo get_option('lps_login_remember_label_size') ?>' oninput="this.form.amountInput2.value=this.value" /> <input type="number"  name="amountInput2" min="12" max="25" value='<?php echo get_option('lps_login_remember_label_size') ?>'  size='4' oninput="this.form.lps_login_remember_label_size.value=this.value" /> 
          <p class='description'> <?php _e( 'Slide to change login form remember me label size .'); ?></p>
            </label>
          </td>
      </tr>


      <tr valign="top">
        <th scope="row"><?php _e('Login Form Border Style'); ?></th>
        <td>
          <label for="lps_login_form_border_size">
            <input type='range'  id='lps_login_form_border_size' name='lps_login_form_border_size' min='0' max='10' value='<?php echo get_option('lps_login_form_border_size') ?>' oninput="this.form.amountInput3.value=this.value"  /> <input type="number"  name="amountInput3" min="0" max="10" value='<?php echo get_option('lps_login_form_border_size') ?>' size='4' oninput="this.form.lps_login_form_border_size.value=this.value" />  
            <p class="description"><?php _e('Slide to change border width');?></p>
          </label>

          <label for="lps_login_form_border_style">
          <select name='lps_login_form_border_style'>
               <option value='none'   <?php selected( get_option('lps_login_form_border_style'),'none'); ?>   >None</option>
                         <option value='solid'  <?php selected( get_option('lps_login_form_border_style'),'solid'); ?>  >Solid</option>
                         <option value='dashed' <?php selected( get_option('lps_login_form_border_style'),'dashed'); ?> >Dashed</option>
                         <option value='dotted' <?php selected( get_option('lps_login_form_border_style'),'dotted'); ?> >Dotted</option>
                         <option value='double' <?php selected( get_option('lps_login_form_border_style'),'double'); ?> >Double</option>
          </select>
          <p class="description"><?php _e('Select login form border style.');?></p>
              </label>
       </td>
        </tr>


        <tr valign='top'>
        <th scope='row'><?php _e('Login Form Border Color');?></th>
        <td><label for='lps_login_form_border_color'>
          <input type='text' class='color_picker'  id='lps_login_form_border_color' name='lps_login_form_border_color' value='<?php echo get_option('lps_login_form_border_color' ); ; ?>' />
          <p class="description"><?php _e('Change login form  border color .'); ?></p>
        </label>
        </td>
      </tr>



      <tr valign='top'>
        <th scope='row'><?php _e('Login Form Border Radius');?></th>
        <td><label for='lps_login_form_border_radius'>
           <input type='range'  id='lps_login_form_border_radius' name='lps_login_form_border_radius' min='0' max='10' value='<?php echo get_option('lps_login_form_border_radius') ?>' oninput="this.form.amountInput4.value=this.value"  /> <input type="number"  name="amountInput4" min="0" max="10" value='<?php echo get_option('lps_login_form_border_radius') ?>' size='4' oninput="this.form.lps_login_form_border_size.value=this.value" />
          <p class="description"><?php _e('Slide to select Login form border radius'); ?></p>
        </label>
        </td>
      </tr>


      <tr valign="top">
        <th scope="row"><?php _e('Login Form Input Field Border Style'); ?></th>
        <td>
          <label for="lps_login_form_input_border_size">
            <input type='range'  id='lps_login_form_input_border_size' name='lps_login_form_input_border_size' min='0' max='10' value='<?php echo get_option('lps_login_form_input_border_size') ?>' oninput="this.form.amountInput5.value=this.value"  /> <input type="number"  name="amountInput5" min="0" max="10" value='<?php echo get_option('lps_login_form_input_border_size') ?>' size='4' oninput="this.form.lps_login_form_border_size.value=this.value" />  
            <p class="description"><?php _e('Slide to select Login form input-field border width');?></p>
          </label>

          <label for="lps_login_form_input_border_style">
          <select name='lps_login_form_input_border_style'>
               <option value='none'   <?php selected( get_option('lps_login_form_input_border_style'),'none'); ?>   >None</option>
                         <option value='solid'  <?php selected( get_option('lps_login_form_input_border_style'),'solid'); ?>  >Solid</option>
                         <option value='dashed' <?php selected( get_option('lps_login_form_input_border_style'),'dashed'); ?> >Dashed</option>
                         <option value='dotted' <?php selected( get_option('lps_login_form_input_border_style'),'dotted'); ?> >Dotted</option>
                         <option value='double' <?php selected( get_option('lps_login_form_input_border_style'),'double'); ?> >Double</option>
          </select>
          <p class="description"><?php _e('Select login form input field border style, <b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>');?></p>
              </label>
       </td>
        </tr>


        <tr valign='top'>
        <th scope='row'><?php _e('Login Form Input Field Border Color');?></th>
        <td><label for='lps_login_form_input_feild_border_color'>
          <input  type='text' class='color_picker' id='lps_login_form_input_feild_border_color' name='lps_login_form_input_feild_border_color' value='<?php echo get_option('lps_login_form_input_feild_border_color' ); ; ?>' />
          <p class="description"><?php _e('Change login form input field border color . '); ?></p>
        </label>
        </td>
      </tr>



      <tr valign='top'>
        <th scope='row'><?php _e('Login Form Input Field Border Radius');?></th>
        <td><label for='lps_login_form_input_feild_border_radius'>
          <input type='range'  id='lps_login_form_input_feild_border_radius' name='lps_login_form_input_feild_border_radius' min='0' max='10' value='<?php echo get_option('lps_login_form_input_feild_border_radius') ?>' oninput="this.form.amountInput7.value=this.value"  /> <input type="number"  name="amountInput7" min="0" max="10" value='<?php echo get_option('lps_login_form_input_feild_border_radius') ?>' size='4' oninput="this.form.lps_login_form_input_feild_border_radius.value=this.value" />
          <p class="description"><?php _e( 'Slide to select Login form input-field border radius . <b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b> '); ?></p>
        </label>
        </td>
      </tr>


      <tr>
        <th scope='row'><?php _e('Login Form Input Field Color with Opacity');?></th>
        <td><label for='lps_login_form_input_color_opacity'>
          <input type='text' id='lps_login_form_input_color_opacity' disabled name='lps_login_form_input_color_opacity' value='<?php echo get_option('lps_login_form_input_color_opacity' ); ; ?>'/>
          <p class='description'> <?php _e( 'Add RGBA color value eg: 255 , 255 , 255 ,0.5 last value in decimal is the Opacity . ')?></p>
        </label>
        </td>
      </tr>


</table></div>

<div id="headings-data">

            <div id="hed3"><h3><?php _e('Google Fonts') ?></h3></div>
            <table class="form-table">

             <tr valign="top">
        <th scope="row"><?php _e('Google font Label '); ?></th>
        <td><label for="google_fontlabel">
                  <input name="lps_gfontlab" id="lps_gfontlab" class="lps_labfont" type="text" value=" "/>

               </label>
               <p class="description"><?php _e( '<b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
        </td>
        </tr>

        <tr valign="top">
        <th scope="row"><?php _e('Google font Navigation Links '); ?></th>
        <td><label for="google_fontlink">
                  <input name="lps_gfontlink" id="lps_gfontlink" class="lps_linkfont" type="text" value=""/>

               </label>
               <p class="description"><?php _e( '<b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>

        </td>
        </tr>


         <tr valign="top">
        <th scope="row"><?php _e('Google font Error Messages '); ?></th>
        <td><label for="google_fontmsg">
                  <input name="lps_gfontmsg" id="lps_gfontmsg" class="lps_msgfont" type="text" value=""/>

               </label><p class="description"><?php _e( '<b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
        </td>
        </tr>


         <tr valign="top">
        <th scope="row"><?php _e('Google font Button '); ?></th>
        <td><label for="google_fontbtn">
                  <input name="lps_gfontbtn" id="lps_gfontbtn" class="lps_btnfont" type="text" value=""/>

               </label>
               <p class="description"><?php _e( '<b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
        </td>
        </tr>
                
            </table></div>

<div id="headings-data">

          <div id="hed3"><h3><?php _e('Button Settings') ?></h3></div>
            <table class="form-table">

      <tr valign='top'>
        <th scope='row'><?php _e('Login Button Border Radius');?></th>
        <td><label for='lps_login_button_border_radius'>
          <input type='range'  id='lps_login_button_border_radius' name='lps_login_button_border_radius' min='0' max='10' value='<?php echo get_option('lps_login_button_border_radius') ?>' oninput="this.form.amountInput6.value=this.value"  /> <input type="number"  name="amountInput6" min="0" max="10" value='<?php echo get_option('lps_login_button_border_radius') ?>' size='4' oninput="this.form.lps_login_button_border_radius.value=this.value" />
          <p class="description"><?php _e('Add login button border radius..'); ?></p>
        </label>
        </td>
      </tr>


  
            <tr valign='top'>
        <th scope='row'><?php _e('Login Button Color');?></th>
        <td><label for='lps_login_button_color'>
          <input type='text' class='color_picker' id='lps_login_button_color' name='lps_login_button_color' value='<?php echo get_option('lps_login_button_color'); ?>' /> 
          <p class='description'> <?php _e( 'Change login button color'); ?></p></br>
          <p class='description'><?php _e('Login Button Border Color');?></p><input type='text' class='color_picker' id='lps_login_button_border_color' name='lps_login_button_border_color' value='<?php echo get_option('lps_login_button_border_color'); ?>' /></br></br>
          <p class='description'><?php _e('Login Button Text Color');?></p><input type='text' class='color_picker' id='lps_login_button_text_color' name='lps_login_button_text_color' value='<?php echo get_option('lps_login_button_text_color'); ?>' />
            </label>
          </td>
      </tr>


      <tr valign='top'>
        <th scope='row'><?php _e('Login Button Color Hover');?></th>
        <td><label for='lps_login_button_color_hover'>
          <input type='color' class='' id='lps_login_button_color_hover' name='lps_login_button_color_hover' value='<?php echo get_option('lps_login_button_color_hover'); ?>' disabled/> 
          <p class='description'> <?php _e( 'Change login button color hover,<b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a></b>'); ?></p></br>
          <p class='description'><?php _e('Login Button Border Color Hover. <b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a></b>');?></p><input type='color' class='' id='lps_login_button_border_color_hover' name='lps_login_button_border_color_hover' value='<?php echo get_option('lps_login_button_border_color_hover'); ?>' disabled /></br></br>
          <p class='description'><?php _e('Login Button Text Color Hover. <b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a></b>');?></p><input type='color' class='' id='lps_login_button_text_color_hover' name='lps_login_button_text_color_hover' value='<?php echo get_option('lps_login_button_text_color_hover'); ?>' disabled />
            </label>
          </td>
      </tr>

</table></div>

<div id="headings-data">

          <div id="hed3"><h3><?php _e('Lost password and Back to blog ') ?></h3></div>
            <table class="form-table">


            <tr valign='top'>
        <th scope='row'><?php _e('Navigation Link Size');?></th>
        <td><label for='lps_login_nav_size'>
          <input type='range'  id='lps_login_nav_size' name='lps_login_nav_size' min='13' max='20' value='<?php echo get_option('lps_login_nav_size') ?>' oninput="this.form.amountInput8.value=this.value"  /> <input type="number"  name="amountInput8" min="13" max="20" value='<?php echo get_option('lps_login_nav_size') ?>' size='4' oninput="this.form.lps_login_nav_size.value=this.value" />
          <p class="description"><?php _e( 'Slide to select Navigation Link Size .'); ?></p>
        </label>
        </td>
      </tr> 


      <tr vlaign='top'>
        <th scope='row'><?php _e('Navigation Links Color');?></th>
        <td><label for='lps_login_nav_color'>
          <input type='text' class='color_picker' id='lps_login_nav_color' name='lps_login_nav_color' value='<?php echo get_option('lps_login_nav_color' ); ; ?>'/>
          <p class="description"><?php _e('Change navigation link color'); ?></p>
        </label>
        </td>
      </tr>

      
      <tr valign='top'>
        <th scope='row'><?php _e('Navigation Hover Links Color');?></th>
        <td><label for='lps_login_nav_hover_color'>
          <input type='text' class='color_picker' id='lps_login_nav_hover_color' name='lps_login_nav_hover_color' value='<?php echo get_option('lps_login_nav_hover_color' ); ; ?>' />
          <p class="description"><?php _e('Change navigiation link hover color '); ?></p>
        </label>
        </td>
      </tr>


</table></div>
<div id="headings-data">

          <div id="hed3"><h3><?php _e('Custom CSS') ?></h3></div>
            <table class="form-table">

            <tr valign="top">
        <th scope="row"><?php _e( 'Custom Css') ?></th>
        <td><label for="lps_login_custom_css">
          <textarea cols="80" rows="7" disabled id="lps_login_custom_css"  name="lps_login_custom_css"  > </textarea>
          <p class="description"><?php _e('Add Extra Styling In Custom Css <b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a></b>'); ?></p>
          </label>
        </td>
      </tr>



           </table></div>

           <h3><strong><?php _e('To use full features of this plugin use <a href=http://web-settler.com/login-page-styler/>Login Page Styler Premium</a>'); ?></strong></h3>
            <h3><strong><?php _e('Try my other plugin ,Click Here :<a href="https://wordpress.org/plugins/scrollbar-designer/" target="_blank">Scrollbar Designer</a>')?> </strong></h3></br>
           <p class="submit">
      <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
    </p>

</div>
        </div>
  
    
        <div id="content2">

        <div class="wrap">

         <h1><?php _e('Custom Template') ?></h1>

          
          
            <table class="form-table">

           <tr valign='top'>
            <th scope='row'><?php _e('Select Layout');?></th>
            <td>

              
               <div id='left'> 

               <label for='layout'>
              <p class="pp"style='padding:0px 0px 0px 20px ;'>None <input type="radio" name="lps_layout" id="layout" value="lay0" <?php checked('lay0' , get_option('lps_layout')) ?> /></p> 
              </label>

              </br>
              </br>

                 <label for='layout'>
              <p class="pp"style='padding:0px 0px 0px 20px ;'>Layout 1 <input type="radio" name="lps_layout" id="layout" value="lay1" <?php checked('lay1' , get_option('lps_layout')) ?> /></p> 
             <img width='500px' src='<?php echo plugins_url( 'images/scrnsht.png', __FILE__); ?>' /> </label>
              

               </br>
               <label for='layout2'>
              <p class="pp"style='padding:0px 0px 0px 20px ;'>Layout 2 <b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b> <input type="radio" disabled name="lps_layout" id="layout2" </p> 
              <img width='500px' src='<?php echo plugins_url( 'images/scrnsht1.png', __FILE__); ?>' /> </label>
              </br>


              <label for='layout3'> 
              <p class="pp"style='padding:0px 0px 0px 20px ;'>Layout 3 <b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b> <input type="radio" disabled name="lps_layout" id="layout3" </p> 
              <img width='500px' src='<?php echo plugins_url( 'images/scrnsht2.png', __FILE__); ?>' /> </label>
              
              
              </td>
            </tr>
</div>


           </table>


        <h3><strong><?php _e('To use full features of this plugin use <a href=http://web-settler.com/login-page-styler/>Login Page Styler Premium</a>'); ?></strong></h3>
            
<h3><strong><?php _e('Try my other plugin ,Click Here :<a href="https://wordpress.org/plugins/scrollbar-designer/" target="_blank">Scrollbar Designer</a>')?> </strong></h3></br>
           
          <p class="submit">
           <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </p> 
 
</div> 
        </div>


        <div id="content3">

<div class="wrap">
    
           <h1><?php _e('Security Settings / Google ReCaptcha') ?></h1>
           
           <table class="form-table">

           <p>You need to <a href="https://www.google.com/recaptcha/admin" rel="external">register you domain for free</a> and get site and secret keys to make ReCaptcha work.</p>

           <p>If you are using any other Google captch plugin on login page , Please deactivate other Google captcha plugin then Enable this captcha feature .
               Following this instruction will help prevent plugin conflicts or any other error.</p>


            <tr valign="top">
        <th scope="row"><?php _e('Site Key'); ?></th>
        <td><label for="rs_site_key">
          <input type="text" id="rs_site_key"  size="50" name="rs_site_key" value="<?php echo esc_attr(get_option('rs_site_key' )) ?>" />
          <p class="description"><?php _e( 'Enter Site Key '); ?></p>
          </label>
        </td>
        </tr>


        <tr valign="top">
        <th scope="row"><?php _e('Secret Key'); ?></th>
        <td><label for="rs_private_key">
          <input type="text" id="rs_private_key" size="50"  name="rs_private_key" value="<?php echo esc_attr(get_option( 'rs_private_key' )); ?>" />
          <p class="description"><?php _e( 'Enter Secret Key '); ?></p>
          </label>
        </td>
        </tr>


        <tr valign='top'>
                <th scope='row'><?php _e('Enable Google ReCaptcha On Login');?></th>
                <td>
                    <div class="onoffswitch">
                     <input type="checkbox" name="lps_login_captcha" class="onoffswitch-checkbox"  id="myonoffswitchcap" value='1'<?php checked(1, get_option('lps_login_captcha')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitchcap">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                </td>
            </tr>


            <tr valign='top'>
                <th scope='row'><?php _e('Enable Google ReCaptcha On Registration');?></th>
                <td>
                    <div class="onoffswitch">
                     <input  type="checkbox" name="lps_reg_captcha" class="onoffswitch-checkbox"  id="myonoffswitchcap1" value='1'<?php checked(1, get_option('lps_reg_captcha')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitchcap1">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                    <p class="description"><?php _e( '<b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
                </td>
            </tr>


            <tr valign='top'>
                <th scope='row'><?php _e('Enable Google ReCaptcha On Lost Password');?></th>
                <td>
                    <div class="onoffswitch">
                     <input  type="checkbox" name="lps_lost_captcha" class="onoffswitch-checkbox"  id="myonoffswitchcap2" value='1'<?php checked(1, get_option('lps_lost_captcha')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitchcap2">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                    <p class="description"><?php _e( '<b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
                </td>
            </tr>

</table>

<h3><strong><?php _e('To use full features of this plugin use <a href=http://web-settler.com/login-page-styler/>Login Page Styler Premium</a>'); ?></strong></h3>
            
<h3><strong><?php _e('Try my other plugin ,Click Here :<a href="https://wordpress.org/plugins/scrollbar-designer/" target="_blank">Scrollbar Designer</a>')?> </strong></h3></br>
           
          <p class="submit">
           <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </p> 

</div> 
 
        </div>


        <div id="content4">
        
       <div class="wrap">
          
           <h1><?php _e('Login Logout Menu Item') ?></h1>

           <table class="form-table">
            
            <tr valign='top'>
                <th scope='row'><?php _e('Show Login/Logout In Menu');?></th>
                <td>
                    <div class="onoffswitch">
                     <input type="checkbox" disabled name="lps_loginout_menu" class="onoffswitch-checkbox"  id="myonoffswitchmenu" value='1'<?php checked(1, get_option('lps_loginout_menu')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitchmenu">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                    <p class="description"><?php _e( 'This feature will show a login/logout menu item in your sites menu <b>Premium Feature <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
                </td>
            </tr>


           </table>
         <p class="submit">
           <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </p>

       
        </div>   

      </div>


      <div id="content5">
        
       <div class="wrap">
          
           <h1><?php _e('Login Redirect') ?></h1>

           <table class="form-table">


           <tr valign="top">
              <th scope="row"><?php _e('Redirect user after login'); ?></th>
                <td><label for="lps_redirect_users">


                 <select name="lps_redirect_users"> 
    <option selected="selected"  value=""><?php echo esc_attr( __( 'None' ) ); ?></option> 
    <?php
        $selected_page = get_option( 'lps_redirect_users' );
        $pages = get_pages(); 
        foreach ( $pages as $page ) {
           $option = '<option value="' . $page->post_name . '" ' . selected( $selected_page, $page->post_name ) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
    ?>
</select>
                     <p class="description"><?php _e( 'Select page which you want user to land on after login <b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
                     </label>
                </td>
            </tr>


            <tr valign="top">
              <th scope="row"><?php _e('Redirect user after logout'); ?></th>
                <td><label for="lps_redirectafter_users">


                 <select name="lps_redirectafter_users"> 
    <option selected="selected"  value=""><?php echo esc_attr( __( 'None' ) ); ?></option> 
    <?php
        $selected_page = get_option( 'lps_redirectafter_users' );
        $pages = get_pages(); 
        foreach ( $pages as $page ) {
           $option = '<option value="' . $page->post_name . '" ' . selected( $selected_page, $page->post_name ) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
    ?>
</select>
                     <p class="description"><?php _e( 'Select page which you want user to land on after logout <b>Premium Version <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
                     </label>
                </td>
            </tr>


           </table>
         <p class="submit">
           <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </p>

        
        </div>   

      </div>



  
        <div id="content6">

        <div class="wrap">
          
           <h1><?php _e('Login Protected Site') ?></h1>

           <table class="form-table">
            
            <tr valign='top'>
                <th scope='row'><?php _e('Enable Private Site');?></th>
                <td>
                    <div class="onoffswitch">
                     <input type="checkbox" name="lps_enable_private_site" class="onoffswitch-checkbox"  id="myonoffswitchprivatesite" value='1'<?php checked(1, get_option('lps_enable_private_site')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitchprivatesite">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                    <p class="description"><?php _e( 'This feature will make your whole site login protected site <b>Premium Feature <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
                </td>
            </tr>



            <tr valign="top">
              <th scope="row"><?php _e('Block Page Access 1'); ?></th>
                <td><label for="lps_private_login_url">


                 <select name="lps_private_login_url"> 
    <option selected="selected"  value=""><?php echo esc_attr( __( 'None' ) ); ?></option> 
    <?php
        $selected_page = get_option( 'lps_private_login_url' );
        $pages = get_pages(); 
        foreach ( $pages as $page ) {
           $option = '<option value="' . $page->post_name . '" ' . selected( $selected_page, $page->post_name ) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
    ?>
</select>
                     <p class="description"><?php _e( 'Select page which you want to be login protected '); ?></p>
                     </label>
                </td>
            </tr>


            <tr valign="top">
              <th scope="row"><?php _e('Block Page Access 2 '); ?></th>
                <td><label for="lps_private_login_url2">

                 <select name="lps_private_login_url2"> 
    <option selected="selected" disabled="disabled" value=""><?php echo esc_attr( __( 'None' ) ); ?></option> 
    <?php
        $selected_page = get_option( 'lps_private_login_url2' );
        $pages = get_pages(); 
        foreach ( $pages as $page ) {
           $option = '<option value="' . $page->post_name . '" ' . selected( $selected_page, $page->post_name ) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
    ?>
</select>
                     <p class="description"><?php _e( 'Select page which you want to be login protected '); ?></p>
                     </label>
                </td>
            </tr>



            <tr valign="top">
              <th scope="row"><?php _e(' Block Page Access 3'); ?></th>
                <td><label for="lps_private_login_url3">

                 <select name="lps_private_login_url3"> 
    <option selected="selected" disabled="disabled" value=""><?php echo esc_attr( __( 'None' ) ); ?></option> 
    <?php
        $selected_page = get_option( 'lps_private_login_url3' );
        $pages = get_pages(); 
        foreach ( $pages as $page ) {
           $option = '<option value="' . $page->post_name . '" ' . selected( $selected_page, $page->post_name ) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
    ?>
</select>
                     <p class="description"><?php _e( 'Select page which you want to be login protected.<b>Premium feature <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
                     </label>
                </td>
            </tr>



            <tr valign="top">
              <th scope="row"><?php _e('Block Page Access 4'); ?></th>
                <td><label for="lps_private_login_url4">

                 <select name="lps_private_login_url4"> 
    <option selected="selected" disabled="disabled" value=""><?php echo esc_attr( __( 'None' ) ); ?></option> 
    <?php
        $selected_page = get_option( 'lps_private_login_url4' );
        $pages = get_pages(); 
        foreach ( $pages as $page ) {
           $option = '<option value="' . $page->post_name . '" ' . selected( $selected_page, $page->post_name ) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
    ?>
</select>
                     <p class="description"><?php _e( 'Select page which you want to be login protected.<b>Premium feature <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
                     </label>
                </td>
            </tr>



            <tr valign="top">
              <th scope="row"><?php _e('Block Page Access 5'); ?></th>
                <td><label for="lps_private_login_url5">

                 <select name="lps_private_login_url5"> 
    <option selected="selected" disabled="disabled" value=""><?php echo esc_attr( __( 'None' ) ); ?></option> 
    <?php
        $selected_page = get_option( 'lps_private_login_url5' );
        $pages = get_pages(); 
        foreach ( $pages as $page ) {
           $option = '<option value="' . $page->post_name . '" ' . selected( $selected_page, $page->post_name ) . '>';
            $option .= $page->post_title;
            $option .= '</option>';
            echo $option;
        }
    ?>
</select>
                     <p class="description"><?php _e( 'Select page which you want to be login protected. <b>Premium feature <a href="http://web-settler.com/login-page-styler/">Unlock Here</a> </b>'); ?></p>
                     </label>
                </td>
            </tr>
 


           </table>

        <p class="submit">
           <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </p>

        
        </div>


        </div>



      
      <div id="content7">
        
       <div class="wrap">
          
           <h1><?php _e('Limit Login Security') ?></h1>

           <table class="form-table">


        <tr valign='top'>
        <th scope='row'><?php _e('Enable Limit Login Security');?></th>
        <td>
            <div class="onoffswitch">
                     <input type="checkbox"  name="lps_enable_lim" class="onoffswitch-checkbox"  id="myonoffswitchl" value='1'<?php checked(1, get_option('lps_enable_lim')); ?> />
                     <label class="onoffswitch-label" for="myonoffswitchl">
                     <span class="onoffswitch-inner"></span>
                     <span class="onoffswitch-switch"></span>
                     </label>
                    </div>
                    <p class="description"><?php _e( 'Select Yes to Enable limit login on your login page '); ?></p>

        </td>
        </tr>   


        <tr valign="top">
        <th scope="row"><?php _e('Login Attempts'); ?></th>
        <td><label for="lps_login_attempts">
          <input type="number" id="lps_login_attempts" placeholder="2" disabled name="lps_login_attempts" size="40" value=""/> Attempts.
          <p class="description"><?php _e( 'Number of Attempts before login lockdown.'); ?></p>
          </label>
        </td>
        </tr>


         <tr valign="top">
        <th scope="row"><?php _e('Attempts With In '); ?></th>
        <td><label for="lps_attempts_within">
          <input type="number" id="lps_attempts_within" placeholder="1" disabled name="lps_attempts_within" size="40" value=""/> Minutes
          <p class="description"><?php _e( ' Failed Attempts within this time period will be blocked.'); ?></p>
          </label>
        </td>
        </tr>


        <tr valign="top">
        <th scope="row"><?php _e('Lockdown Time'); ?></th>
        <td><label for="lps_lock_time">
          <input type="number" id="lps_lock_time" placeholder="2" disabled name="lps_lock_time" size="40" value=""/> Minutes
          <p class="description"><?php _e(' Time period to block an IP to rety the Login Attempts  '); ?></p>
          </label>
        </td>
        </tr>

        </table>

        <p class="description"><?php _e( '<b> The options are pre-set to change this values to your values <a href="http://web-settler.com/login-page-styler/">Buy Premium</a>    </b>'); ?></p>

         <p class="submit">
           <input type="submit" class="button-primary" value="<?php _e( 'Save Changes' ); ?>" />
          </p>

        </form>
        </div>   

      </div>




        <div id="content8">
       
       <div class="wrap">
    
           <h1><?php _e('Limit Login  Blocked Ip') ?></h1>

<?php
  global $wpdb;
  $table_name = $wpdb->prefix . "lps_lockdowns";

if (isset($_POST['release_lockdowns'])) {

    if (isset($_POST['releaseme'])) {
      $released = $_POST['releaseme'];
      foreach ( $released as $release_id ) {
        $releasequery = "UPDATE $table_name SET lpsrelease_date = now() " .
              "WHERE lpslockdown_ID = '%d'";
        $releasequery = $wpdb->prepare($releasequery,$release_id);
        $results = $wpdb->query($releasequery);
      }
    }
}

?>

        <form method="post" action="<?php echo esc_attr($_SERVER["REQUEST_URI"]); ?>">


<h3><?php 
$dalist = lps_listLockedDown();
if( count($dalist) == 1 ) {
  printf( esc_html__( 'There is currently %d locked out IP address.', 'loginlockdown' ), count($dalist) ); 

} else {
  printf( esc_html__( 'There are currently %d locked out IP addresses.', 'loginlockdown' ), count($dalist) ); 
} ?></h3>

<?php
  $num_lockedout = count($dalist);
  
  if( 0 == $num_lockedout ) {
    echo "<p>No IP blocks currently locked out.</p>";
  } else {
    foreach ( $dalist as $key => $option ) {
      ?>

<li><input type="checkbox" name="releaseme[]" value="<?php echo esc_attr($option['lpslockdown_ID']); ?>"> <?php echo esc_attr($option['lpslockdown_IP']); ?> Country: (<?php echo  $tags ?> )  (<?php echo esc_attr($option['minutes_left']); ?> minutes left   )</li>
      <?php
    }
  }
?>
<p class="submit">
<input type="submit" class="button button-primary" name="release_lockdowns" value="<?php _e('Release Selected', 'loginlockdown') ?>" /></>
</form>
        </div> 
               </div>
      

      </div>
  
</div>
                  




<?php }; ?>
