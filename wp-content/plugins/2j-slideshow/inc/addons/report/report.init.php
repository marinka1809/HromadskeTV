<?php 
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

if(!function_exists('twoj_slideshow_report_init')){
	function twoj_slideshow_report_init(){
		twoj_slideshow_include('report.class.php',  plugin_dir_path( __FILE__ ) );
		new TwojSlideShowReport( TWOJ_SLIDESHOW_TYPE_POST );
	}
	add_action( 'init', 'twoj_slideshow_report_init' );
}

if(!function_exists('twoj_slideshow_report_submenu_page')){
	add_action('admin_menu', 'twoj_slideshow_report_submenu_page');
	function twoj_slideshow_report_submenu_page() {
		add_submenu_page( 'edit.php?post_type='.TWOJ_SLIDESHOW_TYPE_POST, 'Report', 'Report', 'manage_options', 'twoj-slideshow-report', 'twoj_slideshow_report_submenu_page_render' );
	}
	function twoj_slideshow_report_submenu_page_render(){
		twoj_slideshow_include('report.html.php', plugin_dir_path( __FILE__ ));
	}
}