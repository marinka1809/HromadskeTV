<?php
/**
Template Name: Projects
 */
get_header();
?>

    <main class="container project-page" >
        <h1><?php single_post_title();?></h1>
        <?php
        $args = array(
            'taxonomy'      => array( 'projects' ),
            'fields'        => 'all',
            'hide_empty'    => true,
        );
        $projects_query = new WP_Term_Query( $args );
         $first_big_thumbnail = (((int)get_theme_mod('series-for-big-thumbnail')+1 )* 3)-2;
         $count_element = 1;
         $count_element_step = 1;
        ?>


        <?php  if ( $projects_query->terms ) :?>
            <ul class="row list-projects">
            <?php foreach( $projects_query->terms as $project ){
                $image = get_field('image_project', $project);?>
                <?php if ( ( $count_element == $first_big_thumbnail)||(( $count_element > $first_big_thumbnail) && ((($count_element - $first_big_thumbnail)%4)== 0))): ?>
                    <li class="tablet col-xs-12 big-item-project">
                        <a href="<?php echo get_term_link($project);?>" class="content-block" <?php if( !empty($image) ): ?>  style="background: url('<?php echo $image['url']; ?>') 50% 50% no-repeat; background-size: cover;"  <?php endif; ?> >
                            <div class="dark-bg">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <h3><?php echo $project->name; ?></h3>
                                        <p><?php echo $project->description; ?></p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li class="mobile col-xs-12 item-project">
                        <a href="<?php echo get_term_link($project);?>" class="small-content">
                            <div class="img-wrapper">
                                <?php if( !empty($image) ): ?>
                                    <?php echo wp_get_attachment_image( $image['id'], 'thumbnails' );?>
                                <?php endif; ?>
                            </div>
                            <h3><?php echo $project->name; ?></h3>
                            <p><?php echo $project->description; ?></p>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="col-xs-12 col-sm-4 item-project">
                        <a href="<?php echo get_term_link($project);?>" class="small-content">
                            <div class="img-wrapper">
                                <?php if( !empty($image) ): ?>
                                    <?php echo wp_get_attachment_image( $image['id'], 'thumbnails' );?>
                                <?php endif; ?>
                            </div>
                            <h3><?php echo $project->name; ?></h3>
                            <p><?php echo $project->description; ?></p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php $count_element ++;
             } ?>
            </ul>
            <?php wp_reset_postdata();?>
        <?php   else :
            get_template_part( 'template-parts/content', 'none' );
        endif; ?>
    </main>

<?php
get_footer();
