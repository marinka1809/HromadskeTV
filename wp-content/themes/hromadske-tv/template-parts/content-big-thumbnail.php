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
    <article class="big" id="<?php the_ID(); ?>" style="background: url('<?php the_post_thumbnail_url(); ?>') 50% 50% no-repeat; background-size: cover;">
        <div class="dark-bg">
            <h2> <?php the_title();?> </h2>
            <p><?php the_excerpt_max_charlength(165); ?></p>
        </div>
    </article>
</li>