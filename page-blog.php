<?php
/**
 * Template Name: Blog
 */

get_header(); ?>

	







<?php query_posts('posts_per_page=-1'); // "-1" = all posts. or, set to number of posts you want to show ?>
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div class="blogentry">

        <div class="blog-featured-image">
				<?php
                //  Display the featured image. Must be inside a loop.
                if ( has_post_thumbnail() ) {
                    the_post_thumbnail('thumbnail');
                }
                // If you do not have a Featured Image, show a thumbnail stored in the themes images folder.
                else {
                    echo '<img src="' . get_bloginfo( 'template_url' ) . '/images/default-thumb.png" />';
                     }
                ?>
        </div><!-- blog featured image  -->



  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
 <?php  echo get_excerpt(300); ?> 
  
</div><!-- blogentry -->
<?php endwhile; endif; ?>
 
  

<?php get_sidebar(); ?>
<?php get_footer(); ?>