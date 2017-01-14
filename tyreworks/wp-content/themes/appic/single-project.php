<?php
get_header();

// function that allows parse galleries from the content and render them into required placeholder
require_once PARENT_DIR . '/includes/project-gallery-handler.php';
?>

<div class="white-wrap container">
	<?php if (have_posts()): ?>
		<?php while(have_posts()) : the_post(); ?>
		<?php
			$projMetaObject = vp_metabox('project_meta');
			$projectMeta = $projMetaObject->meta;
			$theContent = trim(do_shortcode(get_the_content()));
			//checking is the details section should be rendered
			$hasAnyDetailsField = false;
			$detailsKeys = array('client','manager','website');
			foreach ($detailsKeys as $keyName) {
				if (!empty($projectMeta[$keyName])) {
					$hasAnyDetailsField = true;
					break;
				}
			}

			// categories and tags loading
			$categoryLinks = array();
			if ( $categories = wp_get_post_terms($post->ID, 'project_category') ) {
				foreach ($categories as $item) {
					$categoryLinks[] = '<a href="' . esc_url(get_term_link($item, 'project_category')) . '" class="link-category">' . $item->name . '</a>';
				}
			}
		?>
		<section class="project-descript-wrap grey-lines">
			<div class="row">
				<div class="span4 project-descript">
					<h2 class="section-title"><?php the_title(); ?></h2>
					<?php if ( ! empty($categoryLinks) ) { ?>
						<div class="project-categories simple-text-14 dark-grey-text">
							<?php echo __('Categories', 'appic') . ': ' . join(', ', $categoryLinks); ?>
						</div>
					<?php } ?>
					<ul class="font-style-20 bold pink-text pink-list">
					<?php if (!empty($theContent)) { ?>
						<li>
							<span class="list-item-icon">&#8226;</span><?php echo __('Description','appic'); ?>
							<p class="simple-text-14"><?php echo $theContent; ?></p>
						</li>
					<?php } ?>
					<?php if ($hasAnyDetailsField) { ?>
						<li>
							<span class="list-item-icon">&#8226;</span><?php echo __('Details','appic'); ?>
							<div class="details-wrap">
							<?php if (!empty($projectMeta['client'])) { ?>
								<p class="simple-text-14"><strong><?php echo __('Client','appic'); ?>:</strong><?php echo esc_html($projectMeta['client']); ?></p>
							<?php } ?>
							<?php if (!empty($projectMeta['manager'])) { ?>
								<p class="simple-text-14"><strong><?php echo __('Manager','appic'); ?>:</strong><?php echo esc_html($projectMeta['manager']); ?></p>
							<?php } ?>
							<?php if (!empty($projectMeta['website'])) { ?>
								<p class="simple-text-14"><strong><?php echo __('Website','appic'); ?>:</strong><a rel="nofollow" target="_blank" href="<?php echo esc_url($projectMeta['website']); ?>" class="link-simple"><?php echo esc_html($projectMeta['website']); ?></a></p>
							<?php } ?>
							</div>
						</li>
					<?php } ?>
					<?php if (get_theme_option('project_social_sharing')) { ?>
						<li>
							<span class="list-item-icon">&#8226;</span><?php echo __('Share', 'appic'); ?>
							<?php get_template_part('includes/templates/share-buttons'); ?>
						</li>
					<?php } ?>
					</ul>
				</div><!-- end .project-descript -->
				<div class="span8">
					<?php if (!empty($post->galleriesHtml)) : ?>
						<?php $carIndex = 1; ?>
						<?php foreach($post->galleriesHtml as $galleryHtml) { ?>
						<div id="projectCarousel<?php echo $carIndex; ?>" class="carousel slide">
							<!-- Carousel items -->
							<div class="carousel-inner image-border">
								<?php if(empty($galleryHtml)) {
									echo "<img class='item active' src='http://placehold.it/760x520'>";
								} else {
									echo $galleryHtml;
								} ?>
							</div>
							<!-- Carousel nav -->
							<div class="carousel-control-holder text-center">
								<a class="left-control" href="#projectCarousel<?php echo $carIndex; ?>" data-slide="prev"></a>
								<a class="right-control" href="#projectCarousel<?php echo $carIndex; ?>" data-slide="next"></a>
							</div>
						</div>
						<?php $carIndex++; ?>
						<?php } ?>
					<?php elseif (has_post_thumbnail()) : ?>
						<div class="carousel-inner image-border">
						<?php
							$thumb = get_the_post_thumbnail(get_the_id(), 'single-project', array('class' => 'grey-border'));
							if(empty($thumb)) {
								echo "<img class='grey-border' src='http://placehold.it/760x520'>";
							} else {
								echo $thumb;
							}
						?>
						</div>
					<?php endif; ?>
				</div>
			</div><!-- end .row -->
		</section><!-- end .project-descript-wrap -->
		<?php endwhile; ?>

<?php
if (get_theme_option('project_details_show_similar')) {
	get_template_part('includes/templates/project/similar-projects');
}
$hasLeftWidget = is_dynamic_sidebar('single_project_widget_left');
$hasRightWidget = is_dynamic_sidebar('single_project_widget_right');

$leftCellClass = $hasRightWidget ? 'span8' : 'span12';
$rightCellClass = $hasLeftWidget ? 'span4' : 'span12';
?>
<?php if ($hasLeftWidget || $hasRightWidget) : ?>
<section class="container recently-wrap-case">
	<div class="row">
	<?php if ($hasLeftWidget) { ?>
		<div class="<?php echo $leftCellClass ;?>" id="signleProjectToolbar">
			<?php if(!dynamic_sidebar('single_project_widget_left')): ?>
				<?php //[testimonials block_class=""] ?>
			<?php endif; ?>
		</div>
	<?php } ?>
	<?php if ($hasRightWidget) { ?>
		<div class="<?php echo $rightCellClass ;?>">
			<?php if(!dynamic_sidebar('single_project_widget_right')): ?>
			<?php endif; ?>
		</div>
	<?php } ?>
	</div>
</section>
<?php endif; ?>
	<?php else : ?>
		<?php get_template_part('404'); ?>
	<?php endif; ?>
</div><!-- end of .white-wrap -->

<?php get_footer(); ?>