<?php

class post {
    static $post_id = 0;
    function get_my_posts( $author){
        $wp_query = new WP_Query( array('post_status' => 'any', 'post_type' => 'post' , 'author' => $author ) );
        if( count( $wp_query -> posts ) > 0 ){
            return true;
        }else{
            return false;
        }
    }
    function my_posts( $author ){
        global $wp_query;
        
        if ((int) get_query_var('paged') > 0) {
            $paged = get_query_var('paged');
        } else {
            if ((int) get_query_var('page') > 0) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
        }
        
        if( (int)$author > 0  ){
            $wp_query = new WP_Query(array('post_status' => 'any', 'post_type' => 'post', 'paged' => $paged, 'author' => $author  ));
            
            foreach( $wp_query -> posts as $key => $post ){
                $wp_query -> the_post();
                if( $key > 0 ){
            ?>
                    <p class="delimiter">&nbsp;</p>
            <?php 
                }
            ?>
                <article id="post-<?php echo $post->ID; ?>" <?php post_class('post'); ?>>
                    <div class="entry-content">
                        <h2 class="entry-title">
                            <?php
                                if( $post -> post_status == 'publish' ){
                                    ?><a href="<?php echo get_permalink( $post -> ID )?> " title="<?php echo __( 'Permalink to ' , 'cosmotheme' ) . $post -> post_title; ?>" rel="bookmark"><?php echo $post -> post_title; ?></a><?php
                                }else{
                                    echo $post -> post_title;
                                }
                            ?>
                        </h2>
                        <div class="entry-meta">
                            <ul>
                                <?php if(options::logic( 'upload' , 'enb_edit_delete' ) && is_user_logged_in() && $post->post_author == get_current_user_id() && is_numeric(options::get_value( 'upload' , 'post_item_page' ))){ ?> 
                                    <li class="edit_post" title="<?php _e('Edit post','cosmotheme') ?>"><a href="<?php  echo get_page_link(options::get_value( 'upload' , 'post_item_page' )).'?post='.$post->ID;  ?>"  ><?php echo _e('Edit','cosmotheme'); ?></a></li>    
                                <?php }   ?>
                                <?php if( options::logic( 'upload' , 'enb_edit_delete' )  && is_user_logged_in() && $post->post_author == get_current_user_id() ){  
                                    $confirm_delete = __('Confirm to delete this post.','cosmotheme');
                                ?>
                                <li class="delete_post" title="<?php _e('Remove post','cosmotheme') ?>"><a href="javascript:void(0)" onclick="if(confirm('<?php echo $confirm_delete; ?> ')){ removePost('<?php echo $post->ID; ?>','<?php echo home_url() ?>');}" ><?php echo _e('Delete','cosmotheme'); ?></a></li>
                                <?php  } ?>    
                            </ul>
                        </div>
                        <div class="excerpt"> 
                            <?php echo the_excerpt(); ?>
                        </div>
                    </div>
                </article>
            <?php
            }
        
            get_template_part('pagination');
            
        }else{
            get_template_part('loop', '404');
        }
    }
    
    function like( ){
        if ((int) get_query_var('paged') > 0) {
            $paged = get_query_var('paged');
        } else {
            if ((int) get_query_var('page') > 0) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
        }
        
        echo '<div ';
        tools::content_class( 0 , 'front_page' , '_like' );
        echo '>';
        echo '<h1 class="entry-title category">' . __( 'My Loved posts' , 'cosmotheme' ) . '</h1>';
        tools::switch_view( 'front_page' , '_like' );

        /* content */
        echo '<script type="text/javascript">';
        echo 'jQuery(document).ready(function(){ act.my_likes( 0 , [] , 1 ); });';
        echo '</script>';
        
        echo '</div>';
    }
    
    function my_likes( ){
        $post_id = isset( $_POST['post_id'] ) ? $_POST['post_id'] : exit;
        $result  = isset( $_POST['data'] ) ? $_POST['data'] : array();
        $type  = isset( $_POST['type'] ) ? $_POST['type'] : 0;
        global $wp_query;
        $uid = get_current_user_id();
        
        self::$post_id = $post_id;
        add_filter( 'posts_where', array( 'post' , 'filter_where' ) );
        
        $wp_query = new WP_Query( array( 'post_type' => 'post' , 'post_status' => 'publish' , 'posts_per_page' => 250 , 'orderby' => 'ID' ) );
        $break = false;
        foreach( $wp_query -> posts as $p ){
            
            $likes = meta::get_meta( $p -> ID , 'like' );
            $post_id = $p -> ID;
            
            foreach( $likes as $like ){
                
                if( $like['user_id'] == $uid && $p -> post_status == 'publish' ){
                    array_push( $result , $p -> ID );
                    break;
                }
            }
            
            if( count( $result ) == 12 ){
                $break = true;
                break;
            }
        }
        
        if( count( $result ) < 12 && ( $wp_query -> max_num_pages > 1 || $break ) ){
            echo json_encode( array( 'post_id' => $post_id , 'data' => $result ) );
        }else{
            /* content */
            if( !empty( $result ) ){
                global $wp_query;
                remove_filter( 'posts_where', array( 'post' , 'filter_where' ) );
                $wp_query = new WP_Query( array( 'post__in' => $result , 'fp_type' => 'like' , 'post_type' => 'post' , 'post_status' => 'publish' , 'posts_per_page' => 12 ) );
                if( $type == 1 ){
                    self::loop( 'front_page' , '_like' );
                }else{
                    if( tools::is_grid( 'front_page' , '_like' ) ){
                        self::loop_switch( 'front_page' , 1 );
                    }else{
                        echo '<p class="delimiter">&nbsp;</p>';
                        self::loop_switch( 'front_page' , 0 );
                    }
                }           
                if( $wp_query -> max_num_pages > 1 || $break ){
                    echo '<div class="clearfix get-more"><p class="button"><a id="get-more" index="' . $post_id . '" href="javascript:act.my_likes( jQuery(\'#get-more\').attr(\'index\') , [] , 0 );">'. __( 'get more' , 'cosmotheme' ) .'</a></p></div>';
                }
            }else{
?>
                    <article <?php post_class() ?>>
                        <!-- content -->
                        <footer class="entry-footer">
                            <div class="excerpt"><?php _e( 'Unfortunately we did not find any loved posts.' , 'cosmotheme' ); wp_link_pages(); ?>
                            </div>
                        </footer>
                    </article>
<?php
            }
        }
        
        exit();
    }
    
    function filter_where( $where = '' ) {
        global $wpdb;
        if( self::$post_id > 0 ){
            $where .= " AND  ".$wpdb->prefix."posts.ID < " . self::$post_id;
        }
        return $where;
    }
        
    function random_posts($no_ajax = false) {
        global $wp_query;
        if ((int) get_query_var('paged') > 0) {
            $paged = get_query_var('paged');
        } else {
            if ((int) get_query_var('page') > 0) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
        }

        $wp_query = new WP_Query(array('post_status' => 'publish', 'post_type' => 'post', 'posts_per_page' => 1, 'orderby' => 'rand', 'paged' => $paged));

        if ($wp_query->found_posts > 0) {
            $k = 0;
            foreach ($wp_query->posts as $post) {
                $wp_query->the_post();
                $result = get_permalink($post->ID);
            }
        }

        if (isset($no_ajax) && $no_ajax) {
            return $result;
        } else {
            echo $result;
            exit;
        }
    }
    function new_hot_posts( $p = true ) {
        if (options::logic('front_page', 'order')) {
            post::fnew_posts();
            echo '<p class="delimiter types">&nbsp;</p>';
            post::fhot_posts();
        } else {
            post::fhot_posts();
            echo '<p class="delimiter types">&nbsp;</p>';
            post::fnew_posts();
        }
    }
    function fnew_posts(){
        global $wp_query;
        if ((int) get_query_var('paged') > 0) {
            $paged = get_query_var('paged');
        } else {
            if ((int) get_query_var('page') > 0) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
        }
        
        if( options::logic( 'front_page' , 'enb_new_pg' ) ){
            $wp_query = new WP_Query(array('post_status' => 'publish', 'post_type' => 'post', 'paged' => $paged, 'fp_type' => 'news' , 'posts_per_page' => options::get_value('front_page', 'new_per_page')));
        } else {    
            $wp_query = new WP_Query(array('post_status' => 'publish', 'post_type' => 'post', 'fp_type' => 'news', 'posts_per_page' => options::get_value('front_page', 'new_per_page')));
        }

        $grid = tools::is_grid('front_page', '_new');

        $home_url = home_url();
        $news = array('fp_type' => "news");
        $news_url = add_query_arg($news, $home_url);

        $words = explode(' ', options::get_value('front_page', 'new_label'));
        $label = '<strong><a href="' . $news_url . '">';
        $set = true;
        foreach ($words as $key => $word) {
            if ($key == options::get_value('front_page', 'new_nr_words')) {
                $label .= '</a></strong>';
                $set = false;
            }

            $label .= ' ' . $word;
        }

        if ($set) {
            $label .= '</a></strong>';
        }

        echo '<div ';
        tools::content_class(0, 'front_page', '_new');
        echo '>';
        echo '<h1 class="entry-title category">' . $label . '</h1>';

        /* switcher grid / list */
        tools::switch_view('front_page', '_new');
        /* content */
        self::loop('front_page', '_new', options::logic( 'front_page' , 'enb_new_pg' ) );

        echo '</div>';
    }
    function new_posts( $paginate = true ) {
        global $wp_query;
        if ((int) get_query_var('paged') > 0) {
            $paged = get_query_var('paged');
        } else {
            if ((int) get_query_var('page') > 0) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
        }
        
        if ( options::logic( 'front_page' , 'enb_new_pg' ) && (options::get_value( 'front_page' , 'type' ) == 'new_posts' || options::get_value( 'front_page' , 'type' ) == 'new_hot_posts' ) ) {
            $wp_query = new WP_Query(array('post_status' => 'publish', 'post_type' => 'post', 'paged' => $paged , 'fp_type' => 'news' , 'posts_per_page' => options::get_value('front_page', 'new_per_page')));
        } else {    
            if( isset( $_GET['fp_type']) && $_GET['fp_type'] == 'news' ){
                $wp_query = new WP_Query(array('post_status' => 'publish', 'post_type' => 'post', 'paged' => $paged , 'fp_type' => 'news' ));
            }else{
                $wp_query = new WP_Query(array('post_status' => 'publish', 'post_type' => 'post', 'fp_type' => 'news' , 'posts_per_page' => options::get_value('front_page', 'new_per_page')));
            }
        }

        $grid = tools::is_grid('front_page', '_new');

        $home_url = home_url();
        $news = array('fp_type' => "news");
        $news_url = add_query_arg($news, $home_url);

        $words = explode(' ', options::get_value('front_page', 'new_label'));
        $label = '<strong><a href="' . $news_url . '">';
        $set = true;
        foreach ($words as $key => $word) {
            if ($key == options::get_value('front_page', 'new_nr_words')) {
                $label .= '</a></strong>';
                $set = false;
            }

            $label .= ' ' . $word;
        }

        if ($set) {
            $label .= '</a></strong>';
        }

        echo '<div ';
        tools::content_class(0, 'front_page', '_new');
        echo '>';
        echo '<h1 class="entry-title category">' . $label . '</h1>';

        /* switcher grid / list */
        tools::switch_view('front_page', '_new');
        /* content */
        if( isset( $_GET['fp_type']) && $_GET['fp_type'] == 'news' ){
            self::loop('front_page', '_new' , $paginate );
        }else{
            self::loop('front_page', '_new' , options::logic( 'front_page' , 'enb_new_pg' ) );
        }

        echo '</div>';
    }
    
