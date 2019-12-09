<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

class TwojSlideshowActivator {
	public static function activate() {
		delete_option("twojs_slideshow_install_action");
		add_option( 'twojs_slideshow_install_action', '1' );
	}
	public static function deactivate() {}
}