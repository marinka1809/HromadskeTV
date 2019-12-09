<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

function twoj_slideshow_tag($content){
    global $post;
    if ( post_password_required() ) return $content;
  
    $returnCode = '';
    if( get_post_type() == TWOJ_SLIDESHOW_TYPE_POST && is_main_query() ){
		$returnCode = do_shortcode("[2jslideshow id={$post->ID}]");
	}
	return $content.$returnCode;
}
add_filter( 'the_content', 'twoj_slideshow_tag');

function twoj_slideshow_shortcode( $attr ) {
 	$retHTML = '';
 	if( isset($attr) && ( isset($attr['id']) || isset($attr[0]) )  ){
		$slideshow = new twojSlideshow($attr);
		$retHTML = $slideshow->getSlideshow();
	}
	return  $retHTML;
}
add_shortcode( '2jslideshow', 'twoj_slideshow_shortcode' );
add_shortcode( 'twoj-slideshow', 'twoj_slideshow_shortcode' );