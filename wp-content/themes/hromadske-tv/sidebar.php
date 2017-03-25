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
        'hide_empty'    => false,
        'number'        => 5,
    );
    $projects_query = new WP_Term_Query( $args );
    if ( $projects_query->terms ) :?>
        <ul class="row">
            <?php foreach( $projects_query->terms as $project ){
                $image = get_field('image_project', $project);?>
                <li>
                    <?php if( !empty($image) ): ?>
                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                    <?php endif; ?>
                    <h3><?php echo $project->name; ?></h3>
                </li>
            <?php } ?>
        </ul>
    <?php endif;?>
    <?php wp_reset_postdata();?>

	<?php
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        return;
    }
    dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
