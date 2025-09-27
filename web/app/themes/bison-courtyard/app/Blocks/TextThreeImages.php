<?php

declare(strict_types=1);

namespace App\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;

class TextThreeImages extends AbstractBlock
{
    /** @var string */
    public $name = 'Text Three Images';

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

    protected function getChoices(){
        $events = get_posts([
            'post_type' => 'event',
            'numberposts' => -1,
            'post_status' => 'publish',
        ]);

        $choices = [];
        foreach ($events as $event) {
            $choices[] = [$event->ID => $event->post_title];
        }

        return $choices;
    }

    protected function getFeaturedEvent(){

        if (get_field('event_selection_mode')) {
            $event_id = get_field('event_manual_event'); // make sure field name matches
            
            return $event_id ? get_post($event_id) : null;
        } else {
            $events = get_posts([
                'post_type'      => 'event',
                'post_status'    => 'publish',
                'posts_per_page' => 1,
            ]);
        return $events ? $events[0] : null;
        }   
    }

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
        ])

        ->addTab('event_showcase', ['label' => 'Event', 'placement' => 'left'])

        ->addTrueFalse('show_event', [
            'label'        => 'Show Event',
            'instructions' => 'Enable to show a featured event.',
            'default_value'=> false,
            'ui'           => true,
            'ui_on_text'   => 'Show',
            'ui_off_text'  => "Don't Show",
        ])
        ->addRadio('event_text_side', [
            'label' => 'Text Side',
            'instructions' => 'Select the side for the text content.',
            'default_value' => 'left',
            'ui' => true,
            'choices' => [
                'left'  => 'Left',
                'right' => 'Right',
            ],
        ])

        ->addRadio('event_selection_mode', [
            'label'        => 'Event Selection Mode',
            'instructions' => 'Pick next event automatically or select a specific event.',
            'default_value'=> true,
            'ui'           => true,
            'choices' => [
                ['0'  => 'Automatic'],
                ['1' => 'Manual'],
            ],
        ])

        ->addPostObject('event_manual_event', [
            'label' => 'Featured Event',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => [],
            'wrapper' => [
                'width' => '',
                'class' => '',
                'id' => '',
            ],
            'post_type' => ['event'],
            'taxonomy' => [],
            'allow_null' => 0,
            'multiple' => 0,
            'return_format' => 'object',
            'ui' => 1,
        ])
        ->conditional('event_selection_mode', '==', '1');
        
        
    

    
        
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
        'show_event' => get_field('show_event'),
        'text_side' => get_field('text_side') ?: 'left',
        'featured_event' => $this->getFeaturedEvent()
    ];
}

protected function getEvent($event_id): array
{
    var_dump($event_id);
    return [];
}

    

    /**
     * Enqueue assets when rendering the block (optional).
     */
    public function assets(array $block): void
    {
        // enqueue as needed
    }
}
