<?php get_header(); ?>
<div class="b_content clearfix" id="main">

    <?php
        while( have_posts () ){
            the_post();
            $post_id = $post -> ID;
                    
            $classes = tools::login_attr( $post -> ID , 'nsfw' );
            $template = 'single';
            $attr = tools::login_attr( $post -> ID , 'nsfw mosaic-overlay' , get_permalink( $post -> ID ) );
            $size = 'tmedium';
            $s = image::asize( image::size( $post->ID , $template , $size ) );
            
            $zoom = false; 
            
            if( options::logic( 'general' , 'enb_featured' ) ){
                if ( has_post_thumbnail( $post -> ID ) && get_post_format( $post -> ID ) != 'video' ) {
                    $src        = image::thumbnail( $post -> ID , $template , $size );
                    $src_       = image::thumbnail( $post -> ID , $template , 'full' );
                    $caption    = image::caption( $post -> ID );
                    $zoom       = true;
                }
            }
    ?>
            <div class="content-title">
                <div class="left">&nbsp;</div>
                <div class="title">
                    <h1 class="entry-title">
                        <?php like::content( $post->ID , 1 ); ?>
                        <span><?php the_title(); ?></span>
                    </h1>
                    <nav class="hotkeys-meta">
                        <?php
                            $zclasses = ''; 
                            if( !( options::logic( 'general' , 'enb_lightbox' ) && $zoom )  ){
                                $zclasses = 'no-zoom';
                            }
                        ?>
                        <span class="nav-previous <?php echo $zclasses; ?>"><?php previous_post_link( '%link' , __('Previous', 'cosmotheme') ); ?></span>
                        <?php
                            if( options::logic( 'general' , 'enb_lightbox' ) && $zoom  ){
                        ?>
                                <span class="nav-zoom"><a href="<?php echo $src_[0]; ?>" title="<?php echo $caption;  ?>" rel="prettyPhoto-<?php echo $post -> ID; ?>"><?php _e( 'Full size' , 'cosmotheme' ); ?></a></span>
                        <?php
                            }
                        ?>
                        <span class="nav-next"><?php next_post_link( '%link' , __('Next', 'cosmotheme') ); ?></span>
                    </nav>
                </div>
                <div class="right">&nbsp;</div>
            </div>
                    
            <!-- Start content -->
            <div class="b_page clearfix">

                <!-- left sidebar -->
                <?php layout::side( 'left' , $post_id , 'single'); ?>

                <div id="primary" <?php tools::primary_class( $post_id , 'single' ); ?>>
                    <div id="content" role="main">
                        <div <?php tools::content_class( $post_id , 'single' , '' , false ); ?>>

                            <!-- post -->
                            <article id="post-<?php the_ID(); ?>" <?php post_class( 'post' , $post -> ID ); ?>>

                                <!-- header -->
                                <?php
                                    if( options::logic( 'general' , 'enb_featured' ) ){
                                        if ( has_post_thumbnail( $post -> ID ) && get_post_format( $post -> ID ) != 'video' ) {
                                            $src = image::thumbnail( $post -> ID , $template , $size );
                                            $caption = image::caption( $post -> ID );
                                ?>
                                            <!-- thumbnail -->
                                            <header class="entry-header">
                                                <div class="featimg">
                                                    <div class="img">
                                                        <?php
                                                            if ( strlen( $classes ) ) {
                                                                echo image::mis( $post -> ID , $template , $size , 'safe image' , 'nsfw' );
                                                            }else{
                                                                echo '<img src="' . $src[0] . '" alt="' . $caption . '" >';
                                                            }
                                                        ?>
                                                    </div>
                                                </div>
                                            </header>
                                <?php
                                        }
                                    }
                                    
                                    if( get_post_format( $post -> ID ) == 'video' ){

                                        $format = meta::get_meta( $post -> ID , 'format' );

                                        if( isset( $format['video'] ) && !empty( $format['video'] ) && post::isValidURL( $format['video'] ) && (post::get_vimeo_video_id( $format['video']) != 0  || post::get_youtube_video_id( $format['video'] ) != '0' )){
                                            $vimeo_id = post::get_vimeo_video_id( $format['video'] );
                                            $youtube_id = post::get_youtube_video_id( $format['video'] );
                                            $video_type = '';
                                            if( $vimeo_id != '0' ){
                                                $video_type = 'vimeo';
                                                $video_id = $vimeo_id;
                                            }

                                            if( $youtube_id != '0' ){
                                                $video_type = 'youtube';
                                                $video_id = $youtube_id;
                                            }

                                            if( !empty( $video_type ) ){
                                                ?>
                                                <!-- video format -->
                                                <header class="entry-header">
													<div class="featimg">
														<?php if( strlen( $classes ) ){ ?>
                                                        <div class="img">
														<?php } ?> 	
                                                            <?php
                                                                if( strlen( $classes ) ){
                                                                    echo image::mis($post->ID, $template, $size, 'safe image', 'nsfw');
                                                                }else{
                                                                    echo post::get_embeded_video( $video_id , $video_type );
                                                                }
                                                            ?>
														<?php if( strlen( $classes ) ){ ?>  
                                                        </div>
														<?php } ?> 		
                                                    </div>
                                                </header>
                                                <?php
                                            }
                                        }elseif(isset( $format['video'] ) && !empty( $format['video'] )  ){ 
												
											?>
												<header class="entry-header">
													<div class="featimg">
														<?php if( strlen( $classes ) ){ ?>
														<div class="img">
														<?php } ?> 	
															<?php
																if( strlen( $classes ) ){
																	echo image::mis($post->ID, $template, $size, 'safe image', 'nsfw');
																}else{
																	echo post::get_local_video( $format['video']  );
																}
															?>
														<?php if( strlen( $classes ) ){ ?>  
														</div>
														<?php } ?> 		
													</div>
												</header>
														
											<?php  
										}
									}
                                ?>
                                            
                                <!-- content -->
								<?php
									
									$meta_view_style = post::get_meta_view_style($post); 
								?>
                                <div class="entry-content <?php echo $meta_view_style; ?>">
                                    
                                    <!-- meta -->
                                    <?php
                                        if( meta::logic( $post , 'settings' , 'meta' ) ){
                                            post::meta( $post );
                                        }
                                    ?>
                                    <!-- text content -->
                                    <div class="b_text">
                                        <?php 
                                            if( strlen( $classes ) ){
                                                echo options::get_value( 'general' , 'nsfw_content' );
                                            }else{
                                                the_content(); 
                                            }
                                        ?>
										<?php
											if( strlen( $classes ) == 0 ){
												if( get_post_format( $post -> ID ) == 'link' ){
													echo post::get_attached_file( $post -> ID );
												}

												if( get_post_format( $post -> ID ) == 'audio' ){
													$audio = new AudioPlayer();	
													echo $audio->processContent( post::get_audio_file( $post -> ID ) );
												}
											}
										?>  
                                    </div>
                                </div>

                                <!-- footer -->
                                <footer class="entry-footer">
                                    <div class="share">
                                        <?php get_template_part('social-sharing'); ?>
                                    </div>
                                    <?php 
                                        if( strlen( $classes ) == 0 ){
                                            if(options::logic( 'blog_post' , 'show_source' ) && meta::logic( $post , 'settings' , 'meta' )){
                                                echo post::get_source($post -> ID);
                                            }
                                        }

                                        if( strlen( options::get_value( 'advertisement' , 'content' ) ) > 0 ){
                                    ?>
                                            <div class="cosmo-ads zone-2">
                                                <?php echo options::get_value( 'advertisement' , 'content' ); ?>
                                            </div>
                                    <?php
                                        }
                                    ?>
                                </footer>
                            </article>
                            
                            <p class="delimiter blank">&nbsp;</p>
                            
                            <?php
                                /* comments */
                                if( comments_open() ){
                                    if( options::logic( 'general' , 'fb_comments' ) ){
                                        ?>
                                        <div id="comments">
                                            <h3 id="reply-title"><?php _e( 'Leave a reply' , 'cosmotheme' ); ?></h3>
                                            <p class="delimiter">&nbsp;</p>
                                            <fb:comments href="<?php the_permalink(); ?>" num_posts="5" width="620" height="120" reverse="true"></fb:comments>
                                        </div>
                                        <?php
                                    }else{
                                        comments_template( '', true );
                                    }
                                }

                                /* related posts */
                                get_template_part( 'related-posts' );
                            ?>
                        </div>
                    </div>
                </div>
                
                <!-- right sidebar -->
                <?php layout::side( 'right' , $post_id , 'single' ); ?>
            </div>
    <?php
        }
    ?>
</div>
<?php get_footer(); ?>
