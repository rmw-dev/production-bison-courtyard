<?php
add_action('init', function () {
    register_post_type('event', [
        'labels' => [
            'name'                  => __('Events', 'textdomain'),
            'singular_name'         => __('Event', 'textdomain'),
            'menu_name'             => __('Events', 'textdomain'),
            'name_admin_bar'        => __('Event', 'textdomain'),
            'add_new'               => __('Add New', 'textdomain'),
            'add_new_item'          => __('Add New Event', 'textdomain'),
            'new_item'              => __('New Event', 'textdomain'),
            'edit_item'             => __('Edit Event', 'textdomain'),
            'view_item'             => __('View Event', 'textdomain'),
            'all_items'             => __('All Events', 'textdomain'),
            'search_items'          => __('Search Events', 'textdomain'),
            'parent_item_colon'     => __('Parent Events:', 'textdomain'),
            'not_found'             => __('No events found.', 'textdomain'),
            'not_found_in_trash'    => __('No events found in Trash.', 'textdomain'),
        ],
        'public'              => true,
        'menu_icon'           => 'dashicons-calendar',
        'supports'            => ['title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'],
        'has_archive'         => true,
        'rewrite'             => ['slug' => 'events'],
        'show_in_rest'        => true,
        'hierarchical'        => false,
    ]);
});


add_action('pre_get_posts', function ($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('event')) {
        $query->set('meta_key', 'event_date_start');
        $query->set('orderby', 'meta_value');
        $query->set('order', 'DESC');
        $query->set('meta_type', 'DATE');
    }
});
