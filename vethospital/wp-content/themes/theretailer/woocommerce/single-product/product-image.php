<?php

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_attachment_ids();

?>
    
    <div class="images gbtr_images">
		
		<script type="text/javascript">
		
			(function($){
			   $(window).load(function(){
				   $('.doubleSlider-1').iosSlider({
						scrollbar: true,
						snapToChildren: true,
						desktopClickDrag: true,
						infiniteSlider: false,
						navPrevSelector: $('.product_single_slider_previous'),
						navNextSelector: $('.product_single_slider_next'),
						scrollbarHeight: '2',
						scrollbarBorderRadius: '0',
						scrollbarOpacity: '0.5',
						onSliderLoaded: doubleSlider2Load,
						onSlideChange: doubleSlider2Load,
						onSliderResize: doubleSlider2Load
					});
					
					$('.doubleSlider-2 .button').each(function(i) {				
						$(this).bind('click', function() {
							$('.doubleSlider-1').iosSlider('goToSlide', i+1);						
						});				
					});
					
	
					$('.doubleSlider-2').iosSlider({
						desktopClickDrag: true,
						snapToChildren: true,
						snapSlideCenter: false,
						infiniteSlider: false
					});
					
					function doubleSlider2Load(args) {
						
						currentSlide = args.currentSlideNumber;
						$('.doubleSlider-2').iosSlider('goToSlide', args.currentSlideNumber);
						
						/* update indicator */
						$('.doubleSlider-2 .button').removeClass('selected');
						$('.doubleSlider-2 .button:eq(' + (args.currentSlideNumber-1) + ')').addClass('selected');
						
						/* update height of the first slider */

						setTimeout(function() {
							var setHeight = $('.doubleSlider-1 .item:eq(' + (args.currentSlideNumber-1) + ')').outerHeight(true);
							$('.doubleSlider-1').animate({ height: setHeight }, 300);
						},300);
						
					}
			   })
			})(jQuery);

		</script>
    
    
    	<div class = 'doubleSlider-1'>
		
			<div class = 'slider'>
			
				<?php if ( has_post_thumbnail() ) : ?>
            	
				<?php
					//Get the Thumbnail URL
					$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );
					
					$attachment_count   = count( get_children( array( 'post_parent' => $post->ID, 'post_mime_type' => 'image', 'post_type' => 'attachment' ) ) );
			
				?>
                
                <div class="item">
                	<span itemprop="image"><?php echo get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) ) ?></span>
                	<a href="<?php echo $src[0] ?>" class="zoom" rel="prettyPhoto[product-gallery]"></a>
                </div>
				
				<?php endif; ?>	
                
				<?php

					if ( $attachment_ids ) {
				
						$loop = 0;
						$columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );						
						
						foreach ( $attachment_ids as $attachment_id ) {

							$classes = array( 'zoom' );
				
							if ( $loop == 0 || $loop % $columns == 0 )
								$classes[] = 'first';
				
							if ( ( $loop + 1 ) % $columns == 0 )
								$classes[] = 'last';
				
							$image_link = wp_get_attachment_url( $attachment_id );
				
							if ( ! $image_link )
								continue;
				
							$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
							$image_class = esc_attr( implode( ' ', $classes ) );
							$image_title = esc_attr( get_the_title( $attachment_id ) );
							
							printf( '<div class="item"><span>%s</span><a href="%s" class="zoom" rel="prettyPhoto[product-gallery]"></a></div>', wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) ), wp_get_attachment_url( $attachment_id ) );
							
							$loop++;
						}
						
						
				
					}
				?>
			
			</div>
            
            <?php if ( $attachment_count != 1 ) { ?>
            <div class='product_single_slider_previous'></div>
            <div class='product_single_slider_next'></div>
            <?php } ?>
			
		</div>
        
        <link rel="image_src" href="<?php echo $src[0] ?>" />
		
		<?php 

		if ( $attachment_ids ) {
		
		?>
        
        <div class = 'doubleSlider-2'>
			
			<div class = 'slider'>
                        
                        <?php if ( has_post_thumbnail() ) : ?>
                        <div class="button"><div itemprop="image"><?php echo get_the_post_thumbnail( $post->ID, 'shop_thumbnail' ) ?></div></div>
                        <?php endif; ?>
                        
                        <?php
                
                        $loop = 0;
                        $columns = apply_filters( 'woocommerce_product_thumbnails_columns', 3 );
						
						foreach ( $attachment_ids as $attachment_id ) {

							$classes = array( 'zoom' );
				
							if ( $loop == 0 || $loop % $columns == 0 )
								$classes[] = 'first';
				
							if ( ( $loop + 1 ) % $columns == 0 )
								$classes[] = 'last';
				
							$image_link = wp_get_attachment_url( $attachment_id );
				
							if ( ! $image_link )
								continue;
				
							$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
							$image_class = esc_attr( implode( ' ', $classes ) );
							$image_title = esc_attr( get_the_title( $attachment_id ) );
							
							echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="button">%s</div>', $image ), $attachment_id, $post->ID, $image_class );
							
							$loop++;
						}
						
						if ($loop < 4) {
							for ($i=1; $i<(4-$loop); $i++) {
							?>
								<div class="button"><!-- empty placeholder --></div>
							<?php
							}
						}
						?>
			
			</div>
		
		</div>
        
        <?php } ?>
    
    </div>