    function fhot_posts( ) {
        global $wp_query;
        if ((int) get_query_var('paged') > 0) {
            $paged = get_query_var('paged');
        } else {
            if ((int) get_query_var('page') > 0) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
        }
        
        if ( options::logic( 'front_page' , 'enb_hot_pg' ) ) {
            $wp_query = new WP_Query(array(
                        'post_status' => 'publish',
                        'paged' => $paged,
                        'posts_per_page' => options::get_value('front_page', 'hot_per_page'),
                        'meta_key' => 'hot_date',
                        'orderby' => 'meta_value_num',
                        'fp_type' => 'hot',
                        'meta_query' => array(
                            array(
                                'key' => 'nr_like',
                                'value' => options::get_value('general', 'min_likes'),
                                'compare' => '>=',
                                'type' => 'numeric',
                            )),
                        'order' => 'DESC'));
        }else{
            $wp_query = new WP_Query(array(
                        'post_status' => 'publish',
                        'posts_per_page' => options::get_value('front_page', 'hot_per_page'),
                        'meta_key' => 'hot_date',
                        'orderby' => 'meta_value_num',
                        'fp_type' => 'hot',
                        'meta_query' => array(
                            array(
                                'key' => 'nr_like',
                                'value' => options::get_value('general', 'min_likes'),
                                'compare' => '>=',
                                'type' => 'numeric',
                            )),
                        'order' => 'DESC'));
        }

        $grid = tools::is_grid('front_page', '_hot');

        $home_url = home_url();
        $hot = array('fp_type' => "hot");
        $hot_url = add_query_arg($hot, $home_url);

        $news = array('fp_type' => "news");
        $news_url = add_query_arg($news, $home_url);

        $words = explode(' ', options::get_value('front_page', 'hot_label'));
        $label = '<strong><a href="' . $hot_url . '">';
        $set = true;
        foreach ($words as $key => $word) {
            if( $key == options::get_value( 'front_page' , 'hot_nr_words' ) ) {
                $label .= '</a></strong>';
                $set = false;
            }

            $label .= ' ' . $word;
        }

        if ($set) {
            $label .= '</a></strong>';
        }

        echo '<div ';
        tools::content_class(0, 'front_page', '_hot');
        echo '>';
        echo '<h1 class="entry-title category">' . $label . '</h1>';

        /* switcher grid / list */
        tools::switch_view( 'front_page' , '_hot' );
        /* content */
        self::loop( 'front_page' , '_hot' , options::logic( 'front_page' , 'enb_hot_pg' ) );

        echo '</div>';
    }
    
    function hot_posts( $paginate = true ) {
        global $wp_query;
        if ((int) get_query_var('paged') > 0) {
            $paged = get_query_var('paged');
        } else {
            if ((int) get_query_var('page') > 0) {
                $paged = get_query_var('page');
            } else {
                $paged = 1;
            }
        }
        
        if ( options::logic( 'front_page' , 'enb_hot_pg' ) && (options::get_value( 'front_page' , 'type' ) == 'hot_posts' || options::get_value( 'front_page' , 'type' ) == 'new_hot_posts' ) ) {
            $wp_query = new WP_Query(array(
                    'post_status' => 'publish',
                    'paged' => $paged,
                    'posts_per_page' => options::get_value('front_page', 'hot_per_page'),
                    'meta_key' => 'hot_date',
                    'orderby' => 'meta_value_num',
                    'fp_type' => 'hot',
                    'meta_query' => array(
                        array(
                            'key' => 'nr_like',
                            'value' => options::get_value('general', 'min_likes'),
                            'compare' => '>=',
                            'type' => 'numeric',
                        )),
                    'order' => 'DESC'));
        }else{
            if( isset( $_GET['fp_type']) && $_GET['fp_type'] == 'hot' ){
                $wp_query = new WP_Query(array(
                        'post_status' => 'publish',
                        'paged' => $paged,
                        'meta_key' => 'hot_date',
                        'orderby' => 'meta_value_num',
                        'fp_type' => 'hot',
                        'meta_query' => array(
                            array(
                                'key' => 'nr_like',
                                'value' => options::get_value('general', 'min_likes'),
                                'compare' => '>=',
                                'type' => 'numeric',
                            )),
                        'order' => 'DESC'));
            }else{
                $wp_query = new WP_Query(array(
                        'post_status' => 'publish',
                        'paged' => $paged,
                        'posts_per_page' => options::get_value('front_page', 'hot_per_page'),
                        'meta_key' => 'hot_date',
                        'orderby' => 'meta_value_num',
                        'fp_type' => 'hot',
                        'meta_query' => array(
                            array(
                                'key' => 'nr_like',
                                'value' => options::get_value('general', 'min_likes'),
                                'compare' => '>=',
                                'type' => 'numeric',
                            )),
                        'order' => 'DESC'));
            }
        }

        $grid = tools::is_grid('front_page', '_hot');

        $home_url = home_url();
        $hot = array('fp_type' => "hot");
        $hot_url = add_query_arg($hot, $home_url);

        $news = array('fp_type' => "news");
        $news_url = add_query_arg($news, $home_url);

        $words = explode(' ', options::get_value('front_page', 'hot_label'));
        $label = '<strong><a href="' . $hot_url . '">';
        $set = true;
        foreach ($words as $key => $word) {
            if( $key == options::get_value( 'front_page' , 'hot_nr_words' ) ) {
                $label .= '</a></strong>';
                $set = false;
            }

            $label .= ' ' . $word;
        }

        if ($set) {
            $label .= '</a></strong>';
        }

        echo '<div ';
        tools::content_class(0, 'front_page', '_hot');
        echo '>';
        echo '<h1 class="entry-title category">' . $label . '</h1>';

        /* switcher grid / list */
        tools::switch_view( 'front_page' , '_hot' );
        /* content */
        if( isset( $_GET['fp_type']) && $_GET['fp_type'] == 'hot' ){
            self::loop( 'front_page' , '_hot' , $paginate );
        }else{
            self::loop( 'front_page' , '_hot' , options::logic( 'front_page' , 'enb_hot_pg' ) ); 
        }

        echo '</div>';
    }
        
    function search(){
        
        $query = isset( $_GET['params'] ) ? (array)json_decode( stripslashes( $_GET['params'] )) : exit;
        $query['s'] = isset( $_GET['query'] ) ? $_GET['query'] : exit;
        
        global $wp_query;
        $result = array();
        $result['query'] = $query['s'];
        
        $wp_query = new WP_Query( $query );
        
        if( $wp_query -> have_posts() ){
            foreach( $wp_query -> posts as $post ){
                $result['suggestions'][] = $post -> post_title;
                $result['data'][] =  $post -> ID;
            }
        }
        
        echo json_encode( $result );
        exit();
    }
    
