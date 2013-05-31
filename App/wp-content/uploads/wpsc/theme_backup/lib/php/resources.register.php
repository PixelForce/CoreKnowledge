<?php
    $sidebar_value = extra::select_value( '_sidebar' );

    if(!( is_array( $sidebar_value ) || !empty( $sidebar_value ) ) ){
        $sidebar_value = array();
    }

    /* hide if is full width */
    $classes = 'sidebar_list';

    if( isset( $_GET['post'] ) ){
        $meta = meta::get_meta( (int) $_GET['post'] , 'layout' );

        if( isset( $meta['type'] ) && $meta['type'] == 'full' ){
            $classes = 'sidebar_list hidden';
        }
    }

    $position = array( 'left' => __( 'Align Left' , 'cosmotheme' ) , 'right' => __( 'Align Right' , 'cosmotheme' ) );
    /* post type slideshow */
    $res['slideshow']['labels'] = array(
        'name' => _x(__('Slideshow','cosmotheme'), 'post type general name'),
        'singular_name' => _x(__('Slideshow','cosmotheme'), 'post type singular name'),
        'add_new' => _x('Add New', __('Slideshow','cosmotheme')),
        'add_new_item' => __('Add New Slideshow','cosmotheme'),
        'edit_item' => __('Edit Slideshow','cosmotheme'),
        'new_item' => __('New Slideshow','cosmotheme'),
        'view_item' => __('View Slideshow','cosmotheme'),
        'search_items' => __('Search Slideshow','cosmotheme'),
        'not_found' =>  __('Nothing found','cosmotheme'),
        'not_found_in_trash' => __('Nothing found in Trash','cosmotheme')
    );
    $res['slideshow']['args'] = array(
        'public' => true,
        'hierarchical' => false,
        'menu_position' => 3,
        'supports' => array('title'),
    	'exclude_from_search' => true,
        '__on_front_page' => true
    );

    $struct['slideshow']['box'] = array(
        'layout' => 'B',
        'field-style' => 'line',
        'check-column' => array(
            'name' => 'idrow',
            'type' => 'hidden',
            'evisible' => false,
            'lvisible' => false,
        ),
        'icon-column' => array(
            'name' => 'slide',
            'type' => 'attachment',
            'attach_type' => 'image',
            'width' => 100,
            'height' => 100,
            'evisible' => false,
            'lvisible' => false,
        ),
        'info-column-0' => array(
            0 => array(
                'name' => 'resources',
                'type' => 'hidden',
                'evisible' => true,
                'lvisible' => false,
                'post_link' => true,
            ),
            1 => array(
                'name' => 'type_res',
                'type' => 'hidden',
                'evisible' => false,
                'lvisible' => false,
            ),
            2 => array(
                'name' => 'title',
                'type' => 'text',
                'label' => __( 'Resource title' , 'cosmotheme' ),
                'before' => '<h2>',
                'after' => '</h2>',
                'evisible' => false,
                'lvisible' => true,
            ),
            3 => array(
                'name' => 'description',
                'type' => 'textarea',
                'label' => __( 'Resource description' , 'cosmotheme' ),
                'evisible' => false,
                'lvisible' => true,
            ),
            4 => array(
                'name' => 'position',
                'type' => 'select',
                'label' => __( 'Description alignment' , 'cosmotheme' ),
                'assoc' => $position,
                'evisible' => false,
                'lvisible' => true,
            ),
            5 => array(
                'name' => 'url',
                'type' => 'text',
                'label' => __( 'Custom URL' , 'cosmotheme' ),
                'evisible' => false,
                'lvisible' => true,
            ),
        ),
        'actions' => array(
            0 => array( 'slug' => 'edit' , 'label' => 'edit' ,  'args' => array( 'res' => 'slideshow' , 'box' => 'box' , 'post_id' => '' , 'index' => '' , 'selector' => 'div#slideshow_box div.inside div#box_slideshow_box' ) ),
            1 => array( 'slug' => 'update' , 'label' => 'update' , 'args' => array( 'res' => 'slideshow' , 'box' => 'box' , 'post_id' => '' , 'index' => '' , 'data' => array( 'input' =>  "['slideshow-box-slide_id' , 'slideshow-box-slide' , 'slideshow-box-description', 'slideshow-box-title ', 'slideshow-box-url ' ]" , 'select' => "'slideshow-box-position'"  ) , 'selector' => 'div#slideshow_box div.inside div#box_slideshow_box' ) ),
            2 => array( 'slug' => 'del' , 'label' => 'delete' , 'args' => array( 'res' => '' , 'box' => '' , 'post_id' => '' , 'index' => '' , 'selector' => 'div#slideshow_box div.inside div#box_slideshow_box' ) )
        )

    );

    $sl_res = array( 'none' => __( 'Simple image' , 'cosmotheme' ) , 'post' => __( 'Post' , 'cosmotheme' ) );

    $form['slideshow']['box']['type_res']   = array( 'type' => 'st--m-select' , 'label' => __( 'Select resource type' , 'cosmotheme') , 'value' =>  $sl_res , 'action' => "act.select('#type_resource' , { 'post' : '.mis-hint .generic-hint , .slider_resources' }, 'sh_');" , 'id' => 'type_resource' );
    $form['slideshow']['box']['resources']  = array( 'type' => 'st--m-search' , 'label' => __( 'Select post' , 'cosmotheme' ) , 'classes' => 'slider_resources hidden' , 'query' => array( 'post_type' => 'post' , 'post_status' => 'publish' ) , 'action' => "act.search( this , '-');", 'hint'=>__('Start typing the post title','cosmotheme') );
    $form['slideshow']['box']['title']		= array( 'type' => 'st--m-text' , 'label' =>  __( 'Resource title' , 'cosmotheme' ) , 'hint' => __( 'If not completed will use post title' , 'cosmotheme'  ) , 'classes' => 'mis-hint' , 'hclass' => 'hidden' );
    $form['slideshow']['box']['description']= array( 'type' => 'st--m-textarea' , 'label' =>  __( 'Resource description' , 'cosmotheme' ) , 'hint' => __( 'If not completed will use post excerpt (first 180 chars) or post content (first 180 chars)' , 'cosmotheme'  ) , 'classes' => 'mis-hint' , 'hclass' => 'hidden' );
    $form['slideshow']['box']['position']   = array( 'type' => 'st--m-select' , 'label' => __( 'Description alignment' , 'cosmotheme') , 'value' =>  $position , 'hint' => __( 'Choose side of description position' , 'cosmotheme' ) );
    $form['slideshow']['box']['slide']      = array( 'type' => 'st--m-upload-id' , 'label' => __( 'Upload or choose image from media library' , 'cosmotheme') , 'id' => 'box_slide' , 'hint' =>  __( 'If not uploaded will use post Featured image' , 'cosmotheme' ) , 'classes' => 'mis-hint' , 'hclass' => 'hidden' );
    $form['slideshow']['box']['url']		= array( 'type' => 'st--m-text' , 'label' =>  __( 'Custom URL' , 'cosmotheme' ) , 'hint' => __( 'If not completed then Title will link to the selected post' , 'cosmotheme'  ) , 'classes' => 'mis-hint' , 'hclass' => 'hidden' );
    $form['slideshow']['box']['submit']     = array( 'type' => 'st--meta-save' ,  'value' => __( 'Add to slideshow' ,'cosmotheme' ) , 'selector' => 'div#slideshow_box div.inside div#box_slideshow_box'  );

    $box['slideshow']['box']                = array( __('Compose slideshow (drag and drop items to rearange position)' , 'cosmotheme' ) , 'normal' , 'low' , 'content' => $form['slideshow']['box'] , 'box' => 'box' , 'struct' => $struct['slideshow']['box'] , 'callback' => array( 'get_meta_records' , array( 'slideshow' , 'box' , 'box' ) ) , 'records-title' => __('Slideshow items' , 'cosmotheme' ) );
    $form['slideshow']['manager']['link']   = array( 'type' => 'sh--post-upload' , 'title' => __( 'Manage Slideshow' , 'cosmotheme' ) );

    $box['slideshow']['manager']            = array( __('Manage Slideshow' , 'cosmotheme' ) , 'side' , 'low' , 'content' => $form['slideshow']['manager'] , 'box' => 'manager' );


    resources::$labels['slideshow']         = $res['slideshow']['labels'];
    resources::$type['slideshow']           = $res['slideshow']['args'];
    resources::$box['slideshow']            = $box['slideshow'];


    /* standard post */
    $form['post']['layout']['type']         = array( 'type' => 'sh--select' , 'label' =>  __( 'Select layout type' , 'cosmotheme' ) , 'value' => array( 'right' => __( 'Right Sidebar'  , 'cosmotheme' ) , 'left' => __( 'Left Sidebar' , 'cosmotheme' ) , 'full' => __( 'Full Width' , 'cosmotheme' )  ) , 'action' => "act.select( '#post_layout' , { 'full' : '.sidebar_list' } , 'hs_');" , 'id' => 'post_layout' );
    $form['post']['layout']['sidebar']      = array( 'type' => 'sh--select' , 'label' =>  __( 'Select sidebar' , 'cosmotheme' ) , 'value' => $sidebar_value , 'classes' => $classes );
    $form['post']['layout']['link']         = array( 'type' => 'sh--link' , 'url' => 'admin.php?page=cosmothemes___sidebar' , 'title' => __( 'Add new Sidebar' , 'cosmotheme' ) );


    $sliders = get__posts( array( 'post_status' => 'publish' , 'post_type' => 'slideshow' ) , '' );
    if( count( $sliders ) > 0 ){
        $form['post']['settings']['slideshow']  = array( 'type' => 'st--logic-radio' , 'label' => __( 'Display slideshow' , 'cosmotheme' ) , 'hint' => __( 'Show slideshow on this post' , 'cosmotheme' ) , 'cvalue' => 'no' , 'action' => "act.check( this , { 'yes' : '.list_slideshow'  } , 'sh');" );
        $form['post']['settings']['slideshow_select'] = array('type' => 'st--search' , 'label' => __( 'Select slideshow' , 'cosmotheme' ) , 'query' => array( 'post_type' => 'slideshow' , 'post_status' => 'publish' ) , 'hint' => __( 'Start typing the Slideshow title. ' , 'cosmotheme' ) , 'action' => "act.search( this , '.sl_settings')" );
        if( isset( $_GET['post'] ) &&  meta::logic( get_post( $_GET['post']  ) , 'settings' , 'slideshow' ) ){
            $form['post']['settings']['slideshow_select']['classes'] = 'list_slideshow';
        }else{
            $form['post']['settings']['slideshow_select']['classes'] = 'hidden list_slideshow';
        }
    }else{
        $form['post']['settings']['link']        = array( 'type' => 'sh--link' , 'url' => 'post-new.php?post_type=slideshow' , 'title' => __( 'Add New Slideshow' , 'cosmotheme') );
    }

    $form['post']['settings']['safe']       = array( 'type' => 'st--logic-radio' , 'label' => __( 'Not safe' , 'cosmotheme' ) , 'cvalue' => 'no' );
    $form['post']['settings']['related']    = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show related posts' , 'cosmotheme' ) , 'hint' => __( 'Show related posts on this post' , 'cosmotheme' ) , 'cvalue' => options::get_value(  'blog_post' , 'show_similar' ) );
    $form['post']['settings']['meta']       = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show post meta' , 'cosmotheme' ) , 'hint' => __( 'Show post meta on this post' , 'cosmotheme' ) , 'cvalue' => options::get_value(  'general' , 'meta' ), 'action' => "act.check( this , { 'yes' : '.meta_view'  } , 'sh');" );
	$meta_view_type = array('horizontal' => __('Horizontal','cosmotheme'), 'vertical' => __('Vertical','cosmotheme') );  
	$form['post']['settings']['meta_view_style'] = array( 'type' => 'st--select' , 'label' => __( 'Meta view style' , 'cosmotheme' ) ,  'value' => $meta_view_type, 'ivalue' => options::get_value(  'general' , 'meta_view_style' ));

