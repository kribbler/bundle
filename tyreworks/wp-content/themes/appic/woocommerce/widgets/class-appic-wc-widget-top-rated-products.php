<?php
class Appic_WC_Widget_Top_Rated_Products extends WC_Widget_Top_Rated_Products
{
	/**
	 * Widget function.
	 *
	 * @see WP_Widget
	 * @access public
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget( $args, $instance )
	{
		extract( $args );
		
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		$number = absint( $instance['number'] );

		add_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );

		$query_args = array(
			'posts_per_page' => $number, 
			'no_found_rows' => 1, 
			'post_status' => 'publish', 
			'post_type' => 'product' 
		);

		$query_args['meta_query'] = WC()->query->get_meta_query();

		$query = new WP_Query( $query_args );

		if ( $query->have_posts() ) {
			$output = $before_widget;
			if ( $title ) {
				$header_widget_title = '<div class="page-elements-title-wrap horizontal-blue-lines text-center">' .
					'<h3 class="page-elements-title page-title-position blue-text">' .
						$title .
					'</h3>' .
				'</div>';
			} else {
				$header_widget_title = '';
			}

			$output .= '<div class="popular-post">' . $header_widget_title . '<ul class="popular-post-list">';

			while ( $query->have_posts() ) {
				$query->the_post();
				$image = woocommerce_get_thumbnail( null, 'shop-widget-top-rated-products' );
				$link_product = get_permalink();
				$do_excerpt = strip_tags( do_excerpt( get_the_content(), 10 ) );
				$output .= '<li class="widget_popular_product">' .
					'<div class="image-wrap text-center">' .
						$image .
						'<a class="mask" href="' . $link_product . '"></a>' .
					'</div>' .
					'<p class="simple-text-16">' .
						'<a class="link" href="' . $link_product . '">' . $do_excerpt . '</a>' .
						'<a href="' . $link_product . '" class="link-icon-arrow link-position"></a>' .
					'</p>' .
				'</li>';
			}
			$output .= '</ul></div>';
			$output .= $after_widget;

			echo $output;
		}

		remove_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );
		wp_reset_query();
	}
}
register_widget( 'Appic_WC_Widget_Top_Rated_Products' );
