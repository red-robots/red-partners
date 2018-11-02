<?php
/**
 * Displays a Single Post
 */

?>

<!DOCTYPE html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />



<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />

<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400italic,700italic,400,700' rel='stylesheet' type='text/css'>

<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>


<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow' rel='stylesheet' type='text/css'>

<?php wp_head(); ?>

</head>

<body>



<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

<div class="single-portfolio-container">
  

 <!-- --><?php if(get_field('portfolio_image')): ?>          
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
		$size = 'large';
		$thumb = $image['sizes'][ $size ];
		$width = $image['sizes'][ $size . '-width' ];
		$height = $image['sizes'][ $size . '-height' ];
			
		?>
<img src="<?php echo $thumb; ?>" alt="<?php echo $alt; ?>" title="<?php echo $title; ?>" />
<?php endwhile; endif; ?>  <!-- -->

<h1><?php the_title(); ?></h1>
<p><?php the_field("location"); ?>
 		<?php the_content(); ?>
        
  
  

  
  <p><?php the_field("address"); ?>  
  
  
  <div id="map-icon"> 

<!-- telephone -->

<?php the_field("map"); ?>

<!-- / telephone -->  
</div>
      
        
</div><!-- single post container -->






<?php endwhile; endif; ?>


