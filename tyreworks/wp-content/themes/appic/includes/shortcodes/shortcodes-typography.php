<?php
// Divider - Double blue
function divider_blue_shortcode ($atts, $content=null)
{
	extract(shortcode_atts(array(
		'class' => 'link-wrap'
	), $atts));

	return '<div class="'.$class.' horizontal-blue-lines">&nbsp;</div>';
}
add_shortcode ('divider_blue', 'divider_blue_shortcode');

// Divider - Grey
function divider_grey_shortcode ($atts, $content=null)
{
	extract(shortcode_atts(array(
		'class' => 'grey-lines',
	), $atts));
	$classAttr = $class ? ' class="' . $class . '"' : '';
	return '<section'.$classAttr . '>&nbsp;</section>';
}
add_shortcode ('divider_grey', 'divider_grey_shortcode');

// Title - Small
function title_small_shortcode($atts, $content=null)
{
	extract(shortcode_atts(array(
		'small_text' => '',
		'bottom_margin' => 'no'
	), $atts));

	$class = ($bottom_margin == 'yes') ? ' bottom-margin' : '';

	return '<h2 class="article-title' . $class . '">' . $small_text .
		'<span>' .  do_shortcode($content) . '</span>' .
	'</h2>';
}
add_shortcode ('title_small', 'title_small_shortcode');

// Title - Big
function title_big_shortcode ($atts, $content=null)
{
	extract(shortcode_atts(array(
		'small_text' => '',
		'bottom_margin' => 'no'
	), $atts));
	
	$class = ($bottom_margin == 'yes') ? ' bottom-margin' : '';

	return '<h2 class="section-title' . $class . '">' . $small_text .
		'<span class="blue-text">' . do_shortcode($content) . '</span>' .
	'</h2>';
}
add_shortcode ('title_big', 'title_big_shortcode');

// Title - Blue line
function title_blue_shortcode ($atts, $content=null)
{
	extract(shortcode_atts(array(
		'bottom_margin' => 'no'
	), $atts));

	$class = ($bottom_margin == 'yes') ? ' bottom-margin' : '';

	return '<div class="page-elements-title-wrap horizontal-blue-lines text-center' . $class . '">' .
		'<h3 class="page-elements-title page-title-position blue-text">' . do_shortcode($content) . '</h3>' .
	'</div>';
}
add_shortcode ('title_blue', 'title_blue_shortcode');

// Title - Pink
function title_pink_shortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		'small_text' => '',
		'bottom_margin' => 'no'
	), $atts));

	$class = ($bottom_margin == 'yes') ? ' bottom-margin' : '';

	return '<h2 class="pink-text section-title' . $class . '">' . $small_text .
		'<span class="custom-size">' . do_shortcode($content) . '</span>' .
	'</h2>';
}
add_shortcode('title_pink', 'title_pink_shortcode');

// Link - Standard
function link_shortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		'label' => '',
		'url' => '',
	), $atts));

	return '<a class="link-button" href="'.$url.'">'.$label.'<span class="link-arrow"></span></a>';
}
add_shortcode('link', 'link_shortcode');

// Link - Full width
function link_full_width_shortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		'label' => '',
		'url' => '',
	), $atts));

	return '<div class="link-wrap horizontal-blue-lines text-center stretch-over-container">' .
		'<div class="container">' .
			'<a class="pull-right link-button link-full-width" href="'.$url.'">'.$label.'<span class="link-arrow"></span></a>' .
			'<div class="clearfix"></div>' .
		'</div>' .
	'</div>';
}
add_shortcode('link_full_width', 'link_full_width_shortcode');

// Explanation - Arrow 1
function explanation_arrow1_shortcode($atts, $content = null)
{
	return '<p class="grey-text simple-text-16 subscribe-meet-image"><em>' . do_shortcode($content) .'</em></p>';
}
add_shortcode('explanation_arrow1', 'explanation_arrow1_shortcode');

