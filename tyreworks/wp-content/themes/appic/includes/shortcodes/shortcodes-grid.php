<?php
// Row
function row_shortcode($atts, $content = null)
{
	extract(shortcode_atts(array(
		'class' => ''
	), $atts));
	
	return '<div class="row '.$class.'">'.do_shortcode($content).'</div>';
}
add_shortcode('row', 'row_shortcode');

// Span Bootstrap Columns
function grid_column($atts, $content = null, $shortcodename = '')
{
	extract(shortcode_atts(array(
		'class' => ''
	), $atts));

	//remove wrong nested <p>
	$content = remove_invalid_tags($content, array('p'));

	// add divs to the content
	return '<div class="'.str_replace('column_', 'span', $shortcodename).' '.$class.'">' . do_shortcode($content) . '</div>';
}
add_shortcode('column_1', 'grid_column');
add_shortcode('column_2', 'grid_column');
add_shortcode('column_3', 'grid_column');
add_shortcode('column_4', 'grid_column');
add_shortcode('column_5', 'grid_column');
add_shortcode('column_6', 'grid_column');
add_shortcode('column_7', 'grid_column');
add_shortcode('column_8', 'grid_column');
add_shortcode('column_9', 'grid_column');
add_shortcode('column_10', 'grid_column');
add_shortcode('column_11', 'grid_column');
add_shortcode('column_12', 'grid_column');
