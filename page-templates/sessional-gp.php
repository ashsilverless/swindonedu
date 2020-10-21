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