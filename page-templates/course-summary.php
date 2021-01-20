<?php
/**
 * ============== Template Name: Courses & Events Page
 *
 * @package swindonedu
 */
get_header();?>

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



<div class="container content grid-gap">
	<div class="main-content">
		
		
		<div class="filter-controls">
		  	<label>Filter By:</label>
			<p class="filter filter-controls__button" data-filter="all">All</p>
			<?php $terms = get_terms(
			  array(
				  'taxonomy' => 'product_tag', 
				  'hide_empty' => true)
			  ); ?>
			<?php foreach ( $terms as $term ) { ?>
				<p class="filter-controls__button filter <?php echo $term->slug;?>" data-filter=".<?php echo $term->slug;?>">
					<?php echo $term->name;?>
				</p>	
			<?php } ?>
		</div>
		<div class="pager-list">
			<!-- Pagination buttons will be generated here -->
		</div>

		<div class="filter-target">
			<div class="course-wrapper">
				<?php if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();?>
				<?php get_template_part ('template-parts/course-card-body');?>
				<?php endwhile;
					} else {
						echo __( 'No products found' );
					}
				wp_reset_postdata();?>
			</div>
			<div class="no-results">No results found.  Please adjust the filters or <a href="" class="button button__inline">view all</a></div>
		</div>
	</div>
	<div class="side-content">
		<div class="sticky">
			<?php get_template_part ('template-parts/join-cta');?>
		</div>
	</div>	
</div>
	
<?php get_footer();?>