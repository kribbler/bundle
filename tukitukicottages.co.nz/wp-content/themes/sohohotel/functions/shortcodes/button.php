<?php

function button_shortcode( $atts, $content = null ) {
	
	extract( shortcode_atts( array(
			'link_url' => '',
			'type' => '',
			'rounded' => '',
			'target' => '',
		), $atts ) );
	
	if( isset($atts['link_url']) ) $link = $atts['link_url'];
	if( isset($atts['type']) ) $type = $atts['type'];
	if( isset($atts['rounded']) ) $rounded = $atts['rounded'];
	if( isset($atts['target']) ) $target = $atts['target'];
	
	// Get button type
	if( !isset($atts['type']) ) {
		$type = 'button1';
	}
	
	elseif ( $atts['type'] == 'button1' ) {
		$type = 'button1';
	}
	
	elseif ( $atts['type'] == 'button2' ) {
		$type = 'button2';
	}
	
	elseif ( $atts['type'] == 'button3' ) {
		$type = 'button3';
	}
	
	elseif ( $atts['type'] == 'button4' ) {
		$type = 'button4';
	}
	
	elseif ( $atts['type'] == 'button5' ) {
		$type = 'button5';
	}
	
	elseif ( $atts['type'] == 'button6' ) {
		$type = 'button6';
	}
	
	// Get button type
	if( !isset($atts['target']) ) {
		$target = '_parent';
	}
	
	else {
		$target = $atts['target'];
	}
	
	$output = '';
	$output .= '<a target="' . $target . '" href="';
	$output .= $link;
	$output .= '" class="';
	$output .= $type;
	
	// Get button rounded
	if ( $rounded == 'true' ) {
		$output .= ' rounded-button';
	}
	
	$output .= '">';
	$output .= $content;
	$output .= '</a>';
	$output .= '<div class="clearboth"></div>';
	
	return $output;

}

add_shortcode( 'button', 'button_shortcode' );

?>