    function list_view($post, $template = 'blog_page') {
        ?>
        <article id="post-<?php echo $post->ID; ?>" <?php post_class('post ' . tools::nsfw_class($post), $post->ID); ?>>
            <header class="entry-header b w_610">
                <?php
                $classes = tools::login_attr($post->ID, 'nsfw');
                $attr = tools::login_attr($post->ID, 'nsfw mosaic-overlay', get_permalink($post->ID));
                $size = 'tmedium';
                $s = image::asize( image::size( $post->ID , $template , $size ) );

                if (options::logic('general', 'time')) {
                    ?><div class="entry-date"><time><?php echo human_time_diff(get_the_time('U', $post->ID), current_time('timestamp')) . ' ' . __('ago', 'cosmotheme'); ?></time></div><?php
                } else {
                    ?><div class="entry-date"><time><?php echo date_i18n(get_option('date_format'), get_the_time('U', $post->ID)); ?></time></div><?php
                }

				if( get_post_format( $post -> ID ) == 'video' ){
					$format = meta::get_meta( $post -> ID , 'format' );

					if( isset( $format['video'] ) && !empty( $format['video'] ) && post::isValidURL( $format['video'] ) ){
						$vimeo_id = post::get_vimeo_video_id( $format['video'] );
						$youtube_id = post::get_youtube_video_id( $format['video'] );
						$video_type = '';
                        $video_id = 0;
                        $video_type = 'self_hosted';
						if( $vimeo_id != '0' ){
							$video_type = 'vimeo';
							$video_id = $vimeo_id;
						}

						if( $youtube_id != '0' ){
							$video_type = 'youtube';
							$video_id = $youtube_id;
						}

						/*if( !empty( $video_type ) ){
							echo post::get_embeded_video( $video_id , $video_type );
						}*/

						if(isset($video_type) && isset($video_id) && is_user_logged_in () ){
                            if($video_type == 'self_hosted'){
                                $onclick = 'playVideo("'.urlencode($format['video']).'","'.$video_type.'",jQuery(this))';
                            }else{
                                $onclick = 'playVideo("'.$video_id.'","'.$video_type.'",jQuery(this))';
                            }    
							
						}else{
							$meta = meta::get_meta( $post -> ID  , 'settings' );
							if( isset( $meta['safe'] ) ){
								if( !meta::logic( $post , 'settings' , 'safe' ) ){		
									$onclick = 'playVideo("'.$video_id.'","'.$video_type.'",jQuery(this))';
								}
							}else{
                                if($video_type == 'self_hosted'){
                                    $onclick = 'playVideo("'.urlencode($format['video']).'","'.$video_type.'",jQuery(this))';
                                }else{
                                    $onclick = 'playVideo("'.$video_id.'","'.$video_type.'",jQuery(this))';
                                }    
							}	
						}
					}
				}
                ?>
                <div class="featimg readmore"  <?php if(isset($onclick)){ echo "onclick=".$onclick; }?> >
                    <div class="img">
                    <?php
                        if (has_post_thumbnail($post->ID)) {
                            $src = image::thumbnail($post->ID, $template, $size);
                            $caption = image::caption($post->ID);
                            

                            if (strlen($classes)) {
                                ?>
                                <a <?php echo $attr; ?>>
                                    <?php
                                        if ( get_post_format($post->ID) != 'video' ) {
                                            ?><div class="details"><?php _e('Read more', 'cosmotheme'); ?> <i class="cosmo-arrow">→</i></div><?php
                                        }
                                    ?>
                                </a>
                                <div class="format">&nbsp;</div>
                                <?php echo image::mis($post->ID, $template, $size, 'safe image', 'nsfw'); ?>
                                <?php
                                if (options::logic('styling', 'stripes')) {
                                    ?><div class="stripes" style="height: <?php echo $s[1]; ?>px">&nbsp;</div><?php
                                }
                                ?>
                                <?php
                                if (get_post_format($post->ID) == 'video') {
                                    echo '<div class="play">&nbsp;</div>';
                                }
                                ?>
                                <?php
                            } else {
                                ?>
                                <a href="<?php if(!isset($onclick)){ echo get_permalink( $post -> ID ); }else{ echo 'javascript:void(0)'; } ?>" title="<?php echo $caption ?>" class="mosaic-overlay" >
                                    <?php
                                        if ( get_post_format($post->ID) != 'video' ) {
                                            ?><div class="details"><?php _e('Read more', 'cosmotheme'); ?> <i class="cosmo-arrow">→</i></div><?php
                                        }
                                    ?>
                                </a>
                                <div class="format">&nbsp;</div>
                                <img src="<?php echo $src[0]; ?>" alt="<?php echo $caption; ?>" >
                                <?php
                                if (options::logic('styling', 'stripes')) {
                                    ?><div class="stripes" style="height: <?php echo $src[2]; ?>px">&nbsp;</div><?php
                                }
                                ?>
                                <?php
                                if (get_post_format($post->ID) == 'video') {
                                    echo '<div class="play">&nbsp;</div>';
                                }
                                ?>
                                <?php
                            }
                        }else{
                            if (strlen($classes)) {
                                ?>
                                <a <?php echo $attr; ?> >
                                    <?php
                                        if ( get_post_format($post->ID) != 'video' ) {
                                            ?><div class="details"><?php _e('Read more', 'cosmotheme'); ?> <i class="cosmo-arrow">→</i></div><?php
                                        }
                                    ?>
                                </a>
                                <div class="format">&nbsp;</div>
                                <?php echo image::mis($post->ID, $template, $size, 'safe image', 'nsfw'); ?>
                                <?php
                                if (options::logic('styling', 'stripes')) {
                                    ?><div class="stripes" style="height: <?php echo $s[1]; ?>px">&nbsp;</div><?php
                                }
                                ?>
                                <?php
                                if (get_post_format($post->ID) == 'video') {
                                    echo '<div class="play">&nbsp;</div>';
                                }
                                ?>
                                <?php
                            } else {
                                ?>
                                <a class="<?php echo $classes; ?> mosaic-overlay" href="<?php if(!isset($onclick)){ echo get_permalink( $post -> ID ); }else{ echo 'javascript:void(0)'; } ?>" >
                                    <?php
                                        if ( get_post_format($post->ID) != 'video' ) {
                                            ?><div class="details"><?php _e('Read more', 'cosmotheme'); ?> <i class="cosmo-arrow">→</i></div><?php
                                        }
                                    ?>
                                </a>
                                <div class="format">&nbsp;</div>
                                <?php echo image::mis($post->ID, $template, $size, 'safe image', 'no.image'); ?>
                                <?php
                                if (options::logic('styling', 'stripes')) {
                                    ?><div class="stripes" style="height: <?php echo $s[1]; ?>px">&nbsp;</div><?php
                                }
                                ?>
                                <?php
                                if (get_post_format($post->ID) == 'video') {
                                    echo '<div class="play">&nbsp;</div>';
                                }
                                ?>
                                <?php
                            }
                        }
                    ?>                
                    </div>
                </div>
            </header>
            <div <?php tools::entry_class(0, $template, 'entry-content'); ?>>
                <h2 class="entry-title">
                    <a <?php echo tools::login_attr($post->ID, 'nsfw', get_permalink($post->ID)) ?> title="<?php _e('Permalink to', 'cosmotheme'); ?> <?php echo $post->post_title; ?>" rel="bookmark"><?php echo $post->post_title; ?></a>
                </h2>
                <div class="excerpt">
                    <?php
                        if ( is_user_logged_in() ) {
                            the_excerpt();
                        } else {
                            if ( !tools::is_nsfw( $post -> ID ) ) {
                                the_excerpt();
                            }else{
                                echo '<p>' . options::get_value( 'general' , 'nsfw_content' ) . '</p>';
                            }
                        }
                    ?>
                </div>
            </div>
        </article>
        <?php
    }

    function grid_view($post, $template) {
        ?>
        <article id="post-<?php echo $post->ID; ?>" <?php post_class('col ' . tools::nsfw_class($post->ID), $post->ID); ?>>
            <div class="readmore">

                <?php
                $classes = tools::login_attr($post->ID, 'nsfw');
                $attr = tools::login_attr($post->ID, 'nsfw mosaic-overlay', get_permalink($post->ID));
                $size = 'tgrid';
                if (has_post_thumbnail($post->ID)) {
                    $src = image::thumbnail($post->ID, $template, $size);
                    $caption = image::caption($post->ID);

                    if (strlen($classes)) {
                        ?>
                        <a <?php echo $attr; ?>>
                            <div class="details"><?php _e('Read more', 'cosmotheme'); ?> <i class="cosmo-arrow">→</i></div>
                        </a>
                        <div class="format">&nbsp;</div>
                        <?php echo image::mis($post->ID, $template, $size, 'safe image', 'nsfw'); ?>
                        <?php
                        if (options::logic('styling', 'stripes')) {
                            ?><div class="stripes">&nbsp;</div><?php
                        }
                        ?>
                        <?php
                    } else {
                        ?>
                        <a href="<?php echo get_permalink($post->ID); ?>" title="<?php echo $caption ?>" class="mosaic-overlay" >
                            <div class="details"><?php _e('Read more', 'cosmotheme'); ?> <i class="cosmo-arrow">→</i></div>
                        </a>
                        <div class="format">&nbsp;</div>
                        <img src="<?php echo $src[0]; ?>" alt="<?php echo $caption; ?>" >
                        <?php
                        if (options::logic('styling', 'stripes')) {
                            ?><div class="stripes">&nbsp;</div><?php
                        }
                        ?>
                        <?php
                    }
                } else {
                    if (strlen($classes)) {
                        ?>
                        <a <?php echo $attr; ?>>
                            <div class="details"><?php _e('Read more', 'cosmotheme'); ?> <i class="cosmo-arrow">→</i></div>
                        </a>
                        <div class="format">&nbsp;</div>
                        <?php echo image::mis( $post->ID , $template , $size , 'safe image' , 'nsfw' ); ?>
                        <?php
                        if (options::logic('styling', 'stripes')) {
                            ?><div class="stripes">&nbsp;</div><?php
                        }
                        ?>
                        <?php
                    } else {
                        ?>
                        <a class="<?php echo $classes; ?> mosaic-overlay" href="<?php echo get_permalink($post->ID); ?>">
                            <div class="details"><?php _e('Read more', 'cosmotheme'); ?> <i class="cosmo-arrow">→</i></div>
                        </a>
                        <div class="format">&nbsp;</div>
                        <?php echo image::mis( $post->ID , $template , $size , 'safe image', 'no.image' ); ?>
                        <?php
                        if (options::logic('styling', 'stripes')) {
                            ?><div class="stripes">&nbsp;</div><?php
                        }
                        ?>
                        <?php
                    }
                }
                ?>
            </div>
            <h2>
                <a <?php echo tools::login_attr($post->ID, 'nsfw readmore', get_permalink($post->ID)) ?> title="<?php _e('Permalink to', 'cosmotheme'); ?> <?php echo $post->post_title; ?>" rel="bookmark">
                    <?php echo $post->post_title; ?>
                </a>
                <?php like::content($post->ID, 2); ?>
            </h2>
            <footer class="entry-footer">
                <p class="time">
                    <time>
                        <?php
                        if (options::logic('general', 'time')) {
                            echo human_time_diff(get_the_time('U', $post->ID), current_time('timestamp')) . ' ' . __('ago', 'cosmotheme');
                        } else {
                            echo date_i18n(get_option('date_format'), get_the_time('U', $post->ID));
                        }
                        ?>
                    </time>
                </p>
                <div class="excerpt"><?php the_advanced_excerpt() ?></div>
            </footer>
        </article>
        <?php
    }

