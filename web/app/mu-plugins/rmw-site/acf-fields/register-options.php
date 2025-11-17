<?php

namespace RMW\Site\AcfFields;

use Log1x\AcfComposer\Field;
use StoutLogic\AcfBuilder\FieldsBuilder;

class ThemeOptionsFields extends Field
{
    public function __construct()
    {
        // Do NOT call parent::__construct() – it expects a container
    }

    public function fields(): array
    {
        // This is the field group key/name
        $options = new FieldsBuilder('theme_options_fields');

        $options
            // Attach this field group to the options page with slug "theme-options"
            ->setLocation('options_page', '==', 'theme-options')

            ->addText('contact_email_to', [
                'label' => 'Contact Emails To',
                'instructions' => 'The email address that contact form submissions will be sent to.',
            ]);

        return $options->build();
    }
}
