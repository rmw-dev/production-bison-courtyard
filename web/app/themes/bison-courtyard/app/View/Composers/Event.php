<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class Event extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = [
        'partials.cards.event-card',
        'single-event'      
    ];

    protected function get_date_string(){
        $start_date = get_field('event_date_start');
        $end_date = get_field('event_date_end');
        

        if ($start_date && $end_date) {
            
            if ($start_date === $end_date) {
                return $start_date;
            } else {
                return $start_date . ' — ' . $end_date;
            }
        } else {
            return '';
        }



    }

    public function with()
    {
        return [
            'date_string' => $this->get_date_string(),
        ];
    }



    /**
     * Retrieve the pagination links.
     */
    public function pagination(): string
    {
        return wp_link_pages([
            'echo' => 0,
            'before' => '<p>'.__('Pages:', 'sage'),
            'after' => '</p>',
        ]);
    }
}
