<?php
/*
 * ========================================================================
 * Custom Post Types
 * ========================================================================
 */
function create_post_type_testimonial()
{
	register_post_type('testimonial', array(
		'label' => __('Testimonials', 'appic'),
		'labels' => array(
			'add_new_item' => __('Add New Testimonial', 'appic')
		),
		'singular_label' => __('Testimonial', 'appic'),
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'menu_icon' => PARENT_URL . '/includes/images/ico-testimonial.png',
		'menu_position' => 7,
		'rewrite' => array(
			'slug' => 'testimonial',
			'with_front' => false,
		),
		'supports' => array(
			'title',
			'thumbnail',
			'editor',
		)
	));
}
add_action('init', 'create_post_type_testimonial'); // Add Testimonial custom post type

// Services
function create_post_type_services()
{
	register_post_type('service', array(
		'label' => __('Services', 'appic'),
		'labels' => array(
			'add_new_item' => __('Add New Service', 'appic')
		),
		'exclude_from_search' => true,
		'publicly_queryable' => true,
		'public' => true,
		'show_ui' => true,
		'show_in_nav_menus' => true,
		'menu_icon' => PARENT_URL . '/includes/images/ico-services.png',
		'menu_position' => 6,
		'rewrite' => array(
			'slug' => 'services',
			'with_front' => false,
		),
		'supports' => array(
			'title',
			'editor',
		)
	));
}
add_action('init', 'create_post_type_services'); // Add Services custom post type

// Portfolio
function create_post_type_project()
{
	$sectionTitle = get_theme_option('portfolio_page_title');
	if (!$sectionTitle) {
		$sectionTitle = __('Portfolio', 'appic');
	}
	register_post_type('project', array(
		'label' => $sectionTitle,
		'labels' => array(
			'add_new_item' => __('Add New Project', 'appic')
		),
		'singular_label' => __('Project', 'appic'),
		'exclude_from_search' => false,
		'publicly_queryable' => true,
		'public' => true,
		'show_ui' => true,
		'has_archive' => true,
		'show_in_nav_menus' => true,
		'menu_icon' => PARENT_URL . '/includes/images/ico-portfolio.png',
		'menu_position' => 7,
		'rewrite' => array(
			'slug' => 'project',
			'with_front' => false,
		),
		'supports' => array(
			'title',
			'thumbnail',
			'editor',
		)
	));

	register_taxonomy(
		'project_category',
		'project',
		array(
			'hierarchical' => true,
			'label' => __('Project Categories', 'appic'),
			'singular_name' => __('Project Category', 'appic'),
			'rewrite' => true,
			'query_var' => true
		)
	);
}
add_action('init', 'create_post_type_project'); // Add Project custom post type

// Team
function create_post_type_team()
{
	register_post_type('team',
			array(
				'label' => __('Team', 'appic'),
				'labels' => array(
				'add_new_item' => __('Add New Team Member', 'appic')
			),
			'singular_label' => __('Team Member', 'appic'),
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => true,
			'menu_icon' => PARENT_URL . '/includes/images/ico-team.png',
			'menu_position' => 8,
			'rewrite' => array(
				'slug' => 'team',
				'with_front' => false,
			),
			'supports' => array(
					'title',
					'thumbnail',
					'editor'
				)
			)
	);
}
add_action('init', 'create_post_type_team'); // Add Team custom post type
