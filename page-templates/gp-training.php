<?php
/**
 * ============== Template Name: GP Training Page
 *
 * @package swindonedu
 */
get_header();?>

<?php 
$today = date('Ymd');
$args = array(
	'post_type' => 'course_archive',
	'posts_per_page' => -1,
	'relation' => 'AND',
	'tax_query' => array(
		array(
			'taxonomy' => 'type',
			'field'    => 'slug',
			'terms'    => array('gp-training') 
		)
	),
	//Query checks that returned CPT is in the past
	'meta_query' => array(
		array(
			'key' => 'delivered_on',
			'value' => $today,
			'type' => 'DATE',
			'compare' => '<='
		)
	),
	'meta_key' => 'delivered_on',
	'orderby' => 'meta_value_num',
	'order' => 'DESC',
);
$loop = new WP_Query( $args );?>

<div class="container grid-gap content">
	<div class="main-content">
		<?php
		$user = wp_get_current_user();
		if ( in_array( 'gp_training_membership', (array) $user->roles ) ) {?>
			<section>
				<h2 class="heading heading__5"><?php the_field('sub_heading');?></h2>
				<?php the_field('lead_copy');?>
			</section>
			<!--<section class="filter-target">
				<?php if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();?>
				
				<?php get_template_part ('template-parts/course-archive-card');?>
				
				<?php endwhile;
				} else {
					echo __( 'No courses found' );
				}
				wp_reset_postdata();?>
				
			</section>-->
		<?php } elseif ( in_array( 'gp_membership', (array) $user->roles ) ){?>
			<section>
				<h2 class="heading heading__5"><?php the_field('member_heading');?></h2>
				<?php the_field('member_copy');?>
			</section>
			<section>
				<a href="<?php the_field('member_button_target');?>" class="button"><?php the_field('member_button_text');?><i class="fas fa-chevron-right"></i></a>
			</section>
		<?php } else {?>
		<section>
			<h2 class="heading heading__5"><?php the_field('non-member_heading');?></h2>
			<?php the_field('non-member_copy');?>
		</section>
			<section>
				<?php get_template_part ('template-parts/join-cta');?>
			</section>
		<?php }	?>
		<section>
			<div class="general-links">
			<?php if( have_rows('link_section') ):
			while( have_rows('link_section') ): the_row(); ?>
			<h3 class="heading heading__5 heading__color-green"><?php the_sub_field('section_heading');?></h3>
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
		<?php if ( in_array( 'gp_training_membership', (array) $user->roles ) ) {?>
			<section>
				<?php //get_template_part ('template-parts/course-archive-filter');?>
			</section>
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
					<p class="heading heading__5">Forms</p>
					<a href="/gp-training-forms" class="button button__large">
						Visit
						<i class="fas fa-chevron-right"></i>
					</a>
				</div>
			</section>
			<section>
				<?php get_template_part ('template-parts/courses-sidebar');?>
			</section>
		<?php } else {?>
			<section>
				<?php get_template_part ('template-parts/courses-sidebar');?>
			</section>
		<?php }?>
	</div>	
</div>
	
<?php get_footer();?>