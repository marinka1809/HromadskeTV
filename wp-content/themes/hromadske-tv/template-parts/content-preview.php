<?php
/**
 * Template part for displaying posts preview
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

?>
<li>
    <article id="post-<?php the_ID(); ?>" <?php post_class('news'); ?> >
        <div class="info-news">
            <?php
                $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
                if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
                    $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
                }

                $time_string = sprintf( $time_string,
                    esc_attr( get_the_date( 'c' ) ),
                    esc_html( get_the_date() ),
                    esc_attr( get_the_modified_date( 'c' ) ),
                    esc_html( get_the_modified_date() )
                );
            ?>
            <a href="<?php  get_permalink();?>" rel="bookmark"> <?php echo $time_string?> </a>
            <?php if ( get_post_meta($post->ID,'important')):
                $important = "important" ?>
                <span class="important-label">Важливо</span>
            <?php endif;?>
            <?php if ( get_post_meta($post->ID,'updated')):?>
                <span class="updated-label">Оновлено</span>
            <?php endif;?>
        </div>
        <h2 class="<?php echo $important;?>" >
           <a href="<?php the_permalink(); ?>">
               <?php the_title();?>
               <?php if ( get_post_meta($post->ID,'video')):?>
                   <span class="fa fa-video-camera" aria-hidden="true"></span>
               <?php endif; ?>
           </a>
        </h2>
    </article><!-- #post-## -->
</li>