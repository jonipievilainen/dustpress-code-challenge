<?php
/**
 * Template Name: PageEvents
 * Template Post Type: page
 *
 * This template needs a page to function!
 */

/**
 * Class SingleEvent
 */
class PageEvents extends EventsModel {

    /**
     * Enable DustPress.js usage
     *
     * @var array
     */
    protected $api = [
        'Query'
    ];

    /**
     * All events posts for the Events page.
     *
     * @return array|bool|WP_Query
     */
    public function All() {
        return $this->get_all_events( 'start_date', 'DESC', true );
    }

    /**
     * Upcoming events posts for the Events page.
     *
     * @return array|bool|WP_Query
     */
    public function Upcoming() {
        return $this->get_all_events( 'start_date', 'DESC', false );
    }
}
