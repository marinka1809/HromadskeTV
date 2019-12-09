<?php 
/*  
 * 2J SlideShow		http://2joomla.net/wordpress
 * Author:            2J Team  http://2joomla.net
 * License:           GPL-2.0+
 */

$infowide_metabox = new_cmb2_box( array(
    'id'            => TWOJ_SLIDESHOW_PREFIX.'infowide_metabox',
    'title'         => twoj_slideshow_t('Get Premium version','twoj_slideshow'),
    'object_types'  => array( TWOJ_SLIDESHOW_TYPE_POST ),
    'context'       => 'normal',
    'closed'        => twoj_slideshow_set_checkbox_default_for_new_post(0),
));

$infowide_metabox->add_field( array(
    'id'            => TWOJ_SLIDESHOW_PREFIX.'infoWide',
    'type'          => 'title',
    'before_row'    => '<div class="twoj_infoblock">'
    						.'<div class="twoj_infoSmall twoj_getproversion_blank">'.twoj_slideshow_t( 'Get Unlimited Functionality in Premium version' , 'twoj_slideshow' ).'</div>'
    					.'</div>'
));