    function loop($template, $side = '', $paginate = true) {
        global $wp_query;        
        echo '<input type="hidden" id="query-' . $template . $side . '" value="' . urlencode( json_encode( $wp_query -> query ) ) . '" />';
        if ( count( $wp_query->posts) > 0 ) {
            if( tools::is_grid( $template , $side ) ){
?>
                <div class="loop-container-view grid">
                    <?php self::loop_switch( $template , 1 ); ?>
                </div>
<?php
            }else{
?>
                <div class="loop-container-view list">
                    <?php self::loop_switch( $template , 0 ); ?>
                </div>
<?php
            }
            if ($paginate) {
                get_template_part('pagination');
            }
        } else {
            get_template_part('loop', '404');
        }
    }

    function loop_switch( $template = '' , $grid = 1 ) {
        global $wp_query;
        if ( !empty( $template ) ) {
            $ajax = false;
        } else {
            $template = isset( $_POST['template'] ) && strlen( $_POST['template'] ) ? $_POST['template'] : exit();
            $query = isset( $_POST['query'] ) && !empty( $_POST['query'] ) ? json_decode( urldecode( $_POST['query'] ) ) : exit();
            $query -> post_status = 'publish';
            $wp_query = new WP_Query( $query );
            $grid = isset($_POST['grid']) ? (int)$_POST['grid'] : 1;
            $ajax = true;
        }
        
        $template   = str_replace( array( '_hot' , '_new' , '_like' ) , '' , $template );
        
        if( $grid == 1 ){
            $k = 1;
            $i = 1;
            $nr = $wp_query->post_count;

            if (layout::length(0, $template) == layout::$size['large']) {
                $div = 3;
            } else {
                $div = 2;
            }

            foreach ($wp_query->posts as $post) {
                $wp_query->the_post();
                if ($i == 1) {
                    if (( $nr - $k ) < $div) {
                        $classes = 'class="last"';
                    } else {
                        $classes = '';
                    }
                    echo '<div ' . $classes . '>';
                }

                self::grid_view($post, $template);

                if ($i % $div == 0) {
                    echo '</div>';
                    $i = 0;
                }
                $i++;
                $k++;
            }

            if ($i > 1) {
                echo '</div>';
            }
        }else{
            foreach ($wp_query->posts as $index => $post) {
                $wp_query->the_post();
                if ($index > 0) {
                    ?><p class="delimiter">&nbsp;</p><?php
                }

                self::list_view($post, $template);
            }
        }
        
        if( $ajax ){
            exit();
        }
    }
    
    function shmeta($post, $nav = true) {
        global $wp_query;
        ?>
        <div class="entry-meta">
            <ul>
                <?php if(options::logic( 'upload' , 'enb_edit_delete' ) && is_user_logged_in() && $post->post_author == get_current_user_id() && is_numeric(options::get_value( 'upload' , 'post_item_page' ))){ ?> 
                <li class="edit_post" title="<?php _e('Edit post','cosmotheme') ?>"><a href="<?php  echo get_page_link(options::get_value( 'upload' , 'post_item_page' )).'?post='.$post->ID;  ?>"  ><?php echo _e('Edit','cosmotheme'); ?></a></li>    
                <?php }   ?>
                
                <li class="author" title="Author">
                    <a href="<?php echo get_author_posts_url($post->post_author) ?>">
        <?php echo get_the_author_meta('display_name', $post->post_author); ?>
                    </a>
                </li>
        <?php
        if (comments_open($post->ID)) {
            if (options::logic('general', 'fb_comments')) {
                ?>
                        <li class="cosmo-comments" title="">
                            <a <?php echo tools::login_attr($post->ID, 'nsfw', get_comments_link($post->ID)) ?>>
                                <fb:comments-count href="<?php echo get_permalink($post->ID) ?>"></fb:comments-count>
                            </a>
                        </li>
                <?php
            } else {
                ?>
                        <li class="cosmo-comments" title="<?php echo get_comments_number($post->ID); ?> Comments">
                            <a <?php echo tools::login_attr($post->ID, 'nsfw', get_comments_link($post->ID)) ?>>
                <?php echo get_comments_number($post->ID) ?>
                            </a>
                        </li>
                <?php
            }
        }
        ?>

                <li class="cosmo-love"><?php like::content($post->ID, 3); ?></li>
            </ul>
        </div>
        <?php
    }

	function get_meta_view_style($post){
		$meta = meta::get_meta( $post -> ID , 'settings' );

		if( isset( $meta[ 'meta_view_style' ] ) && strlen( $meta[ 'meta_view_style' ] ) && !is_author() ){
			$meta_view_style =  meta::get_meta( $post -> ID , 'settings'  ); 
			$meta_view_style = $meta_view_style[ 'meta_view_style' ];
		}else{
			
			$meta_view_style =  options::get_value( 'general' , 'meta_view_style' ); 
			
		}
		return $meta_view_style;	
	}

	function show_meta_author_box($post){
		$meta = meta::get_meta( $post -> ID , 'settings' );

		  
		if( isset( $meta[ 'author' ] ) && strlen( $meta[ 'author' ] ) && !is_author() ){
			$show_author = meta::logic( $post , 'settings' , 'author' );
		}else{
			if( is_single() ){
				$show_author = options::logic( 'blog_post' , 'post_author_box' );
			}

			if( is_page() ){
				$show_author = options::logic( 'blog_post' , 'page_author_box' );
			}

			if( !( is_single() || is_page() ) ){
				$show_author = true;
			}
		}

		return $show_author;
	}
  
