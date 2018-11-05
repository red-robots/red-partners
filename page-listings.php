<?php 
/**
* Template Name: Listings Page
*/
 get_header(); 
//$params['street'] = '26 N Main St';
//$params['city'] = array('Belmont','Charlotte');
//$params['keywords'] = 'B-2 PED';
//$params['status'] = array('Lease','Sale');
//$params['zipcode'] = array('28205','28031');
//$params['broker'] = array('78','310');
//$params['property_type'] = array('9','10');
$limit_num = 15;
$params = ( isset($_GET) ) ? $_GET : array();
$limit  = ( isset( $_GET['limit'] ) ) ? $_GET['limit'] : $limit_num;
$page   = ( isset( $_GET['pg'] ) ) ? $_GET['pg'] : 1;

$links  = ( isset( $_GET['links'] ) ) ? $_GET['links'] : 7;
$search_results = listing_query($params,$page,$limit);
$has_result = ( isset($search_results['records']) && $search_results['records'] ) ? true : false;
$meta_fields = array('street','keywords','status','city','zipcode','broker','property_type');
$queried = array();
$pagination_params = '';

if($params) {
    foreach($params as $k=>$val) {
        if( in_array($k,$meta_fields) ) {
            $queried[$k] = $val;
            if( is_array($val) ) {
                $arr_val = '';    
                if($val) {
                    $j=1; foreach($val as $av) {
                        $sep = ($j>1) ? '&':'';
                        $arr_val .= $sep . $k . '%5B%5D=' . $av;
                        $j++;
                    }
                }
                $pagination_params .= '&' . $arr_val;
            } else {
                $arr_val = urlencode($val);
                $pagination_params .= '&' . $k . '=' . $arr_val;
            }
        }
    }
}
?>


<div id="main" class="clear contentwrapper">
    <div id="mainContent" class="page-content clear wrapper">
        
        <div class="main-page-content">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php the_content(); ?>
            <?php endwhile; ?>
        </div>
        
        <div class="sp-form-wrapper wrapper">
            <?php get_template_part('inc/search-properties-form'); ?>
        </div>
        
        <div class="spinner-wrapper wrapper clear">
            <div id="spinner"> <div class="sk-circle"> <div class="sk-circle1 sk-child"></div><div class="sk-circle2 sk-child"></div><div class="sk-circle3 sk-child"></div><div class="sk-circle4 sk-child"></div><div class="sk-circle5 sk-child"></div><div class="sk-circle6 sk-child"></div><div class="sk-circle7 sk-child"></div><div class="sk-circle8 sk-child"></div><div class="sk-circle9 sk-child"></div><div class="sk-circle10 sk-child"></div><div class="sk-circle11 sk-child"></div><div class="sk-circle12 sk-child"></div></div></div>
        </div>
        
        <div class="listing-outer-wrapper wrapper clear">
            <div id="list_container" class="listwrap clear wrapper">
                <?php if($queried) { ?>
                    <?php if($has_result) { ?>
                        <?php 
                        $current_page = ( isset( $_GET['pg'] ) ) ? $_GET['pg'] : 1;    
                        echo do_display_listings($search_results,$links, $current_page, $limit, $pagination_params); ?>
                    <?php } else { ?>
                        <?php echo list_not_found(); ?>
                    <?php } ?>
                <?php } else { ?>
                    <?php get_template_part('inc/listings-all'); ?>
                <?php } ?>
            </div>
        </div>
        
        <div id="pageErrors" class="clear wrapper"></div>
        
    </div>
</div>
<?php get_footer(); ?>