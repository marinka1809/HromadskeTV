<?php 
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

if(!function_exists('twoj_slideshow_fix_menu')){
	function twoj_slideshow_fix_menu(){
		if( 
			isset($_GET['post_type']) && $_GET['post_type']=='twoj_slideshow_post' &&
			isset($_GET['page']) && $_GET['page']=='twoj-slideshow-support' 
		) wp_redirect( "http://2joomla.net/wordpress/open.php?product=2jslideshow&task=support" );

		if( 
			isset($_GET['post_type']) && $_GET['post_type']=='twoj_slideshow_post' &&
			isset($_GET['page']) && $_GET['page']=='twoj-slideshow-demo' 
		) wp_redirect( "http://2joomla.net/wordpress/open.php?product=2jslideshow&task=demo" );

	}
	add_action( 'init', 'twoj_slideshow_fix_menu' );
}



if(!function_exists('twoj_slideshow_support_submenu_page')){
	add_action('admin_menu', 'twoj_slideshow_support_submenu_page');
	function twoj_slideshow_support_submenu_page() {
		add_submenu_page( 'edit.php?post_type=twoj_slideshow_post', '2J Slideshow Help', 'Help', 'manage_options', 'twoj-slideshow-support', 'twoj_slideshow_support_submenu_page_render');
	}
	function twoj_slideshow_support_submenu_page_render(){
		echo '<script> window.open("http://2joomla.net/wordpress/open.php?product=2jslideshow&task=help", "_bank"); window.open("edit.php?post_type=twoj_slideshow_post", "_self"); </script>'; 
	}
}

if(!function_exists('twoj_slideshow_submenu_empty')){ function twoj_slideshow_submenu_empty(){} }

if(!function_exists('twoj_slideshow_demo_submenu_page')){
	add_action('admin_menu', 'twoj_slideshow_demo_submenu_page');
	function twoj_slideshow_demo_submenu_page() {
		add_submenu_page( 'edit.php?post_type=twoj_slideshow_post', '2J Slideshow Demo', '2J Slideshow Demo', 'manage_options', 'twoj-slideshow-demo', 'twoj_slideshow_submenu_empty' );
	}
}

if(!function_exists('twoj_slideshow_menuConfig')){
	function twoj_slideshow_menuConfig(){
		wp_enqueue_script('twoj-slideshow-menu', TWOJ_SLIDESHOW_URL.'js/admin/menu.js', array( 'jquery' ), TWOJ_SLIDESHOW_VERSION, true ); 
	}
	add_action( 'in_admin_header', 'twoj_slideshow_menuConfig' );
}

