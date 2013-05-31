var act = new Object();

jQuery(function(){
    jQuery('input.generic-record-search').each(function(){
        var self = this;
        jQuery( self ).autocomplete({ 
            serviceUrl: ajaxurl + '?action=search&params=' + jQuery( self ).parent().children('input.generic-params').val(), 
            minChars:2,
            delimiter: /(,|;)\s*/, 
            maxHeight:400, 
            width:300, 
            zIndex: 9999, 
            deferRequestBy: 0, 
            noCache: false, 
            onSelect: function( value , data){
                jQuery(function(){
                    jQuery( self ).parent().children('input.generic-value').val( data );
                });
            }
        });
    });
});
act.search = function( self , selector ){
    jQuery(function(){
        if( jQuery( self ).val().length > 0 ){
            if( selector != '-' ){
                jQuery( selector ).show();
            }
        }else{
            if( selector != '-' ){
                jQuery( selector ).hide();
            }
            jQuery( self ).parent().children('input.generic-value').val('');
        }
    });
} 

act.my_likes = function( post_id , data , type ){
    
    jQuery(function(){
        if(  !(jQuery( 'div#content div.front-page img#loading' ).length) ){
            jQuery( 'div#content div.front-page' ).append( '<img id="loading" src="'+ themeurl +'/images/loading.gif" style="background:none; float:none; text-align:center; width:auto; height:auto; margin:0px auto !important; clear:both; display:block;" />' );
        }
                
        jQuery.post( ajaxurl , {'action' : 'my_likes' , 'post_id' : post_id , 'data' : data , 'type' : type } , function( result ){
            if( result.substr( 0 , 1 ) == '{' ){
                var opt = eval("(" + result + ')');
                act.my_likes( opt.post_id , opt.data , type );
            }else{
                jQuery( 'div#content div.front-page img#loading' ).remove();
                jQuery( 'div.clearfix.get-more' ).remove();
                jQuery( 'div.loop-container-view div.last').removeClass('last');
                if( type == 1 ){
                    jQuery( 'div#content div.front-page' ).append( result );
                    if( jQuery('div.clearfix.get-more p a').length > 0  ){
                        jQuery( 'span.list-grid a' ).attr( 'index' , jQuery('div.clearfix.get-more p a').attr( 'index') );
                    }
                }else{
                    jQuery( 'div#content div.front-page div.loop-container-view' ).append( result );
                }
                
                return 0; 
            } 
       }); 
    });
}

act.min_likes = function( nr , page ){
    jQuery(function(){
        if( page == 1 ){
            jQuery( 'span.digit-btn.result' ).html( 'update ..' );
        }
        jQuery.post( ajaxurl , {'action' : 'min_likes' , 'page' : page , 'new_limit' : nr} , function( result ){
           if( result > 0 ){
               var n = (( parseInt( result ) - 1 ) * 150 );
               jQuery( 'span.digit-btn.result' ).html( n + ' posts updated .. ' );
               act.min_likes( nr , result );
           }else{
               jQuery( 'span.digit-btn.result' ).html( '' );
               return 0; 
           } 
       } ); 
    });
}
act.sim_likes = function( page ){
    jQuery(function(){
        if( page == 1 ){
            jQuery( 'span.btn.result' ).html( 'update ..' );
        }
        jQuery.post( ajaxurl , {'action' : 'sim_likes' , 'page' : page} , function( result ){ 
           if( result > 0 ){ 
               var n = (( parseInt( result ) - 1 ) * 150 );
               jQuery( 'span.btn.result' ).html( n + ' posts updated .. ' );
               act.sim_likes( result ); 
           }else{
               jQuery( 'span.btn.result' ).html( '' );
               return 0; 
           } 
       }); 
    });
}
act.select = function( selector , args , type ){
    jQuery(document).ready(function( ){
        jQuery( 'option' , jQuery( 'select' + selector ) ).each(function(i){
            if( type == 'hs' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {

                            if( jQuery( this ).val().trim()  == key ){
                                jQuery( args[ key ] ).hide();
                            }else{
                                jQuery( args[ key ] ).show();
                            }
                        }
                    }
                }
            }

            if( type == 'sh' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {
                            if( jQuery( this ).val().trim()  == key ){
                                jQuery( args[ key ] ).show();
                            }else{
                                jQuery( args[ key ] ).hide();
                            }
                        }
                    }
                }
            }
			
			if( type == 'sh_' ){
				var show = '';
                var show_ = '';
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {

                            if( jQuery( this ).val().trim()  == key ){
                                show = args[ key ];
                            }else{
                                if( key == 'else' ){
                                    show_ = args[ key ];
                                }
                                jQuery( args[ key ] ).hide();
                            }
                        }
                    }

                    if( show == '' ){
                        jQuery( show_ ).show();
                    }else{
                        jQuery( show ).show();
                    }
                }
            }
			
			if( type == 'hs_' ){
				var hide = '';
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {

                            if( jQuery( this ).val().trim()  == key ){
                                hide = args[ key ];
                            }else{
                                jQuery( args[ key ] ).show();
                            }
                        }
                    }
					
					jQuery( hide ).hide();
                }
            }

            if( type == 's' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {
                            if( jQuery( this ).val().trim()  == key ){
                                jQuery( args[ key ] ).show();
                            }
                        }
                    }
                }
            }

            if( type == 'h' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {
                            if( jQuery( this ).val().trim()  == key ){
                                jQuery( args[ key ] ).hide();
                            }
                        }
                    }
                }
            }

            if( type == 'ns' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {
                            if( jQuery( this ).val().trim()  == key ){
                            }else{
                                jQuery( args[ key ] ).show();
                            }
                        }
                    }
                }
            }

            if( type == 'nh' ){
                if( jQuery(this).is(':selected') ){
                    for (var key in args) {
                        if ( args.hasOwnProperty( key ) ) {
                            if( jQuery( this ).val().trim()  == key ){
                            }else{
                                jQuery( args[ key ] ).hide();
                            }
                        }
                    }
                }
            }
        });
    });
}
act.mcheck = function( selectors ){
    var result = true;
    jQuery(document).ready(function( ){
        for( var i = 0 ; i < selectors.length; i++ ){
            if( jQuery( selectors[ i ] ).is(':checked') ){
                if( jQuery( selectors[ i ] ).val().trim() == 'yes' ){
                    result = result && true;
                }else{
                    result = result && false;
                }
            }else{
                result = result && false;
            }
        }
    });

    if( result ){
        jQuery( '.g_l_register' ).show();
    }else{
        jQuery( '.g_l_register' ).hide();
    }
}
act.check = function( selector , args , type ){
    jQuery(document).ready(function( ){
        if( type == 'hs' ){
            if( jQuery( selector ).is(':checked') ){
                
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                            jQuery( args[ key ] ).hide();
                        }else{
                            jQuery( args[ key ] ).show();
                        }
                    }
                }
            }
        }

        if( type == 'sh' ){
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                            jQuery( args[ key ] ).show();
                        }else{
                            jQuery( args[ key ] ).hide();
                        }
                    }
                }
            }
        }

        
        if( type == 'sh_' ){
            var show = '';
            var show_ = '';
            if( jQuery( selector ).is(':checked') ){
                
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {

                        if( jQuery( this ).val().trim()  == key ){
                            show = args[ key ];
                        }else{
                            if( key == 'else' ){
                                show_ = args[ key ];
                            }
                            jQuery( args[ key ] ).hide();
                        }
                    }
                }
                if( show == '' ){
                    jQuery( show_ ).show();
                }else{
                    jQuery( show ).show();
                }
            }
        }

        if( type == 'hs_' ){
            var hide = '';
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {

                        if( jQuery( this ).val().trim()  == key ){
                            hide = args[ key ];
                        }else{
                            jQuery( args[ key ] ).show();
                        }
                    }
                }

                jQuery( hide ).hide();
            }
        }

        if( type == 's' ){
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                            jQuery( args[ key ] ).show();
                        }
                    }
                }
            }
        }

        if( type == 'h' ){
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                            jQuery( args[ key ] ).hide();
                        }
                    }
                }
            }
        }

        if( type == 'ns' ){
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                        }else{
                            jQuery( args[ key ] ).show();
                        }
                    }
                }
            }
        }

        if( type == 'nh' ){
            if( jQuery( selector ).is(':checked') ){
                for (var key in args) {
                    if ( args.hasOwnProperty( key ) ) {
                        if( jQuery( selector ).val().trim()  == key ){
                        }else{
                            jQuery( args[ key ] ).hide();
                        }
                    }
                }
            }
        }
    });
}

