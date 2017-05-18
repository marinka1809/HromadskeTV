<?php
/**
 * Template part for displaying stories preview Big Thumbnail.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

?>
<li class="col-xs-6 col-md-3">
    <article class="regular" id="<?php the_ID(); ?>">
        <a href="<?php the_permalink(); ?>">
            <div class="img-wrapper">
                <?php the_post_thumbnail('thumbnails'); ?>
            </div>
            <h2> <?php the_title();?> </h2>
            <?php the_excerpt();?>
        </a>
    </article>
</li>