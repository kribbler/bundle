<?php
/**
 * Cross-sells
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

global $woocommerce_loop, $woocommerce, $product;

$crosssells = $woocommerce->cart->get_cross_sells();

if ( sizeof( $crosssells ) == 0 ) return;

$args = array(
	'post_type'				=> 'product',
	'ignore_sticky_posts'	=> 1,
	'posts_per_page' 		=> 12,
	'no_found_rows' 		=> 1,
	'orderby' 				=> 'rand',
	'post__in' 				=> $crosssells
);

$products = new WP_Query( $args );

$woocommerce_loop['columns'] 	= 2;

if ( $products->have_posts() ) : ?>    
    
    <?php $sliderrandomid = rand() ?>
    
    <script>
	jQuery(document).ready(function($) {
		/* items_slider */
		$('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_slider').iosSlider({
			snapToChildren: true,
			desktopClickDrag: true,
			scrollbar: true,
			scrollbarHide: true,
			scrollbarLocation: 'bottom',
			scrollbarHeight: '2px',
			scrollbarBackground: '#ccc',
			scrollbarBorder: '0',
			scrollbarMargin: '0',
			scrollbarOpacity: '1',
			navNextSelector: $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_sliders_nav .big_arrow_right'),
			navPrevSelector: $('.gbtr_items_slider_id_<?php echo $sliderrandomid ?> .gbtr_items_sliders_nav .big_arrow_left')
		});
	});
	</script>
    
        <br /><br />
        <div class="gbtr_items_slider_id_<?php echo $sliderrandomid ?>">
            
            <div class="gbtr_items_sliders_header">
                <div class="gbtr_items_sliders_title">
                    <div class="gbtr_featured_section_title"><strong><?php _e('You may be interested in&hellip;', 'woocommerce') ?></strong></div>
                </div>
                <div class="gbtr_items_sliders_nav">                        
                    <a class='big_arrow_right'></a>
                    <a class='big_arrow_left'></a>
                    <div class='clr'></div>
                </div>
            </div>
            
            <div class="gbtr_bold_sep"></div>   
        
            <div class="gbtr_items_slider_wrapper">
                <div class="gbtr_items_slider">
                    <ul class="slider">
                        <?php while ( $products->have_posts() ) : $products->the_post(); ?>
        
                            <?php woocommerce_get_template_part( 'content', 'product' ); ?>
            
                        <?php endwhile; // end of the loop. ?>
                    </ul>     
                </div>
            </div>
        
        </div>
    
    

<?php endif;

//wp_reset_query();
