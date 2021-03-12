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

function my_login_stylesheet() {
	wp_enqueue_style( 'custom-login', get_stylesheet_directory_uri() . '/style.css' );
}
add_action( 'login_enqueue_scripts', 'my_login_stylesheet' );

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
Calculates product price if user is a member (businessbloomer)*/

// add_filter( 'woocommerce_get_price_html', 'bbloomer_alter_price_display');
//  
// function bbloomer_alter_price_display( $price_html, $product ) {
// 	echo "<h1>sdsadasdsa</h1>";
// 	// ONLY ON FRONTEND
// 	if ( is_admin() ) return $price_html;
// 	
// 	// ONLY IF PRICE NOT NULL
// 	if ( '' === $product->get_price() ) return $price_html;
// 	
// 	// IF CUSTOMER LOGGED IN, APPLY DISCOUNT   
// 	$user = wp_get_current_user();
// 	$allowed_roles = array('administrator');
// 	if( array_intersect($allowed_roles, $user->roles ) ) {
// 		
// 		$orig_price = wc_get_price_to_display( $product );
// 		$price_html = wc_price( $orig_price * .18 );
// 		//$price_html = '<span class="woocommerce-Price-amount amount">FREE</span>';
// 		
// 	}
// 	return $price_html;
// }
 
/**
Calculates cart/checkout price if user is a member (businessbloomer)
*/
// add_action( 'woocommerce_before_calculate_totals', 'bbloomer_alter_price_cart', 9999, 10 );
//  
// function bbloomer_alter_price_cart( $cart ) {
//  
// 	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
//  
// 	if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) return;
//  
//  	$user = wp_get_current_user();
// 	$allowed_roles = array('administrator');
// 	if( array_intersect($allowed_roles, $user->roles ) ) {
// 		echo 'is a user';
// 		foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
// 			if( has_term( 26, 'product_cat' ) ) {
// 				
// 				$product = $cart_item['data'];
// 				$price = $product->get_price();
// 				$cart_item['data']->set_price( $price * 7 );
// 			}
// 		}
// 	}
// }

/**
Add Custom Field to Checkout

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
*/
/**
 * Custom Checkboxes on checkout


add_action('woocommerce_after_order_notes', 'cw_custom_checkbox_fields');
function cw_custom_checkbox_fields( $checkout ) {
	echo '<div class="cw_custom_class"><h3>'.__('Give Sepration Heading: ').'</h3>';
	woocommerce_form_field( 'custom_checkbox', array(
		'type'          => 'checkbox',
		'label'         => __('Agreegation Policy.'),
		'required'  => true,
	), $checkout->get_value( 'custom_checkbox' ));
	echo '</div>';
}

add_action('woocommerce_checkout_process', 'cw_custom_process_checkbox');
function cw_custom_process_checkbox() {
	global $woocommerce;
	if (!$_POST['custom_checkbox'])
		wc_add_notice( __( 'Notification message.' ), 'error' );
}

add_action('woocommerce_checkout_update_order_meta', 'cw_checkout_order_meta');
function cw_checkout_order_meta( $order_id ) {
	if ($_POST['custom_checkbox']) update_post_meta( $order_id, 'checkbox name', esc_attr($_POST['custom_checkbox']));
}
*/



/**
 * Process the checkout

add_action('woocommerce_checkout_process', 'my_custom_checkout_field_process');

function my_custom_checkout_field_process() {
	// Check if set, if its not set add an error.
	if ( ! $_POST['my_field_name'] )
		wc_add_notice( __( 'Please enter something into this new shiny field.' ), 'error' );
}
*/
/**
 * Update the order meta with field value
add_action( 'woocommerce_checkout_update_order_meta', 'my_custom_checkout_field_update_order_meta' );

function my_custom_checkout_field_update_order_meta( $order_id ) {
	if ( ! empty( $_POST['my_field_name'] ) ) {
		update_post_meta( $order_id, 'My Field', sanitize_text_field( $_POST['my_field_name'] ) );
	}
}
*/
/**
 * Display field value on the order edit page

add_action( 'woocommerce_admin_order_data_after_billing_address', 'my_custom_checkout_field_display_admin_order_meta', 10, 1 );

function my_custom_checkout_field_display_admin_order_meta($order){
	echo '<p><strong>'.__('My Field').':</strong> ' . get_post_meta( $order->id, 'My Field', true ) . '</p>';
}
*/

//add_role( 'customer', 'Non-Member Customer', get_role( 'author' )->capabilities );


add_action( 'woocommerce_order_status_completed', 'set_change_role_on_purchase' );

function set_change_role_on_purchase( $order_id ) {

// get order object and items
	$order = new WC_Order( $order_id );
	$items = $order->get_items();
	$product_cat = 'course'; 
	
	foreach ( $items as $item ) {

		if( $product_cat == $item['category'] && $order->user_id ) {
			$user = new WP_User( $order->user_id );

			// Add new role
			$user->add_role( 'customer' );
		}
	}
}

