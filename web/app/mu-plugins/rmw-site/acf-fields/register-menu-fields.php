<?php

namespace RMW\Site\AcfFields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class MenuItemFields extends Field
{
    public function __construct()
    {
        // Do NOT call parent::__construct() – it expects a container
    }

    public function fields(): array
    {
        $menuItem = new FieldsBuilder('menu_item_fields');

        $menuItem
            ->setLocation('nav_menu_item', '==', 'all')
            ->addText('description', [
                'label' => 'Description',
            ])
            ->addImage('thumbnail', [
                'label' => 'Thumbnail',
                'return_format' => 'id',
                'preview_size' => 'thumbnail',
                'library' => 'all',
            ]);

        return $menuItem->build();
    }
}
