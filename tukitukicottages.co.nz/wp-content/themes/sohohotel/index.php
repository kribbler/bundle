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
	<h2><?php _e('Blog','qns') ?></h2>
</div>

<!-- BEGIN .content-wrapper -->
<div class="content-wrapper clearfix">
	
	<!-- BEGIN .main-content -->
	<div class="<?php echo $content_id_class; ?> page-content">

		<?php $paged = (get_query_var('paged')) ? get_query_var('paged') : 1; ?>
		<?php query_posts( "post_type=post&paged=" . $paged . "&posts_per_page=" . $posts_per_page ); ?>
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'loop', 'style1' ); ?>
			<?php endwhile; ?>
		<?php endif; ?>
		<?php load_template( get_template_directory() . '/includes/pagination.php' ); ?>
		
	<!-- END .main-content -->	
	</div>

	<?php get_sidebar(); ?>

<!-- END .content-wrapper -->
</div>

<?php get_footer(); ?>