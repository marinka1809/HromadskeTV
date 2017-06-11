<?php
/**
 * Template part for displaying important posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */



$args = array(
    'post_type' => 'post',
    'meta_key'  => 'important',
    'post__not_in' => $firstPostID,
    'posts_per_page' => 4,
    'ignore_sticky_posts' => 1
);
$importantPosts = new WP_Query($args);

if ( $importantPosts->have_posts() ) :?>
    <section class="section important-news-section">
        <div class="container">
            <header class="section-header">
                <h1 class="tablet"><?php echo get_theme_mod('title-important-news-section'); ?></h1>
                <a class="tablet link-all-articles" href="/news"> <?php echo get_theme_mod('inscription-button-all-articles'); ?></a>

                <a class="mobile link-all-articles" href="/news"> <?php echo get_theme_mod('title-important-news-section'); ?></a>
            </header>
            <ul class="row">
                <?php while ( $importantPosts->have_posts() ) : $importantPosts->the_post();?>
                    <li class="col-sm-6 col-md-3 item-important-posts">
                        <a class="item-wrapper" href="<?php the_permalink(); ?>">
                            <div class="img-wrapper">
                                <?php  the_post_thumbnail('thumbnails');?>
                            </div>
                            <h3><?php the_title();?></h3>
                            <?php the_excerpt(); ?>
                        </a>
                    </li>
                <?php endwhile;  ?>
            </ul>
        </div>
    </section>
<?php endif;
wp_reset_postdata();      ?>