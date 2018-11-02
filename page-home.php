<?php 
/**
* Template Name: Home Page
*/
 get_header(); ?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div id="slideshow-wrapper">
<div id="slideshow"><?php if ( function_exists( 'soliloquy_slider' ) ) soliloquy_slider( '40' );?></div></div>

<div id="main">

<div id="row1">

<div id="row1-left">
<?php $recent = new WP_Query("page_id=42"); while($recent->have_posts()) : $recent->the_post();?>

<?php the_content(); ?>
<?php endwhile; wp_reset_postdata(); // end of the loop. ?>
</div>

<div id="row1-right">

<h2>Latest News</h2>
 <?php $the_query = new WP_Query( 'showposts=3' ); ?>

<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>

 <li><span class="date"><?php the_date('m.d.y'); ?></span>&nbsp;&nbsp;<a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>

 <?php endwhile;?>



 <p><a href="<?php bloginfo('url'); ?>/news">see all ></a></p>



 </ul>
 <?php wp_reset_postdata(); ?>
</div>


</div>





<?php endwhile; endif; ?>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>