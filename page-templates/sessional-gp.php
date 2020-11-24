<?php
/**
 * ============== Template Name: Sessional GP Page
 *
 * @package swindonedu
 */
get_header();?>

<div class="container grid-gap content">
	<div class="main-content">
		<section>
			<div class="lead-copy">
				<h2 class="heading heading__4 heading__no-caps"><?php the_field('sub_heading');?></h2>
				<?php the_field('lead_copy');?>
			</div>
		</section>
		<section>
			<div class="main-copy">
				<h3 class="heading heading__4 heading__no-caps"><?php the_field('heading');?></h3>
				<?php the_field('main_copy');?>
			</div>
		</section>
		<section>
			<div class="general-links">
			<?php if( have_rows('links') ):
			while( have_rows('links') ): the_row(); ?>
			<div class="general-links__item">
				<h3 class="heading heading__6"><?php the_sub_field('title');?></h3>
				<?php the_sub_field('description');?>
				<a href="<?php the_sub_field('link');?>" target="_blank"><i class="fas fa-chevron-right"></i></a>
			</div>
			<?php endwhile; endif;?>
			</div>
		</section>
		<section>
			<div class="form">
				FORM
			</div>
		</section>
	</div>
	<div class="side-content">
		<?php get_template_part ('template-parts/courses-sidebar');?>
		<?php get_template_part ('template-parts/join-cta');?>
	</div>	
</div>
	
<?php get_footer();?>