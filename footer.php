<?php
/**
 * The template for displaying the footer
 * @package swindonedu
 */
?>
</main>
<footer>
	<div class="vector-wrapper">
		<?php get_template_part ('inc/img/hero-vector');?>
	</div>
	<div class="container footer">
		<div class="contact-section">
			<h4 class="heading heading__7">Contact Us</h4>
			<p><i class="fas fa-phone"></i><?php the_field('phone', 'options');?></p>
			<p><i class="fas fa-envelope"></i><?php the_field('email', 'options');?></p>
		</div>
		
		<div  class="menu-section">
			<?php wp_nav_menu( array( 
				'theme_location' => 'footer-menu'
			) ); ?>
			
			<div class="termscons">
				<ul>
					<li><a href="/terms-conditions">Terms & Conditions</a></li>
					<li><a href="/privacy">Privacy Policy</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="socket">
			<div class="silverless logo-holder">
				<a href="https://silverless.co.uk"><?php get_template_part('inc/img/silverless', 'logo');?></a>
			</div>
			<div class="copyright">
				<p>&copy; <?php echo get_bloginfo(); ?> <?php echo date ('Y');?>.  All Rights Reserved</p>
			</div>
		</div>
	</div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
