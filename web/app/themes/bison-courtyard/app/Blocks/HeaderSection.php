<?php

declare(strict_types=1);

namespace App\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;

class HeaderSection extends AbstractBlock
{
    /** @var string */
    public $name = 'Header Section';

    /** @var string */
    public $description = 'Regular page header section.';

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
            'label' => 'Main heading',
        ])
        ->addTextarea('sub_heading', [
            'label' => 'Secondary heading',
            'rows' => 4,
            'new_lines' => 'br', // keep simple line breaks
        ])

        ->addTab('images', ['label' => 'Images', 'placement' => 'left'])

        // Image background
        ->addImage('background_image', [
            'label' => 'Background Image',
            'return_format' => 'array',
            'preview_size'  => 'large',
        ])
        ->addNumber('overlay_opacity', [
            'label' => 'Overlay Opacity',
            'instructions' => '0 (none) – 1 (solid)',
            'min' => 0,
            'max' => 1,
            'step' => 0.05,
            'default_value' => 0.35,
        ])
        ->addImage('center_image', [
            'label' => 'Center Image',
            'instructions' => 'Main image to display centered in the header area. Only image that displays on mobile.',
            'return_format' => 'array',
            'preview_size'  => 'large',
        ])
        ->addField('center_color', 'editor_palette')
            ->setConfig('default_value', 'white')
            ->setConfig('allowed_colors', ['theme-brown', 'theme-orange', 'theme-yellow', 'theme-dark-blue', 'theme-light-blue', 'theme-footer-tan', 'theme-footer-light-tan', 'white', 'black'])
            ->setConfig('return_format', 'slug')
        ->addImage('left_image', [
            'label' => 'Left Image',
            'return_format' => 'array',
            'preview_size'  => 'large',
        ])
        ->addField('left_color', 'editor_palette')
            ->setConfig('default_value', 'white')
            ->setConfig('allowed_colors', ['theme-brown', 'theme-orange', 'theme-yellow', 'theme-dark-blue', 'theme-light-blue', 'theme-footer-tan', 'theme-footer-light-tan', 'white', 'black'])
            ->setConfig('return_format', 'slug')
        ->addImage('right_image', [
            'label' => 'Right Image',
            'return_format' => 'array',
            'preview_size'  => 'large',
        ])
        ->addField('right_color', 'editor_palette')
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
            'media_type' => get_field('media_type'),
            'background_image' => get_field('background_image'),
            'left_image' => get_field('left_image'),
            'center_image' => get_field('center_image'),
            'right_image' => get_field('right_image'),
            'video_mp4' => get_field('video_mp4'),
            'video_webm' => get_field('video_webm'),
            'poster' => get_field('poster'),
            'overlay_opacity' => get_field('overlay_opacity'),
            'left_color'   => 'bg-' . (get_field('left_color') ?: 'white'),
            'center_color' => 'bg-' . (get_field('center_color') ?: 'white'),
            'right_color'  => 'bg-' . (get_field('right_color') ?: 'white'),
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
