<?php

declare(strict_types=1);

namespace App\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;

class HeroSection extends AbstractBlock
{
    /** @var string */
    public $name = 'Hero Section';

    /** @var string */
    public $description = 'A beautiful Hero Section block.';

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
        'margin'  => null,
    ];

    /** @var array */
    public $supports = [
        'align'         => true,
        'align_text'    => false,
        'align_content' => false,
        'full_height'   => false,
        'anchor'        => true,
        'mode'          => true,
        'multiple'      => true,
        'jsx'           => true,
        'color'         => [
            'background' => false,
            'text'       => false,
            'gradients'  => false,
        ],
        'spacing'       => [
            'padding' => false,
            'margin'  => false,
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
        'core/heading'   => ['placeholder' => 'Hello World'],
        'core/paragraph' => ['placeholder' => 'Welcome to the Hero Section block.'],
    ];

    /**
     * Define block-specific fields (shared layout is injected by AbstractBlock).
     */
    protected function defineFields(FieldsBuilder $fields): FieldsBuilder
    {
        $fields
            ->addTab('content', ['label' => 'Content', 'placement' => 'left'])

            ->addText('headline', [
                'label' => 'Headline',
            ])
            ->addTextarea('subheadline', [
                'label' => 'Sub-headline',
                'rows' => 2,
                'new_lines' => 'br', // keep simple line breaks
            ])

            ->addSelect('media_type', [
                'label' => 'Background Type',
                'choices' => ['image' => 'Image', 'video' => 'Video'],
                'default_value' => 'image',
                'ui' => 1,
                'return_format' => 'value',
            ])

            // Image background
            ->addImage('image', [
                'label' => 'Background Image',
                'return_format' => 'array',
                'preview_size'  => 'large',
                'conditional_logic' => [[
                    ['field' => 'media_type', 'operator' => '==', 'value' => 'image'],
                ]],
            ])

            // Video background
            ->addFile('video_mp4', [
                'label' => 'Video (MP4)',
                'mime_types' => 'mp4',
                'library' => 'all',
                'conditional_logic' => [[
                    ['field' => 'media_type', 'operator' => '==', 'value' => 'video'],
                ]],
            ])
            ->addFile('video_webm', [
                'label' => 'Video (WebM) — optional',
                'mime_types' => 'webm',
                'required' => 0,
                'library' => 'all',
                'conditional_logic' => [[
                    ['field' => 'media_type', 'operator' => '==', 'value' => 'video'],
                ]],
            ])
            ->addImage('poster', [
                'label' => 'Poster (fallback image) — optional',
                'return_format' => 'array',
                'required' => 0,
                'conditional_logic' => [[
                    ['field' => 'media_type', 'operator' => '==', 'value' => 'video'],
                ]],
            ])

            ->addNumber('overlay_opacity', [
                'label' => 'Overlay Opacity',
                'instructions' => '0 (none) – 1 (solid)',
                'min' => 0,
                'max' => 1,
                'step' => 0.05,
                'default_value' => 0.35,
            ]);

        return $fields;
    }

    /**
     * Provide block-specific data (merged with layout data by AbstractBlock).
     */
    protected function withBlock(): array
    {
        // Raw fields
        $image           = get_field('image');
        $poster          = get_field('poster');
        $overlay_opacity = get_field('overlay_opacity');

        // Derived helpers (mirror your Blade logic)
        $imgId     = is_array($image ?? null)  ? ($image['ID']  ?? null) : ($image ?? null);
        $imgAlt    = is_array($image ?? null)  ? ($image['alt'] ?? '')   : '';
        $posterUrl = is_array($poster ?? null) ? ($poster['url'] ?? null): ($poster ?? null);
        $overlay   = isset($overlay_opacity) ? max(0, min(1, (float) $overlay_opacity)) : 0.35;

        return [
            // originals
            'headline'        => get_field('headline'),
            'subheadline'     => get_field('subheadline'),
            'media_type'      => get_field('media_type'),
            'image'           => $image,
            'video_mp4'       => get_field('video_mp4'),
            'video_webm'      => get_field('video_webm'),
            'poster'          => $poster,
            'overlay_opacity' => $overlay_opacity,

            // new derived values for Blade
            'imgId'           => $imgId,
            'imgAlt'          => $imgAlt,
            'posterUrl'       => $posterUrl,
            'overlay'         => $overlay,
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
