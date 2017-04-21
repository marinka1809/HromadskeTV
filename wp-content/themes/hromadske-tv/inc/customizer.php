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

    /**
     * Front page
     */

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

    /**
     * Social link
     */
    $customizer->add_section(
        'social-links-section',
        array(
            'title' => esc_html__( 'Social links section', 'hromadske-tv' ),
            'description' => esc_html__( 'If you need to add a link to the site, add the address in the appropriate field, if the link is not needed just do not fill the field.', 'hromadske-tv' )
        )
    );

    $customizer->add_setting(
        'vk-link',
        array('default' => '')
    );
    $customizer->add_control(
        'vk-link',
        array(
            'label' => esc_html__('Vk:', 'hromadske-tv' ) ,
            'section' => 'social-links-section',
            'type' => 'url',
        )
    );

    $customizer->add_setting(
        'facebook-link',
        array('default' => '')
    );
    $customizer->add_control(
        'facebook-link',
        array(
            'label' => esc_html__('Facebook:', 'hromadske-tv' ) ,
            'section' => 'social-links-section',
            'type' => 'url',
        )
    );

    $customizer->add_setting(
        'google-link',
        array('default' => '')
    );
    $customizer->add_control(
        'google-link',
        array(
            'label' => esc_html__('Google +:', 'hromadske-tv' ) ,
            'section' => 'social-links-section',
            'type' => 'url',
        )
    );

    $customizer->add_setting(
        'youtube-link',
        array('default' => '')
    );
    $customizer->add_control(
        'youtube-link',
        array(
            'label' => esc_html__('Youtube:', 'hromadske-tv' ) ,
            'section' => 'social-links-section',
            'type' => 'url',
        )
    );

    $customizer->add_setting(
        'tumblr-link',
        array('default' => '')
    );
    $customizer->add_control(
        'tumblr-link',
        array(
            'label' => esc_html__('Tumblr:', 'hromadske-tv' ) ,
            'section' => 'social-links-section',
            'type' => 'url',
        )
    );

    $customizer->add_setting(
        'rss-link',
        array('default' => '')
    );
    $customizer->add_control(
        'rss-link',
        array(
            'label' => esc_html__('RSS:', 'hromadske-tv' ) ,
            'section' => 'social-links-section',
            'type' => 'url',
        )
    );

    $customizer->add_setting(
        'twitter-link',
        array('default' => '')
    );
    $customizer->add_control(
        'twitter-link',
        array(
            'label' => esc_html__('Twitter:', 'hromadske-tv' ) ,
            'section' => 'social-links-section',
            'type' => 'url',
        )
    );

    /**
     * Project page
     */
    $customizer->add_section(
        'project-page-settings',
        array(
            'title' => esc_html__( 'Project page settings', 'hromadske-tv' ),
        )
    );

    $customizer->add_setting(
        'series-for-big-thumbnail',
        array('default' => '1')
    );

    $customizer->add_control(
        'series-for-big-thumbnail',
        array(
            'label' => esc_html__('From which series to begin to display big thumbnail:', 'hromadske-tv' ) ,
            'section' => 'project-page-settings',
            'type' => 'select',
            'choices' => array("1", "2", "3",),
        )
    );

    /**
     * News
     */
    $customizer->add_section(
        'news-settings',
        array(
            'title' => esc_html__( 'News settings', 'hromadske-tv' ),
        )
    );

    $customizer->add_setting(
        'label-important-news',
        array('default' => 'Важливо')
    );

    $customizer->add_control(
        'label-important-news',
        array(
            'label' => esc_html__('Label for important news:', 'hromadske-tv' ) ,
            'section' => 'news-settings',
            'type' => 'text',
        )
    );

    $customizer->add_setting(
        'label-updated-news',
        array('default' => 'Оновлено')
    );

    $customizer->add_control(
        'label-updated-news',
        array(
            'label' => esc_html__('Label for updated news:', 'hromadske-tv' ) ,
            'section' => 'news-settings',
            'type' => 'text',
        )
    );

    $customizer->add_setting(
        'video-icon',
        array('default' => 'fa-video-camera')
    );

    $customizer->add_control(
        'video-icon',
        array(
            'label' => esc_html__('Icon for news with video:', 'hromadske-tv' ) ,
            'description' => esc_html__('Insert here the class icons with Font Awesome','hromadske-tv' ) ,
            'section' => 'news-settings',
            'type' => 'text',
        )
    );

    $customizer->add_setting(
        'label-news-button',
        array('default' => 'Більше новин')
    );
    $customizer->add_control(
        'label-news-button',
        array(
            'label' => esc_html__( 'Inscription for type button more news.', 'hromadske-tv' ),
            'section' => 'news-settings',
            'type' => 'text'
        )
    );

    $customizer->add_setting(
        'title-related-posts',
        array('default' => 'Читайте також')
    );
    $customizer->add_control(
        'title-related-posts',
        array(
            'label' => esc_html__( 'Title for section Related posts', 'hromadske-tv' ),
            'section' => 'news-settings',
            'type' => 'text'
        )
    );

    //--------------Footer-logo--------------------------

    $customizer->add_setting('footer-logo');
    $customizer->add_control(
        new WP_Customize_Image_Control(
            $customizer,
            'background-page-title',
            array(
                'label' => 'Logo for footer',
                'section' => 'title_tagline',
                'settings' => 'footer-logo'
            )
        )
    );
});



