<?php
/**
 * ============== Template Name: GP Training Forms Page
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
			<?php
			$user = wp_get_current_user();
			if ( in_array( 'gp_training_membership', (array) $user->roles ) ) {?>
				<section>
					<div class="form-links">
					<?php if( have_rows('forms') ):
					while( have_rows('forms') ): the_row(); ?>
					<?php $formItem = get_sub_field('form');?>
					<div class="form-links__item">
						<h3 class="heading heading__6"><?php the_sub_field('title');?></h3>
						<?php the_sub_field('description');?>
						<a href="<?php echo $formItem['url'];?>" target="_blank"><i class="fas fa-chevron-right"></i></a>
					</div>
					<?php endwhile; endif;?>
					</div>
				</section>
			<?php } else {?>
				<section>
					NON GP TRAINING MEMBER
				</section>
			<?php }?>
	</div>
	<div class="side-content">
		<section>
			<div class="dark-leader">
				<p class="heading heading__5">Training Video Archive</p>
				<a href="/gp-training-videos" class="button button__large">
					Visit
					<i class="fas fa-chevron-right"></i>
				</a>
			</div>
		</section>
		<section>
			<div class="dark-leader">
				<p class="heading heading__5">GP Training Course Archive</p>
				<a href="/gp-training" class="button button__large">
					Visit
					<i class="fas fa-chevron-right"></i>
				</a>
			</div>
		</section>
		<section>
			<?php get_template_part ('template-parts/courses-sidebar');?>
		</section>
	</div>	
</div>
	
<?php get_footer();?>