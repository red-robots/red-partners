<?php 
/**
* Template Name: News Page
*/
 get_header(); ?>


<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div id="main">
<div class="page-content">

<div id="news-photo"><img src="<?php the_field("news_photo"); ?>" /></div>
     <h1><?php the_title(); ?></h1>
     <?php the_content(); ?>
     
     
<div id="news">     
     <?php $the_query = new WP_Query( 'showposts=-1' ); ?><ul>

<?php while ($the_query -> have_posts()) : $the_query -> the_post(); ?>

 <li><span class="date"><?php the_date('m.d.y'); ?></span><br /><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></li>

 <?php endwhile;?></ul>
     </div>
     
 </div><!-- / page content -->


<?php endwhile; endif; ?>

<?php //get_sidebar(); ?>
<?php get_footer(); ?>