<?php
add_action('init', function () {
    register_post_type('store', [
        'labels' => [
            'name'                  => __('Stores', 'textdomain'),
            'singular_name'         => __('Store', 'textdomain'),
            'menu_name'             => __('Stores', 'textdomain'),
            'name_admin_bar'        => __('Store', 'textdomain'),
            'add_new'               => __('Add New', 'textdomain'),
            'add_new_item'          => __('Add New Store', 'textdomain'),
            'new_item'              => __('New Store', 'textdomain'),
            'edit_item'             => __('Edit Store', 'textdomain'),
            'view_item'             => __('View Store', 'textdomain'),
            'all_items'             => __('All Stores', 'textdomain'),
            'search_items'          => __('Search Stores', 'textdomain'),
            'parent_item_colon'     => __('Parent Stores:', 'textdomain'),
            'not_found'             => __('No stores found.', 'textdomain'),
            'not_found_in_trash'    => __('No stores found in Trash.', 'textdomain'),
        ],
        'public'              => true,
        'menu_icon'           => 'dashicons-store',
        'taxonomies'          => ['store_type'],
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'has_archive'         => true,
        'rewrite'             => ['slug' => 'discover'],
        'show_in_rest'        => true,
        'hierarchical'        => false,
    ]);
});
