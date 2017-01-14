<?php

	//Display Header
	get_header();
	
	//Get Post ID
	global $wp_query; $post_id = $wp_query->post->ID;
	
	//Get Header Image
	$header_image = page_header(get_post_meta($post_id, 'qns_page_header_image_url', true));
	
	//Get Content ID/Class
	$content_id_class = content_id_class(get_post_meta($post_id, 'qns_page_sidebar', true));
	
	//Reset Query
	wp_reset_query();
	
?>

<div id="page-header" <?php echo $header_image; ?>>
	<h2><?php the_title(); ?></h2>
</div>

<!-- BEGIN .content-wrapper -->
<div class="content-wrapper clearfix">
	
	<!-- BEGIN .main-content -->
	<div class="<?php echo $content_id_class; ?> page-content">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php the_content(); ?>			
			<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'qns').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>			
			<?php if ( comments_open() ) : comments_template(); endif; ?>
		<?php endwhile;endif; ?>
		
	<!-- END .main-content -->	
	</div>

	<?php get_sidebar(); ?>

<!-- END .content-wrapper -->
</div>

<?php get_footer(); ?>