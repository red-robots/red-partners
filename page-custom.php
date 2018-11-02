<?php 
/**
* Template Name: Custom Page
*/
 get_header(); ?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


<div class="page-content">
     <h2><?php the_title(); ?></h2>
     <?php the_content(); ?>
 </div><!-- / page content -->


<?php endwhile; endif; ?>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>