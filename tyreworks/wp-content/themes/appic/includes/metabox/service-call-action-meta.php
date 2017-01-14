<?php return array(
	array(
		'type' => 'textbox',
		'name' => 'title1',
		'label' => __('Heading', 'appic'),
		'validation' => 'maxlength[255]'
	),
	array(
		'type' => 'textbox',
		'name' => 'title2',
		'label' => __('Subheading', 'appic'),
		'validation' => 'maxlength[255]',
	),
	array(
		'type' => 'textbox',
		'name' => 'btn_title',
		'label' => __('Button Text', 'appic'),
		'validation' => 'maxlength[20]',
	),
	array(
		'type' => 'textbox',
		'name' => 'btn_url',
		'label' => __('Button URL', 'appic'),
		'validation' => 'required|url',
		'dependency'  => array(
			'field' => 'btn_title',
			'function' => 'vp_dep_boolean',
		),
	),
	array(
		'type' => 'upload',
		'name' => 'image_url',
		'label' => __('Image', 'appic'),
		'validation' => '',
	),
	array(
		'type' => 'backgroundposition',
		'name' => 'bg_position',
		'label' => __('Image Position', 'appic'),
		'default' => array(
			'h' => 'top',
			'v' => 'center',
			'repeat' => 'no-repeat',
		)
	)
);
