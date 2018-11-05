<!DOCTYPE html>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?><?php bloginfo('name'); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/soliloquy.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/colorbox.css" />
<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400italic,700italic,400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Oswald:400,700' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Archivo+Narrow' rel='stylesheet' type='text/css'>
<?php wp_head(); ?>

<!-- nav -->
<?php
	$urlParam = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 'https' : 'http' ) . '://' .  $_SERVER['HTTP_HOST'] . $_SERVER["REQUEST_URI"];
?>
<script type="text/javascript" language="JavaScript">
   var full_url = '<?php echo $urlParam?>';
<!--
function HideContent(d) {
document.getElementById(d).style.display = "none";
}
function ShowContent(d) {
document.getElementById(d).style.display = "block";
}
function ReverseDisplay(d) {
if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; }
else { document.getElementById(d).style.display = "none"; }
}
//--></script>

<!-- nav -->


</head>

<body>




<div id="main-header" class="clear">

<div id="header" class="clear">

    <div id="logo">
    <a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_url'); ?>/images/red-partners-logo.png" alt="" border="0"></a> 
    </div><!-- #logo -->
    
    <div id="header-content">
    
   
 <div id="header-content1-wrapper">   
<div id="header-content1">704.333.7997</div>
<div id="header-content2"><a href="<?php bloginfo('url'); ?>/brokerage/available-listings/">Available Listings</a></div></div> <div id="header-content3"><a href="<?php bloginfo('url'); ?>/news">NEWS</a> &nbsp;&nbsp; <a href="<?php bloginfo('url'); ?>/contact-us">CONTACT US</a></div>
    </div><!-- #logo -->    
    
    
    </div>
    
   <div id="navigation">
<?php if(is_page( 'Home' ) ) { ?>
<div id="home-button-hide"></div>
            <?php } else { ?>
<div id="home-button"><a href="<?php bloginfo('url'); ?>">HOME</a></div>
            <?php } ?>
      <nav id="access" role="navigation">
				<?php /* Our navigation menu. If one isn't filled out, wp_nav_menu falls back to wp_page_menu. The menu assigned to the primary location is the one used. If one isn't assigned, the menu with the lowest ID is used. */ ?>
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
			</nav>
    </div><!-- #navigation -->
    
    
    
    

    
    
    
    
<div id="mobile-navigation">

<a href="javascript:ReverseDisplay('uniquename')"> 
Menu &nbsp;&nbsp;&nbsp; <img src="<?php bloginfo('template_url'); ?>/images/down-arrow.png" alt="" border="0">
</a>

<div id="uniquename" style="display:none;">
<ul>
<?php wp_list_pages('title_li=','sort_column=menu_order'); ?>
</ul>
            
            
</div>

      
    </div><!-- #navigation -->    
    
    
    
    
    </div>
    
    
    
    
  