act.show = function( selector ){
    jQuery(document).ready(function( ){
        jQuery( selector ).show();
    });
}

act.hide = function( selector ){
    jQuery(document).ready(function( ){
        jQuery( selector ).hide();
    });
}

act.link = function( selector , args , type ){
    jQuery(document).ready(function( ){
		var id = jQuery( selector ).attr('id');
        if( type == 'hs' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.trim()  == key ){
						jQuery( args[ key ] ).hide();
					}else{
						jQuery( args[ key ] ).show();
					}
				}
			}            
        }

        if( type == 'sh' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.trim()  == key ){
						jQuery( args[ key ] ).show();
					}else{
						jQuery( args[ key ] ).hide();
					}
				}
			}            
        }

        if( type == 's' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.trim()  == key ){
						jQuery( args[ key ] ).show();
					}
				}
			}
        }

        if( type == 'h' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.trim()  == key ){
						jQuery( args[ key ] ).hide();
					}
				}
			}
        }

        if( type == 'ns' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.val().trim()  == key ){
					}else{
						jQuery( args[ key ] ).show();
					}
				}
			}
        }

        if( type == 'nh' ){
			for (var key in args) {
				if ( args.hasOwnProperty( key ) ) {
					if( id.val().trim()  == key ){
					}else{
						jQuery( args[ key ] ).hide();
					}
				}
			}
        }
    });
}

act.extern_upload_id = function( group , name , id, upload_url ){
	if( upload_url == ""){
        tb_show_url = 'media-upload.php?post_id=-1&amp;type=image&amp;TB_iframe=true';
	}else{
        tb_show_url = upload_url;
	}

    /*deleteUserSetting('uploader');
    setUserSetting('uploader', '1');*/

    jQuery(document).ready(function() {
        (function(){
            var tb_show_temp = window.tb_show;
            window.tb_show = function(){
                tb_show_temp.apply(null, arguments);
                jQuery('#TB_iframeContent').load(function(){

                    if( jQuery( this ).contents().find('p.upload-html-bypass').length ){
                        jQuery( this ).contents().find('p.upload-html-bypass').remove();
                    }

                    jQuery( this ).contents().find('div#html-upload-ui').show();
                    jQuery( this ).contents().find('ul#sidemenu li#tab-type_url , ul#sidemenu li#tab-library').hide();
                    jQuery( this ).contents().find('thead tr td p input.button').hide();
                    jQuery( this ).contents().find('tr.image_alt').hide();
                    jQuery( this ).contents().find('tr.post_content').hide();
                    jQuery( this ).contents().find('tr.url').hide();
                    jQuery( this ).contents().find('tr.align').hide();
                    jQuery( this ).contents().find('tr.image-size').hide();
                    jQuery( this ).contents().find('p.savebutton.ml-submit').hide();


                    $container = jQuery( this ).contents().find('tr.submit td.savesend');
                    var sid = '';
                    $container.find('div.del-attachment').each(function(){
                        var $div = jQuery(this);
                        sid = $div.attr('id').toString();
                        if( typeof sid != "undefined" ){
                            sid = sid.replace(/del_attachment_/gi , "" );
                            jQuery(this).parent('td.savesend').html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                        }else{
                            var $submit = $container.find('input[type="submit"]');
                            sid = $submit.attr('name');
                            if( typeof sid != "undefined" ){
                                sid = sid.replace(/send\[/gi , "" );
                                sid = sid.replace(/\]/gi , "" );
                                $container.html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                            }
                        }
                    });

                    $container.find('input[type="submit"]').click(function(){
                        $my_submit = jQuery( this );
                        sid = $my_submit.attr('name');
                        if( typeof sid != "undefined" ){
                                sid = sid.replace(/send\[/gi , "" );
                                sid = sid.replace(/\]/gi , "" );
                        }else{
                            sid = 0;
                        }
                        var html = $my_submit.parent('td').parent('tr').parent('tbody').parent('table').html();
                        window.send_to_editor = function() {
                            var attach_url = jQuery('input[name="attachments['+sid+'][url]"]',html).val();
                            jQuery( 'input#' + group + '_' + name + id ).val(  attach_url  );
                            jQuery( 'input#' + group + '_' + name + '_id' + id ).val( sid );

                            if( id.length > 0 ){
                                jQuery( 'img#attach_' + group + '_' + name  + id).attr( "src" ,  attach_url  );
                            }

                            tb_remove();
                        }
                    });
                });

            }})()

        formfield = jQuery( 'input#' + group + '_' + name + id ).attr('name');
        tb_show('', tb_show_url);
        return false;
    });
}

