<?php
/**
 * Template part for displaying posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header
    <?php if ( get_post_meta($post->ID,'content-cap', 1)=='image'):
        if (get_post_type()== post):
            $image = get_field("poster_image");?>
            class="article-header img-header"  style="background: url('<?php echo $image['url']; ?>') 50% 50% no-repeat; background-size: cover">
            <div class="bg-dark">
        <?php  else : ?>
            class="article-header img-header"  style="background: url('<?php the_post_thumbnail_url(); ?>') 50% 50% no-repeat; background-size: cover">
            <div class="bg-dark">
        <?php  endif; ?>
    <?php elseif (get_post_meta($post->ID,'content-cap', 1)=='video'): ?>
        class="article-header video-header">
    <?php else : ?>
        class="article-header clear-header">
    <?php endif; ?>
        <div class="header-wrap">
          <h1> <?php the_title(); ?> </h1>
          <?php the_excerpt(); ?>
            <?php


            $time_string = '<time class="entry-date published updated" datetime="%1$s"> %2$s </time>';

            $time_string = sprintf( $time_string,
                esc_attr( get_the_date( 'c' ) ),
                date_i18n( 'l, d F Y',  strtotime( get_the_date( ) ) )
            );
            ?>
            <?php echo $time_string ;?>
        </div>
        <?php if (get_post_meta($post->ID,'content-cap', 1)=='video'): ?>
           <div class="video-wrap">
               <?php $videoID = get_post_meta($post->ID,'url-video', 1); ?>
               <?php echo wp_oembed_get( $videoID, array('width' => 970));?>
           </div>
        <?php elseif ( get_post_meta($post->ID,'content-cap', 1)=='image'): ?>
            </div>
        <?php endif; ?>
    </header>

