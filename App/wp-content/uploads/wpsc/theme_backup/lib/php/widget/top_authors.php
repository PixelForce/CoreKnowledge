<?php
    class widget_top_authors extends WP_Widget {

        function widget_top_authors() {
            $widget_ops = array( 'classname' => 'widget_top_authors widget_tabber' , 'description' => __( 'Top authors. (In order for this widget to function please install WordPress JetPack plugin)' , 'cosmotheme' ) );
            $this -> WP_Widget( 'widget_top_authors' , _TN_ . ' : ' . __( 'Top authors' , 'cosmotheme' ) , $widget_ops );
        }

        function widget( $args , $instance ) {

            /* prints the widget*/
            extract($args, EXTR_SKIP);

            if( isset( $instance['title'] ) ){
                $title = $instance['title'];
            }else{
                $title = '';
            }

            if( isset( $instance['nr_authors'] ) ){
                $nr_authors = $instance['nr_authors'];
            }else{
                $nr_authors = 0;
            }

            

            echo $before_widget;

            if( !empty( $title ) ){
                echo $before_title . $title . $after_title;
            }

        ?>
            <!-- menu tabber -->
            <ul class="widget_tabber">
                <li class="active"><a href="#tabber_7_days"><?php _e( '7 days' , 'cosmotheme' )?></a></li>
                <li><a href="#tabber_30_days"><?php _e( '30 days' , 'cosmotheme' )?></a></li>
                
            </ul>

            <!-- panel 7 days -->
            <div id="tabber_7_days_panel" class="tab_menu_content tabs-container">
                <?php
                    echo self::getTopAuthors($nr_authors,$last_days = 7);
                ?>
            </div>

            <!-- panel 30 days -->
            <div id="tabber_30_days_panel" class="tab_menu_content tabs-container hidden">
                <?php
                    echo self::getTopAuthors($nr_authors,$last_days = 30);
                ?>
            </div>

           
        <?php
            echo $after_widget;
        }

        function update( $new_instance, $old_instance) {

            /*save the widget*/
            $instance = $old_instance;
            $instance['title'] = strip_tags( $new_instance['title'] );
            $instance['nr_authors'] = strip_tags( $new_instance['nr_authors'] );
            
            return $instance;
        }

        function form($instance) {

            /* widget form in backend */
			if( isset($instance['title']) ){
                $title = esc_attr($instance['title']);
            }else{
                $title = __( 'Top Authors' , 'cosmotheme' );
            }

            $instance = wp_parse_args( (array) $instance, array( 'title' => '' , 'nr_authors' => 10  ) );
            
			
            $nr_authors = strip_tags( $instance['nr_authors'] );
            
    ?>

            <p>
                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title','cosmotheme') ?>:
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                </label>
            </p>
            <p>
                <label for="<?php echo $this->get_field_id('nr_authors'); ?>"><?php _e( 'Number authors to dislay' , 'cosmotheme' ) ?>:
                    <input class="widefat digit" id="<?php echo $this->get_field_id('nr_authors'); ?>" name="<?php echo $this->get_field_name('nr_authors'); ?>" type="text" value="<?php echo esc_attr( $nr_authors ); ?>" />
                </label>
            </p>
           
    <?php
        }

        /* aditional functions */
        function getTopAuthors($number,$last_days = 7){
			$result = '';
			wp_reset_query();

			$top_authors = null;
			if ( function_exists('stats_get_csv')   ){


				$key = 'top_read_authors_'.$last_days;

				
				$top_authors = stats_get_csv('postviews', "&days=$last_days&limit=-1&summarize"); 
				echo '<span style="display:none">'.count($top_authors).'</span>'; /*for debugging*/
				
				if ( is_array( $top_authors ) && sizeof( $top_authors ) ) {	 

					$most_read_authors = array(); 
					foreach ( $top_authors as $post ){ 
						$postTitle = $post['post_title'];
						
						/*consider only posts*/
						if(get_post_type($post['post_id']) == 'post' && $post['post_title'] != 'Home page'){			

							$post_info1 = get_post($post['post_id']);

							if( array_key_exists($post_info1-> post_author, $most_read_authors ) ){ 
								$most_read_authors[$post_info1-> post_author] =  $most_read_authors[$post_info1-> post_author] + $post['views'];  
							}else{
								if(sizeof($most_read_authors) < $number || $number = 0){	
									$most_read_authors[$post_info1-> post_author] = $post['views'];
								}
							}		
							
						}
					}

					/*sort the array:*/ 
					asort($most_read_authors);
					$most_read_authors = array_reverse($most_read_authors, true);
				
					if(is_array($most_read_authors) && sizeof($most_read_authors)){  
						$result .= '<ul>';
						foreach($most_read_authors as $index => $post_views){
							$args = array('include' => $post['post_id'] );	
							$post_info = get_posts($args);
							
							$result .= '<li>';  
							$result .= '<a class="entry-img" href="'.get_author_posts_url($index).'" >';
                            $size = image::asize( 'tsmall' );
							$result .= cosmo_avatar( $index , $size[0] , $default = DEFAULT_AVATAR );
							$result .= '</a>';	
							$result .= '<article class="entry-item"> ';
							$result .= '<a href="'.get_author_posts_url($index).'" class="top_author_avatar">' . get_the_author_meta( 'display_name' , $index ) .'</a> ';
							$views_label = __('views','cosmotheme');
							if($post_views == 1){
								$views_label = __('view','cosmotheme');
							}
							$result .= '<span class="author_nr_views">' . $post_views . ' ' . $views_label . '</span>';
							$result .= '</article> ';
							$result .= '</li>';
						}
						$result .= '</ul>';  
					}  
				}
			}else{
				$result = __('In order for this widget to function please install WordPress JetPack plugin','cosmotheme');
			}

			return $result;
		}
    }
?>