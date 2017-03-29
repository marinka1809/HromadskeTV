<?php
/**
 * Template part for displaying stories preview Big Thumbnail.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

?>
<li class="col-md-6" data-href="<?php the_permalink(); ?>">
    <article id="<?php the_ID(); ?>">
        <?php the_post_thumbnail(); ?>
        <div class="content">
            <h2> <?php the_title();?> </h2>
            <p><?php the_excerpt_max_charlength(165); ?></p>
        </div>
    </article><!-- #post-## -->
</li>