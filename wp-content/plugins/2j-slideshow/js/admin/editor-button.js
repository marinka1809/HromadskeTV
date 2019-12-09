/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

jQuery(function(){
	var twojSlideshowDialog = jQuery("#twoj-slideshow").appendTo("body");
	twojSlideshowDialog.dialog({
		'dialogClass' : 'wp-dialog',
		'title': twoj_slideshow_trans.twojSlideshowTitle,
		'modal' : true,
		'autoOpen' : false,
		'width': 'auto',
	    'maxWidth': 700,
	    'height': 'auto',
	    'fluid': true, 
	    'resizable': false,
		'responsive': true,
		'draggable': false,
		'closeOnEscape' : true,
		'buttons' : [{
				'text' : twoj_slideshow_trans.closeButton,
				'class' : 'button-default',
				'click' : function() { jQuery(this).dialog('close'); }
		},{
				'text' : twoj_slideshow_trans.insertButton,
				'class' : 'button-primary',
				'click' : function() { 
					var slideshowId = jQuery('#page_id', twojSlideshowDialog).val();
					window.parent.send_to_editor('[2jslideshow '+slideshowId+']');
        			window.parent.tb_remove();
					jQuery(this).dialog('close'); 
				}
		}],
		open: function( event, ui ) {}
	});
	jQuery(document).on( 'click', '#insert-2j-slideshow', function(event) { 
		twojSlideshowDialog.dialog('open'); 
		return false; 
	});
});