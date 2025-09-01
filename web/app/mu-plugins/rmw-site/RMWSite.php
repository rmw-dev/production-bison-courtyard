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
    
}
