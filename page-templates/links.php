<?php
/**
 * ============== Template Name: Links Page
 *
 * @package swindonedu
 */
get_header();?>

<div class="container grid-gap content">
	<div class="main-content">
		<section>
			<h2 class="heading heading__5"><?php the_field('sub_heading');?></h2>
			<?php the_field('lead_copy');?>
		</section>
		<section>
			<div class="general-links">
			<?php if( have_rows('link_section') ):
			while( have_rows('link_section') ): the_row(); ?>
			<h3 class="heading heading__6"><?php the_sub_field('section_heading');?></h3>
				<?php if( have_rows('links') ):
				while( have_rows('links') ): the_row(); ?>
					<div class="general-links__item">
						<p><?php the_sub_field('link_desscription');?></p>
						<a href="<?php the_sub_field('link_to_page');?><?php the_sub_field('link_to_document');?>" target="_blank"><i class="fas fa-chevron-right"></i></a>
					</div>
				<?php endwhile; endif;?>	
			<?php endwhile; endif;?>	
			</div>
		</section>
	</div>
	<div class="side-content">
		<section>
			<?php get_template_part ('template-parts/join-cta');?>
		</section>
	</div>	
</div>
	
<?php get_footer();?>