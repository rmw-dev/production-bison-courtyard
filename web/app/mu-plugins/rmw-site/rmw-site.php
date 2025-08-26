<?php
/**
 * Plugin Name: RMW Site Core
 * Description: Custom post types, ACF field groups, etc.
 */

require_once __DIR__ . '/RMWSite.php';

add_action('plugins_loaded', function () {
    (new \RMW\Site\RMWSite())->boot();
});
