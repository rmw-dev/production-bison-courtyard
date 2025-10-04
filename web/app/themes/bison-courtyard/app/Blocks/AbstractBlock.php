<?php

declare(strict_types=1);

namespace App\Blocks;

use Log1x\AcfComposer\Block;
use StoutLogic\AcfBuilder\FieldsBuilder;

abstract class AbstractBlock extends Block
{

    public $blockVersion = '3';
    /**
     * Child blocks must implement this to add their own fields.
     */
    abstract protected function defineFields(FieldsBuilder $fields): FieldsBuilder;

    /**
     * Compose ACF fields: child fields + shared layout controls.
     */
    public function fields(): array
    {
        $fields = new FieldsBuilder($this->name);

        // Child-specific fields
        $fields = $this->defineFields($fields);

        // Common layout controls
        $this->addLayoutControls($fields);

        return $fields->build();
    }

    /**
     * Merge child with shared layout data.
     */
    public function with(): array
    {
        return array_merge($this->withBlock(), $this->withLayout());
    }

    /**
     * Child blocks can override to pass extra data to the view.
     */
    protected function withBlock(): array
    {
        return [];
    }

    /**
     * Shared layout fields (tab + controls).
     */
    protected function addLayoutControls(FieldsBuilder $f): void
    {
        $f->addTab('layout', ['label' => 'Layout', 'placement' => 'left'])
            ->addRange('padding_top', [
                'label'         => 'Padding Top',
                'min'           => 0,
                'max'           => 24,
                'step'          => 1,
                'append'        => 'units',
                'default_value' => 16,
                'wrapper'       => ['width' => 100],
            ])
            ->addRange('padding_bottom', [
                'label'         => 'Padding Bottom',
                'min'           => 0,
                'max'           => 24,
                'step'          => 1,
                'append'        => 'units',
                'default_value' => 16,
                'wrapper'       => ['width' => 100],
            ])
            ->addField('background_color', 'editor_palette')
                ->setConfig('default_value', 'white')
                ->setConfig('allowed_colors', ['theme-brown', 'theme-orange', 'theme-yellow', 'theme-dark-blue', 'theme-light-blue', 'theme-footer-tan', 'theme-footer-light-tan', 'white', 'black'])
                ->setConfig('return_format', 'slug');
    }

    /**
     * Shared layout data + computed inline style string.
     */
    protected function withLayout(): array
    {
        $pt = get_field('padding_top');
        $pb = get_field('padding_bottom');
        $bg = get_field('background_color');

        $pt_string = 'pt-' . floor($pt / 2) . ' md:pt-' . $pt;
        $pb_string = 'pb-' . floor($pb / 2) . ' md:pb-' . $pb;

        $padding_class = [];
        if (is_numeric($pt)) {
            $padding_class[] = $pt_string;
        }
        if (is_numeric($pb)) {
            $padding_class[] = $pb_string;
        }

        return [
            'layout' => [
                'padding_top'      => $pt,
                'padding_bottom'   => $pb,
                'background_color' => "bg-$bg",
                'padding_class'    => implode(' ', $padding_class),
            ],
        ];
    }
}
