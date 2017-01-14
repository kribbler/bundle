<?php
// Pricing table (Pricing table)
function pricing_table_shortcode($atts, $content = null)
{
	extract( shortcode_atts( array(
		'columns' => '4',
	), $atts ) );
	
	$map = array(
		'3' => 'three',
		'4' => 'four',
		'5' => 'five',
	);
	
	return '<section class="shortcode pricing-tables clearfix text-center ' . $map[$columns] . '-cols">' .
		do_shortcode($content) .
	'</section>';
}
add_shortcode('pricing_table', 'pricing_table_shortcode');
ThemeShortcodesEscapeNL::register_nested_shortcods('pricing_table', 'pricing_column', 'pricing_item');

// Pricing column (Pricing table)
function pricing_column_shortcode($atts, $content = null)
{
	extract( shortcode_atts( array(
		'title' => '',
		'title_class' => 'blue-text',
		'price' => '',
		'button_text' => '',
		'button_url' => '',
		'premium' => '',
		'button_class' => 'btn-primary',
	), $atts ) );

	if (empty($button_text)) {
		$button_text = __('Purchase', 'appic');
	}

	$output  = '<div class="pricing-column pull-left text-center advanced">' .
		'<header class="pr-head">' .
			'<h3 class="font-style-24 ' . $title_class . '">' . $title . '</h3>' .
			'<h4 class="price">' . $price . '</h4>' .
		'</header>' .
		'<div class="pr-body">' .
			'<ul class="clear-list pr-features">' . do_shortcode($content) . '</ul>' .
			'<a href="'.$button_url.'" class="btn btn-large '.$button_class.'">' . $button_text . '</a>' . 
		'</div>' .
	'</div>';

	return $output;
}
add_shortcode('pricing_column', 'pricing_column_shortcode');

// Pricing Item (Pricing table)
function pricing_item_shortcode($atts, $content = null)
{
	return '<li>' . do_shortcode($content) . '</li>';
}
add_shortcode('pricing_item', 'pricing_item_shortcode');

// Tabs - Horizontal
function tabs_shortcode($atts, $content = null)
{
	extract (shortcode_atts(array(
		'class' => ''
	), $atts));

	$output = '<ul class="shortcode clear-list nav nav-tabs" id="myTab">';

	//Create unique ID for this tab set
	//$id = rand();

	//Build tab menu
	$numTabs = count($atts);

	for($i = 1; $i <= $numTabs; $i++) {
		$class = (1 == $i ? ' class="active"' : '');
		$output .= '<li'.$class.'><a href="#tab'.$i.'" data-toggle="tab">'.$atts['tab'.$i].'</a></li>';
	}

	$output .= '</ul>';

	$output .= '<div class="tab-content">';

	//Build content of tabs
	$i = 1;
	$tabContent = do_shortcode($content);
	$find = array();
	$replace = array();
	foreach($atts as $key => $value) {
		$find[] = '['.$key.']';
		$find[] = '[/'.$key.']';
		$class = (1 == $i ? ' active' : '');
		$replace[] = '<div id="tab'.$i.'" class="tab-pane'.$class.'">';
		$replace[] = '</div><!-- .tab (end) -->';
		$i++;
	}
	$output .= str_replace($find, $replace, $tabContent);
	$output .= '</div><!-- .tab-content (end) -->';

	return $output;
}
add_shortcode('tabs', 'tabs_shortcode');

// Tabs - Vertical
function tabs_vertical_shortcode($atts, $content = null)
{
	extract (shortcode_atts(array(
		'class' => ''
	), $atts));

	JsClientScript::addScript('tabs2ShortcodeInit',
		'$(".span6").each(function(){' .
			'$(this).find("#myTab-left li:first").addClass("active");' .
			'$(this).find(".tab-pane:first").addClass("active");' .
		'});' .

		'$("#myTab-left a").click(function (e) {' .
			'e.preventDefault();' .
			'$(this).tab("show");' .
		'});'
	);

	//Create unique ID for this tab set
	$id = rand();

	//Build tab menu
	$numTabs = count($atts);

	$output = '<div class="shortcode tabbable tabs-left">' .
		'<ul class="clear-list nav nav-tabs" id="myTab-left">';

	for($i = 1; $i <= $numTabs; $i++){
		$class = (1 == $i ? ' class="active"' : '');
		$output .= '<li' . $class . '><a href="#tab-'.$id.'-'.$i.'-left" data-toggle="tab">'.$atts['tab'.$i].'</a></li>';
	}
	$output .= '</ul>';

	$output .= '<div class="tab-content">';

	//Build content of tabs
	$i = 1;
	$tabContent = do_shortcode($content);
	$find = array();
	$replace = array();
	foreach($atts as $key => $value){
		$find[] = '['.$key.']';
		$find[] = '[/'.$key.']';
		$class = (1 == $i ? ' active' : '');
		$replace[] = '<div id="tab-'.$id.'-'.$i.'-left" class="tab-pane'.$class.'">';
		$replace[] = '</div><!-- .tab (end) -->';
		$i++;
	}

	$output .= str_replace($find, $replace, $tabContent);

	$output .= '</div>';//<!-- .tab-content (end) -->
	$output .= '</div>';

	return $output;

}
add_shortcode('tabs_vertical', 'tabs_vertical_shortcode');

