<?php
/**
 * ============== Template Name: Contact Page
 *
 * @package swindonedu
 */
get_header();?>

<div class="container grid-gap content contact">
	<div class="main-content">
		<div class="details">
			<?php if( have_rows('contact_details', 'options') ):
			while( have_rows('contact_details', 'options') ): the_row();?>
			<div class="details__item">
				<h4 class="heading heading__7"><?php the_sub_field('name');?></h4>
				<?php if (get_sub_field('phone')){
					echo '<div><i class="fas fa-phone"></i><p>';
					the_sub_field('phone');
					echo '</p></div>';
				}?>
				<?php if (get_sub_field('email')){
					echo '<div><i class="fas fa-envelope"></i><p>';
					the_sub_field('email');
					echo '</p></div>';
				}?>
				<?php if (get_sub_field('appointment')){
					echo '<div><i class="fas fa-user"></i><p>';
					the_sub_field('appointment');
					echo '</p></div>';
				}?>				
			</div>
			<?php endwhile; endif;?>
			<div class="details__item">
				<h4 class="heading heading__7">Postal Address</h4>
				<p><?php the_field('postal_address', 'options');?></p>
			</div>
			
		</div>
		<div class="form">
			<?php echo do_Shortcode('[contact-form-7 id="526" title="Contact General"]');?> 
		</div>		
	</div>
	<div class="side-content">
		<section>
			<?php get_template_part ('template-parts/join-cta');?>
		</section>
	</div>	
</div>
	
<?php get_footer();?>