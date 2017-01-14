<?php
	
	/* 
	Template Name: Events
	*/

	// Get Theme Options
	global $smof_data;

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
	<div class="<?php echo $content_id_class; ?>" style="width: 100%;">

			<?php the_content(); ?>
			
			<?php if( $smof_data['event_items_pp'] ) { 
				$event_perpage = $smof_data['event_items_pp'];
			}
			
			else {
				$event_perpage = '10';
			}
			
			$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;	
				
			$args = array(
				
				'post_type' => 'event',
				'posts_per_page' => $event_perpage,
				'paged' => $paged,
				'meta_key' => 'qns_event_date',
				'orderby' => 'meta_value',
				'order' => !empty($smof_data['event_order']) ? ($smof_data['event_order'] == 'Oldest First' ? 'ASC' : 'DESC') : 'ASC',
				'meta_query' => array(
					array(
						'key' => 'qns_event_date',
						'value' => !empty($smof_data['event_show_past']) ? 0 : date('Y-m-d'),
						'compare' => !empty($smof_data['event_show_past']) ? '>=' :'>=',
						'type' => 'DATE'
					)
				)
				
			);

			$wp_query = new WP_Query($args);

			if($wp_query->have_posts()) : ?>
				
					<?php while($wp_query->have_posts()) : 
						$wp_query->the_post(); ?>

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

						<div class="event-entry clearfix">
							
							<?php if( has_post_thumbnail() ) { ?>		
								<a href="" rel="bookmark" title="<?php the_title_attribute(); ?>">
									<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'image-style7' ); ?>
									<?php echo '<img src="' . $src[0] . '" alt="" class="event-image" />'; ?>
								</a>	
							<?php } ?>
							
							<div class="event-date-wrapper">
								<div class="event-month"><?php echo $event_month; ?></div>
								<div class="event-day"><?php echo $event_day; ?></div>	
							</div>

							<div class="event-inner-wrapper">
								<h3 class="event-title"><?php the_title(); ?></h3>
								<div class="event-meta"><?php _e('Event Time','qns') ?>: <i><?php echo $event_time; ?></i> / <?php _e('Event Location','qns');?>: <i><?php echo $event_location; ?></i></div>
								
								<?php global $more;$more = 0;?>
								<?php the_content(__('Event Details', 'qns')); ?>
								
							</div>

						</div>

					<?php endwhile; else : ?>
					<p><?php _e('No events have been added yet!','qns'); ?></p>
				
				<?php endif; ?>
				
			<?php load_template( get_template_directory() . '/includes/pagination.php' ); ?>

			<!-- END .main-content -->	
			</div>

		<!--	<?php get_sidebar(); ?>  -->

		<!-- END .content-wrapper -->
		</div>

		<?php get_footer(); ?>