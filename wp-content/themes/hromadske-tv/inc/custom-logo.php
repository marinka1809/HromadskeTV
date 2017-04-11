<?php
/**
 * Sample implementation of the Custom Logo feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php  the_custom_logo(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-logo/
 *
 * @package hromadske-tv
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses hromadske_tv_header_style()
 */
function hromadske_tv_custom_logo_setup() {
	add_theme_support( 'custom-logo', array(
        'default-image'          => '',
		'default-text-color'     => '000000',
		'width'                  => 194,
		'height'                 => 50,
		'flex-height'            => true,
        'header-text' => array( 'site-title', 'site-description' )
	) ) ;
}
add_action( 'after_setup_theme', 'hromadske_tv_custom_logo_setup' );


