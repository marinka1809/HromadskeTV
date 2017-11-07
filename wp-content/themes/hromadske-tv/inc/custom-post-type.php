<?php
/**
 * hromadske-tv Theme Custom Post Type and custom taxonomy
 *
 * @package hromadske-tv
 */

/**
 * Create custom post type
 */


add_action('init', 'register_post_types');


function register_post_types(){
    /**
     * Stories
     */
    register_post_type('stories', array(
        'labels' => array(
            'name'               => esc_html__('Stories', 'hromadske-tv'),
            'singular_name'      => esc_html__('Story', 'hromadske-tv'),
            'add_new'            => esc_html__('Add new', 'hromadske-tv'),
            'add_new_item'       => esc_html__('Add new story', 'hromadske-tv'),
            'edit_item'          => esc_html__('Edit story', 'hromadske-tv'),
            'new_item'           => esc_html__('New story', 'hromadske-tv'),
            'view_item'          => '',
        ),
        'description'         => '',
        'public'              => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'menu_icon'           => 'dashicons-id-alt',
        'capability_type'    => 'post',
        'supports'            => array('title','editor','excerpt','thumbnail','custom-fields'), // 'title','editor','author','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array('stories-tags'),
    ) );

    /**
     * Episodes
     */
    register_post_type('episodes', array(
        'labels' => array(
            'name'               => esc_html__('Episodes', 'hromadske-tv'),
            'singular_name'      => esc_html__('Episode', 'hromadske-tv'),
            'add_new'            => esc_html__('Add new', 'hromadske-tv'),
            'add_new_item'       => esc_html__('Add new episode', 'hromadske-tv'),
            'edit_item'          => esc_html__('Edit episode', 'hromadske-tv'),
            'new_item'           => esc_html__('New episode', 'hromadske-tv') ,
            'view_item'          => '',
        ),
        'description'         => '',
        'public'              => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'capability_type'    => 'post',
        'supports'            => array('title','editor','excerpt','thumbnail','custom-fields'), // 'title','editor','author','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array('episodes-tags', 'projects'),
        'has_archive'         => true
    ) );

    /**
     * Employees
     */
    register_post_type('employees', array(
        'labels' => array(
            'name'               => esc_html__('Employees', 'hromadske-tv'),
            'singular_name'      => esc_html__('Employee', 'hromadske-tv'),
            'add_new'            => esc_html__('Add new', 'hromadske-tv'),
            'add_new_item'       => esc_html__('Add new employee', 'hromadske-tv'),
            'edit_item'          => esc_html__('Edit employee', 'hromadske-tv'),
            'new_item'           => esc_html__('New employee', 'hromadske-tv'),
            'view_item'          => '',
        ),
        'description'         => '',
        'public'              => false,
        'menu_icon'           => 'dashicons-groups',
        'show_ui'            => true,
        'capability_type'    => 'post',
        'supports'            => array('title','excerpt','thumbnail'), // 'title','editor','author','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'

    ) );

    /**
     * Production
     */
    register_post_type('production', array(
        'labels' => array(
            'name'               => esc_html__('Production', 'hromadske-tv'),
            'singular_name'      => esc_html__('Production', 'hromadske-tv'),
            'add_new'            => esc_html__('Add production', 'hromadske-tv'),
            'add_new_item'       => esc_html__('Add new production', 'hromadske-tv'),
            'edit_item'          => esc_html__('Edit production', 'hromadske-tv'),
            'new_item'           => esc_html__('New production', 'hromadske-tv'),
            'view_item'          => '',
        ),
        'description'         => '',
        'public'              => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'menu_icon'           => 'dashicons-id-alt',
        'capability_type'    => 'post',
        'supports'            => array('title','editor','excerpt','thumbnail','custom-fields'), // 'title','editor','author','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
        'taxonomies'          => array('production-tags'),
    ) );
}


/**
 * Create custom taxonomy
 */
