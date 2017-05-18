<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package hromadske-tv
 */

get_header(); ?>

<main class="search-page" >
    <?php get_search_form()?>
    <?php global $wp_query;?>
    <?php
    if ( have_posts() ) : ?>

        <ul class="nav nav-pills search-nav" role="tablist">
            <li role="presentation" ><a href="#all-content" aria-controls="all-content" role="tab" data-toggle="tab" id="first">Усе</a></li>
            <li role="presentation"><a href="#news-content" aria-controls="website-content" role="tab" data-toggle="tab">Новини</a></li>
            <li role="presentation"><a href="#stories-content" aria-controls="logo-content" role="tab" data-toggle="tab">Історії</a></li>
            <li role="presentation"><a href="#project-content" aria-controls="kit-content" role="tab" data-toggle="tab">Проекти</a></li>
        </ul>

        <script>
            var ajaxurl = '<?php echo admin_url('admin-ajax.php')?>';
            var search ='<?php the_search_query() ?>';
        </script>

        <div class="tab-content ">
            <div class="tab-pane fade all-search" id="all-content" role="tablist">

            </div>
            <div class="tab-pane fade news-search" id="news-content" role="tablist">

            </div>
            <div class="tab-pane fade stories-search" id="stories-content" role="tablist">

            </div>
            <div class="tab-pane fade project-search" id="project-content" role="tablist">

            </div>

        </div>
    <?php else :
        get_template_part( 'template-parts/content', 'none' );
    endif; ?>


</main><!-- #main -->

<?php
get_footer();
