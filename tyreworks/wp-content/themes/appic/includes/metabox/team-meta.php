<?php return array(
	array(
		'type'       => 'textbox',
		'name'       => 'position',
		'label'      => __('Position', 'appic'),
	),
	array(
		'type' => 'group',
		'repeating' => true,
		'name' => 'social_sevices_tema_group',
		'title' => __('Social Network Services', 'appic'),
		'fields' => array(
			 array(
				'type' => 'select',
				'name' => 'service_name_team',
				'label' => __('Service Name', 'appic'),
				'items' => array(
					array(
						'value' => 'facebook',
						'label' => __('Facebook', 'appic'),
					),
					array(
						'value' => 'google',
						'label' => __('Google+', 'appic'),
					),
					array(
						'value' => 'twitter',
						'label' => __('Twitter', 'appic'),
					),
					array(
						'value' => 'linkedIn',
						'label' => __('LinkedIn', 'appic'),
					),
					array(
						'value' => 'pinterest',
						'label' => __('Pinterest', 'appic'),
					),
				),
				'default' => array(
					'',
				),
			),
			array(
				'name' => 'service_url_team',
				'label' => __('Link', 'appic'),
				'type' => 'textbox',
				'dependency' => array(
					'field' => 'service_name_team',
					'function' => 'vp_dep_boolean',
				),
				'description' => __('Enter a link to the public profile.', 'appic'),
				'validation' => 'required|url'
			),
		),
	),
);
