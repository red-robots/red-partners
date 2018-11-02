<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 
get_header(); ?>



<div id="main">


<div class="page-content">
    
    
    <article id="post-0" class="post error404 no-results not-found">
				<header class="entry-header">
					<h1 class="entry-title"><?php _e( 'We&rsquo;re sorry. The page you are looking for cannot be found.', 'avalillys' ); ?></h1>
				</header>

				<div class="entry-content">
					<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Please use the links below to browse our site.', 'olive' ); ?></p>
                    
                    <div id="sitemap">
                    <ul>
				  <?php wp_list_pages('title_li='); ?>
                  </ul>
                  </div>
               
				</div><!-- .entry-content -->
			</article>
    
    
 </div><!-- / page content -->




<?php //get_sidebar(); ?>
<?php get_footer(); ?>