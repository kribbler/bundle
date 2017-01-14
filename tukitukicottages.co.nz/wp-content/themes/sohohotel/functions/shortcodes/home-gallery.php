<?php

// Gallery Section Wrapper Shortcode
function gallery_section_shortcode( $atts, $content = null ) {	
	$output = '<li>';
	$output .= do_shortcode($content);
	$output .= '</li>';
	return $output;
}
add_shortcode( 'gallery_section', 'gallery_section_shortcode' );

// Gallery Image Shortcode
function gallery_image_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
			'image_url' => '',
		), $atts ) );
	
	if( !isset($atts['image_url']) ) {
		$image_url = $atts['image_url'];
	}
	
	$output = '<img src="';
	$output .= $image_url;
	$output .= '" class="gallery-preview" alt="" />';
	return $output;
}
add_shortcode( 'gallery_image', 'gallery_image_shortcode' );

?>