<?php
/**
 * Change password form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce;
?>

<?php $woocommerce->show_messages(); ?>

<div class="gbtr_my_account_wrapper">

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
    
    <div class="grid_8 omega">

        <h2><?php _e('Change password', 'theretailer'); ?></h2>
        
        <form action="<?php echo esc_url( get_permalink(woocommerce_get_page_id('change_password')) ); ?>" method="post">
        
            <p class="form-row form-row-first">
                <label for="password_1"><?php _e('New password', 'woocommerce'); ?> <span class="required">*</span></label>
                <input type="password" class="input-text" name="password_1" id="password_1" />
            </p>
            <p class="form-row form-row-last">
                <label for="password_2"><?php _e('Re-enter new password', 'woocommerce'); ?> <span class="required">*</span></label>
                <input type="password" class="input-text" name="password_2" id="password_2" />
            </p>
            
            <div class="clr"></div>
        
            <div class="gbtr_my_account_button"><input type="submit" class="button" name="change_password" value="<?php _e('Save', 'woocommerce'); ?>" /></div>

            <?php $woocommerce->nonce_field('change_password')?>
            <input type="hidden" name="action" value="change_password" />
        
        </form>
    
	</div>
    
    <div class="clr"></div>

</div>