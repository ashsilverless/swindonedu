<?php get_header();
/**
 * Default Page Template
 *
 * @package swindonedu
 */
?>
<?php if ( have_posts() ) :?>
<?php woocommerce_content(); ?>
<?php endif; ?>
<?php get_footer();?>
