<?php
/**
 * ============== Template Name: Course Archive Page
 *
 * @package swindonedu
 */
get_header();?>

<?php 
$today = date('Ymd');
$parentType = 'standard';
$args = array(
	'post_type' => 'course_archive',
	'posts_per_page' => -1,
	'relation' => 'AND',
	'tax_query' => array(
		array(
			'taxonomy' => 'type',
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

<?php 
global $user_login, $current_user;
get_currentuserinfo();
$user_info = get_userdata($current_user->ID);
$roles = array (
	'gp_training_membership',
	'gp_membership',
);?>

<div class="container grid-gap content">
	
	<div class="main-content">
		<section>
			<div class="lead-copy">
				<h2 class="heading heading__4 heading__no-caps"><?php the_field('sub_heading');?></h2>
				<?php the_field('lead_copy');?>
			</div>
		</section>
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
		<?php if (array_intersect( $roles, $user_info->roles)) {} else {?>
		<section>
			<?php get_template_part ('template-parts/join-cta');?>
		</section>
		<?php }?>
	</div>
	<div class="side-content">
		<section>
			<?php get_template_part ('template-parts/course-archive-filter');?>
		</section>
		<section>
			<div class="dark-leader">
				<p class="heading heading__5">Video Archive</p>
				<?php 
				$user = wp_get_current_user();
				$allowed_roles = array('gp_membership', 'gp_training_membership');
				if( array_intersect($allowed_roles, $user->roles ) ) {?>
				<a href="/course-archive-video" class="button button__large">
					Visit
					<i class="fas fa-chevron-right"></i>
				</a>
				<?php } else { ?>
				<a class="button button__large disabled">
					Visit
					<i class="fas fa-chevron-right"></i>
				</a>
				<span>
					<i class="fas fa-info-circle"></i> 
					This is a members-only facility.  For membership details, <a href="/membership" class="inline-link">please click here</a>
				</span> 
				<?php } ?>
			</div>
		</section>
		<section>
			<?php get_template_part ('template-parts/courses-sidebar');?>
		</section>
	</div>	
</div>

<?php get_footer();?>