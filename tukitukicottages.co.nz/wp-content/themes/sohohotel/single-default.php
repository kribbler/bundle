<?php
	
	// Display Header
	get_header();
	
	// Get Theme Options
	global $smof_data;
	
	// Get Post ID
	global $wp_query;$post_id = $wp_query->post->ID;
	
	// Get Header Image
	$header_image = page_header(get_post_meta($post_id, 'qns_page_header_image_url', true));
	
	// Get Content ID/Class
	$content_id_class = content_id_class(get_post_meta($post_id, 'qns_page_sidebar', true));
	
	// Reset Query
	wp_reset_query();

?>

<div id="page-header" <?php echo $header_image; ?>>
	<h2><?php the_title(); ?></h2>
</div>

<!-- BEGIN .content-wrapper -->
<div class="content-wrapper clearfix">
	
	<!-- BEGIN .main-content -->
	<div class="<?php echo $content_id_class; ?> page-content">
			
		<?php if ( post_password_required() ) {
			echo qns_password_form();
		} else { ?>
			
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

				<div id="post-<?php the_ID(); ?>" <?php post_class("blog-entry-single clearfix"); ?>>

					<?php if( has_post_thumbnail() ) { ?>		
						<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
							<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'image-style7' ); ?>
							<?php echo '<img src="' . $src[0] . '" alt="" class="blog-image" />'; ?>
						</a>	
					<?php } ?>

					<div class="blog-meta"><?php _e('By','qns'); ?> <?php the_author_posts_link(); ?> / <?php the_time('jS F, Y'); ?> / <?php the_category(', '); ?> / <?php comments_popup_link( 
						__( 'No Comments', 'qns' ), 
						__( '1 Comment', 'qns' ), 
						__( '% Comments', 'qns' ), 
						'',
						__( 'Off','qns')
					); ?></div>

					<?php the_content(); ?>
					
					<p class="post-tags"><?php the_tags( __('Tags: ','qns'), ', ', '' ); ?></p>
					
					<?php 
						wp_link_pages( array( 
							'before' => '<div class="page-pagination">', 
							'after' => '</div>', 
							'link_before' => '<span class="page">', 
							'link_after' => '</span>'
						) ); 
					?>

				</div>

			<?php endwhile; endif; ?>
		
			<?php if ( comments_open() ) :
				comments_template();
			endif; ?>

			<?php } ?>

			<!-- END .main-content -->	
			</div>

			<?php get_sidebar(); ?>

		<!-- END .content-wrapper -->
		</div>

		<?php get_footer(); ?>