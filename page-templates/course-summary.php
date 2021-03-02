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
		<?php
		$date = date('j F Y');
		$dateUnix = strtotime($date);
		$fullArray = array();
		?>
		
		<?php if ( $loop->have_posts() ) {
		while ( $loop->have_posts() ) : $loop->the_post();?>
			<?php 
			$courseDate = get_field('date_of_course');
			$courseDateUnix = strtotime($courseDate);
			?>
			<?php if ($courseDateUnix > $dateUnix) {?>
				<?php 
					$terms = get_the_terms( $post->ID, 'product_tag' );
					foreach ( $terms as $term ) {
						$term = $term->slug;
						array_push($fullArray, $term);
					}
				?>
			<?php }?>
		<?php endwhile;
		} ?>
		<div class="filter-controls">
		  	<label>Filter By:</label>
			<p class="filter filter-controls__button" data-filter="all">All</p>
			<?php 
			$uArray = array_unique($fullArray);
			foreach ($uArray as $uArrayItem){?>
				<p class="filter-controls__button filter <?php echo $uArrayItem;?>" data-filter=".<?php echo $uArrayItem;?>">
				<?php echo $uArrayItem;?>
				</p>
			<?php }	?>
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
			<div class="no-results">No more results found.  Please adjust the filters or <a href="" class="button button__inline">view all</a></div>
		</div>
	</div>
	<div class="side-content">
		<div class="sticky">
			<?php get_template_part ('template-parts/join-cta');?>
		</div>
	</div>	
</div>
	
<?php get_footer();?>