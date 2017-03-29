<?php
/**
 * The template for displaying taxonomy
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

get_header();
$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$image = get_field('image_project', $term);?>


<section class="title-section" style="background: url('<?php echo $image['url']; ?>') 50% 50% no-repeat; background-size: cover;">
    <div class="container"?>
        <?php
        $tax = get_taxonomy( get_queried_object()->taxonomy );
        /* translators: Taxonomy term archive title. 1: Taxonomy singular name, 2: Current taxonomy term */
        $title = $tax->labels->singular_name;
        //echo $title;?>
        <h1> <?php echo $term->name; ?> </h1>
        <p><?php echo $term->description; ?> </p>
    </div>
</section>
<main class="container">

    <?php if ( have_posts() ) : ?>
        <ul class="row list-episodes">
            <?php
            /* Start the Loop */
            while ( have_posts() ) : the_post();?>
                <?php if ( get_post_meta($post->ID,'big-thumbnail')):?>
                    <?php get_template_part( 'template-parts/content', 'big-thumbnail' );?>
                <?php else: ?>
                    <?php get_template_part( 'template-parts/content', 'regular-thumbnail' );?>
                <?php endif; ?>
            <?php endwhile;?>
        </ul>
        <?php the_posts_navigation();
    else :
        get_template_part( 'template-parts/content', 'none' );
    endif; ?>
</main><!-- #main -->
<?php
get_footer();