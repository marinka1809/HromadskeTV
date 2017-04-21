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

        <?php add_filter('the_content', 'wpse_ad_content');

        function wpse_ad_content($content)
        {
            $tag_block ='';
            if( has_term('', 'post_tag', $post->ID) ):
                $tag_block = '<div class="tags-list">'  . get_the_term_list( $post->ID, 'post_tag', '', '', '' ) .'</div>';
            elseif ( has_term('', 'stories-tags', $post->ID) ):
                $tag_block.= '<div class="tags-list">';
                $tag_block.= get_the_term_list( $post->ID, 'stories-tags', '', '', '' );
                $tag_block.='</div>';
            elseif ( has_term('', 'episodes-tags', $post->ID) ):
                $tag_block = '<div class="tags-list">' . get_the_term_list( $post->ID, 'episodes-tags', '', '', '' ) .'</div>';
            endif;

            $content = explode('<div class="et_social_inline et_social_mobile_on et_social_inline_bottom">', $content, 2);
            $new_content = $content[0] .$tag_block .'<div class="et_social_inline et_social_mobile_on et_social_inline_bottom">'  .$content[1];

        return $new_content;
        }?>

        <?php get_template_part( 'template-parts/content');?>
        <?php get_template_part( 'template-parts/related', get_post_type());?>

    <?php endwhile; // End of the loop.    ?>
</main><!-- #main -->

<?php
get_footer();
