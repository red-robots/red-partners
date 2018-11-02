<?php 
/**
* Template Name: Portfolio Page
*/
 get_header(); ?>


<div id="main">


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


<div class="page-content">
<div id="our-people-row1">

<div id="our-people-quote"><?php the_field("quote"); ?></div>

     <h1><?php the_title(); ?></h1>
     <?php the_content(); ?><?php endwhile; endif; ?>
     
     </div>
     
<!-- posts -->
<div id="portfolio">



<?php /* Second Custom Query pulling the post type, "Newsletters" */  
           $args = array( 
            'post_type' => array('portfolio'), // In an array so You can list multiple Custom Post Types if you want ('blog', 'another_post_type')
            'posts_per_page' => '-1', // # of posts to show use -1 for all posts.    
            );
            $query = new WP_Query( $args );  // Query all of your arguments from above
           ?>
           <?php if (have_posts()) : while( $query->have_posts() ) : $query->the_post(); // the loop ?>
           

<div class="portfolio-item">
<div class="portfolio-image">
  
  <?php if(get_field('portfolio_image')): ?>          

<?php while(has_sub_field('portfolio_image')): ?>




    	<?php 
		// Get field Name
		$image = get_sub_field('image'); 
		$url = $image['url'];
		$title = $image['title'];
		$alt = $image['alt'];
		$caption = $image['caption'];
	 
		// thumbnail or custom size that will go
		// into the "thumb" variable.
		$size = 'portsmall';
		$thumb = $image['sizes'][ $size ];
		$width = $image['sizes'][ $size . '-width' ];
		$height = $image['sizes'][ $size . '-height' ];
			
		?>
    
    

<a href="<?php the_permalink() ?>" class="iframe group1 cboxElement"><img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>" /></a>
<?php endwhile; endif; ?>   
</div><h3><?php the_title(); ?></h3>


         
  <p><?php the_field("location"); ?>

  
 <div class="plus">
 <a href="<?php the_permalink() ?>" class="iframe group2 cboxElement">+</a></div>  

</div>
        <?php  endwhile; endif; wp_reset_postdata();  // close loop and reset the query ?>
     
<!-- posts -->
  
</div>


<!-- content -->



<!-- / content -->

     
     
     
 </div><!-- / page content -->




<?php //get_sidebar(); ?>
<?php get_footer(); ?>