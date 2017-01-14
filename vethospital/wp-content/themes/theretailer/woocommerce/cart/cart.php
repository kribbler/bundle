<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce;
?>

<em class="items_found_cart"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> found</em>

<hr />

<?php $woocommerce->show_messages(); ?>

<div class="gbtr_main_wrapper">

    <?php do_action( 'woocommerce_before_cart_table' ); ?>
    
    <div class="grid_8 alpha">
    
    <form action="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" method="post">
    
        <div class="shop_table_wrapper">
            
            <table class="shop_table footable" cellspacing="0">
                <thead>
                    <tr>
                        <th class="product-remove">&nbsp;</th>
                        <th data-hide="phone" class="product-thumbnail">&nbsp;</th>
                        <th class="product-name"><?php _e('Item', 'theretailer'); ?></th>
                        <th data-hide="phone" class="product-quantity"><?php _e('Quantity', 'woocommerce'); ?></th>
                        <th class="product-subtotal"><?php _e('Total', 'woocommerce'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    
                    <?php do_action( 'woocommerce_before_cart_contents' ); ?>
            
                    <?php
                    if ( sizeof( $woocommerce->cart->get_cart() ) > 0 ) {
                        foreach ( $woocommerce->cart->get_cart() as $cart_item_key => $values ) {
                            $_product = $values['data'];
                            if ( $_product->exists() && $values['quantity'] > 0 ) {
                                ?>
                                <tr class = "<?php echo esc_attr( apply_filters('woocommerce_cart_table_item_class', 'cart_table_item', $values, $cart_item_key ) ); ?>">
                                    <!-- Remove from cart link -->
                                    <td class="product-remove">
                                        <?php
                                            echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf('<a href="%s" class="remove" title="%s">&times;</a>', esc_url( $woocommerce->cart->get_remove_url( $cart_item_key ) ), __('Remove this item', 'woocommerce') ), $cart_item_key );
                                        ?>
                                    </td>
            
                                    <!-- The thumbnail -->
                                    <td class="product-thumbnail">
                                        <?php
                                            $thumbnail = apply_filters( 'woocommerce_in_cart_product_thumbnail', $_product->get_image(), $values, $cart_item_key );
                                            printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), $thumbnail );
                                        ?>
                                    </td>
            
                                    <!-- Product Name -->
                                    <td class="product-name">
                                        <?php
											
											if ( ! $_product->is_visible() || ( $_product instanceof WC_Product_Variation && ! $_product->parent_is_visible() ) )
                                                echo apply_filters( 'woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key );
                                            else
                                                printf('<a href="%s">%s</a>', esc_url( get_permalink( apply_filters('woocommerce_in_cart_product_id', $values['product_id'] ) ) ), apply_filters('woocommerce_in_cart_product_title', $_product->get_title(), $values, $cart_item_key ) );
											
											// Meta data
                                            echo $woocommerce->cart->get_item_data( $values );
            
                                            // Backorder notification
                                            if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $values['quantity'] ) )
                                                echo '<p class="backorder_notification">' . __('Available on backorder', 'woocommerce') . '</p>';
                                        ?>
                                        
                                        <div class="product-price">
										<?php
                                            $product_price = get_option('woocommerce_display_cart_prices_excluding_tax') == 'yes' || $woocommerce->customer->is_vat_exempt() ? $_product->get_price_excluding_tax() : $_product->get_price();
            
                                            echo apply_filters('woocommerce_cart_item_price_html', woocommerce_price( $product_price ), $values, $cart_item_key );
                                        ?>
                                        </div>
                                    </td>
            
                                    <!-- Quantity inputs -->
                                    <td class="product-quantity">
                                        <?php
                                            if ( $_product->is_sold_individually() ) {
                                                $product_quantity = '1';
                                            } else {
                                                $data_min = apply_filters( 'woocommerce_cart_item_data_min', '', $_product );
                                                $data_max = ( $_product->backorders_allowed() ) ? '' : $_product->get_stock_quantity();
                                                $data_max = apply_filters( 'woocommerce_cart_item_data_max', $data_max, $_product );
            
                                                $product_quantity = sprintf( '<div class="quantity"><input name="cart[%s][qty]" data-min="%s" data-max="%s" value="%s" size="4" title="Qty" class="input-text qty text" maxlength="12" /></div>', $cart_item_key, $data_min, $data_max, esc_attr( $values['quantity'] ) );
                                            }
            
                                            echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
                                        ?>
                                    </td>
            
                                    <!-- Product subtotal -->
                                    <td class="product-subtotal">
                                        <?php
                                            echo apply_filters( 'woocommerce_cart_item_subtotal', $woocommerce->cart->get_product_subtotal( $_product, $values['quantity'] ), $values, $cart_item_key );
                                        ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    }
            
                    do_action( 'woocommerce_cart_contents' );
                    
                    ?>
            
                    <?php do_action( 'woocommerce_after_cart_contents' ); ?>
                    
                </tbody>
            </table>
        
        </div>
    
    </div>
    
    <div class="grid_4 omega">
    
        <div class="gbtr_left_column_cart">            
            
            
            <?php if ( $woocommerce->cart->coupons_enabled() ) { ?>
                <div class="coupon">

                    <h3><?php _e('Have a coupon?', 'theretailer'); ?></h3>
                    <div class="coupon_inputs_wrapper">
                        <input name="coupon_code" class="input-text" id="coupon_code" placeholder="<?php _e('Enter coupon code', 'theretailer'); ?>" value="" />
                        <input type="submit" class="button button-coupon" name="apply_coupon" value="<?php _e('Apply', 'theretailer'); ?>" />
                    </div>
    
                    <?php do_action('woocommerce_cart_coupon'); ?>
                    
                    <div class="clr"></div>

                </div>
            <?php } ?>
            
            
        
            <?php woocommerce_cart_totals(); ?>
            
            <div class="gbtr_left_column_cart_sep"></div>
            
            <input type="submit" class="update-button button" name="update_cart" value="<?php _e('Update Shopping Bag', 'theretailer'); ?>" />
                        
            <input type="submit" class="checkout-button button" name="proceed" value="<?php _e('Proceed to Checkout', 'woocommerce'); ?>" />
    
            <?php do_action('woocommerce_proceed_to_checkout'); ?>
    
            <?php $woocommerce->nonce_field('cart') ?>  
        
        </div>
    
    </form>
    
    </div>
    
    <div class="grid_12 alpha"><br /><br /><div class="hr"></div></div>
    
    <div class="grid_12 alpha">
        <div class="gbtr_left_column_cart_shipping_wrapper">        
            <div class="gbtr_left_column_cart_shipping">
				<?php woocommerce_shipping_calculator(); ?>
            </div>    
    	</div>
    </div>
    
    <?php do_action( 'woocommerce_after_cart_table' ); ?>
    
    <div class="clr"></div>
    
    <?php do_action('woocommerce_cart_collaterals'); ?>
    
    <div class="clr"></div>

<div>