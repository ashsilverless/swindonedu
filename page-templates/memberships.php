<?php
/**
 * ============== Template Name: Memberships Page
 *
 * @package swindonedu
 */
get_header();?>

<div class="container grid-gap content">
	<div class="main-content">	
		<section>
			<h2 class="heading heading__5"><?php the_field('heading');?></h2>
			<?php the_field('copy');?>
		</section>
		<!--<section>
			<ul class="features">
				<?php if( have_rows('features_list') ):
				$i = 1;
				while( have_rows('features_list') ): the_row(); ?>
				<li>
					<div class="head">
						<i class="fas fa-check-circle"></i>
						<h3 class="heading heading__6"><?php the_sub_field('feature_heading');?></h3>
					</div>
					<?php the_sub_field('feature_detail');?>
				</li>
				<?php $i++; endwhile; endif;?>
			</ul>
		</section>-->
		<!--<section>
			<div class="toggle">
				<?php if( have_rows('toggle') ):
					$i = 1;
					while( have_rows('toggle') ): the_row(); ?>
					<div class="toggle__item">
						<div class="head">
							<span>Q<?php echo $i;?></span>
							<p><?php the_sub_field('heading');?></p>
							<i class="fas fa-chevron-right"></i>
						</div>
						<div class="body">
							<?php the_sub_field('content');?>
						</div>
					</div>
				<?php $i++; endwhile; endif;?>
			</div>
		</section>-->
	</div>
</div>
	
<div class="container grid-gap memberships">
		<h4 class="heading heading__5">Annual</h4>
		<h3 class="heading heading__3">Membership Packages</h3>
		<div class="membership-wrap">
				<?php $args = array(
					'post_type' => 'product',
					'posts_per_page' =>  -1,
					'post_status' => 'publish',
						'tax_query' => array(
							array(
								'taxonomy' => 'product_cat',
								'field'    => 'id',
								'terms'    => 25,
							),
						),
				);
				$loop = new WP_Query( $args );?>
				
				<?php if ( $loop->have_posts() ) {
				while ( $loop->have_posts() ) : $loop->the_post();?>
					<div class="memberships-cta__item">
						<h2 class="heading heading__4"><?php the_title();?></h2>
						<?php the_field('membership_summary');?>
						<div class="foot">
							<p class="cost"><?php echo $product->get_price_html(); ?><span class="denomination">Per Year</span></p>
							<a href="<?php the_permalink();?>" class="button button__large">
								Buy Now
								<i class="fas fa-chevron-right"></i>
							</a>
						</div>
							
					</div>
				<?php endwhile;
					} else {
						echo __( 'No products found' );
					}
				wp_reset_postdata();?>
			
		</div>
	
	

</div>
	
	
<?php get_footer();?>