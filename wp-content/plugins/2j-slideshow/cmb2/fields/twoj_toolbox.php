<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

class TWOJ_TOOLBOX {

	public function hooks() {
		add_action( 'admin_enqueue_scripts', array( $this, 'twoj_setup_admin_scripts' ) );
		if(!TWOJ_SLIDESHOW_PRO) add_action( 'in_admin_header', array( $this, 'twoj_setup_admin_header' ) );
		add_action( 'in_admin_header', array( $this, 'twoj_slidehsow_setup_admin_script' ) );
	}

	public function twoj_slidehsow_setup_admin_script(){
		echo '<script>'
				.'var TWOJ_SLIDESHOW_PRO = '.TWOJ_SLIDESHOW_PRO.';'
			.'</script>';
	}

	public function twoj_setup_admin_header(){
		echo '<div id="twoj_showInformation" '
						.'style="display: none;" '
						.'data-body="twoj_edit" '
						.'data-open="0" '
						.'data-title="'.twoj_slideshow_t('2J Slideshow Premium Version').'" '
						.'data-close="'.twoj_slideshow_t('Close', 'twoj_slideshow').'" '
						.'data-info="'.twoj_slideshow_t('Get Premium Version').'"'
					.'>'
					.twoj_slideshow_t('This functionality available in Premium Version', 'twoj_slideshow')
				.'</div>';
	}

	public function twoj_setup_admin_scripts() {

		wp_enqueue_media();
		wp_enqueue_style("wp-jquery-ui-dialog");
		wp_enqueue_script('jquery-ui-dialog');
		
		if(!defined ('TWOJ_SLIDESHOW_VERSION')) return;

		if(!TWOJ_SLIDESHOW_PRO){
			wp_enqueue_script('twoj-slideshow-info', TWOJ_SLIDESHOW_URL.'js/admin/info.js', array( 'jquery' ), TWOJ_SLIDESHOW_VERSION, true ); 
			wp_enqueue_style ('twoj-slideshow-info', TWOJ_SLIDESHOW_URL.'css/admin/info.css', array( ), TWOJ_SLIDESHOW_VERSION );
		}


		$translation_array = array(
			'twoj_image_text' => twoj_slideshow_t( 'If you wish to upload more than 3 images please upgrade to PREMIUM version', 'twoj_slideshow' ),
		);
		wp_localize_script('twoj-toolbox-admin-edit', 'twoj_slideshow_trans', $translation_array );
		wp_enqueue_script( 'twoj-toolbox-admin-edit' );

		wp_enqueue_style ( 'twoj-toolbox-admin-edit',  TWOJ_SLIDESHOW_URL.'css/admin/edit.css' );


		//bootstrap
		wp_enqueue_script( 	'twoj_bootstrap', 			TWOJ_SLIDESHOW_URL.'addons/bootstrap/js/bootstrap.min.js', 		array('jquery'), TWOJ_SLIDESHOW_VERSION, true);
		wp_enqueue_style ( 	'twoj_bootstrap', 			TWOJ_SLIDESHOW_URL.'addons/bootstrap/css/bootstrap.css',			array(), TWOJ_SLIDESHOW_VERSION, 'all');
		//wp_enqueue_style ( 'twoj_bootstrap_theme', 	TWOJ_SLIDESHOW_URL.'addons/bootstrap/bootstrap-theme.css' );

		//checkbox
		wp_enqueue_script( 'twoj-toolbox-toggles-js', 	TWOJ_SLIDESHOW_URL.'addons/toggles/js/bootstrap-toggle.js', 	array( 'jquery' ), TWOJ_SLIDESHOW_VERSION, true );
		wp_enqueue_style(  'twoj-toolbox-toggles-css',	TWOJ_SLIDESHOW_URL.'addons/toggles/css/bootstrap-toggle.css', 	array(), TWOJ_SLIDESHOW_VERSION, 'all' );

		//color
		wp_enqueue_script( 'twoj-toolbox-color-tinycolor', TWOJ_SLIDESHOW_URL.'addons/color/bootstrap.colorpickersliders.tinycolor.js', 	array( 'jquery' ), TWOJ_SLIDESHOW_VERSION, true );
		wp_enqueue_script( 'twoj-toolbox-color', TWOJ_SLIDESHOW_URL.'addons/color/bootstrap.colorpickersliders.js', 						array( 'jquery' ), TWOJ_SLIDESHOW_VERSION, true );
		wp_enqueue_style( 'twoj-toolbox-color', TWOJ_SLIDESHOW_URL.'addons/color/bootstrap.colorpickersliders.css', 						array(), TWOJ_SLIDESHOW_VERSION, 'all' );

		//slider
		wp_enqueue_script( 'twoj-toolbox-bootstrap-slider', TWOJ_SLIDESHOW_URL.'addons/bootstrap-slider/js/bootstrap-slider.js', 	array( 'jquery', 'twoj_bootstrap' ), TWOJ_SLIDESHOW_VERSION, true );
		wp_enqueue_style( 'twoj-toolbox-bootstrap-slider', TWOJ_SLIDESHOW_URL.'addons/bootstrap-slider/css/bootstrap-slider.css', 	array(), TWOJ_SLIDESHOW_VERSION, 'all' );
	
		//select
		wp_enqueue_script('twoj-toolbox-bootstrap-select', TWOJ_SLIDESHOW_URL.'addons/bootstrap-select/js/bootstrap-select.js', 	array( 'jquery' ), TWOJ_SLIDESHOW_VERSION, true );
		wp_enqueue_style( 'twoj-toolbox-bootstrap-select', TWOJ_SLIDESHOW_URL.'addons/bootstrap-select/css/bootstrap-select.css', 	array(), TWOJ_SLIDESHOW_VERSION, 'all' );
		
				//admin.base
		wp_register_script( 'twoj-toolbox-admin-edit', TWOJ_SLIDESHOW_URL.'js/admin/edit.js', 	array( 'jquery' ,'twoj-toolbox-bootstrap-slider' ), TWOJ_SLIDESHOW_VERSION, true );
		
	}
}
$twoj_tololbox = new TWOJ_TOOLBOX();
$twoj_tololbox->hooks();