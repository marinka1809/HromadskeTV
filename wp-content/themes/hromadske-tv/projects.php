<?php
/**
Template Name: Projects
 */
get_header();
?>

    <main class="container" >
        <h1><?php single_post_title();?></h1>
        <?php
        $args = array(
            'taxonomy'      => array( 'projects' ),
            'orderby'       => 'name',
            'fields'        => 'all',
            'hide_empty'    => false,

        );
        $projects_query = new WP_Term_Query( $args );
         $first_big_thumbnail = (((int)get_theme_mod('series-for-big-thumbnail')+1 )* 3)-2;
         $count_element = 1;
         $count_element_step = 1;
        ?>
        <?php  if ( $projects_query->terms ) :?>
            <ul class="list-projects">
            <?php foreach( $projects_query->terms as $project ){
                $image = get_field('image_project', $project);?>
                <?php if ( ( $count_element == $first_big_thumbnail)||(( $count_element > $first_big_thumbnail) && ((($count_element - $first_big_thumbnail)%4)== 0))): ?>
                    <li class="col-xs-12 item-project" data-href="<?php echo get_term_link($project);?>">

                        <div class="content-block" <?php if( !empty($image) ): ?>
                                style="background-image: url('<?php echo $image['url']; ?>');"
                        <?php endif; ?> >
                            <h3><?php echo $project->name; ?></h3>
                            <p><?php echo $project->description; ?></p>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="col-md-4 item-project" data-href="<?php echo get_term_link($project);?>">
                        <?php if( !empty($image) ): ?>
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                        <?php endif; ?>
                        <h3><?php echo $project->name; ?></h3>
                        <p><?php echo $project->description; ?></p>
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
