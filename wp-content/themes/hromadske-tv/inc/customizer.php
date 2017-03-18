<?php
/**
 * hromadske-tv Theme Customizer
 *
 * @package hromadske-tv
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function hromadske_tv_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'hromadske_tv_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function hromadske_tv_customize_preview_js() {
	wp_enqueue_script( 'hromadske_tv_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'hromadske_tv_customize_preview_js' );


/**
 * Adds theme settings page in the WordPress admin panel
 */


add_action('customize_register', function($customizer){

    $customizer->add_panel( 'settings-front-page', array(
        'priority' => 10,
        'capability' => 'edit_theme_options',
        'theme_supports' => '',
        'title' => esc_html__( 'Settings for front page', 'hromadske-tv' ),
        'description' => esc_html__( 'Titles and label buttons for front page.', 'hromadske-tv' ),
    ) );

    $customizer->add_section(
        'titles-section',
        array(
            'title' => esc_html__( 'Titles sections', 'hromadske-tv' ),
            'description' => esc_html__( 'Titles section for front page.', 'hromadske-tv' ),
            'panel' => 'settings-front-page'
        )
    );

    $customizer->add_setting(
        'title-news-section',
        array('default' => 'Новини')
    );
    $customizer->add_control(
        'title-news-section',
        array(
            'label' => esc_html__('Title for the last news section', 'hromadske-tv' ) ,
            'section' => 'titles-section',
            'type' => 'text',
        )
    );

    $customizer->add_setting(
        'title-important-news-section',
        array('default' => 'Важливі новини')
    );
    $customizer->add_control(
        'title-important-news-section',
        array(
            'label' => esc_html__('Title for the important news section', 'hromadske-tv' ),
            'section' => 'titles-section',
            'type' => 'text',
        )
    );

    $customizer->add_setting(
        'title-stories-section',
        array('default' => 'Історії')
    );
    $customizer->add_control(
        'title-stories-section',
        array(
            'label' => esc_html__( 'Title for the stories section', 'hromadske-tv' ) ,
            'section' => 'titles-section',
            'type' => 'text',
        )
    );

    $customizer->add_setting(
        'title-donate-section',
        array('default' => 'Підтримайте проект')
    );
    $customizer->add_control(
        'title-donate-section',
        array(
            'label' => esc_html__( 'Title for the section donate', 'hromadske-tv' ) ,
            'section' => 'titles-section',
            'type' => 'text',
        )
    );

    $customizer->add_setting(
        'title-project-section',
        array('default' => 'Проекти')
    );
    $customizer->add_control(
        'title-project-section',
        array(
            'label' => esc_html__( 'Title for the project section', 'hromadske-tv' ),
            'section' => 'titles-section',
            'type' => 'text',
        )
    );

    $customizer->add_setting(
        'title-social-section',
        array('default' => 'Будь в курсі останніх новин')
    );
    $customizer->add_control(
        'title-social-section',
        array(
            'label' => esc_html__( 'Title for the section social networking', 'hromadske-tv' ),
            'section' => 'titles-section',
            'type' => 'text',
        )
    );
    $customizer->add_section(
        'button-donations',
        array(
            'title' => esc_html__( 'Button donations', 'hromadske-tv' ),
            'panel' => 'settings-front-page'
        )
    );

    $customizer->add_setting(
        'inscription-donate',
        array('default' => 'Donate')
    );
    $customizer->add_control(
        'inscription-donate',
        array(
            'label' => esc_html__( 'Inscription:', 'hromadske-tv' ),
            'section' => 'button-donations',
            'type' => 'text',
        )
    );

    $customizer->add_setting(
        'page-donate'
    );
    $customizer->add_control(
        'page-donate',
        array(
            'label' => esc_html__( 'Select page:', 'hromadske-tv' ),
            'section' => 'button-donations',
            'type' => 'dropdown-pages'
        )
    );

    $customizer->add_section(
        'button-labels',
        array(
            'title' => esc_html__( 'Button labels', 'hromadske-tv' ),
            'panel' => 'settings-front-page'
        )
    );

    $customizer->add_setting(
        'inscription-detailed-button',
        array('default' => 'Детальніше')
    );
    $customizer->add_control(
        'inscription-detailed-button',
        array(
            'label' => esc_html__( 'Inscription for type buttons: continue reading the article.', 'hromadske-tv' ),
            'section' => 'button-labels',
            'type' => 'text'
        )
    );

    $customizer->add_setting(
        'inscription-button-all-articles',
        array('default' => 'Всі')
    );
    $customizer->add_control(
        'inscription-button-all-articles',
        array(
            'label' => esc_html__( 'Inscription for type buttons: see all articles of this type', 'hromadske-tv' ),
            'section' => 'button-labels',
            'type' => 'text'
        )
    );




});