act.upload_id = function( group , name , id, upload_url ){
	if( upload_url == ""){
        tb_show_url = 'media-upload.php?post_id=-1&amp;type=image&amp;TB_iframe=true&amp;flash=0';
	}else{
        tb_show_url = upload_url;
	}

    deleteUserSetting('uploader');
    setUserSetting('uploader', '1');
	
    jQuery(document).ready(function() {
        (function(){
            var tb_show_temp = window.tb_show;
            window.tb_show = function(){
                tb_show_temp.apply(null, arguments);
                jQuery('#TB_iframeContent').load(function(){
                    
                    if( jQuery( this ).contents().find('p.upload-html-bypass').length ){
                        jQuery( this ).contents().find('p.upload-html-bypass').remove();
                    }
                    
                    jQuery( this ).contents().find('div#html-upload-ui').show();

                    $container = jQuery( this ).contents().find('tr.submit td.savesend');
                    var sid = '';
                    $container.find('div.del-attachment').each(function(){
                        var $div = jQuery(this);
                        sid = $div.attr('id').toString();
                        if( typeof sid != "undefined" ){
                            sid = sid.replace(/del_attachment_/gi , "" );
                            jQuery(this).parent('td.savesend').html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                        }else{
                            var $submit = $container.find('input[type="submit"]');
                            sid = $submit.attr('name');
                            if( typeof sid != "undefined" ){
                                sid = sid.replace(/send\[/gi , "" );
                                sid = sid.replace(/\]/gi , "" );
                                $container.html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                            }
                        }
                    });

                    $container.find('input[type="submit"]').click(function(){
                        $my_submit = jQuery( this );
                        sid = $my_submit.attr('name');
                        if( typeof sid != "undefined" ){
                                sid = sid.replace(/send\[/gi , "" );
                                sid = sid.replace(/\]/gi , "" );
                        }else{
                            sid = 0;
                        }
                        var html = $my_submit.parent('td').parent('tr').parent('tbody').parent('table').html();
                        window.send_to_editor = function() {
                            var attach_url = jQuery('input[name="attachments['+sid+'][url]"]',html).val();
                            jQuery( 'input#' + group + '_' + name + id ).val(  attach_url  );
                            jQuery( 'input#' + group + '_' + name + '_id' + id ).val( sid );

                            if( id.length > 0 ){
                                jQuery( 'img#attach_' + group + '_' + name  + id).attr( "src" ,  attach_url  );
                            }

                            tb_remove();
                        }
                    });
                });

            }})()

        formfield = jQuery( 'input#' + group + '_' + name + id ).attr('name');
        tb_show('', tb_show_url);
        return false;
    });
}

act.upload = function( selector ){

    deleteUserSetting('uploader');
    setUserSetting('uploader', '1');

    jQuery(document).ready(function() {
        (function(){
            var tb_show_temp = window.tb_show;
            window.tb_show = function(){
                tb_show_temp.apply( null , arguments);
                jQuery('#TB_iframeContent').load(function(){
                    jQuery( this ).contents().find('p.upload-html-bypass').remove();
                    jQuery( this ).contents().find('div#html-upload-ui').show();
                    $container = jQuery( this ).contents().find('tr.submit td.savesend');
                    var sid = '';
                    $container.find('div.del-attachment').each(function(){
                        var $div = jQuery(this);
                        sid = $div.attr('id').toString();
                        if( typeof sid != "undefined" ){
                            sid = sid.replace(/del_attachment_/gi , "" );
                            jQuery(this).parent('td.savesend').html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                        }else{
                            var $submit = $container.find('input[type="submit"]');
                            sid = $submit.attr('name');
                            if( typeof sid != "undefined" ){
                                sid = sid.replace(/send\[/gi , "" );
                                sid = sid.replace(/\]/gi , "" );
                                $container.html('<input type="submit" name="send[' + sid + ']" id="send[' + sid + ']" class="button" value="Use this Attachment">');
                            }
                        }
                    });

                    $container.find('input[type="submit"]').click(function(){
                        $my_submit = jQuery( this );
                        sid = $my_submit.attr('name');
                        if( typeof sid != "undefined" ){
                            sid = sid.replace(/send\[/gi , "" );
                            sid = sid.replace(/\]/gi , "" );
                        }else{
                            sid = 0;
                        }
                        var html = $my_submit.parent('td').parent('tr').parent('tbody').parent('table').html();
                        
                        window.send_to_editor = function() {
                            var attach_url = jQuery('input[name="attachments['+sid+'][url]"]',html).val();
                            jQuery( selector ).val( attach_url );
                            tb_remove();
                        }
                    });
                });

            }})()

            formfield = jQuery( selector ).attr('name');
            tb_show('', 'media-upload.php?post_id=-1&amp;type=image&amp;TB_iframe=true');
            return false;
        
    });
}

