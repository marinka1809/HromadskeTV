<?php
/**
Template Name: News sent
 */

get_header(); ?>

    <div id="primary" class="content-area">
        <main id="main" class="news-sent-content" role="main">
            <?php
            while ( have_posts() ) : the_post();?>
                <section class="news-sent">
                    <div class="container">
                        <h1><?php the_title();?> </h1>
                        <?php the_content(); ?>
                        <a class="link-front-page" href="/"><?php esc_html_e( 'On home page', 'hromadske-tv' ); ?></a>
                    </div>
                </section>
            <?php endwhile; // End of the loop.
            ?>

            <?php get_template_part( 'template-parts/social-section' );?>


            <?php get_template_part( 'template-parts/important-news' );?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_footer();
