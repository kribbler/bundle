<?php
/**
 * Checkout coupon form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

if ( ! WC()->cart->coupons_enabled() )
	return;

$info_message = apply_filters('woocommerce_checkout_coupon_message', __( 'Have a coupon?', ETHEME_DOMAIN ));
?>

<p><?php echo $info_message; ?> <a href="#" class="showcoupon"><?php _e( 'Click here to enter your code', ETHEME_DOMAIN ); ?></a></p>

<form class="checkout_coupon" method="post" style="display:none">

	<input type="text" name="coupon_code" class="input-text" placeholder="<?php _e( 'Coupon code', ETHEME_DOMAIN ); ?>" id="coupon_code" value="" />
	<input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', ETHEME_DOMAIN ); ?>" />
	<div class="clear"></div>
</form>