<?php 
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

if( isset($_GET['showproinfo']) && $_GET['showproinfo'] ){
	if(!function_exists('twoj_slideshow_showInformation')){
		function twoj_slideshow_showInformation(){
			wp_enqueue_style("wp-jquery-ui-dialog");
			wp_enqueue_script('jquery-ui-dialog');

			wp_enqueue_script('twoj-slideshow-info', TWOJ_SLIDESHOW_URL.'js/admin/info.js', array( 'jquery' ), TWOJ_SLIDESHOW_VERSION, true ); 
			wp_enqueue_style ('twoj-slideshow-info', TWOJ_SLIDESHOW_URL.'css/admin/info.css', array( ), TWOJ_SLIDESHOW_VERSION );
			
			echo '<div id="twoj_showInformation" '
						.'style="display: none;" '
						.'data-open="1" '
						.'data-title="'.__('Get 2J Slideshow Premium version', '2j-slideshow').'" '
						.'data-close="'.__('Close', '2j-slideshow').'" '
						.'data-info="'.__('Get Premium version', '2j-slideshow').'"'
					.'>'
					.__('You can create only 1 slideshow. Update to Premium to get unlimited slideshows', '2j-slideshow')
				.'</div>';
		}
		if(!TWOJ_SLIDESHOW_PRO) add_action( 'in_admin_header', 'twoj_slideshow_showInformation' );
	}
}

if(!function_exists('twoj_slideshow_column')){
	function twoj_slideshow_column( $column, $post_id ) {
	    switch ( $column ) {
		case 'twoj_slideshow_images' :
			global $post;
			$images = get_post_meta( (int) $post->ID, TWOJ_SLIDESHOW_PREFIX.'slideshowImages', true);
			if(count($images)){
				if( isset($images[0]) && trim($images[0])!='' ){
					echo '<a href="'.admin_url( 'post.php?post='.$post_id.'&action=edit&show_media_editor=1' ).'" class="tooltip tooltip_needload" data-id="'.$post_id.'">';
						echo '<span class="dashicons-before dashicons-images-alt"> '.count($images).'</span>'; 	
						echo '<span class="twoj_tooltip tooltiptext"><span>'.__('Loading', '2j-slideshow').'...</span></span>';
					echo '</a>';
				}
			}		    
		    break;
	    }
	}
	add_action( 'manage_'.TWOJ_SLIDESHOW_TYPE_POST.'_posts_custom_column' , 'twoj_slideshow_column', 10, 2 );
}


if(!function_exists('twoj_slideshow_column_title')){	
	function twoj_slideshow_column_title($columns) { 
		return array_merge($columns, array('twoj_slideshow_images' => twoj_slideshow_t('Slides') ) ); 
	}
	add_filter('manage_'.TWOJ_SLIDESHOW_TYPE_POST.'_posts_columns' , 'twoj_slideshow_column_title');
}

if(!function_exists('twoj_custom_columns')){
	function twoj_custom_columns( $column, $post_id ) {
	    switch ( $column ) {
		case 'twoj_slideshow' :
			global $post;
			$slug = '' ;
			$slug = $post->post_name;
	        $shortcode = '<span>[2jslideshow '.$post->ID.']</span>';
		    echo $shortcode; 
		    break;
	    }
	}
	add_action( 'manage_'.TWOJ_SLIDESHOW_TYPE_POST.'_posts_custom_column' , 'twoj_custom_columns', 10, 2 );
}

if(!function_exists('add_twoj_table_columns')){
	function add_twoj_table_columns($columns) { 
		return array_merge($columns, array('twoj_slideshow' => __('Shortcode'),)); 
	}
	add_filter('manage_'.TWOJ_SLIDESHOW_TYPE_POST.'_posts_columns' , 'add_twoj_table_columns');
}

if(!function_exists('twoj_slideshow_list')){
	function twoj_slideshow_list (){
		if(!defined ('TWOJ_SLIDESHOW_VERSION')) return;
		wp_enqueue_script('twoj-slideshow-list', TWOJ_SLIDESHOW_URL.'js/admin/list.js', array( 'jquery' ), TWOJ_SLIDESHOW_VERSION, true ); 
			
		wp_enqueue_style ('twoj-slideshow-list', TWOJ_SLIDESHOW_URL.'css/admin/list.css', array( ), TWOJ_SLIDESHOW_VERSION );
	}
	add_action( 'in_admin_header', 'twoj_slideshow_list' );
}