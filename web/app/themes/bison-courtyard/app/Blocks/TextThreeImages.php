<?php

declare(strict_types=1);

namespace App\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;

class TextThreeImages extends AbstractBlock
{
    /** @var string */
    public $name = 'Text & Three Images';

    /** @var string */
    public $description = 'A beautiful homepage block';

    /** @var string */
    public $category = 'design';

    /** @var string|array */
    public $icon = 'editor-ul';

    /** @var array */
    public $keywords = [];

    /** @var array */
    public $post_types = ['post', 'page'];

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
            'label' => 'Heading',
        ])

        ->addWysiwyg('content', [
            'label' => 'Content',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
        ])

        ->addImage('image_1', [
            'label' => 'Image 1',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ])

        ->addImage('image_2', [
            'label' => 'Image 2',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ])

        ->addImage('image_3', [
            'label' => 'Image 3',
            'return_format' => 'array',
            'preview_size' => 'medium',
        ]);

    return $fields;
}

/**
 * Provide block-specific data (merged with layout data by AbstractBlock).
 */
protected function withBlock(): array
{
    return [
        'heading'  => get_field('heading'),
        'content'  => get_field('content'),
        'image_1'  => get_field('image_1'),
        'image_2'  => get_field('image_2'),
        'image_3'  => get_field('image_3'),
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
