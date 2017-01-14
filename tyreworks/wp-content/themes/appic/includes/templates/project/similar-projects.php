<?php
$projectTags = '';
$projectCategories = '';

$taxQuery = array(
	'relation' => 'OR',
);

if ('project' == get_post_type()) {
	$projectCategories = wp_get_post_terms($post->ID, 'project_category');
	$projectTags = wp_get_post_terms($post->ID,'post_tag');

	$catIds = array();
	if ($projectCategories) {
		foreach ($projectCategories as $cat) {
			$catIds[] = $cat->term_id;
		}

		$taxQuery[] = array(
			'taxonomy' => 'project_category', 
			'field' => 'term_id', 
			'terms' => $catIds,
			'operator' => 'IN'
		);
	}
	$tagIds = array();
	if ($projectTags) {
		foreach ($projectTags as $tag) {
			$tagIds[] = $tag->term_id;
		}
		$taxQuery[] = array(
			'taxonomy' => 'post_tag', 
			'field' => 'term_id', 
			'terms' => $tagIds,
			'operator' => 'IN'
		);
	}
}

$similarProjects = new WP_Query(array(
	'post_type' => 'project',
	'posts_per_page' => 12,
	'paged' => 1,
	'tax_query' => $taxQuery,
	'post__not_in' => array(get_the_ID()),
	//to get posts with featured image only
	'meta_query' => array(
		array('key' => '_thumbnail_id'),
	)
));


if (!$similarProjects->have_posts()) {
	return;
}

wp_enqueue_script('bxslider');
JsClientScript::addScript('initSimilarProjects',
	'$("#similarProjectsSlider").bxSlider({pager:false,minSlides:1,maxSlides:4,slideWidth:270,slideMargin:30});'
);
?>

<div class="similar-projects-wrap horizontal-blue-lines stretch-over-container">
	<section class="container similar-projects grey-lines">
		<h2 class="article-title"><?php echo __('Similar', 'appic'); ?><span><?php echo __('Projects', 'appic'); ?></span></h2>
		<ul id="similarProjectsSlider" class="bxslider">
<?php
$elements = array();
while($similarProjects->have_posts()) : $similarProjects->the_post();
	$title = get_the_title();
	$permalink = get_permalink();
	$thumbUrl = wp_get_attachment_url(get_post_thumbnail_id(), 'full');
	if(empty($thumbUrl)){
		$thumbUrl = "http://placehold.it/270x160";
	}else{
		$thumbUrl = aq_resize($thumbUrl, 270, 160, true );
	}

	$elements[] = '<li>' .
			'<div class="view hover-effect-image">' .
			'<img src="' . $thumbUrl . '" alt="'. $title .'" />' .
			'<a href="' . $permalink .'" class="mask-no-border"><span class="mask-icon" title="' . $title . '">' . $title . '</span></a>' .
		'</div>' .
	'</li>';
endwhile;

$curIndex = 0;
while (count($elements) < 4) {
	$elements[] = $elements[$curIndex];
	$curIndex++;
}
echo join('', $elements);
?>
		</ul>
	</section>
</div>