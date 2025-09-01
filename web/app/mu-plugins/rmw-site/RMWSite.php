<?php

namespace RMW\Site;

class RMWSite
{
    public function boot(): void
    {
        $this->load_helpers();
        $this->load_post_types();
        $this->load_taxonomies();
        $this->load_acf_fields();
        $this->load_rest_endpoints();
        //$this->register_all_image_sizes();
        add_action('after_setup_theme', [$this,'register_all_image_sizes']);
    }

    protected function load_helpers(): void
    {
        $helpers = __DIR__ . '/inc/helpers.php';
        if (file_exists($helpers)) {
            require_once $helpers;
        }
    }

    protected function load_post_types(): void
    {
        $dir = __DIR__ . '/post-types';
        $this->load_files_in_dir($dir);
    }

    protected function load_taxonomies(): void
    {
        $dir = __DIR__ . '/taxonomies';
        $this->load_files_in_dir($dir);
    }

    protected function load_rest_endpoints(): void
    {
        $dir = __DIR__ . '/rest-endpoints';
        $this->load_files_in_dir($dir);
    }

    protected function load_acf_fields(): void
    {
        if (!function_exists('acf_add_local_field_group')) return;

        $acf_dir = __DIR__ . '/acf-fields';

        foreach (glob($acf_dir . '/*.php') as $file) {
            require_once $file;
        }

        foreach (get_declared_classes() as $class) {
            if (is_subclass_of($class, \Log1x\AcfComposer\Field::class)) {
                $instance = new $class();
                acf_add_local_field_group($instance->fields());
            }
        }
    }


    protected function load_files_in_dir(string $dir): void
    {
        foreach (glob($dir . '/*.php') as $file) {
            require_once $file;
        }
    }

    /**
     * Register a full range of image sizes
     * from 300px up to 1920px in common formats.
     */
    function register_all_image_sizes() {
    // Sizes range (widths in px)
        $widths = [300, 400, 600, 800, 1000, 1200, 1400, 1600, 1920];

        foreach ($widths as $w) {
            // Flexible width-only resize, maintains original aspect ratio
            add_image_size("size-{$w}", $w, 0, false);
        }
    }
     
}
