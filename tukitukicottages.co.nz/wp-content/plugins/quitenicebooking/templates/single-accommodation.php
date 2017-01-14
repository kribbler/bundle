<?php get_header(); ?>

<?php
// display the header image
global $post;
$header_image = page_header(get_post_meta($post->ID, 'qns_page_header_image_url', true));
$content_id_class = content_id_class(get_post_meta($post->ID, 'qns_page_sidebar', true));
wp_reset_query();
// get the maximum persons in form option
$quitenicebooking_max_persons_in_form = get_option('quitenicebooking');
$quitenicebooking_max_persons_in_form = $quitenicebooking_max_persons_in_form['max_persons_in_form'];
?>

<div id="page-header" <?php echo $header_image; ?>>
	<h2><?php the_title(); ?></h2>
</div>

<!-- BEGIN .content-wrapper -->
<div class="content-wrapper clearfix">
	
	<!-- BEGIN .main-content -->
	<div class="main-content left-main-content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
			<?php $attachments = get_post_meta($post->ID, '_slideshow_images', true); // get attachments ?>
			<?php if ( $attachments ) : ?>
				<!-- BEGIN .slider -->
				<div class="slider accommodation-slider">
					<!-- BEGIN .slides -->
					<ul class="slides">
						<?php $attachments_array = array_filter(explode( ',', $attachments )); ?>
						<?php if ($attachments_array) : // display attachments ?>
							<?php foreach ($attachments_array as $attachment_id) : ?>
								<?php $link = wp_get_attachment_link($attachment_id, 'accommodation-full', false); ?>
									<li>
										<?php echo $link; ?>
										<?php if (get_post_field('post_excerpt', $attachment_id) != '') : ?>
											<?php echo '<div class="flex-caption">' . get_post_field('post_excerpt', $attachment_id) . '</div>'; ?>
										<?php endif; ?>
									</li>
							<?php endforeach; ?>
						 <?php endif; ?>
					<!-- END .slides -->
					</ul>
				<!-- END .slider -->
				</div>
			<?php endif; // attachments ?>
				
			<!-- BEGIN .page-content -->
			<div class="page-content">
				<h3 class="title-style1"><?php _e('Room Description', 'quitenicebooking'); ?><span class="title-block"></span></h3>
				<?php the_content(); ?>
				<hr class="space1" />
				
				<!-- BEGIN .tabs -->
				<div class="tabs">
					<ul class="nav clearfix">
						<?php foreach (range(1, 5) as $r) : ?>
							<?php $tab_title[$r] = get_post_meta($post->ID, 'quitenicebooking_tab_'.$r.'_title', TRUE); ?>
							<?php $tab_content[$r] = get_post_meta($post->ID, 'quitenicebooking_tab_'.$r.'_content', TRUE); ?>
						<?php endforeach; ?>
						
						<?php foreach (range(1, 5) as $r) : ?>
							<?php if ($tab_title[$r]) : ?>
								<li><a href="#tabs-tab-title-<?php echo $r; ?>"><?php echo $tab_title[$r]; ?></a></li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
					
					<?php foreach (range(1, 5) as $r) : ?>
						<?php if ($tab_title[$r]) : ?>
							<div id="tabs-tab-title-<?php echo $r; ?>">
								<?php echo do_shortcode($tab_content[$r]); ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>

				<!-- END .tabs -->
				</div>
				
			<!-- END .page-content -->
			</div>
			
		<?php endwhile; endif; ?>
	<!-- END .main-content -->
	</div>
	
	<!-- BEGIN .sidebar -->
	<div class="sidebar right-sidebar">
		
		<!-- BEGIN .widget -->
		<div class="widget">
			<h4 class="title-style3"><?php _e('Reserve This Room', 'quitenicebooking'); ?><span class="title-block"></span></h4>
			
			<?php $quitenicebooking_settings = get_option('quitenicebooking'); ?>
			<!-- BEGIN .widget-reservation-box -->
			<div class="widget-reservation-box">
				<form class="booking-form" action="<?php echo get_permalink($quitenicebooking_settings['step_1_page_id']); ?>" method="POST">
					<div class="room-price-widget">
						<p class="from"><?php _e('Room', 'quitenicebooking'); ?></p>
						<h3 class="price">
							<?php 
								if ($quitenicebooking_settings['entity_scheme'] == 'per_room') {
									echo Quitenicebooking_Utilities::format_price(number_format(min(get_post_meta($post->ID, 'quitenicebooking_price_per_room_weekday', TRUE), get_post_meta($post->ID, 'quitenicebooking_price_per_room_weekend', TRUE))), $quitenicebooking_settings);
								} else {
									echo Quitenicebooking_Utilities::format_price(number_format(min(get_post_meta($post->ID, 'quitenicebooking_price_per_adult_weekday', TRUE), get_post_meta($post->ID, 'quitenicebooking_price_per_adult_weekend', TRUE))), $quitenicebooking_settings);
								}
							?>
						</h3>
						<p class="price-detail"><?php _e('Per Night', 'quitenicebooking') ?></p> 
					</div>
				
					<input type="text" id="datefrom" name="room_all_checkin" value="<?php _e('Check In', 'quitenicebooking'); ?>" class="datepicker">
					<input type="text" id="dateto" name="room_all_checkout" value="<?php _e('Check Out','quitenicebooking'); ?>" class="datepicker">
					
					<div class="select-wrapper">
						<select id="room_1_adults" name="room_1_adults">
							<option value="0" selected><?php _e('Adults', 'quitenicebooking'); ?></option>
							<?php foreach (range(0, $quitenicebooking_max_persons_in_form) as $r) { ?>
								<option value="<?php echo $r; ?>"><?php echo $r; ?></option>
							<?php } ?>
						</select>
					</div>
					
					<?php if (empty($quitenicebooking_settings['remove_children'])) { ?>
					<div class="select-wrapper">
						<select id="room_1_children" name="room_1_children">
							<option value="0" selected><?php _e('Children', 'quitenicebooking'); ?></option>
							<?php foreach (range(0, $quitenicebooking_max_persons_in_form) as $r) { ?>
								<option value="<?php echo $r; ?>"><?php echo $r; ?></option>
							<?php } ?>
						</select>
					</div>
					<?php } else { ?>
					<input type="hidden" name="room_1_children" value="0" />
					<?php } ?>
					
					<input type="hidden" name="room_qty" value="1" />
					<input type="hidden" name="highlight" value="<?php echo $post->ID; ?>" />
					<input class="bookbutton" name="booking_step_1_submit" type="submit" value="<?php _e('Check Availability', 'quitenicebooking'); ?>" />
				</form>
				<?php if (!empty($quitenicebooking_settings['multiroom_link'])) { ?>
				<p class="multiroom-link"><a href="<?php echo get_permalink($quitenicebooking_settings['step_1_page_id']); ?>"><?php _e('Multi-room booking?', 'quitenicebooking'); ?></a></p>
				<?php } ?>
			<!-- END .widget-reservation-box -->
			</div>
		<!-- END .widget -->
		</div>
		
		<!-- BEGIN .widget -->
		<?php if ($quitenicebooking_settings['phone_number'] || $quitenicebooking_settings['fax_number'] || $quitenicebooking_settings['email_address']) { ?>
		<div class="widget">
			<h4 class="title-style3"><?php _e('Direct Reservations', 'quitenicebooking'); ?><span class="title-block"></span></h4>

			<ul class="contact_details_list">
				<?php if ($quitenicebooking_settings['phone_number']) { ?>
					<li class="phone_list"><strong><?php _e('Phone', 'quitenicebooking'); ?>:</strong> <?php echo $quitenicebooking_settings['phone_number']; ?></li>
				<?php } ?>

				<?php if ($quitenicebooking_settings['fax_number']) { ?>
					<li class="fax_list"><strong><?php _e('Fax', 'quitenicebooking'); ?>:</strong> <?php echo $quitenicebooking_settings['fax_number']; ?></li>	
				<?php } ?>

				<?php if ($quitenicebooking_settings['email_address']) { ?>
					<li class="email_list"><strong><?php _e('Email', 'quitenicebooking'); ?>:</strong> <a href="mailto:<?php echo $quitenicebooking_settings['email_address']; ?>"><?php echo $quitenicebooking_settings['email_address']; ?></a></li>
				<?php } ?>
			</ul>
		<!-- END .widget -->
		</div>
		<?php } ?>
		
	<!-- END .sidebar -->
	</div>
	
<!-- END .content-wrapper -->
</div>

<?php get_footer(); ?>
