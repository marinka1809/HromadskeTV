<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

get_header();?>
<div class="container">
    <div class="row">
        <main class="col-sm-9" >
            <h1><?php single_post_title();?></h1>
            <?php if ( have_posts() ) : ?>
                <ul class="list-news">
                    <?php /* Start the Loop */
                    while ( have_posts() ) : the_post();
                        get_template_part( 'template-parts/content', 'preview' );
                    endwhile; ?>
                </ul>
                <a class="link-all-articles"> <?php echo get_theme_mod('label-news-button'); ?> </a>
                <div class="blog-nav">
                    <?php
                    echo paginate_links();?>
                </div>

            <?php   else :
                get_template_part( 'template-parts/content', 'none' );
            endif; ?>
        </main>
        <?php get_sidebar();?>
    </div>
</div>

<?php
get_footer();