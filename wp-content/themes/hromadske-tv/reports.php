<?php
/**
Template Name: Reports
 */
get_header();?>
    <main class="reports-content">
        <?php while ( have_posts() ) : the_post();?>
            <div class="container">
                <div class="row">
                    <header class="col-md-8 col-md-offset-2">
                        <h1><?php the_title();?></h1>
                        <?php the_content(); ?>
                    </header>
                    <div class="col-md-8 col-md-offset-2">
                    <?php

                    // check if the repeater field has rows of data
                    if( have_rows('upload_file') ):

                        // loop through the rows of data
                        while ( have_rows('upload_file') ) : the_row();

                        $file = get_sub_field('file');?>

                            <a class="file-link" href="<?php echo $file['url']; ?>"><?php echo $file['title']; ?></a>
                         <?php endwhile;

                    else :

                        // no rows found

                    endif;

                    ?>

                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </main>

<?php
get_footer();