add_action('init', 'create_taxonomy');
function create_taxonomy(){

    $labels_episodes = array(
        'name'              => esc_html__('Tags for episod', 'hromadske-tv'),
        'singular_name'     => esc_html__('Tag episod', 'hromadske-tv'),
        'search_items'      => esc_html__('Search tag', 'hromadske-tv'),
        'all_items'         => esc_html__('All tags', 'hromadske-tv'),
        'edit_item'         => esc_html__('Edit tag', 'hromadske-tv'),
        'update_item'       => esc_html__('Update tag', 'hromadske-tv'),
        'add_new_item'      => esc_html__('Add New tag', 'hromadske-tv'),
        'new_item_name'     => esc_html__('New tag Name', 'hromadske-tv')
    );

    $args_episodes = array(
        'labels'                => $labels_episodes,
        'description'           => '',
        'public'                => true,
        'show_tagcloud'         => false,
        'hierarchical'          => false,
        'update_count_callback' => '',
        'rewrite'               => true,
        'capabilities'          => array(),
        'show_admin_column'     => false,
        '_builtin'              => false,
        'show_in_quick_edit'    => null,
    );
    register_taxonomy('episodes-tags', array('episodes'), $args_episodes );

     $labels_production = array(
         'name'              => esc_html__('Tags for production', 'hromadske-tv'),
         'singular_name'     => esc_html__('Tag production', 'hromadske-tv'),
         'search_items'      => esc_html__('Search tag', 'hromadske-tv'),
         'all_items'         => esc_html__('All tags', 'hromadske-tv'),
         'edit_item'         => esc_html__('Edit tag', 'hromadske-tv'),
         'update_item'       => esc_html__('Update tag', 'hromadske-tv'),
         'add_new_item'      => esc_html__('Add New tag', 'hromadske-tv'),
         'new_item_name'     => esc_html__('New tag Name', 'hromadske-tv')
     );

    $args_production = array(
        'labels'                => $labels_production,
        'description'           => '',
        'public'                => true,
        'show_tagcloud'         => false,
        'hierarchical'          => false,
        'update_count_callback' => '',
        'rewrite'               => true,
        'capabilities'          => array(),
        'show_admin_column'     => false,
        '_builtin'              => false,
        'show_in_quick_edit'    => null,
    );
    register_taxonomy('production-tags', array('production'), $args_production );

    $labels = array(
        'name'              => esc_html__('Tags for stories', 'hromadske-tv'),
        'singular_name'     => esc_html__('Tag stories', 'hromadske-tv'),
        'search_items'      => esc_html__('Search tag', 'hromadske-tv'),
        'all_items'         => esc_html__('All tags', 'hromadske-tv'),
        'edit_item'         => esc_html__('Edit tag', 'hromadske-tv'),
        'update_item'       => esc_html__('Update tag', 'hromadske-tv'),
        'add_new_item'      => esc_html__('Add New tag', 'hromadske-tv'),
        'new_item_name'     => esc_html__('New tag Name', 'hromadske-tv')
    );

    $args = array(
        'labels'                => $labels,
        'description'           => '',
        'public'                => true,
        'show_tagcloud'         => false,
        'hierarchical'          => false,
        'update_count_callback' => '',
        'rewrite'               => true,
        'capabilities'          => array(),
        'show_admin_column'     => false,
        '_builtin'              => false,
        'show_in_quick_edit'    => null,
    );
    register_taxonomy('stories-tags', array('stories'), $args );

    $labelsProject = array(
        'name'              => esc_html__('Projects', 'hromadske-tv'),
        'singular_name'     => esc_html__('Project', 'hromadske-tv'),
        'search_items'      => esc_html__('Search project', 'hromadske-tv'),
        'all_items'         => esc_html__('All Projects', 'hromadske-tv'),
        'edit_item'         => esc_html__('Edit project', 'hromadske-tv'),
        'update_item'       => esc_html__('Update project', 'hromadske-tv'),
        'add_new_item'      => esc_html__('Add New project', 'hromadske-tv'),
        'parent_item'       => null,
        'parent_item_colon' => null,
    );

    $argsProject = array(
        'labels'                => $labelsProject,
        'description'           => esc_html__('There are various projects in which studies, projects continue to expand new episodes', 'hromadske-tv'), // описание таксономии
        'public'                => true,
        'show_tagcloud'         => false,
        'hierarchical'          => true,
        'update_count_callback' => '',
        'capabilities'          => array(),
        'show_admin_column'     => true,
        '_builtin'              => false,
        'query_var'             => true,
        'rewrite'               => true,

    );
    register_taxonomy('projects', array('episodes'), $argsProject );
}