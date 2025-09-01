<?php

declare(strict_types=1);

namespace App\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;

class TwoColumnsText extends AbstractBlock
{
    /** @var string */
    public $name = 'Two Columns Text';

    /** @var string */
    public $description = 'Two text columns side by side';

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


    /**
     * Define block-specific fields (shared layout is injected by AbstractBlock).
     */
    protected function defineFields(FieldsBuilder $fields): FieldsBuilder
{
    $fields
        ->addTab('common', ['label' => 'Common', 'placement' => 'right'])
        ->addField('text_color', 'editor_palette')
                ->setConfig('default_value', 'theme-yellow')
                ->setConfig('allowed_colors', ['theme-brown', 'theme-orange', 'theme-yellow', 'theme-dark-blue', 'theme-light-blue', 'theme-footer-tan', 'theme-footer-light-tan', 'white', 'black'])
                ->setConfig('return_format', 'slug')

        ->addRadio('has_overlapping_image_below',  [
            'label' => 'Has Overlapping Image Below',
            'choices' => [
                0 => 'No',
                1 => 'Left',
                2 => 'Right',
            ],
            'default_value' => 0,
            'return_format' => 'value',
        ])

        ->addTab('left_side', ['label' => 'Left', 'placement' => 'left'])

        ->addText('left_heading', [
            'label' => 'Heading',
        ])

        ->addWysiwyg('left_content', [
            'label' => 'Content',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
        ])
        ->addTrueFalse('left_vertical_center_align', [
            'label' => 'Vertical Center Align',
            'ui' => 1,
            'default_value' => 0,
        ])
        
        ->addTab('right_side', ['label' => 'Right', 'placement' => 'right'])

        ->addText('right_heading', [
            'label' => 'Heading',
        ])

        ->addWysiwyg('right_content', [
            'label' => 'Content',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
        ])
        
        ->addTrueFalse('right_vertical_center_align', [
            'label' => 'Vertical Center Align',
            'ui' => 1,
            'default_value' => 0,
        ]);


        

    return $fields;
}

/**
 * Provide block-specific data (merged with layout data by AbstractBlock).
 */
protected function withBlock(): array
{
    return [
        'left_heading'  => get_field('left_heading'),
        'right_heading'  => get_field('right_heading'),
        'left_content'  => get_field('left_content'),
        'right_content'  => get_field('right_content'),
        'left_vertical_center_align_class'  => get_field('left_vertical_center_align') ? 'justify-center' : '',
        'right_vertical_center_align_class'  => get_field('right_vertical_center_align') ? 'justify-center' : '',
        'text_class'  => 'text-' . get_field('text_color'),
        'has_overlapping_image_below'  =>  get_field('has_overlapping_image_below'),
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
