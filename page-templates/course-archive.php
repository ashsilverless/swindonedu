<?php
/**
 * ============== Template Name: Course Archive Page
 *
 * @package swindonedu
 */
get_header();?>

<?php $today = date('Ymd');
$args = array(
	'post_type' => 'course_archive',
	/*'meta_query' => array(
		array(
			'key' => 'date_of_course',
			'value' => $today,
			'type' => 'DATE',
			'compare' => '>='
		)
	),
	'meta_key' => 'date_of_course',
	'orderby' => 'meta_value_num',
	'order' => 'ASC',*/
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
		$user = wp_get_current_user();
		if ( 
			in_array( 'gp_role', (array) $user->roles )|| 
			in_array( 'standard_role', (array) $user->roles ) 
		) {?>
			
			<?php if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post();?>
		
		<div class="course-item mix">
			<div class="summary">
				<?php if( have_rows('course_details') ):
				while( have_rows('course_details') ): the_row(); ?>
					<p><?php the_sub_field('course_date');?></p>
					<h2 class="heading heading__5"><?php the_title();?></h2>
					<p><?php the_sub_field('lecturer');?></p>
				<?php endwhile; endif;?>
			</div>
			<a href="<?php the_permalink();?>" class="book">
				<span>
					<i class="fas fa-chevron-right"></i>
					See More	
				</span>
			</a>
		</div>		

		<?php endwhile;
			} else {
				echo __( 'No products found' );
			}
		wp_reset_postdata();?>
		<?php } else {?>
			<section>
				<h3 class="heading heading__5">This content is reserved for members</h3>
				<p>Already a member?  <span class="trigger-signin">Sign in here</span></p>
			</section>
			<?php get_template_part ('template-parts/join-cta');?>
		<?php }
		?>
	</div>
	<div class="side-content">
		<?php get_template_part ('template-parts/courses-sidebar');?>
	</div>	
</div>
	
<?php get_footer();?>