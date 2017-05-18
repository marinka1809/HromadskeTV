<?php
/**
 * Template part for displaying social section
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */
?>

<section class="section front-social-section">
    <div class="container">
        <h1><?php echo get_theme_mod('title-social-section'); ?></h1>
        <ul class="row">
            <?php dynamic_sidebar( 'social-sections' ); ?>
        </ul>

    </div>
</section>