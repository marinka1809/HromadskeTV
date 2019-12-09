<?php
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

$tools_metabox = new_cmb2_box( array(
    'id'            => TWOJ_SLIDESHOW_PREFIX . 'images_metabox',
    'title'         => twoj_slideshow_t( 'Tools', 'twoj_slideshow' ),
    'object_types'  => array( TWOJ_SLIDESHOW_TYPE_POST ),
    'context'       => 'normal',
    'priority'      => 'high',
    'closed'        => twoj_slideshow_set_checkbox_default_for_new_post(0),
    'show_names'	=> false,
));

$tools_metabox->add_field(array(
    'button' => twoj_slideshow_t( 'Manage Slides', 'twoj_slideshow' ),
    'id'   => TWOJ_SLIDESHOW_PREFIX . 'slideshowImages', 
    'type' => 'twoj_slideshow',
    'sanitization_cb' => 'twoj_slideshow_field_sanitise'
));