<?php 
/**
* Template Name: Sitemap Page
*/
 get_header(); ?>

<div id="main">

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


<div class="page-content">
     <h1><?php the_title(); ?></h1>
     <?php the_content(); ?>
     
<div id="sitemap">
<ul>
<?php wp_list_pages('title_li=','sort_column=menu_order'); ?>
</ul>
</div>
     
 </div><!-- / page content -->


<?php endwhile; endif; ?>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>