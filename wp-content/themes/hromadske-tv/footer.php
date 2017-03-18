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
            <?php wp_nav_menu( array( 'theme_location' => 'menu-1', 'menu_id' => 'footer-menu' ) ); ?>

            <a class="linl-donate" href="<?php echo get_page_link(get_theme_mod('page-donate') ); ?>">
                <?php echo get_theme_mod('inscription-donate'); ?>
            </a>
        </div>
		<div class="site-info">

		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
