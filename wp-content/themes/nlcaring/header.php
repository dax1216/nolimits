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
	<div class="navbar">
			<div class="wrapper">
					<ul class="nav-left">
						<li><a title="My Orders" href="http://nolimits.com/my-orders/">My Orders</a></li>
						<li><a title="Dashboard" href="http://nolimits.com/dashboard/">Dashboard</a></li>
					</ul>
					<ul class="nav-right">
						<?php 
						$submit_url = get_option('theme_submit_url');
						$my_help_url = get_option('theme_my_help_url');
						$my_profile_url = get_option('theme_my_profile_url');
						if(is_user_logged_in()) {
							if(!empty($submit_url)){
								echo '<li><a href="'.$submit_url.'">Submit Help</a></li>';
							}							
							if(!empty($my_help_url)){
								echo '<li><a href="'.$my_help_url.'">My Helps</a></li>';
							}
							
							if(!empty($my_profile_url)){
								echo '<li><a href="'.$my_profile_url.'">Profile</a></li>';
							}							
							echo '<li><a href="'.wp_logout_url( home_url() ).'">Logout</a></li>';
							
						}else{
							  $theme_login_url = get_option('theme_login_url');							  
							if(!empty($submit_url)){
								echo '<li><a href="'.$submit_url.'">Submit Help</a></li>';
							}							
							if(!empty($theme_login_url)){
								echo '<li><a href="'.$theme_login_url.'">Login</a></li>';
							}							
							if(!empty($theme_login_url)){
								echo '<li><a href="'.$theme_login_url.'">Register</a></li>';
							}
						}
						?>
					</ul>
					
					
					<div class="clearfix"></div>
			</div>
	</div>
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