<div id="post-<?php the_ID(); ?>" <?php post_class("blog-entry clearfix"); ?>>
	
	<?php if( has_post_thumbnail() ) { ?>		
		<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
			<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'image-style7' ); ?>
			<?php echo '<img src="' . $src[0] . '" alt="" class="blog-image" />'; ?>
		</a>	
	<?php } ?>
	
	<h3 class="blog-title">
		<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
	</h3>
	
	<div class="blog-meta"><?php _e('By','qns'); ?> <?php the_author_posts_link(); ?> / <?php the_time('jS F, Y'); ?> / <?php the_category(', '); ?> / <?php comments_popup_link( 
		__( 'No Comments', 'qns' ), 
		__( '1 Comment', 'qns' ), 
		__( '% Comments', 'qns' ), 
		'',
		__( 'Off','qns')
	); ?></div>
	
	<?php global $more;$more = 0;?>
	<?php the_content(__('Read More','qns')); ?>

</div>