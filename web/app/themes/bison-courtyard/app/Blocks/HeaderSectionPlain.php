<?php

declare(strict_types=1);

namespace App\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;

class HeaderSectionPlain extends AbstractBlock
{
    /** @var string */
    public $name = 'Header Section Plain';

    /** @var string */
    public $description = 'Plain page header section.';

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

    /** @var array */
    public $template = [
        'core/heading' => ['placeholder' => 'Hello World'],
        'core/paragraph' => ['placeholder' => 'Welcome to the Hero Section block.'],
    ];

    /**
     * Define block-specific fields (shared layout is injected by AbstractBlock).
     */
    protected function defineFields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
        ->addTab('content', ['label' => 'Content', 'placement' => 'left'])

        ->addText('heading', [
            'label' => 'Main heading',
        ])
        ->addText('sub_heading', [
            'label' => 'Sub heading',
        ])
        ->addField('text_color', 'editor_palette')
            ->setConfig('default_value', 'white')
            ->setConfig('allowed_colors', ['theme-brown', 'theme-orange', 'theme-yellow', 'theme-dark-blue', 'theme-light-blue', 'theme-footer-tan', 'theme-footer-light-tan', 'white', 'black'])
            ->setConfig('return_format', 'slug');
       
        return $fields;
    }

    /**
     * Provide block-specific data (merged with layout data by AbstractBlock).
     */
    protected function withBlock(): array
    {
        return [
            'heading' => get_field('heading'),
            'sub_heading' => get_field('sub_heading'),
            'text_color' => get_field('text_color') ? 'text-' . get_field('text_color') : 'text-white',
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
