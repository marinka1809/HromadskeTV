<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

$size_metabox = new_cmb2_box( array(
    'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'size_metabox',
    'title' 		=> twoj_slideshow_t('Size Slideshow' , 'twoj_slideshow' ),
    'object_types' 	=> array( TWOJ_SLIDESHOW_TYPE_POST ),
    'cmb_styles' 	=> false,
    'show_names'	=> false,
    'context' 		=> 'normal',
    'priority' 		=> 'high',
    'closed'        => twoj_slideshow_set_checkbox_default_for_new_post(0),
));

$size_metabox->add_field( array('type' => 'toolbox'));

$size_metabox->add_field( array(
	'name' 			=> twoj_slideshow_t('Size ', 'twoj_slideshow'),
	'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'size',
	'type' 			=> 'multisize',
	'default'		=> 
		array( 
				'width'=> 100, 
				'widthType'=> twoj_slideshow_set_checkbox_default_for_new_post('1'), 
				'height'=> '', 
				'heightType'=>'0'
	),
	'bootstrap_style'=> 1,
	'before_row' 	=> ' <br />
<div class="twoj_block">'
	//'level'			=> !TWOJ_SLIDESHOW_PRO,	
));

$size_metabox->add_field( array(
	'name' 			=> twoj_slideshow_t('Min Size ', 'twoj_slideshow'),
	'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'minsize',
	'type' 			=> 'multisize',
	'default'		=> array( 'width'=> 300, 'widthType'=>'0', 'height'=> '', 'heightType'=>'0'),
	'bootstrap_style'=> 1,
	//'level'			=> !TWOJ_SLIDESHOW_PRO,	
));

$size_metabox->add_field( array(
	'name' 			=> twoj_slideshow_t('Max Size ', 'twoj_slideshow'),
	'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'maxsize',
	'type' 			=> 'multisize',
	'default'		=> array( 'width'=> 100, 'widthType'=> twoj_slideshow_set_checkbox_default_for_new_post('1'), 'height'=> '', 'heightType'=>'0'),
	'bootstrap_style'=> 1,
	//'level'			=> !TWOJ_SLIDESHOW_PRO,
	
));

$size_metabox->add_field( array(
    'name'    => twoj_slideshow_t('Ratio','twoj_slideshow'),
    'default' => '800/600',
    'small'   => 1,
    'id'	  => TWOJ_SLIDESHOW_PREFIX .'ratio',
    'type'    => 'twojtext',
    'desc' 	  => '[ example 4/3 or 16/9]'
));

$size_metabox->add_field( array(
    'name'    	=> twoj_slideshow_t(' Image Fit','twoj_slideshow'),
    'default' 	=> 'contain',
    'options'	=> array( 
    		'contain' 	=> 'contain' , 
    		'cover'		=> 'cover' , 
    		'scaledown' => 'scaledown' ,
    		'none' 		=> 'none' ,
    	),
    'id'	  	=> TWOJ_SLIDESHOW_PREFIX .'fit',
    'type'    	=> 'twojselectbutton',
));

$size_metabox->add_field( array(
	'name' 			=> twoj_slideshow_t('Images Space', 'twoj_slideshow' ),
	'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'margin',
	'type' 			=> 'slider',
	'bootstrap_style'=> 1,
	'default'		=> twoj_slideshow_set_checkbox_default_for_new_post(2),
	'min'			=> 0,
	'max'			=> 200,
	'addons'		=> 'px.',
));

$size_metabox->add_field( array(
	'name' 			=> twoj_slideshow_t('Thumb Space', 'twoj_slideshow' ),
	'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'thumbmargin',
	'type' 			=> 'slider',
	'bootstrap_style'=> 1,
	'default'		=> twoj_slideshow_set_checkbox_default_for_new_post(2),
	'min'			=> 0,
	'max'			=> 50,
	'addons'		=> 'px.',
	'after_row' 	=> '
</div>',
));

