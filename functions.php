<?php
/**
 * swindonedu functions and definitions
 *
 * @package swindonedu
 */

/****************************************************/
/*                       Hooks                       /
/****************************************************/

/* Enqueue scripts and styles */
add_action('wp_enqueue_scripts', 'swindonedu_scripts');

/* Add Menus */
add_action('init', 'swindonedu_custom_menu');

/* Dashboard Config */
add_action('wp_dashboard_setup', 'swindonedu_dashboard_widget');

/* Dashboard Style */
add_action('admin_head', 'swindonedu_custom_fonts');

/* Remove Default Menu Items */
add_action('admin_menu', 'swindonedu_remove_menus');

/* Change Posts Columns */
add_filter('manage_posts_columns', 'swindonedu_manage_columns');

/* Reorder Admin Menu */
add_filter('custom_menu_order', 'swindonedu_reorder_menu');
add_filter('menu_order', 'swindonedu_reorder_menu');

/* Remove Comments Link */
add_action('wp_before_admin_bar_render', 'swindonedu_manage_admin_bar');

/* Remove Admin Bar */
add_action('after_setup_theme', 'swindonedu_remove_admin_bar');

/**= Add Custom Post Types and Taxonomies =**/

require_once ('custom-post-types.php');

/****************************************************/
/*                     Functions                     /
/****************************************************/

function swindonedu_scripts() {
	wp_enqueue_style( 'swindonedu-style', get_stylesheet_uri() );
	wp_enqueue_script( 'swindonedu-core-js', get_template_directory_uri() . '/inc/js/compiled.js', array('jquery'), true);
	wp_enqueue_script( 'swindonedu-owl-js', get_template_directory_uri() . '/inc/js/owl.carousel.min.js', array('jquery'), true);
}

// add async and defer attributes to enqueued scripts
function shapeSpace_script_loader_tag($tag, $handle, $src) {
	
	if ($handle === 'my-plugin-javascript-handle') {
		
		if (false === stripos($tag, 'async')) {
			
			$tag = str_replace(' src', ' async="async" src', $tag);
			
		}
		
		if (false === stripos($tag, 'defer')) {
			
			$tag = str_replace('<script ', '<script defer ', $tag);
			
		}
		
	}
	
	return $tag;
	
}
add_filter('script_loader_tag', 'shapeSpace_script_loader_tag', 10, 3);

function swindonedu_custom_menu() {
	register_nav_menus(array(
		'upper-menu' => __( 'Main Menu Upper' ),
		'lower-menu' => __( 'Main Menu Lower' ),
		'footer-menu' => __( 'Footer Menu' ),
	));
}
add_action( 'init', 'swindonedu_custom_menu' );

function swindonedu_dashboard_widget() {
	global $wp_meta_boxes;
	wp_add_dashboard_widget('custom_help_widget', 'swindonedu Support', 'swindonedu_dashboard_help');
}

function swindonedu_dashboard_help() {
	echo file_get_contents(__DIR__ . "/admin-settings/dashboard.html");
}

function swindonedu_custom_fonts() {
	echo '<style type="text/css">' . file_get_contents(__DIR__ . "/admin-settings/style-admin.css") . '</style>';

	if(function_exists('acf_add_options_page')) {
		acf_add_options_page(array(
			'page_title' 	=> 'Theme Settings',
			'menu_title'	=> 'Theme Settings',
			'menu_slug' 	=> 'site-general-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
		));
	}
}

function swindonedu_remove_menus(){
	remove_menu_page( 'edit-comments.php' ); //Comments
}

function swindonedu_manage_columns($columns) {
	unset($columns["comments"]);
	return $columns;
}

function swindonedu_reorder_menu() {
    return array(
		'index.php',                        // Dashboard
		'separator1',                       // --Space--
		'edit.php',                         // Posts
		'edit.php?post_type=page',          // Pages
		'upload.php',                       // Media
		'separator2',                       // --Space--
		'themes.php',                       // Appearance
		'plugins.php',                      // Plugins
		'users.php',                        // Users
		'tools.php',                        // Tools
		'options-general.php',              // Settings
		'wpcf7',                            // Contact Form 7
   );
}

function swindonedu_manage_admin_bar(){
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('comments');
}


if(function_exists('acf_add_options_page')) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme Settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'site-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}

function swindonedu_remove_admin_bar() {
	show_admin_bar(false);
}

