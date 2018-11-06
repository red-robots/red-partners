<?php 
$perpage = 15;
$paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
$args = array(
    'posts_per_page'   => $perpage,
    'orderby'          => 'date',
    'order'            => 'DESC',
    'post_type'        => 'properties',
    'post_status'      => 'publish',
    'paged'			   => $paged
    );
$items = new WP_Query($args);
if ( $items->have_posts() ) { ?>
<div class="property-lists clear">
    <div class="all-list clear">
        <?php $i=1; while ( $items->have_posts() ) : $items->the_post(); 
            $post_id = get_the_ID();
            $pic = get_field('listing_image',$post_id);
            $pic_url = ($pic) ? $pic['sizes']['medium_large'] : '';
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
        <div id="property_<?php the_ID();?>" class="property clear <?php echo $divClass . $first_row;?>">
            <div class="imagecol">
                <?php if($the_types) { ?>
                <div class="types">
                    <?php echo $the_types; ?>
                </div>
                <?php } ?>

                <?php if($pic) { ?>
                <div class="img"><a href="<?php echo $pic['url']?>" class="popup" title="<?php the_title(); ?>"><img src="<?php echo $pic_url?>" alt="<?php echo $pic['title']?>" /></a></div>
                <?php } else { ?>
                <div class="no-img"><i class="dashicons dashicons-admin-home"></i></div>
                <?php } ?>
            </div> 

            <div class="infoCol">
                <div class="location">
                    <div class="pad clear">
                        <h3 class="property-name"><?php the_title(); ?></h3>
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
        <?php $i++; endwhile; wp_reset_postdata(); ?>

        <?php $total_pages = $items->max_num_pages;
        if ($total_pages > 1) { ?>
            <div id="pagination" class="pagination-wrapper clear">
            <?php
                $big = 999999999;
                $pagination = array(
                    'base' => @add_query_arg('pg','%#%'),
                    'format' => '?paged=%#%',
                    'current' => $paged,
                    'total' => $total_pages,
                    'prev_text' => __( '&laquo;', 'red_partners' ),
                    'next_text' => __( '&raquo;', 'red_partners' ),
                    'type' => 'plain'
                );
                echo paginate_links($pagination);
            ?>
            </div>
        <?php } ?> 
    </div>       
</div>                      
<?php } ?>
