<?php
// Timeline
function timeline_shortcode ($atts, $content=null)
{
	extract(shortcode_atts(array(
		'open_all' => false,
	), $atts));

	wp_enqueue_script('time_line');

	JsClientScript::addScript('timelineShortcodeInitCode',
		'$(".timeline").timeLineG({maxdis:280,mindis:100,wraperClass:"timeline-wrap",openAll:' . ( $open_all == 'yes' ? 'true' : 'false' ) . '});'
	);

	return '<div class="timeline"><div class="dateline">' .
		do_shortcode($content) .
	'</div></div>';
}
add_shortcode ('timeline', 'timeline_shortcode');

function year_shortcode($atts, $content=null)
{
	extract(shortcode_atts(array(
		'x' => '2014'
	), $atts));

	return '<div class="year"><span class="sircle"></span>'.$x.'</div>';
}
add_shortcode ('year', 'year_shortcode');

// Timeline item
function time_item_shortcode ($atts, $content=null)
{
	extract(shortcode_atts(array(
		'date' => '',
		'position' => 'bottom',
		'month' => ''
	), $atts));

	return '<div data-date="'.$date.'" class="event '.$position.'">' .
		'<div class="block-e">' .
			'<h5 class="simple-text-16 bold">'.$month.'</h5>' .
			'<p class="simple-text-12"><em>' .
				do_shortcode($content) .
			'</em></p>' .
		'</div>' .
		'<span class="sircle"></span> <span class="line"></span>' .
	'</div>';
}
add_shortcode ('time_item', 'time_item_shortcode');


// Appic UNIVERSE
function appic_universe_shortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		'title' => '',
		'subtitle' => '',
		'title1' => '',
		'title2' => '',
		'title3' => '',
		'title_hover1' => '',
		'title_hover2' => '',
		'title_hover3' => '',
		'link1' => '',
		'link2' => '',
		'link3' => '',
	), $atts));

	$output = '<div class="shortcode universe-border-wrap hidden-phone stretch-over-container">' .
		'<div class="universe-wrap stretch-over-container">' .
			'<div class="pattern-wrap stretch-over-container">' .
				'<div class="lines-wrap horizontal-grey-lines stretch-over-container">' .
					'<section class="container universe">' .
						'<h2 class="section-title pull-left">' . $title . '<span>' . $subtitle . '</span></h2>' .
						'<ul class="clear-list ch-second-grid">';

	for($i=1; $i<4; $i++) {
		$itemTitle = isset($atts['title' . $i]) ? $atts['title' . $i] : '';
		$itemTitleHover = isset($atts['title_hover' . $i]) ? $atts['title_hover' . $i] : '';
		$itemLink = isset($atts['link' . $i]) ? $atts['link' . $i] : '';
		if (empty($itemTitle) || empty($itemTitleHover) || empty($itemLink)) {
			continue;
		}
		$output .= '<li>' .
			'<div class="ch-second-item">' .
				'<h4>' . $itemTitle . '</h4>' .
				'<a href="' . $itemLink . '" class="ch-second-info">' .
					'<h4>' . $itemTitleHover . '</h4>' .
				'</a>' .
			'</div>' .
		'</li>';
	}

	$output .= '</ul>' .
					'</section>' .
				'</div>' .
			'</div>' .
		'</div>' .
	'</div>';

	return $output;
}
add_shortcode('appic_universe', 'appic_universe_shortcode');

// Address
function address_shortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		'phone' => '',
		'email' => '',
		'address' => '',
	), $atts));

	$output = '';
	if( !empty($phone) ){
		$output .= '<span class="widget-news-phone">'.$phone.'</span>';
	}

	if( !empty($email) ){
		$output .= '<span class="widget-news-email">'.$email.'</span>';
	}

	if( !empty($address) ){
		$output .= '<span class="widget-news-address">'.$address.'</span>';
	}

	if ($output) {
		$output = '<div class="shortcode get-in-touch">' .
			'<address>' . $output . '</address>' .
		'</div>';
	}

	return $output;
}
add_shortcode('address', 'address_shortcode');
