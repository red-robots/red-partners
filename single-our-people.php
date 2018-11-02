<?php
/**
 * Displays a Single Post
 */

get_header(); ?>

	

<div id="main">



<div class="single-post-container">

<div id="subnav">

<h2>Our People</h2>

<!-- -->

<?php wp_nav_menu( array( 'theme_location' => 'secondary' ) ); ?>

<!-- -->

 <div class="plus2"><a href="<?php bloginfo('url'); ?>/our-people">+</a></div>    

</div>

<div id="our-people-left">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<img src="<?php the_field("photo"); ?>">

<a href="mailto: <?php the_field("email"); ?>"><?php the_field("email"); ?></a>
     
     
<!-- telephone -->
<p><?php
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

<div id="vcard"><a href="<?php the_field("vcard"); ?>">vcard <img src="<?php bloginfo('template_url'); ?>/images/vcard.png" alt="" style="width: 31px; height: 22px;" border="0" align="right"></a></div>
     


<!-- cell -->
<?php
$clients	= get_field('clients_represented');
if( ($clients) )
{
	echo '<p><h2>CLIENTS REPRESENTED</h2>';
}
else {
	echo '<p>&nbsp;';
}
?><?php the_field("clients_represented"); ?>
<!-- / cell -->  

 

<p><p>&nbsp;
<hr> 

</div>


<div id="our-people-content">

  <h1><?php the_title(); ?></h1>
 		<?php the_content(); ?>
        
  <!-- -->    
 
 
<!-- Affiliations -->
<?php
$affiliations	= get_field('professional_affiliations_accreditations');
if( ($affiliations) )
{
	echo '<h2>PROFESSIONAL AFFILIATIONS / ACCREDITATIONS</h2>';
}
?><?php the_field("professional_affiliations_accreditations"); ?>
<!-- / Affiliations -->  
 
 
<!-- education -->
<?php
$education	= get_field('education');
if( ($education) )
{
	echo '<p><h2>EDUCATION</h2> ';
}
?><?php the_field("education"); ?>
<!-- / education -->  
     
  
  </div>        
     
     
     <!-- -->
   
        
</div><!-- single post container -->






<?php endwhile; endif; ?>


<?php // get_sidebar(); ?>
<?php get_footer(); ?>