<?php
/**
 * Edit address form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce, $current_user;

get_currentuserinfo();
?>

<?php $woocommerce->show_messages(); ?>

<?php if (!$load_address) : ?>

	<?php woocommerce_get_template('myaccount/my-address.php'); ?>

<?php else : ?>

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
    
		<h2><?php if ($load_address=='billing') _e('Billing Address', 'woocommerce'); else _e('Shipping Address', 'woocommerce'); ?></h2>
    
        <form action="<?php echo esc_url( add_query_arg( 'address', $load_address, get_permalink( woocommerce_get_page_id('edit_address') ) ) ); ?>" method="post">
    
            <?php
            foreach ($address as $key => $field) :
                $value = (isset($_POST[$key])) ? $_POST[$key] : get_user_meta( get_current_user_id(), $key, true );
    
                // Default values
                if (!$value && ($key=='billing_email' || $key=='shipping_email')) $value = $current_user->user_email;
                if (!$value && ($key=='billing_country' || $key=='shipping_country')) $value = $woocommerce->countries->get_base_country();
                if (!$value && ($key=='billing_state' || $key=='shipping_state')) $value = $woocommerce->countries->get_base_state();
    
                woocommerce_form_field( $key, $field, $value );
            endforeach;
            ?>
            
            <div class="clr"></div>
    
            <div class="gbtr_my_account_button"><input type="submit" class="button" name="save_address" value="<?php _e('Save Address', 'woocommerce'); ?>" /></div>
    
            <?php $woocommerce->nonce_field('edit_address') ?>
            <input type="hidden" name="action" value="edit_address" />
    
        </form>
    
    </div>
    
    <div class="clr"></div>

</div>

<?php endif; ?>