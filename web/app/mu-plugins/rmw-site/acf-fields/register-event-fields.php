<?php

namespace RMW\Site\AcfFields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class EventFields extends Field
{
    public function __construct()
    {
        // Do NOT call parent::__construct() – it expects a container
    }

    public function fields(): array
    {
        $menuItem = new FieldsBuilder('event_fields');

        $menuItem
            ->setLocation('post_type', '==', 'event')
            ->addDatePicker('event_date_start', [
                'label' => 'Event Start Date',
                'instructions' => 'Select the date of the event.',
                'required' => 1,
            ])
            ->addDatePicker('event_date_end', [
                'label' => 'Event End Date',
                'instructions' => 'Select the date of the event.',
                'required' => 1,
            ]);

        return $menuItem->build();
    }
}
