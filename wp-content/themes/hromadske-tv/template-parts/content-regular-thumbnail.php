<?php
/**
 * Template part for displaying stories preview Big Thumbnail.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

?>
<li class="col-xs-6 col-md-3" data-href="<?php the_permalink(); ?>" >
    <article id="stories-<?php the_ID(); ?>" <?php post_class('stories'); ?> >
        <?php the_post_thumbnail(); ?>
        <h2> <?php the_title();?> </h2>
        <?php the_excerpt();?>
    </article><!-- #post-## -->
</li>