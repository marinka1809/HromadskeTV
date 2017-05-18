<?php
/**
 * Template part for displaying stories preview Big Thumbnail.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

?>
<li class="col-md-6">
    <article class="big" id="<?php the_ID(); ?>" style="background: url('<?php the_post_thumbnail_url(); ?>') 50% 50% no-repeat; background-size: cover;">
        <a class="dark-bg" href="<?php the_permalink(); ?>">
            <h2> <?php the_title();?> </h2>
            <p><?php the_excerpt_max_charlength(165); ?></p>
        </a>
    </article>
</li>