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
            'name'               => 'Stories',
            'singular_name'      => 'Story',
            'add_new'            => 'Add new',
            'add_new_item'       => 'Add new story',
            'edit_item'          => 'Edit story',
            'new_item'           => 'New story',
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
        'taxonomies'          => array('stories-tags'),
        'has_archive'         => true
    ) );

    /**
     * Episodes
     */
    register_post_type('episodes', array(
        'labels' => array(
            'name'               => 'Episodes',
            'singular_name'      => 'Episode',
            'add_new'            => 'Add new',
            'add_new_item'       => 'Add new episode',
            'edit_item'          => 'Edit episode',
            'new_item'           => 'New episode',
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
        'taxonomies'          => array(''),
        'has_archive'         => true
    ) );
}


/**
 * Create custom taxonomy
 */
add_action('init', 'create_taxonomy');
function create_taxonomy(){
    $labels = array(
        'name'              => 'Tags for stories',
        'singular_name'     => 'Tag',
        'search_items'      => 'Search tag',
        'all_items'         => 'All tags',
        'edit_item'         => 'Edit tag',
        'update_item'       => 'Update tag',
        'add_new_item'      => 'Add New tag',
        'new_item_name'     => 'New tag Name'
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
        'name'              => 'Projects',
        'singular_name'     => 'Project',
        'search_items'      => 'Search project',
        'all_items'         => 'All Projects',
        'edit_item'         => 'Edit project',
        'update_item'       => 'Update project',
        'add_new_item'      => 'Add New project',
        'new_item_name'     => 'New project Name',
        'parent_item'       => null,
        'parent_item_colon' => null,
    );

    $argsProject = array(
        'labels'                => $labelsProject,
        'description'           => 'There are various projects in which studies, projects continue to expand new episodes', // описание таксономии
        'public'                => true,
        'show_tagcloud'         => false,
        'hierarchical' => true,
        'update_count_callback' => '',
        'rewrite'               => true,
        'capabilities'          => array(),
        'show_admin_column'     => true,
        '_builtin'              => false,
        'show_in_quick_edit'    => null,

    );
    register_taxonomy('projects', array('episodes'), $argsProject );
}