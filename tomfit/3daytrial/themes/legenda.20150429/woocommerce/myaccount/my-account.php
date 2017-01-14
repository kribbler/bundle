<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce;
extract(etheme_account_sidebar());
?>

<div class="row-fluid">
	<?php if ($sidebar): ?>
		<div class="span3">
			<?php 

				do_action('etheme_before_account_sidebar');

				if ( has_nav_menu( 'account-menu' ) ) : ?>
					<?php wp_nav_menu(array(
						'theme_location' => 'account-menu',
						'before' => '',
						'after' => '',
						'link_before' => '',
						'container_class' => 'widget_nav_menu',
						'link_after' => '',
						'depth' => 4,
						'fallback_cb' => false
					)); ?>
				<?php else: ?>
					<br>
                    <h4 class="a-center install-menu-info">Set your account menu in <em>Apperance &gt; Menus</em></h4>
				<?php endif;

			?>
		</div>
	<?php endif ?>
	<div class="span<?php echo $span; ?>">
		<?php wc_print_notices(); ?>
		<p class="myaccount_user">
			<?php
			printf(
				__( 'Hello <strong>%1$s</strong> (not %1$s? <a href="%2$s">Sign out</a>).', ETHEME_DOMAIN ) . ' ',
				$current_user->display_name,
				wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) )
			);
		
			printf( __( 'From your account dashboard you can view your recent orders, manage your shipping and billing addresses and <a href="%s">edit your password and account details</a>.', ETHEME_DOMAIN ),
				wc_customer_edit_account_url()
			);
			?>
		</p>
		
		<?php do_action( 'woocommerce_before_my_account' ); ?>
		
		<?php wc_get_template( 'myaccount/my-downloads.php' ); ?>
		
		<?php wc_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>
		
		<?php wc_get_template( 'myaccount/my-address.php' ); ?>
		
		<?php do_action( 'woocommerce_after_my_account' ); ?>
	</div>
</div>