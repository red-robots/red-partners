<?php
$us_states = listing_states();
$statuses = listing_status();
$cities = listing_cities();
$zipcodes = listing_zipcodes();
$brokers = listing_brokers();
$property_types = listing_property_types();

?>
<div class="sp_form clear">
    <div class="row clear">
        <form id="listingFilter" class="search-properties-form" method="GET">
            <div class="prop-form-inner clear">
                <div class="form-group fieldwrap street_address">
                    <div class="inputdiv">
                        <input type="text" name="street" id="street" class="form-control" placeholder="Street Address" />  
                        <a href="#" class="street_button btn">Update</a>
                    </div>
                </div>

                <div class="form-group fieldwrap keywords">
                    <div class="inputdiv">
                        <input type="text" name="keywords" id="keywords" class="form-control" placeholder="Keywords" />  
                        <a href="#" class="street_button btn">Update</a>
                    </div>
                </div>

                <div class="form-group searchfield selection-field">
                    <select id="listing_status" class="mdb-select" multiple name="status">
                        <option value="" disabled selected>Status</option>
                        <?php if($statuses) { ?>
                            <?php foreach($statuses as $k=>$label) { ?>
                            <option value="<?php echo $k;?>"><?php echo $label;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group searchfield selection-field">
                    <select id="listing_city" class="mdb-select" multiple name="city">
                        <option value="" disabled selected>City</option>
                        <?php if($cities) { ?>
                            <?php foreach($cities as $c) { ?>
                            <option value="<?php echo $c->meta_value;?>"><?php echo $c->meta_value;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group searchfield selection-field">
                    <select id="listing_zipcode" class="mdb-select" multiple name="zipcode">
                        <option value="" disabled selected>City</option>
                        <?php if($zipcodes) { ?>
                            <?php foreach($zipcodes as $z) { ?>
                            <option value="<?php echo $z->meta_value;?>"><?php echo $z->meta_value;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group searchfield selection-field">
                    <select id="listing_broker" class="mdb-select" multiple name="broker">
                        <option value="" disabled selected>City</option>
                        <?php if($brokers) { ?>
                            <?php foreach($brokers as $b) { ?>
                            <option value="<?php echo $b->ID;?>"><?php echo $b->post_title;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group searchfield selection-field">
                    <select id="listing_property_type" class="mdb-select" multiple name="property_type">
                        <option value="" disabled selected>City</option>
                        <?php if($property_types) { ?>
                            <?php foreach($property_types as $pt) { ?>
                            <option value="<?php echo $pt->term_id;?>"><?php echo $pt->name;?></option>
                            <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group button-wrap">
                    <button id="reset_filter" type="reset" class="btn reset-btn">Clear</button>
                </div>
            </div>
        </form>
    </div>    
</div>    