// Table
function table_shortcode($atts, $content = null)
{
	return '<table class="shortcode table table-bordered">' . do_shortcode($content) . '</table>';
}
add_shortcode('table', 'table_shortcode');
ThemeShortcodesEscapeNL::register_nested_shortcods('table', 'head', 'table_row', 'column');
ThemeShortcodesEscapeNL::register_nested_shortcods('table', 'body', 'table_row', 'column');
ThemeShortcodesEscapeNL::register_nested_shortcods('table', 'table_row');


// Table tr (Table)
function tr_shortcode($atts, $content = null)
{
	return '<tr>' . do_shortcode($content) . '</tr>';
}
add_shortcode('table_row', 'tr_shortcode');

// Table td (Table)
function td_shortcode($atts, $content = null)
{
	return '<td>' . do_shortcode($content) . '</td>';
}
add_shortcode('column', 'td_shortcode');

// Table thead (Table)
function thead_shortcode($atts, $content = null)
{
	return '<thead>' . do_shortcode($content) .'</thead>';
}
add_shortcode('head', 'thead_shortcode');

// Table tbody (Table0)
function tbody_shortcode($atts, $content = null)
{
	return '<tbody>' . do_shortcode($content) .'</tbody>';
}
add_shortcode('body', 'tbody_shortcode');

// Accordion
function _get_accordion_id($generateNew = false)
{
	static $curId;
	if (null == $curId) {
		$curId = 1;
	} elseif ($generateNew) {
		$curId++;
	}

	return 'accordion' . $curId;
}

function _get_accordion_toggle_next_id()
{
	static $curId;
	if (null == $curId) {
		$curId = 1;
	} else {
		$curId++;
	}

	return $curId;
}

function accordion_shortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		'style' => '',
	), $atts));

	$map = array(
		'1' => 'accordion style-2',
		'2' => 'accordion',
	);

	$class = isset($map[$style]) ? $map[$style] : 'accordion style-3';

	return '<div id="' . _get_accordion_id(true) . '" class="shortcode '.$class.'">' . do_shortcode($content) . '</div>';
}
add_shortcode('accordion', 'accordion_shortcode');
ThemeShortcodesEscapeNL::add_relation('accordion','toggle');

// Accordion toggle
function toggle_shortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		'title' => 'Title goes here',
		'open' => 'no'
	), $atts));

	$toggle_id = _get_accordion_toggle_next_id();
	$output = '<div class="accordion-group">' .
		'<div class="accordion-heading">' .
			'<a data-parent="#' . _get_accordion_id() . '" class="accordion-toggle accordion-'.($open == 'yes' ? 'minus' :'plus').'" data-toggle="collapse" href="#collapse-' . $toggle_id . '">' .
				$title .
			'</a>' .
		'</div>' .
		'<div id="collapse-' . $toggle_id . '" class="accordion-body collapse'.($open == 'yes' ? ' in' :'').'">' .
			'<div class="accordion-inner">' . do_shortcode($content) . '</div>' .
		'</div>' .
	'</div>';

	return $output;
}
add_shortcode('toggle', 'toggle_shortcode');

// Button
function button_shortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		'color' => 'info',
		'link' => '#',
		'text' => 'Button',
		'size' => 'large',
		'target' => '_self'
	), $atts));
	
	$buttonClassesMap = array(
		'Blue' => 'info',
		'Dark blue' => 'primary',
		'Grey' => '',
		'Green' => 'success',
		'Yellow' => 'warning',
		'Pink' => 'danger',
	);
	$classButton = !empty($buttonClassesMap[$color]) ? 'btn-'.$buttonClassesMap[$color] : '';

	return '<a href="'.$link.'" class="btn btn-'.$size.' '.$classButton.'" target="'.$target.'">'. $text . '</a>';

}
add_shortcode('button', 'button_shortcode');

// Image border
function border_shortcode($atts, $content=null)
{
	extract(shortcode_atts(array(
		'alignment' => 'left',
	), $atts));
	
	return '<div class="image-border pull-' . $alignment . ' image-in-text">' . $content . '</div>';
}
add_shortcode ('border', 'border_shortcode');
