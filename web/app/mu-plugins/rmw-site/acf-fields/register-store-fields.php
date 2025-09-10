<?php

namespace RMW\Site\AcfFields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class StoreFields extends Field
{
    public function __construct()
    {
        // Do NOT call parent::__construct() – it expects a container
    }

    public function fields(): array
    {
        $menuItem = new FieldsBuilder('store_fields');

        $menuItem
            ->setLocation('post_type', '==', 'store')
            ->addTab('Store Details')
            ->addWysiwyg('store_hours', [
                'label' => 'Store Hours',
                'instructions' => 'Store opening hours.',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
            ])
            ->addWysiwyg('store_contact_details', [
                'label' => 'Contact Details',
                'instructions' => 'Store contact details such as phone number and email address.',
                'required' => 0,
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
            ])
            ->addText('store_website_address')
            ->addText('store_instagram_address')
            ->addText('store_facebook_address')
            ->addText('store_twitter_address')

            ->addTab('Images')

            ->addImage('store_image', [
                'label' => 'Store Image',
                'instructions' => 'Image to display for the store.',
                'required' => 0,
                'return_format' => 'integer',
                'preview_size'  => 'medium',
                'library' => 'all',
            ]);

    

        return $menuItem->build();
    }
}
