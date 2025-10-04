<?php

declare(strict_types=1);

namespace App\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;

class CallToActionBanner extends AbstractBlock
{
    /** @var string */
    public $name = 'Call to Action Banner';

    /** @var string */
    public $description = 'A call to action banner with heading, text and buttons.';

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
    public $template = [
        'core/heading' => ['placeholder' => 'Call to action'],
        'core/paragraph' => ['placeholder' => 'Welcome to the Call to Action block.'],
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
        ->addField('banner_background_color', 'editor_palette')
            ->setConfig('default_value', 'white')
            ->setConfig('allowed_colors', ['theme-brown', 'theme-orange', 'theme-yellow', 'theme-dark-blue', 'theme-light-blue', 'theme-footer-tan', 'theme-footer-light-tan', 'white', 'black'])
            ->setConfig('return_format', 'slug')
        ->addField('text_color', 'editor_palette')
            ->setConfig('default_value', 'white')
            ->setConfig('allowed_colors', ['theme-brown', 'theme-orange', 'theme-yellow', 'theme-dark-blue', 'theme-light-blue', 'theme-footer-tan', 'theme-footer-light-tan', 'white', 'black'])
            ->setConfig('return_format', 'slug')

        ->addRepeater('buttons', [
            'label' => 'Buttons',
            'layout' => 'row',
            'button_label' => 'Add Button',
        ])
            ->addLink('button_link', ['label' => 'Button'])
            ->addSelect('button_style', [
                'label' => 'Button Style',
                'choices' => [
                    'primary' => 'Primary',
                    'secondary' => 'Secondary',
                    'tertiary' => 'Tertiary',
                ],
                'default_value' => 'primary',
                'return_format' => 'value',
            ])
        ->endRepeater();
       
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
            'banner_background_color' => get_field('banner_background_color') ? 'bg-' . get_field('banner_background_color') : 'bg-white',
            'buttons' => get_field('buttons') ?: [],
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
