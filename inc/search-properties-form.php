<?php
$us_states = listing_states();
$statuses = listing_status();
$cities = listing_cities();
$zipcodes = listing_zipcodes();
$brokers = listing_brokers();
$property_types = listing_property_types();
$limit = ( isset($_GET['limit']) && $_GET['limit'] ) ? $_GET['limit'] : 2;
$links = 7;
$pg = ( isset($_GET['pg']) && $_GET['pg'] ) ? $_GET['pg'] : 1;
global $post;
$post_id = $post->ID;
$current_url = get_permalink($post_id);
?>
<div class="sp_form clear">
    <div class="row clear">
        <form id="listingFilter" class="search-properties-form clear" method="GET" data-formstat="">
            <div class="cover"></div>
            <input type="hidden" name="page" class="page" value="<?php echo $pg;?>" /> 
            <input type="hidden" name="limit" class="limit" value="<?php echo $limit;?>" /> 
            <input type="hidden" name="links" class="links" value="<?php echo $links;?>" /> 
            <input type="hidden" name="current_url" class="current_url" value="<?php echo get_permalink($post_id);?>" /> 
            <div class="prop-form-inner clear">
                
                <?php
                    $s_street = ( isset($_GET['street']) && $_GET['street'] ) ? $_GET['street'] : '';
                ?>
                <div class="form-group fieldwrap street_address">
                    <div class="inputdiv">
                        <input type="text" name="street" id="street" class="form-control the-field" placeholder="Street Address" value="<?php echo $s_street;?>" />  
                        <a href="#" class="street_button btn">Update</a>
                    </div>
                </div>
                
                <?php
                    $s_keywords = ( isset($_GET['keywords']) && $_GET['keywords'] ) ? $_GET['keywords'] : '';
                ?>
                <div class="form-group fieldwrap keywords">
                    <div class="inputdiv">
                        <input type="text" name="keywords" id="keywords" class="form-control the-field" placeholder="Keywords" value="<?php echo $s_keywords;?>" />  
                        <a href="#" class="street_button btn">Update</a>
                    </div>
                </div>
                
                <?php
                    $s_status = ( isset($_GET['status']) && $_GET['status'] ) ? $_GET['status'] : '';
                ?>
                <div class="form-group searchfield selection-field">
                    <select id="listing_status" class="mdb-select the-field" multiple name="status">
                        <option value="" disabled selected>Status</option>
                        <?php if($statuses) { ?>
                            <?php foreach($statuses as $status) { 
                                $selected_status = '';
                                if($s_status) {
                                    if( in_array($status,$s_status) ) {
                                        $selected_status = ' selected';
                                    }
                                }
                            ?>
                            <option value="<?php echo $status;?>"<?php echo $selected_status;?>><?php echo $status;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                
                <?php
                    $s_cities = ( isset($_GET['city']) && $_GET['city'] ) ? $_GET['city'] : '';
                ?>
                <div class="form-group searchfield selection-field">
                    <select id="listing_city" class="mdb-select the-field" multiple name="city">
                        <option value="" disabled selected>City</option>
                        <?php if($cities) { ?>
                            <?php foreach($cities as $c) { 
                                $city_name = $c->meta_value;
                                $city_selected = '';
                                if($s_cities) {
                                    if( in_array($city_name,$s_cities) ) {
                                        $city_selected = ' selected';
                                    }
                                }
                            ?>
                            <option value="<?php echo $city_name;?>"<?php echo $city_selected;?>><?php echo $city_name;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                
                <?php
                    $s_zipcodes = ( isset($_GET['zipcode']) && $_GET['zipcode'] ) ? $_GET['zipcode'] : '';
                ?>
                <div class="form-group searchfield selection-field">
                    <select id="listing_zipcode" class="mdb-select the-field" multiple name="zipcode">
                        <option value="" disabled selected>City</option>
                        <?php if($zipcodes) { ?>
                            <?php foreach($zipcodes as $z) { 
                                $zip_code = $z->meta_value;
                                $zip_selected = '';
                                if($s_zipcodes) {
                                    if( in_array($zip_code,$s_zipcodes) ) {
                                        $zip_selected = ' selected';
                                    }
                                }
                            ?>
                            <option value="<?php echo $zip_code;?>"<?php echo $zip_selected;?>><?php echo $zip_code;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                
                <?php
                    $s_brokers = ( isset($_GET['broker']) && $_GET['broker'] ) ? $_GET['broker'] : '';
                ?>
                <div class="form-group searchfield selection-field">
                    <select id="listing_broker" class="mdb-select the-field" multiple name="broker">
                        <option value="" disabled selected>City</option>
                        <?php if($brokers) { ?>
                            <?php foreach($brokers as $b) { 
                                $broker_id = $b->ID;
                                $selected_broker = '';
                                if($s_brokers) {
                                    if( in_array($broker_id,$s_brokers) ) {
                                        $selected_broker = ' selected';
                                    }
                                }
                            ?>
                            <option value="<?php echo $broker_id;?>"<?php echo $selected_broker;?>><?php echo $b->post_title;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>
                
                <?php
                    $s_property_type = ( isset($_GET['property_type']) && $_GET['property_type'] ) ? $_GET['property_type'] : '';
                ?>
                <div class="form-group searchfield selection-field">
                    <select id="listing_property_type" class="mdb-select the-field" multiple name="property_type">
                        <option value="" disabled selected>City</option>
                        <?php if($property_types) { ?>
                            <?php foreach($property_types as $pt) { 
                                $term_id = $pt->term_id;
                                $selected_type = '';
                                if($s_property_type) {
                                    if( in_array($term_id,$s_property_type) ) {
                                        $selected_type = ' selected';
                                    }
                                }
                            ?>
                            <option value="<?php echo $term_id;?>"<?php echo $selected_type;?>><?php echo $pt->name;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group button-wrap">
                    <button data-url="<?php echo $current_url;?>" id="reset_filter" type="reset" class="btn reset-btn">Clear</button>
                </div>
            </div>
        </form>
    </div>    
</div>    