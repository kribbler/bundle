<?php
// Roundabout
function roundabout_shortcode($atts, $content = null)
{
	$jsOptions = array(
		'tilt' => 0.4,
		'minScale' => 0.5,
		'minOpacity' => 1,
		'duration' => 400,
		'easing' => 'easeOutQuad',
		'enableDrag' => true,
		'dragFactor' => 2,
		'dropEasing' => 'easeOutBack',
		'responsive' => true,
		//'focusBearing' => 20,
	);
	if ($atts && is_array($atts)) {
		$attrToOption = array(
			'min_scale' => 'minScale',
			'min_opacity' => 'minOpacity',
			'drag_factor' => 'dragFactor',
			'drop_easing' => 'dropEasing',
			'enable_drag' => 'enableDrag'
		);

		foreach ($atts as $atrrName => $value) {
			$jsOptionName = isset($attrToOption[$atrrName]) ? $attrToOption[$atrrName] : $atrrName;
			if (isset($jsOptions[$jsOptionName])) {
				$type = gettype($jsOptions[$jsOptionName]);
				if ('boolean' == $type && in_array($value, array('false','no'))) {
					$value = false;
				} else {
					settype($value, $type);
				}
			}
			$jsOptions[$jsOptionName] = $value;
		}
	}
	wp_enqueue_script('roundabout');
	$containerId = 'carousel';
	$makeCarouselCode = 'jQuery("#'.$containerId.'").roundabout(' . json_encode($jsOptions) . ');';
	JsClientScript::addScript('roundaboutShortcodeInit',
		$makeCarouselCode .
		'var raboutOnResizeTout, raboutOnResize = function(){jQuery("#'.$containerId.'>li").removeAttr("style");'.$makeCarouselCode.' raboutOnResizeTout = null;};' .
		'jQuery(window).resize(function(){if (raboutOnResizeTout) clearTimeout(raboutOnResizeTout); raboutOnResizeTout = setTimeout(raboutOnResize, 200);});'
	);

	return '<ul class="shortcode clear-list carousel" id="carousel">' . do_shortcode($content) . '</ul>';
}
add_shortcode('roundabout_carousel', 'roundabout_shortcode');
ThemeShortcodesEscapeNL::add_relation('roundabout_carousel','item');
