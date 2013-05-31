<?php
    class tools{
        function primary_class( $post_id , $template ){
            ob_start();
            ob_clean();
            $left = layout::side( 'left' , $post_id , $template );
            if( layout::length( $post_id , $template ) == layout::$size['large'] ){
                $classes = 'fullwidth';
            }else{
                if( $left ){
                    $classes = 'fr';
                }else{
                    $classes = 'fl';
                }
            }
            ob_get_clean();
            echo 'class="w_' . layout::length( $post_id , $template , true ) . ' ' . $classes . '"';
        }

        function content_class( $post_id , $template , $side = '' , $with_grid = true ){
            $grid = self::is_grid( $template , $side );

            echo 'class="w_' . layout::length( $post_id , $template ) . '  ' . str_replace( '_' , '-' , $template ) . ' ';
            if( $with_grid ){
                if( $grid ){
                    echo 'grid-view';
                }else{
                    echo 'list-view';
                }
            }
            echo '"';
        }

        function entry_class( $post_id , $template , $classes = '' ){
            ob_start();
            ob_clean();
            $left = layout::side( 'left' , $post_id , $template );
            if( layout::length( $post_id , $template ) == layout::$size['large'] ){
                $classes .= ' b w_290';
            }else{
                if( $left ){
                    $classes .= ' w_610';
                }else{
                    $classes .= ' w_610';
                }
            }
            ob_get_clean();
            echo 'class="' . $classes . '"';
        }

        function switch_view( $template , $side = '' ){
            $grid = self::is_grid( $template , $side );

            echo '<span class="list-grid fr"><a href="javascript:javascript:void(0);" rel="' . $template . $side . '" class="switch ';
            if( strlen( $side ) > 0  ){
                echo ' side ';
            }
            if( $grid ){
                echo 'swap';
            }
            echo '">&nbsp;</a></span>';
			
			if( $template != 'category' && $template != 'search' && $template != 'tag' && $template != 'archive' && $template != 'author'){
			    echo '<p class="delimiter blank">&nbsp;</p>';
			}		
        }
        static function nsfw_class( $post_id ){
            if( self::is_nsfw( $post_id ) ){
                $result = ' nsfw';
            }else{
                $result = ' ';
            }

            return $result;
        }

        static function login_attr( $post_id , $type , $url = '' ){

            if( strlen( $url) ){
                $result = 'href="' . $url . '"';
            }else{
                $result = '';
            }
            if( !is_user_logged_in () ){
                if( self::is_nsfw( $post_id ) ){
                    if( strlen( $url ) ){
                        $result = 'class="simplemodal-' . $type . '" href="' . wp_login_url( ) . '"';
                    }else{
                        $result = 'simplemodal-' . $type;
                    }
                }
            }
            
            return $result;
        }
        
        static function is_nsfw( $post_id ){
            $post = get_post( $post_id );
            $meta = meta::get_meta( $post -> ID  , 'settings' );
            if( isset( $meta['safe'] ) ){
                if( meta::logic( $post , 'settings' , 'safe' ) ){
                    $result = true;
                }else{
                    $result = false;
                }
            }else{
                $result = false;
            }

            return $result;
        }

        static function is_grid( $template , $side = '' ){
            $grid = false;

            if( isset( $_COOKIE[ZIP_NAME.'_grid_' . $template . $side ] ) ){
                if( $_COOKIE[ZIP_NAME.'_grid_' . $template . $side ] == 'grid'  ){
                    $grid = true;
                }else{
                    $grid = false;
                }
            }else{
                if( strlen( $side ) ){
                    if( options::logic( 'front_page' , 'v' . $side  ) ){
                        $grid = false;
                    }else{
                        $grid = true;
                    }
                }else{
                    if( options::logic( 'layout' , 'v_' . $template  ) ){
                        $grid = false;
                    }else{
                        $grid = true;
                    }
                }
            }

            return $grid;
        }
        
        static function tour( $pos ,  $location , $id , $type , $title , $body , $nr ,  $next = true ){
            
            $nrs = explode('/' , $nr );
            
            /* stap */
            if( isset( $_COOKIE[ ZIP_NAME.'_tour_stap_' . $location . '_' . $id ] ) && (int)$_COOKIE[ ZIP_NAME.'_tour_stap_' . $location . '_' . $id ] > 0  ){
                $k = $_COOKIE[ ZIP_NAME.'_tour_stap_' . $location . '_' . $id ] + 1;
            }else{
                $k = 1;
            }
            
            if( $nrs[0] == $k ){
                $classes = '';
            }else{
                $classes = 'hidden';
            }
        ?>
            <div class="demo-tooltip <?php echo $classes; ?>" index="<?php echo $nrs[0] - 1; ?>" rel="<?php echo $location . '_' . $id; ?>" style="top: <?php echo $pos[0]; ?>px; left: <?php echo $pos[1]; ?>px; "><!--Virtual guide starts here. Set coordinates top and left-->
                <span class="arrow <?php echo $type; ?>">&nbsp;</span><!--Available arrow position: left, right, top -->
                <header class="demo-steps">
                    <strong class="fl"><?php echo $title; ?></strong>
                    <span class="fr"><?php echo $nr; ?></span><!--Step number from-->
                </header>
                <div class="demo-content">
                    <?php echo stripslashes( $body ); ?>
                    <?php
                        if( $next ){
                    ?>
                            <p class="fr close"><a href="#" class="close"><?php _e( 'Do not show hints anymore' , 'cosmotheme' ); ?></a></p>
                    <?php
                        }
                    ?>
                </div>
                <footer class="demo-buttons">
                    <?php
                        if( $next ){
                    ?>
                            <p class="fl button-small"><a href="#" class="next"><?php _e( 'Next feature' , 'cosmotheme' ); ?></a></p>
                            <p class="fr button-small gray"><a href="#" class="skip"><?php _e( 'Skip' , 'cosmotheme' ); ?></a></p>
                    <?php
                        }else{
                            ?><p class="fr button-small gray"><a href="#" class="close"><?php _e( 'Close' , 'cosmotheme' ); ?></a></p><?php
                        }
                    ?>
                            
                    
                </footer>
            </div>
        <?php
        }
    }
?>