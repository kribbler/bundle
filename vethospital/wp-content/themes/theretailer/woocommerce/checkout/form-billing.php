<?php
/**
 * Checkout billing information form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce;
?>


<?php if (is_user_logged_in() || get_option('woocommerce_enable_signup_and_login_from_checkout')=="no") : ?>

<script type='text/javascript'>
//<![CDATA[ 

jQuery(document).ready(function($) {	
	$('.gbtr_billing_address_content').show();
	$('.gbtr_billing_address_header').removeClass('gbtr_checkout_header_nonactive');
});

//]]>  
</script>

<?php endif; ?>

<?php if (!is_user_logged_in() && get_option('woocommerce_enable_signup_and_login_from_checkout')=="yes") : ?>
    
	<div class="gbtr_create_account_block">
    
        <h3 class="gbtr_create_account_header accordion_header"><?php _e('Create an account', 'theretailer'); ?></h3>
        
        <?php if (get_option('woocommerce_enable_guest_checkout')=='yes') : ?>
            
            <p id="createaccount_wrapper" class="form-row">
                <input class="input-checkbox" id="createaccount" <?php checked($checkout->get_value('createaccount'), true) ?> type="checkbox" name="createaccount" value="1" /> 
                <label for="createaccount" class="checkbox"><?php _e('Create an account?', 'woocommerce'); ?></label>
            </p>
    
        <?php endif; ?>
    
        <?php do_action( 'woocommerce_before_checkout_registration_form', $checkout ); ?>
    
        <div class="create-account gbtr_create_account_content accordion_content">
    
            <p><?php _e('Create an account by entering the information below. If you are a returning customer please login at the top of the page.', 'woocommerce'); ?></p>
    
            <?php foreach ($checkout->checkout_fields['account'] as $key => $field) : ?>
    
                <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
    
            <?php endforeach; ?>
            
            <div class="clr"></div>
            
            <input type="button" class="button_create_account_continue button" name="button_create_account_continue" value="<?php _e('Continue &raquo;', 'theretailer'); ?>" />
            
            <div class="clr"></div>
    
        </div>
    
        <?php do_action( 'woocommerce_after_checkout_registration_form', $checkout ); ?>
    
    </div>

<?php endif; ?>



<?php if ( $woocommerce->cart->ship_to_billing_address_only() && $woocommerce->cart->needs_shipping() ) : ?>

	<h3 class="gbtr_billing_address_header accordion_header"><?php _e('Billing &amp; Shipping', 'woocommerce'); ?></h3>

<?php else : ?>

	<h3 class="gbtr_billing_address_header accordion_header"><?php _e('Billing Address', 'woocommerce'); ?></h3>

<?php endif; ?>

<div class="gbtr_billing_address_content accordion_content">

	<?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>
    
    <?php foreach ($checkout->checkout_fields['billing'] as $key => $field) : ?>
    
        <?php woocommerce_form_field( $key, $field, $checkout->get_value( $key ) ); ?>
    
    <?php endforeach; ?>
    
    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
    
    <div class="clr"></div>
            
    <input type="button" class="button_billing_address_continue button" name="button_create_account_continue" value="<?php _e('Continue &raquo;', 'theretailer'); ?>" />
    
    <div class="clr"></div>

</div>