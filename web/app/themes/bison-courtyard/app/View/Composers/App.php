<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class App extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        '*',
    ];

    /**
     * Retrieve the site name.
     */
    public function siteName(): string
    {
        return get_bloginfo('name', 'display');
    }

    public function siteMenu(): array
    {
        
        $locations = get_nav_menu_locations();
        $menu_id = $locations['primary_navigation'] ?? null;
        $menu = $menu_id ? wp_get_nav_menu_items($menu_id) : [];

        $menu = array_map(function ($item) {
            return (object) [
                'title' => $item->title,
                'url' => $item->url,
                'db_id' => $item->object_id,
                'object_id' => $item->object_id,
                'menu_item_parent' => $item->menu_item_parent,
                'description' => get_field('description', $item->ID),
                'thumbnail' => get_field('thumbnail', $item->ID),
            ];
        }, $menu);

        

        
        
        
        return $menu;
        
    }

    public function pageSettings(): array
    {
        return [
            'solid_header' => get_field('solid_header') ?? true,
        ];
    }

    public function with()
    {
        return [
            'siteName' => $this->siteName(),
            'siteMenu' => $this->siteMenu(),
            'pageSettings' => $this->pageSettings(),
        ];
    }

    




}
