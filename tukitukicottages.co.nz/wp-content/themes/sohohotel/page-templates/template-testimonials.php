<?php
	
	/* 
	Template Name: Testimonials
	*/
	
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
				
		<?php the_content(); ?>
				
		<?php
					
			if( $smof_data['items_per_page'] ) { 
				$testimonial_perpage = $smof_data['items_per_page'];
			}
			else {
				$testimonial_perpage = '10';
			}
				
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
					
			$args = array(
				'post_type' => 'testimonial',
				'posts_per_page' => $testimonial_perpage,
				'paged' => $paged
			);

			$testimonial_posts = new WP_Query($args);

			if($testimonial_posts->have_posts()) : 
				while($testimonial_posts->have_posts()) : 
					$testimonial_posts->the_post(); ?>

					<?php	
						// Get testimonial date
						$testimonial_guest = get_post_meta($post->ID, $prefix.'testimonial_guest', true);
						$testimonial_room = get_post_meta($post->ID, $prefix.'testimonial_room', true);			
					?>

					<div class="testimonial-wrapper clearfix">
							
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

					<p class="testimonial-author"><?php echo $testimonial_guest; ?> - <span><?php echo $testimonial_room ?></span></p>
					<hr class="space1" />
							
				<?php endwhile; else : ?>

					<p><?php _e('No testimonials have been added yet','qns'); ?></p>
					
				<?php endif; ?>

			<?php // Include Pagination feature
				load_template( get_template_directory() . '/includes/pagination.php' );
			?>	
					
			<!-- END .main-content -->	
			</div>

			<?php get_sidebar(); ?>

		<!-- END .content-wrapper -->
		</div>

<?php get_footer(); ?>