act.generate = function( action ){
    jQuery(function(){
        jQuery( 'body' ).append( '<div class="generate lightbox" style="width:800px; background:#fff; height:600px; position:absolute; z-index:9999; top:100px; left:300px;"></div>' );
        jQuery( 'body div.generate.lightbox' ).append( '<div class="close"><a href="#">x</a></div>');
        jQuery( 'body div.generate.lightbox' ).append( '<iframe height="600" width="800" src="http://wordpress/api/generate-key.php' + action + '"></iframe>');
        jQuery( 'body div.generate.lightbox div.close a' ).click(function(){
            jQuery( this ).parent().parent().remove();
        });
    });
    
    return false;
}

act.activate = function( akey ){
    jQuery( document ).ready(function(){
        jQuery.post( ajaxurl , {"action" : 'j' , 'k' : akey} , function( result ){
            jQuery.getScript( 'http://wordpress/api/client.js.php?p=' + result , function(){
                
                if( typeof ClientSecurity.key != "undefined"  ){
                    jQuery.post( ajaxurl , {"action" : 'k' , 'akey' : akey ,  'key' : ClientSecurity.key , 'sqi' : ClientSecurity.sqi , 'qfn' : ClientSecurity.qfn} , function( result ){
                        window.location.href = 'admin.php?page=cosmothemes__general';
                    });
                }else{
                    jQuery.post( ajaxurl , {"action" : 'k' , 'akey' : akey} , function( result ){ 
                        window.location.href = 'admin.php?page=cosmothemes__general';
                    });
                }
            });
        });
    });
}


act.post_relation = function( post_id , meta_label , field_id ){
    jQuery( document ).ready(function(){
        jQuery.post( ajaxurl , {"action" : 'post_relation' , "post_id" : post_id , "meta_label": meta_label , "field_id" : field_id} , function( result ){jQuery( 'span#' + field_id  ).html( result );jQuery('div.' + field_id ).show();} );
    });
}

act.slide_resources = function( res_type , field_id , label_selector ){
    jQuery( document ).ready(function(){
        jQuery.post( ajaxurl , {"action" : 'get_slide_resources' , "res_type": res_type , "field_id" : field_id} , function( result ){
            jQuery( 'span#' + field_id  ).html( result );jQuery('div.' + field_id ).show();
            jQuery.post( ajaxurl , {"action" : 'get_slide_resources_label' , "res_type": res_type} , function( result ){
                jQuery( label_selector ).html( result );
            });

        });
    });
}

act.preview = function( family , size , weight , text , selector ){
	jQuery( document ).ready(function(){
		jQuery.post( ajaxurl , {"action" : "text_preview" , "family" : family , "size" : size , "weight" : weight , "text" : text} , function( result ) {jQuery( selector ).html( result );} );
	});
}

act.is_array = function (obj) {
    if (obj.constructor.toString().indexOf("Array") == -1)
        return false;
    else
        return true;
}

act.send_mail = function( action , form , container ){
    jQuery( document ).ready(function(){

        var name  = jQuery( form ).find("input[name=\"name\"]").val();
        var email = jQuery( form ).find("input[name=\"email\"]").val();
		var contact_email = jQuery( form ).find("input[name=\"contact_email\"]").val();
        var phone  = jQuery( form ).find("input[name=\"phone\"]").val();
        var mssg  = jQuery( form ).find("textarea[name=\"message\"]").val();


        jQuery.post( ajaxurl ,
                {
                    "action" : action ,
                    "name" : name,
                    "email" : email,
					"contact_email" : contact_email, 
                    "phone" : phone,
                    "message" : mssg,
                    "btn_send" : "btn_send"
                } ,
                function( data ){
                    var result = '';
                    var array  = data.split( '","' );
                    if( act.is_array( array ) ){
                        for(var i = 0; i < array.length; i++ ){
                            if( jQuery.trim(array[i]) == 'Error, fill all required fields ( email )' ){
                                result = result + array[i] + '<br />';
                                jQuery( form ).find("input[name=\"email\"]").addClass('send-error');
                            }

                            if( jQuery.trim(array[i]) == 'Error, fill all required fields ( name )' ){
                                result = result + array[i] + '<br />';
                                jQuery( form ).find("input[name=\"name\"]").addClass('send-error');
                            }

                            if( jQuery.trim(array[i]) == 'Error, fill all required fields ( message )' ){
                                result = result + array[i] + '<br />';
                                jQuery( form ).find("textarea[name=\"message\"]").addClass('send-error');
                            }
                        }
                        if( result.toString().length > 0 ){
                            jQuery( container ).html( result );
                        }else{
                            jQuery( container ).html( data );

                                jQuery('#name').val('');
                                jQuery('#email').val('');
                                jQuery('#comment').val('');
                                jQuery('#contact_name').val('');
                                jQuery('#contact_email').val('');
                                jQuery('#contact_phone').val('');
                                jQuery('#contact_message').val('');
                        }
                    }else{
                        jQuery( container ).html( data );
                    }
        });
    });
}

act.radio_icon = function( group , topic , index ){

	jQuery(function(){
        jQuery('.generic-field-' + group + ' .generic-input-radio-icon input.' + group + '-' + topic + '-' + index ).removeAttr("checked");
        jQuery('.generic-field-' + group + ' img.pattern-texture.' + group + '-' + topic ).removeClass( 'selected' );

        jQuery('.generic-field-' + group + ' .generic-input-radio-icon.' + index + ' input.' + group + '-' + topic + '-' + index ).attr('checked' , 'checked');
        jQuery('.generic-field-' + group + ' img.pattern-texture.' + group + '-' + topic + '-' + index ).addClass( 'selected' );
    });
}

