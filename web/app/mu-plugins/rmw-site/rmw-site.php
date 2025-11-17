<?php
/**
 * Plugin Name: RMW Site Core
 * Description: Custom post types, ACF field groups, etc.
 */

require_once __DIR__ . '/RMWSite.php';

add_action('plugins_loaded', function () {
    (new \RMW\Site\RMWSite())->boot();
});

add_action('acf/init', function () {
    if (! function_exists('acf_add_options_page')) {
        return;
    }

    acf_add_options_page([
        'page_title' => 'Theme Options',
        'menu_title' => 'Theme Options',
        'menu_slug'  => 'theme-options',       // must match the location slug
        'capability' => 'manage_options',
        'redirect'   => false,
        'position'   => 60,
        'icon_url'   => 'dashicons-admin-generic',
    ]);
});
