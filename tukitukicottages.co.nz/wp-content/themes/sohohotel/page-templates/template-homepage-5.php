<?php
	
	/* 
	Template Name: Homepage 5
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
	
<!-- BEGIN .content-wrapper -->
</div>



<?php
/* ------------------------------------------------
	Display Testimonials Slider
------------------------------------------------ */
?>

<div class="dark-wrapper clearfix">
	<div class="content-wrapper">
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
					
				</ul>
			</div>
		</div>
	</div>
</div>



<?php
/* ------------------------------------------------
	Display Blog Slider
------------------------------------------------ */
?>

<hr class="space1" />

<!-- BEGIN .content-wrapper -->
<div class="content-wrapper">

<h3 class="title-style1"><?php _e('Blog','qns'); ?><span class="title-block"></span></h3>

<div class="text-slider-wrapper">

	<!-- BEGIN .slider -->
	<div class="text-slider">
		<ul class="slides">

			<?php $count = 0;
			
			$args = array(
				'post_type' => 'post',
				'posts_per_page' => '10'
			);

			$blog_posts = new WP_Query($args);

			if($blog_posts->have_posts()) : 
				while($blog_posts->have_posts()) : 
					$blog_posts->the_post(); ?>

					<?php $current_num = $blog_posts->current_post + 1; ?>

					<?php if ( $blog_posts->current_post == 0 ) {
						echo '<li>';
					} elseif ( $blog_posts->current_post % 2 == 0 ) {
						echo '<li>';
					} ?>

					<!-- BEGIN .one-half -->
					<div class="one-half blog-event-one-half">
		
						<div class="blog-preview">
							
							<?php if( has_post_thumbnail() ) { ?>		
								<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
									<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'image-style1' ); ?>
									<?php echo '<img src="' . $src[0] . '" alt="" class="blog-image-thumb" />'; ?>
								</a>	
							<?php } ?>
							
							<div class="blog-entry-inner<?php if( !has_post_thumbnail() ) {echo ' blog-no-image';} ?>">	
								<h4><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> <span><?php _e('By','qns'); ?> <?php the_author_posts_link(); ?> / <?php the_time('jS F, Y'); ?></span></h4>
								<?php print_excerpt(150); ?>
							</div>
						</div>
		
					<!-- END .one-half -->	
					</div>

					<?php if ( $current_num % 2 == 0 ) {
						echo '</li>';
					} elseif ( $current_num == $blog_posts->post_count ) {
						echo '</li>';
					} ?>

				<?php endwhile; else : ?>
					<p><?php _e('No blog posts have been added yet','qns'); ?></p>
				<?php endif; ?>

		</ul>
		
	<!-- END .text-slider -->
	</div>
	
<!-- END .text-slider -->
</div>

<!-- END .content-wrapper -->
</div>



<?php
/* ------------------------------------------------
	Display Events Slider
------------------------------------------------ */
?>

<hr class="space1" />

<!-- BEGIN .dark-wrapper -->
<div class="dark-wrapper clearfix">

<!-- BEGIN .content-wrapper -->
<div class="content-wrapper">

<h3 class="title-style1"><?php _e('Events','qns'); ?><span class="title-block"></span></h3>

<div class="text-slider-wrapper">

	<!-- BEGIN .slider -->
	<div class="text-slider">
		<ul class="slides">

			<?php $count = 0;
			
			$args = array(
				'post_type' => 'event',
				'posts_per_page' => 10
			);

			$event_posts = new WP_Query($args);
			if($event_posts->have_posts()) : ?>

				<div class="text-slider">
					<ul class="slides">

					<?php while($event_posts->have_posts()) : 
						$event_posts->the_post(); ?>
						
						<?php $current_num = $event_posts->current_post + 1; ?>

						<?php if ( $event_posts->current_post == 0 ) {
							echo '<li>';
						} elseif ( $event_posts->current_post % 2 == 0 ) {
							echo '<li>';
						} ?>

						<?php // Get event date
						$e_date = get_post_meta($post->ID, $prefix.'event_date', true);
						if ( $e_date !== '' ) { 									
							$event_date_string = $e_date;
							$event_monthM = mysql2date( 'M', $event_date_string );
							$event_day = mysql2date( 'd', $event_date_string );
							$event_month = apply_filters('get_the_date', $event_monthM, 'M');
						}
						
						// If no date set
						else { 
							$event_month = "---";
							$event_day = "00";
						}
						
						// Get event time
						$e_time = get_post_meta($post->ID, $prefix.'event_time', true);
						if ( $e_time !== '' ) { $event_time = $e_time; }
						else { $event_time = __('No time set','qns'); }
						
						// Get event location
						$e_location = get_post_meta($post->ID, $prefix.'event_location', true);
						if ( $e_location !== '' ) { $event_location = $e_location; }
						else { $event_location = __('No location set','qns'); } ?>

						<div class="one-half blog-event-one-half">
							<div class="event-preview">	
								<div class="event-date-wrapper">
									<div class="event-month"><?php echo $event_month; ?></div>
									<div class="event-day"><?php echo $event_day; ?></div>
								</div>
								<div class="event-entry-inner">	
									<h4><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a> <span><?php _e('Event Time','qns'); ?>: <i><?php echo $event_time; ?></i> / <?php _e('Event Location','qns'); ?>: <i><?php echo $event_location; ?></i></span></h4>
									<?php print_excerpt(150); ?>
								</div>
							</div>
						</div>

						<?php if ( $current_num % 2 == 0 ) {
							echo '</li>';
						} elseif ( $current_num == $event_posts->post_count ) {
							echo '</li>';
						} ?>

					<?php endwhile; ?>
					
					</ul>
				</div>
					
			<?php else : ?>
				<p><?php _e('No events have been added yet!','qns'); ?></p>
			<?php endif; ?>

		</ul>
		
	<!-- END .text-slider -->
	</div>
	
<!-- END .text-slider -->
</div>

<!-- END .content-wrapper -->
</div>

<!-- END .dark-wrapper -->
</div>



<?php if ( $smof_data['homepage_photo_slider'] ) { ?>
<hr class="space1" />

<!-- BEGIN .content-wrapper -->
<div class="content-wrapper">

<h3 class="title-style1"><?php _e('Photo Gallery','qns'); ?><span class="title-block"></span></h3>

<div class="text-slider-wrapper">

	<!-- BEGIN .slider -->
	<div class="text-slider">
		
		<ul class="slides">
			<?php echo do_shortcode($smof_data['homepage_photo_slider']); ?>
		</ul>
		
	<!-- END .text-slider -->
	</div>
	
<!-- END .text-slider -->
</div>

<!-- END .content-wrapper -->
</div>
<?php } ?>



<?php get_footer(); ?>