<?php  
function do_display_listings($search_results,$links,$page,$limit,$urlParams=null) {    
    if ( $search_results ) { 
    $records = $search_results['records'];
    $total_pages = $search_results['total'];
    $items_text = ($total_pages>1) ? ' items':' item';
    ob_start();
        
    if( $records) { ?>
    <div class="property-lists clear wrapper">
    <div class="found-info">
        <strong>Result: <?php echo $total_pages . $items_text;?> found</strong>
    </div>
    
    <?php $i=1; 
    foreach($records as $row) { 
        $post_id = $row->post_id;
        $pic = get_field('listing_image',$post_id);
        $types = get_the_terms($post_id,'property_types');
        $the_types = '';
        if($types) {
            $j=1; foreach($types as $t) {
                $comma = ($j>1) ? ', ':'';
                $the_types .= $comma . $t->name;
            $j++; }
        }
        $divClass = ($i % 2==0) ? 'even':'odd';   

        $street_address = get_field('listing_street_address',$post_id);
        $city = get_field('listing_city',$post_id);
        $state = get_field('listing_state',$post_id);
        $zip = get_field('listing_zip_code',$post_id);
        $loc_info = array($city,$state);
        $parts = ($loc_info) ? array_filter($loc_info) : '';
        if($parts) {
            $addtl = implode(", ",$parts);
            $street_address .= '<br>' . $addtl . ' ' . $zip;
        } else {
            if($zip) {
                $street_address .= '<br>' . $zip;
            }
        }

        $availability = get_field('listing_availability',$post_id);
        $status = get_field('listing_status',$post_id);
        $features = get_field('listing_features',$post_id);
        $pdf = get_field('listing_pdf_link',$post_id);
        $pdf_link = ($pdf) ? $pdf['url'] : '';
        $first_row = ($i==1) ? ' first':'';
    ?>
    <div id="property_<?php echo $post_id;?>" class="property clear <?php echo $divClass . $first_row;?>">
        <div class="imagecol">
            <?php if($the_types) { ?>
            <div class="types">
                <?php echo $the_types; ?>
            </div>
            <?php } ?>

            <?php if($pic) { ?>
            <div class="img"><img src="<?php echo $pic['url']?>" alt="<?php echo $pic['title']?>" /></div>
            <?php } else { ?>
            <div class="no-img"><i class="dashicons dashicons-admin-home"></i></div>
            <?php } ?>
        </div> 

        <div class="infoCol">
            <div class="location">
                <div class="pad clear">
                    <h3 class="property-name"><?php echo get_the_title($post_id); ?></h3>
                    <?php if($street_address) { ?>
                    <div class="info"><?php echo $street_address;?></div>
                    <?php } ?>
                    <?php if($availability && $status) { ?>
                    <div class="info"><?php echo $availability;?> - <?php echo $status;?></div>
                    <?php } ?>
                </div>    
            </div>
            <div class="features">
                <div class="pad clear">
                    <?php if($city) { ?>
                    <div class="info"><span class="city"><?php echo $city;?></span></div>
                    <?php } ?>
                    <?php if($features) { ?>
                    <div class="info"><?php echo $features;?></div>
                    <?php } ?>
                </div>
            </div>
            <div class="details">
                <?php if($pdf_link) { ?>
                <a class="plink" href="<?php echo $pdf_link;?>" target="_blank">View Property</a>
                <?php } ?>
            </div>
        </div>    

    </div>
    <?php $i++; } ?>


    <div id="pagination" class="pagination-wrapper clear">
    <?php   
        echo create_pagination( $links, $page, $limit, $total_pages, $urlParams, 'pagination' );
    ?>
    </div>
                             
</div>   
    <?php } else { ?>
        <?php echo list_not_found(); ?>
    <?php } ?>
<?php } 
    
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
    
}

function list_not_found() { 
    ob_start(); ?>
    <div class="notfound">No records found.</div>
<?php
    $html = ob_get_contents();
    ob_end_clean();
    return $html;
}
