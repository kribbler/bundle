<?php
/**
*	Template for standart Posts (timeline layout)
*/

?>

<?php 
	$postClass = 'blog-post post-timeline';
	$postId = get_the_ID();
	$lightbox = etheme_get_option('blog_lightbox');
	$blog_slider = etheme_get_option('blog_slider');
?>


<article <?php post_class($postClass); ?> id="post-<?php the_ID(); ?>" >
	<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<div class="post-info">
		<span class="posted-by"> <?php _e('Posted by', ETHEME_DOMAIN);?> <?php the_author_posts_link(); ?></span> / 
		<span class="posted-in"><?php the_category(',&nbsp;') ?></span> 
		<?php // Display Comments 

			if(comments_open() && !post_password_required()) {
				echo ' / ';
				comments_popup_link('0', '1 Comment', '% Comments', 'post-comments-count');
			}

		 ?>
	</div>

	<?php 
		$width = etheme_get_option('blog_page_image_width');
		$height = etheme_get_option('blog_page_image_height');
		$crop = etheme_get_option('blog_page_image_cropping');
	?>

	<?php $images = etheme_get_images($width,$height,$crop); ?>

	<?php if (count($images)>0 && has_post_thumbnail()): ?>
		<div class="post-images nav-type-small<?php if (count($images)>1): ?> images-slider<?php endif; ?>">
			<ul class="slides">
				<?php if(!$blog_slider): ?>
					<li><a href="<?php the_permalink(); ?>"><img src="<?php echo $images[0]; ?>"></a></li>
				<?php else: ?>
					<?php foreach ($images as $key => $value): ?>
						<li><a href="<?php the_permalink(); ?>"><img src="<?php echo $value; ?>"></a></li>
					<?php endforeach ?>
				<?php endif; ?>
			</ul>
			<?php if (count($images) == 1 || !$blog_slider): ?>
				<div class="blog-mask">
					<div class="mask-content">
						<?php if($lightbox): ?><a href="<?php echo etheme_get_image(get_post_thumbnail_id($postId)); ?>" rel="lightbox"><i class="icon-resize-full"></i></a><?php endif; ?>
						<a href="<?php the_permalink(); ?>"><i class="icon-link"></i></a>
					</div>
				</div>
			<?php endif ?>
		</div>
		<?php if($blog_slider && count($images) > 1): ?>
			<script type="text/javascript">
				jQuery(document).ready(function(){
					jQuery('.post-images').flexslider({
						animation: "slide",
						slideshow: false,
						animationLoop: false,
						controlNav: false,
						smoothHeight: true
					});
				});
			</script>	
		<?php endif; ?>
	<?php endif ?>

	<div class="post-description"><?php the_content('<span class="button right read-more">'.__('Read More', ETHEME_DOMAIN).'</span>'); ?></div>

	<div class="post-date">
		<span class="post-day"><?php echo get_the_time('d'); ?></span>
		<span class="post-month"><?php echo get_the_time('M'); ?> <?php echo get_the_time('Y'); ?></span>
	</div>

	<div class="clear"></div>

	<hr>
	
	<div class="blog-line"></div>

	<div class="clear"></div>

</article>