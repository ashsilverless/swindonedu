<?php
/**
 * Empty cart page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart-empty.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

defined( 'ABSPATH' ) || exit;

/*
 * @hooked wc_empty_cart_message - 10
 */
//do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
	<section>
		<h2 class="heading heading__7">You currently have no products selected</h2>
		<p>Use the links below to begin your selection, or <a href="<?php echo get_home_url(); ?>" class="inline-link">return home</a>.</p>
		<div class="links-wrapper">
			<a href="/course-summary" class="button">Courses & Events<i class="fas fa-chevron-right"></i></a>
			<a href="/membership" class="button">Purchase Membership<i class="fas fa-chevron-right"></i></a>
		</div>
	</section>
<?php endif; ?>