/**
WooCommerce Support
*/
add_action( 'after_setup_theme', 'woocommerce_support' );
function woocommerce_support() {
   add_theme_support( 'woocommerce' );
}
if (class_exists('Woocommerce')){
	add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
}
   
/**
Calculates product price if user is a member (businessbloomer)
*/
add_filter( 'woocommerce_get_price_html', 'bbloomer_alter_price_display', 9999, 10 );
 
function bbloomer_alter_price_display( $price_html, $product ) {
	
	// ONLY ON FRONTEND
	if ( is_admin() ) return $price_html;
	
	// ONLY IF PRICE NOT NULL
	if ( '' === $product->get_price() ) return $price_html;
	
	// IF CUSTOMER LOGGED IN, APPLY DISCOUNT   
	if ( wc_current_user_has_role( 'gp_role' ) || wc_current_user_has_role( 'standard_role' ) ) {
		$orig_price = wc_get_price_to_display( $product );
		$price_html = wc_price( $orig_price * .18 );
		//$price_html = '<span class="woocommerce-Price-amount amount">FREE</span>';
	}
	return $price_html;
}
 
/**
Calculates cart/checkout price if user is a member (businessbloomer)
*/
add_action( 'woocommerce_before_calculate_totals', 'bbloomer_alter_price_cart', 9999, 10 );
 
function bbloomer_alter_price_cart( $cart ) {
 
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
 
	if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) return;
 
	if ( wc_current_user_has_role( 'gp_role' ) || wc_current_user_has_role( 'standard_role' ) ) {
		
		foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
			$product = $cart_item['data'];
			$price = $product->get_price();
			$cart_item['data']->set_price( $price * .18 );
		}
	}
}
/**
Google Map API with ACF
*/
// Method 1: Filter.
function my_acf_google_map_api( $api ){
	$api['key'] = 'AIzaSyDdLgvjad0_pDCxQocNwFUjrAer1G9zx-g';
	return $api;
}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

/**
Add Custom Field to Checkout
*/
add_action( 'woocommerce_after_order_notes', 'my_custom_checkout_field' );

function my_custom_checkout_field( $checkout ) {

	echo '<div id="my_custom_checkout_field"><h2>' . __('My Field') . '</h2>';

	woocommerce_form_field( 'my_field_name', array(
		'type'          => 'text',
		'class'         => array('my-field-class form-row-wide'),
		'label'         => __('Fill in this field'),
		'placeholder'   => __('Enter something'),
		), $checkout->get_value( 'my_field_name' ));

	echo '</div>';

}
/**
 * Process the checkout
 */
add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
	// Check if set, if its not set add an error.
	if ( ! $_POST['my_field_name'] )
		wc_add_notice( __( 'Please enter something into this new shiny field.' ), 'error' );
}
/**
 * Update the order meta with field value
 */
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {
	if ( ! empty( $_POST['my_field_name'] ) ) {
		update_post_meta( $order_id, 'My Field', sanitize_text_field( $_POST['my_field_name'] ) );
	}
}
/**
 * Display field value on the order edit page
 */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
	echo '<p><strong>'.__('My Field').':</strong> ' . get_post_meta( $order->id, 'My Field', true ) . '</p>';
}




/**
Change user role when membership purchased
*/
add_action( 'woocommerce_order_status_completed', 'change_role_on_purchase' );
function change_role_on_purchase( $order_id ) {
	$order = wc_get_order( $order_id );
	$items = $order->get_items();
	
	$checkifstandard = array( 21 );//This is checking to see if the user has purchased a Standard Membership
	$checkifgp = array( 113 );//This is checking to see if the user has purchased a GP Membership
	
	foreach ( $items as $item ) {
		if ( $order->user_id > 0 && in_array( $item['product_id'], $checkifstandard ) ) {
			$user = new WP_User( $order->user_id );
			add_role(  'standard_role', 'Standard Membership', array( 'read' => true, 'level_0' => true ) ); 
			// Change role
			$user->remove_role( 'customer' );
			$user->remove_role( 'gp_role' );
			$user->add_role( 'standard_role' );
		} elseif ( $order->user_id > 0 && in_array( $item['product_id'], $checkifgp ) ){
			$user = new WP_User( $order->user_id );
			add_role(  'gp_role', 'GP Membership', array( 'read' => true, 'level_0' => true ) ); 
			// Change role
			$user->remove_role('customer');
			$user->remove_role('standard_role');
			$user->add_role( 'gp_role' );
		// Exit the loop
		break;
		}
	}
}

