<?php
/**
 * ============== Template Name: Sessional GP Page
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
	</div>
	<div class="side-content">
		
	</div>	
</div>
	
<?php get_footer();?>