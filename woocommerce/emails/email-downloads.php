<?php
/**
 * Email Downloads.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/email-downloads.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$text_align = is_rtl() ? 'right' : 'left';

?><h2 class="woocommerce-order-downloads__title"><?php esc_html_e( 'Online Course Details', 'woocommerce' ); ?></h2>

<?php foreach( $order->get_items() as $item_id => $item ){
$product_id = $item->get_product_id(); 
$product_name = $item->get_name()
?>

<div class="online-course">
	<h3>Course Title: <?php echo $product_name;?></h3>
	<a href="<?php the_field('online_url', $product_id);?>" class="button">Link to online meeting</a>
	<p>Meeting ID: <?php the_field('online_meeting_id', $product_id);?></p>
	<p>Meeting Password: <?php the_field('online_meeting_password', $product_id);?></p>
</div>

<?php }?>




