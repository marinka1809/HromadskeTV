<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

get_header(); ?>

<main class="container content-regular-page">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <?php
            while ( have_posts() ) : the_post();?>
                <h1><?php the_title();?></h1>
                <?php the_content(); ?>
            <?php endwhile; // End of the loop.
            ?>
        </div>
    </div>
</main><!-- #main -->

<?php
get_footer();
