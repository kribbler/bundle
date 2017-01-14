<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $product, $woocommerce_loop, $theretailer_theme_options;

$attachment_ids = $product->get_gallery_attachment_ids();

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibilty
if ( ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

?>

	
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

        <li class="product_item">
        
        	<?php woocommerce_get_template( 'loop/sale-flash.php' ); ?>
        
            <div class="image_container">
                <a href="<?php the_permalink(); ?>">

                    <div class="loop_products_thumbnail_img_wrapper front"><?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog') ?></div>
                    
                    <?php if ( (!$theretailer_theme_options['flip_product']) || ($theretailer_theme_options['flip_product'] == 0) ) { ?>
                    
					<?php

						if ( $attachment_ids ) {
					
							$loop = 0;				
							
							foreach ( $attachment_ids as $attachment_id ) {
					
								$image_link = wp_get_attachment_url( $attachment_id );
					
								if ( ! $image_link )
									continue;
								
								$loop++;
								
								printf( '<div class="loop_products_additional_img_wrapper back">%s</div>', wp_get_attachment_image( $attachment_id, 'shop_catalog' ) );
								
								if ($loop == 1) break;
							
							}
					
						} else {
						?>
                        
                        <div class="loop_products_additional_img_wrapper back"><?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog') ?></div>
                        
                        <?php
							
						}
					?>
                    
                    <?php } ?>
                    
                </a>
                <div class="clr"></div>
                <?php if ( (!$theretailer_theme_options['catalog_mode']) || ($theretailer_theme_options['catalog_mode'] == 0) ) { ?>
                <div class="product_button"><?php do_action( 'woocommerce_after_shop_loop_item' ); ?></div>
                <?php } ?>
            </div>
            
            <?php if ( (!$theretailer_theme_options['category_listing']) || ($theretailer_theme_options['category_listing'] == 0) ) { ?>
            <!-- Show only the first category-->
            <?php $gbtr_product_cats = strip_tags($product->get_categories('|||', '', '')); //Categories without links separeted by ||| ?>
            <h3><a href="<?php the_permalink(); ?>"><?php list($firstpart) = explode('|||', $gbtr_product_cats); echo $firstpart; ?></a></h3>
            <?php } ?>
            
            <p><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>
            
            <?php
                /**
                 * woocommerce_after_shop_loop_item_title hook
                 *
                 * @hooked woocommerce_template_loop_price - 10
                 */
                 
                do_action( 'woocommerce_after_shop_loop_item_title' );
            ?>
        
        </li>
