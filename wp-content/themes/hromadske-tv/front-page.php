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

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">
            <?php
            $args = array(
                'post_type' => 'post',
                'posts_per_page' => 1,
            );
            $firstPosts = new WP_Query($args);

            while ( $firstPosts->have_posts() ) : $firstPosts->the_post();?>
                <section class="section welcom-section" style="background-image: url('<?php echo get_field("poster_image")?>');">
                    <div class="container">
                        <h1><?php the_title(); ?></h1>
                        <p><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>"><?php echo get_theme_mod('inscription-detailed-button'); ?></a>
                    </div>
                    <?php $firstPostID = array($post->ID);
            endwhile;

            wp_reset_postdata();
            ?>

            <?php
                $args = array(
                    'post_type' => 'post',
                    'post__not_in' => $firstPostID,
                    'posts_per_page' => 5,
                );

                $recentPosts = new WP_Query($args);

                if ( $recentPosts->have_posts() ) :?>
                    <div>
                        <h2><?php echo get_theme_mod('title-news-section'); ?></h2>
                        <ul>
                            <?php while ( $recentPosts->have_posts() ) : $recentPosts->the_post();?>
                                <li>

                                    <div class="info-news">
                                        <?php the_time('d.m.Y');?>
                                        <?php if ( get_post_meta($post->ID,'important')):
                                                echo "Важливо";
                                        endif;
                                        if ( get_post_meta($post->ID,'updated')):
                                            echo "Оновлено";
                                        endif;

                                        if ( get_post_meta($post->ID,'video')):
                                        echo "Відео";
                                        endif;
                                        ?>

                                    </div>
                                    <a href="<?php the_permalink(); ?>">
                                            <?php the_title();?>
                                    </a>
                                </li>
                            <?php endwhile;  ?>
                        </ul>
                    <div>
                <?php endif;
            wp_reset_postdata();
            ?>
            </section>
            <?php
            $args = array(
                'post_type' => 'post',
                'meta_key'  => 'important',
                    'post__not_in' => $firstPostID,
                'posts_per_page' => 4,
            );

            $importantPosts = new WP_Query($args);

            if ( $importantPosts->have_posts() ) :?>
            <section class="section">
                <div class="container">
                    <h1><?php echo get_theme_mod('title-important-news-section'); ?></h1>
                    <a class="link-all-articles" href=""> <?php echo get_theme_mod('inscription-button-all-articles'); ?></a>
                    <ul class="row">
                        <?php while ( $importantPosts->have_posts() ) : $importantPosts->the_post();?>
                            <li class="col-sm-3">
                                <div class="item-important-posts" data-href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail();?>
                                    <h3><?php the_title();?></h3>
                                    <?php the_excerpt();?>
                                </div>
                            </li>
                        <?php endwhile;  ?>
                    </ul>
                </div>
            <section>
            <?php endif;
                wp_reset_postdata();
            ?>

            <?php
            $args = array(
                'post_type' => 'stories',
                'posts_per_page' => 1,
            );
            $firstStories = new WP_Query($args);

            while ( $firstStories->have_posts() ) : $firstStories->the_post();?>
            <section class="section front-story-section" style="background-image: url('<?php echo get_the_post_thumbnail_url() ?>');">
                <div class="container">
                    <h1><?php echo get_theme_mod('title-stories-section'); ?></h1>
                    <a class="link-all-articles" href="/stories"> <?php echo get_theme_mod('inscription-button-all-articles'); ?></a>
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>"><?php echo get_theme_mod('inscription-detailed-button'); ?></a>
                </div>
            </section>
                <?php endwhile;

                wp_reset_postdata();
                ?>

            <section class="section">
                <div class="container">
                    <h1><?php echo get_theme_mod('title-donate-section'); ?></h1>
                    <a class="linl-donate" href="<?php echo get_page_link(get_theme_mod('page-donate') ); ?>">
                        <?php echo get_theme_mod('inscription-donate'); ?>
                    </a>
                </div>
            </section>

            <?php
            $args = array(
                'taxonomy'      => array( 'projects' ),
                'orderby'       => 'count',
                'order'         => 'DESC',
                'fields'        => 'all',
                'hide_empty'    => false,
                'number'        => 3,
            );
            $projects_query = new WP_Term_Query( $args );
            if ( $projects_query->terms ) :?>
                <section class="section front-project-section" >
                    <div class="container">
                        <h1><?php echo get_theme_mod('title-project-section'); ?></h1>
                        <a class="link-all-articles" href="/projects"> <?php echo get_theme_mod('inscription-button-all-articles'); ?></a>
                        <ul class="row">
                            <?php foreach( $projects_query->terms as $project ){
                                $image = get_field('image_project', $project);?>
                                <li class="col-md-4">
                                    <?php if( !empty($image) ): ?>
                                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                    <?php endif; ?>
                                    <h3><?php echo $project->name; ?></h3>
                                    <p><?php echo $project->description; ?></p>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </section>
            <?php endif;?>
            <?phpwp_reset_postdata();?>

                <section class="section">
                    <div class="container">
                        <h1><?php echo get_theme_mod('title-social-section'); ?></h1>

                    </div>
                </section>


		</main><!-- #main -->
	</div><!-- #primary -->

<?php

get_footer();
