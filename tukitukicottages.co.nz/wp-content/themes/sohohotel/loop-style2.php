<li id="post-<?php the_ID(); ?>" <?php post_class("col"); ?>>

	<?php if (get_post_meta($post->ID, '_slideshow_images', true) != '') { ?>
		<?php $attachments = get_post_meta($post->ID, '_slideshow_images', true); ?>
		
		<!-- BEGIN .page-slider -->
		<div class="page-slider clearfix">
			<ul class="slides slide-page-loader">
			
			<?php $attachments_array = array_filter( explode( ',', $attachments ) );

				// Display Attachments
				if ( $attachments_array ) {

					foreach ( $attachments_array as $attachment_id ) {	
						$link = wp_get_attachment_link($attachment_id, 'image-style9', false); ?>

						<li>
							<?php echo $link; 
							if ( get_post_field('post_excerpt', $attachment_id) != '' ) {
								echo '<div class="flex-caption">' . get_post_field('post_excerpt', $attachment_id) . '</div>';
							} ?>
						</li>
					<?php } 
			 } ?>

			</ul>
		<!-- END .page-slider -->
		</div>

	<?php } else { ?>
			
		<?php if( has_post_thumbnail() ) { ?>		
			<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
				<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'image-style9' ); ?>
				<?php echo '<img src="' . $src[0] . '" alt="" class="portfolio-image" />'; ?>
			</a>	
		<?php } ?>
			
	<?php } ?> 

	<div class="title1 clearfix">
		<h4><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
		<div class="title-block"></div>
	</div>
	
	<?php the_content(); ?>
	
</li>