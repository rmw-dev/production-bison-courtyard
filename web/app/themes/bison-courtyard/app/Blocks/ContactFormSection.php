<?php

declare(strict_types=1);

namespace App\Blocks;

use StoutLogic\AcfBuilder\FieldsBuilder;
use Vite;

class ContactFormSection extends AbstractBlock
{
    /** @var string */
    public $name = 'Contact Form Section';

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
        ->addTab('Common')
        ->addTrueFalse('show_form', [
            'label' => 'Show contact form',
            'ui' => 1,
            'default_value' => 0,
        ])

        ->addSelect('form_type', [
            'label' => 'Form Type',
            'choices' => [
                'forms.contact-form' => 'General Enquiry',
                'forms.commercial-leasing-enquiry' => 'Commercial Leasing Enquiry',
                'forms.residential-leasing-enquiry' => 'Residential Leasing Enquiry',
                'forms.parking-enquiry' => 'Parking Enquiry',
            ],
            'default_value' => 'general',
            'conditional_logic' => [
                [
                    [
                        'field' => 'show_form',
                        'operator' => '==',
                        'value' => '1',
                    ],
                ],
            ],
        ])
        
        ->addTrueFalse('show_map', [
            'label' => 'Show map',
            'ui' => 1,
            'default_value' => 0,
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
        
        ->addTab('right_side', ['label' => 'Right', 'placement' => 'right'])
        
        ->addText('right_heading', [
            'label' => 'Heading',
        ])

        ->addWysiwyg('right_content', [
            'label' => 'Content',
            'tabs' => 'all',
            'toolbar' => 'full',
            'media_upload' => 1,
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
        'show_form'  => get_field('show_form'),
        'form_type'  => get_field('form_type'),
        'show_map'  => get_field('show_map'),
        'endpoint'  => $this->getFormsEndpoint(),
        'restNonce' => wp_create_nonce('wp_rest'),
    ];
}


    /**
     * Get the forms endpoint URL.
     */

    protected function getFormsEndpoint(): string{
        switch (get_field('form_type')) {
            case 'forms.contact-form':
                return rest_url('rmw/v1/contact');
            case 'forms.commercial-leasing-enquiry':
                return rest_url('rmw/v1/leasing');
            case 'forms.residential-leasing-enquiry':
                return rest_url('rmw/v1/residential-leasing');
            case 'forms.parking-enquiry':
                return rest_url('rmw/v1/parking-inquiry');
            default:
                return rest_url('rmw/v1/contact');
        }
    }

    /**
     * Enqueue assets when rendering the block (optional).
     */
    public function assets(array $block): void
    {
        
        switch ($block['data']['form_type'] ?? '') {
            case 'forms.contact-form':
                wp_enqueue_script('contact-form-js', Vite::asset('resources/js/contactForm.js'), [], null, true);
                break;
            case 'forms.commercial-leasing-enquiry':
                wp_enqueue_script('contact-form-commercial-js', Vite::asset('resources/js/contactFormCommercial.js'), [], null, true);
                break;
            case 'forms.residential-leasing-enquiry':
                wp_enqueue_script('contact-form-residential-js', Vite::asset('resources/js/contactFormResidential.js'), [], null, true);
                break;
            case 'forms.parking-enquiry':
                wp_enqueue_script('contact-form-parking-js', Vite::asset('resources/js/contactFormParking.js'), [], null, true);
                break;
        }
    }
}
