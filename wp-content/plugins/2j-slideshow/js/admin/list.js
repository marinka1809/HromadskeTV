/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */
(function($) {
	$('.twoj_slideshow_images.column-twoj_slideshow_images .tooltip').on("mouseenter", function(){
		if( $(this).is('.tooltip_needload') ){
			$( this).removeClass('tooltip_needload');
			twojSlideshowUpdateTooltip( $(this).data('id'), this);	
		}
	});

	function twojSlideshowUpdateTooltip( id, elem ){
		var data = {
			'action': 'twoj_slideshow_get_images_from_post',
			'idstring': id
		};
		jQuery.post(ajaxurl, data, function(response) {
			$('.tooltiptext', elem).html(response);
		});
	}
})(jQuery);