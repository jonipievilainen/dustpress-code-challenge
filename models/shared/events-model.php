<?php
/**
 * A events model is handle all events data.
 */

/**
 * Class EventsModel
 */

define("ACF_START_DATE","start_date");
define("ACF_END_DATE","end_date");

class EventsModel extends \DustPress\Model {

    /**
     * Binds submodules for all extending classes.
     */
    public function Submodules() {
        $this->bind_sub( 'Header' );
        $this->bind_sub( 'Footer' );
    }

    /**
     * Get all events
     *
     * @param string $date_key              Key of ACF fild
     * @param string $orderby               Event order
     * @param bool $remove_passed_events    Remove passed events
     *
     * @return array|bool|WP_Query
     */
    protected function get_all_events( $date_key = 'start_date', $orderby = 'ASC', $remove_passed_events = false ) {

        $args = [
            'post_type'                 => 'event',
            'posts_per_page'            => -1,
            'offset'                    => 0,
            'update_post_meta_cache'    => false,
            'update_post_term_cache'    => false,
            'no_found_rows'             => false,
            'query_object'              => true,
            'orderby'                   => 'order_clause',
            'order'                     => $orderby,
            'meta_query'                => array(
                'relation' => 'OR',
                'order_clause' => array(
                    'key'     => $date_key,
                    'value'   => '1',
                    'compare' => '!=',
                ),
            )
        ];

        $posts = \DustPress\Query::get_posts( $args );

        foreach ( $posts->{'posts'} as $key => $post ) {

            if ( $this->is_date_passed( $posts->{'posts'}[$key]->{'end_date'} ) ) {
                if ( $remove_passed_events ) {
                    unset( $posts->{'posts'}[$key] );
                    continue;
                } else {
                    $posts->{'posts'}[$key]->{'is_passed'} = true;
                }
            } else {
                $posts->{'posts'}[$key]->{'is_passed'} = false;
            }

            $posts->{'posts'}[$key]->{'start_date'} = get_field( ACF_START_DATE, $post );
            $posts->{'posts'}[$key]->{'end_date'} = get_field( ACF_END_DATE, $post );

        }
        
        return $posts;
    }

    /**
     * Get single event
     *
     * @param int $page     Current page ID
     *
     * @return array|bool|WP_Query
     */
    protected function get_single_event( $page ) {
        if ( $post = \DustPress\Query::get_post( $page ) ) {

            $post->{'start_date'} = get_field( ACF_START_DATE, $page );
            $post->{'end_date'} = get_field( ACF_END_DATE, $page );
            $post->{'is_passed'} = $this->is_date_passed( $post->{'end_date'} );

        }

        return $post;
    }

    /**
     * Compare current date and given date
     * 
     * @param string $date     Date
     * 
     * @return bool
     */
    private function is_date_passed( $date ) {

        $date = strtotime( $date );
        $current_date = strtotime( date( 'Y-m-d', time() ) );

        if ( $date < $current_date ) {
            return true;
        } else {
            return false;
        }
    }
}