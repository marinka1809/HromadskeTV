<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hromadske-tv
 */

?>

	</div><!-- #content -->

    <a href="#" id="up" style="background: #ffffff url('<?php echo get_theme_mod( 'scroll-up' ) ?>') 50% 50% no-repeat; "></a>

	<footer id="colophon" class="site-footer" role="contentinfo" >
        <div class="container">
            <div class="site-info-top">
                <?php dynamic_sidebar( 'footer-menu' ); ?>
                <a class="link-donate" href="<?php echo get_page_link(get_theme_mod('page-donate') ); ?>">
                    <?php echo get_theme_mod('inscription-donate'); ?>
                </a>
            </div>
            <div class="site-info">
                    <p class="site-title">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                            <?php if ( has_custom_logo() ) {
                                echo '<img src="'. get_theme_mod( 'footer-logo' ) .'">';
                            }?>
                            <?php bloginfo( 'name' ); ?>
                        </a>
                    </p>
                    <?php get_template_part( 'template-parts/social-link' ); ?>

                    <p class="copyright">Copyright &copy; <?php echo date('Y'); ?></p>
            </div><!-- .site-info -->
        </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
