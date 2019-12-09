<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

function twoj_slideshow_group_metabox() {

	function twoj_slideshow_set_checkbox_default_for_new_post( $default ) {
		return twoj_slideshow_is_edit_page('edit') ? '' : ( $default ? (string) $default : '' );
	}

    twoj_slideshow_include( 
    		array( 'images.php', 'size.php',  'interface.php', 'animation.php', 'general.php' ), 
    		TWOJ_SLIDESHOW_OPTIONS_PATH 
    );
	
	if( !TWOJ_SLIDESHOW_PRO ) twoj_slideshow_include('premium_version.php', TWOJ_SLIDESHOW_OPTIONS_PATH);
}
add_action( 'cmb2_init', 'twoj_slideshow_group_metabox' );


function twoj_slideshow_add_publish_meta_options($post_obj) {
 
	global $post;
 
 	$views = (int) get_post_meta( $post->ID, 'views', true);

	if( TWOJ_SLIDESHOW_TYPE_POST == $post->post_type) {
		echo  '
			<div class="misc-pub-section twoj-misc-pub-post-views misc-pub-post-status" >
				'.__('Views', '2j-slideshow').': <span >'.$views.'</span>
			</div>';
	}
}
 

add_action('post_submitbox_misc_actions', 'twoj_slideshow_add_publish_meta_options');