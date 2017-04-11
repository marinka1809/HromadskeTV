<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package hromadske-tv
 */

get_header(); ?>


<main id="main" class="site-main" role="main">
    <?php while ( have_posts() ) : the_post();?>

       <?php get_template_part( 'template-parts/title', get_post_type() );?>
       <?php get_template_part( 'template-parts/content');?>
    <?php endwhile; // End of the loop.    ?>
</main><!-- #main -->

<?php
get_footer();
