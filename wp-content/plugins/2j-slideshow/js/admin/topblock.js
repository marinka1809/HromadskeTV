/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

jQuery(function(){
	jQuery('.twoj_getproversion_blank').click( function(event ){
		event.preventDefault();
		window.open("http://2joomla.net/wordpress/open.php?product=2jslideshow&task=gopremium",'_blank');
		if( jQuery(this).is(".twoj_close_dialog") ) window['twojSlideshowDialog'].dialog("close");
	});
	jQuery('.twoj_getproversionforfree_blank').click( function(event ){
		event.preventDefault();
		window.open("http://2joomla.net/wordpress/open.php?product=2jslideshow&task=gopremiumforfree",'_blank');
		if( jQuery(this).is(".twoj_close_dialog") ) window['twojSlideshowDialog'].dialog("close");
	});
});