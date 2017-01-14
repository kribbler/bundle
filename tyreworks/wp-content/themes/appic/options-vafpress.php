<?php $sectionsConfig = array(
	'title' => __('Theme Settings', 'appic'),
	'logo' => PARENT_URL . '/img/appic-logo.png',
	'menus' => array(
		array(
			'title' => __('General', 'appic'),
			'name' => 'general',
			'icon' => 'font-awesome:fa-cogs',
			'controls' => array(
				array(
					'name' => 'favicons',
					'title' => __('Favicons', 'appic'),
					'type' => 'section',
					'fields' => array(
						//implement validation for uploaded images impossible for now
						//as vafpress does not support server-side validation
						array(
							'name' => 'favicon_ico',
							'label' => sprintf(__('Favicon %s', 'appic'), '*.ico'),
							'type' => 'upload',
							'description' => __('Favicon in ico format', 'appic'),
							'default' => '',
						),
						array(
							'name' => 'favicon_png',
							'label' => sprintf(__('Favicon %s', 'appic'), '*.png'),
							'type' => 'upload',
							'description' => __('Favicon in png format. Minimal size is 144px x 144px', 'appic'),
							'default' => '',
						),
					)
				),
				array(
					'name' => 'update_notifier',
					'label' => __('Update Notifier', 'appic'),
					'description' => __('Switch off if you don\'t want to receive update noticies.', 'appic'),
					'type' => 'toggle',
					'default' => 1,
				),
				array(
					'name' => 'google_analitycs_code',
					'label' => __('Google Analytics Code', 'appic'),
					'description' => __('Paste your Google Analytics code here.', 'appic'),
					'type' => 'textarea',
				),
				array(
					'name' => 'custom_css_text',
					'label' => __('Custom CSS', 'appic'),
					'type' => 'textarea',
				),
			)
		),
		array(
			'name' => 'typography',
			'title' => __('Typography', 'appic'),
			'type' => 'section',
			'icon' => 'font-awesome:fa-font',
			'controls' => array(
				array(
					'type' => 'section',
					'title' => __('Primary Heading Font','appic'),
					'name' => 'primary_heading_font_section',
					'fields' => _getFontSelectionFields('h1', array(
						// 'face' => '"PT Sans", Arial, sans-serif',
						'face' => 'PT Sans',
					)),
				), //end of Primary Heading Font
				array(
					'type' => 'section',
					'title' => __('Secondary Heading Font','appic'),
					'name' => 'h2_font_section',
					'fields' => _getFontSelectionFields('h2', array(
						// 'face' => 'Oswald, sans-serif',
						'face' => 'Oswald',
					)),
				), //end of Secondary Heading Font
				array(
					'type' => 'section',
					'title' => __('Navigation Font','appic'),
					'name' => 'nav_font_section',
					'fields' => _getFontSelectionFields('nav', array(
						// 'face' => '"PT Sans", Arial, sans-serif',
						'face' => 'PT Sans',
						'color' => '#ffffff'
					)),
				), //end of Navigation Font
				array(
					'type' => 'section',
					'title' => __('Body Font','appic'),
					'name' => 'body_font_section',
					'fields' => _getFontSelectionFields('body', array(
						// 'face' => '"PT Sans", Arial, sans-serif',
						'face' => 'PT Sans',
					)),
				), //end of Body Font
				array(
					'type' => 'section',
					'title' => __('Button Fonts', 'appic'),
					'name' => 'button_font_section',
					'fields' => array_merge(
						_getFontSelectionFields('button', array(
							'face' => 'PT Sans'
						)),
						array(
							array(
								'type' => 'fontsize',
								'label' => __('Standard Button Font Size', 'appic'),
								'name' => 'button_font_size',
								'default' => array('20', 'px'),
							),
							array(
								'type' => 'fontsize',
								'label' => __('Large Button Font Size', 'appic'),
								'name' => 'large_button_font_size',
								'default' => array('24', 'px'),
							),
						)
					),
				),
			)
		),
		array(
			'name' => 'header',
			'title' => __('Header', 'appic'),
			'type' => 'section',
			'icon' => 'font-awesome:fa-credit-card',//'font-awesome:fa-h-square',
			'controls' => array(
				array(
					'type' => 'section',
					'title' => __('Top Lines', 'appic'),
					'fields' => array(
						array(
							'name' => 'show_top_lines',
							'lable' => __('Show Top Lines', 'appic'),
							'type' => 'toggle',
							'description' => __('Show top line above the navigation menu', 'appic'),
							'default' => '1',
						),
						array(
							'name' => 'top_line_left_text',
							'label' => __('Top Line Left Text', 'appic'),
							'type' => 'textbox',
							'dependency'  => array(
								'field' => 'show_top_lines',
								'function' => 'vp_dep_boolean',
							),
						),
						array(
							'name' => 'top_line_right_text',
							'label' => __('Top Line Right Text', 'appic'),
							'type' => 'textbox',
							'dependency'  => array(
								'field' => 'show_top_lines',
								'function' => 'vp_dep_boolean',
							),
						),
					)
				),
				array(
					'type' => 'section',
					'title' => __('Logo', 'appic'),
					'fields' => array(
						array(
							'name' => 'logo_type',
							'label' => __('Logo Type', 'appic'),
							'type' => 'radiobutton',
							'items' => array(
								array(
									'value' => 'image',
									'label' => __('Image', 'appic'),
								),
								array(
									'value' => 'text',
									'label' => __('Text', 'appic'),
								),
							),
							'default' => array('text'),
							'validation' => 'required',
						),
						array(
							'name' => 'logo_image',
							'label' => __('Logo Image', 'appic'),
							'type' => 'upload',
							'validation' => 'required',
							'dependency' => array(
								'field' => 'logo_type',
								'function' => 'vp_dep_value_equal_image',
							),
						),
						array(
							'name' => 'logo_image_retina',
							'label' => __('Logo Image for Retina', 'appic'),
							'type' => 'upload',
							'validation' => 'required',
							'dependency' => array(
								'field' => 'logo_type',
								'function' => 'vp_dep_value_equal_image',
							),
						),
					)
				)
			)
		),
		array(
			'name' => 'footer',
			'title' => __('Footer', 'appic'),
			'type' => 'section',
			'icon' => 'font-awesome:fa-columns',
			'controls' => array(
				array(
					'name' => 'footer_show_widgets',
					'label' => __('Show Footer Widgets', 'appic'),
					'type' => 'toggle',
					'default' => '1'
				),
				array(
					'name' => 'footer_widgets_columns',
					'label' => __('Footer Widgets Columns', 'appic'),
					'type' => 'radiobutton',
					'items' => array(
						array(
							'value' => '3',
							'label' => sprintf(__('%s Columns', 'appic'), 3),
						),
						array(
							'value' => '4',
							'label' => sprintf(__('%s Columns', 'appic'), 4),
						)
					),
					'dependency' => array(
						'field' => 'footer_show_widgets',
						'function' => 'vp_dep_boolean'
					),
					'default' => array('{{last}}'),
					'validation' => 'required',
				),
				array(
					'name' => 'footer_show_social_media',
					'label' => __('Show Social Media', 'appic'),
					'type' => 'toggle',
					'default' => '1'
				),
				array(
					'name' => 'footer_note',
					'label' => __('Footer Note', 'appic'),
					'description' => __('Text used in the left side of the footer. HTML tags are allowed.', 'appic'),
					'type' => 'textarea',
					'default' => '<p>&copy; APPIC, 2013. All rights reserved. <a href="http://themeforest.net/user/olechka?ref=olechka">Done by Olia Gozha</a></p>'
				),
			)
		),
		array(
			'name' => 'home',
			'title' => __('Home', 'appic'),
			'type' => 'section',
			'icon' => 'font-awesome:fa-home',
			'menus' => array(
				array(
					'title' => __('Action Block', 'appic'),
					'name' => 'home_call_to_action',
					'icon' => 'font-awesome:fa-sitemap',
					'controls' => array_merge(
						array(
							array(
								'type' => 'toggle',
								'name' => 'home_call_block_show',
								'label' => __('Is Active?', 'appic'),
								'default' => '0',
							),
							array(
								'name' => 'home_ca_title',
								'label' => __('Title', 'appic'),
								'type' => 'textbox',
								'validation' => 'required',
								'dependency' => array(
									'field' => 'home_call_block_show',
									'function' => 'vp_dep_boolean',
								),
							),
							array(
								'name' => 'home_ca_subtitle',
								'label' => __('Subtitle', 'appic'),
								'type' => 'textbox',
								'dependency' => array(
									'field' => 'home_call_block_show',
									'function' => 'vp_dep_boolean',
								),
							),
						),
						_getHomeCallBlocks(3, array(
							'dependency' => array(
								'field' => 'home_call_block_show',
								'function' => 'vp_dep_boolean',
							),
						))
					),
				),
				array(
					'title' => __('Slider', 'appic'),
					'name' => 'home_slider',
					'icon' => 'font-awesome:fa-film',
					'controls' => array(
						array(
							'name' => 'home_show_slider',
							'label' => __('Show Slider', 'appic'),
							'type' => 'toggle',
						),
						array(
							'type' => 'section',
							'title' => __('Settings', 'appic'),
							'name' => 'home_section_slider_settings',
							'fields' => array(
								array(
									'name' => 'home_slider_mode',
									'label' => __('Display Mode','appic'),
									'type' => 'radiobutton',
									'items' => array(
										array(
											'value' => 'content_width',
											'label' => __('Content Width', 'appic'),
										),
										array(
											'value' => 'full_width',
											'label' => __('Full Width', 'appic'),
										),
									),
									'default' => '{{first}}',
								),
								_getSliderSelectorForHomePage(),
							),
							'dependency' => array(
								'field' => 'home_show_slider',
								'function' => 'vp_dep_boolean',
							),
						),
					),
				),
			),
		),
		array(
			'name' => 'blog_portfolio',
			'title' => __('Blog & Portfolio', 'appic'),
			'type' => 'section',
			'icon' => 'font-awesome:fa-th-list',
			'controls' => array(
				array(
					'name' => 'blog_style',
					'label' => __('Blog Style', 'appic'),
					'type' => 'radiobutton',
					'items' => array(
						array(
							'value' => '1',
							'label' => sprintf(__('Style %s', 'appic'), 1),
						),
						array(
							'value' => '2',
							'label' => sprintf(__('Style %s', 'appic'), 2),
						),
						array(
							'value' => '3',
							'label' => sprintf(__('Style %s', 'appic'), 3),
						),
					),
					'default' => array('{{first}}'),
					'validation' => 'required',
				),
				array(
					'name' => 'excerpt_text',
					'label' => __('Excerpt Text', 'appic'),
					'type' => 'textbox',
					'default' => 'More',
				),
				array(
					'name' => 'post_social_sharing',
					'label' => __('Post Social Sharing', 'appic'),
					'type' => 'toggle',
					'default' => '0',
				),
				array(
					'name' => 'portfolio_page_title',
					'label' => __('Portfolio Page Title', 'appic'),
					'description' => 'Is also shown in breadcrumbs.',
					'type' => 'textbox',
					'default' => 'Portfolio',
				),
				array(
					'name' => 'portfolio_layout',
					'label' => __('Portfolio Layout', 'appic'),
					'type' => 'radiobutton',
					'items' => array(
						array(
							'value' => '2',
							'label' => sprintf(__('%s Columns', 'appic'), 2),
						),
						array(
							'value' => '3',
							'label' => sprintf(__('%s Columns', 'appic'), 3),
						),
						/*array(
							'value' => 'random',
							'label' => __('Random', 'appic'),
						),*/
					),
					'default' => array('{{first}}'),
					'validation' => 'required',
				),
				array(
					'name' => 'project_details_show_similar',
					'label' => __('Show similar projects?', 'appic'),
					'description' => __('Turn on if you would like to show similar projects section on the project details page.', 'appic'),
					'type' => 'toggle',
					'default' => '1',
				),
				array(
					'name' => 'project_per_page',
					'label' => __('Projects per Page', 'appic'),
					'type' => 'textbox',
					'validation' => 'required|numeric|minlength[1]|maxlength[4]',
					'default' => '10',
				),
				array(
					'name' => 'project_social_sharing',
					'label' => __('Project Social Sharing', 'appic'),
					'type' => 'toggle',
					'default' => '0',
				),
			),
		),
		array(
			'name' => 'social_media',
			'title' => __('Social Media', 'appic'),
			'type' => 'section',
			'icon' => 'font-awesome:fa-facebook-square',
			'controls' => array(
				array(
					'name' => 'social_link_pinterest',
					'type' => 'textbox',
					'label' => __('Pinterest URL', 'appic'),
					'validation' => 'url',
				),
				array(
					'name' => 'social_link_google',
					'type' => 'textbox',
					'label' => __('Google+ URL', 'appic'),
					'validation' => 'url',
				),
				array(
					'name' => 'social_link_linkedin',
					'type' => 'textbox',
					'label' => __('Linkedin URL', 'appic'),
					'validation' => 'url',
				),
				array(
					'name' => 'social_link_twitter',
					'type' => 'textbox',
					'label' => __('Twitter URL', 'appic'),
					'validation' => 'url',
				),
				array(
					'name' => 'social_link_facebook',
					'type' => 'textbox',
					'label' => __('Facebook URL', 'appic'),
					'validation' => 'url',
				),
			),
		),
		array(
			'name' => 'other',
			'title' => __('Other','appic'),
			'type' => 'section',
			'icon' => 'font-awesome:fa-wrench',
			'menus' => array(
				array(
					'name' => 'google_map',
					'title' => __('Contact Page', 'appic'),
					'icon' => 'font-awesome:fa-map-marker',
					'type' => 'section',
					'controls' => array(
						array(
							'name' => 'google_map_show',
							'label' => __('Show Google Map', 'appic'),
							'type' => 'toggle',
							'default' => '0',
						),
						array(
							'name' => 'google_map_address',
							'label' => __('Google Map Address', 'appic'),
							'description' => __('The address will show up when clicking on the map marker.', 'appic'),
							'type' => 'textbox',
							'dependency' => array(
								'field' => 'google_map_show',
								'function' => 'vp_dep_boolean',
							),
						),
						array(
							'name' => 'google_map_coordinates',
							'label' => __('Google Map Coordinates', 'appic'),
							'description' => __('Coordinates separated by comma.', 'appic'),
							'type' => 'textbox',
							'dependency' => array(
								'field' => 'google_map_show',
								'function' => 'vp_dep_boolean',
							),
							'validation' => 'required',
							'default' => '40.764324,-73.973057',
						),
						array(
							'name' => 'google_map_zoom',
							'label' => __('Google Map Zoom', 'appic'),
							'description' => __('Number in range from 1 up to 21.', 'appic'),
							'type' => 'textbox',
							'validation' => 'required|numeric|minlength[1]|maxlength[2]',
							'default' => '10',
							'dependency' => array(
								'field' => 'google_map_show',
								'function' => 'vp_dep_boolean',
							),
							'validation' => 'required',
						),
					)
				),
				array(
					'name' => 'other_coomin_soon',
					'title' => __('Coming Soon Page', 'appic'),
					'type' => 'section',
					'icon' => 'font-awesome:fa-clock-o',
					'controls' => array(
						array(
							'name' => 'coming_soon_date',
							'label' => __('Day of Release', 'appic'),
							'type' => 'date',
							'min_date' => 'today',
							//'default' => '+1W',
						),
						array(
							'name' => 'coming_soon_description',
							'label' => __('Description', 'appic'),
							'type' => 'textarea',
							'dependency' => array(
								'field' => 'coming_soon_date',
								'function' => 'vp_dep_boolean',
							),
						),
						array(
							'name' => 'coming_soon_sb',
							'label' => __('Subscription Box', 'appic'),
							'type' => 'toggle',
							'default' => '0',
							'dependency' => array(
								'field' => 'coming_soon_date',
								'function' => 'vp_dep_boolean',
							),
						),
						array(
							'name' => 'coming_soon_sb_note',
							'label' => __('Subscription Note', 'appic'),
							'type' => 'textbox',
							'dependency' => array(
								'field' => 'coming_soon_sb',
								'function' => 'vp_dep_boolean',
							),
						),
						array(
							'name' => 'coming_soon_sb_form_code',
							'label' => __('Subscription Form Shortcode', 'appic'),
							'description' => __('Please use shortcode to insert subscription form here.', 'appic'),
							'type' => 'textarea',
							'dependency' => array(
								'field' => 'coming_soon_sb',
								'function' => 'vp_dep_boolean',
							),
							'validation' => 'required',
						)
					)
				),
				array(
					'name' => '404_page',
					'title' => '404 Page',
					'type' => 'section',
					'icon' => 'font-awesome:fa-warning',
					'controls' => array(
						array(
							'name' => '404_title',
							'label' => __('Title', 'appic'),
							'type' => 'textbox',
							'default' => __('Oooops!', 'appic'),
						),
						array(
							'name' => '404_text',
							'label' => __('Text', 'appic'),
							'type' => 'textarea',
							'default' => __('Looks like something broke! The page you were looking for is not here.<br/>Go %s or try a search:', 'appic'),
						),
					)
				)
			)
		),
	)
);

