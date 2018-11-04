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
    $has_values = array();
    foreach($params as $key=>$val) {
        if( in_array($key,$meta_fields) ) {
            if( is_array($val) ) {
                $search_meta[$key] = $val;
                if($val) {
                    $has_values[] = $val;
                }
            } else {
                $clean_str = trim(preg_replace('/\s+/','', $val));
                if($clean_str) {
                    $string = trim(preg_replace('/\s+/',' ', $val));
                    $search_meta[$key] = urldecode($string);
                    $has_values[] = $string;
                }
            }
        }
    }
    
    
    $Select_From = 'SELECT meta.*, post.post_title FROM ' . $prefix . 'postmeta as meta, ' . $prefix . 'posts as post ';
    $Select_From_Post = 'SELECT post.ID as post_id, post.post_title FROM ' . $prefix . 'posts as post ';
    /* STREET ADDRESS */
    if( isset($search_meta['street']) && $search_meta['street'] ) {
        $street = $search_meta['street'];
        $sql_query = $Select_From . 'WHERE meta.meta_key="listing_street_address" AND meta.meta_value LIKE "%'.$street.'%" AND meta.post_id=post.ID AND post.post_status="publish"';
        $result = $wpdb->get_results($sql_query,OBJECT);
        $search_results = ($result) ? $result : false;
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
        
        /* Search keyword from wp_posts */
        $sql_query3 = $Select_From_Post . 'WHERE post.post_title LIKE "%'.$keyword.'%" AND post.post_type="properties" AND post.post_status="publish"';
        $result3 = $wpdb->get_results($sql_query3,OBJECT);
        if($search_results) {
            foreach($search_results as $ss) {
                $m_id = $ss->post_id;
                if($result3) {
                    foreach($result3 as $pp) {
                        $p_id = $pp->post_id;
                        if($m_id!=$p_id) {
                            $search_results[] = $pp;
                        }
                    }
                }
            }
        } else {
            $search_results = ($result3) ? $result3 : false;
        }
        
        /* Search keyword from property features meta field*/
        $sql_query4 = $Select_From . 'WHERE meta.meta_key="listing_features" AND meta.meta_value LIKE "%'.$keyword.'%" AND meta.post_id=post.ID AND post.post_status="publish"';
        $result4 = $wpdb->get_results($sql_query4,OBJECT);
        if($search_results) {
            foreach($search_results as $ss) {
                $m_id = $ss->post_id;
                if($result4) {
                    foreach($result4 as $pp) {
                        $p_id = $pp->post_id;
                        if($m_id!=$p_id) {
                            $search_results[] = $pp;
                        }
                    }
                }
            }
        } else {
            $search_results = ($result4) ? $result4 : false;
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
    
    /* CITY */
    if( isset($search_meta['city']) && $search_meta['city'] ) {
        $cities = $search_meta['city'];
        $search_results = array();
        if($result) {
            foreach($result as $row) {
                $post_id = $row->post_id;
                foreach($cities as $city) {
                    $sql_query = $Select_From . 'WHERE meta.meta_key="listing_city" AND meta.meta_value LIKE "'.$city.'" AND (meta.post_id=' . $post_id . ' AND meta.post_id=post.ID AND post.post_status="publish")';
                    $result2 = $wpdb->get_results($sql_query,OBJECT);
                    if($result2) {
                        foreach($result2 as $row2) {
                            $search_results[] =  $row2;
                        }
                    }
                }
            }
        
           

        } else {
            foreach($cities as $city) {
                $sql_query = $Select_From . 'WHERE meta.meta_key="listing_city" AND meta.meta_value LIKE "'.$city.'" AND meta.post_id=post.ID AND post.post_status="publish"';
                $result2 = $wpdb->get_results($sql_query,OBJECT);
                if($result2) {
                    foreach($result2 as $row2) {
                        $post_id = $row2->post_id;
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
    }
    
    $records = array();
    $output = array();
    if($search_results) {
        $sorted = sortObject($search_results,'post_title','ASC');
        $search_results = array_values($sorted);
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
    
    if(!$has_values) {
        $output['filter_empty'] = true;
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


function create_pagination( $links, $page, $limit, $total, $urlParams='', $list_class='pagination' ) {
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
    $html       .= '<li class="' . $class . '"><span class="cover"></span><a href="'.$base_url.'?limit=' . $limit . '&pg=' . ( $page - 1 ) . $urlParams . '">&laquo;</a></li>';
    
    
    if ( $start > 1 ) {
        $html   .= '<li><span class="cover"></span><a href="'.$base_url.'?limit=' . $limit . '&pg=1">1</a></li>';
        $html   .= '<li class="disabled"><span>...</span></li>';
    }
 
    for ( $i = $start ; $i <= $end; $i++ ) {
        $class  = ( $page == $i ) ? "active" : "";
        $html   .= '<li class="' . $class . '"><span class="cover"></span><a href="'.$base_url.'?limit=' . $limit . '&pg=' . $i . $urlParams . '">' . $i . '</a></li>';
    }
 
    if ( $end < $last ) {
        $html   .= '<li class="disabled"><span>...</span></li>';
        $html   .= '<li><span class="cover"></span><a href="'.$base_url.'?limit=' . $limit . '&pg=' . $last . $urlParams . '">' . $last . '</a></li>';
    }
    
    
    $class      = ( $page == $last ) ? "disabled" : "";
    $html       .= '<li class="' . $class . '"><span class="cover"></span><a href="'.$base_url.'?limit=' . $limit . '&pg=' . ( $page + 1 ) . $urlParams . '">&raquo;</a></li>';
    
    
 
    $html       .= '</ul>';
 
    return $html;
}


add_action("wp_ajax_do_list_filter", "do_list_filter");
add_action( 'wp_ajax_nopriv_do_list_filter', 'do_list_filter' );
function do_list_filter() {
    $meta_fields = array('street','keywords','status','city','zipcode','broker','property_type');
    $the_fields = array();
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $the_fields = $_REQUEST['fields'];
        $params = array();
        $base_url = $_REQUEST['base_url'];
        //$page = $_REQUEST['page'];
        $page = 1;
        $limit  = $_REQUEST['limit'];
        $links  = $_REQUEST['links'];
        $url_params = '?pg=' . $page . '&limit=' . $limit . '&links=' . $links;
        $pagination_params = '';
        foreach($the_fields as $a) {
            $field = $a['name'];
            $val = $a['value'];
            $params[$field] = $val;
            if( is_array($val) ) {
                //types%5B%5D=2&types%5B%5D=4&types%5B%5D=6
                //$arr_val = http_build_query($val);
                $arr_val = '';
                if($val) {
                    $j=1; foreach($val as $av) {
                        $sep = ($j>1) ? '&':'';
                        $arr_val .= $sep . $field . '%5B%5D=' . $av;
                        $j++;
                    }
                }
                $url_params .= '&' . $arr_val;
                $pagination_params .= '&' . $arr_val;
            } else {
                $arr_val = urlencode($val);
                $url_params .= '&' . $field . '=' . $arr_val;
                $pagination_params .= '&' . $field . '=' . $arr_val;
            }
            
        }
        $search_results = listing_query($params,$page,$limit);
        $records = ( isset($search_results['records']) && $search_results['records'] ) ? true : false;
        if($records) {
            $html = do_display_listings($search_results,$links,$page,$limit,$pagination_params);
        } else {
            $html = list_not_found();
        }
        
        $display_all = false;
        if( isset($search_results['filter_empty']) ) {
            $display_all = true;
        }
        $response['success'] = ($records) ? true : false;
        $response['markup'] = $html;
        $response['show_all'] = $display_all;
        $response['base_url'] = $base_url . $url_params;
        $response['main_url'] = $base_url;
        echo json_encode($response);
            
    } else {
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    die();
}

add_action( 'wp_enqueue_scripts', 'ajax_list_enqueue_scripts' );
function ajax_list_enqueue_scripts() {
	wp_enqueue_script( 'list', get_bloginfo('template_directory') . '/assets/js/listing.js', array('jquery'), '1.0', true );    
	wp_localize_script( 'list', 'listAjax', array(
		'ajax_url' => admin_url( 'admin-ajax.php' )
	));
}

require get_template_directory() . '/inc/listings-result.php';

