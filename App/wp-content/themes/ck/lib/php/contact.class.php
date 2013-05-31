<?php
    class contact{
        static function send_mail( ){
            if( isset( $_POST['btn_send'] ) && !empty( $_POST['btn_send'] ) && isset($_POST['contact_email']) && is_email($_POST['contact_email'])  ){

                $tomail = $_POST['contact_email'];
                $result = '';
                if( isset( $_POST['name'] ) && strlen( $_POST['name'] ) ) {
                    $name =  trim( $_POST['name'] );
                }else{
                    $result .= '<div style="width:100%; padding:5px 0; text-align:center; background:#ffd2d2; color:#d90000; ">' .  __('Please fill in the name field.','cosmotheme') . '</div>';
                }

                if( isset( $_POST['email'] ) && is_email( $_POST['email'] ) ){
                    $frommail = trim( $_POST['email'] );
                }else{
                    if( strlen( $result ) ){
                        $result .= '';
                    }
                    $result .= '<div style="width:100%; padding:5px 0; text-align:center; background:#ffd2d2; color:#d90000; ">' .  __('Please fill in the email field.','cosmotheme') . '</div>';

                }

                if( isset( $_POST['message'] ) && strlen($_POST['message']) ){
                	$message = '';
                	if( isset($_POST['name']) ){
                		$message .= __('Contact name: ','cosmotheme'). trim($_POST['name'])."\n";
                	}
                	if( isset($_POST['email']) ){
                		$message .= __('Contact email: ','cosmotheme'). trim($_POST['email'])."\n";
                	}
                	if( isset($_POST['phone']) ){
                		$message .= __('Contact phone: ','cosmotheme'). trim($_POST['phone'])."\n\n";
                	}

                    $message .= trim( $_POST['message'] );
                }else{
                    if( strlen( $result ) ){
                        $result .= '';
                    }
                    $result .= '<div style="width:100%; padding:5px 0; text-align:center; background:#ffd2d2; color:#d90000; margin-bottom:15px;">' .  __('Please fill in the message field.','cosmotheme') . '</div>';
                }

                if( strlen( $result ) ){
                    echo $result;
                    exit();
                }

                if( is_email( $tomail ) && strlen( $tomail ) && strlen( $frommail ) &&  strlen( $name ) && strlen( $message ) ){
                	$subject = $_POST['name'].' - '.get_bloginfo('name').__(' Contact Form','cosmotheme');
					$header = 'From: '.$_POST['name'].' <'.$_POST['email'].'>';
                    wp_mail($tomail, $subject , $message, $header);
                    echo '<div class="success" style="width:100%; padding:8px 0; text-align:center; background:#cbffc2; color:#007603; margin-bottom:15px;">' . __('Email sent successfully.','cosmotheme') . '</div>';
                }else{
                    _e('error, sending email failed','cosmotheme');
                }
            }
            exit;
        }

        static function get_contact_form( $email ){
?>
            <form id="comment_form" class="form comments b_contact" method="post" action="<?php echo home_url() ?>/">
			  <fieldset>
				  <p class="input">
					  <input type="text" onfocus="if (this.value == '<?php _e( 'Your name' , 'cosmotheme' ); ?> *') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Your name' , 'cosmotheme' ); ?> *';}" value="<?php _e( 'Your name' , 'cosmotheme' ); ?> *" name="name" id="name" />
				  </p>
				  <p class="input">
					  <input type="text" onfocus="if (this.value == '<?php _e( 'Your email' , 'cosmotheme' ); ?> *') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Your email' , 'cosmotheme' ); ?> *';}" value="<?php _e( 'Your email' , 'cosmotheme' ); ?> *" name="email" id="email" />
				  </p>
				  <p class="textarea">
					  <textarea onfocus="if (this.value == '<?php _e( 'Message' , 'cosmotheme' ); ?> *') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'Message' , 'cosmotheme' ); ?> *';}" tabindex="4" cols="50" rows="10" id="comment" name="message"><?php _e( 'Message' , 'cosmotheme' ); ?> *</textarea>
				  </p>
				  <p class="button hover">
					  <input type="button" value="<?php _e( 'Submit form' , 'cosmotheme' ); ?>" name="btn_send" onclick="javascript:act.send_mail( 'contact' , '#comment_form' , 'p#send_mail_result' );" class="inp_button" />
				  </p>
				  <p id="send_mail_result">
				  </p>
				  <input type="hidden" value="<?php echo $email; ?>" name="contact_email"  />
			  </fieldset>
		  </form>
<?php

        }
    }
?>