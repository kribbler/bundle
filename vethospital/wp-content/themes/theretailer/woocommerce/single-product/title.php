<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
 global $wpdb;
 global $woocommerce, $post;
?>

	<div class="grtr_product_header_desktops">
    
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
    
    </div>
