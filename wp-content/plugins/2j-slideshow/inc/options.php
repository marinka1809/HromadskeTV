<?php 
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

if ( ! defined( 'ABSPATH' ) ) exit;

class Twoj_Slideshow_Options {

	private $active_tab = '';

	function __construct(){
		$this->init();
	}


	function init(){
		$this->hooks();
	}

	function hooks(){
		add_action( 'admin_init', array( $this, 'settings') );
		add_action('admin_menu', array( $this, 'menu') ) ;
	}

	function menu(){
		add_submenu_page( 'edit.php?post_type='.TWOJ_SLIDESHOW_TYPE_POST, '2J SlideShow Options', 'Options', 'manage_options', 'twoj-slideshow-options', array( $this, 'page') );
	}


	function settings(){

		register_setting( 'twoj_slideshow_options_main', TWOJ_SLIDESHOW_PREFIX.'font' );

		register_setting( 'twoj_slideshow_options_post', TWOJ_SLIDESHOW_PREFIX.'postShowText' );
		register_setting( 'twoj_slideshow_options_post', TWOJ_SLIDESHOW_PREFIX.'cloneBlock' );
		
		register_setting( 'twoj_slideshow_options_seo', TWOJ_SLIDESHOW_PREFIX.'seo' );
		
	}

	function tabs( ){
		echo '
		<h2 class="nav-tab-wrapper">
		    <a href="edit.php?post_type='.TWOJ_SLIDESHOW_TYPE_POST.'&page=twoj-slideshow-options&tab=main" class="nav-tab '.( $this->active_tab == 'main' ? 'nav-tab-active' : '' ).'">
		    	'.__('General Options', '2j-slideshow').'
		    </a>
		    <a href="edit.php?post_type='.TWOJ_SLIDESHOW_TYPE_POST.'&page=twoj-slideshow-options&tab=post" class="nav-tab '.( $this->active_tab == 'post' ? 'nav-tab-active' : '' ).'">
		    	'.__('New Slideshow Options', '2j-slideshow').'
		    </a>
		    <a href="edit.php?post_type='.TWOJ_SLIDESHOW_TYPE_POST.'&page=twoj-slideshow-options&tab=seo" class="nav-tab '.( $this->active_tab == 'seo' ? 'nav-tab-active' : '' ).'">
		    	'.__('Optimization', '2j-slideshow').'
		    </a>
		</h2>';
	}



	function enqueue(){
		wp_enqueue_style ( 	'robosoft-gallery-about', TWOJ_SLIDESHOW_URL.'css/admin/about.css', array( ), TWOJ_SLIDESHOW_VERSION );		
	}


	function page(){
		
		$this->enqueue();

		$this->active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'main';

		echo '
		<div class="wrap">
			<h1>'.__('2J Slideshow Options', '2j-slideshow').'</h1>';
		
		settings_errors();

		$this->tabs();

		echo '<form method="post" action="options.php?tab='.$this->active_tab.'">';
			
			echo '<table class="form-table">';

		    if( $this->active_tab == 'main' ) {
		    	settings_fields( 'twoj_slideshow_options_main' ); 
				do_settings_sections( 'twoj_slideshow_options_main' ); 
		        $this->mainOptions();
		    } elseif( $this->active_tab == 'post' ) {
		    	settings_fields( 'twoj_slideshow_options_post' ); 
				do_settings_sections( 'twoj_slideshow_options_post' ); 
		        $this->postOptions();
		    } else {
		    	settings_fields( 'twoj_slideshow_options_seo' ); 
				do_settings_sections( 'twoj_slideshow_options_seo' ); 
		        $this->seoOptions();
		    } 
		    
		    echo '</table>';

			submit_button();

		echo '
			</form>
		</div>';
	}



	function mainOptions(){
		 ?>
			<tr>
				<th scope="row"><?php _e('Font Awesome', '2j-slideshow'); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e('Font Awesome', '2j-slideshow'); ?></span></legend>
						<label title='<?php _e('Load'); ?>'>
							<input type='radio' name='<?php echo TWOJ_SLIDESHOW_PREFIX.'font'; ?>' value='on' <?php if( get_option(TWOJ_SLIDESHOW_PREFIX.'font', 'on')=='on' ) echo " checked='checked'";?> /> <?php _e('Load'); ?>
						</label><br />
						<label title='<?php _e('Don\'t load', '2j-slideshow'); ?>'>
							<input type='radio' name='<?php echo TWOJ_SLIDESHOW_PREFIX.'font'; ?>' value='off' <?php if( get_option(TWOJ_SLIDESHOW_PREFIX.'font')=='off' ) echo " checked='checked'";?>  /> <?php _e('Don\'t load', '2j-slideshow'); ?>
						</label>
						<p class="description">[ <?php _e('for the case if Your theme already have awesome fonts loaded', '2j-slideshow'); ?>' ]</p>
					</fieldset>
				</td>
			</tr>
			
		<?php
	}


