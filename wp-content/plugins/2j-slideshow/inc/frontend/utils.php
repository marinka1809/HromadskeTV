<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

if( TWOJ_SLIDESHOW_PRO != 1 ){
	class twojSlideshowParent{ public $pro = 0; }
}

class twojSlideshowUtils extends twojSlideshowParent{
	
	public function compileJavaScript(){
 		return
 		'var '.$this->slideshowId.' = {'.$this->helper->getOptionList().'}, '.$this->slideshowId.'_css = "'.$this->javaScriptStyle.'",
		head = document.head || document.getElementsByTagName("head")[0],
		style = document.createElement("style");
		style.type = "text/css";
		if (style.styleSheet) style.styleSheet.cssText = '.$this->slideshowId.'_css;
			else  style.appendChild(document.createTextNode('.$this->slideshowId.'_css));
		head.appendChild(style);';
 	}

}