<?php

namespace RMW\Site\AcfFields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class PageFields extends Field
{
    public function __construct()
    {
        // Do NOT call parent::__construct() – it expects a container
    }

    public function fields(): array
    {
        $menuItem = new FieldsBuilder('page_fields');

        $menuItem
            ->setLocation('post_type', '==', 'page')
            ->addTrueFalse('solid_header', [
                'label' => 'Assign solid white header for page',
                'instructions' => 'Check to assign a solid white header for this page. Uncheck to assign a transparent header.',
                'ui' => 1,
                'default_value' => 1,
            ]);

        return $menuItem->build();
    }
}
