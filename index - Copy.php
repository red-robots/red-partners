<?php get_header(); ?>





<?php 
// You can query blog posts from a certain category or all of them
//query_posts( 'posts_per_page=2' ); 
?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="post-container">
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
  <?php // Display post content
	     echo get_excerpt(100); ?>
</div><!-- / post container -->
	




<?php endwhile; endif; ?>

<?php //get_sidebar(); ?>

<?php get_footer(); ?>