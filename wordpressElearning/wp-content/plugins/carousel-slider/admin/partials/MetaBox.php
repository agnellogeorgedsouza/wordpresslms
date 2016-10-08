<?php
namespace CarouselSlider;

class MetaBox {

    private $fields;

	public function __construct($fields){
        $this->fields = $fields;
        add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );
		add_action( 'save_post', array( &$this, 'save_meta_box' ) );
        add_action( 'wp_ajax_save_images', array( &$this, 'save_images' ) );
        add_action( 'admin_enqueue_scripts', array( &$this, 'metabox_scripts' ) );
        add_action( 'admin_head', array( &$this, 'admin_head' ) );
	}

    /**
     * Add a custom meta box
     * 
     * @method add_meta_boxes
     */
    public function add_meta_boxes()
    {
        if( !is_array( $this->fields ) ) return false;
        add_meta_box(
            $this->fields['id'],
            $this->fields['title'],
            array( $this, 'meta_box_callback' ),
            $this->fields['page'],
            $this->fields['context'],
            $this->fields['priority'],
            $this->fields
        );
    }


    /**
     * Prints out the HTML for the edit screen section.
     * @method meta_box_callback
     * @param  string   $post   name of post type
     * @param  array $form_fields Arguments to pass into your callback function.
     *
     * @return string
     */
    public function meta_box_callback($post, $form_fields)
    {
        if( !is_array( $form_fields) ) return false;

        wp_nonce_field( basename(__FILE__), 'wpdh_meta_box_nonce' );

        echo '<table class="form-table">';

        foreach( $form_fields['args']['fields'] as $field ){

            $meta_id    = (isset($field['id'])) ? $field['id'] : strtolower(str_replace(' ', '_', $field['name']));
            $meta_name  = $this->fields['id'] . '_meta['.$meta_id. ']';
            $meta       = get_post_meta( $post->ID, $meta_id, true );
            $std        = (isset($field['std'])) ? $field['std'] : '';
            $value      = $meta ? $meta : $std;
            $desc       = (isset($field['desc'])) ? $field['desc'] : '';
            $type       = (isset($field['type'])) ? $field['type'] : 'text';

            echo sprintf('<tr><th><label for="%1$s"><strong>%2$s</strong></label></th>', $meta_id, $field['name']);

            switch( $type ){
                case 'text':
                    echo sprintf('<td><input type="text" name="%1$s" id="%2$s" value="%3$s" class="regular-text">',$meta_name, $meta_id, $value);
                break;

                case 'email':
                    echo sprintf('<td><input type="email" name="%1$s" id="%2$s" value="%3$s" class="regular-text">',$meta_name, $meta_id, $value);
                break;

                case 'number':
                    echo sprintf('<td><input type="number" name="%1$s" id="%2$s" value="%3$s" class="regular-text">',$meta_name, $meta_id, $value);
                break;

                case 'url':
                    echo sprintf('<td><input type="url" name="%1$s" id="%2$s" value="%3$s" class="regular-text">',$meta_name, $meta_id, $value);
                break;

                case 'color':
                    echo sprintf('<td><input type="text" name="%1$s" id="%2$s" value="%3$s" data-default-color="%4$s" class="colorpicker">',$meta_name, $meta_id, $value, $std);
                break;

                case 'date':
                    echo sprintf('<td><input type="text" name="%1$s" id="%2$s" value="%3$s" class="datepicker">',$meta_name, $meta_id, $value);
                break;

                case 'textarea':
                    echo sprintf('<td><textarea name="%1$s" id="%2$s" rows="8" cols="50">%3$s</textarea>',$meta_name, $meta_id, $value);
                break;

                case 'select':
                    echo sprintf('<td><select name="%1$s" id="%2$s">',$meta_name, $meta_id);
                    foreach( $field['options'] as $key => $option ){
                        $selected = ( $value == $key ) ? ' selected="selected"' : '';
                        echo sprintf('<option value="%1$s" %3$s>%2$s</option>',$key, $option, $selected);
                    }
                    echo'</select>';
                break;

                case 'image_sizes':
                    $available_img_size = get_intermediate_image_sizes();
                    array_push($available_img_size, 'full');

                    echo sprintf('<td><select name="%1$s" id="%2$s">',$meta_name, $meta_id);
                    foreach( $available_img_size as $key => $option ){
                        $selected = ( $value == $option ) ? ' selected="selected"' : '';
                        echo sprintf('<option value="%1$s" %3$s>%2$s</option>',$option, $option, $selected);
                    }
                    echo'</select>';
                break;

                case 'radio':
                    echo '<td><fieldset>';
                    foreach( $field['options'] as $key => $option ){

                        $checked = ( $value == $key ) ? ' checked="checked"' : '';
                        echo sprintf('<label for="%1$s"><input type="radio" name="%4$s" id="%1$s" value="%1$s" %3$s>%2$s</label><br>',$key, $option, $checked, $meta_name);
                    }
                    echo '<fieldset>';
                break;

                case 'checkbox':
                    $checked = ( $value == 'on' ) ? ' checked' : '';
                    $label = (isset($field['label'])) ? $field['label'] : '';
                    echo sprintf( '<input type="hidden" name="%1$s" value="off">', $meta_name );
                    echo sprintf('<td><label for="%2$s"><input type="checkbox" %4$s value="on" id="%2$s" name="%1$s">%3$s</label>',$meta_name, $meta_id, $label, $checked);
                break;

                case 'file':
                    $multiple = ( isset( $field['multiple'] ) ) ? true : false;
                    ?><script>
                    jQuery(function($){
                        var frame,
                            isMultiple = "<?php echo $multiple; ?>";

                        $('#<?php echo $meta_id; ?>_button').on('click', function(e) {
                            e.preventDefault();

                            var options = {
                                state: 'insert',
                                frame: 'post',
                                multiple: isMultiple
                            };

                            frame = wp.media(options).open();

                            frame.menu.get('view').unset('gallery');
                            frame.menu.get('view').unset('featured-image');

                            frame.toolbar.get('view').set({
                                insert: {
                                    style: 'primary',
                                    text: '<?php _e("Insert", "wpdh"); ?>',

                                    click: function() {
                                        var models = frame.state().get('selection'),
                                            url = models.first().attributes.url,
                                            files = [];

                                        if( isMultiple ) {
                                            models.map (function( attachment ) {
                                                attachment = attachment.toJSON();
                                                files.push(attachment.url);
                                                url = files;
                                            });
                                        }

                                        $('#<?php echo $meta_id; ?>').val( url );

                                        frame.close();
                                    }
                                }
                            });
                        });
                    });
                    </script>

                    <?php
                    echo sprintf('<td><input type="text" name="%1$s" id="%2$s" value="%3$s" class="regular-text">',$meta_name, $meta_id, $value);
                    echo '<input type="button" class="button" name="'. $meta_id .'_button" id="'. $meta_id .'_button" value="Browse">';
                break;

                case 'images':
                    $create_btn_text    = 'Create Gallery';
                    $edit_btn_text      = 'Edit Gallery';
                    $update_btn_text    = 'Save Gallery';
                    $progress_btn_text  = 'Saving...';
                    ?>
                    <script>
                    jQuery(function($){
                        var frame,
                            images = '<?php echo get_post_meta( $post->ID, '_wpdh_image_ids', true ); ?>',
                            selection = loadImages(images);

                        $('#wpdh_images_upload').on('click', function(e) {
                            e.preventDefault();
                            var options = {
                                title: '<?php echo $create_btn_text; ?>',
                                state: 'gallery-edit',
                                frame: 'post',
                                selection: selection
                            };

                            if( frame || selection ) {
                                options['title'] = '<?php echo $edit_btn_text; ?>';
                            }

                            frame = wp.media(options).open();

                            // Tweak Views
                            frame.menu.get('view').unset('cancel');
                            frame.menu.get('view').unset('separateCancel');
                            frame.menu.get('view').get('gallery-edit').el.innerHTML = '<?php echo $edit_btn_text; ?>';
                            frame.content.get('view').sidebar.unset('gallery'); // Hide Gallery Settings in sidebar

                            // when editing a gallery
                            overrideGalleryInsert();
                            frame.on( 'toolbar:render:gallery-edit', function() {
                                overrideGalleryInsert();
                            });

                            frame.on( 'content:render:browse', function( browser ) {
                                if ( !browser ) return;
                                // Hide Gallery Settings in sidebar
                                browser.sidebar.on('ready', function(){
                                    browser.sidebar.unset('gallery');
                                });
                                // Hide filter/search as they don't work
                                browser.toolbar.on('ready', function(){
                                    if(browser.toolbar.controller._state == 'gallery-library'){
                                        browser.toolbar.$el.hide();
                                    }
                                });
                            });

                            // All images removed
                            frame.state().get('library').on( 'remove', function() {
                                var models = frame.state().get('library');
                                if(models.length == 0){
                                    selection = false;
                                    $.post(ajaxurl, {
                                        ids: '',
                                        action: 'save_images',
                                        post_id: wpdh_ajax.post_id,
                                        nonce: wpdh_ajax.nonce
                                    });
                                }
                            });

                            function overrideGalleryInsert(){
                                frame.toolbar.get('view').set({
                                    insert: {
                                        style: 'primary',
                                        text: '<?php echo $update_btn_text; ?>',
                                        click: function(){
                                            var models = frame.state().get('library'),
                                                ids = '';

                                            models.each( function( attachment ) {
                                                ids += attachment.id + ','
                                            });

                                            this.el.innerHTML = '<?php echo $progress_btn_text; ?>';

                                            $.ajax({
                                                type: 'POST',
                                                url: ajaxurl,
                                                data: {
                                                    ids: ids,
                                                    action: 'save_images',
                                                    post_id: wpdh_ajax.post_id,
                                                    nonce: wpdh_ajax.nonce
                                                },
                                                success: function(){
                                                    selection = loadImages(ids);
                                                    $('#_wpdh_image_ids').val( ids );
                                                    frame.close();
                                                },
                                                dataType: 'html'
                                            }).done( function( data ) {
                                                $('.wpdh-gallery-thumbs').html( data );
                                                console.log(data);
                                            });
                                        }
                                    }
                                });
                            }

                        });

                        function loadImages(images){
                            if (images){
                                var shortcode = new wp.shortcode({
                                    tag:      'gallery',
                                    attrs:    { ids: images },
                                    type:     'single'
                                });

                                var attachments = wp.media.gallery.attachments( shortcode );

                                var selection = new wp.media.model.Selection( attachments.models, {
                                    props:    attachments.props.toJSON(),
                                    multiple: true
                                });

                                selection.gallery = attachments.gallery;

                                selection.more().done( function() {
                                    // Break ties with the query.
                                    selection.props.set({ query: false });
                                    selection.unmirror();
                                    selection.props.unset('orderby');
                                });

                                return selection;
                            }
                            return false;
                        }
                    });
                    </script>

                    <?php

                    $meta = get_post_meta( $post->ID, '_wpdh_image_ids', true );
                    $thumbs_output = '';
                    $button_text = ($meta) ? $edit_btn_text : $create_btn_text;
                    if( $meta ) {
                        $thumbs = explode(',', $meta);
                        $thumbs_output = '';
                        foreach( $thumbs as $thumb ) {
                            $thumbs_output .= '<li>' . wp_get_attachment_image( $thumb, array(75,75) ) . '</li>';
                        }
                    }

                    echo sprintf('<td class="wpdh-box-%s">', $type);
                    echo sprintf('<input type="button" class="button" name="%1$s" id="wpdh_images_upload" value="%2$s">', $meta_id, $button_text);
                    echo '<input type="hidden" name="wpdh_meta[_wpdh_image_ids]" id="_wpdh_image_ids" value="' . ($meta ? $meta : 'false') . '"><br>';

                    echo sprintf('<div class="wpdh-gallery-thumbs"><ul>%s</ul></div>',$thumbs_output);
                break;

                default:
                    echo sprintf('<td><input type="text" name="%1$s" id="%2$s" value="%3$s" class="regular-text">',$meta_name, $meta_id, $value);
                break;

            }

            if (!empty($desc)) {
                echo sprintf('<p class="description">%s</p>', $desc);
            }

            echo '</td></tr>';

        }

        echo '</table>';

        // Include inline scripts for meta box
        $this->inline_scripts();

    }

    /**
     * Save custom meta box
     * @method save_meta_box
     * @param  int $post_id The post ID
     */
    public function save_meta_box( $post_id ) {

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
            return;

        $postName  = $this->fields['id']. '_meta';

        if ( !isset($_POST[$postName]) || !isset($_POST['wpdh_meta_box_nonce']) || !wp_verify_nonce( $_POST['wpdh_meta_box_nonce'], basename( __FILE__ ) ) )
            return;

        if ( 'page' == $_POST['post_type'] ) {
            if ( !current_user_can( 'edit_page', $post_id ) ) return;
        } else {
            if ( !current_user_can( 'edit_post', $post_id ) ) return;
        }

        foreach( $_POST[$postName] as $key => $val ){
            update_post_meta( $post_id, $key, stripslashes(htmlspecialchars($val)) );
        }
    }

    /**
     * Save images
     * @method save_images
     */
    public function save_images(){
        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
            return;
        }

        if ( !isset($_POST['ids']) || !isset($_POST['nonce']) || !wp_verify_nonce( $_POST['nonce'], 'wpdh-ajax' ) ){
            return;
        }

        if ( !current_user_can( 'edit_posts' ) ) return;

        $ids = strip_tags(rtrim($_POST['ids'], ','));
        update_post_meta($_POST['post_id'], '_wpdh_image_ids', $ids);

        $thumbs = explode(',', $ids);
        $thumbs_output = '';
        foreach( $thumbs as $thumb ) {
            $thumbs_output .= '<li>' . wp_get_attachment_image( $thumb, array(75,75) ) . '</li>';
        }

        echo $thumbs_output;

        die();
    }

    /**
     * Enqueue admin scripts for meta box
     * @method metabox_scripts
     */
    public function metabox_scripts(){

        wp_enqueue_media();
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        wp_enqueue_script( 'jquery-ui-datepicker' );

        global $post;
        if( isset($post) ) {
            wp_localize_script( 'jquery', 'wpdh_ajax', array(
                'post_id' => $post->ID,
                'nonce' => wp_create_nonce( 'wpdh-ajax' )
            ) );
        }
    }

    /**
     * Add inline script for color and date field
     * @method inline_scripts
     */
    public function inline_scripts()
    {
        ?><script type="text/javascript">
            jQuery(document).ready(function($){
                $('.colorpicker').wpColorPicker();
                $( ".datepicker" ).datepicker({
                    changeMonth: true,
                    changeYear: true
                });
            });
        </script><?php
    }

    /**
     * Add inline style for admin screen
     * @method admin_head
     */
    public function admin_head()
    {
        $style  = '<style>';
        $style .= '.wpdh-gallery-thumbs{display: block; clear: both;}';
        $style .= '.wpdh-gallery-thumbs li {display: inline-block;margin-right: 10px;margin-bottom: 10px;}';
        $style .= '</style>';
        echo $style;
    }

}
