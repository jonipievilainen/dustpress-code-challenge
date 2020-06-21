<?php
/**
 * Template Name: SingleEvent
 * Template Post Type: event
 *
 */

/**
 * Class SingleEvent
 */
class SingleEvent extends EventsModel {

    /**
     * Enable DustPress.js usage
     *
     * @var array
     */
    protected $api = [
        'Query'
    ];
    
    /**
     * Query event post for the Event page.
     *
     * @return array|bool|WP_Query
     */
    public function Query() {
        $page = get_the_ID();
        return $this->get_single_event( $page );
    }
}
