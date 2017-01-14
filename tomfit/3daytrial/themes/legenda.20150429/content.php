<?php
/**
*	Template for standart Posts
*/

?>

<?php 
	$postClass = 'blog-post';
	$postId = get_the_ID();
	$lightbox = etheme_get_option('blog_lightbox');
	$blog_slider = etheme_get_option('blog_slider');
?>


<article <?php post_class($postClass); ?> id="post-<?php the_ID(); ?>" >

	<?php 
		$width = etheme_get_option('blog_page_image_width');
		$height = etheme_get_option('blog_page_image_height');
		$crop = etheme_get_option('blog_page_image_cropping');
	?>

	<?php $images = etheme_get_images($width,$height,$crop); $count = count($images); ?>

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
			<?php if (count($images) == 1): ?>
				<div class="blog-mask">
					<div class="mask-content">
						<?php if($lightbox): ?><a href="<?php echo etheme_get_image(get_post_thumbnail_id($postId)); ?>" rel="lightbox"><i class="icon-resize-full"></i></a><?php endif; ?>
						<a href="<?php the_permalink(); ?>"><i class="icon-link"></i></a>
					</div>
				</div>
				
			<?php else: ?>
				
			<?php endif; ?>
		</div>
		<?php if($blog_slider): ?>
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

	<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
	<div class="post-info">
		<span class="posted-on">
			<?php _e('Posted on', ETHEME_DOMAIN) ?>
			<?php the_time(get_option('date_format')); ?> 
			<?php _e('at', ETHEME_DOMAIN) ?> 
			<?php the_time(get_option('time_format')); ?>
		</span> 
		<span class="posted-by"> <?php _e('by', ETHEME_DOMAIN);?> <?php the_author_posts_link(); ?></span> / 
		<span class="posted-in"><?php the_category(',&nbsp;') ?></span> 
		<?php // Display Comments 

			if(comments_open() && !post_password_required()) {
				echo ' / ';
				comments_popup_link('0', '1 Comment', '% Comments', 'post-comments-count');
			}

		 ?>
	</div>

	<div class="post-description"><?php the_content('<span class="button right read-more">'.__('Read More', ETHEME_DOMAIN).'</span>'); ?></div>

	<div class="clear"></div>

</article>