function _getFontSelectionFields($prefix, $defaults = array())
{
	$result = array();

	$faceFieldName = $prefix . '_font_face';

	$defMap = array(
		'face' => '',
		'style' => '{{first}}',
		'weight' => '{{first}}',
		'color' => '',
	);
	$defaults = $defaults ? array_merge($defMap, $defaults) : $defMap;

	$result[] = array(
		'type' => 'select',
		'name' => $faceFieldName,
		'label' => __('Font Face', 'appic'),
		'default' => $defaults['face'],
		'items' => array(
			'data' => array(
				array(
					'source' => 'function',
					'value' => 'cached_vp_get_gwf_family',
				),
			),
		),
	);
	$result[] = array(
		'type' => 'radiobutton',
		'name' => $prefix . '_font_style',
		'label' => __('Font Style', 'appic'),
		'items' => array(
			'data' => array(
				array(
					'source' => 'binding',
					'field' => $faceFieldName,
					'value' => 'cached_vp_get_gwf_style',
				),
			),
		),
		'default' => $defaults['style'],
		// 'default' => array('{{first}}'),
	);
	$result[] = array(
		'type' => 'radiobutton',
		'name' => $prefix . '_font_weight',
		'label' => __('Font Weight', 'appic'),
		'items' => array(
			'data' => array(
				array(
					'source' => 'binding',
					'field' => $faceFieldName,
					'value' => 'cached_vp_get_gwf_weight',
				),
			),
		),
		'default' => $defaults['weight'],
	);

	return $result;
}

