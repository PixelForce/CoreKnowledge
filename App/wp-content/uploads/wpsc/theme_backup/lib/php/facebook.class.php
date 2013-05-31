<?php
    class facebook{
        function cookie(){
            $args = array();
            if( isset( $_COOKIE[ 'fbs_' . options::get_value( 'social' , 'facebook_app_id' ) ] ) ){
                  parse_str(trim($_COOKIE[ 'fbs_' . options::get_value( 'social' , 'facebook_app_id' ) ], '\\"'), $args);
                  ksort($args);
                  $payload = '';
                  foreach ($args as $key => $value) {
                    if ($key != 'sig') {
                      $payload .= $key . '=' . $value;
                    }
                  }
                  if ( md5( $payload . options::get_value( 'social' , 'facebook_secret' ) ) != $args['sig'] ){
                    return null;
                  }
             }

             return $args;
        }

        function login($atts){
            global $wpdb;
            $cookie = facebook::cookie( );
            $perms = apply_filters('fb_connect_perms', array('email'));

            if( !empty( $cookie ) ){
?>
                <div id="fb-root"></div>
                <div class="fb-login-button" data-scope="email" data-perms="email" data-width="200" onclick="javascript:onLogin();">
                    <?php _e( 'Facebook' , 'cosmotheme' ); ?>
                </div>
<?php
            }else{
?>
                <div id="fb-root"></div>
                <fb:login-button scope="email" perms="email" width="200" onlogin="javascript:onLogin();">
                    <?php _e( 'Facebook' , 'cosmotheme' ); ?>
                </fb:login-button>
<?php
            }
?>
            <script type="text/javascript">
                var do_ = 0;
                function onLogin( ) {
                    do_ = 1;
                    if( jQuery.cookie('fbs_<?php echo options::get_value( 'social' , 'facebook_app_id' ); ?>') ){
                        jQuery( function(){
                            jQuery( '.simplemodal-login-fields' ).hide();
                            jQuery( '.simplemodal-login-activity').show();
                        });

                        window.location.href = ajaxurl + '?action=fb_user';
                    }
                }

                window.fbAsyncInit=function(){
                    FB.init({
                        appId:<?php echo options::get_value( 'social' , 'facebook_app_id' ); ?>,
                        status:true,
                        cookie:true,
                        xfbml:true
                    });

                    FB.Event.subscribe('auth.login', function(){
                        if( do_ == 1 ){
                            onLogin( 'subscribe' );
                            do_ = 0;
                        }
                    });
                };
                (function() {
                    var e = document.createElement('script');
                    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
                    e.async = true;
                    document.getElementById('fb-root').appendChild(e);
                }());
            </script>
<?php
            exit();
        }

        function id(){
            if( is_user_logged_in () ){
                $cookie = self::cookie();
                if ( !empty( $cookie ) ) {
                    $data = wp_remote_get( 'https://graph.facebook.com/me?access_token=' . $cookie['access_token'] );
                    $user = json_decode( $data['body'] );
                    if( !isset( $user -> error ) ){
                        global $current_user;
                        get_currentuserinfo();
                        $fb_uid = get_user_meta($current_user->ID , 'fb_uid' , true );
                        if( $fb_uid == $user -> id ){
                            return $user -> id;
                        }
                    }
                }
            }
            
            return '';
        }
        function picture(){
            if( is_user_logged_in () ){
                $cookie = self::cookie();
                if ( !empty( $cookie ) ) {
                    $data = wp_remote_get( 'https://graph.facebook.com/me?access_token=' . $cookie['access_token'] );
                    $user = json_decode( $data['body'] );
                    if( !isset( $user -> error ) ){
                        global $current_user;
                        get_currentuserinfo();
                        $fb_uid = get_user_meta($current_user->ID , 'fb_uid' , true );
                        if( $fb_uid == $user -> id ){
                            return 'http://graph.facebook.com/' . $user -> id . '/picture';
                        }
                    }
                }
            }

            return '';
        }

        function user(){
            global $wpdb;
            $cookie = self::cookie();
            if ( !empty( $cookie ) ) {

                $data = wp_remote_get( 'https://graph.facebook.com/me?access_token=' . $cookie['access_token'] );
                $user = json_decode( $data['body'] );


                if( !empty( $user ) && !isset( $user -> error ) ){

                    if( !isset( $user -> email ) || empty( $user -> email ) ){
                        do_action('fb_connect_get_email_error');
                    }

                    if( is_user_logged_in() ){
                        global $current_user;
                        get_currentuserinfo();
                        $fb_uid = get_user_meta($current_user->ID, 'fb_uid', true);
                        if($fb_uid == $user->id){
                            wp_redirect( home_url() );
                            return true;
                        }

                        if( $user->email == $current_user->user_email ) {
                            do_action('fb_connect_wp_fb_same_email');
                            $fb_uid = get_user_meta( $current_user -> ID , 'fb_uid' , true);
                            if( !$fb_uid ){
                                update_user_meta( $current_user -> ID , 'fb_uid' , $user -> id );
                            }
                            wp_redirect( home_url() );
                            return true;
                        } else {
                            do_action('fb_connect_wp_fb_different_email');
                            $fb_uid = get_user_meta($current_user->ID, 'fb_uid', true);
                            if( !$fb_uid )
                                update_user_meta( $current_user->ID, 'fb_uid', $user->id );
                            $fb_email = get_user_meta($current_user->ID, 'fb_email', true);
                            if( !$fb_uid )
                                update_user_meta( $current_user->ID, 'fb_email', $user->email );
                            wp_redirect( home_url() );
                            return true;
                        }
                    }else{
                        $existing_user = $wpdb->get_var( 'SELECT DISTINCT `u`.`ID` FROM `' . $wpdb->users . '` `u` JOIN `' . $wpdb->usermeta . '` `m` ON `u`.`ID` = `m`.`user_id`  WHERE (`m`.`meta_key` = "fb_uid" AND `m`.`meta_value` = "' . $user->id . '" ) OR user_email = "' . $user->email . '" OR (`m`.`meta_key` = "fb_email" AND `m`.`meta_value` = "' . $user->email . '" )  LIMIT 1 ' );
                        if( $existing_user > 0 && is_email( $user -> email ) ){
                            $fb_uid = get_user_meta($existing_user, 'fb_uid', true);
                            if( !$fb_uid ){
                                update_user_meta( $new_user, 'fb_uid', $user->id );
                            }

                            $user_info = get_userdata( $existing_user );
                            do_action('fb_connect_fb_same_email');
                            wp_set_auth_cookie( $existing_user , true , false );
                            do_action( 'wp_login' , $user_info -> user_login );
                            if( wp_get_referer() ){
                                wp_redirect( wp_get_referer() );
                            }else{
                                wp_redirect( $_SERVER['REQUEST_URI'] );
                            }
                            exit();
                        }else{
                            do_action('fb_connect_fb_new_email');
                            $username = sanitize_user( $user -> first_name , true );
                            $i='';
                            while( username_exists( $username . $i ) ){
                                $i = absint($i);
                                $i++;
                            }

                            $username = $username . $i;
                            $userdata = array(
                                'user_pass'		=>	wp_generate_password(),
                                'user_login'	=>	$username,
                                'user_nicename'	=>	$username,
                                'user_email'	=>	$user -> email,
                                'display_name'	=>	$user -> name,
                                'nickname'		=>	$username,
                                'first_name'	=>	$user -> first_name,
                                'last_name'		=>	$user -> last_name,
                                'role'			=>	'subscriber'
                            );

                            $userdata = apply_filters( 'fb_connect_new_userdata' , $userdata , $user );
                            $new_user = absint( wp_insert_user( $userdata ) );
                            do_action( 'fb_connect_new_user' , $new_user );
                            if( $new_user > 0 ){
                                update_user_meta( $new_user, 'fb_uid', $user->id );
                                $user_info = get_userdata($new_user);
                                wp_set_auth_cookie($new_user, true, false);
                                do_action('wp_login', $user_info->user_login);
                                wp_redirect(wp_get_referer());
                                exit();
                            } else {
                                wp_redirect( home_url() );
                                exit();
                            }
                        }
                    }
                }
            }
            wp_redirect( home_url() );
            exit();
        }
    }
?>