/**
Change user role when membership purchased
*/
add_action( 'woocommerce_order_status_completed', 'change_role_on_purchase' );
function change_role_on_purchase( $order_id ) {
	$order = wc_get_order( $order_id );
	$items = $order->get_items();
	
	$checkifmember = array( 616, 617 ,618, 619, 620, 621, 622 );//This is checking to see if the user has purchased a GP Membership
	$checkifgptraining = array( 113 );//This is checking to see if the user has purchased a GP Training Membership
	
	foreach ( $items as $item ) {
		if ( $order->user_id > 0 && in_array( $item['product_id'], $checkifmember ) ) {
			$user = new WP_User( $order->user_id );
			add_role(  'gp_membership', 'Standard Membership', array( 'read' => true, 'level_0' => true ) ); 
			// Change role
			$user->remove_role( 'customer' );
			$user->remove_role( 'gp_training_membership' );
			$user->add_role( 'gp_membership' );
		} elseif ( $order->user_id > 0 && in_array( $item['product_id'], $checkifgptraining ) ){
			$user = new WP_User( $order->user_id );
			add_role(  'gp_training_membership', 'GP Training Membership', array( 'read' => true, 'level_0' => true ) ); 
			// Change role
			$user->remove_role('customer');
			$user->remove_role('gp_membership');
			$user->add_role( 'gp_training_membership' );
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
Change Billing Details
*/
function wc_billing_field_strings( $translated_text, $text, $domain ) {
switch ( $translated_text ) {
case 'Billing details' :
$translated_text = __( 'Booking Information', 'woocommerce' );
break;
}
return $translated_text;
}
add_filter( 'gettext', 'wc_billing_field_strings', 20, 3 );

/**
Create Additional User Field

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
	// Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID.
	update_usermeta( $user_id, 'country_to_visit', $_POST['country_to_visit'] );
}
*/

/**
Override Default Log In Form
*/

function wp_login_form_set( $args = array() ) {
	$defaults = array(
		'echo'           => true,
		// Default 'redirect' value takes the user back to the request URI.
		'redirect'       => ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
		'form_id'        => 'loginform',
		'label_username' => __( 'Username or Email Address' ),
		'label_password' => __( 'Password' ),
		'label_remember' => __( 'Remember me' ),
		'label_log_in'   => __( 'Submit' ),
		'id_username'    => 'user_login',
		'id_password'    => 'user_pass',
		'id_remember'    => 'rememberme',
		'id_submit'      => 'wp-submit',
		'remember'       => true,
		'value_username' => '',
		// Set 'value_remember' to true to default the "Remember me" checkbox to checked.
		'value_remember' => true,
	);
 
	/**
	 * Filters the default login form output arguments.
	 *
	 * @since 3.0.0
	 *
	 * @see wp_login_form()
	 *
	 * @param array $defaults An array of default login form arguments.
	 */
	$args = wp_parse_args( $args, apply_filters( 'login_form_defaults', $defaults ) );
 
	/**
	 * Filters content to display at the top of the login form.
	 *
	 * The filter evaluates just following the opening form tag element.
	 *
	 * @since 3.0.0
	 *
	 * @param string $content Content to display. Default empty.
	 * @param array  $args    Array of login form arguments.
	 */
	$login_form_top = apply_filters( 'login_form_top', '', $args );
 
	/**
	 * Filters content to display in the middle of the login form.
	 *
	 * The filter evaluates just following the location where the 'login-password'
	 * field is displayed.
	 *
	 * @since 3.0.0
	 *
	 * @param string $content Content to display. Default empty.
	 * @param array  $args    Array of login form arguments.
	 */
	$login_form_middle = apply_filters( 'login_form_middle', '', $args );
 
	/**
	 * Filters content to display at the bottom of the login form.
	 *
	 * The filter evaluates just preceding the closing form tag element.
	 *
	 * @since 3.0.0
	 *
	 * @param string $content Content to display. Default empty.
	 * @param array  $args    Array of login form arguments.
	 */
	$login_form_bottom = apply_filters( 'login_form_bottom', '', $args );
 
	$form = '
		<form name="' . $args['form_id'] . '" id="' . $args['form_id'] . '" action="' . esc_url( site_url( 'wp-login.php', 'login_post' ) ) . '" method="post" class="set-form">
			' . $login_form_top . '
			<p class="login-username form-field">
				<label for="' . esc_attr( $args['id_username'] ) . '">Username</label>
				<input type="text" name="log" id="' . esc_attr( $args['id_username'] ) . '" class="input" value="' . esc_attr( $args['value_username'] ) . '" size="20" />
			</p>
			<p class="login-password form-field">
				<label for="' . esc_attr( $args['id_password'] ) . '">Password</label>
				<input type="password" name="pwd" id="' . esc_attr( $args['id_password'] ) . '" class="input" value=""/>
			</p>
			<p class="login-submit">
				<input type="submit" name="wp-submit" id="' . esc_attr( $args['id_submit'] ) . '" class="submit" value="' . esc_attr( $args['label_log_in'] ) . '" />
				<input type="hidden" name="redirect_to" value="' . esc_url( $args['redirect'] ) . '" />
			</p>
			' . $login_form_middle . '
			' . ( $args['remember'] ? '<p class="login-remember">
			<span class="checkbox-wrapper">
				<input name="rememberme" type="checkbox" id="' . esc_attr( $args['id_remember'] ) . '" value="forever"' . ( $args['value_remember'] ? ' checked="checked"' : '' ) . ' />
			</span>
			<label> ' . esc_html( $args['label_remember'] ) . '</label></p>' : '' ) . '
			
			' . $login_form_bottom . '
		</form>';
 
	if ( $args['echo'] ) {
		echo $form;
	} else {
		return $form;
	}
}

/**
Login Fail Redirect
*/
add_action( 'wp_login_failed', 'set_custom_login_failed' );
function set_custom_login_failed( $username ) {
	$referrer = wp_get_referer();
	if ( $referrer && ! strstr($referrer, 'wp-login') && ! strstr($referrer,'wp-admin') ){
		wp_redirect( '/wp-login.php' );
		exit;
	}
}

/**
Add Product Category as ACF Filter
*/

// step 1 add a location rule type
  add_filter('acf/location/rule_types', 'acf_wc_product_type_rule_type');
  function acf_wc_product_type_rule_type($choices) {
	// first add the "Product" Category if it does not exist
	// this will be a place to put all custom rules assocaited with woocommerce
	// the reason for checking to see if it exists or not first
	// is just in case another custom rule is added
	if (!isset($choices['Product'])) {
	  $choices['Product'] = array();
	}
	// now add the 'Category' rule to it
	if (!isset($choices['Product']['product_cat'])) {
	  // product_cat is the taxonomy name for woocommerce products
	  $choices['Product']['product_cat_term'] = 'Product Category Term';
	}
	return $choices;
  }
  
  // step 2 skip custom rule operators, not needed
  
  
  // step 3 add custom rule values
  add_filter('acf/location/rule_values/product_cat_term', 'acf_wc_product_type_rule_values');
  function acf_wc_product_type_rule_values($choices) {
	// basically we need to get an list of all product categories
	// and put the into an array for choices
	$args = array(
	  'taxonomy' => 'product_cat',
	  'hide_empty' => false
	);
	$terms = get_terms($args);
	foreach ($terms as $term) {
	  $choices[$term->term_id] = $term->name;
	}
	return $choices;
  }
  
  // step 4, rule match
  add_filter('acf/location/rule_match/product_cat_term', 'acf_wc_product_type_rule_match', 10, 3);
  function acf_wc_product_type_rule_match($match, $rule, $options) {
	if (!isset($_GET['tag_ID'])) {
	  // tag id is not set
	  return $match;
	}
	if ($rule['operator'] == '==') {
	  $match = ($rule['value'] == $_GET['tag_ID']);
	} else {
	  $match = !($rule['value'] == $_GET['tag_ID']);
	}
	return $match;
  }
  
  /**
  Add Checkboxes and link to account profile
  */
  
  add_action('show_user_profile', 'my_user_profile_edit_action');
  add_action('edit_user_profile', 'my_user_profile_edit_action');
  add_action( 'woocommerce_before_order_notes', 'my_user_profile_edit_action');
  function my_user_profile_edit_action($user) {
	  /*
	$partner_checked = (isset($user->gp_partner) && $user->gp_partner) ? ' checked="checked"' : '';
	$salaried_checked = (isset($user->salaried_gp) && $user->salaried_gp) ? ' checked="checked"' : '';
	$locum_checked = (isset($user->locum_gp) && $user->locum_gp) ? ' checked="checked"' : '';
	$new_checked = (isset($user->new_gp) && $user->new_gp) ? ' checked="checked"' : '';
	$practice_checked = (isset($user->practice_manager) && $user->practice_manager) ? ' checked="checked"' : '';
	*/
	$partner_checked = (isset($user->gp_partner) && $user->gp_partner) ? ' checked="checked"' : '';
	$sessional_checked = (isset($user->sessional_gp) && $user->sessional_gp) ? ' checked="checked"' : '';
	$whole_checked = (isset($user->whole_practice) && $user->whole_practice) ? ' checked="checked"' : '';
	$nurse_checked = (isset($user->practice_nurse) && $user->practice_nurse) ? ' checked="checked"' : '';
	$paramedic_checked = (isset($user->paramedic) && $user->paramedic) ? ' checked="checked"' : '';
	$pharmacist_checked = (isset($user->pharmacist) && $user->pharmacist) ? ' checked="checked"' : '';
	$other_checked = (isset($user->other_healthcare) && $user->other_healthcare) ? ' checked="checked"' : '';
	$trainee_checked = (isset($user->gp_trainee) && $user->gp_trainee) ? ' checked="checked"' : '';
	
  }
  add_action('personal_options_update', 'my_user_profile_update_action');
  add_action('edit_user_profile_update', 'my_user_profile_update_action');
  add_action('woocommerce_checkout_update_user_meta', 'my_user_profile_update_action');
  add_action('woocommerce_checkout_before_customer_details', 'my_user_profile_update_action');
  function my_user_profile_update_action($user_id) {
	  /*
	update_user_meta($user_id, 'gp_partner', isset($_POST['gp_partner']));
	update_user_meta($user_id, 'salaried_gp', isset($_POST['salaried_gp']));
	update_user_meta($user_id, 'locum_gp', isset($_POST['locum_gp']));
	update_user_meta($user_id, 'new_gp', isset($_POST['new_gp']));
	update_user_meta($user_id, 'practice_manager', isset($_POST['practice_manager']));
	*/
	update_user_meta($user_id, 'gp_partner', isset($_POST['gp_partner']));
	update_user_meta($user_id, 'sessional_gp', isset($_POST['sessional_gp']));
	update_user_meta($user_id, 'whole_practice', isset($_POST['whole_practice']));
	update_user_meta($user_id, 'practice_nurse', isset($_POST['practice_nurse']));
	update_user_meta($user_id, 'paramedic', isset($_POST['paramedic']));
	update_user_meta($user_id, 'pharmacist', isset($_POST['pharmacist']));
	update_user_meta($user_id, 'other_healthcare', isset($_POST['other_healthcare']));
	update_user_meta($user_id, 'gp_trainee', isset($_POST['gp_trainee']));
  }

/**
  Redirect on incorrect password
  */

add_action( 'wp_login_failed', 'custom_login_failed' );
function custom_login_failed( $username )
{
	$referrer = wp_get_referer();

	if ( $referrer && ! strstr($referrer, 'wp-login') && ! strstr($referrer,'wp-admin') )
	{
		wp_redirect( $url );
		exit;
	}
}

/**
  Change Logo on Login Page
  */
function my_login_logo_one() { 
	get_template_part ('inc/img/set-logo');
	} 
add_action( 'login_message', 'my_login_logo_one' );

/**
  Change Components on Login Page
  */function set_custom_login() { 
	echo '<div class="reset-password">
	<a href="http://swindon-education-trust.local/my-account/lost-password/"> <i class="fas fa-question-circle"></i> Lost your password?</a>
</div>';
	} 
add_action( 'login_form', 'set_custom_login' );

function set_custom_login_footer() { 
	$url = home_url();
	echo '<div class="return-to-site"><a href="'. $url .'">&larr; Return to Swindon Education Trust</a></div>';
	} 
add_action( 'login_footer', 'set_custom_login_footer' );

function wpse_lost_password_redirect() {

	// Check if have submitted
	$confirm = ( isset($_GET['action'] ) && $_GET['action'] == resetpass );

	if( $confirm ) {
		wp_redirect( home_url() );
		exit;
	}
}
add_action('login_headerurl', 'wpse_lost_password_redirect');

add_action( 'woocommerce_review_order_after_submit', 'checkout_reset_button', 10 );
function checkout_reset_button(){
	echo '<a class="button button__clear" href="?cancel=1"><i class="fas fa-trash-alt"></i>'.__("Clear All Items", "woocommerce").'</a>';
}

add_action( 'template_redirect', 'checkout_reset_cart' );
function checkout_reset_cart() {
	if( ! is_admin() && isset($_GET['cancel']) ) {
		WC()->cart->empty_cart();
		wp_redirect( get_permalink( wc_get_page_id( 'cart' ) ) );
		exit();
	}
}

function user_extra_meta_fields(){
	
	 return array(
	   'plan_expiry_date' => __( 'Plan Expiry Date', 'swindonedu'),
	 ); 
	
	} 
	
	function add_contact_methods( $contactmethods ) {
		 $contactmethods = array_merge( $contactmethods, user_extra_meta_fields());
		 return $contactmethods;
	}
	
	add_filter('user_contactmethods','add_contact_methods',10,1);
	
	add_action('woocommerce_after_order_notes', 'my_custom_checkout_field');
	
	function my_custom_checkout_field( $checkout ) {
	
	  foreach( user_extra_meta_fields() as $name => $label) {
		 $value = '';     
		 if( is_user_logged_in() )
		 $value = get_user_meta( get_current_user_id(), $name, true );
	
		  woocommerce_form_field( $name, array(
				'type'          => 'date',
				'class'         => array('plan-expiry-date'),
				'label'         => $label,
				), $value );
	
		  }
	}
	
	add_action( 'woocommerce_checkout_process', 'user_fields_woocommerce_checkout_process' );
	
	function user_fields_woocommerce_checkout_process(){
	
	  if( is_user_logged_in() )
	  add_action('woocommerce_checkout_update_user_meta', 'my_custom_checkout_field_update_user_meta' );
	  else 
	  add_action( 'woocommerce_created_customer',  'my_custom_checkout_field_update_user_meta' );
	}

	function my_custom_checkout_field_update_user_meta( $user_id ) {
	
		foreach( array_keys( user_extra_meta_fields() ) as $meta_name  ){
		  if( isset( $_POST[$meta_name] ) ){
			 $meta_value = $_POST[$meta_name] ? esc_attr($_POST[$meta_name]) : '';                                                    
			 update_user_meta( $user_id,  $meta_name, $meta_value );  
		  }
	
		}
	}


function expired_membership() {
global $current_user; 
get_currentuserinfo();
$now = new DateTime();
$now = $now->format('Y/m/d');
$thisuser = new WP_User($current_user->ID);
if ( $current_user ) {
	
	$current_expiry_date = get_user_meta( $current_user->ID, 'plan_expiry_date' , true );
	$time = strtotime($current_expiry_date);
	$newformat = date('Y/m/d',$time);

	if($newformat < $now) {
		$thisuser->remove_role( 'gp_training_membership' );
		$thisuser->remove_role( 'gp_training_membership' );
		$thisuser->add_role( 'customer' );
	} else {
		//Do nothing
	}
}

}
add_action('woocommerce_before_checkout_billing_form', 'expired_membership', 10, 2);

add_action('woocommerce_email_header', 'add_to_email');
function add_to_email() {
	get_template_part ('inc/img/set-logo-email');
}

add_action('woocommerce_after_checkout_billing_form', 'not_signed_in');
function not_signed_in() {
	if ( ! is_user_logged_in() ) {?>
	<section class="new-user-notice">
		<i class="fas fa-info-circle"></i>
		<div>
			<p>An account will be created for you automatically.  A password will be generated and emailed to you.</p>
			<p>If you already have an account <a href="" class="inline-link trigger-login">Log In Here</a></p>
		</div>
	</section>
	<?php }
}

add_filter('manage_edit-shop_order_columns', 'misha_order_items_column' );
function misha_order_items_column( $order_columns ) {
	$order_columns['order_products'] = "Purchased products";
	return $order_columns;
}
 
add_action( 'manage_shop_order_posts_custom_column' , 'misha_order_items_column_cnt' );
function misha_order_items_column_cnt( $colname ) {
	global $the_order; // the global order object
 
	 if( $colname == 'order_products' ) {
 
		// get items from the order global object
		$order_items = $the_order->get_items();
 
		if ( !is_wp_error( $order_items ) ) {
			foreach( $order_items as $order_item ) {
 
				 echo $order_item['quantity'] .' × <a href="' . admin_url('post.php?post=' . $order_item['product_id'] . '&action=edit' ) . '">'. $order_item['name'] .'</a><br />';
				// you can also use $order_item->variation_id parameter
				// by the way, $order_item['name'] will display variation name too
 
			}
		}
 
	}
 
}
// WooCommerce - Add email column to shop order table

add_filter( 'manage_shop_order_posts_columns', 'set_shop_order_posts_columns', 99 );
function set_shop_order_posts_columns( $columns ) {
  $columns['email_address'] = 'Email';
  return $columns;
}

add_action( 'manage_shop_order_posts_custom_column' , 'show_custom_columns', 10, 2 );
function show_custom_columns( $column_name, $post_id ) {
  switch ( $column_name ) {
	case 'email_address':
	  $order = new WC_Order( $post_id );
	  print $order->get_billing_email();
	  break;
  }
}

add_action( 'admin_footer', 'woocommerce_admin_init' );
function woocommerce_admin_init() {
	$screen = get_current_screen();
	if ( $screen->post_type == "shop_order" ) {
	?>
	<script type="text/javascript">
	/*
	 * printThis v1.15.1
	 * @desc Printing plug-in for jQuery
	 * @author Jason Day
	 *
	 * Resources (based on):
	 * - jPrintArea: http://plugins.jquery.com/project/jPrintArea
	 * - jqPrint: https://github.com/permanenttourist/jquery.jqprint
	 * - Ben Nadal: http://www.bennadel.com/blog/1591-Ask-Ben-Print-Part-Of-A-Web-Page-With-jQuery.htm
	 *
	 * Licensed under the MIT licence:
	 *              http://www.opensource.org/licenses/mit-license.php
	 *
	 * (c) Jason Day 2015-2019
	 *
	 * Usage:
	 *
	 *  $("#mySelector").printThis({
	 *      debug: false,                   // show the iframe for debugging
	 *      importCSS: true,                // import parent page css
	 *      importStyle: false,             // import style tags
	 *      printContainer: true,           // grab outer container as well as the contents of the selector
	 *      loadCSS: "path/to/my.css",      // path to additional css file - use an array [] for multiple
	 *      pageTitle: "",                  // add title to print page
	 *      removeInline: false,            // remove all inline styles from print elements
	 *      removeInlineSelector: "body *", // custom selectors to filter inline styles. removeInline must be true
	 *      printDelay: 333,                // variable print delay
	 *      header: null,                   // prefix to html
	 *      footer: null,                   // postfix to html
	 *      base: false,                    // preserve the BASE tag, or accept a string for the URL
	 *      formValues: true,               // preserve input/form values
	 *      canvas: false,                  // copy canvas elements
	 *      doctypeString: '...',           // enter a different doctype for older markup
	 *      removeScripts: false,           // remove script tags from print content
	 *      copyTagClasses: false           // copy classes from the html & body tag
	 *      beforePrintEvent: null,         // callback function for printEvent in iframe
	 *      beforePrint: null,              // function called before iframe is filled
	 *      afterPrint: null                // function called before iframe is removed
	 *  });
	 *
	 * Notes:
	 *  - the loadCSS will load additional CSS (with or without @media print) into the iframe, adjusting layout
	 */
	;
	(function($) {
	
		function appendContent($el, content) {
			if (!content) return;
	
			// Simple test for a jQuery element
			$el.append(content.jquery ? content.clone() : content);
		}
	
		function appendBody($body, $element, opt) {
			// Clone for safety and convenience
			// Calls clone(withDataAndEvents = true) to copy form values.
			var $content = $element.clone(opt.formValues);
	
			if (opt.formValues) {
				// Copy original select and textarea values to their cloned counterpart
				// Makes up for inability to clone select and textarea values with clone(true)
				copyValues($element, $content, 'select, textarea');
			}
	
			if (opt.removeScripts) {
				$content.find('script').remove();
			}
	
			if (opt.printContainer) {
				// grab $.selector as container
				$content.appendTo($body);
			} else {
				// otherwise just print interior elements of container
				$content.each(function() {
					$(this).children().appendTo($body)
				});
			}
		}
	
		// Copies values from origin to clone for passed in elementSelector
		function copyValues(origin, clone, elementSelector) {
			var $originalElements = origin.find(elementSelector);
	
			clone.find(elementSelector).each(function(index, item) {
				$(item).val($originalElements.eq(index).val());
			});
		}
	
		var opt;
		$.fn.printThis = function(options) {
			opt = $.extend({}, $.fn.printThis.defaults, options);
			var $element = this instanceof jQuery ? this : $(this);
	
			var strFrameName = "printThis-" + (new Date()).getTime();
	
			if (window.location.hostname !== document.domain && navigator.userAgent.match(/msie/i)) {
				// Ugly IE hacks due to IE not inheriting document.domain from parent
				// checks if document.domain is set by comparing the host name against document.domain
				var iframeSrc = "javascript:document.write(\"<head><script>document.domain=\\\"" + document.domain + "\\\";</s" + "cript></head><body></body>\")";
				var printI = document.createElement('iframe');
				printI.name = "printIframe";
				printI.id = strFrameName;
				printI.className = "MSIE";
				document.body.appendChild(printI);
				printI.src = iframeSrc;
	
			} else {
				// other browsers inherit document.domain, and IE works if document.domain is not explicitly set
				var $frame = $("<iframe id='" + strFrameName + "' name='printIframe' />");
				$frame.appendTo("body");
			}
	
			var $iframe = $("#" + strFrameName);
	
			// show frame if in debug mode
			if (!opt.debug) $iframe.css({
				position: "absolute",
				width: "0px",
				height: "0px",
				left: "-600px",
				top: "-600px"
			});
	
			// before print callback
			if (typeof opt.beforePrint === "function") {
				opt.beforePrint();
			}
	
			// $iframe.ready() and $iframe.load were inconsistent between browsers
			setTimeout(function() {
	
				// Add doctype to fix the style difference between printing and render
				function setDocType($iframe, doctype){
					var win, doc;
					win = $iframe.get(0);
					win = win.contentWindow || win.contentDocument || win;
					doc = win.document || win.contentDocument || win;
					doc.open();
					doc.write(doctype);
					doc.close();
				}
	
				if (opt.doctypeString){
					setDocType($iframe, opt.doctypeString);
				}
	
				var $doc = $iframe.contents(),
					$head = $doc.find("head"),
					$body = $doc.find("body"),
					$base = $('base'),
					baseURL;
	
				// add base tag to ensure elements use the parent domain
				if (opt.base === true && $base.length > 0) {
					// take the base tag from the original page
					baseURL = $base.attr('href');
				} else if (typeof opt.base === 'string') {
					// An exact base string is provided
					baseURL = opt.base;
				} else {
					// Use the page URL as the base
					baseURL = document.location.protocol + '//' + document.location.host;
				}
	
				$head.append('<base href="' + baseURL + '">');
	
				// import page stylesheets
				if (opt.importCSS) $("link[rel=stylesheet]").each(function() {
					var href = $(this).attr("href");
					if (href) {
						var media = $(this).attr("media") || "all";
						$head.append("<link type='text/css' rel='stylesheet' href='" + href + "' media='" + media + "'>");
					}
				});
	
				// import style tags
				if (opt.importStyle) $("style").each(function() {
					$head.append(this.outerHTML);
				});
	
				// add title of the page
				if (opt.pageTitle) $head.append("<title>" + opt.pageTitle + "</title>");
	
				// import additional stylesheet(s)
				if (opt.loadCSS) {
					if ($.isArray(opt.loadCSS)) {
						jQuery.each(opt.loadCSS, function(index, value) {
							$head.append("<link type='text/css' rel='stylesheet' href='" + this + "'>");
						});
					} else {
						$head.append("<link type='text/css' rel='stylesheet' href='" + opt.loadCSS + "'>");
					}
				}
	
				var pageHtml = $('html')[0];
	
				// CSS VAR in html tag when dynamic apply e.g.  document.documentElement.style.setProperty("--foo", bar);
				$doc.find('html').prop('style', pageHtml.style.cssText);
	
				// copy 'root' tag classes
				var tag = opt.copyTagClasses;
				if (tag) {
					tag = tag === true ? 'bh' : tag;
					if (tag.indexOf('b') !== -1) {
						$body.addClass($('body')[0].className);
					}
					if (tag.indexOf('h') !== -1) {
						$doc.find('html').addClass(pageHtml.className);
					}
				}
	
				// print header
				appendContent($body, opt.header);
	
				if (opt.canvas) {
					// add canvas data-ids for easy access after cloning.
					var canvasId = 0;
					// .addBack('canvas') adds the top-level element if it is a canvas.
					$element.find('canvas').addBack('canvas').each(function(){
						$(this).attr('data-printthis', canvasId++);
					});
				}
	
				appendBody($body, $element, opt);
	
				if (opt.canvas) {
					// Re-draw new canvases by referencing the originals
					$body.find('canvas').each(function(){
						var cid = $(this).data('printthis'),
							$src = $('[data-printthis="' + cid + '"]');
	
						this.getContext('2d').drawImage($src[0], 0, 0);
	
						// Remove the markup from the original
						if ($.isFunction($.fn.removeAttr)) {
							$src.removeAttr('data-printthis');
						} else {
							$.each($src, function(i, el) {
								el.removeAttribute('data-printthis');
							});
						}
					});
				}
	
				// remove inline styles
				if (opt.removeInline) {
					// Ensure there is a selector, even if it's been mistakenly removed
					var selector = opt.removeInlineSelector || '*';
					// $.removeAttr available jQuery 1.7+
					if ($.isFunction($.removeAttr)) {
						$body.find(selector).removeAttr("style");
					} else {
						$body.find(selector).attr("style", "");
					}
				}
	
				// print "footer"
				appendContent($body, opt.footer);
	
				// attach event handler function to beforePrint event
				function attachOnBeforePrintEvent($iframe, beforePrintHandler) {
					var win = $iframe.get(0);
					win = win.contentWindow || win.contentDocument || win;
	
					if (typeof beforePrintHandler === "function") {
						if ('matchMedia' in win) {
							win.matchMedia('print').addListener(function(mql) {
								if(mql.matches)  beforePrintHandler();
							});
						} else {
							win.onbeforeprint = beforePrintHandler;
						}
					}
				}
				attachOnBeforePrintEvent($iframe, opt.beforePrintEvent);
	
				setTimeout(function() {
					if ($iframe.hasClass("MSIE")) {
						// check if the iframe was created with the ugly hack
						// and perform another ugly hack out of neccessity
						window.frames["printIframe"].focus();
						$head.append("<script>  window.print(); </s" + "cript>");
					} else {
						// proper method
						if (document.queryCommandSupported("print")) {
							$iframe[0].contentWindow.document.execCommand("print", false, null);
						} else {
							$iframe[0].contentWindow.focus();
							$iframe[0].contentWindow.print();
						}
					}
	
					// remove iframe after print
					if (!opt.debug) {
						setTimeout(function() {
							$iframe.remove();
	
						}, 1000);
					}
	
					// after print callback
					if (typeof opt.afterPrint === "function") {
						opt.afterPrint();
					}
	
				}, opt.printDelay);
	
			}, 333);
	
		};
	
		// defaults
		$.fn.printThis.defaults = {
			debug: false,               // show the iframe for debugging
			importCSS: true,            // import parent page css
			importStyle: false,         // import style tags
			printContainer: true,       // print outer container/$.selector
			loadCSS: "",                // path to additional css file - use an array [] for multiple
			pageTitle: "",              // add title to print page
			removeInline: false,        // remove inline styles from print elements
			removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
			printDelay: 333,            // variable print delay
			header: null,               // prefix to html
			footer: null,               // postfix to html
			base: false,                // preserve the BASE tag or accept a string for the URL
			formValues: true,           // preserve input/form values
			canvas: false,              // copy canvas content
			doctypeString: '<!DOCTYPE html>', // enter a different doctype for older markup
			removeScripts: false,       // remove script tags from print content
			copyTagClasses: false,      // copy classes from the html & body tag
			beforePrintEvent: null,     // callback function for printEvent in iframe
			beforePrint: null,          // function called before iframe is filled
			afterPrint: null            // function called before iframe is removed
		};
	})(jQuery);
	
	
	</script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$('.tablenav.top .actions').append('<button class="button printScrn">Print</button>');
			
			$(".printScrn").click(function (event) {
				event.preventDefault();
				//$('.search-box, .tablenav.top').hide();
				$('#posts-filter').printThis();
			});
			
			$('.cancel-button').click(function(){
				console.log('dsfsdf0');
			});
		});
	</script>
	<?php
	}
}


add_action( 'admin_footer', 'memberships_admin_init' );
function memberships_admin_init() {
	$screen = get_current_screen();
	if ( $screen->post_type == "ywcmbs-membership" ) {
	?>
	<script type="text/javascript">
	/*
	 * printThis v1.15.1
	 * @desc Printing plug-in for jQuery
	 * @author Jason Day
	 *
	 * Resources (based on):
	 * - jPrintArea: http://plugins.jquery.com/project/jPrintArea
	 * - jqPrint: https://github.com/permanenttourist/jquery.jqprint
	 * - Ben Nadal: http://www.bennadel.com/blog/1591-Ask-Ben-Print-Part-Of-A-Web-Page-With-jQuery.htm
	 *
	 * Licensed under the MIT licence:
	 *              http://www.opensource.org/licenses/mit-license.php
	 *
	 * (c) Jason Day 2015-2019
	 *
	 * Usage:
	 *
	 *  $("#mySelector").printThis({
	 *      debug: false,                   // show the iframe for debugging
	 *      importCSS: true,                // import parent page css
	 *      importStyle: false,             // import style tags
	 *      printContainer: true,           // grab outer container as well as the contents of the selector
	 *      loadCSS: "path/to/my.css",      // path to additional css file - use an array [] for multiple
	 *      pageTitle: "",                  // add title to print page
	 *      removeInline: false,            // remove all inline styles from print elements
	 *      removeInlineSelector: "body *", // custom selectors to filter inline styles. removeInline must be true
	 *      printDelay: 333,                // variable print delay
	 *      header: null,                   // prefix to html
	 *      footer: null,                   // postfix to html
	 *      base: false,                    // preserve the BASE tag, or accept a string for the URL
	 *      formValues: true,               // preserve input/form values
	 *      canvas: false,                  // copy canvas elements
	 *      doctypeString: '...',           // enter a different doctype for older markup
	 *      removeScripts: false,           // remove script tags from print content
	 *      copyTagClasses: false           // copy classes from the html & body tag
	 *      beforePrintEvent: null,         // callback function for printEvent in iframe
	 *      beforePrint: null,              // function called before iframe is filled
	 *      afterPrint: null                // function called before iframe is removed
	 *  });
	 *
	 * Notes:
	 *  - the loadCSS will load additional CSS (with or without @media print) into the iframe, adjusting layout
	 */
	;
	(function($) {
	
		function appendContent($el, content) {
			if (!content) return;
	
			// Simple test for a jQuery element
			$el.append(content.jquery ? content.clone() : content);
		}
	
		function appendBody($body, $element, opt) {
			// Clone for safety and convenience
			// Calls clone(withDataAndEvents = true) to copy form values.
			var $content = $element.clone(opt.formValues);
	
			if (opt.formValues) {
				// Copy original select and textarea values to their cloned counterpart
				// Makes up for inability to clone select and textarea values with clone(true)
				copyValues($element, $content, 'select, textarea');
			}
	
			if (opt.removeScripts) {
				$content.find('script').remove();
			}
	
			if (opt.printContainer) {
				// grab $.selector as container
				$content.appendTo($body);
			} else {
				// otherwise just print interior elements of container
				$content.each(function() {
					$(this).children().appendTo($body)
				});
			}
		}
	
		// Copies values from origin to clone for passed in elementSelector
		function copyValues(origin, clone, elementSelector) {
			var $originalElements = origin.find(elementSelector);
	
			clone.find(elementSelector).each(function(index, item) {
				$(item).val($originalElements.eq(index).val());
			});
		}
	
		var opt;
		$.fn.printThis = function(options) {
			opt = $.extend({}, $.fn.printThis.defaults, options);
			var $element = this instanceof jQuery ? this : $(this);
	
			var strFrameName = "printThis-" + (new Date()).getTime();
	
			if (window.location.hostname !== document.domain && navigator.userAgent.match(/msie/i)) {
				// Ugly IE hacks due to IE not inheriting document.domain from parent
				// checks if document.domain is set by comparing the host name against document.domain
				var iframeSrc = "javascript:document.write(\"<head><script>document.domain=\\\"" + document.domain + "\\\";</s" + "cript></head><body></body>\")";
				var printI = document.createElement('iframe');
				printI.name = "printIframe";
				printI.id = strFrameName;
				printI.className = "MSIE";
				document.body.appendChild(printI);
				printI.src = iframeSrc;
	
			} else {
				// other browsers inherit document.domain, and IE works if document.domain is not explicitly set
				var $frame = $("<iframe id='" + strFrameName + "' name='printIframe' />");
				$frame.appendTo("body");
			}
	
			var $iframe = $("#" + strFrameName);
	
			// show frame if in debug mode
			if (!opt.debug) $iframe.css({
				position: "absolute",
				width: "0px",
				height: "0px",
				left: "-600px",
				top: "-600px"
			});
	
			// before print callback
			if (typeof opt.beforePrint === "function") {
				opt.beforePrint();
			}
	
			// $iframe.ready() and $iframe.load were inconsistent between browsers
			setTimeout(function() {
	
				// Add doctype to fix the style difference between printing and render
				function setDocType($iframe, doctype){
					var win, doc;
					win = $iframe.get(0);
					win = win.contentWindow || win.contentDocument || win;
					doc = win.document || win.contentDocument || win;
					doc.open();
					doc.write(doctype);
					doc.close();
				}
	
				if (opt.doctypeString){
					setDocType($iframe, opt.doctypeString);
				}
	
				var $doc = $iframe.contents(),
					$head = $doc.find("head"),
					$body = $doc.find("body"),
					$base = $('base'),
					baseURL;
	
				// add base tag to ensure elements use the parent domain
				if (opt.base === true && $base.length > 0) {
					// take the base tag from the original page
					baseURL = $base.attr('href');
				} else if (typeof opt.base === 'string') {
					// An exact base string is provided
					baseURL = opt.base;
				} else {
					// Use the page URL as the base
					baseURL = document.location.protocol + '//' + document.location.host;
				}
	
				$head.append('<base href="' + baseURL + '">');
	
				// import page stylesheets
				if (opt.importCSS) $("link[rel=stylesheet]").each(function() {
					var href = $(this).attr("href");
					if (href) {
						var media = $(this).attr("media") || "all";
						$head.append("<link type='text/css' rel='stylesheet' href='" + href + "' media='" + media + "'>");
					}
				});
	
				// import style tags
				if (opt.importStyle) $("style").each(function() {
					$head.append(this.outerHTML);
				});
	
				// add title of the page
				if (opt.pageTitle) $head.append("<title>" + opt.pageTitle + "</title>");
	
				// import additional stylesheet(s)
				if (opt.loadCSS) {
					if ($.isArray(opt.loadCSS)) {
						jQuery.each(opt.loadCSS, function(index, value) {
							$head.append("<link type='text/css' rel='stylesheet' href='" + this + "'>");
						});
					} else {
						$head.append("<link type='text/css' rel='stylesheet' href='" + opt.loadCSS + "'>");
					}
				}
	
				var pageHtml = $('html')[0];
	
				// CSS VAR in html tag when dynamic apply e.g.  document.documentElement.style.setProperty("--foo", bar);
				$doc.find('html').prop('style', pageHtml.style.cssText);
	
				// copy 'root' tag classes
				var tag = opt.copyTagClasses;
				if (tag) {
					tag = tag === true ? 'bh' : tag;
					if (tag.indexOf('b') !== -1) {
						$body.addClass($('body')[0].className);
					}
					if (tag.indexOf('h') !== -1) {
						$doc.find('html').addClass(pageHtml.className);
					}
				}
	
				// print header
				appendContent($body, opt.header);
	
				if (opt.canvas) {
					// add canvas data-ids for easy access after cloning.
					var canvasId = 0;
					// .addBack('canvas') adds the top-level element if it is a canvas.
					$element.find('canvas').addBack('canvas').each(function(){
						$(this).attr('data-printthis', canvasId++);
					});
				}
	
				appendBody($body, $element, opt);
	
				if (opt.canvas) {
					// Re-draw new canvases by referencing the originals
					$body.find('canvas').each(function(){
						var cid = $(this).data('printthis'),
							$src = $('[data-printthis="' + cid + '"]');
	
						this.getContext('2d').drawImage($src[0], 0, 0);
	
						// Remove the markup from the original
						if ($.isFunction($.fn.removeAttr)) {
							$src.removeAttr('data-printthis');
						} else {
							$.each($src, function(i, el) {
								el.removeAttribute('data-printthis');
							});
						}
					});
				}
	
				// remove inline styles
				if (opt.removeInline) {
					// Ensure there is a selector, even if it's been mistakenly removed
					var selector = opt.removeInlineSelector || '*';
					// $.removeAttr available jQuery 1.7+
					if ($.isFunction($.removeAttr)) {
						$body.find(selector).removeAttr("style");
					} else {
						$body.find(selector).attr("style", "");
					}
				}
	
				// print "footer"
				appendContent($body, opt.footer);
	
				// attach event handler function to beforePrint event
				function attachOnBeforePrintEvent($iframe, beforePrintHandler) {
					var win = $iframe.get(0);
					win = win.contentWindow || win.contentDocument || win;
	
					if (typeof beforePrintHandler === "function") {
						if ('matchMedia' in win) {
							win.matchMedia('print').addListener(function(mql) {
								if(mql.matches)  beforePrintHandler();
							});
						} else {
							win.onbeforeprint = beforePrintHandler;
						}
					}
				}
				attachOnBeforePrintEvent($iframe, opt.beforePrintEvent);
	
				setTimeout(function() {
					if ($iframe.hasClass("MSIE")) {
						// check if the iframe was created with the ugly hack
						// and perform another ugly hack out of neccessity
						window.frames["printIframe"].focus();
						$head.append("<script>  window.print(); </s" + "cript>");
					} else {
						// proper method
						if (document.queryCommandSupported("print")) {
							$iframe[0].contentWindow.document.execCommand("print", false, null);
						} else {
							$iframe[0].contentWindow.focus();
							$iframe[0].contentWindow.print();
						}
					}
	
					// remove iframe after print
					if (!opt.debug) {
						setTimeout(function() {
							$iframe.remove();
	
						}, 1000);
					}
	
					// after print callback
					if (typeof opt.afterPrint === "function") {
						opt.afterPrint();
					}
	
				}, opt.printDelay);
	
			}, 333);
	
		};
	
		// defaults
		$.fn.printThis.defaults = {
			debug: false,               // show the iframe for debugging
			importCSS: true,            // import parent page css
			importStyle: false,         // import style tags
			printContainer: true,       // print outer container/$.selector
			loadCSS: "",                // path to additional css file - use an array [] for multiple
			pageTitle: "",              // add title to print page
			removeInline: false,        // remove inline styles from print elements
			removeInlineSelector: "*",  // custom selectors to filter inline styles. removeInline must be true
			printDelay: 333,            // variable print delay
			header: null,               // prefix to html
			footer: null,               // postfix to html
			base: false,                // preserve the BASE tag or accept a string for the URL
			formValues: true,           // preserve input/form values
			canvas: false,              // copy canvas content
			doctypeString: '<!DOCTYPE html>', // enter a different doctype for older markup
			removeScripts: false,       // remove script tags from print content
			copyTagClasses: false,      // copy classes from the html & body tag
			beforePrintEvent: null,     // callback function for printEvent in iframe
			beforePrint: null,          // function called before iframe is filled
			afterPrint: null            // function called before iframe is removed
		};
	})(jQuery);
	
	
	</script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$('.tablenav.top .actions').append('<button class="button printScrn">Print</button>');
			
			$(".printScrn").click(function (event) {
				event.preventDefault();
				//$('.search-box, .tablenav.top').hide();
				$('#posts-filter').printThis();
			});
			
			$('.cancel-button').click(function(){
				console.log('dsfsdf0');
			});
		});
	</script>
	
	<?php
	
	}
}

