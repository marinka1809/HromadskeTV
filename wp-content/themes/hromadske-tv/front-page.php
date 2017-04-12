<?php
/**
 * The template for displaying front page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
            <div class="top-block">
                <?php
                $args = array(
                    'posts_per_page' => 1,
                    'post__in'  => get_option( 'sticky_posts' ),
                    'ignore_sticky_posts' => 1
                );
                $stickPosts = new WP_Query($args);

                while ( $stickPosts->have_posts() ) : $stickPosts->the_post();
                    $image = get_field("poster_image");?>

                    <section class="welcome-section" style="background: url('<?php echo $image['url']; ?>') 50% 50% no-repeat; background-size: cover;">
                        <div class="container flex-block">
                            <div class="row">
                                <div class="col-md-8">
                                    <h1><?php the_title(); ?></h1>
                                    <p><?php the_excerpt_max_charlength(165); ?></p>
                                    <a class="link-detailed" href="<?php the_permalink(); ?>"><?php echo get_theme_mod('inscription-detailed-button'); ?></a>
                                </div>
                            </div>
                        </div>
                    </section>
                    <?php $firstPostID = array($post->ID);
                endwhile;

                    wp_reset_postdata();
                ?>
                <?php
                $args = array(
                    'post_type' => 'post',
                    'post__not_in' => $firstPostID,
                    'posts_per_page' => 5,
                    'ignore_sticky_posts' => 1
                );

                $recentPosts = new WP_Query($args);

                if ( $recentPosts->have_posts() ) :?>
                <div class="last-news">
                    <div class="wrapper">
                        <h2><?php echo get_theme_mod('title-news-section'); ?></h2>
                            <?php while ( $recentPosts->have_posts() ) : $recentPosts->the_post();?>
                                <article>
                                    <div class="info-news">
                                        <span class="time"><?php the_time('d.m.Y');?></span>
                                        <?php if ( get_post_meta($post->ID,'important')):?>
                                        <span class="important-label"><?php echo get_theme_mod('label-important-news'); ?></span>
                                        <?php endif;?>
                                        <?php if ( get_post_meta($post->ID,'updated')):?>
                                            <span class="updated-label"><?php echo get_theme_mod('label-updated-news'); ?></span>
                                        <?php endif;?>
                                        <?php if ( get_post_meta($post->ID,'content-cap', 1)=='video'):?>
                                            <span class="fa <?php echo get_theme_mod('video-icon'); ?>" aria-hidden="true"></span>
                                        <?php endif; ?>
                                    </div>
                                    <a class="title
                                            <?php if ( get_post_meta($post->ID,'important')):
                                                    echo "important-title";
                                            endif; ?>"
                                       href="<?php the_permalink(); ?>">
                                        <?php the_title();?>
                                    </a>
                                </article>
                            <?php endwhile;  ?>
                    </div>
                    <div class="bottom-wrapper">
                        <a class="link-all-articles" href="/news"> <?php echo get_theme_mod('label-news-button'); ?> </a>
                    </div>
                </div>
                <?php endif;
                    wp_reset_postdata();
                ?>
            </div>

            <?php
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
                            <h1><?php echo get_theme_mod('title-important-news-section'); ?></h1>
                            <a class="link-all-articles" href="/news"> <?php echo get_theme_mod('inscription-button-all-articles'); ?></a>
                        </header>
                        <ul class="row">
                            <?php while ( $importantPosts->have_posts() ) : $importantPosts->the_post();?>
                                <li class="col-sm-6 col-md-3 item-important-posts" data-href="<?php the_permalink(); ?>">
                                    <div class="item-wrapper">
                                        <div class="img-wrapper">
                                            <?php the_post_thumbnail();?>
                                        </div>
                                        <h3><?php the_title();?></h3>
                                        <?php the_excerpt(); ?>
                                    </div>
                                </li>
                            <?php endwhile;  ?>
                        </ul>
                    </div>
                </section>
            <?php endif;
            wp_reset_postdata();      ?>

            <?php
            $args = array(
                'post_type' => 'stories',
                'posts_per_page' => 1,
                'meta_key'  => 'stick-stories',

            );
            $stickStories = new WP_Query($args);

            while ( $stickStories->have_posts() ) : $stickStories->the_post();?>
                <section class="section front-story-section" style="background: url('<?php echo get_the_post_thumbnail_url() ?>') 50% 50% no-repeat; background-size: cover">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-9">
                                <header class="section-header">
                                    <h2><?php echo get_theme_mod('title-stories-section'); ?></h2>
                                    <a class="link-all-articles" href="/all-stories"> <?php echo get_theme_mod('inscription-button-all-articles'); ?></a>
                                </header>
                                <h1><?php the_title(); ?></h1>
                                <p><?php the_excerpt_max_charlength(165); ?></p>
                                <a class="link-detailed" href="<?php the_permalink(); ?>"><?php echo get_theme_mod('inscription-detailed-button'); ?></a>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endwhile;

            wp_reset_postdata();
            ?>

            <section class="section section-donate">
                <div class="container">
                    <h1><?php echo get_theme_mod('title-donate-section'); ?></h1>
                    <a class="link-donate" href="<?php echo get_page_link(get_theme_mod('page-donate') ); ?>">
                        <?php echo get_theme_mod('inscription-donate'); ?>
                    </a>
                </div>
            </section>

            <?php
            $args = array(
                'taxonomy'      => array( 'projects' ),
                'meta_key' =>  'custom_term_meta',
                'fields'        => 'all',
                'hide_empty'    =>  false,
                'number'        => 3,
            );

            $projects_query = new WP_Term_Query( $args );

            if ( $projects_query->terms ) :
                $count = 1; ?>
                <section class="section front-project-section" >
                    <div class="container">
                        <header class="section-header">
                            <h1><?php echo get_theme_mod('title-project-section'); ?></h1>
                            <a class="link-all-articles" href="/projects"> <?php echo get_theme_mod('inscription-button-all-articles'); ?></a>
                        </header>
                        <ul class="row">
                            <?php foreach( $projects_query->terms as $project ){
                                $image = get_field('image_project', $project);
                                ?>
                                <?php if( $count==1 ):?>
                                    <li class="col-sm-12 first-item-project visible-tablet" data-href="<?php echo get_term_link($project);?>">
                                        <div class="bg" style="background: url('<?php echo $image['url']; ?>') 50% 50% no-repeat; background-size: cover;">
                                            <div class="content">
                                                <h3><?php echo $project->name; ?></h3>
                                                <p><?php echo $project->description; ?></p>
                                            </div>
                                        </div>
                                    </li>
                                <?php endif; ?>
                                <li class="col-sm-6 col-md-4 item-project <?php if( $count==1 ): echo "hidden-tablet"; endif;?>" data-href="<?php echo get_term_link($project);?>">
                                    <?php if( !empty($image) ): ?>
                                        <div class="img-wrapper">
                                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                                        </div>
                                    <?php endif; ?>
                                    <h3><?php echo $project->name; ?></h3>
                                    <p><?php echo $project->description; ?></p>
                                </li>
                            <?php
                                $count++;
                            } ?>
                        </ul>
                    </div>
                </section>
            <?php endif;?>
            <?php wp_reset_postdata();?>

            <section class="section front-social-section">
                <div class="container">
                    <h1><?php echo get_theme_mod('title-social-section'); ?></h1>
                    <ul class="row">
                        <?php dynamic_sidebar( 'social-sections' ); ?>
                    </ul>

                </div>
            </section>


        </main><!-- #main -->
	</div><!-- #primary -->
<?php
get_footer();
