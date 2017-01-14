<?php
	
	/* 
	Template Name: Blog
	*/
	
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
	<div class="<?php echo $content_id_class; ?>">
		
		<?php if( $smof_data['posts_per_page'] ) { 
			$posts_per_page = $smof_data['posts_per_page'];
		}
		
		else {
			$posts_per_page = 'posts_per_page';
		} ?>
		
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