<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}
?>
<div class="container book-cta">
	
	<div class="title-wrapper">
		<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
	
			<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt">
				<?php if( has_term (26, 'product_cat')) {
					echo 'Book A Place <i class="fas fa-chevron-right"></i>';
				} else {
					echo 'Purchase Membership <i class="fas fa-chevron-right"></i>';
				}?>
			</button>
	
			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		</form>	
		<h2 class="heading heading__4 title"><?php the_title();?></h2>
	</div>
	
	<div class="button-wrapper">
		<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
	
			<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="single_add_to_cart_button button alt">
				<?php if( has_term (26, 'product_cat')) {
					echo 'Book A Place <i class="fas fa-chevron-right"></i>';
				} else {
					echo 'Purchase Membership <i class="fas fa-chevron-right"></i>';
				}?>
			</button>
	
			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
		</form>		
	</div>
</div>

<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>

	<?php
	/**
	 * Hook: woocommerce_before_single_product_summary.
	 *
	 * @hooked woocommerce_show_product_sale_flash - 10
	 * @hooked woocommerce_show_product_images - 20
	 */
	//do_action( 'woocommerce_before_single_product_summary' );
	?>
	<div class="container grid-gap content">
		<div class="summary entry-summary">
			<?php
			/**
			 * Hook: woocommerce_single_product_summary.
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 * @hooked WC_Structured_Data::generate_product_data() - 60
			 */
			//do_action( 'woocommerce_single_product_summary' );?>
			<?php if( has_term (26, 'product_cat')) {?>
				<div class="product-meta">
					<div class="product-meta__item">
						<div class="lecturer-wrapper">
							<?php if( have_rows('lecturers') ):?>
							
							<h4 class="heading heading__6">
								<?php
								$lecturers = get_field('lecturers');
								$lecturerCount = count($lecturers);
									if ($lecturerCount <= 1){
										echo 'Lecturer';
									} else {
										echo 'Lecturers';
									};?>
								</h4>
							
							
							<?php while( have_rows('lecturers') ): the_row(); ?>
								<p><?php the_sub_field('lecturer');?></p>
							<?php endwhile; endif;?>
						</div>
					</div>
					<div class="product-meta__item">
						<h4 class="heading heading__6">Date & Time</h4>
						<p><?php the_field('course_time_from'); ?><?php the_field('course_time_to');?>, <?php the_field('course_date');?></p>
					</div>			
					<?php if (get_field('postcode')) {?>
						<div class="product-meta__item physical-address">
							<h4 class="heading heading__6">Location</h4>
							<p><?php the_field('address');?> <?php the_field('postcode');?></p>
							<a href="https://www.google.co.uk/maps/search/<?php the_field('postcode');?>" class="location" target="_blank"><i class="fas fa-map-marker-alt"></i>View Location on Google Maps<i class="fas fa-chevron-right"></i></a>
						</div>
					<?php }?>
					<?php if (get_field('additional_notes')) {?>
					<div class="product-meta__item">
						<h4 class="heading heading__6">Additional Notes</h4>
						<?php the_field('additional_notes');?>
					</div>
					<?php }?>
				</div>
				<?php if (get_field('synopsis')) {?>
				<div class="product-meta__item longform">
				<h4 class="heading heading__6">Course Synopsis</h4>
					<?php the_field('synopsis');?>
				</div>
				<?php }?>
				
				<?php if (get_field('learning_objectives')) {?>
				<div class="product-meta__item longform">
					<h4 class="heading heading__6">Learning Objectives</h4>
					<ul>
					<?php if( have_rows('learning_objectives') ):
					$i = 1;
					while( have_rows('learning_objectives') ): the_row(); ?>
						<li><p><span><?=$i;?></span><?php the_sub_field('objective');?></p></li>
					<?php $i++; endwhile; endif;?>
					</ul>
				</div>
				<?php }?>
				
				<?php if (get_field('curriculum_statement')) {?>
				<div class="product-meta__item longform ">
					<h4 class="heading heading__6">Curriculum Statement</h4>
					<ul>
					<?php if( have_rows('curriculum_statement') ):
					while( have_rows('curriculum_statement') ): the_row(); ?>
						<li class="large-index"><p><span><?php the_sub_field('number');?></span><?php the_sub_field('statement');?></p></li>
					<?php endwhile; endif;?>
					</ul>
				</div>
				<?php }?>
				
				<?php if (get_field('course_notes')) {?>
					<div class="course-notes">
						<h4 class="heading heading__6">Course Notes</h4>
						<a href="<?php the_field('course_notes');?>" target="_blank"><i class="fas fa-file-alt"></i></a>
					</div>
				<?php }?>
				
			<?php } else {?>
				<?php the_field('membership_detail');?>				
			<?php }?>
			
			
			
			
			
			
			<?php
			/**
			 * Hook: woocommerce_after_single_product_summary.
			 *
			 * @hooked woocommerce_output_product_data_tabs - 10
			 * @hooked woocommerce_upsell_display - 15
			 * @hooked woocommerce_output_related_products - 20
			 */
			//do_action( 'woocommerce_after_single_product_summary' );
			?>
		</div>

		<div>
			<div class="sticky under-book-button">
				
				<div class="product-meta cost">
					<?php if( has_term (26, 'product_cat')) {?>
					<div class="product-meta__item">
						<h4 class="heading heading__6">Cost</h4>
						<p>Non-members<span> <?php echo $product->get_price_html(); ?></span></p>
						<p>Members<span> £FREE</span></p>
					</div>
					<?php }else{?>
						<div class="product-meta__item membership">
							<h4 class="heading heading__6">Cost</h4>
							<p>Annual Membership<span> <?php echo $product->get_price_html(); ?></span></p>
						</div>
					<?php }?>
				</div>
				<?php get_template_part ('template-parts/join-cta-sidebar');?>
			</div>
		</div>
	</div>
</div>


<?php do_action( 'woocommerce_after_single_product' ); ?>
<div class="dark-section">
	<div class="container">
		<div class="main-content">
			
			<?php if( has_term (26, 'product_cat')) {?>
			<h4 class="heading heading__5">OTHER COURSES</h4>
			<?php } else {?>
			<h4 class="heading heading__5">COURSES FREE TO ALL MEMBERS</h4>
			<?php }?>			
			<div class="course-wrapper">
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
		</div>
</div>
