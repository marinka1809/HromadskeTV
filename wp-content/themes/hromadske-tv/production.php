<?php
/**
Template Name: Production
 */
get_header();
?>

    <main class="container stories-page" >
        <h1><?php single_post_title();?></h1>
        <?php

        $ourCurrentPage = get_query_var('paged');
        $args = array(
            'post_type' => 'production',
            'posts_per_page' => get_theme_mod('per-page-stories'),
            'paged' => $ourCurrentPage,
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
            <div class="tablet blog-nav">
                <?php echo paginate_links(array(
                        'total'        => $queryStories->max_num_pages,
                        'prev_text'    => '<',
                        'next_text'    => '>',
                        'mid_size'     => 2,
                    )
                );?>
            </div>
            <div class="mobile blog-nav">
                <?php echo paginate_links(array(
                        'total'        => $queryStories->max_num_pages,
                        'prev_text'    => '<span> < </span><span>' .__( 'Prev', 'hromadske-tv' ) .'</span>',
                        'next_text'    => '<span>' .__('Next', 'hromadske-tv' ) .'</span><span> > </span>',
                        'mid_size'     => 0,
                    )
                );?>
            </div>
            <?php wp_reset_postdata();?>
        <?php   else :
            get_template_part( 'template-parts/content', 'none' );
        endif; ?>
    </main>

<?php
get_footer();
