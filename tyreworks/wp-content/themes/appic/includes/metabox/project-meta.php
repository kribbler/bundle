<?php return array(
	array(
		'type'       => 'textbox',
		'name'       => 'client',
		'label'      => __('Client', 'appic'),
		'validation' => 'maxlength[150]',
	),
	array(
		'type'       => 'textbox',
		'name'       => 'manager',
		'label'      => __('Manager', 'appic'),
		'validation' => 'maxlength[150]',
	),
	array(
		'type'       => 'textbox',
		'name'       => 'website',
		'label'      => __('Website', 'appic'),
		'validation' => 'url',
	),
);
