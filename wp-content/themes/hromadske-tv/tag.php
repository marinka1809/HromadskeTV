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
                <div class="tablet blog-nav">
                    <?php echo paginate_links(array(
                            'prev_text'    => '<',
                            'next_text'    => '>',
                            'mid_size'     => 2,
                        )
                    );?>
                </div>
                <div class="mobile blog-nav">
                    <?php echo paginate_links(array(
                            'prev_text'    => '<span> < </span><span>' .__( 'Prev', 'hromadske-tv' ) .'</span>',
                            'next_text'    => '<span>' .__('Next', 'hromadske-tv' ) .'</span><span> > </span>',
                            'mid_size'     => 0,
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
