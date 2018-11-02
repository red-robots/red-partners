<?php 
/**
* Template Name: For Sale Listings Page
*/
 get_header(); ?>


<div id="main">





<div class="page-content">




<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
     <h1><?php the_title(); ?></h1>
     <?php the_content(); ?>
     
     

          
<div id="framed">

<iframe src="http://direct.xceligent.com/A703AFDD0FB4330F214260AC?showHeader=false" frameborder="0" width="730" height="650"></iframe>



<!-- old <iframe src="http://www.siteindexcharlotte.com/cpelink/index.cfm?LinkID=90" frameborder="0" width="730" height="650"></iframe><iframe src="http://www.siteindexcharlotte.com/cpelink/index.cfm?LinkID=90&lmethod=Sale" frameborder="0" width="730" height="650"></iframe> -->

</div>



   <?php endwhile; endif; ?>  

 <!-- content -->


<div id="services-our-people">

<?php
$wp_query = new WP_Query();
$wp_query->query(array(
'post_type'=>'our-people', // your custom post type
'posts_per_page' => -1,
'tax_query' => array(
array(
'taxonomy' => 'category', // your custom taxonomy
'field' => 'slug',
'terms' => 'brokerage' // the terms (categories) you created
)
)
));
if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>

<div class="services-our-people-box">

<div class="services-our-people-image"><a href="<?php the_permalink() ?>"><img src="<?php the_field("photo"); ?>" border="0"></a></div>

<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>

<!-- direct -->
<?php
$dnumber	= get_field('direct_number');
if( ($dnumber) )
{
	echo '<p>D. ';
}
?><?php the_field("direct_number"); ?>
<!-- / direct --> 

<!-- cell -->
<?php
$cnumber	= get_field('cell_number');
if( ($cnumber) )
{
	echo '<p>C. ';
}
?><?php the_field("cell_number"); ?>
<!-- / cell -->  

<br><a href="mailto: <?php the_field("email"); ?>"><?php the_field("email"); ?></a>

     <div id="vcard-white"><a href="<?php the_field("vcard"); ?>">vcard <img src="<?php bloginfo('template_url'); ?>/images/vcard-white.png" alt="" style="width: 31px; height: 22px; float: right;" border="0" align="right"></a></div>


 <div class="plus"><a href="<?php the_permalink() ?>">+</a></div>  

</div>

<?php  endwhile; endif; wp_reset_postdata();  // close loop and reset the query ?>



</div>



<!-- / content -->    
     
 </div><!-- / page content -->




<?php //get_sidebar(); ?>
<?php get_footer(); ?>