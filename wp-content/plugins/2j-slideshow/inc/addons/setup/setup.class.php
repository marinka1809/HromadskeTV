<?php


class TwoJSlideshowSetup{

	public $api	= 'https://2joomla.net/setup/update.php';

	function __construct(){
		if( strpos($_SERVER['REQUEST_URI'], '/wp-admin/plugins.php') !== false ){
			add_action('admin_footer',			array($this, 'popup') );
			add_action('admin_enqueue_scripts', array($this, 'includes') );
		}
		add_action('wp_ajax_twoj_slideshow_setup',	array($this, 'twoj_slideshow_setup') );
	}
	
	public function includes(){
		
		wp_enqueue_script('twoj_slideshow_setup-js', plugin_dir_url( __FILE__ ) . 'js/setup.js', array('jquery'), false, true );		
		wp_enqueue_style('twoj_slideshow_setup-css', plugin_dir_url( __FILE__ ) . 'css/setup.css', false, '1.0', 'all');
		
		wp_localize_script('twoj_slideshow_setup-js', 'twoj_slideshow_setup',  array(
				'slug'		=> '2j-slideshow',
				'ajax'		=> admin_url( 'admin-ajax.php' ),
				'skip'		=> __('Skip & Deactivate'),
				'submit'	=> __('Submit & Deactivate'),
		));
		
	}
	
	public function twoj_slideshow_setup(){
		if( isset( $_POST['plugin'] ) )
			deactivate_plugins( $_POST['plugin'] );
		
		if( isset( $_POST['check'] ) ){
			$message = '';
			if( isset($_POST['twoj_slideshow_setup-msg-better-plugin']) && $_POST['twoj_slideshow_setup-msg-better-plugin'] )  $message .= 'Plugin:'.$_POST['twoj_slideshow_setup-msg-better-plugin'].'|';
			if( isset($_POST['twoj_slideshow_setup-msg-other']) && $_POST['twoj_slideshow_setup-msg-other'] )  $message .= 'Other:'.$_POST['twoj_slideshow_setup-msg-other'].'|';
			$this->curl( $_POST['check'], $message );
		}
		
		wp_die();
	}
	
	private function curl( $check, $msg = '' ){
		if( $Curl = curl_init() ){		
			curl_setopt_array(
				$Curl, array(
					CURLOPT_URL 			=> 	$this->api.'?'.http_build_query( array( 'check'=> $check, 'msg' => $msg ) ),
					CURLOPT_HEADER			=>	false,
					CURLOPT_RETURNTRANSFER 	=> 	true,
					CURLOPT_CONNECTTIMEOUT	=>	1,
					CURLOPT_SSL_VERIFYPEER  => false  ,
				)
			);
			$data = curl_exec($Curl);
			curl_close($Curl);
		}		
		return $data;
	}
	
	public function popup(){
		include_once dirname(__FILE__) . '/tpl/popup.php';
	}

}


?>