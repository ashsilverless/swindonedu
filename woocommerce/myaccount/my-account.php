<?php
/**
 * My Account page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/my-account.php.
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

/**
 * My Account navigation.
 *
 * @since 2.6.0
 */?>
 <div class="container grid-gap content reverse">
	<div class="side-content">
        <?php do_action( 'woocommerce_account_navigation' ); ?>

        <h3 class="heading heading__6" style="margin-bottom: 1rem;">You are logged in as <strong><?php printf(esc_html( $current_user->display_name ));?></strong></h3>
        <a href="%2$s" class="button">Log out<i class="fas fa-chevron-right"></i></a>
        
	 </div>
	 <div class="main-content">
		<div class="woocommerce-MyAccount-content">
			<?php
				/**
				 * My Account content.
				 *
				 * @since 2.6.0
				 */
				do_action( 'woocommerce_account_content' );
			?>
		</div>
	 </div>