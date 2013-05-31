<?php 

if(is_user_logged_in()){
    $post_format = '';
    if(isset ($_GET['post']) && is_numeric($_GET['post'])){
        $post_id = $_GET['post'];
		
		$the_source = '';
		$source_meta = meta::get_meta( $post_id , 'source' );
		if(is_array($source_meta) && sizeof($source_meta) && isset($source_meta['post_source']) && trim($source_meta['post_source']) != ''){
			$the_source = $source_meta['post_source'];
			
		}
					
        $post_edit = get_post($post_id);
        
		$post_categories = wp_get_post_categories( $post_id );	
        switch(get_post_format( $post_id )){
            case 'video':
                $post_format = 'video';
                $action_edit_video = true;    
                break;
            case 'audio':
                $post_format = 'audio';
                $action_edit_audio = true;
                break;
            case 'link':
                $post_format = 'link';
                $action_edit_link = true;
                break;
            case 'image':
                $post_format = 'image';
                $action_edit_image = true;
				
                break;
            default:
                $post_format = 'default';
                $action_edit_text = true;
                
            
        }
        
		if(has_post_thumbnail( $post_id )){
			$thumb_id = get_post_thumbnail_id($post_id);
		}
        
    } 
?>
<div class="cosmo-box error medium hidden" id="video_error_msg_box">
	<span class="cosmo-ico"></span> 
	<span id="video_error_msg" ></span> 
</div>
<div class="cosmo-tabs submit" id="d39">
    <?php if(!isset($post_id)) { ?>    
	<ul class="tabs-nav"> 
		<?php if( (options::logic( 'upload' , 'enb_image' ) )  ){	?>
		<li class="first image tabs-selected"><a href="#pic_upload"><span><?php _e('Image','cosmotheme'); ?></span></a></li>
		<?php } ?> 
		<?php if( options::logic( 'upload' , 'enb_video' ) ){	?>
        <li class="video <?php if( isset($post_id) && $post_format =='video'){echo 'first tabs-selected'; } ?>"> <a href="#video_upload"><span><?php _e('Video','cosmotheme'); ?></span></a></li>
		<?php } ?> 
		<?php if( options::logic( 'upload' , 'enb_text' ) && !isset($post_id)  ){	?>
		<li class="text <?php if( isset($post_id) && $post_format =='standard'){echo 'first tabs-selected'; } ?>"> <a href="#text_post"><span><?php _e('Text','cosmotheme'); ?></span></a></li>
		<?php } ?> 
		<?php if( options::logic( 'upload' , 'enb_audio' ) && !isset($post_id)  ){	?>
		<li class="audio <?php if( isset($post_id) && $post_format =='audio'){echo 'first tabs-selected'; } ?>"> <a href="#audio_post"><span><?php _e('Audio','cosmotheme'); ?></span></a></li>
		<?php } ?>
		<?php if( options::logic( 'upload' , 'enb_file' ) && !isset($post_id)  ){	?>
		<li class="attach <?php if( isset($post_id) && $post_format =='link'){echo 'first tabs-selected'; } ?>"> <a href="#file_post"><span><?php _e('File','cosmotheme'); ?></span></a></li>
		<?php } ?> 
	</ul>
    <?php } ?>
	<?php if( (options::logic( 'upload' , 'enb_image' ) && !isset($post_id) ) || ( isset($post_id) && $post_format == 'image')  ){	?>
	<div class="tabs-container" id="pic_upload">
        <form method="post" action="/post-item?phase=post" id="form_post_image" >  
			<h3><?php if( isset($post_id) && $post_format == 'image'){ _e('Edit picture','cosmotheme'); }else{ _e('Add picture','cosmotheme'); } ?></h3>
			<div class="field">
				<label id="label_url_img" <?php if(isset($thumb_id)  ) {?>style="display:none" <?php } ?>>
					<h4><?php _e('Image URL','cosmotheme'); ?></h4>
					
					<input type="text" name="image_url" value="" class="generic-record front_post_input" id="image_url"  />
										
				</label>
				<label id="label_upload_img" <?php if(!isset($thumb_id) ){ ?>style="display:none" <?php } ?> >
					<h4><?php _e('Image URL','cosmotheme'); ?></h4>
					
					<?php
						$action['group'] = 'img';
						$action['topic'] = 'upload';
						$action['index'] = '';
						$action['upload_url'] =  home_url().'/wp-admin/media-upload.php?post_id=-1&amp;type=image&amp;TB_iframe=true';
					?>
					<input type="text" name="image" value="<?php if(isset($thumb_id)){$thumb_url = wp_get_attachment_image_src( $thumb_id,'full'); echo $thumb_url[0]; } ?>" class="generic-record front_post_input" id="img_upload"  onclick="jQuery('#upload_btn').click();"  />
					<input type="button" class="button-primary hidden front_post_input" id="upload_btn" value="<?php _e('Choose File','cosmotheme'); ?>" <?php echo fields::action( $action , 'extern-upload-id' ) ?>  />
					
                    <input type="hidden" value="<?php if(isset($thumb_id)){echo $thumb_id;} ?>" name="image_id" id="img_upload_id"  class="generic-record generic-single-record " />
				
				</label>
				<input type="hidden" value="<?php if(isset($thumb_id)){echo 'upload_img';}else{ echo 'url_img'; } ?>" id="image_type" name="image_type">
				<p class="info">
					<span class="warning" style="display:none; " id="img_warning"></span>
					<a class="upload_photo <?php if(isset($thumb_id)){echo 'hide';} ?>" href="javascript:void(0)"  onclick="swithch_image_type('upload_img','');" id="swithcher_upload_img" ><strong><?php _e('Upload a file.','cosmotheme'); ?></strong></a>
					<a class="post_link <?php if(!isset($thumb_id)){echo 'hide';} ?>" href="javascript:void(0)" onclick="swithch_image_type('url_img','');" id="swithcher_url_img" ><strong><?php _e('Use a URL.','cosmotheme'); ?></strong></a> <?php _e('JPEG, GIF or PNG.','cosmotheme'); ?>
				</p>
				
			</div>

			<div class="field">
				<label>
					<h4><?php _e('Title','cosmotheme')?></h4>
					<input type="text" class="text tipped front_post_input" name="title" id="img_post_title"  value="<?php if(isset($action_edit_image)){echo $post_edit -> post_title; } ?>">
					<p class="info"  id="img_post_title_info">
						<span class="warning" style="display:none; " id="img_post_title_warning"></span>
						<?php _e('Be descriptive or interesting!','cosmotheme'); ?>
					</p>
					
				</label>
			</div>
			<div class="field">
				<h4><?php _e('Text content','cosmotheme')?></h4>
				<?php
					if(class_exists('WP_Editor')){
						global $wp_editor;
						$media_bar = false; /* set to true to show the media bar */
						$settings = array(); /* additional settings, */
                        if(isset($action_edit_image)){
                            echo $wp_editor->editor($post_edit -> post_content, 'image_content', $settings, $media_bar);
                        }else{
                            echo $wp_editor->editor('', 'image_content', $settings, $media_bar);
                        }
					}	
				?>
			</div>
			<div class="field">
				<label>
					<h4><?php _e('Category','cosmotheme')?></h4>
					<?php 
					if(isset($action_edit_image) && is_array($post_categories) && sizeof($post_categories) ){
						//$cat = get_category( $post_categories[0] );
                        $args = array(  'orderby'            => 'ID', 
								    'order'              => 'ASC',
								    'hide_empty'         => 0, 
                                    'selected'           => $post_categories[0],
								    'id'                 => 'img_post_cat',
							    );
                    }else{
                        $args = array(  'orderby'            => 'ID', 
								    'order'              => 'ASC',
								    'hide_empty'         => 0, 
								    'id'                 => 'img_post_cat',
							    );    
                    }
					
					wp_dropdown_categories( $args );		    
					?>
					
				</label>
			</div>
			<div class="field"> 
				<label>
					<h4><?php _e('Tags','cosmotheme'); ?> <span>(<?php _e('recommended','cosmotheme'); ?>)</span></h4> 
					<input id="photo_tag_input" type="text" class="text tag_input tipped front_post_input" name="tags" value="<?php if(isset($action_edit_image)){ echo post::list_tags($post_id); } ?>" placeholder="tag 1, tag 2, tag 3, tag 4, tag 5" autocomplete="off">
				</label>
				<p class="info"  id="photo_tag_input_info"><?php _e('Use comma to separate each tag. E.g. design, wtf, awesome.','cosmotheme'); ?></p>
			</div>
			<?php if(options::logic( 'blog_post' , 'show_source' )){ ?>
			<div class="field">
				<label>
					<h4><?php _e('Source','cosmotheme')?></h4> 
					<input type="text" class="text tipped front_post_input" name="source" id="img_post_source"  value="<?php if(isset($action_edit_image)){ echo $the_source; } ?>">
				</label>
				<p class="info" id="image_source_input_info"><?php _e('Example: http://cosmothemes.com','cosmotheme'); ?></p>
			</div>
			<?php } ?>
			<div class="field">
				<label class="nsfw"> 
					<input type="checkbox" class="checkbox" <?php if(isset($action_edit_image) && meta::logic( $post_edit , 'settings' , 'safe' )){ echo 'checked'; } ?> name="nsfw" value="1"> <?php _e('This is NSFW (Not Safe For Work)','cosmotheme'); ?>
					
				</label>
			</div>
			
			<input type="hidden" value="image"  name="post_format">
			<?php if(isset($post_id)) { ?>
			<input type="hidden" value="<?php echo $post_id; ?>"  name="post_id">
			<?php } ?>
			<div class="field button">
				<p class="button blue">
					<input type="button" id="submit_img_btn"  onclick="add_image_post()" value="<?php if(isset($post_id)){ _e('Update post','cosmotheme'); }else{ _e('Submit post','cosmotheme'); } ?>"/>
				</p>
			</div>		
		</form>
	</div>
	<?php } ?> 
	<?php if( (options::logic( 'upload' , 'enb_video' ) && !isset($post_id) ) || ( isset($post_id) && $post_format =='video') ){	?>
	<div class="tabs-container tabs-hide" id="video_upload">
		
		<form method="post" action="/post-item?phase=post" id="form_post_video" >
			<h3><?php if( isset($post_id) && $post_format == 'video'){ _e('Edit video','cosmotheme'); }else{ _e('Add video','cosmotheme'); } ?></h3>
			<div class="field">
                <?php
                    if(isset($post_id)){    
                        $format = meta::get_meta( $post_id , 'format' );
                        if( isset( $format['video'] ) && !empty( $format['video'] ) && post::isValidURL( $format['video'] ) && post::get_vimeo_video_id( $format['video']) != 0  && post::get_youtube_video_id( $format['video'] ) != 0 ){
                            $video_type = 'url_video'; 

                        }else{
                            $video_type = 'upload_video'; 

                        }
                    }    
                ?>
                <label id="label_url_video" <?php if(isset($video_type) && $video_type != 'url_video'){ echo 'style="display:none"'; }?> >
					<h4><?php _e('Video URL','cosmotheme'); ?></h4>
					
					<input type="text" name="video_url" value="" class="generic-record front_post_input" id="video_url"  />
										
					
				</label>
				<label id="label_upload_video" <?php if( !isset($post_id) ||  (isset($video_type) && $video_type != 'upload_video') ){ echo 'style="display:none"'; }?> >
					<h4><?php _e('Video URL','cosmotheme'); ?></h4>
					
					<?php



						$action['group'] = 'video';
						$action['topic'] = 'upload';
						$action['index'] = '';
						$action['upload_url'] =  home_url().'/wp-admin/media-upload.php?post_id=-1&amp;type=image&amp;TB_iframe=true';

					?>
					<input type="text" name="video" value="<?php if(isset($post_id) && isset($format['video'])){ echo $format['video'] ;} ?>" class="generic-record front_post_input" id="video_upload"  onclick="jQuery('#video_upload_btn').click();"  />
					<input type="button" class="button-primary hidden front_post_input" id="video_upload_btn" value="<?php _e('Choose File','cosmotheme'); ?>" <?php echo fields::action( $action , 'extern-upload-id' ) ?>  />
					
                    <input type="hidden" name="video_id" id="video_upload_id"  class="generic-record generic-single-record " />

					
				</label>  
				<input type="hidden" value="<?php if(isset($video_type)){ echo $video_type; }else{ echo 'url_video'; } ?>" id="video_type" name="video_type">
				<p class="info">
					<span class="warning" style="display:none; " id="video_warning"></span>
					<a class="upload_video <?php if(isset($video_type) && $video_type != 'url_video'){ echo 'hide'; }?>" href="javascript:void(0)"  onclick="swithch_image_type('upload_video','');" id="swithcher_upload_video" ><strong><?php _e('Upload a file.','cosmotheme'); ?></strong></a>
					<a class="post_link <?php if (!isset($post_id) || (isset($video_type) && $video_type != 'upload_video')) { echo 'hide'; }?> " href="javascript:void(0)" onclick="swithch_image_type('url_video','');" id="swithcher_url_video" ><strong><?php _e('Use a URL.','cosmotheme'); ?></strong></a> <?php _e('Currently we only support YouTube, Vimeo and self hosted videos.','cosmotheme') ?>
				</p>
				
			</div>

			<div class="field">
				<label>
					<h4><?php _e('Title','cosmotheme')?></h4>
					<input type="text" class="text tipped front_post_input" name="title" id="video_post_title"  value="<?php if(isset($action_edit_video)){echo $post_edit -> post_title; } ?>">
					<p class="info"  id="video_post_title_info">
						<span class="warning" style="display:none; " id="video_post_title_warning"></span>
						<?php _e('Be descriptive or interesting!','cosmotheme'); ?>
					</p>
					
				</label>
			</div>
			<div class="field">
				<label>
					<h4><?php _e('Category','cosmotheme')?></h4>
					<?php 
					if(isset($action_edit_video) && is_array($post_categories) && sizeof($post_categories) ){
						
                        $args = array(  'orderby'            => 'ID', 
								    'order'              => 'ASC',
								    'hide_empty'         => 0, 
                                    'selected'           => $post_categories[0],
								    'id'                 => 'video_post_cat',
							    );
                    }else{
                        $args = array(  'orderby'            => 'ID', 
								    'order'              => 'ASC',
								    'hide_empty'         => 0, 
								    'id'                 => 'video_post_cat',
							    );    
                    }			
					wp_dropdown_categories( $args );		    
					?>
					
				</label>
			</div>
			<div class="field">
				<h4><?php _e('Text content','cosmotheme')?></h4>
				<?php
					if(class_exists('WP_Editor')){
						global $wp_editor;
						$media_bar = false; // set to true to show the media bar
						$settings = array(); // additional settings,
						
						if(isset($action_edit_video)){
                            echo $wp_editor->editor($post_edit -> post_content, 'video_content', $settings, $media_bar);
                        }else{
                            echo $wp_editor->editor('', 'video_content', $settings, $media_bar);
                        }
					}	
				?>
			</div>
			<div class="field">
				<label>
					<h4><?php _e('Tags','cosmotheme'); ?> <span>(<?php _e('recommended','cosmotheme'); ?>)</span></h4>
					<input id="video_tag_input" type="text" class="text tag_input tipped front_post_input" name="tags" value="<?php if(isset($action_edit_video)){ echo post::list_tags($post_id); } ?>" placeholder="tag 1, tag 2, tag 3, tag 4, tag 5" autocomplete="off">
				</label>
				<p class="info" id="video_tag_input_info"><?php _e('Use comma to separate each tag. E.g. design, wtf, awesome.','cosmotheme'); ?></p>
			</div>
			<?php if(options::logic( 'blog_post' , 'show_source' )){ ?>
			<div class="field">
				<label>
					<h4><?php _e('Source','cosmotheme')?></h4>
					<input type="text" class="text tipped front_post_input" name="source" id="video_post_source"  value="<?php if(isset($action_edit_video)){ echo $the_source; } ?>">
				</label>
				<p class="info" id="video_source_input_info"><?php _e('Example: http://cosmothemes.com','cosmotheme'); ?></p>
			</div>
			<?php } ?>
			<div class="field">
				<label class="nsfw">
					<input type="checkbox" class="checkbox" <?php if(isset($action_edit_video) && meta::logic( $post_edit , 'settings' , 'safe' )){ echo 'checked'; } ?> name="nsfw" value="1"> <?php _e('This is NSFW (Not Safe For Work)','cosmotheme'); ?>
				</label>
			</div>
			<input type="hidden" value="video"  name="post_format">
			<?php if(isset($post_id)) { ?>
                <input type="hidden" value="<?php echo $post_id; ?>"  name="post_id">
			<?php } ?>
			<div class="field button">
				<p class="button blue">
					<input type="button" id="submit_video_btn"  onclick="add_video_post()" value="<?php if(isset($post_id)){ _e('Update post','cosmotheme'); }else{ _e('Submit post','cosmotheme'); } ?>" />
				</p>
			</div>
		</form>
	</div>
	<?php } ?> 
	<?php if( (options::logic( 'upload' , 'enb_text' ) && !isset($post_id) ) || ( isset($post_id) && $post_format == 'default') ){	?>
	<div class="tabs-container" id="text_post">
		<form method="post" action="/post-item?phase=post" id="form_post_text" >  
			<h3><?php if( isset($post_id) && $post_format == 'default'){ _e('Edit text','cosmotheme'); }else{ _e('Add text','cosmotheme'); } ?></h3>
			
			<div class="field">
				<label>
					<h4><?php _e('Title','cosmotheme')?></h4>
					<input type="text" class="text tipped front_post_input" name="title" id="text_post_title"  value="<?php if(isset($action_edit_text)){echo $post_edit -> post_title; } ?>">
					<p class="info"  id="text_post_title_info">
						<span class="warning" style="display:none; " id="text_post_title_warning"></span>
						<?php _e('Be descriptive or interesting!','cosmotheme'); ?>
					</p>
					
				</label>
			</div>
			<div class="field">
				<h4><?php _e('Text content','cosmotheme')?></h4>
				<?php
					if(class_exists('WP_Editor')){
						global $wp_editor;
						$media_bar = false; // set to true to show the media bar
						$settings = array(); // additional settings,
						
						if(isset($action_edit_text)){
                            echo $wp_editor->editor($post_edit -> post_content, 'text_content', $settings, $media_bar);
                        }else{
                            echo $wp_editor->editor('', 'text_content', $settings, $media_bar);
                        }
					}	
				?>
			</div>
			<div class="field">
				<label>
					<h4><?php _e('Category','cosmotheme')?></h4>
					<?php 
					
					if(isset($action_edit_text) && is_array($post_categories) && sizeof($post_categories) ){
						
                        $args = array(  'orderby'            => 'ID', 
								    'order'              => 'ASC',
								    'hide_empty'         => 0, 
                                    'selected'           => $post_categories[0],
								    'id'                 => 'text_post_cat',
							    );
                    }else{
                        $args = array(  'orderby'            => 'ID', 
								    'order'              => 'ASC',
								    'hide_empty'         => 0, 
								    'id'                 => 'text_post_cat',
							    );    
                    }			
					wp_dropdown_categories( $args );		    
					?>
					
				</label>
			</div>
			<div class="field">
				<label>
					<h4><?php _e('Tags','cosmotheme'); ?> <span>(<?php _e('recommended','cosmotheme'); ?>)</span></h4>
					<input id="text_tag_input" type="text" class="text tag_input tipped front_post_input" name="tags" value="<?php if(isset($action_edit_text)){ echo post::list_tags($post_id); } ?>" placeholder="tag 1, tag 2, tag 3, tag 4, tag 5" autocomplete="off">
				</label>
				<p class="info"  id="text_tag_input_info"><?php _e('Use comma to separate each tag. E.g. design, wtf, awesome.','cosmotheme'); ?></p>
			</div>
			<?php if(options::logic( 'blog_post' , 'show_source' )){ ?>
			<div class="field">
				<label>
					<h4><?php _e('Source','cosmotheme')?></h4>
					<input type="text" class="text tipped front_post_input" name="source" id="text_post_source"  value="<?php if(isset($action_edit_text)){ echo $the_source; } ?>">
				</label>
				<p class="info" id="text_source_input_info"><?php _e('Example: http://cosmothemes.com','cosmotheme'); ?></p>
			</div>
			<?php } ?>
			<div class="field">
				<label class="nsfw">
					<input type="checkbox" class="checkbox" <?php if(isset($action_edit_text) && meta::logic( $post_edit , 'settings' , 'safe' )){ echo 'checked'; } ?> name="nsfw" value="1"> <?php _e('This is NSFW (Not Safe For Work)','cosmotheme'); ?>
					
				</label>
			</div>
			<input type="hidden" value=""  name="post_format">
            <?php if(isset($post_id)) { ?>
                <input type="hidden" value="<?php echo $post_id; ?>"  name="post_id">
			<?php } ?>
			<div class="field button">
				<p class="button blue">
					<input type="button" id="submit_text_btn"  onclick="add_text_post()" value="<?php if(isset($post_id)){ _e('Update post','cosmotheme'); }else{ _e('Submit post','cosmotheme'); } ?>"/>
				</p>
			</div>		
		</form>
	</div>
	<?php } ?> 
	<?php if( (options::logic( 'upload' , 'enb_audio' ) && !isset($post_id) ) || ( isset($post_id) && $post_format == 'audio') ){	?>

	<div class="tabs-container" id="audio_post">
		<form method="post" action="/post-item?phase=post" id="form_post_audio" >  
			<h3><?php if( isset($post_id) && $post_format == 'audio'){ _e('Edit audio file','cosmotheme'); }else{ _e('Add mp3 audio file','cosmotheme'); } ?></h3>
			
			<div class="field" >
				
				<label id="label_upload_audio"  >
					<h4><?php _e('Upload file','cosmotheme'); ?></h4>
					
					<?php

						$action['group'] = 'audio';
						$action['topic'] = 'upload';
						$action['index'] = '';
						$action['upload_url'] =  home_url().'/wp-admin/media-upload.php?post_id=-1&amp;type=image&amp;TB_iframe=true';
                        
                        if(isset($post_id)){
                            $attached_file_meta = meta::get_meta( $post_id , 'format' ); 
                            if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['audio']) && $attached_file_meta['audio'] != '' ){
                                $attached_file = $attached_file_meta['audio']; 
                            }
                        }            
					?>
					<p class="button"><input type="button" class="button-primary  " id="upload_audio_btn" value="<?php _e('Choose File','cosmotheme'); ?>" <?php echo fields::action( $action , 'extern-upload-id' ) ?>  /></p>
					<input type="text" name="audio" value="<?php if(isset($attached_file)){echo $attached_file; }else{ _e('No file chosen','cosmotheme'); } ?>" class="generic-record front_post_input" id="audio_upload"    />
					
					
                    <input type="hidden" name="audio_id" id="audio_upload_id"  class="generic-record generic-single-record " />

					
				</label>
				
				<p class="info">
					<span class="warning" style="display:none; " id="audio_warning"></span>
					<?php _e('MP3 only','cosmotheme'); ?>
				</p>
				
			</div>
				
			<div class="field">
				<label>
					<h4><?php _e('Title','cosmotheme')?></h4>
					<input type="text" class="text tipped front_post_input" name="title" id="audio_post_title"  value="<?php if(isset($action_edit_audio)){echo $post_edit -> post_title; } ?>">
					<p class="info"  id="audio_img_post_title_info">
						<span class="warning" style="display:none; " id="audio_img_post_title_warning"></span>
						<?php _e('Be descriptive or interesting!','cosmotheme'); ?>
					</p>
					
				</label>
			</div>
			
			<div class="field">
				<label id="audio_label_url_img"  <?php if(isset($thumb_id)  ) {?>style="display:none" <?php } ?> >
					<h4><?php _e('Image URL','cosmotheme'); ?></h4>
					
					<input type="text" name="image_url" value="" class="generic-record front_post_input" id="audio_image_url"  />
										
				</label>
				<label id="audio_label_upload_img" <?php if(!isset($thumb_id) ){ ?>style="display:none" <?php } ?> >
					<h4><?php _e('Image URL','cosmotheme'); ?></h4>
					
					<?php



						$action['group'] = 'audio_img';
						$action['topic'] = 'upload';
						$action['index'] = '';
						$action['upload_url'] =  home_url().'/wp-admin/media-upload.php?post_id=-1&amp;type=image&amp;TB_iframe=true';

					?>
					<input type="text" name="image" value="<?php if(isset($thumb_id)){$thumb_url = wp_get_attachment_image_src( $thumb_id,'full'); echo $thumb_url[0]; } ?>" class="generic-record front_post_input" id="audio_img_upload"  onclick="jQuery('#audio_upload_btn').click();"  />
					<input type="button" class="button-primary hidden front_post_input" id="audio_upload_btn" value="<?php _e('Choose File','cosmotheme'); ?>" <?php echo fields::action( $action , 'extern-upload-id' ) ?>  />
					
                    <input type="hidden" value="<?php if(isset($thumb_id)){echo $thumb_id;} ?>" name="image_id" id="audio_img_upload_id"  class="generic-record generic-single-record " />

					
				</label>
				<input type="hidden" value="<?php if(isset($thumb_id)){echo 'upload_img';}else{ echo 'url_img'; } ?>" id="audio_image_type" name="image_type">
				<p class="info">
					<span class="warning" style="display:none; " id="audio_img_warning"></span>
					<a class="upload_photo <?php if(isset($thumb_id)){echo 'hide';} ?>" href="javascript:void(0)"  onclick="swithch_image_type('upload_img','audio_');" id="audio_swithcher_upload_img" ><strong><?php _e('Upload a file.','cosmotheme'); ?></strong></a>
					<a class="post_link <?php if(!isset($thumb_id)){echo 'hide';} ?>" href="javascript:void(0)" onclick="swithch_image_type('url_img','audio_');" id="audio_swithcher_url_img" ><strong><?php _e('Use a URL.','cosmotheme'); ?></strong></a> <?php _e('JPEG, GIF or PNG.','cosmotheme'); ?>
				</p>
				
			</div>
			
			<div class="field">
				<h4><?php _e('Text content','cosmotheme')?></h4>
				<?php
					if(class_exists('WP_Editor')){
						global $wp_editor;
						$media_bar = false; // set to true to show the media bar
						$settings = array(); // additional settings,
						
						if(isset($action_edit_audio)){
                            echo $wp_editor->editor($post_edit -> post_content, 'audio_content', $settings, $media_bar);
                        }else{
                            echo $wp_editor->editor('', 'audio_content', $settings, $media_bar);
                        }
					}	
				?>
			</div>
			<div class="field">
				<label>
					<h4><?php _e('Category','cosmotheme')?></h4>
					<?php 
					
					if(isset($action_edit_audio) && is_array($post_categories) && sizeof($post_categories) ){
						
                        $args = array(  'orderby'            => 'ID', 
								    'order'              => 'ASC',
								    'hide_empty'         => 0, 
                                    'selected'           => $post_categories[0],
								    'id'                 => 'audio_post_cat',
							    );
                    }else{
                        $args = array(  'orderby'            => 'ID', 
								    'order'              => 'ASC',
								    'hide_empty'         => 0, 
								    'id'                 => 'audio_post_cat',
							    );   
                    }				
					wp_dropdown_categories( $args );		    
					?>
					
				</label>
			</div>
			<div class="field">
				<label>
					<h4><?php _e('Tags','cosmotheme'); ?> <span>(<?php _e('recommended','cosmotheme'); ?>)</span></h4>
					<input id="audio_photo_tag_input" type="text" class="text tag_input tipped front_post_input" name="tags" value="<?php if(isset($action_edit_audio)){ echo post::list_tags($post_id); } ?>" placeholder="tag 1, tag 2, tag 3, tag 4, tag 5" autocomplete="off">
				</label>
				<p class="info"  id="audio_photo_tag_input_info"><?php _e('Use comma to separate each tag. E.g. design, wtf, awesome.','cosmotheme'); ?></p>
			</div>
			<?php if(options::logic( 'blog_post' , 'show_source' )){ ?>
			<div class="field">
				<label>
					<h4><?php _e('Source','cosmotheme')?></h4>
					<input type="text" class="text tipped front_post_input" name="source" id="audio_img_post_source" value="<?php if(isset($action_edit_audio)){ echo $the_source; } ?>">
				</label>
				<p class="info" id="audio_image_source_input_info"><?php _e('Example: http://cosmothemes.com','cosmotheme'); ?></p>
			</div>
			<?php } ?>
			<div class="field">
				<label class="nsfw">
					<input type="checkbox" class="checkbox" <?php if(isset($action_edit_audio) && meta::logic( $post_edit , 'settings' , 'safe' )){ echo 'checked'; } ?> name="nsfw" value="1"> <?php _e('This is NSFW (Not Safe For Work)','cosmotheme'); ?>
					
				</label>
			</div>
			
			<input type="hidden" value="audio"  name="post_format">
            <?php if(isset($post_id)) { ?>
                <input type="hidden" value="<?php echo $post_id; ?>"  name="post_id">
			<?php } ?>
			<div class="field button">
				<p class="button blue">
					<input type="button" id="submit_audio_btn"  onclick="add_audio_post()" value="<?php if(isset($post_id)){ _e('Update post','cosmotheme'); }else{ _e('Submit post','cosmotheme'); } ?>"/>
				</p>
			</div>		
		</form>
	</div>
	<?php } ?> 
	<?php if( (options::logic( 'upload' , 'enb_file' ) && !isset($post_id) ) || ( isset($post_id) && $post_format == 'link') ){	?>
	<div class="tabs-container" id="file_post">
		<form method="post" action="/post-item?phase=post" id="form_post_file" >  
			<h3><?php if( isset($post_id) && $post_format == 'link'){ _e('Edit file','cosmotheme'); }else{ _e('Add file','cosmotheme'); } ?></h3>
			
			<div class="field">
				
				<label id="label_upload_file" >
					<h4><?php _e('Upload file','cosmotheme'); ?></h4>
					
					<?php



						$action['group'] = 'file';
						$action['topic'] = 'upload';
						$action['index'] = '';
						$action['upload_url'] =  home_url().'/wp-admin/media-upload.php?post_id=-1&amp;type=image&amp;TB_iframe=true';
                        
                        if(isset($post_id)){
                            $attached_file_meta = meta::get_meta( $post_id , 'format' );
                            if(is_array($attached_file_meta) && sizeof($attached_file_meta) && isset($attached_file_meta['link_id']) && is_numeric($attached_file_meta['link_id'])){
                                $attachment_id = $attached_file_meta['link_id'];
                                $attachment_url = $attached_file_meta['link'];
                            }
                        }    

					?>
					<p class="button"><input type="button" class="button-primary  " id="upload_file_btn" value="<?php  _e('Choose File','cosmotheme');  ?>" <?php echo fields::action( $action , 'extern-upload-id' ) ?>  /></p>
					<input type="text" name="file" value="<?php if(isset($attachment_url)){ echo $attachment_url; }else{ _e('No file chosen','cosmotheme'); } ?>" class="generic-record front_post_input" id="file_upload"    />
					
					
                    <input type="hidden" name="file_id" id="file_upload_id" value="<?php if(isset($attachment_id)){ echo $attachment_id; } ?>" class="generic-record generic-single-record " />

					
				</label>
				
				<p class="info">
					<span class="warning" style="display:none; " id="file_warning"></span>
					<?php _e('PDF, DOC, ZIP and RAR files only','cosmotheme'); ?>
				</p>
				
			</div>
				
			<div class="field">
				<label>
					<h4><?php _e('Title','cosmotheme')?></h4>
					<input type="text" class="text tipped front_post_input" name="title" id="file_post_title" value="<?php if(isset($action_edit_link)){echo $post_edit -> post_title; } ?>">
					<p class="info"  id="file_img_post_title_info">
						<span class="warning" style="display:none; " id="file_img_post_title_warning"></span>
						<?php _e('Be descriptive or interesting!','cosmotheme'); ?>
					</p>
					
				</label>
			</div>
			
			<div class="field">
				<label id="file_label_url_img" <?php if(isset($thumb_id)  ) {?>style="display:none" <?php } ?> >
					<h4><?php _e('Image URL','cosmotheme'); ?></h4>
					
					<input type="text" name="image_url" value="" class="generic-record front_post_input" id="file_image_url"  />
										
				</label>
				<label id="file_label_upload_img" <?php if(!isset($thumb_id) ){ ?>style="display:none" <?php } ?> >
					<h4><?php _e('Image URL','cosmotheme'); ?></h4>
					
					<?php

						$action['group'] = 'file_img';
						$action['topic'] = 'upload';
						$action['index'] = '';
						$action['upload_url'] =  home_url().'/wp-admin/media-upload.php?post_id=-1&amp;type=image&amp;TB_iframe=true';

					?>
					<input type="text" name="image" value="<?php if(isset($thumb_id)){$thumb_url = wp_get_attachment_image_src( $thumb_id,'full'); echo $thumb_url[0]; } ?>" class="generic-record front_post_input" id="file_img_upload"  onclick="jQuery('#file_upload_btn').click();"  />
					<input type="button" class="button-primary hidden front_post_input" id="file_upload_btn" value="<?php _e('Choose File','cosmotheme'); ?>" <?php echo fields::action( $action , 'extern-upload-id' ) ?>  />
					
                    <input type="hidden" value="<?php if(isset($thumb_id)){echo $thumb_id;} ?>" name="image_id" id="file_img_upload_id"  class="generic-record generic-single-record " />

					
				</label>
				<input type="hidden" value="<?php if(isset($thumb_id)){echo 'upload_img';}else{ echo 'url_img'; } ?>" id="file_image_type" name="image_type">
				<p class="info">
					<span class="warning" style="display:none; " id="file_img_warning"></span>
					<a class="upload_photo <?php if(isset($thumb_id)){echo 'hide';} ?>" href="javascript:void(0)"  onclick="swithch_image_type('upload_img','file_');" id="file_swithcher_upload_img" ><strong><?php _e('Upload a file.','cosmotheme'); ?></strong></a>
					<a class="post_link <?php if(!isset($thumb_id)){echo 'hide';} ?>" href="javascript:void(0)" onclick="swithch_image_type('url_img','file_');" id="file_swithcher_url_img" ><strong><?php _e('Use a URL.','cosmotheme'); ?></strong></a> <?php _e('JPEG, GIF or PNG.','cosmotheme'); ?>
				</p>
				
			</div>
			
			<div class="field">
				<h4><?php _e('Text content','cosmotheme')?></h4>
				<?php
					if(class_exists('WP_Editor')){
						global $wp_editor;
						$media_bar = false; // set to true to show the media bar
						$settings = array(); // additional settings,
						
						if(isset($action_edit_link)){
                            echo $wp_editor->editor($post_edit -> post_content, 'file_content', $settings, $media_bar);
                        }else{
                            echo $wp_editor->editor('', 'file_content', $settings, $media_bar);
                        }
					}	
				?>
			</div>
			<div class="field">
				<label>
					<h4><?php _e('Category','cosmotheme')?></h4>
					<?php 
					
					
								
					if(isset($action_edit_link) && is_array($post_categories) && sizeof($post_categories) ){
						
                        $args = array(  'orderby'            => 'ID', 
								    'order'              => 'ASC',
								    'hide_empty'         => 0, 
                                    'selected'           => $post_categories[0],
								    'id'                 => 'file_post_cat',
							    );
                    }else{
                        $args = array(  'orderby'            => 'ID', 
								    'order'              => 'ASC',
								    'hide_empty'         => 0, 
								    'id'                 => 'file_post_cat',
							    );  
                    }				
					wp_dropdown_categories( $args );		    
					?>
					
				</label>
			</div>
			<div class="field">
				<label>
					<h4><?php _e('Tags','cosmotheme'); ?> <span>(<?php _e('recommended','cosmotheme'); ?>)</span></h4>
					<input id="file_photo_tag_input" type="text" class="text tag_input tipped front_post_input" name="tags" value="<?php if(isset($action_edit_link)){ echo post::list_tags($post_id); } ?>" placeholder="tag 1, tag 2, tag 3, tag 4, tag 5" autocomplete="off">
				</label>
				<p class="info"  id="file_photo_tag_input_info"><?php _e('Use comma to separate each tag. E.g. design, wtf, awesome.','cosmotheme'); ?></p>
			</div>
			<?php if(options::logic( 'blog_post' , 'show_source' )){ ?>
			<div class="field">
				<label>
					<h4><?php _e('Source','cosmotheme')?></h4>
					<input type="text" class="text tipped front_post_input" name="source" id="file_img_post_source"  value="<?php if(isset($action_edit_link)){ echo $the_source; } ?>">
				</label>
				<p class="info" id="file_image_source_input_info"><?php _e('Example: http://cosmothemes.com','cosmotheme'); ?></p>
			</div>
			<?php } ?>
			<div class="field">
				<label class="nsfw">
					<input type="checkbox" class="checkbox" <?php if(isset($action_edit_link) && meta::logic( $post_edit , 'settings' , 'safe' )){ echo 'checked'; } ?> name="nsfw" value="1"> <?php _e('This is NSFW (Not Safe For Work)','cosmotheme'); ?>
					
				</label>
			</div>
			<?php if(isset($post_id)) { ?>
                <input type="hidden" value="<?php echo $post_id; ?>"  name="post_id">
			<?php } ?>
			<input type="hidden" value="link"  name="post_format">
			<div class="field button">
				<p class="button blue">
					<input type="button" id="submit_file_btn"  onclick="add_file_post()" value="<?php if(isset($post_id)){ _e('Update post','cosmotheme'); }else{ _e('Submit post','cosmotheme'); } ?>"/>
				</p>
			</div>		
		</form>
	</div>
	<?php } ?> 
	
</div>
<div id="not_logged_msg" style="display:none"><?php _e('You must be logged in to submit an post','cosmotheme'); ?></div>
<div id="success_msg" style="display:none"></div>
<div id="loading_" style="display:none"><img src="<?php echo get_template_directory_uri() ?>/images/loading.gif" alt="working..."/></div>
<?php 
}else{
	_e('You must be <a href="#" class="simplemodal-login simplemodal-none link">logged in</a> to submit a post.','cosmotheme');
}
?>