    function meta( $post ) {
        global $wp_query;
		
		?>
        <div class="entry-meta ">
			<?php if(self::show_meta_author_box($post) && self::get_meta_view_style($post) == 'vertical') { 
				$role = array( 
                                    10 => __( 'Administrator' , 'cosmotheme' ) ,
                                    7 => __( 'Editor' , 'cosmotheme' ) , 
                                    2 => __( 'Author' , 'cosmotheme' ) , 
                                    1 => __( 'Contributor' , 'cosmotheme'  ) , 
                                    0 => __( 'Subscriber' , 'cosmotheme' ), 
                                    '' => __( 'Subscriber' , 'cosmotheme' )
                                );
			?>  
			<div class="entry-author">
				<a href="<?php echo get_author_posts_url($post->post_author) ?>" class="profile-pic" ><?php echo cosmo_avatar( $post->post_author , 32 , $default = DEFAULT_AVATAR_LOGIN ); ?></a>
				<a href="<?php echo get_author_posts_url($post->post_author) ?>">
					<?php echo get_the_author_meta('display_name', $post->post_author); ?>
					<img src="<?php echo get_template_directory_uri(); ?>/images/mask.png" class="mask" alt="">
					<span><?php echo $role[ get_the_author_meta( 'user_level' , $post->post_author ) ]; ?></span>
				</a>
			</div>
			<?php } ?>	
            <ul>
                <li class="time">
                    <time>
                        <?php
                        if (options::logic('general', 'time')) {
                            echo human_time_diff(get_the_time('U', $post->ID), current_time('timestamp')) . ' ' . __('ago', 'cosmotheme');
                        } else {
                            echo date_i18n(get_option('date_format'), get_the_time('U', $post->ID));
                        }
                        ?>
                    </time>
                </li>
                <?php
                    if (comments_open($post->ID)) {
						$comments_label = __('comments','cosmotheme');  
                        if (options::logic('general', 'fb_comments')) {
                            ?><li class="cosmo-comments" title=""><a href="<?php echo get_comments_link($post->ID); ?>"> <fb:comments-count href="<?php echo get_permalink($post->ID) ?>"></fb:comments-count> <?php if(self::get_meta_view_style($post) == 'vertical'){ echo $comments_label; } ?> </a></li><?php
                        } else {
							
							if(get_comments_number($post->ID) == 1){
								$comments_label = __('comment','cosmotheme');
							}
                            ?><li class="cosmo-comments" title="<?php echo get_comments_number($post->ID); echo ' '.$comments_label; ?>"><a href="<?php echo get_comments_link($post->ID) ?>"> <?php echo get_comments_number($post->ID) ?> <?php if(self::get_meta_view_style($post) == 'vertical'){ echo $comments_label; } ?> </a></li><?php
                        }
                    }
                ?>
            </ul>
            <?php
            $tags = wp_get_post_terms($post->ID, 'post_tag');

            if (!empty($tags)) {
                ?>
                <ul class="b_tag">
                    <?php
                    foreach ($tags as $tag) {
                        $t = get_tag($tag);
                        echo '<li><a href="' . get_tag_link($tag) . '" rel="tags">' . $t->name . '</a></li>';
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
            <?php
            $categories = wp_get_post_terms($post->ID, 'category');
            if (!empty($categories)) {
                ?>
                <ul class="category">
                    <?php
                    foreach ($categories as $category) {
                        $cat = get_category($category);
                        echo '<li><a href="' . get_category_link($category) . '">' . $cat->name . '</a></li>';
                    }
                    ?>
                </ul>
                <?php
            }
            ?>
        </div>
        <?php
        }

        function add_image_post(){
        	$response = array(  'image_error' => '',
        						'error_msg' => '',	
        						'title_error' => '',
        						'post_id' => 0,
        						'auth_error' => '',
        						'success_msg' => ''	);
        	
        	
        	$is_valid = true;
        	
        	if(!is_user_logged_in()){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['auth_error'] = __('You must be logged in to submit a post! ','cosmotheme');	
        	}
        	if(is_user_logged_in() && isset($_POST['post_id'])){
				$post_edit = get_post($_POST['post_id']);
				
				if(get_current_user_id() != $post_edit->post_author){
					$is_valid = false;	
					$response['error_msg'] = __('You are not the author of this post. ','cosmotheme');
					$response['title_error'] = __('You are not the author of this post. ','cosmotheme');
				}
			}
        	if(!isset($_POST['title']) || trim($_POST['title']) == ''){
        		$is_valid = false;	
        		$response['error_msg'] = 'Title is required. ';
        		$response['title_error'] = __('Title is required. ','cosmotheme');
        	}
        	if(isset($_POST['image_type']) ){
        		if($_POST['image_type'] == 'url_img'){

					if(isset($_POST['image_url']) && $_POST['image_url'] != ''){
        				if(self::isValidURL($_POST['image_url'])){
		        			$ext = $rest = substr($_POST['image_url'], -4); /*get the last 4 chars*/
		        			
		        			if(($ext !='.gif') && ($ext !='.jpg') && ($ext !='.png')){
		        				$is_valid = false;	
		        				$response['error_msg'] = 'Invalid image type';
        						$response['image_error'] = __('Invalid image type. ','cosmotheme');	
		        			}  		
		        		}else{
		        			$is_valid = false;	
		        			$response['error_msg'] = 'Invalid image URL';
        					$response['image_error'] = __('Invalid image URL. ','cosmotheme');
		        		}
					}else{
						$is_valid = false;	
						$response['error_msg'] = 'Invalid image URL';
        				$response['image_error'] = __('Invalid image URL. ','cosmotheme');
					}		
        		}elseif ($_POST['image_type'] == 'upload_img'){
		        	if(!isset($_POST['image_id']) || !is_numeric($_POST['image_id'])){
		        		$is_valid = false;	
		        		$response['error_msg'] = 'error';
        				$response['image_error'] = __('Invalid image. ','cosmotheme');
		        	}		
		        }
        	}else{
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['image_error'] = __('Invalid image','cosmotheme');
        	}
        	
        	
        		if($is_valid){
        			/*create post*/
        			$post_categories = array(1);
        			if(isset($_POST['category_id'])){
        				$post_categories = array($_POST['category_id']);
        			}
        			
        			$post_content = '';
        			if(isset($_POST['image_content'])){
        				$post_content = $_POST['image_content'];
        			}
        			
        			if(isset($_POST['post_id'])){
						$new_post = self::create_new_post($_POST['title'], $_POST['tags'], $post_categories, $post_content, $_POST['post_id']);  /*add image as content*/
					}else{
						$new_post = self::create_new_post($_POST['title'],$_POST['tags'],$post_categories,$post_content);  /*add image as content*/
					}
        			
				    
				    if(is_numeric($new_post)){	
					    if($_POST['image_type'] == 'url_img'){
		        			require_once(ABSPATH . 'wp-admin/includes/file.php');
						    require_once(ABSPATH . 'wp-admin/includes/media.php');
							require_once(ABSPATH . 'wp-admin/includes/image.php');
							
							/*attach an image to the post*/
							$upload =  media_sideload_image( urldecode($_POST['image_url']), $new_post);
							
							/* set attached image as featured image */
							// Associative array of attachments, as $attachment_id => $attachment
							$attachments = get_children( array('post_parent' => $new_post, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
							foreach ($attachments as $index => $id) {
								$attachment = $index;
							} 

							
		        		}elseif ($_POST['image_type'] == 'upload_img'){
							if(isset($_POST['post_id']) && get_post_thumbnail_id($_POST['post_id']) != $_POST['image_id']){
								$attachment = $_POST['image_id']; 
							}else{
								$attachment = $_POST['image_id']; 
							}
		        			
		        		}
				    	/*include the necesarry scripts for media_sideload_image() function*/
						
						
						set_post_thumbnail( $new_post, $attachment );
						
						if(isset($_POST['nsfw'])){
							$settings_meta = array(	  "safe"=>  "yes");
							meta::set_meta( $new_post , 'settings' , $settings_meta );
						}	
						
						/*add source meta data*/
						if(isset($_POST['source']) && trim($_POST['source']) != ''){
							$settings_meta = array(	  "post_source"=>  $_POST['source']);
							meta::set_meta( $new_post , 'source' , $settings_meta );	
						}
							
						/*add video url meta data*/
						$image_format_meta = array(	   "type" => 'image');
						meta::set_meta( $new_post , 'format' , $image_format_meta );

						if(isset($_POST['post_format']) && ($_POST['post_format'] == 'video' || $_POST['post_format'] == 'image' || $_POST['post_format'] == 'audio') ){
							set_post_format( $new_post , $_POST['post_format']);
						}
						
						if(options::get_value( 'upload' , 'default_posts_status' ) == 'publish'){
							/*if post was publihed imediatelly then we will show the prmalink to the user*/
								
							$response['success_msg'] = sprintf(__('You can check your post %s here%s.','cosmotheme'),'<a href="'.get_permalink($new_post).'">','</a>');
							
						}else{
							$response['success_msg'] = __('Success. Your post is awaiting moderation.','cosmotheme');
						}	
						$response['post_id'] = $new_post;
				    }	
				    
	        		
        		}	
        	echo json_encode($response);
        	exit;
        }

		function add_file_post(){

			$response = array(  'image_error' => '',
								'file_error' => '',
        						'error_msg' => '',	
        						'title_error' => '',
        						'post_id' => 0,
        						'auth_error' => '',
        						'success_msg' => ''	);
        	
        	
        	$is_valid = true;
        	
        	if(!is_user_logged_in()){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['auth_error'] = __('You must be logged in to submit a post! ','cosmotheme');	
        	}
            
            if(is_user_logged_in() && isset($_POST['post_id'])){
				$post_edit = get_post($_POST['post_id']);
				
				if(get_current_user_id() != $post_edit->post_author){
					$is_valid = false;	
					$response['error_msg'] = __('You are not the author of this post. ','cosmotheme');
					$response['title_error'] = __('You are not the author of this post. ','cosmotheme');
				}
			}
            
        	if(!isset($_POST['title']) || trim($_POST['title']) == ''){
        		$is_valid = false;	
        		$response['error_msg'] = 'Title is required. ';
        		$response['title_error'] = __('Title is required. ','cosmotheme');
        	}

			if(!isset($_POST['file_id']) || !is_numeric($_POST['file_id']) ){
        		$is_valid = false;	
        		$response['error_msg'] = 'File is required. ';
        		$response['file_error'] = __('File is required. ','cosmotheme');
        	}else{
				if(isset($_POST['file']) && $_POST['file'] != ''){
					$ext1 = substr($_POST['file'], -4); /*get the last 4 chars*/
					$ext2 = substr($_POST['file'], -5); /*get the last 5 chars*/
					if(($ext1 !='.pdf') && ($ext1 !='.doc') && ($ext1 !='.zip') && ($ext1 !='.rar') && ($ext2 !='.docx')){
						$is_valid = false;	
						$response['error_msg'] = 'Invalid file format. ';
						$response['file_error'] = __('Invalid file format. ','cosmotheme');
					}	
				}else{
					$is_valid = false;	
					$response['error_msg'] = 'Invalid file. ';
					$response['file_error'] = __('Invalid file. ','cosmotheme');
				}
			}

        	if(isset($_POST['image_type']) ){
        		if($_POST['image_type'] == 'url_img'){

					if(isset($_POST['image_url']) && $_POST['image_url'] != ''){
        				if(self::isValidURL($_POST['image_url'])){
		        			$ext = substr($_POST['image_url'], -4); /*get the last 4 chars*/
		        			
		        			if(($ext !='.gif') && ($ext !='.jpg') && ($ext !='.png')){
		        				$is_valid = false;	
		        				$response['error_msg'] = 'Invalid image type';
        						$response['image_error'] = __('Invalid image type. ','cosmotheme');	
		        			}  		
		        		}else{
		        			$is_valid = false;	
		        			$response['error_msg'] = 'Invalid image URL';
        					$response['image_error'] = __('Invalid image URL. ','cosmotheme');
		        		}
					}		
        		}
        	}
        	
        	
        		if($is_valid){
        			/*create post*/
        			$post_categories = array(1);
        			if(isset($_POST['category_id'])){
        				$post_categories = array($_POST['category_id']);
        			}
        			
        			$post_content = '';
        			if(isset($_POST['file_content'])){
        				$post_content = $_POST['file_content'];
        			}
        			
        			
                    if(isset($_POST['post_id'])){
						$new_post = self::create_new_post($_POST['title'], $_POST['tags'], $post_categories, $post_content, $_POST['post_id']);  
					}else{
						$new_post = self::create_new_post($_POST['title'],$_POST['tags'],$post_categories,$post_content);  
					}
                    
				    if(is_numeric($new_post)){	
						if($response['image_error'] == ''){  
							if($_POST['image_type'] == 'url_img'){
								require_once(ABSPATH . 'wp-admin/includes/file.php');
								require_once(ABSPATH . 'wp-admin/includes/media.php');
								require_once(ABSPATH . 'wp-admin/includes/image.php');
								
								/*attach an image to the post*/
								$upload =  media_sideload_image( urldecode($_POST['image_url']), $new_post);
								
								/* set attached image as featured image */
								// Associative array of attachments, as $attachment_id => $attachment
								$attachments = get_children( array('post_parent' => $new_post, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
								foreach ($attachments as $index => $id) {
									$attachment = $index;
								} 
								if(isset($attachment)){  
									set_post_thumbnail( $new_post, $attachment );
								}
		
							}elseif ($_POST['image_type'] == 'upload_img'){
								
                                if(isset($_POST['post_id']) && get_post_thumbnail_id($_POST['post_id']) != $_POST['image_id']){
                                    $attachment = $_POST['image_id']; 
                                }else{
                                    $attachment = $_POST['image_id']; 
                                }
								set_post_thumbnail( $new_post, $attachment );
							}
							
						}
						
						if(isset($_POST['nsfw'])){
							$settings_meta = array(	  "safe"=>  "yes");
							meta::set_meta( $new_post , 'settings' , $settings_meta );
						}	
						
						/*add source meta data*/
						if(isset($_POST['source']) && trim($_POST['source']) != ''){
							$settings_meta = array(	  "post_source"=>  $_POST['source']);
							meta::set_meta( $new_post , 'source' , $settings_meta );	
						}
							
						
						/*add file url meta data*/
						$file_url_meta = array(	  "link"=>  $_POST['file'], "type" => 'link', 'link_id' => $_POST['file_id']);
						meta::set_meta( $new_post , 'format' , $file_url_meta );


						if(isset($_POST['post_format']) && ($_POST['post_format'] == 'video' || $_POST['post_format'] == 'image' || $_POST['post_format'] == 'audio' || $_POST['post_format'] == 'link') ){
							set_post_format( $new_post , $_POST['post_format']);
						}
						
						if(options::get_value( 'upload' , 'default_posts_status' ) == 'publish'){
							/*if post was publihed imediatelly then we will show the prmalink to the user*/
								
							$response['success_msg'] = sprintf(__('You can check your post %s here%s.','cosmotheme'),'<a href="'.get_permalink($new_post).'">','</a>');
							
						}else{
							$response['success_msg'] = __('Success. Your post is awaiting moderation.','cosmotheme');
						}	
						$response['post_id'] = $new_post;
				    }	
				    
	        		
        		}	
        	echo json_encode($response);
        	exit;
		}

		function add_audio_post(){
			$response = array(  'image_error' => '',
								'audio_error' => '',
        						'error_msg' => '',	
        						'title_error' => '',
        						'post_id' => 0,
        						'auth_error' => '',
        						'success_msg' => ''	);
        	
        	
        	$is_valid = true;
        	
        	if(!is_user_logged_in()){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['auth_error'] = __('You must be logged in to submit a post! ','cosmotheme');	
        	}
        	
            if(is_user_logged_in() && isset($_POST['post_id'])){
				$post_edit = get_post($_POST['post_id']);
				
				if(get_current_user_id() != $post_edit->post_author){
					$is_valid = false;	
					$response['error_msg'] = __('You are not the author of this post. ','cosmotheme');
					$response['title_error'] = __('You are not the author of this post. ','cosmotheme');
				}
			}
            
        	if(!isset($_POST['title']) || trim($_POST['title']) == ''){
        		$is_valid = false;	
        		$response['error_msg'] = 'Title is required. ';
        		$response['title_error'] = __('Title is required. ','cosmotheme');
        	}

			if(!isset($_POST['audio']) || $_POST['audio'] == '' ){
        		$is_valid = false;	
        		$response['error_msg'] = 'Audio File is required. ';
        		$response['audio_error'] = __('Audio File is required. ','cosmotheme');
        	}else{
				if(isset($_POST['audio']) && $_POST['audio'] != ''){
					$ext1 = substr($_POST['audio'], -4); /*get the last 4 chars*/
					
					if(($ext1 !='.mp3') ){
						$is_valid = false;	
						$response['error_msg'] = 'Invalid file format, only mp3 allowed. ';
						$response['audio_error'] = __('Invalid file format, only mp3 allowed. ','cosmotheme');
					}	
				}else{
					$is_valid = false;	
					$response['error_msg'] = 'Invalid file. ';
					$response['audio_error'] = __('Invalid file. ','cosmotheme');
				}
			}

        	if(isset($_POST['image_type']) ){
        		if($_POST['image_type'] == 'url_img'){

					if(isset($_POST['image_url']) && $_POST['image_url'] != ''){
        				if(self::isValidURL($_POST['image_url'])){
		        			$ext = substr($_POST['image_url'], -4); /*get the last 4 chars*/
		        			
		        			if(($ext !='.gif') && ($ext !='.jpg') && ($ext !='.png')){
		        				$is_valid = false;	
		        				$response['error_msg'] = 'Invalid image type';
        						$response['image_error'] = __('Invalid image type. ','cosmotheme');	
		        			}  		
		        		}else{
		        			$is_valid = false;	
		        			$response['error_msg'] = 'Invalid image URL';
        					$response['image_error'] = __('Invalid image URL. ','cosmotheme');
		        		}
					}		
        		}
        	}
        	
        	
        		if($is_valid){
        			/*create post*/
        			$post_categories = array(1);
        			if(isset($_POST['category_id'])){
        				$post_categories = array($_POST['category_id']);
        			}
        			
        			$post_content = '';
        			if(isset($_POST['audio_content'])){
        				$post_content = $_POST['audio_content'];
        			}

					if(isset($_POST['post_id'])){
						$new_post = self::create_new_post($_POST['title'], $_POST['tags'], $post_categories, $post_content, $_POST['post_id']);  
					}else{
						$new_post = self::create_new_post($_POST['title'],$_POST['tags'],$post_categories,$post_content);  
					}
                    
				    if(is_numeric($new_post)){	
						if($response['image_error'] == ''){  
							if($_POST['image_type'] == 'url_img'){
								require_once(ABSPATH . 'wp-admin/includes/file.php');
								require_once(ABSPATH . 'wp-admin/includes/media.php');
								require_once(ABSPATH . 'wp-admin/includes/image.php');
								
								/*attach an image to the post*/
								$upload =  media_sideload_image( urldecode($_POST['image_url']), $new_post);
								
								/* set attached image as featured image */
								// Associative array of attachments, as $attachment_id => $attachment
								$attachments = get_children( array('post_parent' => $new_post, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
								foreach ($attachments as $index => $id) {
									$attachment = $index;
								} 
								if(isset($attachment)){  
									set_post_thumbnail( $new_post, $attachment );
								}
		
							}elseif ($_POST['image_type'] == 'upload_img'){
								
                                if(isset($_POST['post_id']) && get_post_thumbnail_id($_POST['post_id']) != $_POST['image_id']){
                                    $attachment = $_POST['image_id']; 
                                }else{
                                    $attachment = $_POST['image_id']; 
                                }
								set_post_thumbnail( $new_post, $attachment );
							}
							
						}
						
						if(isset($_POST['nsfw'])){
							$settings_meta = array(	  "safe"=>  "yes");
							meta::set_meta( $new_post , 'settings' , $settings_meta );
						}	
						
						/*add source meta data*/
						if(isset($_POST['source']) && trim($_POST['source']) != ''){
							$settings_meta = array(	  "post_source"=>  $_POST['source']);
							meta::set_meta( $new_post , 'source' , $settings_meta );	
						}
							
						
						if(isset($_POST['audio']) && trim($_POST['audio']) != ''){
							
							meta::set_meta( $new_post , 'is_audio' , 'audio' );	 /*mark that for this post we've added audio short code at the end of the content*/
							/*add audio url meta data*/
							$audio_url_meta = array(	  "audio"=>  $_POST['audio'], "type" => 'audio');
							meta::set_meta( $new_post , 'format' , $audio_url_meta );
						}

						
						if(isset($_POST['post_format']) && ($_POST['post_format'] == 'video' || $_POST['post_format'] == 'image' || $_POST['post_format'] == 'audio' || $_POST['post_format'] == 'link') ){
							set_post_format( $new_post , $_POST['post_format']);
						}
						
						if(options::get_value( 'upload' , 'default_posts_status' ) == 'publish'){
							/*if post was publihed imediatelly then we will show the prmalink to the user*/
								
							$response['success_msg'] = sprintf(__('You can check your post %s here%s.','cosmotheme'),'<a href="'.get_permalink($new_post).'">','</a>');
							
						}else{
							$response['success_msg'] = __('Success. Your post is awaiting moderation.','cosmotheme');
						}	
						$response['post_id'] = $new_post;
				    }	
				    
	        		
        		}	
        	echo json_encode($response);
        	exit;
		}
        
        function add_text_post(){
        	$response = array(  'error_msg' => '',	
        						'title_error' => '',
        						'post_id' => 0,
        						'auth_error' => '' );
        	
        	$is_valid = true;
        	
        	if(!is_user_logged_in()){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['auth_error'] = __('You must be logged in to submit a post!','cosmotheme');	
        	}
        	
            if(is_user_logged_in() && isset($_POST['post_id'])){
				$post_edit = get_post($_POST['post_id']);
				
				if(get_current_user_id() != $post_edit->post_author){
					$is_valid = false;	
					$response['error_msg'] = __('You are not the author of this post. ','cosmotheme');
					$response['title_error'] = __('You are not the author of this post. ','cosmotheme');
				}
			}
            
        	if(!isset($_POST['title']) || trim($_POST['title']) == ''){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['title_error'] = __('Title is required. ','cosmotheme');
        	}
        	
        		if($is_valid){

	        			/*create post*/
        				/*$post_content = self::get_embeded_video($video_id,$video_type);*/
	        			$post_categories = array(1);
	        			//$response['video_error'] = $_POST['category_id'];
	        			if(isset($_POST['category_id'])){
	        				$post_categories = array($_POST['category_id']);
	        			}
	        			
	        			$post_content = '';
	        			if(isset($_POST['text_content'])){
	        				$post_content = $_POST['text_content'];
	        			}
	        			
                        if(isset($_POST['post_id'])){
                            $new_post = self::create_new_post($_POST['title'], $_POST['tags'], $post_categories, $post_content, $_POST['post_id']);  
                        }else{
                            $new_post = self::create_new_post($_POST['title'],$_POST['tags'],$post_categories,$post_content);  
                        }
                        
					    if(is_numeric($new_post)){	
						   
							
							if(isset($_POST['nsfw'])){
								$settings_meta = array(	  "safe"=>  "yes");
								meta::set_meta( $new_post , 'settings' , $settings_meta );
							}	
							
							/*add source meta data*/
						    if(isset($_POST['source']) && trim($_POST['source']) != ''){
								$settings_meta = array(	  "post_source"=>  $_POST['source']);
								meta::set_meta( $new_post , 'source' , $settings_meta );	
							}
						
							if(options::get_value( 'upload' , 'default_posts_status' ) == 'publish'){
								/*if post was publihed imediatelly then we will show the prmalink to the user*/
									
								$response['success_msg'] = sprintf(__('You can check your post %s here%s.','cosmotheme'),'<a href="'.get_permalink($new_post).'">','</a>');
								
							}else{
								$response['success_msg'] = __('Success. Your post is awaiting moderation','cosmotheme');
							}	
							$response['post_id'] = $new_post;
					    }
				
        		}
        			
        	echo json_encode($response);
        	exit;
        	
        }
        
        function add_video_post(){
        	$response = array(  'video_error' => '',
        						'error_msg' => '',	
        						'title_error' => '',
        						'post_id' => 0,
        						'auth_error' => '' );
        	
        	
        	$is_valid = true;
        	
        	if(!is_user_logged_in()){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['auth_error'] = __('You must be logged in to submit a post!','cosmotheme');	
        	}
        	
            if(is_user_logged_in() && isset($_POST['post_id'])){
				$post_edit = get_post($_POST['post_id']);
				
				if(get_current_user_id() != $post_edit->post_author){
					$is_valid = false;	
					$response['error_msg'] = __('You are not the author of this post. ','cosmotheme');
					$response['title_error'] = __('You are not the author of this post. ','cosmotheme');
				}
			}
            
        	if(!isset($_POST['title']) || trim($_POST['title']) == ''){
        		$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['title_error'] = __('Title is required. ','cosmotheme');
        	}
        	
			if(isset($_POST['video_type']) ){
				if($_POST['video_type'] == 'url_video'){	
					if(isset($_POST['video_url']) && trim($_POST['video_url']) != '' && self::isValidURL($_POST['video_url']) ){
						if(self::get_youtube_video_id($_POST['video_url']) == '0' && self::get_vimeo_video_id($_POST['video_url']) == '0'){
							$is_valid = false;	
							$response['error_msg'] = 'error';
							$response['video_error'] = __('Invalid format. ','cosmotheme');
						}
					}else{
						$is_valid = false;	
						$response['error_msg'] = 'error';
						$response['video_error'] = __('Invalid video URL. ','cosmotheme');
					}
				}elseif ($_POST['video_type'] == 'upload_video'){
					if(self::isValidURL($_POST['video_url'])){
		        		$is_valid = false;	
		        		$response['error_msg'] = 'error';
        				$response['video_error'] = __('Invalid video. ','cosmotheme');
		        	}
				}  
        	
			}else{
				$is_valid = false;	
        		$response['error_msg'] = 'error';
        		$response['video_error'] = __('Invalid video','cosmotheme');
			}
        	
        	if($is_valid){

				if($_POST['video_type'] == 'url_video'){  
					/*set video ID = youtube id*/
					if(self::get_youtube_video_id($_POST['video_url']) != '0'){
						$video_id = self::get_youtube_video_id($_POST['video_url']); 
						$video_type = 'youtube';
					}else{
						$video_id = self::get_vimeo_video_id($_POST['video_url']);
						$video_type = 'vimeo';
					}
				}else{
					$video_id =	$_POST['video_id'];
                    $video_type = 'self_hosted';
				}
        		
        		if($video_id != '0'){
        			
        			if(self::get_video_thumbnail($video_id,$video_type) != '' || $_POST['video_type'] == 'upload_video'){
						if($_POST['video_type'] == 'url_video'){  
							$video_image_url = self::get_video_thumbnail($video_id,$video_type);
						}
        				
	        			/*create post*/
        				/*$post_content = self::get_embeded_video($video_id,$video_type);*/
	        			$post_categories = array(1);
	        			//$response['video_error'] = $_POST['category_id'];
	        			
	        			if(isset($_POST['category_id'])){
	        				$post_categories = array($_POST['category_id']);
	        			}
	        			
	        			$post_content = '';
	        			if(isset($_POST['video_content'])){
	        				$post_content = $_POST['video_content'];
	        			}
	        			
        				
                        if(isset($_POST['post_id'])){
                            $new_post = self::create_new_post($_POST['title'], $_POST['tags'], $post_categories, $post_content, $_POST['post_id']);  
                        }else{
                            $new_post = self::create_new_post($_POST['title'],$_POST['tags'],$post_categories,$post_content);  
                        }
                    
					    if(is_numeric($new_post)){	

							if($_POST['video_type'] == 'url_video'){
                                $do_thumb_url = true;
                                if(isset($_POST['post_id'])){
                                    $format = meta::get_meta( $_POST['post_id'] , 'format' );
                                    if( isset( $format['video'] ) && !empty( $format['video'] ) && self::isValidURL( $format['video'] ) && self::get_vimeo_video_id( $format['video']) != 0  && self::get_youtube_video_id( $format['video'] ) != 0 ){
                                        if($format['video'] == $_POST['video_url']){
                                           $do_thumb_url = false; 
                                        }
                                    }
                                }
                                    
                                if($do_thumb_url){
                                    /*include the necesarry scripts for media_sideload_image() function*/
                                    require_once(ABSPATH . 'wp-admin/includes/file.php');
                                    require_once(ABSPATH . 'wp-admin/includes/media.php');
                                    require_once(ABSPATH . 'wp-admin/includes/image.php');

                                    /*attach an image to the post*/
                                    $upload =  media_sideload_image( urldecode($video_image_url), $new_post);

                                    /* set attached image as featured image */
                                    // Associative array of attachments, as $attachment_id => $attachment
                                    $attachments = get_children( array('post_parent' => $new_post, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC', 'orderby' => 'menu_order ID') );
                                    foreach ($attachments as $index => $id) {
                                        $attachment = $index;
                                    } 

                                    set_post_thumbnail( $new_post, $attachment );
                                }    
							}
							
							if(isset($_POST['nsfw'])){
								$settings_meta = array(	  "safe"=>  "yes");
								meta::set_meta( $new_post , 'settings' , $settings_meta );
							}	
							
							/*add source meta data*/
						    if(isset($_POST['source']) && trim($_POST['source']) != ''){
								$settings_meta = array(	  "post_source"=>  $_POST['source']);
								meta::set_meta( $new_post , 'source' , $settings_meta );	
							}
						

							/*add video url meta data*/
							if($_POST['video_type'] == 'url_video'){
								$video_url_meta = array(	  "video"=>  $_POST['video_url'], "type" => 'video');
							}elseif ($_POST['video_type'] == 'upload_video'){
								$video_url_meta = array(	  "video"=>  $_POST['video'], "type" => 'video');
							}
							meta::set_meta( $new_post , 'format' , $video_url_meta );

							if(isset($_POST['post_format']) && ($_POST['post_format'] == 'video' || $_POST['post_format'] == 'image' || $_POST['post_format'] == 'audio') ){
								set_post_format( $new_post , $_POST['post_format']);
							}
							
							
							if(options::get_value( 'upload' , 'default_posts_status' ) == 'publish'){
								/*if post was publihed imediatelly then we will show the prmalink to the user*/
									
								$response['success_msg'] = sprintf(__('You can check your post %s here%s.','cosmotheme'),'<a href="'.get_permalink($new_post).'">','</a>');
								
							}else{
								$response['success_msg'] = __('Success. Your post is awaiting moderation','cosmotheme');
							}	
							$response['post_id'] = $new_post;
					    }
				    
        			}else{
        				$is_valid = false;	
		        		$response['error_msg'] = 'error, could not create thumbnail for this video';
		        		$response['video_error'] = __('Invalid video URL. ','cosmotheme');
        			}
        			
        		}else{
        			$is_valid = false;	
	        		$response['error_msg'] = 'error';
	        		$response['video_error'] = __('Invalid video URL ','cosmotheme');
        		}
        	}
        			
        	echo json_encode($response);
        	exit;
        }
        
       
        function get_embeded_video($video_id,$video_type,$autoplay = 0,$width = 610,$height = 443){
        	
        	$embeded_video = '';
        	if($video_type == 'youtube'){
        		$embeded_video	= '<iframe width="'.$width.'" height="'.$height.'" src="http://www.youtube.com/embed/'.$video_id.'?wmode=transparent&autoplay='.$autoplay.'" wmode="opaque" frameborder="0" allowfullscreen></iframe>';
        	}elseif($video_type == 'vimeo'){
        		$embeded_video	= '<iframe src="http://player.vimeo.com/video/'.$video_id.'?title=0&amp;autoplay='.$autoplay.'&amp;byline=0&amp;portrait=0" width="'.$width.'" height="'.$height.'" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>';
        	}
        	
        	return $embeded_video;
        }
        
		function get_local_video($video_url, $width = 610, $height = 443, $autoplay = false ){
			
            $result = '';    
			
            if($autoplay){
                $auto_play = 'true';
            }else{
                $auto_play = 'false';
            }
            
            $result = '<embed src="' . get_template_directory_uri() . '/flv/gddflvplayer.swf" 
                flashvars="?&autoplay='.$auto_play.'&sound=70&buffer=2&vdo=' . $video_url . '" 
                width="'.$width.'" 
                height="'.$height.'" 
                allowFullScreen="true" 
                quality="best" 
                wmode="transparent" 
                allowScriptAccess="always"  
                pluginspage="http://www.macromedia.com/go/getflashplayer"  
                type="application/x-shockwave-flash"></embed>';
            

			return $result;	
		}
  
        function get_video_thumbnail($video_id,$video_type){
        	$thumbnail_url = '';
        	if($video_type == 'youtube'){
				$thumbnail_url = 'http://i1.ytimg.com/vi/'.$video_id.'/hqdefault.jpg';
        	}elseif($video_type == 'vimeo'){
        		
				$hash = wp_remote_get("http://vimeo.com/api/v2/video/$video_id.php");
				$hash = unserialize($hash['body']);
				
				$thumbnail_url = $hash[0]['thumbnail_large'];  
        	}
        	
        	return $thumbnail_url;
        }
        
    	function get_youtube_video_id($url){
	        /*
	         *   @param  string  $url    URL to be parsed, eg:  
	 		*  http://youtu.be/zc0s358b3Ys,  
	 		*  http://www.youtube.com/embed/zc0s358b3Ys
	 		*  http://www.youtube.com/watch?v=zc0s358b3Ys 
	 		*  
	 		*  returns
	 		*  */	
        	$id=0;
        	
        	/*if there is a slash at the en we will remove it*/
        	$url = rtrim($url, " /");
        	if(strpos($url, 'youtu')){
	        	$urls = parse_url($url); 
	     
			    /*expect url is http://youtu.be/abcd, where abcd is video iD*/
			    if(isset($urls['host']) && $urls['host'] == 'youtu.be'){  
			        $id = ltrim($urls['path'],'/'); 
			    } 
			    /*expect  url is http://www.youtube.com/embed/abcd*/ 
			    else if(strpos($urls['path'],'embed') == 1){  
			        $id = end(explode('/',$urls['path'])); 
			    } 
			     
			    /*expect url is http://www.youtube.com/watch?v=abcd */
			    else if( isset($urls['query']) ){ 
			        parse_str($urls['query']); 
			        $id = $v; 
			    }else{
					$id=0;
				} 
        	}	
			
			return $id;
        }
        
        function  get_vimeo_video_id($url){
        	/*if there is a slash at the en we will remove it*/
        	$url = rtrim($url, " /");
        	$id = 0;
        	if(strpos($url, 'vimeo')){
				$urls = parse_url($url); 
				if(isset($urls['host']) && $urls['host'] == 'vimeo.com'){  
					$id = ltrim($urls['path'],'/'); 
					if(!is_numeric($id) || $id < 0){
						$id = 0;
					}
				}else{
					$id = 0;
				} 
        	}	
			return $id;
		}
        

	    function isValidURL($url)
		{
			return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
		}

        function create_new_post($post_title,$post_tags, $post_categories, $content = '', $post_id = 0 ){
        	$current_user = wp_get_current_user();

        	$post_status = options::get_value( 'upload' , 'default_posts_status' )	;
        	if($post_id == 0){
				$post_args = array(
		            'post_title' => $post_title,
		            'post_content' => $content ,
		            'post_status' => $post_status,
		            'post_type' => 'post',
					'post_author' => $current_user -> ID,
					'tags_input' => $post_tags,
					'post_category' => $post_categories
		        );
                
                $new_post = wp_insert_post($post_args);
        	}else{
                $updated_post = get_post($post_id);
        		$post_args = array(
        			'ID' => $post_id,	
		            'post_title' => $post_title,
		            'post_content' => $content ,
		            'post_status' => $post_status,
                    'comment_status'=> $updated_post -> comment_status,
		            'post_type' => 'post',
					'post_author' => $current_user -> ID,
					'tags_input' => $post_tags,
        			'post_category' => $post_categories
		        );
                
                $new_post = wp_update_post($post_args);
        	}    
	
	        
	        
			if($post_status == 'pending'){ /*we will notify admin via email if a this option was activated*/
				if(is_email(options::get_value( 'upload' , 'pending_email' ))){
					$tomail = options::get_value( 'upload' , 'pending_email' );
					$subject = __('A new post is awaiting your moderation','cosmotheme');
					$message = __('A new post is awaiting your moderation.','cosmotheme');
					$message .= ' ';
					$message .= sprintf(__('To moderate the post go to  %s ','cosmotheme'), home_url('/wp-admin/post.php?post='.$new_post.'&action=edit')) ;

					wp_mail($tomail, $subject , $message);

				}	
			}

	        return $new_post;
        }

		function remove_post(){
			if(isset($_POST['post_id']) && is_numeric($_POST['post_id'])){
				$post = get_post($_POST['post_id']);
				if(get_current_user_id() == $post->post_author){ echo 'ee';
					wp_delete_post($_POST['post_id']);
				}
			}  

			exit;
		}
        
        function get_source($post_id){
        	
        	$source = '';
  			$source_meta = meta::get_meta( $post_id , 'source' );
  			
  			if(is_array($source_meta) && sizeof($source_meta) && isset($source_meta['post_source']) && trim($source_meta['post_source']) != ''){
  				if(self::isValidURL($source_meta['post_source'])){
  					$source_url = $source_meta['post_source'];
        			if( !is_numeric(strpos($source_meta['post_source'], 'http')) ){ /*if the $source dos not contain http we will add it*/
						$source_url = 'http://'.$source_meta['post_source'];
					}
        			$source = '<div class="source"><p><a href="'.$source_url.'" target="_blank" >'.__('View source','cosmotheme').'</a></p></div>';
        		}else{
        			$source = '<div class="source"><p>'.__('Source:','cosmotheme').' '.$source_meta['post_source'].'</p></div>';
        		}
  			}else{
  				$source = '<div class="source no_source"><p>'.__('Unknown source','cosmotheme').'</p></div>';
  			}
  			
        
        			
  			return $source;      	
        }

		function get_attached_file($post_id){
        	
        	$attached_file = '';
  			$attached_file_meta = meta::get_meta( $post_id , 'format' );

  			
			if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['link_id']) && is_numeric($attached_file_meta['link_id'])){

				$attachment_url = explode('/',wp_get_attachment_url($attached_file_meta['link_id']));
				$file_name = '';
				if(sizeof($attachment_url)){
					$file_name = $attachment_url[sizeof($attachment_url) - 1];
				}	
				$attached_file .= '<div class="attach">';
				$attached_file .= '	<a href="'.wp_get_attachment_url($attached_file_meta['link_id']).'">'.$file_name.'</a>';
				$attached_file .= '</div>';
			}	
  					
  			return $attached_file;      	
        }

		function get_audio_file($post_id){
        	
        	$attached_file = '';
  			$attached_file_meta = meta::get_meta( $post_id , 'format' );
  			
			if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['audio']) && $attached_file_meta['audio'] != '' ){

				
				$attached_file .= '[audio:'.$attached_file_meta['audio'].']';
				
			}	
  					
  			return $attached_file;      	
        }
        
        function play_video(){
        	$result = '';	
        	if(isset($_POST['video_id']) && isset($_POST['video_type']) && $_POST['video_type'] != 'self_hosted'){	
        		$result = self::get_embeded_video($_POST['video_id'],$_POST['video_type'],1);
        	}else{
                $video_url = urldecode($_POST['video_id']);
                $result = self::get_local_video($video_url, 610, 443, true );
            }	
        	
        	echo $result;
        	exit;
        }
        
        function list_tags($post_id){
            $tag_list = '';
            $tags = wp_get_post_terms($post_id, 'post_tag');

            if (!empty($tags)) {
                    $i = 1;
                    foreach ($tags as $tag) { 
                        if($i==1){
                            $tag_list .= $tag->name;
                        }else{
                            $tag_list .= ', '.$tag->name;
                        }    
                        $i++;
                    }
            }
            
            return $tag_list;
        }
    }
?>