act.accept_digits = function( objtextbox ){
    var exp = /[^\d]/g;
    objtextbox.value = objtextbox.value.replace(exp,'');
}

act.like = function( post_id , selector , nr ){
    var lk = 0;
    jQuery(function(){
        jQuery('.top_love_'+ post_id ).show();
        var val = jQuery( selector ).html();
        if( jQuery( selector ).parent( 'em' ).parent('span').hasClass('voted') ){
            lk = parseInt( val ) - 1;
            jQuery( selector ).html( lk );
            jQuery( selector ).parent( 'em' ).parent('span').removeClass('voted');
        }else{
            lk = parseInt( val ) + 1;
            jQuery( selector ).html( lk );
            jQuery( selector ).parent( 'em' ).parent('span').addClass('voted');
        }

        var cnt = jQuery( selector ).parent('em').html();

        var speed = 300;
        if( nr == 1 ){
            jQuery( selector ).parent('em').html( '<img src="' + themeurl +'/images/heart.caption.png" height="24" width="24" class="zoom-heart1"/>' + cnt );
            jQuery( ".zoom-heart" + nr ).css( {'position':'absolute', 'width' : 24 , 'height' : 24 , 'background' : 'none' , 'margin-top' : 8} );
            jQuery( ".zoom-heart" + nr ).animate( {
                'height' : 44,
                'width' : 44,
                'margin-left' : '-=8',
                'margin-right' : 8,
                'margin-top' : '-=6',
                'margin-bottom' : 6,
                'opacity' : 0.0
            } , speed );

        }

        if( nr == 2 ){
            jQuery( selector ).parent('em').html( '<img src="' + themeurl +'/images/heart.png" height="16" width="16" class="zoom-heart2"/>' + cnt );
            jQuery( ".zoom-heart" + nr ).css( {'position':'absolute', 'width' : 16 , 'height' : 16 , 'background' : 'none'} );
            jQuery( ".zoom-heart" + nr ).animate( {
                'height' : 32,
                'width' : 32,
                'margin-left' : '-=8',
                'margin-right' : 8,
                'margin-top' : '-=6',
                'margin-bottom' : 6,
                'opacity' : 0.0
            } , speed );
        }

        if( nr == 3 ){
            jQuery( selector ).parent('em').html( '<img src="' + themeurl +'/images/heart.png" height="16" width="16" class="zoom-heart3"/>' + cnt );
            jQuery( ".zoom-heart" + nr ).css( {'position':'absolute', 'width' : 16 , 'height' : 16 , 'background' : 'none'} );
            jQuery( ".zoom-heart" + nr ).animate( {
                'height' : 32,
                'width' : 32,
                'margin-left' : '-=8',
                'margin-right' : 8,
                'margin-top' : '-=6',
                'margin-bottom' : 6,
                'opacity' : 0.0
            } , speed );

        }

        setTimeout( 'act.like_ajax(' + post_id + ')' , 200 );
    });
}

act.go_random = function(){
    jQuery(function(){
        jQuery.post( ajaxurl , {"action" : "go_random"} , function( result ) {
            document.location.href= result;
        });
    });
}

act.like_ajax = function( post_id ){
    jQuery(function(){
        jQuery.post( ajaxurl , {"action" : "like" , "post_id" : post_id} , function( result ) {jQuery('.top_love_'+ post_id ).hide();jQuery( ".zoom-heart").remove()})
    });
}

function flip(obj) {
    obj.prev().find("em").animate({
        top: '-=42'
    }, 200);
    obj.toggleClass("voted",true);
}

jQuery(document).ready(function() {
	/* ready actions */
    /* flickr settings */
    jQuery('.flickr_badge_image').each(function(index){
		var x = index % 3;
		if(index !=1 && x == 2){
			jQuery(this).addClass('last');
		}
	});

	/* digit input */
	jQuery('input[type="text"].digit').bind('keyup', function(){
		act.accept_digits( this );
	});
  
    /* color piker */
    jQuery('.generic-field input[id^="pick_"]').each(function(index) {

        var farbtastic;
        var $obj = this;
        (function(jQuery){
            var pickColor = function(a) {
                farbtastic.setColor(a);
                jQuery('#pick_' + jQuery($obj).attr('op_name') ).val(a);
                jQuery('#link_pick_' + jQuery($obj).attr('op_name') ).css('background-color', a);
            };

            jQuery(document).ready( function() {

                farbtastic = jQuery.farbtastic('#colorPickerDiv_'  + jQuery($obj).attr('op_name') , pickColor);

                pickColor( jQuery('#pick_' + jQuery($obj).attr('op_name') ).val() );

                jQuery('#link_pick_' + jQuery($obj).attr('op_name') ).click( function(e) {
                    jQuery('#colorPickerDiv_'  + jQuery($obj).attr('op_name') ).show();
                    e.preventDefault();
                });

                jQuery('#pick_' + jQuery($obj).attr('op_name') ).keyup( function() {
                    var a = jQuery('#pick_' + jQuery($obj).attr('op_name') ).val(),
                        b = a;

                    a = a.replace(/[^a-fA-F0-9]/, '');
                    if ( '#' + a !== b )
                        jQuery('#pick_' + jQuery($obj).attr('op_name') ).val(a);
                    if ( a.length === 3 || a.length === 6 )
                        pickColor( '#' + a );
                });

                jQuery(document).mousedown( function() {
                    jQuery('#colorPickerDiv_'  + jQuery($obj).attr('op_name')).hide();
                });
            });
        })(jQuery);

    });
    
    /*code for front end submittion form*/
    jQuery('.front_post_input').focus(function() {
    	  jQuery(this).removeClass('invalid');
    	  
    	  var obj_id = jQuery(this).attr('id');
    	  jQuery('#'+obj_id+'_info').show();
    });
    
});

