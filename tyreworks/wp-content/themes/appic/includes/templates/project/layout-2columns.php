<?php
$cellClass = 'span6';
$thumbWidth = 570;
$thumbHeight = 330;

$detailsTitle = get_theme_option('excerpt_text');
if ( empty( $detailsTitle ) ) {
	$detailsTitle = __('More', 'appic');
};
?>

<div class="row image-gallery">
<?php while(have_posts()) : the_post(); ?>
	<?php
		$detailsLink = get_permalink();
		$itemTitle = get_the_title();
	?>
	<div class="<?php echo $cellClass; ?>">
		<div class="image-figure">
		<?php
			if (has_post_thumbnail()) {
				$thumb = get_the_post_thumbnail($post->ID);
				if(empty($thumb)){
					$thumbUrl = "http://placehold.it/{$thumbWidth}x{$thumbHeight}";
				}else{
					if ($mainImageUrl = wp_get_attachment_url(get_post_thumbnail_id(),'full')) {
						$thumbUrl = aq_resize($mainImageUrl, $thumbWidth, $thumbHeight, true ); //resize & crop img
					}
				}
				echo'<div class="view hover-effect-image">
					<img src="'.$thumbUrl.'" width="'.$thumbWidth.'" height="'.$thumbHeight.'" />
					<a href="'.$detailsLink.'" class="mask" title="'.esc_attr($itemTitle).'">
						<span class="mask-icon" title="'.$detailsTitle.'">'.$detailsTitle.'</span>
					</a>
				</div>';
			}
		?>
			<div class="image-capture">
				<h2 class="font-style-20 bold">
					<a href="<?php echo $detailsLink; ?>" data-rel="colorbox2" class="link"><?php echo $itemTitle; ?></a>
				</h2>
				<h5 class="simple-text-14 dark-grey-text">
					<?php
						echo get_the_term_list($post->ID, 'project_category', 'Categories: ', ', ', '');
					?>
				</h5>
				<div class="simple-text-12"><?php the_excerpt(); ?></div>
			</div>
		</div>
	</div>
<?php endwhile; ?>
</div><!-- end of .row -->
<?php echo appic_posts_navigation(); ?>