	function postOptions(){
		?>
			<tr>
				<th scope="row"><?php _e('Text Block', '2j-slideshow'); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e('Show Text', '2j-slideshow'); ?></span></legend>
						<label title='<?php _e('Show'); ?>'>
							<input type='radio' name='<?php echo TWOJ_SLIDESHOW_PREFIX.'postShowText'; ?>' value='0' <?php if( !get_option(TWOJ_SLIDESHOW_PREFIX.'postShowText', '') ) echo " checked='checked'"; ?> /> <?php _e('Show'); ?>
						</label><br />
						<label title='<?php _e('Hide'); ?>'>
							<input type='radio' name='<?php echo TWOJ_SLIDESHOW_PREFIX.'postShowText'; ?>' value='1' <?php if( get_option(TWOJ_SLIDESHOW_PREFIX.'postShowText')=='1' ) echo " checked='checked'"; ?>  /> <?php _e('Hide'); ?>
						</label><br />			
					</fieldset>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php _e('Clone Block', '2j-slideshow'); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e('Show Clone Block', '2j-slideshow'); ?></span></legend>
						<label title='<?php _e('Show'); ?>'>
							<input type='radio' name='<?php echo TWOJ_SLIDESHOW_PREFIX.'cloneBlock'; ?>' value='0' <?php if( !get_option(TWOJ_SLIDESHOW_PREFIX.'cloneBlock', '') ) echo " checked='checked'"; ?> /> <?php _e('Show'); ?>
						</label><br />
						<label title='<?php _e('Hide'); ?>'>
							<input type='radio' name='<?php echo TWOJ_SLIDESHOW_PREFIX.'cloneBlock'; ?>' value='1' <?php if( get_option(TWOJ_SLIDESHOW_PREFIX.'cloneBlock')=='1' ) echo " checked='checked'"; ?>  /> <?php _e('Hide'); ?>
						</label><br />			
					</fieldset>
				</td>
			</tr>
		<?php
	}


	function seoOptions(){
		?>
			<tr>
				<th scope="row"><?php _e('Add SEO content', '2j-slideshow'); ?></th>
				<td>
					<fieldset>
						<legend class="screen-reader-text"><span><?php _e('Enable [thumbs]', '2j-slideshow'); ?></span></legend>
						<label title='<?php _e('Enable [thumbs]', '2j-slideshow'); ?>'>
							<input type='radio' name='<?php echo TWOJ_SLIDESHOW_PREFIX.'seo'; ?>' value='2' <?php if( get_option(TWOJ_SLIDESHOW_PREFIX.'seo')=='2' ) echo " checked='checked'"; ?> /> <?php _e('Enable [thumbs]', '2j-slideshow'); ?>
						</label><br />

						<legend class="screen-reader-text"><span><?php _e('Enable [thumbs + link]', '2j-slideshow'); ?></span></legend>
						<label title='<?php _e('Enable [thumbs + link]', '2j-slideshow'); ?>'>
							<input type='radio' name='<?php echo TWOJ_SLIDESHOW_PREFIX.'seo'; ?>' value='1' <?php if( get_option(TWOJ_SLIDESHOW_PREFIX.'seo')=='1' ) echo " checked='checked'"; ?> /> <?php _e('Enable [thumbs + link]', '2j-slideshow'); ?>
						</label><br />

						<label title='<?php _e('Disable'); ?>'>
							<input type='radio' name='<?php echo TWOJ_SLIDESHOW_PREFIX.'seo'; ?>' value='0' <?php if( !get_option(TWOJ_SLIDESHOW_PREFIX.'seo', '') ) echo " checked='checked'"; ?>  /> <?php _e('Disable', '2j-slideshow'); ?>
						</label><br />			
					</fieldset>
				</td>
			</tr>

		<?php
	}

}
		
$options = new Twoj_Slideshow_Options();