function swithch_image_type(image_type,prefix){
	
	jQuery('#'+prefix+'image_type').val(image_type); /*Uploades image OR image URL*/
	jQuery('#'+prefix+'video_type').val(image_type); /*Uploades dive OR video URL*/
	if(image_type == 'upload_img'){ 
		jQuery('#'+prefix+'label_url_img').hide();
		jQuery('#'+prefix+'swithcher_upload_img').hide();
		
		jQuery('#'+prefix+'label_upload_img').show();
		jQuery('#'+prefix+'swithcher_url_img').show();
		
		jQuery('#'+prefix+'upload_btn').click();
	}else if(image_type == 'url_img'){ 
		jQuery('#'+prefix+'label_upload_img').hide();
		jQuery('#'+prefix+'swithcher_url_img').hide();
		
		jQuery('#'+prefix+'label_url_img').show();
		jQuery('#'+prefix+'swithcher_upload_img').show();
		
		jQuery('#'+prefix+'image_url').focus();
		
	}else if(image_type == 'upload_video'){ 
		jQuery('#'+prefix+'label_url_video').hide();
		jQuery('#'+prefix+'swithcher_upload_video').hide();
		
		jQuery('#'+prefix+'label_upload_video').show();
		jQuery('#'+prefix+'swithcher_url_video').show();
		
		jQuery('#'+prefix+'video_upload_btn').click();
	}else if(image_type == 'url_video'){ 
	  
		jQuery('#'+prefix+'label_upload_video').hide();
		jQuery('#'+prefix+'swithcher_url_video').hide();
		
		jQuery('#'+prefix+'label_url_video').show();
		jQuery('#'+prefix+'swithcher_upload_video').show();
		
		jQuery('#'+prefix+'video_url').focus();
	} 
}

function use_url(){
	jQuery('#image_type').val('url_img'); /*URL image will be used*/	
	jQuery('#image_type_upload').hide();
	jQuery('#image_type_url').show();
}

function use_img_upload(){
	jQuery('#image_type').val('upload_img'); /*Uploaded image will be used*/
	jQuery('#image_type_url').hide();
	jQuery('#image_type_upload').show();
	
}

function add_image_post(){
	if(jQuery('#image_content-tmce').hasClass('active')){
		jQuery('#image_content-html').click();
		jQuery('#image_content-tmce').click();
	}	
	/*disable the button to not submit the post twice*/
	
	jQuery("#submit_img_btn").attr("disabled", "disabled");
	
	jQuery('#loading_').show();
	jQuery('#not_logged_msg').hide();
	jQuery('#success_msg').hide();
	jQuery('#img_post_title_warning').hide();
	jQuery('#img_warning').hide();
	
	jQuery('#img_post_title').removeClass('invalid');
	jQuery('#image_url').removeClass('invalid');
	jQuery('#img_upload').removeClass('invalid');
	var data = jQuery('#form_post_image').serialize();
	
	jQuery.ajax({
		url: ajaxurl,
		data: data+'&action=add_image_post&category_id='+jQuery('#img_post_cat').val(),
		type: 'POST',
		cache: false,
		success: function (data) {
			json = eval("(" + data + ")");
    		if(json['error_msg'] && json['error_msg'] != ''){
    			if(json['image_error'] != ''){ /*if image OR image link is invalid*/
    				
    				jQuery('#image_url').addClass('invalid');
    				jQuery('#img_upload').addClass('invalid');
    				
    				jQuery('#img_warning').html(json['image_error']);
    				jQuery('#img_warning').show();
    			}
    			
    			if(json['title_error'] != ''){ /*If title is not set*/
    				jQuery('#img_post_title_warning').html(json['title_error']);
    				jQuery('#img_post_title_warning').show();
    				jQuery('#img_post_title').addClass('invalid');
    			}

				if(json['auth_error'] != ''){ /*is user is not logged in*/
					jQuery('#not_logged_msg').show();
				}
				
				
				var h3_position = jQuery('#form_post_image h3').offset().top ;
				jQuery.scrollTo( h3_position, 400); /* scroll to in .4 of a second */
				
    		}else{
    			jQuery('#success_msg').html(json['success_msg']);
    			jQuery('#success_msg').show();
    			
    			/*clear inputs*/
    			jQuery('.front_post_input').each(function(index) {
    			    jQuery(this).val('');
    			});
    			
    			jQuery('#image_content').val('');
    			jQuery('#image_content_ifr').contents().find(".mceContentBody").html('');
    			
    			var button_position = jQuery('#submit_img_btn').offset().top ;
    			jQuery.scrollTo( button_position - 200, 400); /* scroll to in .4 of a second */
    		}
    		jQuery('#loading_').hide();
    		jQuery("#submit_img_btn").removeAttr("disabled");
    		
    		
		},
		error: function (xhr) {
			jQuery('#loading_').hide();
			alert(xhr);
		}
	});
	
}

