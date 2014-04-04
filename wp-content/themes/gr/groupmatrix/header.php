<!DOCTYPE HTML>
<html <?php language_attributes(); ?>>
<head>

<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<link rel="shortcut icon" href="/wp-content/themes/groupmatrix/favicon.ico" />
<link rel="apple-touch-icon" type="image/png" href="/wp-content/themes/groupmatrix/images/apple-touch-icon-57x57.png">
<link rel="apple-touch-icon" type="image/png" sizes="72x72" href="/wp-content/themes/groupmatrix/images/apple-touch-icon-72x72.png">
<link rel="apple-touch-icon" type="image/png" sizes="114x114" href="/wp-content/themes/groupmatrix/images/apple-touch-icon-114x114.png">

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
	<header id="header">
		<div class="container hidden-xs">
			<div class="row">
				<div id="top-links" class="col-sm-6">
					<?php  wp_nav_menu( array( 'theme_location' =>'top_nav','container'=>false)); ?>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="mobile-menu visible-xs">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#top-nav">
						<span class="fa fa-caret-down"> </span> Menu
					</button>
					<ul>
						<li><a href="<?php bloginfo('url');?>"><span class="glyphicon glyphicon-home"></span></a></li>
					</ul>
					<?php  wp_nav_menu( array( 'theme_location' =>'mobile_top_nav','container'=>false)); ?>
				</div>
				<div id="logo"  class="col-sm-2">
					<a href="<?php bloginfo('url');?>" title="Group Matrix"><img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Group Matrix"></a>
				</div>
				<div class="col-sm-7">
					<nav id="top-nav" class="collapse navbar-collapse">						
						<?php  wp_nav_menu( array( 'theme_location' =>'main_nav','container'=>false )); ?>
						<div class="clearfix"></div>
					</nav>
				</div>
				<div class="col-sm-3 hidden-xs">
					<p id="telephone">1-800-986-6669</p>
				</div>
			</div>
		</div>
		<section id="tagline" class="hidden-xs">
			<div class="container">
				<div class="row">
					<div class="col-sm-8">
						<h3>King Makers. We build market dominant Personal Injury firms.</h3>
					</div>
					<div class="col-sm-4">
						<p class="align-right"><a href="#" class="cwbtn cwbtn-blue right">Start Building Your Firm</a></p>
					</div>
				</div>
			</div>
		</section>
	</header>
	<?php 
		if(is_home() || is_front_page())
		get_template_part('includes/content','banner');
	?>
	<?php get_template_part('includes/content','tap_buttons');?>	
	<?php 
		if(is_home() || is_front_page())
		get_template_part('includes/content','clients');?>
