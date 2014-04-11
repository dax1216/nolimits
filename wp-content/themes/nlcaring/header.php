<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
	<link href="<?php echo get_template_directory_uri(); ?>/css/main.css" rel="stylesheet">
	<link href="<?php echo get_template_directory_uri(); ?>/css/font-awesome.min.css" rel="stylesheet">
	 <?php
		$favicon = get_option('theme_favicon');
		if( !empty($favicon) )
		{
			?>
			<link rel="shortcut icon" href="<?php echo $favicon; ?>" />
			<?php
			}
		?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->	
	<?php 
		    // Google Analytics From Theme Options
		echo stripslashes(get_option('theme_google_analytics'));
	wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<div class="wrapper">
		<header id="header">
			<div id="logo">			
				<?php  $logo_path = get_option('theme_sitelogo');
					if(!empty($logo_path)) : ?>
						 <a title="<?php  bloginfo( 'name' ); ?>" href="<?php echo home_url(); ?>">  <img src="<?php echo $logo_path; ?>" alt="<?php  bloginfo( 'name' ); ?>"></a>
				<?php  else:  ?>
						<h1><a href="<?php echo home_url(); ?>"  title="<?php bloginfo( 'name' ); ?>"> <?php  bloginfo( 'name' ); ?> </a></h1>
				<?php endif;?>
			</div>
			<nav id="topNav">
				<?php wp_nav_menu(array(
					'theme_location'=>'main_nav',
					'container'=>false
				));?>
			</nav>
			<div class="clearfix"></div>
		</header>
	</div>	