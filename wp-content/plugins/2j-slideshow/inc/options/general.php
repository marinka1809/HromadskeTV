<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

$general_metabox = new_cmb2_box( array(
    'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'general_metabox',
    'title' 		=> twoj_slideshow_t( 'General', 'twoj_slideshow' ), 
    'object_types' 	=> array( TWOJ_SLIDESHOW_TYPE_POST ),
    'show_names'	=> false,
    'context' 		=> 'normal',
    'closed'        => twoj_slideshow_set_checkbox_default_for_new_post(0),
));

$general_metabox->add_field( array(
    'name'    => twoj_slideshow_t('Start Index','twoj_slideshow'),
    'default' => '',
    'small'   => 1,
    'id'	  => TWOJ_SLIDESHOW_PREFIX .'startindex',
    'type'    => 'twojtext',
    'before_row' 	=> ' <br />
<div class="twoj_block">'
));

$general_metabox->add_field( array(
    'name'    	=> twoj_slideshow_t('Align','twoj_slideshow'),
    'default' 	=> '',
    'options'	=> array( 
    		'' 		=> 'Disable', 
    		'left' 		=> 'Left', 
    		'center'	=> 'Center', 
    		'right'		=> 'Right',
    	),
    'id'	  	=> TWOJ_SLIDESHOW_PREFIX .'padding-align',
    'level'			=> !TWOJ_SLIDESHOW_PRO,
    'type'    	=> 'twojselectbutton',
));

$general_metabox->add_field( array(
	'name' 			=> twoj_slideshow_t('Padding', 'twoj_slideshow'),
	'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'paddingCustom',
	'type' 			=> 'padding',
	'default'		=> array( 'left'=> 0, 'top'=> 0, 'right'=> 0, 'bottom'=> 0),
	'bootstrap_style'=> 1,
	//'level'			=> !TWOJ_SLIDESHOW_PRO,
	
));


$general_metabox->add_field( array(
	'name' 			=> twoj_slideshow_t('RTL', 'twoj_slideshow' ),
	'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'rtl',
	'type' 			=> 'switch',
	'default'		=> twoj_slideshow_set_checkbox_default_for_new_post(0),
    'bootstrap_style'=> 1,
    'after_row' 	=> '
</div>',
));