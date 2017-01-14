<?php
// Error (Alert box)
function error_shortcode($atts, $content=null)
{
	return '<div class="shortcode alert alert-error fade in">' .
		'<button type="button" class="close" data-dismiss="alert">&times;</button>' .
		do_shortcode($content) .
	'</div>';
}
add_shortcode ('error', 'error_shortcode');

// Warning (Alert box)
function warning_shortcode($atts, $content=null)
{
	return '<div class="shortcode alert alert-notice fade in">' .
		'<button type="button" class="close" data-dismiss="alert">&times;</button>' .
		do_shortcode($content) .
	'</div>';
}
add_shortcode ('warning', 'warning_shortcode');

// Info (Alert box)
function info_shortcode($atts, $content=null)
{
	return '<div class="shortcode alert alert-info fade in">' .
		'<button type="button" class="close" data-dismiss="alert">&times;</button>' .
		do_shortcode($content) .
	'</div>';
}
add_shortcode ('info', 'info_shortcode');

// Success (Alert box)
function success_shortcode($atts, $content=null)
{
	return '<div class="shortcode alert alert-success fade in">' .
		'<button type="button" class="close" data-dismiss="alert">&times;</button>' .
		do_shortcode($content) .
	'</div>';
}
add_shortcode ('success', 'success_shortcode');

// Promo box
function promo_shortcode($atts, $content=null)
{
	extract(shortcode_atts(array(
		'button_link' => '#',
		'button_text' => 'Button',
		'button_color' => 'info',
		'color' => '',
		'overlay' => '',
	), $atts));

	$wrapClasesMap = array(
		'Beige' => '',
		'Grey' => '2',
	);
	$classWrap = isset($wrapClasesMap[$color]) ? $wrapClasesMap[$color] : '3';
	$classWrap .= $overlay == 'yes' ? ' wrap-position' : '';

	$buttonClassesMap = array(
		'Blue' => 'info',
		'Dark blue' => 'primary',
		'Grey' => '',
		'Green' => 'success',
		'Yellow' => 'warning',
		'Pink' => 'danger',
	);
	$classButton = isset($buttonClassesMap[$button_color]) ? 'btn-' . $buttonClassesMap[$button_color] : '';

	return '<div class="shortcode promobox-wrap'.$classWrap.' button-wrap">' .
		'<div class="promobox">' .
			'<p class="pull-left">'.$content.'</p>' .
			'<a class="btn '.$classButton.' btn-large-maxi pull-right" href="'.$button_link.'">'.$button_text.'</a>' .
		'</div>' .
	'</div>';
}
add_shortcode ('promo', 'promo_shortcode');

// Action box
function action_shortcode ($atts, $content=null)
{
	extract(shortcode_atts(array(
		'title' => '',
		'button' => '',
		'link' => '#'
	), $atts));

	return '<div class="shortcode grey-block-wrap">' .
		'<div class="grey-block question-wrap text-center">' .
			'<h4 class="font-style-20 bold upper">' . $title . '</h4>' .
			'<p class="simple-text-12">' . do_shortcode($content) . '</p>' .
			'<a href="' . $link . '" class="btn btn-info btn-large-maxi">' . $button . '</a>' .
		'</div>' .
	'</div>';
}
add_shortcode('action', 'action_shortcode');

// Double box
function double_box_shortcode($atts, $content = null)
{
	return '<div class="grey-lines double-box">&nbsp;</div>' .
		'<section class="shortcode posts-choose-wrap grey-lines">' .
			'<span class="grey-vertical-line hidden-phone"></span>' .
			'<div class="row">' . do_shortcode($content) . '</div>' .
		'</section>';
	//'</div>';
}
add_shortcode('double_box', 'double_box_shortcode');

// Double Box column
function double_box_column_shortcode($atts, $content = null)
{
	extract( shortcode_atts( array(
		'position' => 'left',
		'class' => '',
	), $atts ) );
	
	if ('right' == $position) {
		$class = 'choose-appic-wpar';
	}

	return '<div class="span6">' .
		(!empty($class) ? '<div class="' . $class . '">' : '') .
			do_shortcode($content) .
		(!empty($class) ? '</div>' : '') .
	'</div>';
}
add_shortcode('double_box_column', 'double_box_column_shortcode');
