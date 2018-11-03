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

function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

function listing_query($params,$offset=0,$limit=15) {
    global $wpdb;
    $prefix = $wpdb->prefix;
    $meta_fields = array('street','keywords','status','city','zipcode','broker','property_type');
    $sql_query = '';
    $result = array();
    $search_meta = array();
    $search_results = array();
    foreach($params as $key=>$val) {
        if( in_array($key,$meta_fields) ) {
            if( is_array($val) ) {
                $search_meta[$key] = $val;
            } else {
                $search_meta[$key] = urldecode($val);
            }
        }
    }
    
    
    $Select_From = 'SELECT meta.*, post.post_title FROM ' . $prefix . 'postmeta as meta, ' . $prefix . 'posts as post ';
    /* STREET ADDRESS */
    if( isset($search_meta['street']) && $search_meta['street'] ) {
        $street = $search_meta['street'];
        $sql_query = $Select_From . 'WHERE meta.meta_key="listing_street_address" AND meta.meta_value LIKE "%'.$street.'%" AND meta.post_id=post.ID AND post.post_status="publish"';
        $result = $wpdb->get_results($sql_query,OBJECT);
        $search_results = ($result) ? $result : false;
    }

    /* CITY */
    if( isset($search_meta['city']) && $search_meta['city'] ) {
        $city = $search_meta['city'];
        $search_results = array();
        if($result) {
            foreach($result as $row) {
                $post_id = $row->post_id;
                $sql_query = $Select_From . 'WHERE meta.meta_key="listing_city" AND meta.meta_value LIKE "%'.$city.'%" AND (meta.post_id=' . $post_id . ' AND meta.post_id=post.ID AND post.post_status="publish")';
                $result = $wpdb->get_results($sql_query,OBJECT);
                if($result) {
                    foreach($result as $row2) {
                        $search_results[] =  $row2;
                    }
                }
            }

        } else {
            $sql_query = $Select_From . 'WHERE meta.meta_key="listing_city" AND meta.meta_value LIKE "%'.$city.'%" AND meta.post_id=post.ID AND post.post_status="publish"';
            $result = $wpdb->get_results($sql_query,OBJECT);
            $search_results = ($result) ? $result : false;
        }

        $result = $search_results;
    }


    /* KEYWORDS */
    if( isset($search_meta['keywords']) && $search_meta['keywords'] ) {
        $keyword = $search_meta['keywords'];
        $search_results = array();
        if($result) {
            foreach($result as $row) {
                $post_id = $row->post_id;
                $sql_query = $Select_From . 'WHERE meta.meta_key="listing_keyword" AND meta.meta_value LIKE "%'.$keyword.'%" AND (meta.post_id=' . $post_id . ' AND meta.post_id=post.ID AND post.post_status="publish")';
                $result2 = $wpdb->get_results($sql_query,OBJECT);
                if($result2) {
                    foreach($result2 as $row2) {
                        //$i_keywords = ($row2->meta_value) ? explode(',',$row2->meta_value) : '';
                        //$row2->keywords = $i_keywords;
                        $search_results[] =  $row2;
                    }
                }
            }

        } else {
            $sql_query = $Select_From . 'WHERE meta.meta_key="listing_keyword" AND meta.meta_value LIKE "%'.$keyword.'%" AND meta.post_id=post.ID AND post.post_status="publish"';
            $result = $wpdb->get_results($sql_query,OBJECT);
            $search_results = ($result) ? $result : false;
        }

        $result = $search_results;
    }

    /* STATUS */
    if( isset($search_meta['status']) && $search_meta['status'] ) {
        $statuses = $search_meta['status'];
        $search_results = array();
        if($result) {
            foreach($result as $row) {
                $post_id = $row->post_id;
                foreach($statuses as $status) {
                    $sql_query = $Select_From . 'WHERE meta.meta_key="listing_status" AND meta.meta_value LIKE "'.$status.'" AND (meta.post_id=' . $post_id . ' AND meta.post_id=post.ID AND post.post_status="publish")';
                    $result2 = $wpdb->get_results($sql_query,OBJECT);
                    if($result2) {
                        foreach($result2 as $row2) {
                            $row2->status = get_field('listing_status',$post_id);
                            $search_results[] =  $row2;
                        }
                    }
                }
            }

        } else {
            foreach($statuses as $status) {
                $sql_query = $Select_From . 'WHERE meta.meta_key="listing_status" AND meta.meta_value LIKE "'.$status.'" AND meta.post_id=post.ID AND post.post_status="publish"';
                $result2 = $wpdb->get_results($sql_query,OBJECT);
                if($result2) {
                    foreach($result2 as $row2) {
                        $post_id = $row2->post_id;
                        $row2->status = get_field('listing_status',$post_id);
                        $search_results[] =  $row2;
                    }
                }
            }
        }

        $result = $search_results;
    }

    /* ZIP CODE */
    if( isset($search_meta['zipcode']) && $search_meta['zipcode'] ) {
        $zipcodes = $search_meta['zipcode'];
        $search_results = array();
        if($result) {
            foreach($result as $row) {
                $post_id = $row->post_id;
                foreach($zipcodes as $zip) {
                    $sql_query = $Select_From . 'WHERE meta.meta_key="listing_zip_code" AND meta.meta_value LIKE "'.$zip.'" AND (meta.post_id=' . $post_id . ' AND meta.post_id=post.ID AND post.post_status="publish")';
                    $result2 = $wpdb->get_results($sql_query,OBJECT);
                    if($result2) {
                        foreach($result2 as $row2) {
                            $row2->zipcode = get_field('listing_zip_code',$post_id);
                            $search_results[] =  $row2;
                        }
                    }
                }
            }
        } else {
            foreach($zipcodes as $zip) {
                $sql_query = $Select_From . 'WHERE meta.meta_key="listing_zip_code" AND meta.meta_value LIKE "'.$zip.'" AND meta.post_id=post.ID AND post.post_status="publish"';
                $result2 = $wpdb->get_results($sql_query,OBJECT);
                if($result2) {
                    foreach($result2 as $row2) {
                        $post_id = $row2->post_id;
                        $row2->zipcode = get_field('listing_zip_code',$post_id);
                        $search_results[] =  $row2;
                    }
                }
            }
        }

        $result = $search_results;
    }


    /* BROKER */
    if( isset($search_meta['broker']) && $search_meta['broker'] ) {
        $brokers = $search_meta['broker'];
        $search_results = array();
        if($result) {
            foreach($result as $row) {
                $post_id = $row->post_id;
                foreach($brokers as $broker_id) {
                    $sql_query = $Select_From . 'WHERE meta.meta_key="listing_broker" AND meta.meta_value = '.$broker_id.' AND (meta.post_id=' . $post_id . ' AND meta.post_id=post.ID AND post.post_status="publish")';
                    $result2 = $wpdb->get_results($sql_query,OBJECT);
                    if($result2) {
                        foreach($result2 as $row2) {
                            $row2->broker_name = get_the_title($broker_id);
                            $search_results[] =  $row2;
                        }
                    }
                }
            }
        } else {
            foreach($brokers as $broker_id) {
                $sql_query = $Select_From . 'WHERE meta.meta_key="listing_broker" AND meta.meta_value = '.$broker_id.' AND meta.post_id=post.ID AND post.post_status="publish"';
                $result2 = $wpdb->get_results($sql_query,OBJECT);
                if($result2) {
                    foreach($result2 as $row2) {
                        $post_id = $row2->post_id;
                        $row2->broker_name = get_the_title($broker_id);
                        $search_results[] =  $row2;
                    }
                }
            }
        }

        $result = $search_results;
    }
    
    /* PROPERTY TYPE */
    if( isset($search_meta['property_type']) && $search_meta['property_type'] ) {
        $types = $search_meta['property_type'];
        $Select_From2 = 'SELECT term.term_taxonomy_id as term_id, term.object_id as post_id, post.post_title FROM ' . $prefix . 'term_relationships as term, ' . $prefix . 'posts as post ';
        $search_results = array();
        if($result) {
            foreach($result as $row) {
                $post_id = $row->post_id;
                foreach($types as $term_id) {
                    $sql_query = $Select_From2 . 'WHERE term.term_taxonomy_id='.$term_id.' AND term.object_id='.$post_id.' AND term.object_id=post.ID AND post.post_status="publish"';
                    $result2 = $wpdb->get_results($sql_query,OBJECT);
                    if($result2) {
                        foreach($result2 as $row2) {
                            $search_results[] =  $row2;
                        }
                    }
                }
            }
        } else {
            foreach($types as $term_id) {
                $sql_query = $Select_From2 . 'WHERE term.term_taxonomy_id='.$term_id.' AND term.object_id=post.ID AND post.post_status="publish"';
                $result2 = $wpdb->get_results($sql_query,OBJECT);
                if($result2) {
                    foreach($result2 as $row2) {
                        $search_results[] =  $row2;
                    }
                }
            }
        }
        
        $lists = array();
        if($search_results) {
            foreach($search_results as $sr) {
                $id = $sr->post_id;
                $lists[$id] = $sr;
            }
        }
        
        $search_results = ($lists) ? array_values($lists) : '';
        $result = $search_results;   
        $sorted = sortObject($search_results,'post_title','ASC');
        $search_results = array_values($sorted);
    }
    
    $records = array();
    $output = array();
    
    if($search_results) {
        $total = count($search_results);
        $start = $offset;
        $x = $start*$limit;
        $start = $x-$limit;
        if($offset==0) {
            $max = $limit;
        } else {
            $max = $start + $limit;
        }        
        
        for($x=$start; $x<$max; $x++) {
            if( isset($search_results[$x]) ) {
                $item = $search_results[$x];
                $records[$x] = $item;
            } 
        }
        
        
        $output['records'] = $records;
        $output['total'] = $total;
        
    }	
        
    return $output;
    
}


