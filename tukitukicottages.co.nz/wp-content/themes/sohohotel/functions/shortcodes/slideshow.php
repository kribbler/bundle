<?php

/**
 * Slideshow container
 *
 * @param array $atts
 * @param string $content
 * @return string
 */
function qns_slideshow_shortcode($atts, $content = NULL) {

	ob_start();
	?>
	<div class="slider slideshow-shortcode">
		<ul class="slides">
			<?php echo do_shortcode($content); ?>
		</ul>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode('slideshow', 'qns_slideshow_shortcode');

/**
 * Slideshow slides
 * 
 * @param array $atts
 *		array(
 *			'image_url' => string
 *			'link_url' => string
 *			'caption' => string
 *		)
 * @param string $content
 * @return string
 */
function qns_slideshow_slide($atts, $content = NULL) {
	extract(shortcode_atts(array(
		'image_url' => '',
		'link_url' => '',
		'caption' => ''
	), $atts));
	ob_start();
	?>
	<li>
		<a href="<?php echo $link_url; ?>"><img src="<?php echo $image_url; ?>" alt="" /></a>
		<div class="flex-caption"><?php echo $caption; ?></div>
	</li>
	<?php
	return ob_get_clean();
}
add_shortcode('slide', 'qns_slideshow_slide');
