<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

if(!defined('WPINC'))die;
if(!defined("ABSPATH"))exit;

define('TWOJ_SLIDESHOW_PREFIX',    'twojs_');
define('TWOJ_SLIDESHOW_TYPE_POST', 'twoj_slideshow_post');
define('TWOJ_SLIDESHOW_ICON_PRO',  '<button type="button"  class="btn btn-success btn-xs twoj-label-pro">Premium</button>');
define('TWOJ_SLIDESHOW_LABEL_PRO', TWOJ_SLIDESHOW_ICON_PRO);

class Slideshow2J {
	private static $instance = null;

	private $id;
	
	public $default_settings = array();
	
	public $version = TWOJ_SLIDESHOW_VERSION;

	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self;
		}
		return self::$instance;
	}

	function __construct() {

	}

	public function inc($filesForInclude, $path = ''){
		$filesArray = array();
		
		if(!$path) $path = TWOJ_SLIDESHOW_INCLUDES_PATH;

		if(empty($filesForInclude)) return;
		
		if( !is_array($filesForInclude) ){
			$filesArray[] = $filesForInclude;
		} else {
			$filesArray = $filesForInclude;
		}
		
		for ($i=0; $i < count($filesArray); $i++) { 
			$item = $filesArray[$i];
			if( file_exists($path.$item) ) require_once $path.$item;
		}
	}

	function checkCurrentState($new_edit = null){
        global $pagenow;
        if (!is_admin()) return false;
        if($new_edit == "list")             return in_array( $pagenow, array( 'edit.php',  ) );
            elseif($new_edit == "edit")     return in_array( $pagenow, array( 'post.php' ) );
                elseif($new_edit == "new")  return in_array( $pagenow, array( 'post-new.php' ) );
                    else  return in_array( $pagenow, array( 'post.php', 'post-new.php', 'edit.php' ) );
    }
}

Slideshow2J::get_instance();

if(!function_exists('twoj_slideshow_include')){
	function twoj_slideshow_include( $filesForInclude, $path = '' ){
		$filesArray = array();
		
		if(!$path) $path = TWOJ_SLIDESHOW_INCLUDES_PATH;

		if(empty($filesForInclude)) return ;
		
		if( !is_array($filesForInclude) ){
			$filesArray[] = $filesForInclude;
		} else {
			$filesArray = $filesForInclude;
		}
		
		for ($i=0; $i < count($filesArray); $i++) { 
			$item = $filesArray[$i];
			if( file_exists($path.$item) ) require_once $path.$item;
		}
	}
}

if(!function_exists('twoj_slideshow_t')){
	function twoj_slideshow_t( $text = '', $langDoamin = '' ){
		return __( $text, isset($langDoamin) && $langDoamin  ? $langDoamin :'2j-slideshow');
	}

	function twoj_slideshow_et( $text = '', $langDoamin = ''){
		echo twoj_slideshow_t($text , $langDoamin );
	}
}


twoj_slideshow_include( array('editor_button.php', 'widget.php') );  //, 'options.php'

twoj_slideshow_include( 'duplicate.php', TWOJ_SLIDESHOW_ADDONS_PATH);

if(!function_exists('twoj_slideshow_is_edit_page')){
    function twoj_slideshow_is_edit_page($new_edit = null){
        global $pagenow;
        if (!is_admin()) return false;
        if($new_edit == "list")             return in_array( $pagenow, array( 'edit.php',  ) );
            elseif($new_edit == "edit")     return in_array( $pagenow, array( 'post.php' ) );
                elseif($new_edit == "new")  return in_array( $pagenow, array( 'post-new.php' ) );
                    else  return in_array( $pagenow, array( 'post.php', 'post-new.php', 'edit.php' ) );
    }
}


if(!function_exists('twoj_slideshow_get_current_post_type')){
    function twoj_slideshow_get_current_post_type() {
        global $post, $typenow, $current_screen;
        if ( $post && $post->post_type )                          return $post->post_type;
          elseif( $typenow )                                      return $typenow;
          elseif( $current_screen && $current_screen->post_type ) return $current_screen->post_type;
          elseif( isset( $_REQUEST['post_type'] ) )               return sanitize_key( $_REQUEST['post_type'] );
          elseif (isset($_REQUEST['post']) && get_post_type($_REQUEST['post']))               return get_post_type($_REQUEST['post']);
        return null;
    }
}


function create_post_type_twoj_slideshow() { 

	require_once TWOJ_SLIDESHOW_INCLUDES_PATH.'update.php';
	$update = new TwojSlideshowUpdate();

    register_post_type( TWOJ_SLIDESHOW_TYPE_POST,
        array(
          'labels' => array(
            'name' => '2J Slideshow',
            'singular_name' => __( '2J SlideShow', 	'2j-slideshow' ),
            'all_items'     => __( 'SlideShows', 	'2j-slideshow' ),
            'add_new'       => __( 'Add Slideshow', '2j-slideshow' ),
            'add_new_item'  => __( 'Add Slideshow', '2j-slideshow' ),
            'edit_item'     => __( 'Edit Slideshow','2j-slideshow' ),
          ),
          'rewrite'            => array( 'slug' => 'slideshow', 'with_front' => true ),
          'public'      => true,
          'has_archive' => false,
          'hierarchical'=> true,
          'supports'    => array( 'title', 'comments'),
          'menu_icon'   => 'dashicons-images-alt',
    ));

    if ( is_admin() && get_option( 'twojs_slideshow_install_action' ) == '1' ) {
        delete_option( 'twojs_slideshow_install_action' );
        global $wp_rewrite; $wp_rewrite->flush_rules();
    }
}
add_action( 'init', 'create_post_type_twoj_slideshow' );

