<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;

wc_print_notices();

do_action( 'woocommerce_before_cart' ); ?>
<div class="row-fluid">
	<div class="span8 cart-table-section">

<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

<?php do_action( 'woocommerce_before_cart_table' ); ?>

<table class="shop_table table cart" cellspacing="0">
	<thead>
		<tr>
			<th class="product-thumbnail hidden-phone a-center">&nbsp;</th>
			<th class="product-name"><?php _e( 'Product', ETHEME_DOMAIN ); ?></th>
			<th class="product-price a-center"><?php _e( 'Price', ETHEME_DOMAIN ); ?></th>
			<th class="product-quantity hidden-phone a-center"><?php _e( 'Quantity', ETHEME_DOMAIN ); ?></th>
			<th class="product-subtotal a-center"><?php _e( 'Total', ETHEME_DOMAIN ); ?></th>
			<th class="product-remove">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				?>
				<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">

					<td class="product-thumbnail hidden-phone a-center">
						<?php
							$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );

							if ( ! $_product->is_visible() )
								echo $thumbnail;
							else
								printf( '<a href="%s">%s</a>', $_product->get_permalink(), $thumbnail );
						?>
					</td>

					<td class="product-name">
						<?php
							if ( ! $_product->is_visible() )
								echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
							else
								echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', $_product->get_permalink(), $_product->get_title() ), $cart_item, $cart_item_key );

							// Meta data
							echo WC()->cart->get_item_data( $cart_item );

               				// Backorder notification
               				if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) )
               					echo '<p class="backorder_notification">' . __( 'Available on backorder', ETHEME_DOMAIN ) . '</p>';
						?>
					</td>

					<td class="product-price a-center">
						<?php
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-quantity hidden-phone a-center">
						<?php
							if ( $_product->is_sold_individually() ) {
								$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
							} else {
								$product_quantity = woocommerce_quantity_input( array(
									'input_name'  => "cart[{$cart_item_key}][qty]",
									'input_value' => $cart_item['quantity'],
									'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
								), $_product, false );
							}

							echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
						?>
					</td>

					<td class="product-subtotal a-center">
						<?php
							echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
						?>
					</td>

					<td class="product-remove">
						<?php
							echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf( '<a href="%s" class="remove" title="%s">&times;</a>', esc_url( WC()->cart->get_remove_url( $cart_item_key ) ), __( 'Remove this item', ETHEME_DOMAIN ) ), $cart_item_key );
						?>
					</td>
				</tr>
				<?php
			}
		}

		do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<input type="submit" class="button" name="update_cart" value="<?php _e( 'Update Cart', ETHEME_DOMAIN ); ?>" /> 
				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
	</tbody>
</table>

<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>
		<div class="row-fluid cart-options-row">
			<div class="span5">
				<?php if ( WC()->cart->coupons_enabled() ) { ?>
					<form class="checkout_coupon" method="post">
						<div class="coupon">
	
							<?php wp_nonce_field( 'woocommerce-coupon' ); ?>
							<label for="coupon_code"><?php _e( 'Coupon', ETHEME_DOMAIN ); ?>:</label> <input name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php _e( 'Coupon code', ETHEME_DOMAIN ); ?>" /> <input type="submit" class="button" name="apply_coupon" value="<?php _e( 'Apply Coupon', ETHEME_DOMAIN ); ?>" />
	
							<?php do_action('woocommerce_cart_coupon'); ?>
	
						</div>
					</form>
				<?php } ?>
				</form>
			</div>
			<div class="span7">
				<?php woocommerce_shipping_calculator(); ?>
			</div>
		</div>
	</div>
	<div class="span4 cart-totals-section">
		<div class="cart-totals-block">

		
			<?php woocommerce_cart_totals(); ?>
			<a href="<?php echo esc_url( $woocommerce->cart->get_checkout_url() ); ?>" class="fl-r arrow-right checkout-button button big"><span><?php _e('Proceed to Checkout', ETHEME_DOMAIN); ?></span></a>  
			<?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
			<div class="clear"></div>
		</div>
		<?php dynamic_sidebar('cart-sidebar'); ?>
	</div>
</div>

<?php do_action( 'woocommerce_cart_collaterals' ); ?>

<?php do_action( 'woocommerce_after_cart' ); ?>