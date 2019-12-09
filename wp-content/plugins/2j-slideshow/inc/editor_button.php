<?php 
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

function add_twoj_slideshow_button(){
	wp_enqueue_style("wp-jquery-ui-dialog");
	wp_enqueue_script('jquery-ui-dialog');
  
  	wp_enqueue_script('twoj-twoj-slideshow-button', TWOJ_SLIDESHOW_URL.'js/admin/editor-button.js', array( 'jquery' ), TWOJ_SLIDESHOW_VERSION, true );    
  	
  	$translation_array = array( 
		'twojSlideshowTitle' 	=> __('2J SlideShow','2j-slideshow'),
		'closeButton'			=> twoj_slideshow_t('Close','2j-slideshow'),
		'insertButton'			=> twoj_slideshow_t('Insert','2j-slideshow'),
	);

	wp_localize_script( 'twoj-twoj-slideshow-button', 'twoj_slideshow_trans', $translation_array );
	wp_enqueue_script( 'twoj-twoj-slideshow-button' );

  	echo '<a href="#twoj-slideshow" id="insert-2j-slideshow" class="button"><span class="dashicons dashicons-images-alt" style="margin: 4px 5px 0 0;"></span>'.twoj_slideshow_t( 'Add 2J Slideshow' , '2j-slideshow' ).'</a>';
	
	$params = array(
	    'sort_order'   	=> 'ASC',
	    'sort_column'  	=> 'post_title',
	    'echo'			=> 0,
	    'post_type' 	=> TWOJ_SLIDESHOW_TYPE_POST
	); 
  	echo '<div id="twoj-slideshow" style="display: none;">'
  			.twoj_slideshow_t('Select slideshow', '2j-slideshow').': '.wp_dropdown_pages( $params ) 
  			.'<p style="margin-bottom:0px;">
  				'.twoj_slideshow_t( 'Manage your ','2j-slideshow').' 
  				<a href="edit.php?post_type='.TWOJ_SLIDESHOW_TYPE_POST.'" target="_blank">
  					'.twoj_slideshow_t( '2J SlideShows','2j-slideshow').'
  				</a>
  			</p>'
  		.'</div>';
}
add_action('media_buttons', 'add_twoj_slideshow_button', 15);
