(function($){
	
	var data_plugin = false;
	
	$('tr[data-slug^="'+ twoj_slideshow_setup.slug +'"] .deactivate a, .twoj_slideshow_setup-footer .button-close').click(function(){
		data_plugin = $(this).parent().parent().parent().parent().attr('data-plugin');
		$('button.allow-deactivate').html( twoj_slideshow_setup.skip );
		$('.twoj_slideshow_setup-deactivation-feedback').toggleClass('active');
		$('.twoj_slideshow_setup input[type=text]').hide()
		$('.twoj_slideshow_setup input[name=check]').prop('checked', false);
		return false;
	});
	
	$('.twoj_slideshow_setup input[name=check]').change(function(){
		var val = $(this).val();
		$('.twoj_slideshow_setup input[type=text]').hide().val('');
		$('button.allow-deactivate').html( twoj_slideshow_setup.submit );
		
		if( val == 2 || val == 7 ){
			$(this).parent().parent().parent().find('.internal-message input[type=text]').show();
		}
	});
	
	$('.twoj_slideshow_setup-footer .allow-deactivate').click(function(){
		var data = $('form.twoj_slideshow_setup').serialize();
		
		$.ajax({
			type: 'POST',
			url: twoj_slideshow_setup.ajax,
			data: data + '&plugin='+ data_plugin +'&action=twoj_slideshow_setup',
			success: function(data) {
				location.reload();
			},
			error:  function(xhr, str){
				console.log('error: ' + xhr.responseCode);
			}
		});
	
		return false;
	});

})(jQuery);