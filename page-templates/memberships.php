<?php
/**
 * ============== Template Name: Memberships Page
 *
 * @package swindonedu
 */
get_header();?>

<div class="container grid-gap content">
	<div class="main-content">
		<?php get_template_part ('template-parts/join-cta');?>
	
		<h2 class="heading heading__5"><?php the_field('heading');?></h2>
		<?php the_field('copy');?>
		<div class="toggle">
			<?php if( have_rows('toggle') ):
				$i = 1;
				while( have_rows('toggle') ): the_row(); ?>
				<div class="toggle__item">
					<div class="head">
						<span>Q<?php echo $i;?></span>
						<p><?php the_sub_field('heading');?></p>
						<i class="fas fa-chevron-right"></i>
					</div>
					<div class="body">
						<?php the_sub_field('content');?>
					</div>
				</div>
			<?php $i++; endwhile; endif;?>
		</div>
	</div>
	
	<div class="side-content">
		<?php get_template_part ('template-parts/courses-sidebar');?>
	</div>	
</div>
	
<?php get_footer();?>