function sortObject($array, $key, $sort='ASC') {
    $sorter=array();
    $ret=array();
    reset($array);
    foreach ($array as $ii => $va) {
        $sorter[$ii]=$va->$key;
    }   
    if($sort=='ASC') {
    	asort($sorter);
    } else {
    	arsort($sorter);
    }
    foreach ($sorter as $ii => $va) {
        $ret[$ii]=$array[$ii];
    }
    $array=$ret;
    return $array;
}


function create_pagination( $links, $page, $limit, $total, $list_class='pagination' ) {
    if ( $limit == 'all' ) {
        return '';
    }
    
    global $post;
    $post_id = $post->ID;
    $base_url = get_permalink($post_id);
 
    $last       = ceil( $total / $limit );
 
    $start      = ( ( $$page - $links ) > 0 ) ? $page - $links : 1;
    $end        = ( ( $page + $links ) < $last ) ? $page + $links : $last;
 
    $html       = '<ul class="' . $list_class . '">';
 

    $class      = ( $page == 1 ) ? "disabled" : "";
    $html       .= '<li class="' . $class . '"><span class="cover"></span><a href="'.$base_url.'?limit=' . $limit . '&pg=' . ( $page - 1 ) . '">&laquo;</a></li>';
    
    
    if ( $start > 1 ) {
        $html   .= '<li><span class="cover"></span><a href="'.$base_url.'?limit=' . $limit . '&pg=1">1</a></li>';
        $html   .= '<li class="disabled"><span>...</span></li>';
    }
 
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $page == $i ) ? "active" : "";
        $html   .= '<li class="' . $class . '"><span class="cover"></span><a href="'.$base_url.'?limit=' . $limit . '&pg=' . $i . '">' . $i . '</a></li>';
    }
 
    if ( $end < $last ) {
        $html   .= '<li class="disabled"><span>...</span></li>';
        $html   .= '<li><span class="cover"></span><a href="'.$base_url.'?limit=' . $limit . '&pg=' . $last . '">' . $last . '</a></li>';
    }
    
    
    $class      = ( $page == $last ) ? "disabled" : "";
    $html       .= '<li class="' . $class . '"><span class="cover"></span><a href="'.$base_url.'?limit=' . $limit . '&pg=' . ( $page + 1 ) . '">&raquo;</a></li>';
    
    
 
    $html       .= '</ul>';
 
    return $html;
}

