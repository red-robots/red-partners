<?php 
/**
* Template Name: Listings Page
*/
 get_header(); 
//$params['street'] = 'One Norman';
//$params['city'] = 'Charlotte';
//$params['keywords'] = 'cafeteria';
//$params['status'] = array('Lease','Sale');
//$params['zipcode'] = array('28205','28031');
//$params['broker'] = array('78','310');
//$params['property_type'] = array('9','10');
$params = array();
$offset = 0;
$limit = 2;
$pg = ( isset($_GET['pg']) && $_GET['pg'] ) ? $_GET['pg'] : 1;
$search_results = listing_query($params,$pg,$limit);

?>


<div id="main">
    <div class="page-content">
        
        <div class="main-page-content">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        </div>
        
        <h1>Search Properties</h1>
        
        <div class="sp-form-wrapper wrapper">
            <?php get_template_part('inc/search-properties-form'); ?>
        </div>
        
        <div class="listing-outer-wrapper">
            <div class="listwrap clear wrapper">
                <?php if($search_results) { ?>
                    <?php get_template_part('inc/listings-result'); ?>
                <?php } else { ?>
                    <?php get_template_part('inc/listings'); ?>
                <?php } ?>
            </div>
        </div>
        
    </div>
</div>
<?php get_footer(); ?>