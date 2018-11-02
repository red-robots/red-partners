


<?php // For linking Titles ?>
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

<?php // For linking Images ?>
<a href="<?php the_permalink(); ?>"><img src="<?php bloginfo('template_url'); ?>" alt="<?php the_title(); ?>" /></a>

<?php // For linking Navigaiton ?>
<ul>
	<li><a href="<?php bloginfo('url'); ?>">Home</a></li>
    <li><a href="<?php bloginfo('url'); ?>/about-us">About Us</a></li>
    <li><a href="<?php bloginfo('url'); ?>/work">Work</a></li>
    <li><a href="<?php bloginfo('url'); ?>/contact-us">Contact Us</a></li>
</ul>



<?php // Displaying Content ?>
<?php the_content(); ?>

<?php // Displaying Only the excerpt ?>
<?php the_excerpt(); ?>

<?php // Displaying a custom excerpt. Must have the Excerpt function in the functions file! ?>
<?php  echo get_excerpt(300); ?> 

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


<?php 
	// A bunch of Meta stuff...
?>
This Article is in the following categories <?php the_category(', ') ?>
There are <?php comments_popup_link('No Comments &#187;', '1 Comment &#187;', '% Comments &#187;'); ?>
<?php comments_template('', true); ?>





<?php // The Loop ?>
<?php query_posts('posts_per_page=10&cat=6'); // show 10 posts from category 6 ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>



<?php endwhile; endif; ?>