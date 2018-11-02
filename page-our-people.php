<?php 
/**
* Template Name: Our People
*/
 get_header(); ?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div id="main">

<div class="page-content">

<div id="our-people-row1">

<div id="our-people-quote"><?php the_field("quote"); ?></div>

     <h1><?php the_title(); ?></h1>
     <?php the_content(); ?><?php endwhile; endif; ?>
     
     </div>
     


<?php /* Second Custom Query pulling the post type, "Our People" */  
	$args = array( 
            'post_type' => array('our-people'), // In an array so You can list multiple Custom Post Types if you want ('blog', 'another_post_type')
            'posts_per_page' => '-1', // # of posts to show use -1 for all posts.    
            );
            $query = new WP_Query( $args );  // Query all of your arguments from above
           ?>
           <?php if (have_posts()) : while( $query->have_posts() ) : $query->the_post(); // the loop ?>

     <div id="our-people-box">
     
     <div id="our-people-image"><a href="<?php the_permalink() ?>"><img src="<?php the_field("photo"); ?>" border="0"></a></div>
     
  <div id="our-people-text">        
     
     <h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
     
     
     
     
     <!-- telephone -->
<?php
$tnumber	= get_field('telephone_number');
if( ($tnumber) )
{
	echo 'T. ';
}
?><?php the_field("telephone_number"); ?>
<!-- / telephone -->  

<!-- direct -->
<?php
$dnumber	= get_field('direct_number');
if( ($dnumber) )
{
	echo '<br>D. ';
}
?><?php the_field("direct_number"); ?>
<!-- / direct -->  

<!-- fax -->
<?php
$fnumber	= get_field('fax_number');
if( ($fnumber) )
{
	echo '<br>F. ';
}
?><?php the_field("fax_number"); ?>
<!-- / fax -->   
     
<!-- cell -->
<?php
$cnumber	= get_field('cell_number');
if( ($cnumber) )
{
	echo '<br>C. ';
}
?><?php the_field("cell_number"); ?>
<!-- / cell -->  

<!-- -->
     <p><a href="mailto: <?php the_field("email"); ?>"><?php the_field("email"); ?></a>

     <div id="vcard-white"><a href="<?php the_field("vcard"); ?>">vcard <img src="<?php bloginfo('template_url'); ?>/images/vcard-white.png" alt="" style="width: 31px; height: 22px; float: right;" border="0" align="right"></a></div>
     
     <!-- -->
     
     
 <div class="plus"><a href="<?php the_permalink() ?>">+</a></div>  
 
 </div>  
     
     </div>
     
           
        <?php  endwhile; endif; wp_reset_postdata();  // close loop and reset the query ?>
     
     
     
 </div><!-- / page content -->




<?php //get_sidebar(); ?>
<?php get_footer(); ?>