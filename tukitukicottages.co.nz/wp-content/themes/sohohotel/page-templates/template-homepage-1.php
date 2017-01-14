<?php
	
	/* 
	Template Name: Homepage 1
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



/* ------------------------------------------------
	Display Slideshow
------------------------------------------------ */

if ($smof_data['slideshow_display']) { ?>

<!-- BEGIN #slider -->
<div id="slider">

	<?php if ($smof_data['homepage_slider']) { ?>

		<div class="slider">
			<ul class="slides">
				<?php $slides = $smof_data['homepage_slider']; ?>	
				<?php foreach ($slides as $slide) { ?>
					<li>
						<?php if ( $slide['link'] ) { echo '<a href="' . $slide['link'] . '" target="_blank" class="slide-link">'; } ?>
						<img src="<?php echo $slide['url']; ?>" alt="" />
						<?php if ( $slide['description'] ) { 
							echo '<div class="slider-caption-wrapper"><div class="slider-caption">' . $slide['description'] . '</div></div>'; 
						} ?>
						<?php if ( $slide['link'] ) { echo '</a>'; } ?>
					</li>
				<?php } ?>
			</ul>
		</div>

	<?php } else { ?>
		<p><?php _e('No Slides','qns'); ?></p>
	<?php }



/* ------------------------------------------------
	Display Slideshow Booking Form
------------------------------------------------ */

if(is_plugin_active('quitenicebooking/quitenicebooking.php')) {
	if ( $smof_data['display_slideshow_booking'] ) {echo do_shortcode("[booking_form]");}
} ?>

<!-- END #slider -->
</div>
<div class="accommodation-custom-button"><a href="http://www.tukitukicottages.co.nz/accommodation/"><img src="http://www.tukitukicottages.co.nz/wp-content/uploads/2014/02/tukitukibook.png" style="width: 100%; height: auto;"></a></div>
<?php } else { ?>
	<hr class="space1" />
<?php }



/* ------------------------------------------------
	Display Three Blocks
------------------------------------------------ */
?>

<!-- BEGIN .content-wrapper -->
<div class="content-wrapper clearfix">
	
	<!-- BEGIN .clearfix -->
	<div class="clearfix">

		<!-- BEGIN .one-third -->
		<div class="one-third clearfix">
	
			<?php if ($smof_data['homepage_block_title_1'] ) { ?>
				<h3 class="title-style1"><?php _e($smof_data['homepage_block_title_1'],'qns'); ?><span class="title-block"></span></h3>
			<?php } ?>
			
			<?php echo do_shortcode($smof_data['homepage_block_content_1']); ?>
			
			<?php if ($smof_data['homepage_block_button_1'] ) { ?>
				<p><a href="<?php _e($smof_data['homepage_block_link_1'],'qns'); ?>" class="button1"><?php _e($smof_data['homepage_block_button_1'],'qns'); ?></a></p>
			<?php } ?>
	
		<!-- END .one-third -->	
		</div>
		
		<!-- BEGIN .one-third -->
		<div class="one-third clearfix">
	
			<?php if ($smof_data['homepage_block_title_2'] ) { ?>
				<h3 class="title-style1"><?php _e($smof_data['homepage_block_title_2'],'qns'); ?><span class="title-block"></span></h3>
			<?php } ?>
			
			<?php echo do_shortcode($smof_data['homepage_block_content_2']); ?>
			
			<?php if ($smof_data['homepage_block_button_2'] ) { ?>
				<p><a href="<?php _e($smof_data['homepage_block_link_2'],'qns'); ?>" class="button1"><?php _e($smof_data['homepage_block_button_2'],'qns'); ?></a></p>
			<?php } ?>
	
		<!-- END .one-third -->	
		</div>
		
		<!-- BEGIN .one-third -->
		<div class="one-third last-col clearfix">
	
			<?php if ($smof_data['homepage_block_title_3'] ) { ?>
				<h3 class="title-style1"><?php _e($smof_data['homepage_block_title_3'],'qns'); ?><span class="title-block"></span></h3>
			<?php } ?>
			
			<?php echo do_shortcode($smof_data['homepage_block_content_3']); ?>
			
			<?php if ($smof_data['homepage_block_button_3'] ) { ?>
				<p><a href="<?php _e($smof_data['homepage_block_link_3'],'qns'); ?>" class="button1"><?php _e($smof_data['homepage_block_button_3'],'qns'); ?></a></p>
			<?php } ?>
	
		<!-- END .one-third -->	
		</div>

	<!-- END .clearfix -->
	</div>
	
	<hr class="space1" />



<?php
/* ------------------------------------------------
	Display Testimonials Slider
------------------------------------------------ */
?>
	
	<h3 class="title-style1"><?php _e('Testimonials','qns'); ?><span class="title-block"></span></h3>
	<div class="text-slider-wrapper">
		<div class="text-slider">
			<ul class="slides">
		
				<?php $count = 0;
		
				$args = array(
					'post_type' => 'testimonial',
					'posts_per_page' => '10'
				);

				$testimonial_posts = new WP_Query($args);

				if($testimonial_posts->have_posts()) : 
					while($testimonial_posts->have_posts()) : 
						$testimonial_posts->the_post(); ?>

						<?php $current_num = $testimonial_posts->current_post + 1; ?>

						<?php if ( $testimonial_posts->current_post == 0 ) {
							echo '<li>';
						} elseif ( $testimonial_posts->current_post % 2 == 0 ) {
							echo '<li>';
						} ?>

						<?php	
							// Get testimonial date
							$testimonial_guest = get_post_meta($post->ID, $prefix.'testimonial_guest', true);
							$testimonial_room = get_post_meta($post->ID, $prefix.'testimonial_room', true);			
						?>

						<div class="one-half testimonial-one-half">
							<div class="testimonial-wrapper clearfix">
								<div class="testimonial-image">
								
								<?php if(has_post_thumbnail()) {
									$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'image-style2' );
									echo '<img src="' . $src[0] . '" alt="" />';
								}
									
								else {
									echo '<img src="' . get_template_directory_uri() .'/images/user.png" alt="" />';
								} ?>
								
								</div>
								<div class="testimonial-text"><?php the_content(); ?></div>
								<div class="testimonial-speech"></div>
							</div>
							<p class="testimonial-author"><?php echo $testimonial_guest; ?> - <span><?php echo $testimonial_room ?></span></p>
						</div>

						<?php if ( $current_num % 2 == 0 ) {
							echo '</li>';
						} elseif ( $current_num == $testimonial_posts->post_count ) {
							echo '</li>';
						} ?>

					<?php endwhile; else : ?>
						<p><?php _e('No testimonials have been added yet','qns'); ?></p>
					<?php endif; ?>

				</li>
			</ul>
		</div>
	</div>
<div style="margin-bottom: 10px; margin-top: 25px; float: right;"><a href="http://www.tukitukicottages.co.nz/testimonials/"><img src="http://www.tukitukicottages.co.nz/wp-content/uploads/2014/04/tukitukitestimonial.png" style="width: 100%; max-width: 300px; height: auto;"></a></div>
<!-- BEGIN .content-wrapper -->
</div>

<?php get_footer(); ?>