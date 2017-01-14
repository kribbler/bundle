<?php
/**
 * Replaces gallery shortcode handler with specific function that renders all galleries
 * defined in the content to the post property 'galleriesHtml'.
 * 
 * @see parse_project_gallery_shortcode for more details
 */
remove_shortcode('gallery');
add_shortcode('gallery', 'parse_project_gallery_shortcode');

function parse_project_gallery_shortcode($atts)
{
	global $post;

	if (empty($post->galleriesHtml)) {
		$post->galleriesHtml = array();
	}

	if (!empty( $atts['ids'] )) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $atts['orderby'] ) ) {
			$atts['orderby'] = 'post__in';
		}
		$atts['include'] = $atts['ids'];
	}

	extract(shortcode_atts(array(
		'orderby'     => 'menu_order ASC, ID ASC',
		'include'     => '',
		'id'          => $post->ID,
		'itemtag'     => 'dl',
		'icontag'     => 'dt',
		'captiontag'  => 'dd',
		'columns'     => 3,
		'size'        => 'single-project',//'large',
		'link'        => 'file'
	), $atts));

	$args = array(
		'post_type' => 'attachment',
		'post_status' => 'inherit',
		'post_mime_type' => 'image',
		'orderby' => $orderby
	);

	if (!empty($include))
		$args['include'] = $include;
	else {
		$args['post_parent'] = $id;
		$args['numberposts'] = -1;
	}

	$images = get_posts($args);
	$firstItem = true;
	$galleryHtml = '';
	foreach ($images as $image) {
		// render your gallery here
		$galleryHtml .= wp_get_attachment_image($image->ID, $size, false, array(
			'class' => 'item' . ($firstItem ? ' active' : '')
		));
		if ($firstItem) {
			$firstItem = false;
		}
	}
	$post->galleriesHtml[] = $galleryHtml;
}
