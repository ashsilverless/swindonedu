<?php /** Header @package swindonedu */ ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="UTF-8">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title><?php echo get_bloginfo(); ?></title>

<link rel="stylesheet" href="https://use.typekit.net/cug8izm.css"><!--TYPEKIT INJECT-->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" type="image/x-icon" />

<script src="https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.js"></script>
<link href="https://api.mapbox.com/mapbox-gl-js/v1.11.0/mapbox-gl.css" rel="stylesheet" />

<?php wp_head(); ?>
</head>
<body <?php body_class('light-mode'); ?>>
	<div id="page" class="site-wrapper">
		<header>
			<div class="container">
				<div class="logo">
					<a href="<?php echo get_home_url(); ?>">
						<?php get_template_part ('inc/img/set-logo');?>
					</a>
				</div>
				<div class="nav nav__upper-section">
					<?wp_nav_menu( array( 
						'theme_location' => 'upper-menu'
					) ); ?>
				</div>
				<div class="nav nav__lower-section">
					<?wp_nav_menu( array( 
						'theme_location' => 'lower-menu'
					) ); ?>
				</div>
				<div class="sign-up">
					<?php
					if ( is_user_logged_in() ) {?>
						<a href="/my-account">My Account</a>
					<?php } else {?>
						<a href="/register">Sign Up</a>
					<?php }?>
				</div>
				<div class="my-account">
					<?php
					if ( is_user_logged_in() ) {?>
						<a href="<?php echo wp_logout_url('$index.php'); ?>">Log Out</a>
					<?php } else {?>
						<a href="/my-account">Log In</a>
					<?php }?>
					
				</div>	
			</div>
		</header>	
		<main>	
			
			<div class="hero">
				<div class="vector-wrapper">
					<?php get_template_part ('inc/img/hero-vector');?>
				</div>
				<div>
					<div class="container">
						<h1 class="heading heading__1">
							<?php if (get_field('hero_title')){
								the_field('hero_title');
							} else {
								the_title();
							} ?>
					</div>
				</div>
			</div>