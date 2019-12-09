<?php 
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class TwojSlideshowUpdate {

	public $updateFlag = 1;

	public $nowInstall = false;

	
	public function __construct(){
		
		$this->nowInstall = get_option( 'twojSlideshowVersion' );
		if(!$this->nowInstall) $this->nowInstall = 0;

		if( $this->nowInstall && $this->nowInstall == TWOJ_SLIDESHOW_VERSION )  $this->updateFlag = false;

		if( $this->updateFlag ){
			delete_option("twojs_slideshow_install_action");
			add_option( 'twojs_slideshow_install_action', '1' );

			delete_option("twojSlideshowVersion");
			add_option( "twojSlideshowVersion", TWOJ_SLIDESHOW_VERSION );
		}
	}

}
