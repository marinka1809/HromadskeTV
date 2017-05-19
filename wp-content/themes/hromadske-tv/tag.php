<?php
/**
 * The template for displaying tag pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package hromadske-tv
 */

get_header();?>


    <main id="main" class="archive-content" role="main">

        <?php
        if ( have_posts() ) : ?>

            <header>
                <div class="container">
                   <?php $title = sprintf( __( '#%s' ), single_tag_title( '', false ) );  ?>
                   <h1> <?php echo $title;  ?> </h1>
                </div>
            </header><!-- .page-header -->

            <div class="container">
            <ul class="row list-stories">

                <?php while ( have_posts() ) : the_post();

                    get_template_part( 'template-parts/content', 'regular-thumbnail' );

                endwhile;?>
            </ul>
            <div class="blog-nav">
                <?php echo paginate_links(array(
                       // 'total'        => $queryStories->max_num_pages,
                        'prev_text'    => __('<'),
                        'next_text'    => __('>'),
                        'mid_size'     => 2,
                    )
                );?>
            </div>
            </div>

        <?php else :
            get_template_part( 'template-parts/content', 'none' );
        endif; ?>

    </main<!-- #main -->

<?php
get_footer();
