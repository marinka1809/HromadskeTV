<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package hromadske-tv
 */
?>

<aside id="secondary" class="col-sm-3" role="complementary">
    <?php
    $args = array(
        'taxonomy'      => array( 'projects' ),
        'fields'        => 'all',
        'hide_empty'    => true,
        'number'        => 5,
        'meta_key'      => 'custom_term_meta',
    );
    $projects_query = new WP_Term_Query( $args );
    if ( $projects_query->terms ) :?>
        <h1><?php esc_html_e('Projects', 'hromadske-tv') ?></h1>
        <ul>
            <?php foreach( $projects_query->terms as $project ){
                $image = get_field('image_project', $project);?>
                <li class="item-project">
                    <a href="<?php echo get_term_link($project);?>">
                        <?php if( !empty($image) ): ?>
                            <?php echo wp_get_attachment_image( $image['id'], 'thumbnails' );?>
                        <?php endif; ?>
                        <div class="dark-bg">
                            <h3><?php echo $project->name; ?></h3>
                        </div>
                    </a>
                </li>
            <?php } ?>
        </ul>
    <?php endif;?>
    <?php wp_reset_postdata();?>
</aside><!-- #secondary -->