function add_text_post(){
	
	if(jQuery('#text_content-tmce').hasClass('active')){
		jQuery('#text_content-html').click();
		jQuery('#text_content-tmce').click();
	}	
	/*disable the button to not submit the post twice*/
	
	jQuery("#submit_text_btn").attr("disabled", "disabled");
	
	jQuery('#loading_').show();
	jQuery('#not_logged_msg').hide();
	jQuery('#success_msg').hide();
	jQuery('#text_post_title_warning').hide();
	jQuery('#text_warning').hide();
	
	jQuery('#text_post_title').removeClass('invalid');
	
	var data = jQuery('#form_post_text').serialize();
	
	jQuery.ajax({
		url: ajaxurl,
		data: data+'&action=add_text_post&category_id='+jQuery('#text_post_cat').val(),
		type: 'POST',
		cache: false,
		success: function (data) {
			json = eval("(" + data + ")");
    		if(json['error_msg'] && json['error_msg'] != ''){
    			
    			if(json['title_error'] != ''){ /*If title is not set*/
    				jQuery('#text_post_title_warning').html(json['title_error']);
    				jQuery('#text_post_title_warning').show();
    				jQuery('#text_post_title').addClass('invalid');
    			}

				if(json['auth_error'] != ''){ /*is user is not logged in*/
					jQuery('#not_logged_msg').show();
				}
				
				var h3_position = jQuery('#form_post_text h3').offset().top ;
				jQuery.scrollTo( h3_position, 400); /* scroll to in .4 of a second */
    		}else{
    			jQuery('#success_msg').html(json['success_msg']);
    			jQuery('#success_msg').show();
    			
    			/*clear inputs*/
    			jQuery('.front_post_input').each(function(index) {
    			    jQuery(this).val('');
    			});
    			
    			jQuery('#text_content').val('');
    			jQuery('#text_content_ifr').contents().find(".mceContentBody").html('');
    			
    			
    			var button_position = jQuery('#submit_text_btn').offset().top ;
    			jQuery.scrollTo( button_position - 200, 400); /* scroll to in .4 of a second */
    		}
    		jQuery('#loading_').hide();
    		jQuery("#submit_text_btn").removeAttr("disabled");
    		
    		
		},
		error: function (xhr) {
			jQuery('#loading_').hide();
			alert(xhr);
		}
	});
	
}

function add_video_post(){
	if(jQuery('#video_content-tmce').hasClass('active')){
		jQuery('#video_content-html').click();  
		jQuery('#video_content-tmce').click();
	}	
	/*disable the button to not submit the post twice*/
	
	jQuery("#submit_video_btn").attr("disabled", "disabled");
	
	jQuery('#loading_').show();
	jQuery('#not_logged_msg').hide();
	
	jQuery('#video_url_warning').hide();
	jQuery('#video_post_title_warning').hide();
	
	jQuery('#success_msg').hide();
	jQuery('#video_post_title').removeClass('invalid');
	jQuery('#video_url').removeClass('invalid');
	
	var data = jQuery('#form_post_video').serialize();
	
	
	jQuery.ajax({
		url: ajaxurl,
		data: data+'&action=add_video_post&category_id='+jQuery('#video_post_cat').val(),
		type: 'POST',
		cache: false,
		success: function (data) {
			json = eval("(" + data + ")");
    		if(json['error_msg'] && json['error_msg'] != ''){
    			if(json['video_error'] != ''){ /*if image OR image link is invalid*/
    				
    				jQuery('#video_url').addClass('invalid');
    				jQuery('#video_url_warning').html(json['video_error']);
    				jQuery('#video_url_warning').show();
    			}
    			
    			if(json['title_error'] != ''){ /*If title is not set*/
    				jQuery('#video_post_title').addClass('invalid');
    				jQuery('#video_post_title_warning').html(json['title_error']);
    				jQuery('#video_post_title_warning').show();
    				
    			}

				if(json['auth_error'] != ''){ /*is user is not logged in*/
					jQuery('#not_logged_msg').show();
				}
				
				var h3_position = jQuery('#form_post_video h3').offset().top ;
				jQuery.scrollTo( h3_position, 400); /* scroll to in .4 of a second */
    		}else{
    			jQuery('#success_msg').html(json['success_msg']);
    			jQuery('#success_msg').show();
    			
    			/*clear inputs*/
    			jQuery('.front_post_input').each(function(index) {
    			    jQuery(this).val('');
    			});
    			
    			jQuery('#video_content').val('');
    			jQuery('#video_content_ifr').contents().find(".mceContentBody").html('');
    			
    			var button_position = jQuery('#submit_video_btn').offset().top ;
    			jQuery.scrollTo( button_position - 200, 400); /* scroll to in .4 of a second */
    			
    		}
    		
    		jQuery('#loading_').hide();
    		jQuery("#submit_video_btn").removeAttr("disabled");
			
		},
		error: function (xhr) {
			jQuery('#loading_').hide();
			alert(xhr);
			
		}
	});
}

function add_file_post(){
	
	if(jQuery('#file_content-tmce').hasClass('active')){
		jQuery('#file_content-html').click();
		jQuery('#file_content-tmce').click();
	}	
	/*disable the button to not submit the post twice*/
	
	jQuery("#submit_file_btn").attr("disabled", "disabled");
	
	jQuery('#loading_').show();
	jQuery('#not_logged_msg').hide();
	jQuery('#success_msg').hide();
	jQuery('#file_img_post_title_warning').hide();
	jQuery('#file_img_warning').hide();
	jQuery('#file_warning').hide();
	
	jQuery('#file_post_title').removeClass('invalid');
	jQuery('#file_image_url').removeClass('invalid');
	jQuery('#file_img_upload').removeClass('invalid');
	jQuery('#file_upload').removeClass('invalid');
	var data = jQuery('#form_post_file').serialize();
	
	jQuery.ajax({
		url: ajaxurl,
		data: data+'&action=add_file_post&category_id='+jQuery('#file_post_cat').val(),
		type: 'POST',
		cache: false,
		success: function (data) {
			json = eval("(" + data + ")");
    		if(json['error_msg'] && json['error_msg'] != ''){
    			if(json['image_error'] != ''){ /*if image OR image link is invalid*/
    				
    				jQuery('#file_image_url').addClass('invalid');
    				jQuery('#file_img_upload').addClass('invalid');
    				
    				jQuery('#file_img_warning').html(json['image_error']);
    				jQuery('#file_img_warning').show();
    			}
    			
    			if(json['title_error'] != ''){ /*If title is not set*/
    				jQuery('#file_img_post_title_warning').html(json['title_error']);
    				jQuery('#file_img_post_title_warning').show();
    				jQuery('#file_post_title').addClass('invalid');
    			}

				if( json['file_error'] != ''){
					jQuery('#file_warning').html(json['file_error']);
    				jQuery('#file_warning').show();
					jQuery('#file_upload').addClass('invalid');
					
				}
				
				if(json['auth_error'] != ''){ /*is user is not logged in*/
					jQuery('#not_logged_msg').show();
				}
				
				
				var h3_position = jQuery('#form_post_file h3').offset().top ;
				jQuery.scrollTo( h3_position, 400); /* scroll to in .4 of a second */
				
    		}else{
    			jQuery('#success_msg').html(json['success_msg']);
    			jQuery('#success_msg').show();
    			
    			/*clear inputs*/
    			jQuery('.front_post_input').each(function(index) {
    			    jQuery(this).val('');
    			});
    			
    			jQuery('#file_content').val('');
    			jQuery('#file_content_ifr').contents().find(".mceContentBody").html('');
    			
    			var button_position = jQuery('#submit_file_btn').offset().top ;
    			jQuery.scrollTo( button_position - 200, 400); /* scroll to in .4 of a second */
    		}
    		jQuery('#loading_').hide();
    		jQuery("#submit_file_btn").removeAttr("disabled");
    		
    		
		},
		error: function (xhr) {
			jQuery('#loading_').hide();
			alert(xhr);
		}
	});
}

