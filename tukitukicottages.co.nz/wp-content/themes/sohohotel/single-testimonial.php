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

<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	<?php
		$testimonial_guest = get_post_meta($post->ID, $prefix.'testimonial_guest', true);
		$testimonial_room = get_post_meta($post->ID, $prefix.'testimonial_room', true);
	?>

<div id="page-header" <?php echo $header_image; ?>>
	<h2><?php echo $testimonial_guest; ?> - <span><?php echo $testimonial_room; ?></h2>
</div>

<?php endwhile;endif; ?>

<!-- BEGIN .content-wrapper -->
<div class="content-wrapper clearfix">
	
	<!-- BEGIN .main-content -->
	<div class="<?php echo $content_id_class; ?> page-content">
		
		<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		
			<div class="testimonial-wrapper testimonial-single clearfix">
					
				<div class="testimonial-image">
					
				<?php				
					if(has_post_thumbnail()) {
						$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'image-style2' );
						echo '<img src="' . $src[0] . '" alt="" />';
					}
					else {
						echo '<img src="' . get_template_directory_uri() .'/images/user.png" alt="" />';
					}			
				?>
				</div>

				<div class="testimonial-text"><?php the_content(); ?></div>
				<div class="testimonial-speech"></div>
		
			</div>
		
		<?php endwhile;endif; ?>
		
	<!-- END .main-content -->	
	</div>

	<?php get_sidebar(); ?>

<!-- END .content-wrapper -->
</div>

<?php get_footer(); ?>