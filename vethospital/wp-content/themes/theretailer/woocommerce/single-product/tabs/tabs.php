<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
$tabs = apply_filters( 'woocommerce_product_tabs', array() );

if ( ! empty( $tabs ) ) : ?>

	<div class="grid_12">
        <div class="woocommerce-tabs">
            <div class="grid_4 alpha omega">
                <ul class="tabs">
                    <?php foreach ( $tabs as $key => $tab ) : ?>
        
                        <li class="<?php echo $key ?>_tab">
                            <a href="#tab-<?php echo $key ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
                        </li>
        
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="grid_8 alpha omega">
				<?php foreach ( $tabs as $key => $tab ) : ?>
        
                    <div class="panel entry-content" id="tab-<?php echo $key ?>">
                        <?php call_user_func( $tab['callback'], $key, $tab ) ?>
                    </div>
        
                <?php endforeach; ?>
            </div>
            <div class="clr"></div>
        </div>
    </div>

<?php endif; ?>