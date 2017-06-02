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
        <?php if ( get_theme_mod('title-social-section')) :
            echo '<h1>' .get_theme_mod('title-social-section') .'</h1>';
        endif;  ?>

        <ul class="row">
            <?php dynamic_sidebar( 'social-sections' ); ?>
        </ul>

    </div>
</section>