<?php
/**
 * My Orders
 *
 * Shows recent orders on the account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce;

$customer_id = get_current_user_id();

?>

<?php if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) { // WC 2.0 ?>
            
	<?php $order_count_temp = $order_count; ?>

<?php } else { ?>

    <?php $order_count_temp = $recent_orders; ?>
    
<?php } ?>

<?php
$args = array(
    'numberposts'     => $order_count_temp,
    'meta_key'        => '_customer_user',
    'meta_value'	  => $customer_id,
    'post_type'       => 'shop_order',
    'post_status'     => 'publish'
);
$customer_orders = get_posts($args);
?>

<div class="gbtr_my_account_wrapper">

    <div class="gbtr_left_column_my_account_parent">    
    <div class="grid_4 alpha">

        <div class="gbtr_left_column_my_account">
        
                <ul class="menu_my_account">
                    <?php  
                    wp_nav_menu(array(
                        'theme_location' => 'my_account',
                        'container' =>false,
                        'menu_class' => '',
                        'echo' => true,
                        'items_wrap'      => '%3$s',
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'depth' => 0,
                    ));
                    ?>
                </ul>
        
        </div>
    
    </div>
    </div>
    
    <div class="grid_8 omega">
    
		<h2><?php _e('Recent Orders', 'woocommerce'); ?></h2>
		
		<?php
        if ($customer_orders) :
        ?>
            <table class="shop_table my_account_orders footable">
        
                <thead>
                    <tr>
                        <th class="order-number"><span class="nobr"><?php _e('Order', 'woocommerce'); ?></span></th>
                        <th data-hide="phone" class="order-shipto"><span class="nobr"><?php _e('Ship to', 'woocommerce'); ?></span></th>
                        <th class="order-total"><span class="nobr"><?php _e('Total', 'woocommerce'); ?></span></th>
                        <th data-hide="phone" class="order-status"><span class="nobr"><?php _e('Status', 'woocommerce'); ?></span></th>
                        <th class="order-details"><span class="nobr"><?php _e('Details', 'theretailer'); ?></span></th>
                    </tr>
                </thead>
        
                <tbody><?php
                    foreach ($customer_orders as $customer_order) :
                        $order = new WC_Order();
        
                        $order->populate( $customer_order );
        
                        $status = get_term_by('slug', $order->status, 'shop_order_status');
        
                        ?><tr class="order">
                            <td class="order-number">
                                <a href="<?php echo esc_url( add_query_arg('order', $order->id, get_permalink(woocommerce_get_page_id('view_order'))) ); ?>"><?php echo $order->get_order_number(); ?></a><br /><time title="<?php echo esc_attr( strtotime($order->order_date) ); ?>"><?php echo date_i18n(get_option('date_format'), strtotime($order->order_date)); ?></time>
                            </td>
                            <td class="order-shipto"><address><?php if ($order->get_formatted_shipping_address()) echo $order->get_formatted_shipping_address(); else echo '&ndash;'; ?></address></td>
                            <td class="order-total"><?php echo $order->get_formatted_order_total(); ?></td>
                            <td class="order-status">
                                <?php echo ucfirst( __( $status->name, 'woocommerce' ) ); ?>
                                <?php if (in_array($order->status, array('pending', 'failed'))) : ?>
                                    <a href="<?php echo esc_url( $order->get_cancel_order_url() ); ?>" class="cancel" title="<?php _e('Click to cancel this order', 'woocommerce'); ?>">(<?php _e('Cancel', 'woocommerce'); ?>)</a>
                                <?php endif; ?>
                            </td>
                            <td class="order-actions">
        
                                <?php if (in_array($order->status, array('pending', 'failed'))) : ?>
                                    <a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>"><?php _e('Pay', 'woocommerce'); ?></a>
                                <?php endif; ?>
        
                                <a href="<?php echo esc_url( add_query_arg('order', $order->id, get_permalink(woocommerce_get_page_id('view_order'))) ); ?>"><?php _e('View', 'woocommerce'); ?></a>
        
        
                            </td>
                        </tr><?php
                    endforeach;
                ?></tbody>
        
            </table>
        <?php
        else :
        ?>
            <p class="gbtr_no_recent_orders"><?php _e('You have no recent orders.', 'woocommerce'); ?></p>
        <?php
        endif;
        ?>

	</div>
    
    <div class="clr"></div>

</div>
