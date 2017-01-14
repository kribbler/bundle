<?php

if(!function_exists('chhild_etheme_register_menus')) {
    function child_etheme_register_menus() {
        register_nav_menus(array(
            'footer-menu' => __('Footer menu', ETHEME_DOMAIN)
        ));
    }
}

add_action('init', 'child_etheme_register_menus');



if(!function_exists('child_etheme_bottom_links')) {
    function child_etheme_bottom_links() {
        ?>
            <ul class="links">
                <?php  if ( has_nav_menu( 'footer-menu' ) ) : ?>
                    <?php wp_nav_menu(array(
                        'theme_location' => 'footer-menu',
                        'before' => '',
                        'after' => '',
                        'link_before' => '',
                        'link_after' => '',
                        'depth' => 4,
                        'fallback_cb' => false
                    )); ?>
                <?php endif; ?>
            </ul>
        <?php
    }
}


if(!function_exists('child_etheme_top_links')) {
    function child_etheme_top_links() {
        ?>
            <ul class="links">
                <?php if ( is_user_logged_in() ) : ?>
                    <?php if(class_exists('Woocommerce')): ?> <li class="my-account-link"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php _e( 'Your Account', ETHEME_DOMAIN ); ?></a>
                    <div class="submenu-dropdown">
                        <?php  if ( has_nav_menu( 'account-menu' ) ) : ?>
                            <?php wp_nav_menu(array(
                                'theme_location' => 'account-menu',
                                'before' => '',
                                'after' => '',
                                'link_before' => '',
                                'link_after' => '',
                                'depth' => 4,
                                'fallback_cb' => false
                            )); ?>
                        <?php else: ?>
		                    <h4 class="a-center install-menu-info">Set your account menu in <em>Apperance &gt; Menus</em></h4>
                        <?php endif; ?>
                    </div>
                </li><?php endif; ?>
                        <li class="logout-link"><a href="<?php echo wp_logout_url(home_url()); ?>"><?php _e( 'Logout', ETHEME_DOMAIN ); ?></a></li>
                <?php else : ?>
                    <?php 
                        $reg_id = etheme_tpl2id('et-registration.php'); 
                        $reg_url = get_permalink($reg_id);
                    ?>    
                    <?php if(class_exists('Woocommerce')): ?><li class="login-link"><a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><?php _e( 'Sign In', ETHEME_DOMAIN ); ?></a></li><?php endif; ?>
                    <?php if(!empty($reg_id)): ?><li class="register-link"><a href="<?php echo $reg_url; ?>"><?php _e( 'Register', ETHEME_DOMAIN ); ?></a></li><?php endif; ?>
                <?php endif; ?>
            </ul>
        <?php
    }
}

add_filter('the_content', 'remove_empty_p', 20, 1);
function remove_empty_p($content){
    $content = force_balance_tags($content);
    return preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
}

function wc_remove_related_products( $args ) {
return array();
}
add_filter('woocommerce_related_products_args','wc_remove_related_products', 10); 
