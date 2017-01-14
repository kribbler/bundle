<?php
 
	global $post, $product;

	// Get category permalink
	$permalinks 	= get_option( 'woocommerce_permalinks' );
	$category_slug 	= empty( $permalinks['category_base'] ) ? _x( 'product-category', 'slug', 'woocommerce' ) : $permalinks['category_base'];
 
?>

<div itemscope itemtype="http://schema.org/Product" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>	
    
    <div class="product_main_infos">
    
    	<?php
			/**
			 * woocommerce_before_single_product hook
			 *
			 * @hooked woocommerce_show_messages - 10
			 */
			 do_action( 'woocommerce_before_single_product' );
		?>    

		<?php
		$terms = get_the_terms($post->ID,'product_cat');
		$count = count($terms); $i=0;
		
		if ($terms) {
			foreach ($terms as $term) {
				if($term->parent==0){
					$i++;
				}
			}
		}
		
		if ($i >= 1) {
		?>
	
		<div class="product_navigation mobiles">
			
			<?php
				$term_list = '';
				$j=0;
				foreach ($terms as $term) {
					if($term->parent==0){
						$j++;
						if( $j <= 1 ){
							$term_list .= '<a href="'.home_url() . '/' . $category_slug . '/'. $term->slug . '">' . $term->name . '</a>';
						}
					}
				}
				if(strlen($term_list) > 0){ echo '<div class="nav-back">&lsaquo;&nbsp;&nbsp;&nbsp;'. __('Back to ', 'theretailer').$term_list.'</div>'; };
			?>
			
			<?php if (function_exists('be_previous_post_link')) { ?>
			<div class="nav-next-single"><?php be_next_post_link( '%link', '', true,'', 'product_cat' ); ?></div>
			<div class="nav-previous-single"><?php be_previous_post_link( '%link', '', true,'', 'product_cat' ); ?></div>
			<div class="nav-prev-next-txt"><?php _e('Prev / Next', 'theretailer'); ?></div>
			<?php } ?>
			<div class="clr"></div>
		</div>
		
		<?php } ?>
        
        <div class="grtr_product_header_mobiles">
        
            <h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
        
            <?php
            
            if ( comments_open() ) {
            
                $count = $wpdb->get_var("
                    SELECT COUNT(meta_value) FROM $wpdb->commentmeta
                    LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                    WHERE meta_key = 'rating'
                    AND comment_post_ID = $post->ID
                    AND comment_approved = '1'
                    AND meta_value > 0
                ");
            
                $rating = $wpdb->get_var("
                    SELECT SUM(meta_value) FROM $wpdb->commentmeta
                    LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
                    WHERE meta_key = 'rating'
                    AND comment_post_ID = $post->ID
                    AND comment_approved = '1'
                ");
            
                if ( $count > 0 ) {
            
                    $average = number_format($rating / $count, 2);
            
                    echo '<div class="after_title_reviews"><div class="reviews_nr">'.$count.' Reviews</div><div class="star-rating" title="'.sprintf(__('Rated %s out of 5', 'woocommerce'), $average).'"><span style="width:'.($average*16).'px"><span itemprop="ratingValue" class="rating">'.$average.'</span> '.__('out of 5', 'woocommerce').'</span></div><div class="clr"></div></div>';
            
                }
                
            }
            
            ?>
            
            <div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
            
                <p itemprop="price" class="price"><?php echo $product->get_price_html(); ?></p>
            
                <link itemprop="availability" href="http://schema.org/<?php echo $product->is_in_stock() ? 'InStock' : 'OutOfStock'; ?>" />
            
            </div>
        
        </div>
        
        <div class="gbtr_poduct_details_left_col">
        
            <?php
                /**
                 * woocommerce_show_product_images hook
                 *
                 * @hooked woocommerce_show_product_sale_flash - 10
                 * @hooked woocommerce_show_product_images - 20
                 */
                do_action( 'woocommerce_before_single_product_summary' );
            ?>
        
        </div>
        
        <div class="gbtr_poduct_details_right_col">
        
			<?php
            $terms = get_the_terms($post->ID,'product_cat');
            $count = count($terms); $i=0;
			
			if ($terms) {
				foreach ($terms as $term) {
					if($term->parent==0){
						$i++;
					}
				}
			}
            
            if ($i >= 1) {
            ?>
        
            <div class="product_navigation desktops">
                
                <?php
					$term_list = '';
					$j=0;
					foreach ($terms as $term) {
						if($term->parent==0){
							$j++;
							if( $j <= 1 ){
								$term_list .= '<a href="'.home_url() . '/' . $category_slug . '/'. $term->slug . '">' . $term->name . '</a>';
							}
						}
					}
					if(strlen($term_list) > 0){ echo '<div class="nav-back">&lsaquo;&nbsp;&nbsp;&nbsp;'. __('Back to ', 'theretailer').$term_list.'</div>'; };
				?>
                
                <?php if (function_exists('be_previous_post_link')) { ?>
                <div class="nav-next-single"><?php be_next_post_link( '%link', '', true,'', 'product_cat' ); ?></div>
                <div class="nav-previous-single"><?php be_previous_post_link( '%link', '', true,'', 'product_cat' ); ?></div>
            	<div class="nav-prev-next-txt"><?php _e('Prev / Next', 'theretailer'); ?></div>
                <?php } ?>
                <div class="clr"></div>
            </div>
            
            <?php } ?>
            
            <div class="summary">
        
                <?php
                    /**
                     * woocommerce_single_product_summary hook
                     *
                     * @hooked woocommerce_template_single_title - 5
                     * @hooked woocommerce_template_single_price - 10
                     * @hooked woocommerce_template_single_excerpt - 20
                     * @hooked woocommerce_template_single_add_to_cart - 30
                     * @hooked woocommerce_template_single_meta - 40
                     * @hooked woocommerce_template_single_sharing - 50
                     */
                    do_action( 'woocommerce_single_product_summary' );
                ?>
        
            </div><!-- .summary -->
        
        </div>
        
        <div class="clr"></div>
    
    </div>
    
    <div class="clr"></div>
    
    <?php
		//Get the Thumbnail URL
		$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );
	?>
    
    <div class="gbtr_product_share">    
        <ul>    
            <li><a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" target="_blank" class="product_share_facebook"><?php _e('<span>Share</span> on Facebook', 'theretailer'); ?></a></li>
            <li><a href="//pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $src[0] ?>&description=<?php strip_tags(the_title()); ?>" target="_blank" class="product_share_pinterest"><?php _e('<span>Pin</span> this item', 'theretailer'); ?></a></li>
            <li><a href="mailto:enteryour@addresshere.com?subject=<?php strip_tags(the_title()); ?>&body=<?php echo strip_tags(apply_filters( 'woocommerce_short_description', $post->post_excerpt )); ?> <?php the_permalink(); ?>" class="product_share_email"><?php _e('<span>Email</span> a friend', 'theretailer'); ?></a></li>
            <li><a href="https://twitter.com/share?url=<?php the_permalink(); ?>" target="_blank" class="product_share_twitter"><?php _e('<span>Tweet</span> this item', 'theretailer'); ?></a></li>   
        </ul>    
    </div>
    
    <div class="clr"></div>

	<div class="">
	
		<?php
            /**
             * woocommerce_after_single_product_summary hook
             *
             * @hooked woocommerce_output_product_data_tabs - 10
             * @hooked woocommerce_output_related_products - 20
             */
            do_action( 'woocommerce_after_single_product_summary' );
        ?>
    
    </div>

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>