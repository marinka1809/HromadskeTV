<?php 
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

function TwojSlideshowDuplicate_slideshowOnly( $post_type ){ return $post_type == TWOJ_SLIDESHOW_TYPE_POST ? true : false; }

function TwojSlideshowDuplicate_getUrl( $id = 0, $context = 'display', $draft = true ) {

	if ( !$post = get_post( $id ) ) return;
	
	if( !TwojSlideshowDuplicate_slideshowOnly($post->post_type) ) return;

	if ($draft)
		$action_name = "twoj_slideshow_duplicate_draft";
	else
		$action_name = "twoj_slideshow_duplicate";

	if ( 'display' == $context )
		$action = '?action='.$action_name.'&amp;post='.$post->ID;
	else
		$action = '?action='.$action_name.'&post='.$post->ID;

	$post_type_object = get_post_type_object( $post->post_type );
	if ( !$post_type_object ) return;

	return apply_filters( 'TwojSlideshowDuplicate_getUrl', admin_url( "admin.php". $action ), $post->ID, $context );
}

add_filter('post_row_actions', 'TwojSlideshowDuplicate_ListingLink',10,2);
add_filter('page_row_actions', 'TwojSlideshowDuplicate_ListingLink',10,2);

function TwojSlideshowDuplicate_ListingLink($actions, $post){
	if( TwojSlideshowDuplicate_slideshowOnly( $post->post_type ) ){
		$actions['clone'] 				= '<a href="'.TwojSlideshowDuplicate_getUrl( $post->ID , 'display', false)	.'" title="'.esc_attr(twoj_slideshow_t("Clone this item", 'twoj_slideshow')). '">'		.twoj_slideshow_t('Clone', 'twoj_slideshow')		.'</a>';
		$actions['edit_as_new_draft'] 	= '<a href="'.TwojSlideshowDuplicate_getUrl( $post->ID )						.'" title="'.esc_attr(twoj_slideshow_t('Copy to a new draft', 'twoj_slideshow')).'">'	.twoj_slideshow_t('New Draft', 'twoj_slideshow')	.'</a>';
	}
	return $actions;
}

function twoj_slideshow_duplicate($status = ''){
	if( 
		!( isset( $_GET['post']) || 
		isset( $_POST['post'])  || 
		( isset($_REQUEST['action']) && 'twoj_slideshow_duplicate' == $_REQUEST['action'] ) ) 
	){
		wp_die( 'No gallery to copy has been supplied!' );
	}

	$my_wp_query = new WP_Query();
	$all_wp_pages = $my_wp_query->query(array( 'post_type' => TWOJ_SLIDESHOW_TYPE_POST,'post_status' => array('any','trash') ));
	if( count($all_wp_pages) ){
		wp_redirect( "edit.php?post_type=twoj_slideshow_post&showproinfo=1" );
		exit;
	}

	$id = (isset($_GET['post']) ? $_GET['post'] : $_POST['post']);
	$post = get_post($id);

	if (isset($post) && $post!=null) {
		$new_id = TwojSlideshowDuplicateDo($post, $status);

		if ($status == ''){
			$sendback = remove_query_arg( array( 'trashed', 'untrashed', 'deleted', 'cloned', 'ids'), wp_get_referer() );
			// Redirect to the post list screen
			wp_redirect( add_query_arg( array( 'cloned' => 1, 'ids' => $post->ID), $sendback ) );
		} else {
			// Redirect to the edit screen for the new draft post
			wp_redirect( add_query_arg( array( 'cloned' => 1, 'ids' => $post->ID), admin_url( 'post.php?action=edit&post=' . $new_id ) ) );
		}
		exit;

	} else {
		wp_die('Copy creation failed, could not find original: ' . htmlspecialchars($id));
	}
}

add_action('admin_action_twoj_slideshow_duplicate', 'twoj_slideshow_duplicate');
add_action('admin_action_twoj_slideshow_duplicate_draft', 'twoj_slideshow_duplicate_draft');


function twoj_slideshow_duplicate_draft(){
	twoj_slideshow_duplicate('draft');
}


