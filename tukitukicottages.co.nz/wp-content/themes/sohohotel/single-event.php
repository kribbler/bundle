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
	
			<?php if ( post_password_required() ) {
				echo qns_password_form();
			} else { ?>
			
			<?php if( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
		
				
					<?php // Get event date
					$e_date = get_post_meta($post->ID, 'qns_event_date', true);
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
					$e_time = get_post_meta($post->ID, 'qns_event_time', true);
					if ( $e_time !== '' ) { $event_time = $e_time; }
					else { $event_time = __('No time set','qns'); }

					// Get event location
					$e_location = get_post_meta($post->ID, 'qns_event_location', true);
					if ( $e_location !== '' ) { $event_location = $e_location; }
					else { $event_location = __('No location set','qns'); } ?>

					<div class="event-entry clearfix">
						
						<?php if( has_post_thumbnail() ) { ?>		
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>">
								<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'image-style7' ); ?>
								<?php echo '<img src="' . $src[0] . '" alt="" class="event-image" />'; ?>
							</a>	
						<?php } ?>
						
						<div class="event-date-wrapper">
							<div class="event-month"><?php echo $event_month; ?></div>
							<div class="event-day"><?php echo $event_day; ?></div>	
						</div>

						<div class="event-inner-wrapper">
							<div class="event-meta"><?php _e('Event Time','qns') ?>: <i><?php echo $event_time; ?></i> / <?php _e('Event Location','qns');?>: <i><?php echo $event_location; ?></i></div>
							
							<?php the_content(); ?>
							
						</div>

					</div>
				
		

				<?php endwhile; ?>
					
			<?php endif; ?>
		
			<?php } ?>
		
			<!-- END .main-content -->	
			</div>

			<?php get_sidebar(); ?>

		<!-- END .content-wrapper -->
		</div>

		<?php get_footer(); ?>