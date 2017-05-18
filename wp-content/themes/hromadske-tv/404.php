<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package hromadske-tv
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="error-404-content" role="main">

			<section class="error-404">
                <div class="container">
                    <h1>404</h1>
                    <p><?php esc_html_e( 'Page not found', 'hromadske-tv' ); ?></p>
                    <a class="link-front-page" href="/"><?php esc_html_e( 'On home page', 'hromadske-tv' ); ?></a>
                </div>
			</section><!-- .error-404 -->


            <?php get_template_part( 'template-parts/social-section' );?>


            <?php get_template_part( 'template-parts/important-news' );?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
