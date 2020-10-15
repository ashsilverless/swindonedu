<?php
/**
 * ============== Template Name: GP Training Page
 *
 * @package swindonedu
 */
get_header();?>

<div class="container content">
	<div class="main-content">
		<?php if ( have_posts() ) : 
			 while ( have_posts() ) : the_post(); 
				 the_content();
			 endwhile; 
		endif;?> 
		<?php $the_stuff = 'STUFF FOR STANDARD MEMBER';?>
		<?php
		echo do_shortcode(' [membership_protected_content plan_id="18"]' .$the_stuff. '[/membership_protected_content]');?>
	</div>
	<div class="side-content">
		
	</div>	
</div>
	
<?php get_footer();?>