/**
Redirect straight to checkout on new purchase
*/
add_filter('woocommerce_add_to_cart_redirect', 'themeprefix_add_to_cart_redirect');
function themeprefix_add_to_cart_redirect() {
 global $woocommerce;
 $checkout_url = wc_get_checkout_url();
 return $checkout_url;
}

/**
Remove address fields on checkout
*/
add_filter('woocommerce_billing_fields','wpb_custom_billing_fields');
// remove some fields from billing form
// ref - https://docs.woothemes.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
function wpb_custom_billing_fields( $fields = array() ) {

	unset($fields['billing_company']);
	unset($fields['billing_address_1']);
	unset($fields['billing_address_2']);
	unset($fields['billing_state']);
	unset($fields['billing_city']);
	unset($fields['billing_phone']);
	unset($fields['billing_postcode']);
	unset($fields['billing_country']);

	return $fields;
}
/**
Create Register Form
*/
/**
 * @snippet       WooCommerce User Registration Shortcode
 * @how-to        Get CustomizeWoo.com FREE
 * @author        Rodolfo Melogli
 * @compatible    WooCommerce 4.0
 * @donate $9     https://businessbloomer.com/bloomer-armada/
 */
   
add_shortcode( 'wc_reg_form_bbloomer', 'bbloomer_separate_registration_form' );
	
