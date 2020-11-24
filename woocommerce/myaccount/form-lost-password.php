<?php
/**
 * Lost password form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/form-lost-password.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.5.2
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_lost_password_form' );
?>


	

<form method="post" class="woocommerce-ResetPassword lost_reset_password">
	<div class="container grid-gap content">
		<div class="main-content">
			<p><?php echo apply_filters( 'woocommerce_lost_password_message', esc_html__( 'Need help with your pasword? Simply enter your username or email address and we\'ll email you a link to create a new password.', 'woocommerce' ) ); ?></p><?php // @codingStandardsIgnoreLine ?>
		</div>
		<div class="side-content password-reset">
			<h4 class="heading heading__5">Reset Password</h4>
			<h3 class="heading heading__3">Enter Your Details</h3>
			<p class="woocommerce-form-row woocommerce-form-row--first form-row form-row-first">
				<label for="user_login"><?php esc_html_e( 'Username or email', 'woocommerce' ); ?></label>
				<input class="woocommerce-Input woocommerce-Input--text input-text" type="text" name="user_login" id="user_login" autocomplete="username" />
			</p>
			<div class="clear"></div>
			<?php do_action( 'woocommerce_lostpassword_form' ); ?>
			<p class="woocommerce-form-row form-row">
				<input type="hidden" name="wc_reset_password" value="true" />
				<button type="submit" class="woocommerce-Button button" value="<?php esc_attr_e( 'Reset password', 'woocommerce' ); ?>"><?php esc_html_e( 'Reset password', 'woocommerce' ); ?><i class="fas fa-chevron-right"></i></button>
			</p>
			<?php wp_nonce_field( 'lost_password', 'woocommerce-lost-password-nonce' ); ?>
		</div>
	</div>
</form>

<?php
do_action( 'woocommerce_after_lost_password_form' );