<?php

function title_shortcode( $atts, $content = null ) {
	
	$output = '<h3 class="title-style1">';
	$output .= $content;
	$output .= '<div class="title-block"></div>';
	$output .= '</h3>';
	
	return $output;
	
}

add_shortcode( 'title', 'title_shortcode' );

?>