<?php
/**
 * ============== Template Name: Course Archive Video Page
 *
 * @package swindonedu
 */
get_header();?>

<?php 
$today = date('Ymd');
if (is_page( 'course-archive-video' )){
	$parentType = 'gp-membership';	
} else {
	$parentType = 'gp-training-membership';	
};

$args = array(
	'post_type' => 'video_archive',
	'posts_per_page' => -1,
	'relation' => 'AND',
	'tax_query' => array(
		array(
			'taxonomy' => 'video_type',
			'field'    => 'slug',
			'terms'    => array($parentType) 
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
		<section>
			<div class="lead-copy">
				<h2 class="heading heading__4 heading__no-caps"><?php the_field('sub_heading');?></h2>
				<?php the_field('lead_copy');?>
			</div>
		</section>
		
		<?php 
		global $user_login, $current_user;
		get_currentuserinfo();
		$user_info = get_userdata($current_user->ID);
		$roles = array (
			'gp_training_membership',
			'gp_membership',
		);
		
		if (is_user_logged_in() && array_intersect( $roles, $user_info->roles)) {?>
		
		<section class="filter-target">	
		<?php if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post();?>
	
			<?php get_template_part ('template-parts/course-archive-card');?>

		<?php endwhile;
		} else {
			echo __( 'No products found' );
		}
		wp_reset_postdata();?>
	</section>
		
		<?php } else {?>
		<section>
			<h2 class="heading heading__5">Members only content</h2>
			<p>In order to view this content, you must be a member of the Swindon Education Trust.  Want to join.  Simply <a href="/membership">click here</a> to get started.</p>
		</section>
		<section>
			<?php get_template_part ('template-parts/join-cta');?>
		</section>
		<?php } ?>

		
	</div>
	<div class="side-content">
		<?php if (is_page( 'course-archive-video' )){?>
		<section>
			<?php get_template_part ('template-parts/course-archive-filter');?>
		</section>
		<?php }?>
		<section>
			<div class="dark-leader">
				<p class="heading heading__5">Course Archive</p>
				<a href="/course-archive" class="button button__large">See All Course Content<i class="fas fa-chevron-right"></i></a>
			</div>
		</section>
		<section>
			<?php get_template_part ('template-parts/courses-sidebar');?>
		</section>
	</div>	
</div>

<?php get_footer();?>