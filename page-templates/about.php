<?php
/**
 * ============== Template Name: About Page
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
			<h2 class="heading heading__5">Team</h2>
			<div class="team-members">
				<?php if( have_rows('team') ):
				while( have_rows('team') ): the_row();
				$teamImage = get_sub_field('picture'); ?>
					<div class="team-members__item">
						<img src="<?php echo $teamImage['url'];?>"/>
						<h4 class="heading heading__6"><?php the_sub_field('name');?></h4>
						<p class="position"><?php the_sub_field('position');?></p>
						<p><?php the_sub_field('bio');?></p>
					</div>
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