<?php
/**
 * My Account page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce;
?>

<p class="myaccount_user"><?php printf( __('<span>Hello %s.</span>From your account dashboard you can view your recent orders, manage your shipping and billing addresses and <a href="%s">change your password</a>.', 'theretailer'), $current_user->display_name, get_permalink(woocommerce_get_page_id('change_password'))); ?></p>

<?php $woocommerce->show_messages(); ?>

<div class="gbtr_my_account_wrapper_parent">

    <div class="gbtr_my_account_wrapper">
    
        <div class="grid_4 alpha">
            
            <div class="gbtr_left_column_my_account">
            
                    <ul class="menu_my_account">
                        <?php if ( has_nav_menu( 'my_account' ) ) : ?>
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
                        <?php else: ?>
                            Define your account navigation.
                        <?php endif; ?>
                    </ul>
            
            </div>
        
        </div>
        
        <div class="grid_8 alpha omega">
        
            <?php do_action('woocommerce_before_my_account'); ?>
            
            <?php if ($downloads = $woocommerce->customer->get_downloadable_products()) : ?>
            <div class="grid_8 omega">
                <h2><?php _e('Available downloads', 'woocommerce'); ?></h2>
                <ul class="digital-downloads">
                    <?php foreach ($downloads as $download) : ?>
                        <li><?php if (is_numeric($download['downloads_remaining'])) : ?><span class="count"><?php echo $download['downloads_remaining'] . _n('&nbsp;download remaining', '&nbsp;downloads remaining', $download['downloads_remaining'], 'woocommerce'); ?></span><?php endif; ?> <a href="<?php echo esc_url( $download['download_url'] ); ?>"><?php echo $download['download_name']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <?php if ( version_compare( WOOCOMMERCE_VERSION, "2.0.0" ) >= 0 ) { // WC 2.0 ?>
            
            	<?php woocommerce_get_template( 'myaccount/my-orders.php', array( 'order_count' => $order_count ) ); ?>
			
			<?php } else { ?>
            
            	<?php woocommerce_get_template('myaccount/my-orders.php', array( 'recent_orders' => $recent_orders )); ?>
				
			<?php } ?> 
            
            <?php woocommerce_get_template('myaccount/my-address.php'); ?>
            
            <?php
            do_action('woocommerce_after_my_account');
            ?>
        
        </div>
        
        <div class="clr"></div>
    
    </div>

</div>