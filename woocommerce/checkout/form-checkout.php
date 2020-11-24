<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}

?>

<?php //if have role of gp or gp trg add class.  if is customer add class?>

<?php 
global $user_login, $current_user;
get_currentuserinfo();
$user_info = get_userdata($current_user->ID);
	$membershipRoles = array (
		'gp_training_membership',
		'gp_membership',
	);
	$customerRoles = array (
		'customer'
	);

if (is_user_logged_in() && array_intersect( $membershipRoles, $user_info->roles)) {
	$userStatus = "member";
} elseif (is_user_logged_in() && array_intersect( $customerRoles, $user_info->roles)) {
	$userStatus = "exsiting-customer";
} else {
	$userStatus = "new-customer";
}
?>

<?php 
$category_checks = array();
foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
	$product = $cart_item['data'];
	$product_in_cat = false;
	if ( has_term( 'membership-plan', 'product_cat', $product->id ) ) {
		$product_type = "product-type-membership";
	} else {
		$product_type = "product-type-course";
	}
}?>

<form name="checkout" method="post" class="checkout woocommerce-checkout <?php echo $product_type;?>" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
<div class="container grid-gap content">
	<div class="main-content <?php echo $userStatus;?>">
		<?php if ( $checkout->get_checkout_fields() ) : ?>
	
			<?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
	
			<div class="col2-set" id="customer_details">
				<div class="col-1">
					<section>
					<?php do_action( 'woocommerce_checkout_billing' ); ?>
					</section>
				</div>
	
	<?php  
	  // set our flag to be false until we find a product in that category
	  $cat_check = false;
			  
	  // check each cart item for our category
	  foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				  
		  $product = $cart_item['data'];
	
		  if ( has_term( 'membership-plan', 'product_cat', $product->id ) ) {
			  $cat_check = true;?>
			 
			<section class="checkboxes">
				<label>Role</label>
				<p>
					<label for="gp_partner">
						<input type="checkbox" id="gp_partner" name="gp_partner" value="1"<?php echo $partner_checked; ?>>
						<span>GP Partner</span>
					</label>
				</p>
				<p>
					<label for="salaried_gp">
						<input type="checkbox" id="salaried_gp" name="salaried_gp" value="1"<?php echo $salaried_checked; ?>>
					 <span>Salaried GP</span>
					</label>
				</p>
				<p>
					<label for="locum_gp">
						<input type="checkbox" id="locum_gp" name="locum_gp" value="1"<?php echo $locum_checked; ?>>
					 <span>Locum GP</span>
					</label>
				</p>
				<p>
					<label for="new_gp">
						<input type="checkbox" id="new_gp" name="new_gp" value="1"<?php echo $new_checked; ?>>
					 <span>Newly Qualified GP (within 5 years of qualifying)</span>
					</label>
				</p>
				<p>
					<label for="practice_manager">
						<input type="checkbox" id="practice_manager" name="practice_manager" value="1"<?php echo $practice_checked; ?>>
					 <span>Practice Manager</span>
					</label>
				</p>
			  </section>
			
			  <?php break;
		  }
	  }?>



				<div class="col-2">
					<?php do_action( 'woocommerce_checkout_shipping' ); ?>
				</div>
			</div>

			<?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>

		<?php endif; ?>
	</div>
	<div class="side-content">
		<?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>

		<h3 id="order_review_heading"><?php esc_html_e( 'Your order', 'woocommerce' ); ?></h3>
		
		<?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
	
		<div id="order_review" class="woocommerce-checkout-review-order">
			<?php do_action( 'woocommerce_checkout_order_review' ); ?>
		</div>
	
		<?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
	</div>
</div>
</form>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>