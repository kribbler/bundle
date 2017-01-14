<?php
/**
 * My Addresses
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce;

$customer_id = get_current_user_id();
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

		<h2><?php _e('My Address', 'woocommerce'); ?></h2>
        <p class="myaccount_address"><?php _e('The following addresses will be used on the checkout page by default.', 'woocommerce'); ?></p>
		
		<?php if (get_option('woocommerce_ship_to_billing_address_only')=='no') : ?>
        
            <div class="col2-set addresses">
        
                <div class="col-1">
        
        <?php endif; ?>
        
                    <header class="title">
                        <h3><?php _e('Billing Address', 'woocommerce'); ?></h3>
                    </header>
                    <div class="small_sep"></div>
                    <br />
                    <address>
                        <?php
                            $address = array(
                                'first_name' 	=> get_user_meta( $customer_id, 'billing_first_name', true ),
                                'last_name'		=> get_user_meta( $customer_id, 'billing_last_name', true ),
                                'company'		=> get_user_meta( $customer_id, 'billing_company', true ),
                                'address_1'		=> get_user_meta( $customer_id, 'billing_address_1', true ),
                                'address_2'		=> get_user_meta( $customer_id, 'billing_address_2', true ),
                                'city'			=> get_user_meta( $customer_id, 'billing_city', true ),
                                'state'			=> get_user_meta( $customer_id, 'billing_state', true ),
                                'postcode'		=> get_user_meta( $customer_id, 'billing_postcode', true ),
                                'country'		=> get_user_meta( $customer_id, 'billing_country', true )
                            );
        
                            $formatted_address = $woocommerce->countries->get_formatted_address( $address );
        
                            if (!$formatted_address) _e('You have not set up a billing address yet.', 'woocommerce'); else echo $formatted_address;
                        ?>
                    </address>
                    <br />
                    
                    <a href="<?php echo esc_url( add_query_arg('address', 'billing', get_permalink(woocommerce_get_page_id('edit_address'))) ); ?>" class="edit"><?php _e('Edit', 'woocommerce'); ?></a>
        
        
        <?php if (get_option('woocommerce_ship_to_billing_address_only')=='no') : ?>
        
                </div><!-- /.col-1 -->
        
                <div class="col-2">
        
                    <header class="title">
                        <h3><?php _e('Shipping Address', 'woocommerce'); ?></h3>
                    </header>
                    <div class="small_sep"></div>
                    <br />
                    <address>
                        <?php
                            $address = array(
                                'first_name' 	=> get_user_meta( $customer_id, 'shipping_first_name', true ),
                                'last_name'		=> get_user_meta( $customer_id, 'shipping_last_name', true ),
                                'company'		=> get_user_meta( $customer_id, 'shipping_company', true ),
                                'address_1'		=> get_user_meta( $customer_id, 'shipping_address_1', true ),
                                'address_2'		=> get_user_meta( $customer_id, 'shipping_address_2', true ),
                                'city'			=> get_user_meta( $customer_id, 'shipping_city', true ),
                                'state'			=> get_user_meta( $customer_id, 'shipping_state', true ),
                                'postcode'		=> get_user_meta( $customer_id, 'shipping_postcode', true ),
                                'country'		=> get_user_meta( $customer_id, 'shipping_country', true )
                            );
        
                            $formatted_address = $woocommerce->countries->get_formatted_address( $address );
        
                            if (!$formatted_address) _e('You have not set up a shipping address yet.', 'woocommerce'); else echo $formatted_address;
                        ?>
                    </address>
                    <br />
                    
                    <a href="<?php echo esc_url( add_query_arg('address', 'shipping', get_permalink(woocommerce_get_page_id('edit_address'))) ); ?>" class="edit"><?php _e('Edit', 'woocommerce'); ?></a>
        
                </div><!-- /.col-2 -->
        
            </div><!-- /.col2-set -->
        
        <?php endif; ?>

	</div>
    
    <div class="clr"></div>

</div>