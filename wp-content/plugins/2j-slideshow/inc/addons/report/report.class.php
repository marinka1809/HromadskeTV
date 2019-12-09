<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

class TwojSlideShowReport{
    protected $postType;
    protected $assetsUri;
    public function __construct($postType){
        $this->postType = $postType;
        $this->assetsUri = plugin_dir_url(__FILE__);
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));
    }

    public function enqueueScripts(){ 
        if ( 
        		twoj_slideshow_get_current_post_type() == $this->postType && 
        		twoj_slideshow_is_edit_page('list') 
        ) {
            wp_enqueue_script(
	            'twoj-slideshow-report-js',
	            $this->assetsUri . '/js/script.js',
	            array(),
	            false,
	            true
	        );
        }
    }
}
