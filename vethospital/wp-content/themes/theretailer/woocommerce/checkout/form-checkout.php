<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce; $woocommerce_checkout = $woocommerce->checkout();
?>

<?php $woocommerce->show_messages(); ?>

<?php //do_action('woocommerce_before_checkout_form'); ?>

<div class="hr"></div>

<?php if (!is_user_logged_in() && get_option('woocommerce_enable_signup_and_login_from_checkout')=="yes") : ?>

    <h3 class="gbtr_checkout_method_header accordion_header"><?php _e('Checkout method', 'theretailer'); ?></h3>
    
    <div class="gbtr_checkout_method_content accordion_content">
        
        <div class="first_col">
        	<div class="title"><?php _e('Returning customers', 'theretailer'); ?></div>
            <?php
			woocommerce_get_template('checkout/form-login-checkout.php', array(
				'message' => __('', 'woocommerce'),
				'redirect' => get_permalink(woocommerce_get_page_id('checkout'))
			));
			?>
        </div>
        
        <div class="sec_col">
        	<div class="title"><?php _e('New customers', 'theretailer'); ?></div>
            <div id="checkout_method_radio_guest_wrapper"><input name="checkout_method_radio" id="checkout_method_radio_guest" type="radio" value="guest" /><label for="checkout_method_radio_guest"><?php _e('Checkout as Guest', 'theretailer'); ?></label></div>
            <div id="checkout_method_radio_account_wrapper"><input name="checkout_method_radio" id="checkout_method_radio_account" type="radio" value="account" /><label for="checkout_method_radio_account"><?php _e('Create an Account with Us', 'theretailer'); ?></label></div>
            <input type="button" class="button_checkout_method_continue button" name="button_checkout_method_continue" value="<?php _e('Continue &raquo;', 'theretailer'); ?>" />
        </div>
        
        <div class="clr"></div>
    
    </div>

<?php endif; ?>

<?php
// If checkout registration is disabled and not logged in, the user cannot checkout
if (get_option('woocommerce_enable_signup_and_login_from_checkout')=="no" && get_option('woocommerce_enable_guest_checkout')=="no" && !is_user_logged_in()) :
	echo apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce'));
	return;
endif;

// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', $woocommerce->cart->get_checkout_url() ); ?>

<form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">

	
	
	<?php if ( sizeof( $woocommerce_checkout->checkout_fields ) > 0 ) : ?>

		<?php do_action( 'woocommerce_checkout_before_customer_details'); ?>

        <div>

            <?php do_action('woocommerce_checkout_billing'); ?>

        </div>

        <div>

            <?php do_action('woocommerce_checkout_shipping'); ?>

        </div>

		<?php do_action( 'woocommerce_checkout_after_customer_details'); ?>

	<?php endif; ?>

	<?php do_action('woocommerce_checkout_order_review'); ?>

</form>

<?php do_action('woocommerce_after_checkout_form'); ?>