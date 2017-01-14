<?php return array(
	array(
		'type'       => 'wpeditor',
		'name'       => 'short_description',
		'label'      => __('Short Description', 'appic'),
		'description'=> __('Will be displayed in services shortcodes (Dynamic > Services > Carousel/List/Featured)', 'appic'),
		'validation' => 'required'
	),
	array(
		'type'       => 'toggle',
		'name'       => 'is_shown_read_more',
		'label'      => __('Do you want a See more link appended to the short description?', 'appic'),
		'default'    => '1'
	),
	array(
		'type'       => 'textbox',
		'name'       => 'read_more_text',
		'label'      => __('See More Link Text', 'appic'),
		'default'    => __('See More', 'appic'),
	),
	array(
		'type'       => 'fontawesome',
		'name'       => 'icon',
		'label'      => __('Service Icon', 'appic'),
		'validation' => 'required'
	),
	array(
		'type'       => 'toggle',
		'name'       => 'is_featured_service',
		'label'      => __('Featured', 'appic'),
	),
);