function TwojSlideshowDuplicateDo($post, $status = '', $parent_id = '') {
	global $wpdb;

	if ( !TwojSlideshowDuplicate_slideshowOnly($post->post_type) ) wp_die('Copy features for this gallery are not enabled');
		
	$post_id = $post->ID;

	$prefix = 'copy of';
	$suffix = '';
	
	$title = $post->post_title;
	if (!empty($prefix)) $prefix.= ' ';
	if (!empty($suffix)) $suffix = ' '.$suffix;
		
	$title = trim($prefix.$title.$suffix);

	if ($title == '') $title = twoj_slideshow_t('Untitled');
		
	$new_post_author = wp_get_current_user();

	$new_post = array(
		'menu_order' => $post->menu_order,
		'comment_status' => $post->comment_status,
		'ping_status' => $post->ping_status,
		'post_author' => $new_post_author->ID,
		'post_content' => addslashes($post->post_content),
		'post_content_filtered' => addslashes($post->post_content_filtered) ,			
		'post_excerpt' => addslashes($post->post_excerpt),
		'post_mime_type' => $post->post_mime_type,
		'post_parent' => $new_post_parent = empty($parent_id)? $post->post_parent : $parent_id,
		'post_password' => $post->post_password,
		'post_status' => $new_post_status = (empty($status))? $post->post_status: $status,
		'post_title' => addslashes($title),
		'post_type' => $post->post_type,
	);

	$new_post_id = wp_insert_post($new_post);

	if ( $new_post_status == 'publish' || $new_post_status == 'future' ){
		$post_name = $post->post_name;
		
		$post_name = wp_unique_post_slug($post_name, $new_post_id, $new_post_status, $post->post_type, $new_post_parent);

		$new_post = array();
		$new_post['ID'] = $new_post_id;
		$new_post['post_name'] = $post_name;

		wp_update_post( $new_post );
	}
	
	do_action( 'wp_ape_gallery_clone_gallery', $new_post_id, $post );

	delete_post_meta($new_post_id, '_wpapegallery_original');
	add_post_meta($new_post_id, '_wpapegallery_original', $post->ID);

	return $new_post_id;
}


function TwojSlideshowDuplicateMetaData($new_id, $post) {
	$post_meta_keys = get_post_custom_keys($post->ID);

	if (empty($post_meta_keys)) return;

	$meta_blacklist = array();
	$meta_blacklist = array_map('trim', $meta_blacklist);
	$meta_blacklist[] = '_wpas_done_all'; //Jetpack Publicize
	$meta_blacklist[] = '_wpas_done_'; //Jetpack Publicize
	$meta_blacklist[] = '_wpas_mess'; //Jetpack Publicize
	$meta_blacklist[] = '_edit_lock'; // edit lock
	$meta_blacklist[] = '_edit_last'; // edit lock
	$meta_keys = array_diff($post_meta_keys, $meta_blacklist);

	foreach ($meta_keys as $meta_key) {
		$meta_values = get_post_custom_values($meta_key, $post->ID);
		foreach ($meta_values as $meta_value) {
			$meta_value = maybe_unserialize($meta_value);
			add_post_meta($new_id, $meta_key, $meta_value);
		}
	}
}

add_action('wp_ape_gallery_clone_gallery', 'TwojSlideshowDuplicateMetaData', 10, 2);


add_action( 'post_submitbox_start', 'TwojSlideshowDuplicateMetaData_addCloneButton' );
function TwojSlideshowDuplicateMetaData_addCloneButton() {
	if ( isset( $_GET['post'] )){
		$id = $_GET['post'];
		$post = get_post($id);
		if( TwojSlideshowDuplicate_slideshowOnly($post->post_type)) {
	 	?>
			<div id="wpape-copy-action">
				<a class="submit_wpape_copy " href="<?php 
					echo TwojSlideshowDuplicate_getUrl( $_GET['post'] ) 
				?>"><?php twoj_slideshow_et('Copy to a new draft', 'twoj_slideshow'); ?></a>
			</div>
		<?php
		}
	}
}


add_filter('removable_query_args', 'TwojSlideshowDuplicate_RemoveArg', 10, 1);
function TwojSlideshowDuplicate_RemoveArg( $removable_query_args ){
	$removable_query_args[] = 'cloned';
	return $removable_query_args;
}