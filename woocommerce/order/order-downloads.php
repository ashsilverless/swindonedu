<?php
/**
 * Order Downloads.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/order/order-downloads.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<section class="woocommerce-order-downloads">
	<?php if ( isset( $show_title ) ) : ?>
		<h2 class="woocommerce-order-downloads__title"><?php esc_html_e( 'Online Course Details', 'woocommerce' ); ?></h2>
	<?php endif; ?>

<?php 
$order_id = get_query_var('view-order');
$order = wc_get_order( $order_id );
foreach( $order->get_items() as $item_id => $item ){
	//Get the product ID
	$product_id = $item->get_product_id();
	$product_name = $item->get_name()?>
	<div class="online-course">
		<h3 class="heading heading__5">Course Title: <?php echo $product_name;?></h3>
		<?php the_field('synopsis', $product_id);?>
		<a href="<?php the_field('online_url', $product_id);?>" class="button">Link to online meeting</a>
		<p>Meeting ID: <?php the_field('online_meeting_id', $product_id);?></p>
		<p>Meeting Password: <?php the_field('online_meeting_password', $product_id);?></p>
		<div class="additional-items">
			
			<div>
				<a href="<?php the_field('course_notes', $product_id);?>" class="button">Course Notes</a>
			</div>
			<?php the_field('additional_notes', $product_id);?>
		</div>
	</div>
<?php }?>

</section>