add_action( 'woocommerce_review_order_before_submit', 'gdpr_notice' );
function gdpr_notice() {?>
	<?php $cat_in_cart = false;
	   
	foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
		if ( has_term( 'membership-plan', 'product_cat', $cart_item['product_id'] ) ) {
			$cat_in_cart = true;
			break;
		}
	}
	
	if ( $cat_in_cart ) {?>
		<p class="mandatory-notice gdpr">By completing this purchase you are consenting to the <a href="<?php the_field('gdpr_document', 'options');?>" target="_blank">Swindon Education Trust GDPR Policy</a></p>
	<?php }?>
<?php }

/**
 * Auto Complete all WooCommerce orders.
 

add_filter( 'woocommerce_payment_complete_order_status', 'auto_complete_virtual_orders', 10, 3 );

function auto_complete_virtual_orders( $payment_complete_status, $order_id, $order ) {
$current_status = $order->get_status();
// We only want to update the status to 'completed' if it's coming from one of the following statuses:
$allowed_current_statuses = array( 'on-hold', 'pending', 'failed' );

if ( 'processing' === $payment_complete_status && in_array( $current_status, $allowed_current_statuses ) ) {

$order_items = $order->get_items();

// Create an array of products in the order
$order_products = array_filter( array_map( function( $item ) {
// Get associated product for each line item
return $item->get_product();
}, $order_items ), function( $product ) {
// Remove non-products
return !! $product;
} );

if ( count( $order_products > 0 ) ) {
$payment_complete_status = 'completed';
}
}
return $payment_complete_status;
}

*/

add_action( 'woocommerce_before_calculate_totals', 'silverless_alter_price_cart', 9999, 10 );
function silverless_alter_price_cart( $cart_object ) {
 
	if ( is_admin() && ! defined( 'DOING_AJAX' ) ) return;
 
	if ( did_action( 'woocommerce_before_calculate_totals' ) >= 2 ) return;
 
	$user = wp_get_current_user();
	$roles = ( array ) $user->roles;
	$allowed_roles = array('gp_membership', 'gp_training_membership');
	if( array_intersect($allowed_roles, $user->roles ) ) {
		foreach ( $cart_object->get_cart() as $hash => $value ) {
			if( in_array( 26, $value['data']->get_category_ids() )) {
				$discountprice = $value['data']->get_regular_price() * 0;
				$value['data']->set_price( $discountprice );
			}
		}
	}
}
