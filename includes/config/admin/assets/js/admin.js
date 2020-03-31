jQuery(function($){
    var ajaxurl    = hcc_upload_params.ajaxurl;
    var btn_upload = hcc_upload_params.btn_upload;
    var btn_title  = hcc_upload_params.btn_title;
    var btn_use    = hcc_upload_params.btn_use;
    var btn_remove = hcc_upload_params.btn_remove;
    
    /*
	 * Select/Upload image(s) event
	 */
	$(document).on('click', '.hcc_upload_image_button', function(e){
		e.preventDefault();
 
    		var button = $(this),
    		    custom_uploader = wp.media({
			title: btn_title,
			library : {
				// uncomment the next line if you want to attach image to the current post
				// uploadedTo : wp.media.view.settings.post.id, 
				type : 'image'
			},
			button: {
				text: btn_use  // button label text
			},
			multiple: false // for multiple image selection set to true
		}).on('select', function() { // it also has "open" and "close" events 
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			$(button).removeClass('button').html('<img class="true_pre_image" src="' + attachment.url + '" style="max-width:95%;display:block;" />').next().val(attachment.id).next().show();
			/* if you sen multiple to true, here is some code for getting the image IDs
			var attachments = frame.state().get('selection'),
			    attachment_ids = new Array(),
			    i = 0;
			attachments.each(function(attachment) {
 				attachment_ids[i] = attachment['id'];
				console.log( attachment );
				i++;
			});
			*/
		})
		.open();
	});
 
	/*
	 * Remove image event
	 */
	$(document).on('click', '.hcc_remove_image_button', function(){
		$(this).hide().prev().val('').prev().addClass('button').html(btn_upload);
		return false;
	});
    
    
    $(document).on('click', '.hcc_upload_file_button', function(e){
        e.preventDefault();
        var button = $(this);
        var custom_uploader = wp.media({
                title: btn_title,
			    library : {
                    type : 'image'
                },
                button: {
                    text: btn_use
                },
                multiple: false
        }).on('select', function(){
            var attachment = custom_uploader.state().get('selection').first().toJSON();
        }).open();
		return false;    
	});
    
});