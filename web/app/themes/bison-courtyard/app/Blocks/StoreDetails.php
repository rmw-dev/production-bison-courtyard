<?php

declare(strict_types=1);

namespace App\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;

class StoreDetails extends AbstractBlock
{
    /** @var string */
    public $name = 'Store Details';

    /** @var string */
    public $description = 'Store Details Block';

    /** @var string */
    public $category = 'design';

    /** @var string|array */
    public $icon = 'editor-ul';

    /** @var array */
    public $keywords = [];

    /** @var array */
    public $post_types = ['post', 'page', 'store'];

    /** @var array */
    public $parent = [];

    /** @var array */
    public $ancestor = [];

    /** @var string */
    public $mode = 'preview';

    /** @var string */
    public $align = '';

    /** @var string */
    public $align_text = '';

    /** @var string */
    public $align_content = '';

    /** @var array */
    public $spacing = [
        'padding' => null,
        'margin' => null,
    ];

    /** @var array */
    public $supports = [
        'align' => true,
        'align_text' => false,
        'align_content' => false,
        'full_height' => false,
        'anchor' => true,
        'mode' => true,
        'multiple' => true,
        'jsx' => true,
        'color' => [
            'background' => false,
            'text' => false,
            'gradients' => false,
        ],
        'spacing' => [
            'padding' => false,
            'margin' => false,
        ],
    ];

    /** @var array */
    public $styles = ['light', 'dark'];

    /** @var array */
    public $example = [
        'items' => [
            ['item' => 'Item one'],
            ['item' => 'Item two'],
            ['item' => 'Item three'],
        ],
    ];


    /**
     * Define block-specific fields (shared layout is injected by AbstractBlock).
     */
    protected function defineFields(FieldsBuilder $fields): FieldsBuilder
{
    


        

    return $fields;
}

/**
 * Provide block-specific data (merged with layout data by AbstractBlock).
 */
protected function withBlock(): array
{
    return [
        'store_hours' => get_field('store_hours', get_the_ID()) ?: '',
        'store_contact_details' => get_field('store_contact_details', get_the_ID()) ?: '',
        'store_website_address' => get_field('store_website_address', get_the_ID()) ?: '',
        'store_facebook_address' => get_field('store_facebook_address', get_the_ID()) ?: '',
        'store_instagram_address' => get_field('store_instagram_address', get_the_ID()) ?: '',
        'store_twitter_address' => get_field('store_twitter_address', get_the_ID()) ?: '',
        'store_image' => (int) get_field('store_image', get_the_ID()) ?: '',
        
    ];
}

    

    /**
     * Enqueue assets when rendering the block (optional).
     */
    public function assets(array $block): void
    {
        // enqueue as needed
    }
}
