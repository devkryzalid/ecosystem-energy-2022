<?php

/**
 * Add sample custom post type
 */
function case_study_post_type()
{
    $labels = array(
        'name'                     => __('Case studies', 'ecosystem-energy'),
        'singular_name'            => __('Case study', 'ecosystem-energy'),
        'all_items'                => __('All case studies', 'ecosystem-energy'),
        'add_new'                  => __('Add', 'ecosystem-energy'),
        'add_new_item'             => __('Add', 'ecosystem-energy'),
        'edit_item'                => __('Edit', 'ecosystem-energy'),
        'new_item'                 =>  __('New', 'ecosystem-energy'),
        'view_item'                => __('See case study', 'ecosystem-energy'),
        'search_items'             => __('Find case study', 'ecosystem-energy'),
        'not_found'                => __('No results', 'ecosystem-energy'),
        'not_found_in_trash'       => __('No results', 'ecosystem-energy'),
        'menu_name'                => __('Case studies', 'ecosystem-energy'),
        'item_published'           => __('Publish', 'ecosystem-energy'),
        'item_published_privately' => __('Publish privately', 'ecosystem-energy'),
        'item_scheduled'           => __('Scheduled', 'ecosystem-energy'),
        'item_updated'             => __('Updated', 'ecosystem-energy'),
    );
    $args = array(
        'labels'              => $labels,
        'hierarchical'        => false,
        'supports'            => array('title', 'editor', 'thumbnail'),
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_rest'        => true,
        'menu_position'       => 4,
        'menu_icon'           => 'dashicons-analytics',
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'publicly_queryable'  => true,
        'exclude_from_search' => false,
        'has_archive'         => true,
        'query_var'           => true,
        'can_export'          => true,
        'rewrite'             => array('slug' => __('case-studies', 'ecosystem-energy'), 'with_front' => true),
    );
    register_post_type('case_study', $args);
}
