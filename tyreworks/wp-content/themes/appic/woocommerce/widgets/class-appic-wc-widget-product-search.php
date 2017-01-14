<?php
class Appic_WC_Widget_Product_Search extends WC_Widget_Product_Search
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

		$output = $before_widget;

		if ( $title ) {
			$output .= $before_title . $title . $after_title;
		}

		$form = '<form class="search-wrap" role="search" method="get" id="searchform" action="' . esc_url( home_url( '/' ) ) . '">' .
			'<div>' .
				'<input type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="' . __( 'Search for products', 'woocommerce' ) . '" />' .
				'<input type="submit" id="searchsubmit" value="" class="submit-button" />' .
				'<input type="hidden" name="post_type" value="product" />' .
			'</div>' .
		'</form>';
		
		$output .= apply_filters( 'get_product_search_form', $form );
		$output .= $after_widget;

		echo $output;
	}
}
register_widget( 'Appic_WC_Widget_Product_Search' );
