<?php

// Widget Slide
function widget_slide_shortcode( $atts, $content = null ) {

	$output = '<li>';
		$output .= $content;
	$output .= '</li>';

	return $output;
}

add_shortcode( 'widget_slide', 'widget_slide_shortcode' );



// Widget Slide Container
function widget_slide_container_shortcode( $atts, $content = null ) {
		
	$output = '<div class="slider-blocks clearfix">';
		$output .= '<ul class="slides slide-loader2">';
			$output .= do_shortcode( $content );
		$output .= '</ul>';
	$output .= '</div>';
	
	return $output;

}

add_shortcode( 'widget_slide_container', 'widget_slide_container_shortcode' );

?>