function bbloomer_separate_registration_form() {
   if ( is_admin() ) return;
   if ( is_user_logged_in() ) return;
   ob_start();
 
   // NOTE: THE FOLLOWING <FORM></FORM> IS COPIED FROM woocommerce\templates\myaccount\form-login.php
   // IF WOOCOMMERCE RELEASES AN UPDATE TO THAT TEMPLATE, YOU MUST CHANGE THIS ACCORDINGLY
 
   do_action( 'woocommerce_before_customer_login_form' );
 
   ?>
	  <form method="post" class="woocommerce-form woocommerce-form-register register" <?php do_action( 'woocommerce_register_form_tag' ); ?> >

		 <?php do_action( 'woocommerce_register_form_start' ); ?>
 
		 <?php if ( 'no' === get_option( 'woocommerce_registration_generate_username' ) ) : ?>
 
			<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			   <label for="reg_username"><?php esc_html_e( 'Username', 'woocommerce' ); ?> <span class="required">*</span></label>
			   <input type="text" class="woocommerce-Input woocommerce-Input--text input-text" name="username" id="reg_username" autocomplete="username" value="<?php echo ( ! empty( $_POST['username'] ) ) ? esc_attr( wp_unslash( $_POST['username'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
			</p>
 
		 <?php endif; ?>
 
			<p class="">
				<label for="reg_billing_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! 	empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />
			</p>
			
			<p class="">
				<label for="reg_billing_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />
			</p>

			<p class="">
				<label for="reg_billing_address_1"><?php _e( 'Address Line One', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" name="billing_address_1" id="reg_billing_address_1" value="<?php if ( ! empty( $_POST['billing_address_1'] ) ) esc_attr_e( $_POST['billing_address_1'] ); ?>" />
			</p>
			
 		   	<p class="">
				<label for="reg_billing_address_2"><?php _e( 'Address Line Two', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" name="billing_address_2" id="reg_billing_address_2" value="<?php if ( ! empty( $_POST['billing_address_2'] ) ) esc_attr_e( $_POST['billing_address_2'] ); ?>" />
			</p>
			<p class="">
				<label for="reg_billing_city"><?php _e( 'City/Town', 'woocommerce' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text" name="billing_city" id="reg_billing_city" value="<?php if ( ! empty( $_POST['billing_city'] ) ) esc_attr_e( $_POST['billing_city'] ); ?>" />
			</p>
 
 
		 <p class="">
			<label for="reg_email"><?php esc_html_e( 'Email address', 'woocommerce' ); ?> <span class="required">*</span></label>
			<input type="email" class="woocommerce-Input woocommerce-Input--text input-text" name="email" id="reg_email" autocomplete="email" value="<?php echo ( ! empty( $_POST['email'] ) ) ? esc_attr( wp_unslash( $_POST['email'] ) ) : ''; ?>" /><?php // @codingStandardsIgnoreLine ?>
		 </p>
 
		 <?php if ( 'no' === get_option( 'woocommerce_registration_generate_password' ) ) : ?>
 
			<p class="">
			   <label for="reg_password"><?php esc_html_e( 'Password', 'woocommerce' ); ?> <span class="required">*</span></label>
			   <input type="password" class="woocommerce-Input woocommerce-Input--text input-text" name="password" id="reg_password" autocomplete="new-password" />
			</p>
 
		 <?php else : ?>
 
			<p><?php esc_html_e( 'A password will be sent to your email address.', 'woocommerce' ); ?></p>
 
		 <?php endif; ?>
 
		 <?php do_action( 'woocommerce_register_form' ); ?>
 
		 <p class="">
			<?php wp_nonce_field( 'woocommerce-register', 'woocommerce-register-nonce' ); ?>
			<button type="submit" class="woocommerce-Button woocommerce-button button woocommerce-form-register__submit" name="register" value="<?php esc_attr_e( 'Register', 'woocommerce' ); ?>"><?php esc_html_e( 'Regidddster', 'woocommerce' ); ?></button>
		 </p>
 
		 <?php do_action( 'woocommerce_register_form_end' ); ?>
 
	  </form>
 
   <?php
	 
   return ob_get_clean();
}

///////////////////////////////
// 2. VALIDATE FIELDS
add_filter( 'woocommerce_registration_errors', 'bbloomer_validate_name_fields', 10, 3 );
  
function bbloomer_validate_name_fields( $errors, $username, $email ) {
	if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {
		$errors->add( 'billing_first_name_error', __( '<strong>Error</strong>: First name is required!', 'woocommerce' ) );
	}
	if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {
		$errors->add( 'billing_last_name_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
	}
	if ( isset( $_POST['billing_address_1'] ) && empty( $_POST['billing_address_1'] ) ) {
		$errors->add( 'billing_address_1_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
	}
	if ( isset( $_POST['billing_address_2'] ) && empty( $_POST['billing_address_2'] ) ) {
		$errors->add( 'billing_address_2_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
	}
	if ( isset( $_POST['billing_city'] ) && empty( $_POST['billing_city'] ) ) {
		$errors->add( 'billing_city_error', __( '<strong>Error</strong>: Last name is required!.', 'woocommerce' ) );
	}
	return $errors;
}
  
///////////////////////////////
// 3. SAVE FIELDS
  
add_action( 'woocommerce_created_customer', 'bbloomer_save_name_fields' );
  
function bbloomer_save_name_fields( $customer_id ) {
	if ( isset( $_POST['billing_first_name'] ) ) {
		update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );
		update_user_meta( $customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']) );
	}
	if ( isset( $_POST['billing_last_name'] ) ) {
		update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );
		update_user_meta( $customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']) );
	}
	if ( isset( $_POST['billing_address_1'] ) ) {
			update_user_meta( $customer_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address_1'] ) );
			update_user_meta( $customer_id, 'billing_address_1', sanitize_text_field($_POST['billing_address_1']) );
	}
	if ( isset( $_POST['billing_address_2'] ) ) {
			update_user_meta( $customer_id, 'billing_address_2', sanitize_text_field( $_POST['billing_address_2'] ) );
			update_user_meta( $customer_id, 'billing_address_2', sanitize_text_field($_POST['billing_address_2']) );
	}  
	if ( isset( $_POST['billing_city'] ) ) {
			update_user_meta( $customer_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );
			update_user_meta( $customer_id, 'billing_city', sanitize_text_field($_POST['billing_city']) );
	}    
}

/**
Custom Fields on Register Form
*/
add_action( 'woocommerce_register_form', 'misha_add_register_form_field' );
function misha_add_register_form_field(){
 
	woocommerce_form_field(
		'country_to_visit',
		array(
			'type'        => 'text',
			'required'    => true, // just adds an "*"
			'label'       => 'Country you want to visit the most'
		),
		( isset($_POST['country_to_visit']) ? $_POST['country_to_visit'] : '' )
	);
 
}

/**
Create Register Form
*/
add_action( 'woocommerce_created_customer', 'misha_save_register_fields' );
function misha_save_register_fields( $customer_id ){
 
	if ( isset( $_POST['country_to_visit'] ) ) {
		update_user_meta( $customer_id, 'country_to_visit', wc_clean( $_POST['country_to_visit'] ) );
	}
 
}

add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>
	<h3>Extra profile information</h3>
	<table class="form-table">
		<tr>
			<th><label for="country_to_visit">Twitter</label></th>
			<td>
				<input type="text" name="country_to_visit" id="country_to_visit" value="<?php echo esc_attr( get_the_author_meta( 'country_to_visit', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Twitter username.</span>
			</td>
		</tr>
	</table>
<?php }

add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'country_to_visit', $_POST['country_to_visit'] );
}