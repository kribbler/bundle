<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
?>

<div class="empty_bag">

    <div class="empty_bag_icon"></div>
    <h3 class="empty_bag_message"><?php _e('Your cart is currently empty.', 'woocommerce') ?></h3>
    <a class="empty_bag_button" href="<?php echo get_permalink(woocommerce_get_page_id('shop')); ?>"><?php _e('Return To Shop', 'woocommerce') ?></a>

</div>

<?php do_action('woocommerce_cart_is_empty'); ?>