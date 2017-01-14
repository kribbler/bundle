<?php
/**
*	Template for standart Posts (grid layout)
*/

?>

<?php 
	$postId = get_the_ID();
	$lightbox = etheme_get_option('blog_lightbox');
	$postClass = 'blog-post post-grid span4';
	$width = etheme_get_option('blog_page_image_width');
	$height = etheme_get_option('blog_page_image_height');
	$crop = etheme_get_option('blog_page_image_cropping');
?>


<article <?php post_class($postClass); ?> id="post-<?php the_ID(); ?>" >

	<?php $image = etheme_get_image(false, $width,$height,$crop); ?>

	<?php if (has_post_thumbnail()): ?>
		<div class="post-images">
			<a href="<?php the_permalink(); ?>"><img src="<?php echo $image; ?>"></a>
			<div class="blog-mask">
				<div class="mask-content">
					<?php if($lightbox): ?><a href="<?php echo etheme_get_image(get_post_thumbnail_id($postId)); ?>" rel="lightbox"><i class="icon-resize-full"></i></a><?php endif; ?>
					<a href="<?php the_permalink(); ?>"><i class="icon-link"></i></a>
				</div>
			</div>
		</div>	
	<?php endif ?>	
	<div class="post-information <?php if (!has_post_thumbnail()): ?>border-top<?php endif ?>">
		<h4 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		<div class="post-info">
			<span class="posted-on">
				<?php _e('Posted on', ETHEME_DOMAIN) ?>
				<?php the_time(get_option('date_format')); ?> 
				<?php _e('at', ETHEME_DOMAIN) ?> 
				<?php the_time(get_option('time_format')); ?>
			</span> 
			<span class="posted-by"> <?php _e('by', ETHEME_DOMAIN);?> <?php the_author_posts_link(); ?></span>
			<?php // Display Comments 

				if(comments_open() && !post_password_required()) {
					echo ' / ';
					comments_popup_link('0', '1 Comment', '% Comments', 'post-comments-count');
				}

			 ?>
		</div>

		<div class="post-description"><?php the_content('<span class="button center read-more">'.__('Read More', ETHEME_DOMAIN).'</span>'); ?></div>

		<div class="clear"></div>
	</div>

</article>