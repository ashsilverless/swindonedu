<?php
/**
 * ============== Template Name: Register Page
 *
 * @package swindonedu
 */
get_header();?>

<div class="container content">
	<div class="main-content">
		
		<?php echo do_shortcode('[wc_reg_form_bbloomer]');?>
		<?php if ( have_posts() ) : 
			 while ( have_posts() ) : the_post(); 
				 the_content();
			 endwhile; 
		endif;?> 
		<?php echo do_shortcode('[loginform]');?>
		<a href="http://swindon-education-trust.local/wp-login.php?action=logout">Logout</a>
	</div>
	<div class="side-content">
		
	</div>	
</div>
	
<?php get_footer();?>