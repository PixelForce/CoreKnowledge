<?php
	class layout{
        static $size = array(
            'large' => 930,
            'lmedium' => 640,
            'medium' => 610
        );
        static function side( $side = 'right' , $post_id = 0 , $template = null ){
            $position = false;
            if( strlen( $side ) ){
                if( $post_id > 0 ){
                    $layout = meta::get_meta( $post_id , 'layout' );

                    if( isset( $layout['type'] ) && !empty( $layout['type'] ) ){
                        $result = $layout['type'];
                    }else{
                        
                        if( strlen( $template ) ){
                            $result = options::get_value( 'layout' , $template );
                        }else{
                            $result = $side;
                        }
                    }
                }else{
                    if( strlen( $template ) ){
                        $result = options::get_value( 'layout' , $template );
                    }else{
                        $result = $side;
                    }
                }

                if( $side == 'right' ){
                    $classes = 'fr';
                }else{
                    $classes = 'fl';
                }

                if( $result == $side ){
                    echo '<div id="secondary" class="widget-area w_280 ' . $classes . '" role="complementary">';
                    echo '<div class="b w_260">';
                    if( is_author() ){
                        get_template_part('author-box');
                    }
                    if( isset( $layout['sidebar'] ) && !empty( $layout['sidebar'] ) ){                        
                        if(dynamic_sidebar ( $layout['sidebar'] ) ){

                        }
                    }else{
                        $layout = options::get_value( 'layout' , $template . '_sidebar' );
                        if( !empty( $layout ) ){
                            if(dynamic_sidebar ( $layout ) ){

                            }
                        }else{
                            get_sidebar( );
                        }
                        
                    }
                    echo '</div>';
                    echo '</div>';

                    $position = true;
                }
            }

            return $position;
        }

        static function length( $post_id = 0 , $template = null , $larger = false ){
            $layout = meta::get_meta( $post_id , 'layout' );
            if( isset( $layout['type'] ) && !empty( $layout['type'] ) && $layout['type'] == 'full' ) {
                $length = self::$size['large'];
            }else{
                if( strlen( $template ) ){
                    $result = options::get_value( 'layout' , $template );
                    if( $result == 'full' ){
                        if( isset( $layout['type'] ) && $layout['type'] != 'full' ){
                            if( $larger ){
                                $length = self::$size['lmedium'];
                            }else{
                                $length = self::$size['medium'];
                            }
                        }else{
                            $length = self::$size['large'];
                        }
                    }else{
                        if( $larger ){
                            $length = self::$size['lmedium'];
                        }else{
                            $length = self::$size['medium'];
                        }
                    }
                }
            }

            return $length;
        }

	}
?>