<?php
/**
 * External product add to cart
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
 
global $theretailer_theme_options;
 
?>

<?php if ( (!$theretailer_theme_options['catalog_mode']) || ($theretailer_theme_options['catalog_mode'] == 0) ) { ?>

<?php do_action('woocommerce_before_add_to_cart_button'); ?>

<p class="cart"><a href="<?php echo $product_url; ?>" rel="nofollow" class="single_add_to_cart_button button alt"><?php echo apply_filters('single_add_to_cart_text', $button_text, 'external'); ?></a></p>

<?php do_action('woocommerce_after_add_to_cart_button'); ?>

<?php } ?>