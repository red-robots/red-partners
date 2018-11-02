<?php
function listing_states() {
    global $wpdb;
    $row = $wpdb->get_row( "SELECT post_content FROM {$wpdb->prefix}posts WHERE post_type='acf-field' AND post_excerpt='listing_state'", OBJECT );
    $choices = '';
    if($row) {
        $result = unserialize($row->post_content);
        if( isset($result['choices']) && $result['choices'] ) {
            $choices = $result['choices'];
        }
    }
    return $choices;
}

function listing_status() {
    global $wpdb;
    $row = $wpdb->get_row( "SELECT post_content FROM {$wpdb->prefix}posts WHERE post_type='acf-field' AND post_excerpt='listing_status'", OBJECT );
    $choices = '';
    if($row) {
        $result = unserialize($row->post_content);
        if( isset($result['choices']) && $result['choices'] ) {
            $choices = $result['choices'];
        }
    }
    return $choices;
}

function listing_cities() {
    global $wpdb;
    $result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key='listing_city' GROUP BY meta_value ORDER BY meta_value ASC", OBJECT );
    return ($result) ? $result : false;
}

function listing_zipcodes() {
    global $wpdb;
    $result = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}postmeta WHERE meta_key='listing_zip_code' GROUP BY meta_value ORDER BY meta_value ASC", OBJECT );
    return ($result) ? $result : false;
}

function listing_brokers() {
    global $wpdb;
    $result = $wpdb->get_results( "SELECT ID, post_title FROM {$wpdb->prefix}posts WHERE post_type='our-people' AND post_status='publish' ORDER BY post_title ASC", OBJECT );
    return ($result) ? $result : false;
}

function listing_property_types() {
    $terms = get_terms( array(
        'taxonomy' => 'property_types',
        'hide_empty' => false,
    ) );
    return ($terms) ? $terms : false;
}