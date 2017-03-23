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

	<footer id="colophon" class="site-footer" role="contentinfo" style="background: #b9b9b9">
        <div class="container">

            <?php dynamic_sidebar( 'footer-menu' ); ?>
            <a class="linl-donate" href="<?php echo get_page_link(get_theme_mod('page-donate') ); ?>">
                <?php echo get_theme_mod('inscription-donate'); ?>
            </a>
        </div>
		<div class="site-info">
            <div class="container">
                <?php  $custom_logo_id = get_theme_mod( 'custom_logo' );
                $logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );?>
                <p class="site-title">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                        <?php if ( has_custom_logo() ) {
                            echo '<img src="'. esc_url( $logo[0] ) .'">';
                        }?>
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </p>
                <?php get_template_part( 'template-parts/social-link' ); ?>

                <p>Copyright &copy; <?php echo date('Y'); ?></p>
            </div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
