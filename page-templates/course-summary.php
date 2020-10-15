<?php
/**
 * ============== Template Name: Courses & Events Page
 *
 * @package swindonedu
 */
get_header();?>

<div class="container content">
	<div class="main-content">
		<?php
		$today = date('Ymd');
		$args = array(
			'post_type' => 'product',
			'posts_per_page' =>  $item_count,
			'post_status' => 'publish',
				'tax_query' => array(
					array(
						'taxonomy' => 'product_cat',
						'field'    => 'id',
						'terms'    => 26,
					),
				),
			'meta_query' => array(
				array(
					'key' => 'date_of_course',
					'value' => $today,
					'type' => 'DATE',
					'compare' => '>='
				)
			),
			'meta_key' => 'date_of_course',
			'orderby' => 'meta_value_num',
			'order' => 'ASC',
		);
		$loop = new WP_Query( $args );
		if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post();?>
		<?php get_template_part ('template-parts/course-card-body');?>
		<?php endwhile;
			} else {
				echo __( 'No products found' );
			}
		wp_reset_postdata();?>
	</div>
	<div class="side-content">
		SIDE
	</div>	
</div>
	
<?php get_footer();?>