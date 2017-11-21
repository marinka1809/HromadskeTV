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
        <?php get_template_part( 'template-parts/title-post');?>

        <?php ?>

<!--        --><?php //add_filter('the_content', 'wpse_ad_content');

//        function wpse_ad_content($content)
//        {
//           
//
//            $content = explode('<div class="getsocial gs-inline-group', $content, 2);
//            $new_content = $content[0] .$tag_block .'<div class="getsocial gs-inline-group'  .$content[1];
//
//        return $new_content;
//        }?>

        <?php get_template_part( 'template-parts/content');?>
        <?php get_template_part( 'template-parts/related', get_post_type());?>

    <?php endwhile; // End of the loop.    ?>
</main><!-- #main -->

<?php
get_footer();
