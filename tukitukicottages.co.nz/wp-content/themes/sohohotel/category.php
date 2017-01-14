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
	<h2><?php echo single_cat_title( '', false ); ?></h2>
</div>

<!-- BEGIN .content-wrapper -->
<div class="content-wrapper clearfix">
	
	<!-- BEGIN .main-content -->
	<div class="<?php echo $content_id_class; ?> page-content">

		<?php if ( have_posts() ) : ?>

			<?php if ( category_description() ) : ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
			<?php endif; ?>

			<ul class="article-category-col-1 clearfix">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'loop', 'style1' ); ?>
				<?php endwhile; ?>
			</ul>

			<?php load_template( get_template_directory() . '/includes/pagination.php' ); ?>

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>
		
	<!-- END .main-content -->	
	</div>

	<?php get_sidebar(); ?>

<!-- END .content-wrapper -->
</div>

<?php get_footer(); ?>