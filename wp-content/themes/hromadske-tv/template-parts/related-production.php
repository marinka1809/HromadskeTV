<?php $tags = wp_get_post_terms( $post->ID, 'production-tags');
if ($tags) :
    $tag_ids = array();
    foreach($tags as $individual_tag) {$tag_ids[] = $individual_tag->term_id;}
    $args = array(
        'tax_query' => array(
            array(
                'taxonomy' => 'production-tags',
                'field'    => 'term_id',
                'terms'    => $tag_ids,
            ),
        ),
        'orderby'=>rand,
        'post__not_in' => array($post->ID),
        'posts_per_page' => 4,
    );
    $relatedPosts = new WP_Query($args);

    if ( $relatedPosts->have_posts() ) : ?>
        <section class="related-post">
            <div class="container">
                <h2><?php echo get_theme_mod('title-related-posts'); ?></h2>
                <ul class="row ">
                    <?php while ( $relatedPosts->have_posts() ) : $relatedPosts->the_post();
                        ?>
                        <li class="col-sm-6 col-md-3 related-item" >
                            <a class="item-wrapper" href="<?php the_permalink(); ?>">
                                <div class="img-wrapper">
                                    <?php  the_post_thumbnail('thumbnails');?>
                                </div>
                                <h3><?php the_title();?></h3>
                                <?php the_excerpt(); ?>
                            </a>
                        </li>
                    <?php endwhile;?>
                </ul>
            </div>
        </section>
    <?php endif;?>
<?php endif;
wp_reset_postdata();
?>