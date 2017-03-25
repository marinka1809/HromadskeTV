<?php
/**
Template Name: Stories
 */
get_header();
?>

<main class="container" >
    <h1><?php single_post_title();?></h1>
    <?php
        $args = array(
        'post_type' => 'stories',
        );
        $queryStories = new WP_Query($args);
    ?>
    <?php if ( $queryStories->have_posts() ) : ?>
        <ul class="row list-stories">
            <?php /* Start the Loop */
            while ($queryStories-> have_posts() ) : $queryStories->the_post();?>
                <?php if ( get_post_meta($post->ID,'big-thumbnail')):?>
                    <?php get_template_part( 'template-parts/content', 'big-thumbnail' );?>
                <?php else: ?>
                    <?php get_template_part( 'template-parts/content', 'regular-thumbnail' );?>
                <?php endif; ?>
            <?php endwhile; ?>
        </ul>
        <?php wp_reset_postdata();?>
    <?php   else :
        get_template_part( 'template-parts/content', 'none' );
    endif; ?>
</main>

<?php
get_footer();
