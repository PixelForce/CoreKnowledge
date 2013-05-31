<?php
    /* register pages */
	$current_theme_name = get_current_theme();

    options::$menu['cosmothemes']['general']            = array( 'label' => __( 'General' , 'cosmotheme' ) , 'title' => __( 'General settings' , 'cosmotheme' ) , 'description' => __( 'General page description.' , 'cosmotheme' ) , 'type' => 'main' , 'main_label' => $current_theme_name );
    options::$menu['cosmothemes']['front_page']         = array( 'label' => __( 'Front page' , 'cosmotheme' )  , 'title' => __( 'Front page settings' , 'cosmotheme' )  , 'description' => __( 'Front page description.' , 'cosmotheme' ) );
    options::$menu['cosmothemes']['layout']             = array( 'label' => __( 'Layout' , 'cosmotheme' )  , 'title' => __( 'Layout page settings' , 'cosmotheme' )  , 'description' => __( 'Layout page description.' , 'cosmotheme' ) );
    options::$menu['cosmothemes']['styling']            = array( 'label' => __( 'Styling' , 'cosmotheme' )  , 'title' => __( 'Styling settings' , 'cosmotheme' )  , 'description' => __( 'Styling page description.' , 'cosmotheme' ) );
    options::$menu['cosmothemes']['menu']               = array( 'label' => __( 'Menus' , 'cosmotheme' )  , 'title' => __( 'Menu settings' , 'cosmotheme' )  , 'description' => __( 'Menu page description.' , 'cosmotheme' ) );
    options::$menu['cosmothemes']['blog_post']          = array( 'label' => __( 'Blogging' , 'cosmotheme' )  , 'title' => __( 'Blog post settings' , 'cosmotheme' )  , 'description' => __( 'Blog post page description.' , 'cosmotheme' ) );
    options::$menu['cosmothemes']['advertisement']      = array( 'label' => __( 'Advertisement' , 'cosmotheme' )  , 'title' => __( 'Advertisement spaces' , 'cosmotheme' )  , 'description' => __( 'Sidebar manager page description.' , 'cosmotheme' ) );
    options::$menu['cosmothemes']['social']             = array( 'label' => __( 'Social networks' , 'cosmotheme' )  , 'title' => __( 'Social network settings' , 'cosmotheme' )  , 'description' => __( 'Social page description.' , 'cosmotheme' ) );
    options::$menu['cosmothemes']['slider']             = array( 'label' => __( 'Slideshow' , 'cosmotheme' )  , 'title' => __( 'Slideshow settings' , 'cosmotheme' )  , 'description' => __( 'Slideshow page description.' , 'cosmotheme' ) );
	options::$menu['cosmothemes']['upload']             = array( 'label' => __( 'Front-end posts' , 'cosmotheme' )  , 'title' => __( 'Front-end posts submission' , 'cosmotheme' )  , 'description' => __( 'Front end tabs settings.' , 'cosmotheme' ) );
    options::$menu['cosmothemes']['_sidebar']           = array( 'label' => __( 'Sidebars' , 'cosmotheme' )  , 'title' => __( 'Sidebar manager' , 'cosmotheme' )  , 'description' => __( 'Sidebar manager page description.' , 'cosmotheme' ) , 'update' => false );
    options::$menu['cosmothemes']['_tooltip']           = array( 'label' => __( 'Tooltips' , 'cosmotheme' )  , 'title' => __( 'Tooltips manager' , 'cosmotheme' )  , 'description' => __( 'Tooltips manager page description.' , 'cosmotheme' ) , 'update' => false );
	options::$menu['cosmothemes']['cosmothemes']        = array( 'label' => __( 'CosmoThemes' , 'cosmotheme' )  , 'title' => __( 'CosmoThemes' , 'cosmotheme' )  , 'description' => __( 'CosmoThemes notifications.' , 'cosmotheme' ) );
   
    /* OPTIONS */
    /* GENERAL DEFAULT VALUE */
    options::$default['general']['enb_keyboard']        = 'yes';
    options::$default['general']['enb_hot_keys']        = 'yes';
    options::$default['general']['enb_likes']           = 'yes';
    options::$default['general']['min_likes']           =  50;
    options::$default['general']['user_register']       = 'yes';
    options::$default['general']['user_login']          = 'yes';
    options::$default['general']['like_register']       = 'no';
	options::$default['general']['sticky_bar']			= 'yes';	
    options::$default['general']['enb_featured']        = 'yes';
    options::$default['general']['enb_lightbox']        = 'yes';
    options::$default['general']['breadcrumbs']         = 'no';
    options::$default['general']['meta']                = 'yes';
	options::$default['general']['meta_view_style']		= 'horizontal';
    options::$default['general']['time']                = 'yes';
    options::$default['general']['fb_comments']         = 'yes';
	options::$default['general']['show_admin_bar']      = 'no';
    options::$default['general']['nsfw_content']        = __( 'This article contains NSFW information. To read this information you need to be logged in.' , 'cosmotheme' ) ;

    /* GENERAL OPTIONS */
    options::$fields['general']['enb_keyboard']         = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable keyboard demo' , 'cosmotheme' ) , 'hint' => __( 'If enabled users can click on the keyboard icon to visualize keyboard hot-keys.' , 'cosmotheme' ) );
    options::$fields['general']['enb_hot_keys']         = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable keyboard hot keys' , 'cosmotheme' )  );
	options::$fields['general']['enb_likes']            = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable Love for posts' , 'cosmotheme') , 'action' => "act.check( this , { 'yes' : '.g_like , .g_l_register' , 'no' : '' } , 'sh' );" , 'iclasses' => 'g_e_likes');
	options::$fields['general']['min_likes']            = array( 'type' => 'st--digit-like' , 'label' => __( 'Minimum number of Loves to set Featured' , 'cosmotheme' ) , 'hint' => __( 'Set minimum number of post likes to change it into a featured post' , 'cosmotheme' ) , 'id' => 'nr_min_likes' ,'action' => "act.min_likes(  jQuery( '#nr_min_likes').val() , 1 );"  );
	options::$fields['general']['sim_likes']            = array( 'type' => 'st--button' , 'value' => __( 'Generate' , 'comotheme' ) , 'label' => __( 'Generate random number of Loves for posts' , 'cosmotheme' ) , 'action' => "act.sim_likes( 1 );" , 'hint' => __( 'WARNING! This will reset all current Loves.' , 'cosmotheme' ) );
    
    options::$fields['general']['my_posts_page']         = array( 'type' => 'st--select' , 'label' => __( 'Select My posts page' , 'cosmotheme' ) , 'value' => get__pages() , 'hint' => __('Select a blank page from the list to generate the My posts page','cosmotheme'));
	options::$fields['general']['user_profile_page']    = array( 'type' => 'st--select' , 'label' => __( 'Select My account page' , 'cosmotheme' ) , 'value' => get__pages() , 'hint' => __('Select a blank page from the list to generate the My account page','cosmotheme'));
    options::$fields['general']['user_login']           = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable user login' , 'cosmotheme') , 'hint' => __( 'Check to show "register" link	'  , 'cosmotheme' ) , 'action' => "act.check( this , { 'yes' : '.g_l_register, .g_sticky_bar' , 'no' : '' } , 'sh' );act.mcheck( [ '.yes.g_e_likes' , '.yes.g_u_register']  );" , 'iclasses' => 'g_u_register' );
    options::$fields['general']['like_register']        = array( 'type' => 'st--logic-radio' , 'label' => __( 'Registration is required to Love a post' , 'cosmotheme') );
	options::$fields['general']['sticky_bar']           = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable sticky bar' , 'cosmotheme') );

    if( options::logic( 'general' , 'enb_likes' ) ){
        options::$fields['general']['min_likes']['classes']     = 'g_like';
        options::$fields['general']['like_register']['classes'] = 'g_l_register';
        options::$fields['general']['sim_likes']['classes']     = 'g_like';
    }else{
        options::$fields['general']['min_likes']['classes']     = 'g_like hidden';
        options::$fields['general']['like_register']['classes'] = 'g_l_register hidden';
        options::$fields['general']['sim_likes']['classes']     = 'g_like hidden';
    }

	if( options::logic( 'general' , 'user_login' ) ){
		options::$fields['general']['sticky_bar']['classes']     = 'g_sticky_bar';
	}else{
		options::$fields['general']['sticky_bar']['classes']     = 'g_sticky_bar hidden';
	}

    options::$fields['general']['enb_featured']         = array('type' => 'st--logic-radio' , 'label' => __( 'Display featured image inside the post' , 'cosmotheme' ) , 'hint' => __( 'If enabled featured images will be displayed both on category and post page' , 'cosmotheme' ) );
    options::$fields['general']['enb_lightbox']         = array('type' => 'st--logic-radio' , 'label' => __( 'Enable pretty-photo ligthbox' , 'cosmotheme' ) , 'hint' => __( 'Images inside posts will open inside a fancy lightbox' , 'cosmotheme' ) );
    options::$fields['general']['breadcrumbs']          = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show breadcrumbs' , 'cosmotheme') );
    options::$fields['general']['meta']                 = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show entry meta' , 'cosmotheme' ) , 'hint' => __( ' In blog / archive / search / tag / category page' , 'cosmotheme' ), 'action' => "act.check( this , { 'yes' : '.meta_view ' , 'no' : '' } , 'sh' );" );
	$meta_view_type = array('horizontal' => __('Horizontal','cosmotheme'), 'vertical' => __('Vertical','cosmotheme') );  
	options::$fields['general']['meta_view_style']  	= array('type' => 'st--select' , 'label' => __( 'Meta view style' , 'cosmotheme' ) , 'value' => $meta_view_type );
    options::$fields['general']['time']                 = array( 'type' => 'st--logic-radio' , 'label' => __( 'Use human time' , 'cosmotheme') ,  'hint' => __( 'If set No will use WordPress time format'  , 'cosmotheme' ) );
    options::$fields['general']['fb_comments']          = array( 'type' => 'st--logic-radio' , 'label' => __( 'Use Facebook comments' , 'cosmotheme' ), 'action' => "act.check( this , { 'yes' : '.fb_app_id ' , 'no' : '' } , 'sh' );" );
	options::$fields['general']['fb_app_id_note']       = array( 'type' => 'st--hint' , 'value' => __( 'You can set Facebook application ID' , 'cosmotheme' ) . ' <a href="admin.php?page=cosmothemes__social">' . __( 'here' , 'cosmotheme') . '</a> ' );
	options::$fields['general']['show_admin_bar']       = array( 'type' => 'st--logic-radio' , 'label' => __( 'Show WordPress admin bar' , 'cosmotheme' ));

	if( options::logic( 'general' , 'meta' ) ){
        options::$fields['general']['meta_view_style']['classes']     = 'meta_view';
    }else{
        options::$fields['general']['meta_view_style']['classes']     = 'meta_view hidden';
    }

	if( options::logic( 'general' , 'fb_comments' ) ){
        options::$fields['general']['fb_app_id_note']['classes']     = 'fb_app_id';
    }else{
        options::$fields['general']['fb_app_id_note']['classes']     = 'fb_app_id hidden';
    }

    options::$fields['general']['nsfw_content']         = array('type' => 'st--textarea' , 'label' => __( 'Default text for NSFW posts' , 'cosmotheme' ) , 'hint' => __( 'Type here the text that will warn non registered users that the post is marked NSFW' , 'cosmotheme' ) );
    options::$fields['general']['tracking_code']        = array('type' => 'st--textarea' , 'label' => __( 'Tracking code' , 'cosmotheme' ) , 'hint' => __( 'Paste your Google Analytics or other tracking code here.<br />It will be added into the footer of this theme' , 'cosmotheme' ) );
    options::$fields['general']['copy_right']   	    = array('type' => 'st--textarea' , 'label' => __( 'Copyright text' , 'cosmotheme' ) , 'hint' => __( 'Type here the Copyright text that will appear in the footer.<br />To display the current year use "%year%"' , 'cosmotheme' ) );
    
    options::$default['general']['copy_right'] 			= 'Copyright &copy; %year% <a href="http://cosmothemes.com" target="_blank">CosmoThemes</a>. All rights reserved.';


	/*Front end tabs settings*/
	options::$default['upload']['enb_image']            = 'yes';
	options::$default['upload']['enb_video']            = 'yes';
	options::$default['upload']['enb_text']             = 'yes';
	options::$default['upload']['enb_file']             = 'yes';
	options::$default['upload']['enb_audio']            = 'yes';
    options::$default['upload']['enb_edit_delete']      = 'yes';
    options::$default['upload']['post_item_page']       = '-';

	options::$fields['upload']['post_item_page']        = array( 'type' => 'st--select' , 'label' => __( 'Select front-end submission page' , 'cosmotheme' ) ,'hint' => __('Select a blank page from the list to generate the Post item page','cosmotheme') , 'value' => get__pages( array( '-' => __( 'Select page' , 'cosmotheme'  ) ) ) , 'action' => "act.select( '#up_page' , { '-' : '.up_page' } , 'hs' );"  , 'id' => 'up_page');
    options::$fields['upload']['enb_image']             = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable image submission' , 'cosmotheme') , 'hint' => __('If enabled users will be able to submit Image posts from front end','cosmotheme') );
	options::$fields['upload']['enb_video']             = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable video submission' , 'cosmotheme') , 'hint' => __('If enabled users will be able to submit Video posts from front end','cosmotheme') );
	options::$fields['upload']['enb_text']              = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable text submission' , 'cosmotheme') , 'hint' => __('If enabled users will be able to submit Text posts from front end','cosmotheme') );
	options::$fields['upload']['enb_file']              = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable file submission' , 'cosmotheme') , 'hint' => __('If enabled users will be able to submit File posts (attachments) from front end','cosmotheme') );
	options::$fields['upload']['enb_audio']             = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable audio submission' , 'cosmotheme') , 'hint' => __('If enabled users will be able to submit Audio posts from front end','cosmotheme') );
    options::$fields['upload']['enb_edit_delete']       = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable users to edit/deltete own posts' , 'cosmotheme')  );

	$default_post_status = array('publish' => __('Published','cosmotheme'), 'pending' => __('Pending','cosmotheme') );  
	options::$fields['upload']['default_posts_status']  = array('type' => 'st--select' , 'label' => __( 'Default posts status' , 'cosmotheme' ) ,'hint' => __('This is the status used for posts submited from front end','cosmotheme'), 'value' => $default_post_status, 'action' => "act.select( '#default_status' , { 'pending' : '.pending_email' } , 'sh' );", 'id' => 'default_status' );
    options::$fields['upload']['pending_email']         = array('type' => 'st--text' , 'label' => __( 'Contact email for pending posts' , 'cosmotheme' ), 'hint' => __('Enter a valid email address if you want to be notified via email when a new post is awaiting moderation','cosmotheme')  );
    
	if( options::get_value( 'upload' , 'post_item_page' ) == '-' ){
        options::$fields['upload']['enb_image']['classes']              = 'up_page hidden';
        options::$fields['upload']['enb_video']['classes']              = 'up_page hidden';
        options::$fields['upload']['enb_text']['classes']               = 'up_page hidden';
        options::$fields['upload']['enb_file']['classes']               = 'up_page hidden';
        options::$fields['upload']['enb_audio']['classes']              = 'up_page hidden';
        options::$fields['upload']['default_posts_status']['classes']   = 'up_page hidden';
    }else{
        options::$fields['upload']['enb_image']['classes']              = 'up_page';
        options::$fields['upload']['enb_video']['classes']              = 'up_page';
        options::$fields['upload']['enb_text']['classes']               = 'up_page';
        options::$fields['upload']['enb_file']['classes']               = 'up_page';
        options::$fields['upload']['enb_audio']['classes']              = 'up_page';
        options::$fields['upload']['default_posts_status']['classes']   = 'up_page';
    }
	
	if( options::get_value( 'upload' , 'post_item_page' ) != '-'  && options::get_value( 'upload' , 'default_posts_status') == 'pending' ){
		options::$fields['upload']['pending_email']['classes']          = 'pending_email up_page';
	}else{
		options::$fields['upload']['pending_email']['classes']          = 'pending_email  up_page hidden';
	}

	options::$default['upload']['default_posts_status'] = 'publish';

    /* LAYOUT DEFAULT VALUE */
    options::$default['layout']['front_page']           = 'right';
    options::$default['layout']['v_front_page']         = 'yes';
    options::$default['layout']['404']                  = 'right';
    options::$default['layout']['author']               = 'right';
    options::$default['layout']['v_author']             = 'yes';
    options::$default['layout']['page']                 = 'full';
    options::$default['layout']['single']               = 'right';
    options::$default['layout']['blog_page']            = 'right';
    options::$default['layout']['v_blog_page']          = 'yes';

    options::$default['layout']['search']               = 'right';
    options::$default['layout']['v_search']             = 'yes';
    options::$default['layout']['archive']              = 'right';
    options::$default['layout']['v_archive']            = 'yes';
    options::$default['layout']['category']             = 'right';
    options::$default['layout']['v_category']           = 'yes';
    options::$default['layout']['tag']                  = 'right';
    options::$default['layout']['v_tag']                = 'yes';
    options::$default['layout']['attachment']           = 'right';

    /* LAYOUT OPTIONS */
    $layouts                                            = array('left' => __( 'Left sidebar' , 'cosmotheme' ) , 'right' => __( 'Right sidebar' , 'cosmotheme' ) , 'full' => __( 'Full width' , 'cosmotheme' ) );
    $view                                               = array('yes' => __( 'List view' , 'cosmotheme' ) , 'no' => __( 'Grid view' , 'cosmotheme' ) ); /* yes - list view , no - grid view */
    $sidebars_record = options::get_value( '_sidebar' );
    if( !is_array( $sidebars_record ) || empty( $sidebars_record ) ){
        $sidebar = array( '' => 'main' );
    }else{
        foreach( $sidebars_record as $sidebars ){
            $sidebar[ trim( strtolower( str_replace( ' ' , '-' , $sidebars['title'] ) ) ) ] = $sidebars['title'];
        }
        $sidebar[''] = 'main';
    }

    options::$fields['layout']['title0']                = array('type' => 'ni--title' , 'title' => __( 'Front page' , 'cosmotheme' ) );
    options::$fields['layout']['front_page']            = array('type' => 'st--select' , 'label' => __( 'Layout for front page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.front_page_layout' , { 'left' : '.front_page_sidebar' , 'right' : '.front_page_sidebar' } , 'sh_' )" , 'iclasses' => 'front_page_layout' );
    options::$fields['layout']['front_page_sidebar']    = array('type' => 'st--select' , 'label' => __( 'Select sidebar for front page template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'front_page_sidebar' );
    if( options::get_value( 'layout' , 'front_page' ) == 'full' ){
        options::$fields['layout']['front_page_sidebar']['classes'] = 'front_page_sidebar hidden';
    }

    options::$fields['layout']['v_front_page']          = array('type' => 'st--select' , 'label' => __( 'View type for front page' , 'cosmotheme') , 'value' => $view );
    options::$fields['layout']['title1']                = array('type' => 'ni--title' , 'title' => __( '404' , 'cosmotheme' ) );
    options::$fields['layout']['404']                   = array('type' => 'st--select' , 'label' => __( 'Layout for 404 page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.layout_404' , { 'left' : '.sidebar_404' , 'right' : '.sidebar_404' } , 'sh_' )" , 'iclasses' => 'layout_404'  );
    options::$fields['layout']['404_sidebar']           = array('type' => 'st--select' , 'label' => __( 'Select sidebar for 404 template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'sidebar_404' );
    if( options::get_value( 'layout' , '404' ) == 'full' ){
        options::$fields['layout']['404_sidebar']['classes'] = 'sidebar_404 hidden';
    }
    options::$fields['layout']['title2']                = array('type' => 'ni--title' , 'title' => __( 'Author' , 'cosmotheme' ) );
    options::$fields['layout']['author']                = array('type' => 'st--select' , 'label' => __( 'Layout for author page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.author_layout' , { 'left' : '.author_sidebar' , 'right' : '.author_sidebar' } , 'sh_' )" , 'iclasses' => 'author_layout' );
    options::$fields['layout']['author_sidebar']        = array('type' => 'st--select' , 'label' => __( 'Select sidebar for author template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'author_sidebar' );
    if( options::get_value( 'layout' , 'author' ) == 'full' ){
        options::$fields['layout']['author_sidebar']['classes'] = 'author_sidebar hidden';
    }
    options::$fields['layout']['v_author']              = array('type' => 'st--select' , 'label' => __( 'View type for author page' , 'cosmotheme') , 'value' => $view );
    options::$fields['layout']['title3']                = array('type' => 'ni--title' , 'title' => __( 'Pages / single post' , 'cosmotheme' ) );
    options::$fields['layout']['page']                  = array('type' => 'st--select' , 'label' => __( 'Layout for pages' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.page_layout' , { 'left' : '.page_sidebar' , 'right' : '.page_sidebar' } , 'sh_' )" , 'iclasses' => 'page_layout' );
    options::$fields['layout']['page_sidebar']          = array('type' => 'st--select' , 'label' => __( 'Select sidebar for page template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'page_sidebar' );
    if( options::get_value( 'layout' , 'page' ) == 'full' ){
        options::$fields['layout']['page_sidebar']['classes'] = 'page_sidebar hidden';
    }
    options::$fields['layout']['single']                = array('type' => 'st--select' , 'label' => __( 'Layout for single post' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.single_layout' , { 'left' : '.single_sidebar' , 'right' : '.single_sidebar' } , 'sh_' )" , 'iclasses' => 'single_layout' );
    options::$fields['layout']['single_sidebar']        = array('type' => 'st--select' , 'label' => __( 'Select sidebar for single page template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'single_sidebar' );
    if( options::get_value( 'layout' , 'single' ) == 'full' ){
        options::$fields['layout']['single_sidebar']['classes'] = 'single_sidebar hidden';
    }
    options::$fields['layout']['title13']               = array('type' => 'ni--title' , 'title' => __( 'Blog page' , 'cosmotheme' ) );
    options::$fields['layout']['blog_page']             = array('type' => 'st--select' , 'label' => __( 'Layout for blog page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.blog_page_layout' , { 'left' : '.blog_page_sidebar' , 'right' : '.blog_page_sidebar' } , 'sh_' )" , 'iclasses' => 'blog_page_layout' );
    options::$fields['layout']['blog_page_sidebar']     = array('type' => 'st--select' , 'label' => __( 'Select sidebar for blog page template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'blog_page_sidebar' );
    if( options::get_value( 'layout' , 'blog_page' ) == 'full' ){
        options::$fields['layout']['blog_page_sidebar']['classes'] = 'blog_page_sidebar hidden';
    }
    options::$fields['layout']['v_blog_page']           = array('type' => 'st--select' , 'label' => __( 'View type for blog page' , 'cosmotheme') , 'value' => $view );

    options::$fields['layout']['title4']                = array('type' => 'ni--title' , 'title' => __( 'Search' , 'cosmotheme' ) );
    options::$fields['layout']['search']                = array('type' => 'st--select' , 'label' => __( 'Layout for search page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.search_layout' , { 'left' : '.search_sidebar' , 'right' : '.search_sidebar' } , 'sh_' )" , 'iclasses' => 'search_layout' );
    options::$fields['layout']['search_sidebar']        = array('type' => 'st--select' , 'label' => __( 'Select sidebar for search template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'search_sidebar' );
    if( options::get_value( 'layout' , 'search' ) == 'full' ){
        options::$fields['layout']['search_sidebar']['classes'] = 'search_sidebar hidden';
    }
    options::$fields['layout']['v_search']              = array('type' => 'st--select' , 'label' => __( 'View type for search page' , 'cosmotheme') , 'value' => $view );
    options::$fields['layout']['title5']                = array('type' => 'ni--title' , 'title' => __( 'Archive' , 'cosmotheme' ) );
    options::$fields['layout']['archive']               = array('type' => 'st--select' , 'label' => __( 'Layout for archive page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.archive_layout' , { 'left' : '.archive_sidebar' , 'right' : '.archive_sidebar' } , 'sh_' )" , 'iclasses' => 'archive_layout' );
    options::$fields['layout']['archive_sidebar']       = array('type' => 'st--select' , 'label' => __( 'Select sidebar for archive template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'archive_sidebar' );
    if( options::get_value( 'layout' , 'archive' ) == 'full' ){
        options::$fields['layout']['archive_sidebar']['classes'] = 'archive_sidebar hidden';
    }
    options::$fields['layout']['v_archive']             = array('type' => 'st--select' , 'label' => __( 'View type for archive page' , 'cosmotheme') , 'value' => $view );
    options::$fields['layout']['title6']                = array('type' => 'ni--title' , 'title' => __( 'Category' , 'cosmotheme' ) );
    options::$fields['layout']['category']              = array('type' => 'st--select' , 'label' => __( 'Layout for category page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.category_layout' , { 'left' : '.category_sidebar' , 'right' : '.category_sidebar' } , 'sh_' )" , 'iclasses' => 'category_layout' );
    options::$fields['layout']['category_sidebar']      = array('type' => 'st--select' , 'label' => __( 'Select sidebar for category template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'category_sidebar' );
    if( options::get_value( 'layout' , 'category' ) == 'full' ){
        options::$fields['layout']['category_sidebar']['classes'] = 'category_sidebar hidden';
    }
    options::$fields['layout']['v_category']            = array('type' => 'st--select' , 'label' => __( 'View type for category page' , 'cosmotheme') , 'value' => $view );;
    options::$fields['layout']['title7']                = array('type' => 'ni--title' , 'title' => __( 'Tags' , 'cosmotheme' ) );
    options::$fields['layout']['tag']                   = array('type' => 'st--select' , 'label' => __( 'Layout for tags page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.tag_layout' , { 'left' : '.tag_sidebar' , 'right' : '.tag_sidebar' } , 'sh_' )" , 'iclasses' => 'tag_layout' );
    options::$fields['layout']['tag_sidebar']           = array('type' => 'st--select' , 'label' => __( 'Select sidebar for tags template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'tag_sidebar' );
    if( options::get_value( 'layout' , 'tag' ) == 'full' ){
        options::$fields['layout']['tag_sidebar']['classes'] = 'tag_sidebar hidden';
    }
    options::$fields['layout']['v_tag']                 = array('type' => 'st--select' , 'label' => __( 'View type for tags page' , 'cosmotheme') , 'value' => $view );
    options::$fields['layout']['title8']                = array('type' => 'ni--title' , 'title' => '' );
    options::$fields['layout']['attachment']            = array('type' => 'st--select' , 'label' => __( 'Layout for attachment page' , 'cosmotheme' ) , 'value' => $layouts , 'action' => "act.select('.attachment_layout' , { 'left' : '.attachment_sidebar' , 'right' : '.attachment_sidebar' } , 'sh_' )" , 'iclasses' => 'attachment_layout' );
    options::$fields['layout']['attachment_sidebar']    = array('type' => 'st--select' , 'label' => __( 'Select sidebar for attachment template' , 'cosmotheme' ) , 'value' =>  $sidebar , 'classes' => 'attachment_sidebar' );
    if( options::get_value( 'layout' , 'attachment' ) == 'full' ){
        options::$fields['layout']['attachment_sidebar']['classes'] = 'attachment_sidebar hidden';
    }

    /* FRONT-PAGE DEFAULT VALUES */
    options::$default['front_page']['type']             = 'new_posts';
    options::$default['front_page']['order']            = 'yes';
    options::$default['front_page']['hot_label']        = __( 'Featured from around the world' , 'cosmotheme' ) ;
    options::$default['front_page']['new_label']        = __( 'Fresh from around the world' , 'cosmotheme' ) ;
    options::$default['front_page']['hot_nr_words']     = 1;
    options::$default['front_page']['new_nr_words']     = 1;
    options::$default['front_page']['hot_per_page']     = 10;
    options::$default['front_page']['new_per_page']     = 6;
    
    
    if( !options::logic( 'general' , 'enb_likes' ) ){
        if( options::get_value( 'front_page' , 'type' ) == 'hot_posts' || options::get_value( 'front_page' , 'type' ) == 'new_hot_posts' ){
            $fp = get_option( 'front_page' );
            $fp['type'] = 'new_posts';
            update_option( 'front_page' , $fp );
        }
    }
    
    /* FRONT-PAGE OPTIONS */
    if( !options::logic( 'general' , 'enb_likes' ) ){
        $type = array( 'page' => __( 'Static Page' , 'cosmotheme' ) , 'new_posts' => __( 'Fresh Posts' , 'cosmotheme' ) );
    }else{
        $type = array( 'page' => __( 'Static Page' , 'cosmotheme' ) , 'hot_posts' => __( 'Featured Posts' , 'cosmotheme' ) , 'new_posts' => __( 'Fresh Posts' , 'cosmotheme' ) , 'new_hot_posts' => __( 'Fresh &amp Featured Posts' , 'cosmotheme' ) );
    }
    options::$fields['front_page']['type']              = array( 'type' => 'st--select' , 'label' => __( 'Select content type' , 'cosmotheme' ) , 'value' =>  $type , 'action' => "act.select( '.fp_type' , { 'page':'.fp_page' , 'hot_posts':'.fp_hot' , 'new_posts':'.fp_inew , .fp_new' , 'new_hot_posts' : '.fp_new_hot , .fp_hot, .fp_new' } , 'sh_' );" , 'iclasses' => 'fp_type' );
    options::$fields['front_page']['page']              = array( 'type' => 'st--select' , 'label' => __( 'Select static page for front page' , 'cosmotheme' ) , 'value' => get__pages() );
    options::$fields['front_page']['info_page']         = array( 'type' => 'st--hint' , 'value' => __( 'If you wish to set blog page go to '  , 'cosmotheme' ) . '<a href="options-reading.php">' . __( 'Settings -> Reading ' , 'cosmotheme' ) . '</a>' );
    if( options::logic( 'general' ,  'enb_likes' ) ){
        options::$fields['front_page']['info_hot']          = array( 'type' => 'st--hint' , 'value' => __( 'Please set Love limit for Featured posts in '  , 'cosmotheme' ) . '<a href="admin.php?page=cosmothemes__general">' . __( 'General settings' , 'cosmotheme' ) . '</a>' );
    }
    options::$fields['front_page']['info_new']          = array( 'type' => 'st--hint' , 'value' => __( 'Classic blog style '  , 'cosmotheme' ) );
    options::$fields['front_page']['order']             = array( 'type' => 'st--label-logic-radio' , 'label' => __( 'Select order' , 'cosmotheme') , 'rlabel' => array( __( 'Fresh / Featured'  , 'cosmotheme' ) , __( 'Featured / Fresh ' , 'cosmotheme' ) ) , 'classes' => 'fp_new_hot' );

    options::$fields['front_page']['hot_title']         = array( 'type' => 'ni--title' , 'title' => __( 'Settings for Featured posts' , 'cosmotheme' ) );
    options::$fields['front_page']['hot_per_page']      = array( 'type' => 'st--select' , 'label'  => __( 'Number of Featured posts per page' , 'cosmotheme' ) , 'value' => fields::digit_array( 20 , 1) );
    options::$fields['front_page']['v_hot']             = array( 'type' => 'st--select' , 'label' => __( 'View type for Featured posts' , 'cosmotheme' ) , 'value' => $view );
    options::$fields['front_page']['hot_label']         = array( 'type' => 'st--text' , 'label' => __( 'Set label for Featured posts' , 'cosmotheme' ) );
    options::$fields['front_page']['hot_nr_words']      = array( 'type' => 'st--select' , 'label' => __( 'Select number of linked words for Featured label' , 'cosmotheme' ) , 'value' => fields::digit_array( 10 ) );
    options::$fields['front_page']['enb_hot_pg']        = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable pagination' , 'cosmotheme') );

    options::$fields['front_page']['new_title']         = array( 'type' => 'ni--title' , 'title' => __( 'Settings for Fresh posts' , 'cosmotheme' ) );
    options::$fields['front_page']['new_per_page']      = array( 'type' => 'st--select' , 'label'  => __( 'Number of Fresh posts per page' , 'cosmotheme' ) , 'value' => fields::digit_array( 20 , 1) );
    options::$fields['front_page']['v_new']             = array( 'type' => 'st--select' , 'label' => __( 'View type for Fresh posts' , 'cosmotheme' ) , 'value' => $view );
    options::$fields['front_page']['new_label']         = array( 'type' => 'st--text' , 'label' => __( 'Set label for Fresh posts' , 'cosmotheme' ) );
    options::$fields['front_page']['new_nr_words']      = array( 'type' => 'st--select' , 'label' => __( 'Select number of linked words for Fresh label' , 'cosmotheme' ) , 'value' => fields::digit_array( 10 ) );
    options::$fields['front_page']['enb_new_pg']        = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable pagination' , 'cosmotheme') );

    if( options::get_value( 'front_page' , 'type' ) == 'page' ){
        options::$fields['front_page']['page']['classes']           = 'fp_page';
        options::$fields['front_page']['info_page']['classes']      = 'fp_page';
        if( options::logic( 'general' ,  'enb_likes' ) ){
            options::$fields['front_page']['info_hot']['classes']   = 'fp_hot hidden';
        }
        options::$fields['front_page']['info_new']['classes']       = 'fp_inew hidden';
        options::$fields['front_page']['order']['classes']          = 'fp_new_hot hidden';
        options::$fields['front_page']['v_hot']['classes']          = 'fp_hot hidden';
        options::$fields['front_page']['v_new']['classes']          = 'fp_new hidden';
        options::$fields['front_page']['hot_nr_words']['classes']   = 'fp_hot hidden';
        options::$fields['front_page']['new_nr_words']['classes']   = 'fp_new hidden';
        options::$fields['front_page']['hot_label']['classes']      = 'fp_hot hidden';
        options::$fields['front_page']['new_label']['classes']      = 'fp_new hidden';
        options::$fields['front_page']['hot_per_page']['classes']   = 'fp_hot hidden';
        options::$fields['front_page']['new_per_page']['classes']   = 'fp_new hidden';
        options::$fields['front_page']['hot_title']['classes']      = 'fp_hot hidden';
        options::$fields['front_page']['new_title']['classes']      = 'fp_new hidden';
        options::$fields['front_page']['enb_hot_pg']['classes']     = 'fp_hot hidden';
        options::$fields['front_page']['enb_new_pg']['classes']     = 'fp_new hidden';
    }

    if( options::get_value( 'front_page' , 'type' ) == 'hot_posts' ){
        options::$fields['front_page']['page']['classes']           = 'fp_page hidden';
        options::$fields['front_page']['info_page']['classes']      = 'fp_page hidden';
        if( options::logic( 'general' ,  'enb_likes' ) ){
            options::$fields['front_page']['info_hot']['classes']   = 'fp_hot';
        }
        options::$fields['front_page']['info_new']['classes']       = 'fp_inew hidden';
        options::$fields['front_page']['order']['classes']          = 'fp_new_hot hidden';
        options::$fields['front_page']['v_hot']['classes']          = 'fp_hot';
        options::$fields['front_page']['v_new']['classes']          = 'fp_new hidden';
        options::$fields['front_page']['hot_nr_words']['classes']   = 'fp_hot';
        options::$fields['front_page']['new_nr_words']['classes']   = 'fp_new hidden';
        options::$fields['front_page']['hot_label']['classes']      = 'fp_hot';
        options::$fields['front_page']['new_label']['classes']      = 'fp_new hidden';
        options::$fields['front_page']['hot_per_page']['classes']   = 'fp_hot';
        options::$fields['front_page']['new_per_page']['classes']   = 'fp_new hidden';
        options::$fields['front_page']['hot_title']['classes']      = 'fp_hot';
        options::$fields['front_page']['new_title']['classes']      = 'fp_new hidden';
        options::$fields['front_page']['enb_hot_pg']['classes']     = 'fp_hot';
        options::$fields['front_page']['enb_new_pg']['classes']     = 'fp_new hidden';
    }

    if( options::get_value( 'front_page' , 'type' ) == 'new_posts' ){
        options::$fields['front_page']['page']['classes']           = 'fp_page hidden';
        options::$fields['front_page']['info_page']['classes']      = 'fp_page hidden';
        if( options::logic( 'general' ,  'enb_likes' ) ){
            options::$fields['front_page']['info_hot']['classes']   = 'fp_hot hidden';
        }
        options::$fields['front_page']['info_new']['classes']       = 'fp_inew';
        options::$fields['front_page']['order']['classes']          = 'fp_new_hot hidden';
        options::$fields['front_page']['v_hot']['classes']          = 'fp_hot hidden';
        options::$fields['front_page']['v_new']['classes']          = 'fp_new';
        options::$fields['front_page']['hot_nr_words']['classes']   = 'fp_hot hidden';
        options::$fields['front_page']['new_nr_words']['classes']   = 'fp_new';
        options::$fields['front_page']['hot_label']['classes']      = 'fp_hot hidden';
        options::$fields['front_page']['new_label']['classes']      = 'fp_new';
        options::$fields['front_page']['hot_per_page']['classes']   = 'fp_hot hidden';
        options::$fields['front_page']['new_per_page']['classes']   = 'fp_new';
        options::$fields['front_page']['hot_title']['classes']      = 'fp_hot hidden';
        options::$fields['front_page']['new_title']['classes']      = 'fp_new';
        options::$fields['front_page']['enb_hot_pg']['classes']     = 'fp_hot hidden';
        options::$fields['front_page']['enb_new_pg']['classes']     = 'fp_new';
    }

    if( options::get_value( 'front_page' , 'type' ) == 'new_hot_posts' ){

        options::$fields['front_page']['page']['classes']           = 'fp_page hidden';
        options::$fields['front_page']['info_page']['classes']      = 'fp_page hidden';
        if( options::logic( 'general' ,  'enb_likes' ) ){
            options::$fields['front_page']['info_hot']['classes']   = 'fp_hot';
        }
        options::$fields['front_page']['info_new']['classes']       = 'fp_inew hidden';
        options::$fields['front_page']['order']['classes']          = 'fp_new_hot';
        options::$fields['front_page']['v_hot']['classes']          = 'fp_hot';
        options::$fields['front_page']['v_new']['classes']          = 'fp_new';
        options::$fields['front_page']['hot_nr_words']['classes']   = 'fp_hot';
        options::$fields['front_page']['new_nr_words']['classes']   = 'fp_new';
        options::$fields['front_page']['hot_label']['classes']      = 'fp_hot';
        options::$fields['front_page']['new_label']['classes']      = 'fp_new';
        options::$fields['front_page']['hot_per_page']['classes']   = 'fp_hot';
        options::$fields['front_page']['new_per_page']['classes']   = 'fp_new';
        options::$fields['front_page']['hot_title']['classes']      = 'fp_hot';
        options::$fields['front_page']['new_title']['classes']      = 'fp_new';
        options::$fields['front_page']['enb_hot_pg']['classes']     = 'fp_hot';
        options::$fields['front_page']['enb_new_pg']['classes']     = 'fp_new';
    }

	/* STYLING DEFAULT VALUES */
    options::$default['styling']['front_end']           = 'no';
	options::$default['styling']['background']			= 'paper';
    options::$default['styling']['logo_type']           = 'text';
	options::$default['styling']['background_color']    = '#ffffff';
    options::$default['styling']['footer_bg_color']     = '#414B52';
    options::$default['styling']['stripes']             = 'yes';

    /* STYLING OPTIONS */
    options::$fields['styling']['front_end']            = array( 'type' => 'st--logic-radio' , 'label' => __( 'Allow theme stylesheet change' , 'cosmotheme' ) , 'hint' => __( 'Allow front-end users to change theme stylesheet.<br />The chosen style will be saved in users cookies' , 'cosmotheme' ) );
    

    $pattern_path = 'pattern/s.pattern.';
    $pattern = array(
        "flowers"=>"flowers.png" , "flowers_2"=>"flowers_2.png" , "flowers_3"=>"flowers_3.png" , "flowers_4"=>"flowers_4.png" ,"circles"=>"circles.png","dots"=>"dots.png","grid"=>"grid.png","noise"=>"noise.png",
        "paper"=>"paper.png","rectangle"=>"rectangle.png","squares_1"=>"squares_1.png","squares_2"=>"squares_2.png","thicklines"=>"thicklines.png","thinlines"=>"thinlines.png" , "none"=>"none.png"
    );

    options::$fields['styling']['bg_title']             = array( 'type' => 'ni--title' , 'title' => __( 'Select theme background' , 'cosmotheme' ) );
    options::$fields['styling']['background']           = array( 'type' => 'ni--radio-icon' ,  'value' => $pattern , 'path' => $pattern_path , 'in_row' => 6 );
    
    /* color */
    /* background */
    options::$fields['styling']['background_color']     = array('type' => 'st--color-picker' , 'label' => __( 'Set background color' , 'cosmotheme' ) );
    options::$fields['styling']['footer_bg_color']      = array('type' => 'st--color-picker' , 'label' => __( 'Set footer background color' , 'cosmotheme' ) );
    options::$fields['styling']['background_image']     = array( 'type' => 'st--hint' , 'value' => __( 'To set a background image go to' , 'cosmotheme' ) . ' <a href="themes.php?page=custom-background">' . __( 'Appearence - Background'  , 'cosmotheme' ) . '</a>' );

    $path_parts = pathinfo( options::get_value( 'styling' , 'favicon' ) );
    if( strlen( options::get_value( 'styling' , 'favicon' ) ) && $path_parts['extension'] != 'ico' ){
        $ico_hint = '<span style="color:#cc0000;">' . __( 'Error, please select "ico" type media file' , 'cosmotheme' ) . '</span>';
    }else{
        $ico_hint = __( "Please select 'ico' type media file. Make sure you allow uploading 'ico' type in General Settings -> Upload file types" , 'cosmotheme' );
    }

    options::$fields['styling']['favicon']              = array('type' => 'st--upload' , 'label' => __( 'Custom favicon' , 'cosmotheme' ) , 'id' => 'favicon_path' , 'hint' => $ico_hint );
    options::$fields['styling']['logo_type']            = array('type' => 'st--select' , 'label' => __( 'Logo type ' , 'cosmotheme' ) , 'value' => array( 'text' => 'Text logo' , 'image' => 'Image logo' ) , 'hint' => __( 'Enable text-based site title and tagline.' , 'cosmotheme' ) , 'action' => "act.select( '.g_logo_type' , { 'text':'.g_logo_text' , 'image':'.g_logo_image' } , 'sh_' );" , 'iclasses' => 'g_logo_type' );

    options::$fields['styling']['stripes']              = array('type' => 'st--logic-radio' , 'label' => __( 'Enable stripes effect for post images' , 'cosmotheme' ) );
    /* fields for general -> logo_type */
    options::$fields['styling']['logo_url']             = array('type' => 'st--upload' , 'label' => __( 'Custom logo URL' , 'cosmotheme' ) , 'id' => 'logo_path' );

    /* hide not used fields */
	if( options::get_value( 'styling' , 'logo_type') == 'image' ){
        options::$fields['styling']['logo_url']['classes'] 	= 'g_logo_image';
        text::fields( 'styling' , 'logo' ,  'g_logo_text hidden' , get_option( 'blogname' ) );
        options::$fields['styling']['hint']                 = array('type' => 'st--hint' , 'classes' => 'g_logo_text hidden' ,'value' => __( 'To change blog title go to <a href="options-general.php">General settings</a> ' , 'cosmotheme') );
    }else{
		options::$fields['styling']['logo_url']['classes'] 	= 'generic-hint g_logo_image hidden';
        text::fields( 'styling' , 'logo' ,  'g_logo_text' , get_option( 'blogname' ) );
        options::$fields['styling']['hint']                 = array('type' => 'st--hint' , 'classes' => 'generic-hint g_logo_text' , 'value' => __( 'To change blog title go to <a href="options-general.php">General settings </a> ' , 'cosmotheme') );
    }
    
	/* MENU DEFAULT VALUES */
    options::$default['menu']['megusta']                = 'yes';
    options::$default['menu']['header']                 = 8;
    options::$default['menu']['footer']                 = 4;
    
    options::$default['menu']['home']                   = __( 'Home' , 'cosmotheme' );
    options::$default['menu']['home_']                  = __( 'welcome' , 'cosmotheme' );
    options::$default['menu']['featured']               = __( 'Featured' , 'cosmotheme' );
    options::$default['menu']['featured_']              = __( 'voted posts' , 'cosmotheme' );
    options::$default['menu']['fresh']                  = __( 'Fresh' , 'cosmotheme' );
    options::$default['menu']['fresh_']                 = __( 'new on site' , 'cosmotheme' );
    options::$default['menu']['random']                 = __( 'I feel lucky' , 'cosmotheme' );
    options::$default['menu']['random_']                = __( 'random posts' , 'cosmotheme' );
            
    /* MENU OPTIONS */
    options::$fields['menu']['def_menu']                = array('type' => 'ni--title' , 'title' => __( 'Default menu' , 'cosmotheme' ) );
    options::$fields['menu']['megusta']                 = array('type' => 'st--logic-radio' , 'label' => __( 'Enable default menu' , 'cosmotheme' ) , 'hint' => __( 'To create a custom  menu go to ' , 'cosmotheme' ) . '<a a href="' . home_url('/wp-admin/nav-menus.php') . '">' . __( 'Appearance -> Menus' , 'cosmotheme' ) . '</a>' , 'action' => "act.check( this , { 'yes' : '.def_menu ' , 'no' : '' } , 'sh' );" );
    options::$fields['menu']['home']                    = array('type' => 'st--text' , 'label' => __( 'Label for Mainpage' , 'cosmotheme' ) );
    options::$fields['menu']['home_']                   = array('type' => 'st--text' , 'label' => __( 'Description for Mainpage' , 'cosmotheme' ) );
    options::$fields['menu']['featured']                = array('type' => 'st--text' , 'label' => __( 'Label for Featured link' , 'cosmotheme' ) );
    options::$fields['menu']['featured_']               = array('type' => 'st--text' , 'label' => __( 'Description for Featured link' , 'cosmotheme' ) );
    options::$fields['menu']['fresh']                   = array('type' => 'st--text' , 'label' => __( 'Label for Fresh link' , 'cosmotheme' ) );
    options::$fields['menu']['fresh_']                  = array('type' => 'st--text' , 'label' => __( 'Description for Fresh link' , 'cosmotheme' ) );
    options::$fields['menu']['random']                  = array('type' => 'st--text' , 'label' => __( 'Label for Random link' , 'cosmotheme' ) );
    options::$fields['menu']['random_']                 = array('type' => 'st--text' , 'label' => __( 'Description for Random link' , 'cosmotheme' ) );
    
    if( options::logic( 'menu' , 'megusta' ) ){
        options::$fields['menu']['home']['classes']     = 'def_menu';
        options::$fields['menu']['home_']['classes']    = 'def_menu';
        options::$fields['menu']['featured']['classes'] = 'def_menu';
        options::$fields['menu']['featured_']['classes']= 'def_menu';
        options::$fields['menu']['fresh']['classes']    = 'def_menu';
        options::$fields['menu']['fresh_']['classes']   = 'def_menu';
        options::$fields['menu']['random']['classes']   = 'def_menu';
        options::$fields['menu']['random_']['classes']  = 'def_menu';
    }else{
        options::$fields['menu']['home']['classes']     = 'def_menu hidden';
        options::$fields['menu']['home_']['classes']    = 'def_menu hidden';
        options::$fields['menu']['featured']['classes'] = 'def_menu hidden';
        options::$fields['menu']['featured_']['classes']= 'def_menu hidden';
        options::$fields['menu']['fresh']['classes']    = 'def_menu hidden';
        options::$fields['menu']['fresh_']['classes']   = 'def_menu hidden';
        options::$fields['menu']['random']['classes']   = 'def_menu hidden';
        options::$fields['menu']['random_']['classes']  = 'def_menu hidden';
    }
    
    options::$fields['menu']['custom_menu']             = array('type' => 'ni--title' , 'title' => __( 'Custom menu' , 'cosmotheme' ) );
    options::$fields['menu']['header']                  = array('type' => 'st--select' , 'value' => fields::digit_array( 20 ) , 'label' => __( 'Set limit for main menu' , 'cosmotheme' ) , 'hint' => __( 'Set the number of visible menu items. Remaining menu items<br />will be shown in the drop down menu item "More"' , 'cosmotheme' ) );
    /*options::$fields['menu']['footer']                  = array('type' => 'st--select' , 'value' => fields::digit_array( 20 ) , 'label' => __( 'Set limit for footer menu' , 'cosmotheme' ) , 'hint' => __( 'Set the number of visible menu items' , 'cosmotheme' ) );*/

    /* POSTS OPTIONS */
    options::$fields['blog_post']['post_title0']        = array('type' => 'ni--title' , 'title' => __( 'General Posts Settings' , 'cosmotheme' ) );

    options::$fields['blog_post']['show_similar']       = array('type' => 'st--logic-radio' , 'label' => __( 'Enable similar posts' , 'cosmotheme' ), 'action' => "act.check( this , { 'yes' : '.similar_type_class ' , 'no' : '' } , 'sh' );" );
    options::$fields['blog_post']['post_similar_full']  = array('type' => 'st--select' , 'value' => fields::digit_array( 20 , 1 ) , 'label' => __( 'Number of similar posts (full width)' , 'cosmotheme' ) );
    options::$fields['blog_post']['post_similar_side']  = array('type' => 'st--select' , 'value' => fields::digit_array( 20 , 1 ) , 'label' => __( 'Number of similar posts (with sidebar)' , 'cosmotheme' ) );
    
	$similar_type_options = array('post_tag'=>__('Same tags','cosmotheme'), 'category'=> __('Same category','cosmotheme'));
    
	options::$fields['blog_post']['similar_type']       = array('type' => 'st--select' , 'value' => $similar_type_options , 'label' => __( 'Similar posts criteria' , 'cosmotheme' ) );
    options::$fields['blog_post']['post_sharing']       = array('type' => 'st--logic-radio' , 'label' => __( 'Enable social sharing for posts' , 'cosmotheme' ) );
    options::$fields['blog_post']['post_author_box']    = array('type' => 'st--logic-radio' , 'label' => __( 'Display post author box' , 'cosmotheme' ) , 'hint' => __( 'This will enable the author box on posts.<br /> Edit description in Users > Your Profile' , 'cosmotheme' ) );
	options::$fields['blog_post']['show_source'] 	    = array('type' => 'st--logic-radio' , 'label' => __( 'Display post source' , 'cosmotheme' )  );
	
	

    options::$fields['blog_post']['post_title1']        = array('type' => 'ni--title' , 'title' => __( 'General Page Settings' , 'cosmotheme' ) );
    options::$fields['blog_post']['page_sharing']       = array('type' => 'st--logic-radio' , 'label' => __( 'Enable social sharing for page' , 'cosmotheme' ) );
    options::$fields['blog_post']['page_author_box']    = array('type' => 'st--logic-radio' , 'label' => __( 'Display page author box' , 'cosmotheme' ) , 'hint' => __( 'This will enable the author box on pages.<br /> Edit description in Users > Your Profile' , 'cosmotheme' ) );

    options::$fields['blog_post']['post_title2']        = array('type' => 'ni--title' , 'title' => __( 'Attachment Posts Settings' , 'cosmotheme' ) );
    options::$fields['blog_post']['attachment_sharing'] = array('type' => 'st--logic-radio' , 'label' => __( 'Enable social sharing for attachment posts' , 'cosmotheme' ) );
    options::$fields['blog_post']['attachment_comments']= array('type' => 'st--logic-radio' , 'label' => __( 'Enable comments for attachment posts' , 'cosmotheme' ) );

    /* POSTS DEFAULT VALUE */
    options::$default['blog_post']['post_similar_full'] = 3;
    options::$default['blog_post']['post_similar_side'] = 2;
    options::$default['blog_post']['show_similar']      = 'yes';
    options::$default['blog_post']['post_sharing']      = 'yes';
    options::$default['blog_post']['post_author_box']   = 'no';
	options::$default['blog_post']['show_source'] 		= 'yes';
    options::$default['blog_post']['page_sharing']      = 'yes';
    options::$default['blog_post']['page_author_box']   = 'no';
    options::$default['blog_post']['author_sharing']    = 'no';
    options::$default['blog_post']['attachment_sharing']= 'yes';
    options::$default['blog_post']['attachment_comments']= 'yes';
	options::$default['blog_post']['similar_type']= 'post_tag';

	if( options::logic( 'blog_post' , 'show_similar' ) ){
		options::$fields['blog_post']['similar_type']['classes']     = 'similar_type_class';
        options::$fields['blog_post']['post_similar_full']['classes']= 'similar_type_class';
        options::$fields['blog_post']['post_similar_side']['classes']= 'similar_type_class';
	}else{ 
		options::$fields['blog_post']['similar_type']['classes']     = 'similar_type_class hidden';
        options::$fields['blog_post']['post_similar_full']['classes']= 'similar_type_class hidden';
        options::$fields['blog_post']['post_similar_side']['classes']= 'similar_type_class hidden';
	}

    /* ADVERTISEMENT SPACES */
    options::$fields['advertisement']['logo']           = array('type' => 'st--textarea' , 'label' => __( 'Advertisement area nr. 1' , 'cosmotheme' ) , 'hint' => __( 'Insert your advertisement code here<br />This is ad area below logo' , 'cosmotheme' ) );
    options::$fields['advertisement']['content']        = array('type' => 'st--textarea' , 'label' => __( 'Advertisement area nr. 2' , 'cosmotheme' ) , 'hint' => __( 'Insert your advertisement code here<br />This is ad area below post content' , 'cosmotheme' ) );

    /* SOCIAL OPTIONS */
    options::$fields['social']['twitter']               = array('type' => 'st--text' , 'label' => __( 'Twitter ID' , 'cosmotheme' ) , 'hint' => __( '' , 'cosmotheme' ) );
    options::$fields['social']['facebook']              = array('type' => 'st--text' , 'label' => __( 'Facebook profile ID' , 'cosmotheme' ) , 'hint' => __( '' , 'cosmotheme' ) );
    options::$fields['social']['facebook_app_id']       = array('type' => 'st--text' , 'label' => __( 'Facebook Application ID' , 'cosmotheme' ) , 'hint' => __( 'You can create a fb application from <a href="https://developers.facebook.com/apps">here</a>' , 'cosmotheme' ) );
    options::$fields['social']['facebook_secret']       = array('type' => 'st--text' , 'label' => __( 'Facebook Secret key' , 'cosmotheme' ) , 'hint' => __( 'Needed for Facebook Connect' , 'cosmotheme' ) );
    options::$fields['social']['linkedin']              = array('type' => 'st--text' , 'label' => __( 'LinkedIn public profile URL' , 'cosmotheme' ) , 'hint' => __( '(i.e. http://www.linkedin.com/company/cosmothemes)' , 'cosmotheme' ) );
    options::$fields['social']['email']                 = array('type' => 'st--text' , 'label' => __( 'Contact email' , 'cosmotheme' )  );
    options::$fields['social']['flickr']                = array('type' => 'st--text' , 'label' => __( 'Flickr ID' , 'cosmotheme' ) , 'hint' => __( 'Insert your Flickr ID (<a target="_blank" href="http://www.idgettr.com">idGettr</a>)' , 'cosmotheme' ) );
    options::$fields['social']['google_map']            = array('type' => 'st--text' , 'label' => __( 'Google map key' , 'cosmotheme' ) , 'hint' => __( 'This key is neded to use Google map inside the contact form' , 'cosmotheme' ) );
    
    /* SLIDER */
    options::$default['slider']['slideshow']            = -1;
    $sliders = get__posts( array( 'post_type' => 'slideshow' ) , '' );
    
    if( count( $sliders ) == 0 ){
        options::$fields['slider']['slide_label']       = array( 'type' => 'st--hint' , 'value' => __( 'No sliders. To create a slide go to '  , 'cosmotheme' ) . '<a href="post-new.php?post_type=slideshow">' . __( 'Add New Slideshow' , 'cosmotheme' ) . '</a>' );
    }else{
        options::$fields['slider']['slideshow']         = array('type' => 'st--search' , 'label' => __( 'Select default slideshow' , 'cosmotheme' ) , 'query' => array( 'post_type' => 'slideshow' , 'post_status' => 'publish' ) , 'hint' => __( 'Start typing the Slideshow tile' , 'cosmotheme' ) , 'action' => "act.search( this , '.sl_settings')" );
    }
    
    options::$fields['slider']['buttons']               = array( 'type' => 'st--select' , 'label'=> __( 'Generate next/previous buttons' , 'cosmotheme' ) , 'value' =>  array('true' =>'Yes' , 'false' => 'No' ) );
    options::$fields['slider']['slidespeed']            = array( 'type' => 'st--digit' , 'label' => __( 'Sliding animation speed ' , 'cosmotheme' )  , 'hint' => __( 'Set interval in milliseconds' , 'cosmotheme' ) );
    options::$fields['slider']['playspeed']             = array( 'type' => 'st--digit' , 'label'=> __( 'Time between slides' , 'cosmotheme' ) , 'hint' => __( 'Set interval in milliseconds' , 'cosmotheme' ) );
    options::$fields['slider']['effect']                = array( 'type' => 'st--select' , 'label'=> __( 'Set effect' , 'cosmotheme' ) , 'value' => array( 'slide, fade' => 'Slide' , 'fade' => 'Fade' ) );
    options::$fields['slider']['randomize']             = array( 'type' => 'st--select' , 'label'=> __( 'Randomize files' , 'cosmotheme' ) , 'value' => array( 'true' => 'Yes' , 'false' => 'No' ) );
    options::$fields['slider']['pause']                 = array( 'type' => 'st--select' , 'label'=> __( 'Pause slideshow on mouse over' , 'cosmotheme' ) , 'value' => array( 'true' => 'Yes' , 'false' => 'No' ) );
    
    /* SLIDER DEFAULT VALUES */
    if( options::get_value( 'slider' , 'slideshow' ) == -1 ){
        $sliders = get_posts( array( 'post_type' => 'slideshow' ) );
		if(sizeof($sliders)){  
			options::$default['slider']['slideshow'] = $sliders[ 0 ] -> ID; 
		}  
    }
    
    if( strlen( options::get_value( 'slider' , 'slideshow') ) > 0 ){
        options::$fields['slider']['buttons']['classes']        = 'sl_settings';
        options::$fields['slider']['slidespeed']['classes']     = 'sl_settings';
        options::$fields['slider']['playspeed']['classes']      = 'sl_settings';
        options::$fields['slider']['effect']['classes']         = 'sl_settings';
        options::$fields['slider']['randomize']['classes']      = 'sl_settings';
        options::$fields['slider']['pause']['classes']          = 'sl_settings';
    }else{
        options::$fields['slider']['buttons']['classes']        = 'sl_settings hidden';
        options::$fields['slider']['slidespeed']['classes']     = 'sl_settings hidden';
        options::$fields['slider']['playspeed']['classes']      = 'sl_settings hidden';
        options::$fields['slider']['effect']['classes']         = 'sl_settings hidden';
        options::$fields['slider']['randomize']['classes']      = 'sl_settings hidden';
        options::$fields['slider']['pause']['classes']          = 'sl_settings hidden';
    }
    
    options::$default['slider']['buttons']              = 'true';
    options::$default['slider']['slidespeed']           =  600 ;
    options::$default['slider']['playspeed']            =  5000 ;
    options::$default['slider']['effect']               = 'slide, fade';
    options::$default['slider']['randomize']            = 'false';
    options::$default['slider']['pause']                = 'true';
    
    /* sidebar manager */
    $struct = array(
        'layout' => 'A',
        'check-column' => array(
            'name' => 'idrow[]',
            'type' => 'hidden'
        ),
        'info-column-0' => array(
            0 => array(
                'name' => 'title',
                'type' => 'text',
                'label' => 'Sidebar Title',
                'classes' => 'sidebar-title'
            )
        ),
        'select' => 'title',
        'actions' => array( 'sortable' => true )
    );

    /* delete_option( '_sidebar' ); */
    /* SOCIAL OPTIONS */
    options::$fields['_sidebar']['idrow']               = array('type' => 'st--m-hidden' , 'value' => 1 , 'id' => 'sidebar_title_id' , 'single' => true );
    options::$fields['_sidebar']['title']               = array('type' => 'st--text' , 'label' => __( 'Set title for new sidebar','cosmotheme' ) , 'id' => 'sidebar_title' , 'single' => true );
    options::$fields['_sidebar']['save']                = array('type' => 'st--button' , 'value' => 'Add new sidebar' , 'action' => "extra.add( '_sidebar' , { 'input' : [ 'sidebar_title_id' , 'sidebar_title'] })" );

    options::$fields['_sidebar']['struct']              = $struct;
    options::$fields['_sidebar']['hint']                = __( 'List of generic dynamic sidebars<br />Drag and drop blocks to rearrange position' , 'cosmotheme' );

    options::$fields['_sidebar']['list']                = array( 'type' => 'ex--extra' , 'cid' => 'container__sidebar');
    
    /*Cosmothemes options*/

	options::$default['cosmothemes']['show_new_version']      = 'yes';
	options::$default['cosmothemes']['show_cosmo_news']      = 'yes';
	options::$fields['cosmothemes']['show_new_version'] = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable notification about new theme version' , 'cosmotheme' ) );
	options::$fields['cosmothemes']['show_cosmo_news']  = array( 'type' => 'st--logic-radio' , 'label' => __( 'Enable Cosmothemes news notification' , 'cosmotheme' ) );

    /* tooltips */
    $type = array( 'left' => __( 'Left' , 'cosmotheme' ) , 'right' => __( 'Right' , 'cosmotheme' ) , 'top' => __( 'Top' , 'cosmotheme' ) );
    $res_type = array( 'front_page' => __( 'On front page' , 'cosmotheme' ) , 'single' => __( 'On single post' , 'cosmotheme' ) , 'page' => __( 'On simple page' , 'cosmotheme' ) );
    $res_pages = get__pages( __( 'Select Page' , 'cosmotheme' ) );
    $tooltips = array(
        'layout' => 'A',
        'check-column' => array(
            'name' => 'idrow',
            'type' => 'hidden',
            'classes' => 'idrow'
        ),
        'info-column-0' => array(
            0 => array(
                'name' => 'title',
                'type' => 'text',
                'label' => 'Tooltip title',
                'classes' => 'tooltip-title',
                'before' => '<strong>',
                'after' => '</strong>',
            ),
            1 => array(
                'name' => 'description',
                'type' => 'textarea',
                'label' => 'Tooltip description',
                'classes' => 'tooltip-description'
            ),
            2 => array(
                'name' => 'res_type',
                'type' => 'select',
                'assoc' => $res_type,
                'label' => 'Location',
                'lvisible' => false,
                'classes' => 'tooltip-res-type',
                'action' => array( 'single' => 'res_posts' , 'page' => 'res_pages' , 'method' => 'sh_' ),
            ),
            3 => array(
                'name' => 'res_posts',
                'type' => 'search',
                'query' => array( 'post_type' => 'post' , 'post_status' => 'publish' ),
                'label' => '',
                'lvisible' => false,
                'classes' => 'tooltip-res-posts',
                'linked' => array( 'res_type' , 'single' ),
            ),
            4 => array(
                'name' => 'res_pages',
                'type' => 'select',
                'assoc' => $res_pages,
                'label' => '',
                'lvisible' => false,
                'classes' => 'tooltip-res-pages',
                'linked' => array( 'res_type' , 'page' ),
            ),
            5 => array(
                'name' => 'top',
                'type' => 'text',
                'label' => 'Top position',
                'lvisible' => false,
                'classes' => 'tooltip-top'
            ),
            6 => array(
                'name' => 'left',
                'type' => 'text',
                'label' => 'Left position',
                'lvisible' => false,
                'classes' => 'tooltip-left'
            ),
            7 => array(
                'name' => 'type',
                'type' => 'select',
                'assoc' => $type,
                'label' => 'Arrow position',
                'lvisible' => false,
                'classes' => 'tooltip-type'
            ),
        ),
        'actions' => array( 'sortable' => true )
    );
    
    $res_action = "act.select( '#tooltip_res_type' , { 'single' : '.res_posts' , 'page': '.res_pages'  } , 'sh_' )";
    
    options::$fields['_tooltip']['idrow']               = array('type' => 'st--hidden' , 'value' => 1 , 'id' => 'tooltip_id' , 'single' => true);
    options::$fields['_tooltip']['title']               = array('type' => 'st--text' , 'label' => __( 'Set title for new tooltip','cosmotheme' ) , 'id' => 'tooltip_title' , 'single' => true);
    options::$fields['_tooltip']['description']         = array('type' => 'st--textarea' , 'label' => __( 'Set description for new tooltip','cosmotheme' ) , 'id' => 'tooltip_description' , 'single' => true );
    options::$fields['_tooltip']['res_type']            = array('type' => 'st--select' , 'label' => __( 'Select tooltip location' , 'cosmotheme' ) , 'value' =>  $res_type , 'action' => $res_action , 'id' => 'tooltip_res_type' , 'single' => true );
    options::$fields['_tooltip']['res_posts']           = array('type' => 'st--search' , 'label' => __( 'Select post' , 'cosmotheme' ) , 'hint' => 'Start typing the post tile' , 'classes' => 'res_posts hidden' , 'id' => 'tooltip_res_posts' , 'single' => true , 'query' => array( 'post_type' => 'post' , 'post_status' => 'publish' ) , 'action' => "act.search( this , '-');" );
    options::$fields['_tooltip']['res_pages']           = array('type' => 'st--select' , 'label' => __( 'Select page' , 'cosmotheme' ) , 'value' => $res_pages , 'classes' => 'res_pages hidden' , 'id' => 'tooltip_res_pages' , 'single' => true );
    options::$fields['_tooltip']['top']                 = array('type' => 'st--text' , 'label' => __( 'Set top position for new tooltip','cosmotheme' )  , 'hint' => __( 'In pixels. E.g.: 450' , 'cosmotheme' ) , 'id' => 'tooltip_top' , 'single' => true );
    options::$fields['_tooltip']['left']                = array('type' => 'st--text' , 'label' => __( 'Set left position for new tooltip','cosmotheme' )  , 'hint' => __( 'In pixels. E.g.: 200' , 'cosmotheme' )  , 'id' => 'tooltip_left' , 'single' => true );
    options::$fields['_tooltip']['type']                = array('type' => 'st--select' , 'label' => __( 'Set arrow position for new tooltip','cosmotheme' ) , 'id' => 'tooltip_type' , 'value' => $type , 'single' => true );
    options::$fields['_tooltip']['save']                = array('type' => 'st--button' , 'value' => __( 'Add new tooltip' , 'cosmotheme' ) , 'action' => "extra.add( '_tooltip' , { 'input' : [ 'tooltip_id' , 'tooltip_title' , 'tooltip_top' , 'tooltip_left', 'tooltip_res_posts' ] , 'textarea' : 'tooltip_description' , 'select' : ['tooltip_type' , 'tooltip_res_type' ,  'tooltip_res_pages' ] })" );
    
    options::$fields['_tooltip']['struct']              = $tooltips;
    options::$fields['_tooltip']['hint']                = __( 'List of generic tooltips<br /> Drag and drop blocks to rearrange position' , 'cosmotheme' );

    options::$fields['_tooltip']['list']                = array( 'type' => 'ex--extra' , 'cid' => 'container__tooltip');
    
    options::$register['cosmothemes']                   = options::$fields;
?>