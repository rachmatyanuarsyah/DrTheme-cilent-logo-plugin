var custom_uploader;
jQuery(document).ready(function($) {
	var error_msg = jQuery("#message p[class='setting-error-message']");
	// look for admin messages with the "setting-error-message" error class
	if (error_msg.length != 0) {
		// get the title
		var error_setting = error_msg.attr('title');
		
		// look for the label with the "for" attribute=setting title and give it an "error" class (style this in the css file!)
		$("label[for='" + error_setting + "']").addClass('error');
		
		// look for the input with id=setting title and add a red border to it.
		$("input[id='" + error_setting + "']").attr('style', 'border-color: red');
	}	
	jQuery('.upload_group').unbind('click').click(function(e){
			 //e.preventDefault();
			 image_id=$(this).attr('id');
			 if (custom_uploader){
				 custom_uploader.open();
			     return;
			 }
			 custom_uploader = wp.media.frames.file_frame = wp.media({
				 title: 'Choose Image',
			     button: {
			            text: 'Choose Image'
			     },
			     library: { type: 'image' },
			     multiple: false
			 });
			 custom_uploader.on('select', function(){
				 attachment = custom_uploader.state().get('selection').first().toJSON();
			     $('#'+image_id).val(attachment.url);
			     $('#preview_'+image_id).attr('src',attachment.url)
			     $('#'+image_id+'.upload_group').val("Change File");
			 });
			 custom_uploader.open();
	});
});