<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

$animation_metabox = new_cmb2_box( array(
    'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'animation_metabox',
    'title' 		=> twoj_slideshow_t( 'Animation', 'twoj_slideshow' ),
    'object_types' 	=> array( TWOJ_SLIDESHOW_TYPE_POST ),
    'show_names' 	=> false,
    'context' 		=> 'normal',
   	'closed'        => twoj_slideshow_set_checkbox_default_for_new_post(0),
));

$animation_metabox->add_field( array(
    'name'    	=> twoj_slideshow_t('Effect','twoj_slideshow'),
    'default' 	=> 'slide',
    'options'	=> array( 
    		'slide' 	=> 'Slide' , 
    		'crossfade'	=> 'Crossfade' , 
    		'dissolve' 	=> 'Dissolve' , 
    	),
    'id'	  	=> TWOJ_SLIDESHOW_PREFIX .'transition',
    'type'    	=> 'twojselectbutton',
    'before_row'	=> '<br/>
<div class="twoj_block">',
));

$animation_metabox->add_field( array(
	'name' 			=> twoj_slideshow_t('Effect Duration', 'twoj_slideshow' ),
	'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'transitionduration',
	'type' 			=> 'slider',
	'bootstrap_style'=> 1,
	'default'		=> twoj_slideshow_set_checkbox_default_for_new_post(300),
	'min'			=> 0,
	'max'			=> 2000,
	'addons'		=> 'ms.',
));

$animation_metabox->add_field( array(
	'name' 			=> 	twoj_slideshow_t('Loop', 'twoj_slideshow' ),
	'id' 			=> 	TWOJ_SLIDESHOW_PREFIX . 'loop',
	'type' 			=> 	'switch',
	'bootstrap_style'=> 1,
	'default'		=> 	twoj_slideshow_set_checkbox_default_for_new_post(1),
));

$animation_metabox->add_field( array(
	'name' 			=> 	twoj_slideshow_t('AutoPlay', 'twoj_slideshow' ),
	'id' 			=> 	TWOJ_SLIDESHOW_PREFIX . 'autoplay',
	'type' 			=> 	'switch',
	'depends' 		=> 	'.twoj_slideshow_autoplay',
	'bootstrap_style'=> 1,
	'default'		=> 	twoj_slideshow_set_checkbox_default_for_new_post(1),
	'after_row'		=> '<div class="twoj_slideshow_autoplay">'
));

$animation_metabox->add_field( array(
	'name' 			=> twoj_slideshow_t('AutoPlay Timer', 'twoj_slideshow' ),
	'id' 			=> TWOJ_SLIDESHOW_PREFIX . 'timer',
	'type' 			=> 'slider',
	'bootstrap_style'=> 1,
	'default'		=> twoj_slideshow_set_checkbox_default_for_new_post(5000),
	'min'			=> 0,
	'max'			=> 10000,
	'addons'		=> 'ms.',
));

$animation_metabox->add_field( array(
	'name' 			=> 	twoj_slideshow_t('AutoPlay stop on touch', 'twoj_slideshow' ),
	'id' 			=> 	TWOJ_SLIDESHOW_PREFIX . 'autoplaystop',
	'type' 			=> 	'switch',
	//'depends' 		=> 	'.twoj_size_width, .twoj_size_height',
	'bootstrap_style'=> 1,
	'default'		=> 	twoj_slideshow_set_checkbox_default_for_new_post(1),
	'after_row'		=> '</div>
</div>'
));
