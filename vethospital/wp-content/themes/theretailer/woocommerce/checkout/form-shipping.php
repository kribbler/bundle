<?php
/**
 * Checkout shipping information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce;
?>

<?php if ( ( $woocommerce->cart->needs_shipping() || get_option('woocommerce_require_shipping_address') == 'yes' ) && ! $woocommerce->cart->ship_to_billing_address_only() ) : ?>

	<?php
		if ( empty( $_POST ) ) :

			$shiptobilling = (get_option('woocommerce_ship_to_same_address')=='yes') ? 1 : 0;
			$shiptobilling = apply_filters('woocommerce_shiptobilling_default', $shiptobilling);

		else :

			$shiptobilling = $checkout->get_value('shiptobilling');

		endif;
	?>

	<h3 class="gbtr_shipping_address_header accordion_header"><?php _e('Shipping Address', 'woocommerce'); ?></h3>
    
    <div class="gbtr_shipping_address_content accordion_content">
    
        <p class="form-row" id="shiptobilling">
            <input id="shiptobilling-checkbox" class="input-checkbox" <?php checked($shiptobilling, 1); ?> type="checkbox" name="shiptobilling" value="1" />
            <label for="shiptobilling-checkbox" class="checkbox"><?php _e('Ship to billing address?', 'woocommerce'); ?></label>
        </p>
    
        <div class="shipping_address">
    
            <?php do_action('woocommerce_before_checkout_shipping_form', $checkout); ?>
    
            <?php foreach ($checkout->checkout_fields['shipping'] as $key => $field) : ?>
    
                <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
    
            <?php endforeach; ?>
    
            <?php do_action('woocommerce_after_checkout_shipping_form', $checkout); ?>
    
        </div>
        
    </div>
    
<?php endif; ?>

<?php do_action('woocommerce_before_order_notes', $checkout); ?>

<?php if (get_option('woocommerce_enable_order_comments')!='no') : ?>

	<?php if ($woocommerce->cart->ship_to_billing_address_only()) : ?>

		<h3 class="gbtr_additional_information_header accordion_header"><?php _e('Additional Information', 'woocommerce'); ?></h3>

	<?php endif; ?>
    
    <div class="gbtr_order_notes_content accordion_content">

		<?php foreach ($checkout->checkout_fields['order'] as $key => $field) : ?>
    
            <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
    
        <?php endforeach; ?>
        
        <div class="clr"></div>
            
        <input type="button" class="button_shipping_address_continue button" name="button_create_account_continue" value="<?php _e('Continue &raquo;', 'theretailer'); ?>" />
        
        <div class="clr"></div>
    
    </div>

<?php endif; ?>

<?php do_action('woocommerce_after_order_notes', $checkout); ?>