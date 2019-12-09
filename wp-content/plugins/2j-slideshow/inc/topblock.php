<?php 
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

if(!function_exists('twoj_slideshow_topblock')){
	function twoj_slideshow_topblock(){
		wp_enqueue_script( 	'twoj-slideshow-topblock', TWOJ_SLIDESHOW_URL.'js/admin/topblock.js', array( 'jquery' ), TWOJ_SLIDESHOW_VERSION, true );
		wp_enqueue_style ( 	'twoj-toolbox-topblock', TWOJ_SLIDESHOW_URL.'css/admin/topblock.css', array( ), TWOJ_SLIDESHOW_VERSION );
		$editNew = twoj_slideshow_is_edit_page('new') || twoj_slideshow_is_edit_page('edit');
		echo '<div class="twojTopBlock twoj_getproversion_blank">
			<div class="twojTopBig"><span class="dashicons dashicons-awards"></span>'.	twoj_slideshow_t( 'Get Unlimited Functionality in Premium version' , '2j-slideshow' ).'</div>
		</div>';
	}
	if(!TWOJ_SLIDESHOW_PRO) add_action( 'in_admin_header', 'twoj_slideshow_topblock' );
}
