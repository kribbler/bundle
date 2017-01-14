<?php




function columns_shortcode( $atts, $content = null ) {
	return '<ul class="columns-wrapper clearfix">' . do_shortcode($content) . '</ul>';
}
add_shortcode( 'columns', 'columns_shortcode' );




function one_half_shortcode( $atts, $content = null ) {
	return '<div class="one-half">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'one_half', 'one_half_shortcode' );




function one_half_last_shortcode( $atts, $content = null ) {
	return '<div class="one-half last-col">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'one_half_last', 'one_half_last_shortcode' );




function one_third_shortcode( $atts, $content = null ) {
	return '<div class="one-third">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'one_third', 'one_third_shortcode' );




function one_third_last_shortcode( $atts, $content = null ) {
	return '<div class="one-third last-col">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'one_third_last', 'one_third_last_shortcode' );




function two_thirds_shortcode( $atts, $content = null ) {
	return '<div class="two-thirds">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'two_thirds', 'two_thirds_shortcode' );




function two_thirds_last_shortcode( $atts, $content = null ) {
	return '<div class="two-thirds last-col">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'two_thirds_last', 'two_thirds_last_shortcode' );




function one_fourth_shortcode( $atts, $content = null ) {
	return '<div class="one-fourth">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'one_fourth', 'one_fourth_shortcode' );




function one_fourth_last_shortcode( $atts, $content = null ) {
	return '<div class="one-fourth last-col">' . do_shortcode($content) . '</div>';
}
add_shortcode( 'one_fourth_last', 'one_fourth_last_shortcode' );



?>