function twoj_slideshow_files_loading(){

	if( twoj_slideshow_get_current_post_type() == TWOJ_SLIDESHOW_TYPE_POST && twoj_slideshow_is_edit_page('list') ){
	    twoj_slideshow_include('listing.php');
	}

	if( twoj_slideshow_get_current_post_type() == TWOJ_SLIDESHOW_TYPE_POST &&  twoj_slideshow_is_edit_page('new') && !TWOJ_SLIDESHOW_PRO ){
	    if(!function_exists('twoj_slideshow_redirect')){
	    	function twoj_slideshow_redirect (){
	        	$my_wp_query = new WP_Query();
	        	$all_wp_pages = $my_wp_query->query(array( 'post_type' => TWOJ_SLIDESHOW_TYPE_POST,'post_status' => array('any','trash') ));
	        	if( count($all_wp_pages) ) wp_redirect( "edit.php?post_type=twoj_slideshow_post&showproinfo=1" );
	    	} 
	    	add_action( 'load-post-new.php', 'twoj_slideshow_redirect' ); 
	    }  
	}

	if( twoj_slideshow_get_current_post_type() == TWOJ_SLIDESHOW_TYPE_POST && !TWOJ_SLIDESHOW_PRO  ){
	    twoj_slideshow_include('topblock.php');
	}

	if( twoj_slideshow_get_current_post_type() == TWOJ_SLIDESHOW_TYPE_POST && ( twoj_slideshow_is_edit_page('new') || twoj_slideshow_is_edit_page('edit') ) ){

	    // Adding the Metabox class
	    twoj_slideshow_include('init.php', TWOJ_SLIDESHOW_CMB_PATH);

	     /* Field */
	    twoj_slideshow_include( array( 	
	    	'twoj_toolbox.php',
			'gallery/cmb-field-gallery.php', 
			'size/cmb-field-size.php',
			'color/jw-cmb2-rgba-colorpicker.php',
			'border/cmb-field-border.php',
			'switch/cmb-field-switch.php',
			'twojselect/cmb-field-twojselect.php',
			'slider/cmb-field-slider.php',
			'twojtext/cmb-field-twojtext.php',
			'twojtextarea/cmb-field-twojtextarea.php',
			'multisize/twojMultiSize.php',
			'twojselectbutton/cmb-field-twojselectbutton.php',
			'padding/twojPadding.php',

	    ), TWOJ_SLIDESHOW_CMB_FILEDS_PATH); 
	   
	    twoj_slideshow_include('edit.php');
	}

	if( is_admin() ){

		/* Fix another plugin code conflict */
		$photonic_options = get_option( 'photonic_options', array() );
		if( !isset($photonic_options['disable_editor']) || $photonic_options['disable_editor']!='on' ){
			$photonic_options['disable_editor'] = 'on';
			delete_option("photonic_options");
			add_option( 'photonic_options', $photonic_options );
		}

		twoj_slideshow_include(  array('media_fields.php', 'menu.php' )  );//, 'options.php'
	}


	twoj_slideshow_include(array('slideshow_images.php', 'helper.php', 'utils.php', 'slideshow.php', 'frontend.php' ), TWOJ_SLIDESHOW_FRONTEND_PATH);


	twoj_slideshow_include('report/report.init.php', 	TWOJ_SLIDESHOW_ADDONS_PATH);

	twoj_slideshow_include('setup/init.php', 	TWOJ_SLIDESHOW_ADDONS_PATH);

}
add_action( 'plugins_loaded', 'twoj_slideshow_files_loading' );

/* Ajax callback */

add_action( 'wp_ajax_twoj_slideshow_get_images_from_ids', 'twoj_slideshow_get_images_from_ids_callback' );
function twoj_slideshow_get_images_from_ids_callback() {
	$returnHtml = '';
	if( is_admin() && isset($_POST['idstring']) ){
		if( $idstring = trim($_POST['idstring']) ){
			$idArray = explode(',', $idstring);
			if(count($idArray)){
				for ($i=0; $i < count($idArray); $i++) { 
					if( $attachment_id = (int)$idArray[$i]  ){
						$url = wp_get_attachment_thumb_url( $attachment_id );
						if( $url ){
							$returnHtml .= '<img src="'.$url.'" /> ';
						} else _e('No url');
					} else _e('No attachment_id');
				}
			} else _e('No count');
		}
	}
	echo $returnHtml;
	wp_die(); 
}

add_action( 'wp_ajax_twoj_slideshow_get_images_from_post', 'twoj_slideshow_get_images_from_post_callback' );
function twoj_slideshow_get_images_from_post_callback() {
	$returnHtml = '';
	if( is_admin() && isset($_POST['idstring']) ){
		if( $id = (int) $_POST['idstring'] ){
			$idArray = get_post_meta( $id, TWOJ_SLIDESHOW_PREFIX.'slideshowImages', true);
			for ($i=0; $i < count($idArray); $i++) { 
				if( $attachment_id = (int)$idArray[$i]  ){
					$url = wp_get_attachment_thumb_url( $attachment_id );
					if( $url ){
						$returnHtml .= '<img src="'.$url.'" />';
					} else _e('No url');
				} else _e('No attachment_id');
			}
		}
	}
	echo $returnHtml;
	wp_die(); 
}