<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hromadske-tv
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link href="https://fonts.googleapis.com/css?family=Merriweather:400,400i,700i" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700,800" rel="stylesheet">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>
    <div id="page" class="site">
        <header id="masthead" class="site-header" role="banner">
            <div class="container">
                <div class="flex-block">
                    <div class="site-branding">
                        <?php
                        $custom_logo_id = get_theme_mod( 'custom_logo' );
                        $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                        if ( is_front_page() || is_home() ) : ?>
                            <h1 class="site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <?php if ( has_custom_logo() ) {
                                    echo '<img src="'. esc_url( $logo[0] ) .'">';
                                    }?>
                                    <?php bloginfo( 'name' ); ?>
                                </a>
                            </h1>
                        <?php else : ?>
                            <p class="site-title">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                    <?php if ( has_custom_logo() ) {
                                        echo '<img src="'. esc_url( $logo[0] ) .'">';
                                    }?>
                                    <?php bloginfo( 'name' ); ?>
                                </a>
                            </p>
                        <?php
                        endif; ?>
                    </div><!-- .site-branding -->

                    <nav id="site-navigation" class="main-navigation" role="navigation">
                        <?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
                    </nav><!-- #site-navigation -->


                    <a id="menu-search" class="icon-search" href="#"></a>
                    <?php get_search_form()?>

                    <div class="toggle-container" id="toggle-container">
                        <input class="burger-check" id="burger-check" type="checkbox">
                        <label for="burger-check" class="burger"></label>
                        <div class="toggle-menu">
                            <?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'primary-menu' ) ); ?>
                            <?php get_search_form()?>
                            <?php get_template_part( 'template-parts/social-link' ); ?>
                            <a class="link-donate" href="<?php echo get_page_link(get_theme_mod('page-donate') ); ?>"><?php echo get_theme_mod('inscription-donate'); ?></a>
                        </div>
                    </div>


                </div>
            </div><!-- .container -->
        </header><!-- #masthead -->
        <div class="fade-screen"></div>
        <div id="content" class="site-content">
