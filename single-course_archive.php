<?php
/**
 * The template for displaying all course archive custom posts
 *
 * @package swindonedu
 */
get_header(); ?>

<div class="container grid-gap content">
	<div class="main-content">
		<section>
			<?php if( have_rows('course_details') ):
			while( have_rows('course_details') ): the_row(); ?>
				<?php the_sub_field('course_date');?>
				<?php the_sub_field('lecturer');?>
				<?php the_sub_field('course_overview');?>
				<?php endwhile; endif;?>
		</section>
	</div>
	<div class="side-content">
		SIDE
	</div>	
</div>
	
<?php get_footer();?>