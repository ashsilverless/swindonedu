<div class="courses-sidebar">
	<h4 class="heading heading__5">Upcoming</h4>
	<h3 class="heading heading__3">Courses & Events</h3>
	<?php $today = date('Ymd');
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
	$loop = new WP_Query( $args );?>
	<?php if ( $loop->have_posts() ) {
	while ( $loop->have_posts() ) : $loop->the_post();
	$date = get_field('date_of_course');
	$formattedDate = date("d.m.y", strtotime($date)); ?>
	<a href="<?php the_permalink();?>">
		<div class="course-item small">
			<p><?php echo $formattedDate; ?></p>
			<p><?php the_title();?></p>
			<i class="fas fa-chevron-right"></i>
			<!--<?php global $product; filter_get_stock_html($product);?>-->
		</div>
		
	</a>
	<?php endwhile;
		} else {
			echo __( 'No products found' );
		}
	wp_reset_postdata();?>
	
	<a href="/course-summary" class="more-from-summary">See All Courses & Events<i class="fas fa-chevron-right"></i></a>
</div>