if ( class_exists('woocommerce') ) {
	$sectionsConfig['menus'][] = array(
		'name' => 'woocommerce',
		'title' => __('Woocommerce','appic'),
		'type' => 'section',
		'icon' => 'font-awesome:fa-shopping-cart',
		'controls' => array(
			array(
				'name' => 'woocommerce_def_img',
				'label' => __('Placeholder image', 'appic'),
				'type' => 'upload',
				'description' => __('Replace the default WooCommerce image', 'appic'),
				'default' => '',
			),
		)
	);;
}


return $sectionsConfig;

/**
 * Generates set of the sections required for the blocks management in the home call to action template.
 * @see  includes/templates/home/call-action-block.php
 * @param  integer $length number of blocks that should be generated
 * @param  assoc $additionalOptions set of options that should be applied to each block
 * @return array
 */
function _getHomeCallBlocks($length = 3, $additionalOptions = array())
{
	$result = array();
	for($i=1; $i<=$length; $i++) {
		$fields = array();
		$dep = array(
			'field' => 'home_ca_title_' .$i,
			'function' => 'vp_dep_boolean',
		);
		$fields[] = array(
			'type' => 'textbox',
			'label' => __('Title', 'appic'),
			'name' => 'home_ca_title_' .$i,
			'validation' => ($i < 2 ? 'required|' : '') . 'maxlength[12]',
		);
		$fields[] = array(
			'type' => 'textbox',
			'label' => __('Title Hover', 'appic'),
			'name' => 'home_ca_title_hover_' .$i,
			'validation' => 'maxlength[9]',
			'dependency' => $dep,
		);
		$fields[] = array(
			'type' => 'textbox',
			'label' => __('URL', 'appic'),
			'name' => 'home_ca_url_' .$i,
			'validation' => 'required|url',
			'dependency' => $dep,
		);
		$fields[] = array(
			'type' => 'textarea',
			'label' => __('Description', 'appic'),
			'name' => 'home_ca_description_' .$i,
			'validation' => 'maxlength[40]',
			'dependency' => $dep,
		);

		$newSection = array(
			'type' => 'section',
			'title' => __('Block', 'appic') . ' ' . $i,
			'name' => 'home_call_settings_section_' . $i,
			'dependency' => array(
				'field' => 'home_call_block_show',
				'function' => 'vp_dep_boolean',
			),
			'fields' => $fields,
		);

		if ( ! empty( $additionalOptions ) ) {
			foreach ($additionalOptions as $key => $settingValue) {
				$newSection[$key] = $settingValue;
			}
		}

		$result[] = $newSection;
	}
	return $result;
}

/**
 * Returns field that allows to select revolution slider.
 * @return assoc
 */
function _getSliderSelectorForHomePage()
{
	$isRevoSliderInstalled = class_exists('RevSlider');

	$revoSlidersList = array();
	if ($isRevoSliderInstalled) {
		$slider = new RevSlider();
		//if ($arrSliders = $slider->getArrSliders()) {
		if ($arrSliders = $slider->getArrSlidersShort()) {
			foreach ($arrSliders as $sid => $stitle) {
				$revoSlidersList[] = array(
					'value' => $sid,
					'label' => $stitle,
				);
			}
		}
	}

	$descriptionNoticeText = '';
	if (!$isRevoSliderInstalled) {
		$descriptionNoticeText = __('Please install and activate the Slider Revolution plugin.','appic');
	} else if (empty($revoSlidersList)) {
		$descriptionNoticeText = __('Please go to Slider Revolution plugin and create a slider.','appic');
	}

	return array(
		'label' => __('Choose Slider', 'appic'),
		'type' => 'select',
		'name' => 'home_slider_alias',
		'description' => $descriptionNoticeText ? '<span style="color:#EE0000">' . $descriptionNoticeText . '</span>' : '',
		'items' => $revoSlidersList,
	);
}
