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
        
        	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        	<?php woocommerce_get_template( 'loop/sale-flash.php' ); ?>
        
        	<div class="my_product_description">
        		
				<p>
				<?php if ($product->post->post_excerpt){
					echo $product->post->post_excerpt;
				} else {
					//echo '<p>Vivamus quis tristique est, id vehicula odio. Aenean sit amet elit risus. Cras id blandit urna. Nunc vel dictum ipsum, nec mattis nulla. Pellentesque ac pharetra purus. Donec ut gravida sapien.</p>';
				} ?>
				<?php //echo $product->post->post_excerpt;?></p>
				
				
					
								
				
				<div class="clear_20"></div>
					<?php
                //if ($_SERVER['REMOTE_ADDR'] == '83.103.200.163'){
	            		$outofstock = 0;
	            		//echo "<pre>";
	            		$available_variations = $product->get_available_variations();
	            		foreach ($available_variations as $key => $value) {
	            			//var_dump($value['availability_html']);
	            			if (strip_tags($value['availability_html']) == 'Out of stock'){
	            				$outofstock++;
	            			}
	            		}
	            		if ($outofstock == 2){
	            			echo '<span class="out_of_stock">Out of stock</span>';
	            		}
	            		//echo "</pre>";
	            	//}
	            ?>			
				
			</div>
            <div class="image_container">
                <a href="<?php the_permalink(); ?>">

                    <div class="loop_products_thumbnail_img_wrapper front">
                    	<?php 
                    	if ( has_post_thumbnail() ) {
                    		echo get_the_post_thumbnail( $post->ID, 'shop_catalog');
						} else {?>
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/default_tyre.png" alt="<?php the_title(); ?>" />
						<?php }
							 
                    	?>
                    </div>
                    
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
            <div class="clear_20"></div>

            <div>
            	<?php 
            	$pa_profile = get_product_attribute_value($product->id, "pa_profile");
            	if ($pa_profile){?>
            		<span class="my_product_attribute_blue"><?php echo $pa_profile;?></span>
            	<?php }
            	$pa_rimsize = get_product_attribute_value($product->id, "pa_rim-size");
            	if ($pa_rimsize){?>
            		<span class="my_product_attribute_blue"><?php echo $pa_rimsize;?></span>
            	<?php }
            	$pa_width = get_product_attribute_value($product->id, "pa_width");
            	if ($pa_width){?>
            		<span class="my_product_attribute_blue"><?php echo $pa_width;?></span>
            	<?php } ?>
				
				
			</div>

			<div class="clear_20"></div>
			<div class="product_item_bottom">
	            <?php if ( ! $product->is_in_stock() ) : ?>
	            	<a href="<?php echo get_permalink($product->id); ?>" class="button"><?php echo apply_filters('out_of_stock_add_to_cart_text', __('Read More', 'woocommerce')); ?></a>
	            <?php else : ?>
	            	<?php 
	            		switch ( $product->product_type ) {
							case "variable" :
								$link = get_permalink($product->id);
								$label = apply_filters('variable_add_to_cart_text', __('MORE INFO', 'woocommerce'));
							break;
							case "grouped" :
							$link = get_permalink($product->id);
							$label = apply_filters('grouped_add_to_cart_text', __('View options', 'woocommerce'));
							break;
							case "external" :
							$link = get_permalink($product->id);
							$label = apply_filters('external_add_to_cart_text', __('Read More', 'woocommerce'));
							break;
							default :
							$link = esc_url( $product->add_to_cart_url() );
							$label = apply_filters('add_to_cart_text', __('Add to cart', 'woocommerce'));
							break;
						}

						if ( $product->product_type == 'simple' ) {
							?>
							<form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="cart" method="post" enctype='multipart/form-data'>
							<?php woocommerce_quantity_input(); ?>
							<?php if ($outofstock != 2){?>
								<button type="submit" class="button alt"><?php echo $label; ?></button>
							<?php } ?>
							</form>
							<?php
						} else {
							printf('<a href="%s" rel="nofollow" data-product_id="%s" class="button____ add_to_cart_button mybutton_product_type_%s ">%s</a>', $link, $product->id, $product->product_type, $label);
							//printf('<a href="%s" rel="nofollow" data-product_id="%s" class="button add_to_cart_button product_type_%s">%s</a>', $link, $product->id, $product->product_type, $label);
						}?>
	            <?php endif; ?>

	            <?php /*
	            <?php if ( (!$theretailer_theme_options['category_listing']) || ($theretailer_theme_options['category_listing'] == 0) ) { ?>
	            <!-- Show only the first category-->
	            <?php $gbtr_product_cats = strip_tags($product->get_categories('|||', '', '')); //Categories without links separeted by ||| ?>
	            <h3><a href="<?php the_permalink(); ?>"><?php list($firstpart) = explode('|||', $gbtr_product_cats); echo $firstpart; ?></a></h3>
	            <?php } ?>
	            
	            */?>

	            <?php
	                /**
	                 * woocommerce_after_shop_loop_item_title hook
	                 *
	                 * @hooked woocommerce_template_loop_price - 10
	                 */
	                 
	                do_action( 'woocommerce_after_shop_loop_item_title' );
	            ?>
        	</div>
        </li>
