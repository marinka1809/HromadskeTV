<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

class twojSlideshow extends twojSlideshowUtils{

 	public $id = 0;
 	public $options_id = 0;
 	public $real_id = 0;

 	public $returnHtml = '';
 	public $options = array();
 	
 	public $mainBlockData = array( );
 	public $twojBorderStyle = '';
	
	public $twojWrapStyle = '';
	public $twojMainStyle = '';

	public $twojStageStyle = '';
	public $twojNavStyle = '';

 	public $twojBoxStyle = '';
	public $twojBoxHoverStyle = '';

 	public $javaScriptStyle = '';

 	public $slideshowId = '';
 	public $helper = '';

 	public $selectImages = null;
 	
 	public $thumbsource = 'medium';

 	public $caption = '';

 	function __construct($attr){
 		$this->helper 		= new twojHelper();
 		$this->slideshowId 	= 'twoj_slideshow_'.uniqid();
 		

 		$id = 0;
 		if( isset($attr) ){
 			if( 		isset($attr['id'])  && ( (int) $attr['id'] )   ) 	$id = (int) $attr['id'];
 			else if( 	isset($attr[0]) 	&& ( (int) $attr[0] )  ) 		$id = (int) $attr[0];
 		} 
 		
 		if( $id ){

			$this->id = $id;
			$options_id = (int) get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'options', true );
			if($options_id){
				$this->real_id = $this->id;
				$this->options_id = $options_id;
				$this->id = $options_id;
			}
			$this->helper->setId( $this->id );
 		}
 	}
 	
 	function twoj_slideshow_styles() {		
		wp_enqueue_style( 'twoj-slideshow', TWOJ_SLIDESHOW_URL.'css/slideshow.css', 	array(), TWOJ_SLIDESHOW_VERSION, 'all' );
		wp_enqueue_style( 'twoj-slideshow-desc', TWOJ_SLIDESHOW_URL.'css/desc.css', 	array(), TWOJ_SLIDESHOW_VERSION, 'all' );
			
	}

	function twoj_slideshow_scripts() {
		//wp_enqueue_script( 'jquery', false, array(), false, true);
		wp_enqueue_script( 'twoj-rbjquer', 		TWOJ_SLIDESHOW_URL.'js/rbjquer.min.js', 	array(), TWOJ_SLIDESHOW_VERSION );
		wp_enqueue_script( 'twoj-slideshow', 	TWOJ_SLIDESHOW_URL.'js/slideshow.min.js', 	array('twoj-rbjquer'), TWOJ_SLIDESHOW_VERSION );
	}	

	public function addJavaScriptStyle($styleValue, $styleName = '', $hover='1'){
		if(isset($this->{$styleValue.'Style'}) && $this->{$styleValue.'Style'} ){
			$this->javaScriptStyle.= ($hover!=2?'#'.$this->slideshowId.' ':'').$styleName.'{'.$this->{$styleValue.'Style'}.'}';
		}
		if( $hover==1 && isset($this->{$styleValue.'HoverStyle'}) && $this->{$styleValue.'HoverStyle'} ){
			$this->javaScriptStyle.= '#'.$this->slideshowId.' '.$styleName.':hover{'.$this->{$styleValue.'HoverStyle'}.'}';
		}
	}

 	function getSizeValue($option, $name, $param = ''){
 		$returnOption = '';
 		$widthType = ( isset($option[$name.'Type']) && $option[$name.'Type']==1 ?'%':'');
 		if( isset($option[$name]) ){
			$returnOption .= ' data-'.$param.$name.'="'.(int)$option[$name].$widthType.'"';
		}
		return $returnOption;
 	}

 	function getSize( $option, $param = '' ){
 		$returnOption = '';
 		$returnOption .= $this->getSizeValue( $option, 'width', $param );
 		$returnOption .= $this->getSizeValue( $option, 'height', $param );
		return $returnOption;
 	}

 	public function getSlideshow( ){
 		if( !$this->id ) return ''; 


 		$count_key = 'views';
		$countView = (int) get_post_meta($this->id, $count_key, true);
		if( !$countView){
		    $countView = 0;
		    delete_post_meta($this->id, $count_key);
		    add_post_meta($this->id, $count_key, '0');
		}
		$countView++;
		update_post_meta($this->id, $count_key, $countView);


 		$size = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'size', true );
 		$this->mainBlockData[] = $this->getSize($size);

 		$size = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'minsize', true );
 		$this->mainBlockData[] = $this->getSize($size, 'min');
 		
 		$size = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'maxsize', true );
 		$this->mainBlockData[] = $this->getSize($size, 'max');
 		
 		if( $ratio = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'ratio', true ) ) $this->mainBlockData[] = ' data-ratio="'.$ratio.'"';

 		$slideshowImages = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'slideshowImages', true );
 		if( !$slideshowImages || !is_array( $slideshowImages ) || !count($slideshowImages) || !(int)$slideshowImages[0] ) return '';

 		$this->caption = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'caption', true );

 		if($this->pro){
			$this->getNavType();
		} else {
			$this->mainBlockData[] = ' data-nav="dots"';
		}

		if( get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'navPos', true ) ) $this->mainBlockData[] = ' data-navposition="top"';
		
		$fullscreen = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'fullscreen', true );
		if(!$fullscreen && $fullscreen!='false' ) $fullscreen = 'true';
		$this->mainBlockData[] = 'data-allowfullscreen="'.$fullscreen.'"';	
		
		if($this->pro){
			$this->getClick();
			$this->getSwipe();
		}

		if( get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'arrow', true ) ) $this->mainBlockData[] 	= ' data-arrows="true"';
		if( get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'keyboard', true ) ) $this->mainBlockData[] = ' data-keyboard="true"';

		if( $startindex = (int) get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'startindex', true ) ) $this->mainBlockData[] = ' data-startindex="'.($startindex-1).'"';
		
		if( $transition = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'transition', true ) ){
			$this->mainBlockData[] = ' data-transition="'.$transition.'"';
		}

		$this->mainBlockData[] = ' data-transitionduration="'.(int)get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'transitionduration', true ).'"';

		if($loop = (int) get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'loop', true ) ) $this->mainBlockData[] = ' data-loop="'.$loop.'"';

		if(  get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'autoplay', true ) && $timer = (int) get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'timer', true ) ){
			$this->mainBlockData[] = ' data-autoplay="'.$timer.'"';
			if( get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'autoplaystop', true )  ) $this->mainBlockData[] = ' data-stopautoplayontouch="true"';
		}

		if( $fit = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'fit', true ) ){
			$this->mainBlockData[] = ' data-fit="'.$fit.'"';
		}

		$this->mainBlockData[] = ' data-margin="'.(int)get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'margin', true ).'"';
		$this->mainBlockData[] = ' data-thumbmargin="'.(int)get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'thumbmargin', true ).'"';

		if( get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'border', true ) ){
			$borderOptions = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'border-options', true );
			if(isset($borderOptions['width'])) $this->mainBlockData[]  = ' data-thumbborderwidth="'.$borderOptions['width'].'"';
			if(isset($borderOptions['color'])) $this->twojBorderStyle .= 'border-color: '.$borderOptions['color'].';';
			if(isset($borderOptions['style'])) $this->twojBorderStyle .= 'border-style: '.$borderOptions['style'].';';
		} else  {
			$this->mainBlockData[]  = ' data-thumbborderwidth="0"';
		}

		if($this->pro){
			$this->setAlign();
		}
		

		$paddingCustom = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'paddingCustom', true );
		if( isset($paddingCustom['left']) 	&& $paddingCustom['left'] ) 	$this->twojMainStyle .= 'margin-left:'.		$paddingCustom['left']	.(strpos($paddingCustom['left'], '%')	?'':'px').';';
		if( isset($paddingCustom['top']) 	&& $paddingCustom['top'] ) 		$this->twojMainStyle .= 'margin-top:'.		$paddingCustom['top']	.(strpos($paddingCustom['top'], '%')	?'':'px').';';
		if( isset($paddingCustom['right']) 	&& $paddingCustom['right'] ) 	$this->twojMainStyle .= 'margin-right:'.	$paddingCustom['right']	.(strpos($paddingCustom['right'], '%')	?'':'px').';';
		if( isset($paddingCustom['bottom']) && $paddingCustom['bottom'] ) 	$this->twojMainStyle .= 'margin-bottom:'.	$paddingCustom['bottom'].(strpos($paddingCustom['bottom'], '%')	?'':'px').';';

		if( get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'bg', true )){
			$this->twojStageStyle 	.='background-color:'	.get_post_meta( $this->id,  TWOJ_SLIDESHOW_PREFIX.'bgColor', true )		.';';
			$this->twojNavStyle 	.= 'background-color: '	.get_post_meta( $this->id,  TWOJ_SLIDESHOW_PREFIX.'bgNavColor', true )	.';';
		}

		if( get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'rtl', true )){
		 	$this->mainBlockData[] = ' data-direction="rtl" ';
		}

		$this->addJavaScriptStyle('twojBorder', '.twoj_slideshow__thumb-border');
		$this->addJavaScriptStyle('twojWrap', '>.twoj_slideshow__wrap');
		$this->addJavaScriptStyle('twojMain', ' ');
		$this->addJavaScriptStyle('twojStage', '.twoj_slideshow__stage');
		$this->addJavaScriptStyle('twojNav', '.twoj_slideshow__nav__shaft');

		$sizeType = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'sizeType', true );

		$width = 120;  $height = 60;

		$size = get_post_meta( $this->id, TWOJ_SLIDESHOW_PREFIX.'thumb-size-options', true );
		if( count($size) ){
			if( isset($size['width'])  ) 	$width = (int) 	$size['width']; 	else $width = 120;
			if( isset($size['height']) ) 	$height = (int) $size['height']; 	else $height = 60;
		}

		$this->mainBlockData[] = ' data-thumbwidth="'.$width.'" ';
		$this->mainBlockData[] = ' data-thumbheight="'.$height.'" ';

		if($this->pro){
			$this->getSource($size);
		}
		
		if($this->options_id){
			$this->id = $this->real_id;
		}
		$this->selectImages = new twojSlideshowImages($this->id);
		if($this->options_id){
			$this->id = $this->options_id;
		}


		$this->selectImages->setSize( $width , $height, $this->thumbsource );
		$this->selectImages->getImages();

		$image_listing = '';
		
		if(count($this->selectImages->imgArray)){
			$this->twoj_slideshow_styles();
			$this->twoj_slideshow_scripts();
			for ($i=0; $i<count($this->selectImages->imgArray); $i++) {
				$img = $this->selectImages->imgArray[$i];
				$image_listing .= $this->getImage($img);
			}
		}
		
		if( $image_listing ){
			$this->returnHtml = 
				'<div id="'.$this->slideshowId.'" '
					.'class="twoj_slideshow" '
					.'data-auto="false" '
					 .implode(' ', $this->mainBlockData)
				.'>'
					.$image_listing
				.'</div>'
				.'<div style="clear: both;"></div>'.
				'<script>'.$this->compileJavaScript().'</script>';
		} 
		return $this->returnHtml;
 	}

 	function getImage($img){
 		$imageEl = "";

 		$descClass = 'twoj_desc';

 		$cleatTitle = esc_attr($img['data']->post_title);

		$captionText = $this->caption ? 'data-caption="'.$cleatTitle.'" ' :'';

		$ratio = $img['sizeW'].'/'.$img['sizeH'];
		
		if($img['typelink']==5) $img['linkoptions']=0;
		if($img['typelink']==6) $img['linkoptions']=1;

		$link = '';
		if( $img['link'] ){
			if( $img['linkoptions']==0 || $img['linkoptions']==1 ){
				$link .= ' data-link="'.$img['link'].'"';
				if( $img['linkoptions'] == 1 ) $link .= ' data-link_targer="_blank"';
			}

			if( $img['linkoptions']==2){
				$link .= ' data-link="'.str_replace('"', "'", $img['link']).'" ';
				$link .= ' data-link_targer="javascript"';
			}
		} 

		if( $img['link'] && ( $img['typelink']==1 || $img['typelink']==2) ){
			$imageEl .= '<a href="'.$img['link'].'" ' .$captionText.' data-thumbratio="'.$ratio.'" ';
				if( $img['typelink']==2 ) $imageEl .= 'data-img="'.$img['image'].'" ';
				$imageEl .= '>';
				if( $img['typelink']==2 ) $imageEl .= '<img src="'.$img['thumb'].'" alt="'.$cleatTitle.'">';
			$imageEl .='</a>';
		} else if($img['typelink']) {
			$imageEl .= 	
			'<div  '
				.$captionText
				.'data-thumb="'.$img['thumb'].'" '
				.'data-thumbratio="'.$ratio.'" '
				.$link
				.( $img['typelink'] != 3 ?' data-img="'.$img['image'].'" ':'')
				.'>'
					.( $img['typelink'] == 3 || $img['typelink'] == 4 ?
					'<div '
							.'class="'.$descClass.'_base'
							.' '.$descClass.'_'.$img['position'].$img['size']
							.' '.$descClass.'_margin'.$img['padding']       
						.'">'
						.'<div class="'.$descClass.'_header '.$descClass.'_'.$img['style'].$img['opacity'].'">'.$img['data']->post_title.'</div>'
						.'<div class="'.$descClass.'_text '.$descClass.'_'.$img['style'].$img['opacity'].'">'.$img['data']->post_content.'</div>'
					.'</div>' : '')
			.'</div>';
		} else {
			$imageEl .= 	
			'<a '
				.$link
				.' href="'.$img['image'].'" '
				.$captionText.'>'
				.($img['thumb']?'<img src="'.$img['thumb'].'"  alt="'.$cleatTitle.'" width="'.$img['sizeW'].'" height="'.$img['sizeH'].'">':'')
			.'</a>';
		}

 		return  $imageEl;
 	}
 	
 } 