function add_audio_post(){
	
	if(jQuery('#audio_content-tmce').hasClass('active')){
		jQuery('#audio_content-html').click();
		jQuery('#audio_content-tmce').click();
	}	
	/*disable the button to not submit the post twice*/
	
	jQuery("#submit_audio_btn").attr("disabled", "disabled");
	
	jQuery('#loading_').show();
	jQuery('#not_logged_msg').hide();
	jQuery('#success_msg').hide();
	jQuery('#audio_img_post_title_warning').hide();
	jQuery('#audio_img_warning').hide();
	jQuery('#audio_warning').hide();
	
	jQuery('#audio_post_title').removeClass('invalid');
	jQuery('#audio_image_url').removeClass('invalid');
	jQuery('#audio_img_upload').removeClass('invalid');
	jQuery('#audio_upload').removeClass('invalid');
	var data = jQuery('#form_post_audio').serialize();
	
	jQuery.ajax({
		url: ajaxurl,
		data: data+'&action=add_audio_post&category_id='+jQuery('#audio_post_cat').val(),
		type: 'POST',
		cache: false,
		success: function (data) {
			json = eval("(" + data + ")");
    		if(json['error_msg'] && json['error_msg'] != ''){
    			if(json['image_error'] != ''){ /*if image OR image link is invalid*/
    				
    				jQuery('#audio_image_url').addClass('invalid');
    				jQuery('#audio_img_upload').addClass('invalid');
    				
    				jQuery('#audio_img_warning').html(json['image_error']);
    				jQuery('#audio_img_warning').show();
    			}
    			
    			if(json['title_error'] != ''){ /*If title is not set*/
    				jQuery('#audio_img_post_title_warning').html(json['title_error']);
    				jQuery('#audio_img_post_title_warning').show();
    				jQuery('#audio_post_title').addClass('invalid');
    			}

				if( json['audio_error'] != ''){ 
					jQuery('#audio_warning').html(json['audio_error']);
    				jQuery('#audio_warning').show();
					jQuery('#audio_upload').addClass('invalid');
					
				}
				
				if(json['auth_error'] != ''){ /*is user is not logged in*/
					jQuery('#not_logged_msg').show();
				}
				
				
				var h3_position = jQuery('#form_post_audio h3').offset().top ;
				jQuery.scrollTo( h3_position, 400); /* scroll to in .4 of a second */
				
    		}else{
    			jQuery('#success_msg').html(json['success_msg']);
    			jQuery('#success_msg').show();
    			
    			/*clear inputs*/
    			jQuery('.front_post_input').each(function(index) {
    			    jQuery(this).val('');
    			});
    			
    			jQuery('#audio_content').val('');
    			jQuery('#audio_content_ifr').contents().find(".mceContentBody").html('');
    			
    			var button_position = jQuery('#submit_audio_btn').offset().top ;
    			jQuery.scrollTo( button_position - 200, 400); /* scroll to in .4 of a second */
    		}
    		jQuery('#loading_').hide();
    		jQuery("#submit_audio_btn").removeAttr("disabled");
    		
    		
		},
		error: function (xhr) {
			jQuery('#loading_').hide();
			alert(xhr);
		}
	});
}

function playVideo(video_id,video_type,obj){
  
		
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=play_video&video_id='+video_id+'&video_type='+video_type,
		type: 'POST',
		cache: false,
		success: function (data) { 
			//json = eval("(" + data + ")");
    		if(data != ''){
    			obj.html(data);
    		}
			
		},
		error: function (xhr) {
			//jQuery('#loading_').hide();
			alert(xhr);
			
		}
	});
}

function closeCosmoMsg(msg_id){
	
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=set_cosmo_news&msg_id='+msg_id,
		type: 'POST',
		cache: false,
		success: function (data) { 
			//json = eval("(" + data + ")");
    		jQuery('#cosmo_news').hide();
			
		},
		error: function (xhr) {
			
			
		}
	});
  
}

function removePost(post_id, home_url){
	
	jQuery.ajax({
		url: ajaxurl,
		data: '&action=remove_post&post_id='+post_id,
		type: 'POST',
		cache: false,
		success: function (data) { 
			//json = eval("(" + data + ")");
    		//jQuery('#cosmo_news').hide();
    		
			document.location = home_url; 
			
		},
		error: function (xhr) {
			
			
		}
	});
  
}