// Explanation - Arrow 2
function explanation_arrow2_shortcode($atts, $content = null)
{
	return '<p class="grey-text simple-text-16 subscribe-compatibility-image"><em>' . do_shortcode($content) .'</em></p>';
}
add_shortcode('explanation_arrow2', 'explanation_arrow2_shortcode');

// List - Decimal
function list_decimal_shortcode($atts, $content=null)
{
	return '<ol class="post-order-list">' . do_shortcode($content) . '</ol>';
}
add_shortcode ('list_decimal', 'list_decimal_shortcode');
ThemeShortcodesEscapeNL::add_relation('list_decimal','item');

// List - Square
function list_square_shortcode($atts, $content=null)
{
	return '<ul class="post-unorder-list">' . do_shortcode($content) . '</ul>';
}
add_shortcode ('list_square', 'list_square_shortcode');
ThemeShortcodesEscapeNL::add_relation('list_square','item');

// Item (List)
function item_shortcode($atts, $content=null)
{
	return '<li>' . do_shortcode($content) . '</li>';
}
add_shortcode ('item', 'item_shortcode');

// List - Vertical line
function list_vertical_line_shortcode ($atts, $content=null)
{
	return '<div class="project-descript vertical-line-list">' .
		'<ul class="clear-list font-style-20 bold pink-text pink-list">' . do_shortcode($content) . '</ul>' .
	'</div>';
}
add_shortcode ('list_vertical_line', 'list_vertical_line_shortcode');
ThemeShortcodesEscapeNL::add_relation('list_vertical_line','item_vertical_line');

// Item - Vertical line
function item_vertical_line_shortcode ($atts, $content=null)
{
	extract(shortcode_atts(array(
		'title' => 'Title'
	), $atts));

	return '<li><span class="list-item-icon">&bull;</span>' . $title .
		'<p class="simple-text-14">' . do_shortcode($content) . '</p>' .
	'</li>';
}
add_shortcode ('item_vertical_line', 'item_vertical_line_shortcode');

// List - Arrow
function list_arrow_shortcode($atts, $content = null)
{
	return '<ul class="shortcode clear-list camera_pag_ul">' . do_shortcode($content) . '</ul>';
}
add_shortcode('list_arrow', 'list_arrow_shortcode');
ThemeShortcodesEscapeNL::add_relation('list_arrow','item');

// Dropcaps
function dropcap_shortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		'style' => ''
	), $atts));

	$map = array(
		'square' => 'dropcaps1 small-grey-text',
		'circle' => 'dropcaps2 small-grey-text',
	);

	$class = isset($map[$style]) ? $map[$style] : 'dropcaps3 small-grey-text';

	return '<p class="'.$class.'">' . $content . '</p>';
}
add_shortcode('dropcap', 'dropcap_shortcode');

// Tooltips
function tooltip_shortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		'color' => '',
		'hint' => ''
	), $atts));

	if (!empty($color)) {
		if('dark' == $color) {
			$color = "dark-blue";
		}
		$color = ' ' .$color . '-tooltip';
	}

	return '<a href="#" class="custom-tooltip'.$color.'" data-original-title="'.$hint.'">' . do_shortcode($content) . '</a>';
}
add_shortcode('tooltip', 'tooltip_shortcode');

// Font
function font_shortcode($atts, $content=null)
{
	extract(shortcode_atts(array(
		'size' => '12',
	), $atts));

	return '<span style="font-size: ' . $size . 'px">' . $content . '</span>';
}
add_shortcode('font', 'font_shortcode');

// Quote
function quote_shortcode($atts, $content=null)
{
	extract(shortcode_atts(array(
		'author' => '',
	), $atts));

	return '<blockquote class="shortcode text-right"><p class="simple-text-14 bold dark-grey-text">' . $author . '</p>' .
		'<p class="simple-text-14 dark-grey-text"><em>' . do_shortcode($content) . '</em></p>' .
	'</blockquote>';
}
add_shortcode('quote', 'quote_shortcode');
