<?php
/**
 * The template for displaying the footer
 * @package swindonedu
 */
?>
</main>
<footer>
	<div class="container footer">
		<div class="contact-section">
			<h4 class="heading heading__6">Contact Us</h4>
			<p>Phone</p>
			<p>Mail</p>
		</div>
		
		<div  class="menu-section">
			<?wp_nav_menu( array( 
				'theme_location' => 'footer-menu'
			) ); ?>
			
			<!--<div class="right-col termscons">
				<a href="/terms-conditions">Terms & Conditions</a> |
				<a href="/privacy">Privacy Policy</a>
			</div>-->
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