//var_dump(meta::get_meta( $_GET['post'] , 'settings' ));

	if( isset( $_GET['post'] ) &&  meta::logic( get_post( $_GET['post']  ) , 'settings' , 'meta' ) ){
		$form['post']['settings']['meta_view_style']['classes'] = 'meta_view';
	}elseif(isset( $_GET['post'] ) && sizeof(meta::get_meta( $_GET['post'] , 'settings' )) &&  !meta::logic( get_post( $_GET['post']  ) , 'settings' , 'meta' )){
 		$form['post']['settings']['meta_view_style']['classes'] = 'hidden meta_view'; 
	}elseif(options::logic( 'general' , 'meta' )){
		$form['post']['settings']['meta_view_style']['classes'] = 'meta_view';
	}else{
		$form['post']['settings']['meta_view_style']['classes'] = 'hidden meta_view'; 
	}

	$form['post']['settings']['love']       = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show post love' , 'cosmotheme' ) , 'hint' => __( 'Show post love on this post' , 'cosmotheme' )  , 'cvalue' => options::get_value(  'general' , 'enb_likes' ) );
    $form['post']['settings']['sharing']    = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show social sharing' , 'cosmotheme' ) , 'hint' => __( 'Show social sharing on this post'  , 'cosmotheme' ) , 'cvalue' => options::get_value( 'blog_post' , 'post_sharing' ) );
    $form['post']['settings']['author']     = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show author box' , 'cosmotheme' ) , 'hint' => __( 'Show author box on this post'  , 'cosmotheme' ) , 'cvalue' => options::get_value( 'blog_post' , 'post_author_box' ) );
    $form['post']['settings']['post_bg']    = array( 'type' => 'st--upload' , 'label' => __( 'Upload or choose image from media library' , 'cosmotheme') , 'id' => 'post_background' , 'hint' => __( 'This will be the background image for this post' , 'cosmotheme' ) );
    $form['post']['settings']['position']   = array( 'type' => 'st--select' , 'label' => __( 'Image background position' , 'cosmotheme' ) , 'value' => array( 'left' => __( 'Left' , 'cosmotheme' ) , 'center' => __( 'Center' , 'cosmotheme' ) , 'right' => __( 'Right' , 'cosmotheme' ) ) );
    $form['post']['settings']['repeat']     = array( 'type' => 'st--select' , 'label' => __( 'Image background repeat' , 'cosmotheme' ) , 'value' => array( 'no-repeat' => __( 'No Repeat' , 'cosmotheme' ) , 'repeat' => __( 'Tile' , 'cosmotheme' ) , 'repeat-x' => __( 'Tile Horizontally' , 'cosmotheme' ) , 'repeat-y' => __( 'Tile Vertically' , 'cosmotheme' ) ) );
    $form['post']['settings']['attachment'] = array( 'type' => 'st--select' , 'label' => __( 'Image background attachment type' , 'cosmotheme' ) , 'value' => array( 'scroll' => __( 'Scroll' , 'cosmotheme' ) , 'fixed' => __( 'Fixed' , 'cosmotheme' ) ) );
    $form['post']['settings']['color']      = array( 'type' => 'st--color-picker' , 'label' => __( 'Set background color for this post' , 'cosmotheme' ) );

    if( isset( $_GET['post'] ) ){
        $post_format = get_post_format( $_GET['post'] );
    }else{
        $post_format = 'standard';
    }
    
    $form['post']['format']['type']         = array( 'type' => 'st--select' , 'label' => __( 'Select post format' , 'cosmotheme' ) , 'value' => array(  'standard' => __( 'Standard' , 'cosmotheme' ) , 'video' => __( 'Video' , 'cosmotheme' ) , 'image' => __( 'Image' , 'cosmotheme' ) , 'audio' => __( 'Audio' , 'cosmotheme' )  , 'link' => __( 'Attachment' , 'cosmotheme' ) )  , 'action' => "act.select( '.post_format_type' , { 'video' : '.post_format_video' , 'image' : '.post_format_image' , 'audio' : '.post_format_audio' , 'link' : '.post_format_link' } , 'sh_' );" , 'iclasses' => 'post_format_type' , 'ivalue' =>  $post_format );

    if( isset( $_GET['post'] ) && get_post_format( $_GET['post'] ) == 'video' ){
        $form['post']['format']['video']        = array( 'type' => 'st--text' , 'label' => __( 'Set video URL ( YouTube , Vimeo or self hosted )' , 'cosmotheme' ) , 'hint' => __( 'If a valid YouTube, Vimeo or self hosted URL is provided, the embeded video <br /> for the provided link will be appended at the beginning of the post <br /> content. Otherwise it will be ignored.' , 'cosmotheme' ) , 'classes' => 'post_format_video' );
    }else{
        $form['post']['format']['video']        = array( 'type' => 'st--text' , 'label' => __( 'Set video URL ( YouTube , Vimeo )' , 'cosmotheme' ) , 'hint' => __( 'If a valid YouTube or Vimeo URL is provided, the embeded video <br /> for the provided link will be appended at the beginning of the post <br /> content. Otherwise it will be ignored.' , 'cosmotheme' ) , 'classes' => 'post_format_video hidden' );
    }

    if( isset( $_GET['post'] ) && get_post_format( $_GET['post'] ) == 'image' ){
        $form['post']['format']['image']        = array( 'type' => 'st--hint' , 'label' => '' , 'value' => __( 'Please set featured image'  , 'cosmotheme' )  , 'classes' => 'post_format_image' );
    }else{
        $form['post']['format']['image']        = array( 'type' => 'st--hint' , 'label' => '' , 'value' => __( 'Please set featured image'  , 'cosmotheme' )  , 'classes' => 'post_format_image hidden' );
    }

    if( isset( $_GET['post'] ) && get_post_format( $_GET['post'] ) == 'audio' ){
        $form['post']['format']['audio']        = array( 'type' => 'st--upload' , 'label' => __( 'Please add audio file or URL'  , 'cosmotheme' )  , 'classes' => 'post_format_audio' , 'id' => 'format_audio' , 'hint' => __( 'Please use  only MP3 files' , 'cosmotheme' ) );
    }else{
        $form['post']['format']['audio']        = array( 'type' => 'st--upload' , 'label' => __( 'Please add audio file or URL'  , 'cosmotheme' )  , 'classes' => 'post_format_audio hidden' , 'id' => 'format_audio' , 'hint' => __( 'Please use  only MP3 files' , 'cosmotheme' ) );
    }
    
    if( isset( $_GET['post'] ) && get_post_format( $_GET['post'] ) == 'link' ){
        $form['post']['format']['link']        = array( 'type' => 'st--upload-id' , 'label' => __( 'Please add attachment file or URL'  , 'cosmotheme' )  , 'classes' => 'post_format_link' , 'id' => 'format_link' , 'hint' => __( 'Please use only .ZIP, .RAR, .DOC, .DOCX, .PDF files' , 'cosmotheme' ) );
    }else{
        $form['post']['format']['link']        = array( 'type' => 'st--upload-id' , 'label' => __( 'Please add attachment file or URL'  , 'cosmotheme' )  , 'classes' => 'post_format_link hidden' , 'id' => 'format_link' , 'hint' => __( 'Please use only .ZIP, .RAR, .DOC, .DOCX, .PDF files' , 'cosmotheme' ) );
    }

    $form['post']['source']['post_source']   = array( 'type' => 'st--text' , 'label' => __( 'Source' , 'cosmotheme' ) , 'hint' => __( 'Example: http://cosmothemes.com' , 'cosmotheme' ) );
    
    $box['post']['shcode']                  = array( __('Shortcodes' , 'cosmotheme' ) , 'normal' , 'high'  , 'box' => 'shcode' , 'includes' => 'shcode/main.php' );
    $box['post']['layout']                  = array( __('Layout and Sidebars' , 'cosmotheme' ) , 'side' , 'low' , 'content' => $form['post']['layout'] , 'box' => 'layout' , 'update' => true  );
    $box['post']['settings']                = array( __('Post Settings' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form['post']['settings'] , 'box' => 'settings' , 'update' => true  );
    $box['post']['format']                  = array( __('Post Format' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form['post']['format'] , 'box' => 'format' , 'update' => true );
    $box['post']['source']                  = array( __('Post Source' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form['post']['source'] , 'box' => 'source' , 'update' => true );
    

    resources::$type['post']                = array();
    resources::$box['post']                 = $box['post'];
    
    $sliders = get__posts( array( 'post_status' => 'publish' , 'post_type' => 'slideshow' ) , '' );
    if( count( $sliders ) > 0 ){
        $form['page']['settings']['slideshow']  = array( 'type' => 'st--logic-radio' , 'label' => __( 'Display slideshow' , 'cosmotheme' ) , 'hint' => __( 'Show slideshow on this post' , 'cosmotheme' ) , 'cvalue' => 'no' , 'action' => "act.check( this , { 'yes' : '.list_slideshow'  } , 'sh');" );
        $form['page']['settings']['slideshow_select'] = array('type' => 'st--search' , 'label' => __( 'Select slideshow' , 'cosmotheme' ) , 'query' => array( 'post_type' => 'slideshow' , 'post_status' => 'publish' ) , 'hint' => __( 'Type title ' , 'cosmotheme' ) , 'action' => "act.search( this , '.sl_settings')" );
        if( isset( $_GET['post'] ) &&  meta::logic( get_post( $_GET['post']  ) , 'settings' , 'slideshow' ) ){
            $form['page']['settings']['slideshow_select']['classes'] = 'list_slideshow';
        }else{
            $form['page']['settings']['slideshow_select']['classes'] = 'hidden list_slideshow';
        }
    }else{
        $form['page']['settings']['link']        = array( 'type' => 'sh--link' , 'url' => 'post-new.php?post_type=slideshow' , 'title' => __( 'Add New Slideshow' , 'cosmotheme') );
    }
    
    $form['page']['settings']['meta']       = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show page meta' , 'cosmotheme' ) , 'hint' => 'Show post meta on this page' , 'cvalue' => 'no' );
    $form['page']['settings']['sharing']    = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show social sharing' , 'cosmotheme' ) , 'hint' => 'Show social sharing on this page' , 'cvalue' => options::get_value( 'blog_post' , 'page_sharing' ) );
    $form['page']['settings']['author']     = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show author box' , 'cosmotheme' ) , 'hint' => 'Show author box on this page' , 'cvalue' => options::get_value( 'blog_post' , 'page_author_box' ) );
    $form['page']['settings']['post_bg']    = array( 'type' => 'st--upload' , 'label' => __( 'Upload image, or choose from media library.' , 'cosmotheme') , 'id' => 'post_background' , 'hint' => __( 'This will be the background image for this page' , 'cosmotheme' ) );
    $form['page']['settings']['position']   = array( 'type' => 'st--select' , 'label' => __( 'Background position' , 'cosmotheme' ) , 'value' => array( 'left' => __( 'Left' , 'cosmotheme' ) , 'center' => __( 'Center' , 'cosmotheme' ) , 'right' => __( 'Right' , 'cosmotheme' ) ) );
    $form['page']['settings']['repeat']     = array( 'type' => 'st--select' , 'label' => __( 'Background repeat' , 'cosmotheme' ) , 'value' => array( 'no-repeat' => __( 'No Repeat' , 'cosmotheme' ) , 'repeat' => __( 'Tile' , 'cosmotheme' ) , 'repeat-x' => __( 'Tile Horizontally' , 'cosmotheme' ) , 'repeat-y' => __( 'Tile Vertically' , 'cosmotheme' ) ) );
    $form['page']['settings']['attachment'] = array( 'type' => 'st--select' , 'label' => __( 'Background attachment type' , 'cosmotheme' ) , 'value' => array( 'scroll' => __( 'Scroll' , 'cosmotheme' ) , 'fixed' => __( 'Fixed' , 'cosmotheme' ) ) );
    $form['page']['settings']['color']      = array( 'type' => 'st--color-picker' , 'label' => __( 'Set background color for this post' , 'cosmotheme' ) );

    $box['page']['shcode']                  = array( __('Shortcodes' , 'cosmotheme' ) , 'normal' , 'high'  , 'box' => 'shcode' , 'includes' => 'shcode/main.php' );
    $box['page']['layout']                  = array( __('Layout and Sidebars' , 'cosmotheme' ) , 'side' , 'low' , 'content' => $form['post']['layout'] , 'box' => 'layout' , 'update' => true  );
    $box['page']['settings']                = array( __('Page Settings' , 'cosmotheme' ) , 'normal' , 'high' , 'content' => $form['page']['settings'] , 'box' => 'settings' , 'update' => true  );
    
    
    resources::$type['page']                = array();
    resources::$box['page']                 = $box['page'];
?>