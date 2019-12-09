<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

define( 'twoj_slideshow_URL', plugin_dir_url( __FILE__ ) );

function twoj_slideshow_field( $field, $meta ) {
	wp_enqueue_script( 'twoj_slideshow_init', twoj_slideshow_URL . 'js/script.js', array( 'jquery' ), null );
	wp_enqueue_style( 'twoj_slideshow_style', twoj_slideshow_URL . 'css/style.css', array(), '', 'all' );

	if ( ! empty( $meta ) ) {
		$meta = implode( ',', $meta );
	} else $meta = ' ';

	echo '<div class="pw-gallery twoj_block twoj_button_block">';
	echo '	<p class="cmb2-metabox-description">' . twoj_slideshow_t( 'Here you can find all necessary tools to manage your slideshow images and shortcode', 'twoj_slideshow' ) . '</p>';
	echo '	<input type="hidden" class="pw-gallary-value" id="' . $field->args( 'id' ) . '" name="' . $field->args( 'id' ) . '" value="' . $meta . '" />';
	echo '	<button id="twoj_slides" class="btn btn-primary btn-lg '.(isset($_GET['show_media_editor'])?'2j_slideshow_open_media':'').'"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> '.twoj_slideshow_t('Manage Slides', 'twoj_slideshow' ).'</button>';
	if( TWOJ_SLIDESHOW_PRO != 1 ){
		if( TWOJ_SLIDESHOW_MESSAGE == 1 ){
			echo '	<button class="btn btn-success btn-lg twoj_getproversionforfree_blank twoj_button_padding"><span class="glyphicon glyphicon-gift"></span> ' . twoj_slideshow_t( 'Get Premium for Free', 'twoj_slideshow') . ' </button>';
		} else {
			echo '	<button class="btn btn-success btn-lg twoj_getproversion_blank twoj_button_padding"><span class="glyphicon glyphicon-gift"></span> ' . twoj_slideshow_t( 'Upgrade to Premium', 'twoj_slideshow') . ' </button>';
		}
	}
	echo '	<button id="twoj_2jslideshow_getshortcode" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-tag"></span> '.twoj_slideshow_t('Get ShortCode', 'twoj_slideshow').' </button>';
	echo '	<p class="cmb2-metabox-description">'.twoj_slideshow_t('Resources manager help you to upload, sort, resize, rotate slideshow images. Also at the same place you can add all additional parameters for every image: description, caption, link, video link, description styling and alignment.', 'twoj_slideshow').'</p>';
	echo '	<div id="twoj_slideshow_image_view"><span class="spinner is-active" style="margin-right: 50%;"></span></div>';
	echo '</div>';
	echo '
	<div id="twoj_showShortCodeDialog" style="display: none;" data-open="0" data-title="'.twoj_slideshow_t( '2J Slideshow ShortCode', 'twoj_slideshow' ).'" data-close="'.twoj_slideshow_t('Close', 'twoj_slideshow').'">
		<div id="cmb2-metabox-twojs_shortcode_metabox" class="cmb2-metabox cmb-field-list"><div class="twoj_shortcode">[2jslideshow '.(isset($_GET['post'])&&$_GET['post']?$_GET['post']:'-').']</div>
			<div class="desc">'.twoj_slideshow_t('use this shortcode to insert this slideshow into post', 'twoj_slideshow').'</div>
		</div>
	</div>';
}
add_filter( 'cmb2_render_twoj_slideshow', 'twoj_slideshow_field', 10, 2 );


function twoj_slideshow_field_sanitise( $meta_value, $field ) {
	if ( empty( $meta_value ) ) {
		$meta_value = '';
	} else {
		$meta_value = explode( ',', $meta_value );
	}
	return $meta_value;
}

