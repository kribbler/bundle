<style>
	.booking-form-notice {
		display: block;
	}
</style>
<!-- BEGIN .booking-step-wrapper -->
<div class="booking-step-wrapper clearfix">

	<div class="step-wrapper">
		<div class="step-icon-wrapper">
			<div class="step-icon">1.</div>
		</div>
		<div class="step-title"><?php _e('Choose Your Date','quitenicebooking'); ?></div>
	</div>

	<div class="step-wrapper">
		<div class="step-icon-wrapper">
			<div class="step-icon step-icon-current">2.</div>
		</div>
		<div class="step-title"><?php _e('Choose Your Room','quitenicebooking'); ?></div>
	</div>

	<div class="step-wrapper">
		<div class="step-icon-wrapper">
			<div class="step-icon">3.</div>
		</div>
		<div class="step-title"><?php _e('Place Your Reservation','quitenicebooking'); ?></div>
	</div>

	<div class="step-wrapper last-col">
		<div class="step-icon-wrapper">
			<div class="step-icon">4.</div>
		</div>
		<div class="step-title"><?php _e('Confirmation','quitenicebooking'); ?></div>
	</div>

	<div class="step-line"></div>

<!-- END .booking-step-wrapper -->
</div>

<!-- BEGIN .booking-main-wrapper -->
<div class="booking-main-wrapper">
	
	<?php if ( isset( $quitenicebooking_highlight ) && ! empty( $quitenicebooking_highlight ) ) { ?>
		<!-- BEGIN .booking-main -->
		<div class="booking-main booking-main-highlight">
			<?php $highlight_found = FALSE; ?>
			<?php foreach ( $quitenicebooking_available_rooms as $r ) { ?>
				<?php if ( $r['id'] == $quitenicebooking_highlight ) { ?>
					<?php $highlight_found = TRUE; ?>
					<?php $room = $r; ?>
					<?php break; ?>
				<?php } ?>
			<?php } ?>
			<?php if ( ! $highlight_found ) { ?>
				<?php $room = $quitenicebooking_highlight_room[$quitenicebooking_highlight]; ?>
			<?php } ?>
			
			<h4 class="title-style4">
				<?php if ( $highlight_found ) { ?>
					<?php _e('Your Chosen Room Is Available','quitenicebooking'); ?><span class="title-block"></span>
				<?php } else { ?>
					<?php _e('Sorry, Your Chosen Room Is Unavailable','quitenicebooking'); ?><span class="title-block"></span>
				<?php } ?>
			</h4>
			
			<?php if ( $highlight_found ) { ?>
			<form action="<?php echo $quitenicebooking_step_2_url; ?>" method="POST">
				<input type="hidden" name="booking_step_2_submit" value="1">
			<?php } ?>
				
				<!-- BEGIN .room-list-wrapper -->
				<ul class="room-list-wrapper clearfix">

					<!-- BEGIN .room-item -->
					<li class="room-item clearfix <?php echo !$highlight_found ? 'room-unavailable' : ''; ?>">

						<h5><?php echo $room['title']; ?></h5>

						<!-- BEGIN .room-list-left -->
						<div class="room-list-left">
							<?php if (isset($room['_thumbnail_id'])) { ?>
								<?php $thumbnail = wp_get_attachment_image_src($room['_thumbnail_id'], 'image-style3'); ?>
								<img src="<?php echo $thumbnail[0]; ?>" alt="" />
							<?php } ?>
						<!-- END .room-list-left -->
						</div>

						<!-- BEGIN .room-list-right -->
						<div class="room-list-right">

							<!-- BEGIN .room-meta -->
							<div class="room-meta">
								<ul>
									<?php if (!empty($room['quitenicebooking_num_bedrooms']) && $room['quitenicebooking_num_bedrooms'] > 1) { ?>
										<li>
											<span><?php _e('Number of Bedrooms', 'quitenicebooking'); ?>:</span> <?php echo $room['quitenicebooking_num_bedrooms']; ?>
										</li>
									<?php } ?>
									<?php if (!empty($room['quitenicebooking_max_occupancy'])) { ?>
										<li><span><?php _e('Occupancy', 'quitenicebooking'); ?>:</span> <?php echo $room['quitenicebooking_max_occupancy']; ?> <?php echo _n('Person', 'Persons', $room['quitenicebooking_max_occupancy'], 'quitenicebooking'); ?></li>
									<?php } ?>
									<?php if (!empty($room['quitenicebooking_room_size'])) { ?>
										<li><span><?php _e('Size', 'quitenicebooking'); ?>: </span><?php echo $room['quitenicebooking_room_size']; ?></li>
									<?php } ?>
									<?php if (!empty($room['quitenicebooking_room_view'])) { ?>
										<li><span><?php _e('View', 'quitenicebooking'); ?>: </span><?php echo $room['quitenicebooking_room_view']; ?></li>
									<?php } ?>
								</ul>
							<!-- END .room-meta -->
							</div>

							<!-- BEGIN .room-price -->
							<div class="room-price">
								<p class="price"><?php _e('From', 'quitenicebooking'); ?>: <span><?php echo Quitenicebooking_Utilities::format_price($quitenicebooking_entity_scheme == 'per_person' ? min($room['quitenicebooking_price_per_adult_weekday'], $room['quitenicebooking_price_per_adult_weekend']) : min($room['quitenicebooking_price_per_room_weekday'], $room['quitenicebooking_price_per_room_weekend'] ), $this->settings); ?></span> / <?php _e('Night', 'quitenicebooking'); ?> </p>
								<?php if ( $highlight_found ) { ?>
									<p class="price-breakdown"><a href="#price_break_hotel_room_<?php echo $room['id']; ?>" rel="prettyPhoto"><?php _e('Price Breakdown', 'quitenicebooking'); ?></a></p>
								<?php } else { ?>
									<p class="price-breakdown"><span><?php _e('Price Breakdown', 'quitenicebooking'); ?></span></p>
								<?php } ?>
									
								<?php if ( $highlight_found ) { ?>
									<!-- BEGIN #price_break_hotel_room -->
									<div id="price_break_hotel_room_<?php echo $room['id']; ?>" class="hide">
									
										<!-- BEGIN .lightbox-title -->
										<div class="lightbox-title">
											<h4 class="title-style4"><?php _e('Price Breakdown','quitenicebooking'); ?><span class="title-block"></span></h4>
										<!-- END .lightbox-title -->
										</div>
										
										<!-- BEGIN .page-content -->
										<div class="page-content">
											
											<table><tbody>
												<?php foreach ($room['price_breakdown']['breakdown'] as $day) { ?>
													<tr>
														<td data-title="<?php _e('Date', 'quitenicebooking'); ?>"><?php echo $day['date_string']; ?></td>
														<td data-title="<?php _e('Price', 'quitenicebooking'); ?>"><?php echo $day['price_string']; ?></td>
													</tr>
												<?php } // end foreach ?>
												<tr>
													<td></td>
													<td><?php _e('Total', 'quitenicebooking'); echo ': '.  Quitenicebooking_Utilities::format_price(number_format($room['price_breakdown']['total']), $this->settings); ?></td>
												</tr>
											</tbody></table>
											
										<!-- END .page-content -->
										</div>
									
									<!-- END #price_break_hotel_room -->
									</div>
								<?php } ?>
									
							<!-- END .room-price -->
							</div>

							<div class="clearboth"></div>

							<?php $bed_type_count = 0; ?>

							<?php // if (!isset($room['quitenicebooking_disable_beds']) || empty($room['quitenicebooking_disable_beds'])) { ?>
							<?php if (!isset($room[$quitenicebooking_beds->keys['disabled']['meta_key']]) || empty($room[$quitenicebooking_beds->keys['disabled']['meta_key']])) { ?>

							<?php foreach ($quitenicebooking_beds->keys['beds'] as $bed => $defs) { // display "Select <bed>" buttons ?>
								<?php if (isset($room[$defs['meta_key']]) && !empty($room[$defs['meta_key']])) { ?>
									<?php if ( $highlight_found ) { ?>
										<button type="submit" class="button2" name="room_<?php echo $quitenicebooking_room_number; ?>_selection" value="type=<?php echo $room['id']; ?>&bed=<?php echo $bed; ?>"><?php printf(_x('Select %s', 'Select bed/room button', 'quitenicebooking'), $defs['description']); ?></button>
									<?php } else { ?>
										<span class="button2"><?php printf(_x('Select %s', 'Select bed/room button', 'quitenicebooking'), $defs['description']); ?></span>
									<?php } ?>
									<?php $bed_type_count ++; ?>
								<?php } // end if ?>
							<?php } // end foreach ?>

							<?php } // end if ?>

							<?php if ($bed_type_count == 0) { // display "Select Room" button ?>
								<?php if ( $highlight_found ) { ?>
									<button type="submit" class="button2" name="room_<?php echo $quitenicebooking_room_number; ?>_selection" value="type=<?php echo $room['id']; ?>&bed=0"><?php printf(_x('Select %s', 'Select bed/room button', 'quitenicebooking'), $quitenicebooking_beds->keys['disabled']['description']); ?></button>
								<?php } else { ?>
									<span class="button2"><?php printf(_x('Select %s', 'Select bed/room button', 'quitenicebooking'), $quitenicebooking_beds->keys['disabled']['description']); ?></span>
								<?php } ?>
							<?php } // end if ?>
							<!-- END .bookroom -->

						<!-- END .room-list-right -->
						</div>	
					<!-- END .room-item -->
					</li>

				<!-- END .room-list-wrapper -->
				</ul>
		<?php if ( $highlight_found ) { ?>
			</form>
		<?php } ?>
			
		<!-- END .booking-main -->
		</div>
	<?php } ?>
	
	<!-- BEGIN .booking-main -->
	<div class="booking-main">
		
		<!-- BEGIN .booking-errors -->
		<noscript>
			<div class="dark-notice booking-form-notice">
				<?php _e('Please enable Javascript in your web browser for an optimal browsing experience', 'quitenicebooking'); ?>
			</div>
		</noscript>
		<?php if (isset($quitenicebooking_errors) && count($quitenicebooking_errors) > 0) { ?>
		<div class="dark-notice booking-form-notice">
			<p><strong><?php _e('Please correct the following errors in your booking:', 'quitenicebooking'); ?></strong></p><br>
			<ul>
				<?php foreach ($quitenicebooking_errors as $e) { ?>
					<li><?php echo $e; ?></li>
				<?php } ?>
			</ul>
		</div><br>
		<?php } ?>
		<!-- END .booking-errors -->
		
		<h4 class="title-style4">
			<?php if ( isset( $quitenicebooking_highlight ) && ! empty( $quitenicebooking_highlight ) ) { ?>
				<?php _e('Other Available Rooms','quitenicebooking'); ?><span class="title-block"></span>
			<?php } else { ?>
				<?php _e('Choose Your Room','quitenicebooking'); ?><span class="title-block"></span>
			<?php } ?>
		</h4>
		
		<?php if (count($quitenicebooking_available_rooms) == 0) { ?>
			<p><?php _e('Sorry! There are no rooms available for these dates', 'quitenicebooking'); ?></p>
		<?php } else { ?>
		
			<form action="<?php echo $quitenicebooking_step_2_url; ?>" method="POST">
				<input type="hidden" name="booking_step_2_submit" value="1">
				
				<!-- BEGIN .room-list-wrapper -->
				<ul class="room-list-wrapper clearfix">

					<?php foreach ($quitenicebooking_available_rooms as $room) { ?>
					
						<?php if ( isset( $quitenicebooking_highlight ) && $room['id'] == $quitenicebooking_highlight ) { continue; } // skip over the room if it's been highlighted ?>
					
						<!-- BEGIN .room-item -->
						<li class="room-item clearfix">

							<h5><?php echo $room['title']; ?></h5>
							
							<!-- BEGIN .room-list-left -->
							<div class="room-list-left">
								<?php if (isset($room['_thumbnail_id'])) { ?>
									<?php $thumbnail = wp_get_attachment_image_src($room['_thumbnail_id'], 'image-style3'); ?>
									<img src="<?php echo $thumbnail[0]; ?>" alt="" />
								<?php } ?>
							<!-- END .room-list-left -->
							</div>
							
							<!-- BEGIN .room-list-right -->
							<div class="room-list-right">
							
								<!-- BEGIN .room-meta -->
								<div class="room-meta">
									<ul>
										<?php if (!empty($room['quitenicebooking_num_bedrooms']) && $room['quitenicebooking_num_bedrooms'] > 1) { ?>
											<li>
												<span><?php _e('Number of Bedrooms', 'quitenicebooking'); ?>:</span> <?php echo $room['quitenicebooking_num_bedrooms']; ?>
											</li>
										<?php } ?>
										<?php if (!empty($room['quitenicebooking_max_occupancy'])) { ?>
											<li><span><?php _e('Occupancy', 'quitenicebooking'); ?>:</span> <?php echo $room['quitenicebooking_max_occupancy']; ?> <?php echo _n('Person', 'Persons', $room['quitenicebooking_max_occupancy'], 'quitenicebooking'); ?></li>
										<?php } ?>
										<?php if (!empty($room['quitenicebooking_room_size'])) { ?>
											<li><span><?php _e('Size', 'quitenicebooking'); ?>: </span><?php echo $room['quitenicebooking_room_size']; ?></li>
										<?php } ?>
										<?php if (!empty($room['quitenicebooking_room_view'])) { ?>
											<li><span><?php _e('View', 'quitenicebooking'); ?>: </span><?php echo $room['quitenicebooking_room_view']; ?></li>
										<?php } ?>
									</ul>
								<!-- END .room-meta -->
								</div>
							
								<!-- BEGIN .room-price -->
								<div class="room-price">
									<p class="price"><?php _e('From', 'quitenicebooking'); ?>: <span><?php echo Quitenicebooking_Utilities::format_price($quitenicebooking_entity_scheme == 'per_person' ? min($room['quitenicebooking_price_per_adult_weekday'], $room['quitenicebooking_price_per_adult_weekend']) : min($room['quitenicebooking_price_per_room_weekday'], $room['quitenicebooking_price_per_room_weekend'] ), $this->settings); ?></span> / <?php _e('Night', 'quitenicebooking'); ?> </p>
									<p class="price-breakdown"><a href="#price_break_hotel_room_<?php echo $room['id']; ?>" rel="prettyPhoto"><?php _e('Price Breakdown', 'quitenicebooking'); ?></a></p>
									
									<!-- BEGIN #price_break_hotel_room -->
									<div id="price_break_hotel_room_<?php echo $room['id']; ?>" class="hide">
									
										<!-- BEGIN .lightbox-title -->
										<div class="lightbox-title">
											<h4 class="title-style4"><?php _e('Price Breakdown','quitenicebooking'); ?><span class="title-block"></span></h4>
										<!-- END .lightbox-title -->
										</div>
										
										<!-- BEGIN .page-content -->
										<div class="page-content">
											
											<table><tbody>
												<?php foreach ($room['price_breakdown']['breakdown'] as $day) { ?>
													<tr>
														<td data-title="<?php _e('Date', 'quitenicebooking'); ?>"><?php echo $day['date_string']; ?></td>
														<td data-title="<?php _e('Price', 'quitenicebooking'); ?>"><?php echo $day['price_string']; ?></td>
													</tr>
												<?php } // end foreach ?>
												<tr>
													<td></td>
													<td><?php _e('Total', 'quitenicebooking'); echo ': '.  Quitenicebooking_Utilities::format_price(number_format($room['price_breakdown']['total']), $this->settings); ?></td>
												</tr>
											</tbody></table>
											
										<!-- END .page-content -->
										</div>
									
									<!-- END #price_break_hotel_room -->
									</div>
								<!-- END .room-price -->
								</div>
								
								<div class="clearboth"></div>
								
								<!-- BEGIN .bookroom -->
								<?php // DEBUG Rooms left: <?php echo $room['quitenicebooking_room_quantity']; <br> ?>
								
								<?php $bed_type_count = 0; ?>
								
								<?php if (!isset($room[$quitenicebooking_beds->keys['disabled']['meta_key']]) || empty($room[$quitenicebooking_beds->keys['disabled']['meta_key']])) { ?>
								
								<?php foreach ($quitenicebooking_beds->keys['beds'] as $bed => $defs) { // display "Select <bed>" buttons ?>
									<?php if (isset($room[$defs['meta_key']]) && !empty($room[$defs['meta_key']])) { ?>
										<button type="submit" class="button2" name="room_<?php echo $quitenicebooking_room_number; ?>_selection" value="type=<?php echo $room['id']; ?>&bed=<?php echo $bed; ?>"><?php printf(_x('Select %s', 'Select bed/room button', 'quitenicebooking'), $defs['description']); ?></button>
										<?php $bed_type_count ++; ?>
									<?php } // end if ?>
								<?php } // end foreach ?>
										
								<?php } // end if ?>
								
								<?php if ($bed_type_count == 0) { // display "Select Room" button ?>
									<button type="submit" class="button2" name="room_<?php echo $quitenicebooking_room_number; ?>_selection" value="type=<?php echo $room['id']; ?>&bed=0"><?php printf(_x('Select %s', 'Select bed/room button', 'quitenicebooking'), $quitenicebooking_beds->keys['disabled']['description']); ?></button>
								<?php } // end if ?>
								<!-- END .bookroom -->
		
							<!-- END .room-list-right -->
							</div>	
						<!-- END .room-item -->
						</li>
					<?php } // end foreach ?>
				<!-- END .room-list-wrapper -->
				</ul>
			</form>

		<?php } // end else ?>
	<!-- END .booking-main -->
	</div>
<!-- END .booking-main-wrapper -->
</div>

<!-- BEGIN .booking-side-wrapper -->
<div class="booking-side-wrapper">

	<!-- BEGIN .booking-side -->
	<div class="booking-side clearfix">

		<?php if ($quitenicebooking_total_substeps == 1) { ?>
			<h4 class="title-style4"><?php _e('Your Reservation', 'quitenicebooking'); ?><span class="title-block"></span></h4>
		<?php } else { ?>
			<h4 class="title-style4"><?php printf(__('Room %d of %d', 'quitenicebooking'), $quitenicebooking_current_substep, $quitenicebooking_total_substeps); ?><span class="title-block"></span></h4>
		<?php } ?>

		<!-- BEGIN .display-reservation -->
		<div class="display-reservation">
			<ul>
				<li><span><?php _e('Check In','quitenicebooking'); ?>: </span> <?php echo ${'quitenicebooking_room_'.$quitenicebooking_room_number.'_checkin'}; ?></li>
				<li><span><?php _e('Check Out','quitenicebooking'); ?>: </span> <?php echo ${'quitenicebooking_room_'.$quitenicebooking_room_number.'_checkout'}; ?></li>
				<li>
					<span><?php _e('Guests'); ?>: </span>
					<?php $str = ''; ?>
					<?php $str .= ${'quitenicebooking_room_'.$quitenicebooking_room_number.'_adults'} > 0 ? ${'quitenicebooking_room_'.$quitenicebooking_room_number.'_adults'}.' '._n('Adult', 'Adults', ${'quitenicebooking_room_'.$quitenicebooking_room_number.'_adults'}, 'quitenicebooking').', ' : ''; ?>
					<?php $str .= ${'quitenicebooking_room_'.$quitenicebooking_room_number.'_children'} > 0 ? ${'quitenicebooking_room_'.$quitenicebooking_room_number.'_children'}.' '._n('Child', 'Children', ${'quitenicebooking_room_'.$quitenicebooking_room_number.'_children'}, 'quitenicebooking').', ' : ''; ?>
					<?php $str = substr($str, 0, -2); ?>
					<?php echo $str; ?>
					<?php unset($str); ?>
				</li>
			</ul>
			<a href="#" class="button3 edit-reservation"><?php _e('Edit Reservation','quitenicebooking'); ?></a>
		<!-- END .display-reservation -->
		</div>
			
		
		<!-- BEGIN .display-reservation-edit -->
		<div class="display-reservation-edit hide">
			<form class="booking-form" action="<?php echo $quitenicebooking_step_2_url; ?>" method="POST">
				<input type="hidden" name="booking_step_2_submit" value="1">
				
				<div class="clearfix">
					<div class="one-half-form">
						<label for="datefrom"><?php _e('Check In','quitenicebooking'); ?></label>
						<input type="text" id="datefrom" name="room_<?php echo $quitenicebooking_room_number; ?>_checkin" value="<?php echo ${'quitenicebooking_room_'.$quitenicebooking_room_number.'_checkin'} ?>" class="datepicker">
					</div>
					<div class="one-half-form last-col">
						<label for="dateto"><?php _e('Check Out','quitenicebooking'); ?></label>
						<input type="text" id="dateto" name="room_<?php echo $quitenicebooking_room_number; ?>_checkout" value="<?php echo ${'quitenicebooking_room_'.$quitenicebooking_room_number.'_checkout'} ?>" class="datepicker">
					</div>
				</div>
			
				<!-- BEGIN .rooms-wrapper -->
				<div class="rooms-wrapper">
		
					<!-- BEGIN .room-1 -->
					<div class="room-1 clearfix">
						<hr class="space8" />
						<div class="one-third-form">
							<label for="room_<?php echo $quitenicebooking_room_number; ?>_adults"><?php _e('Adults','quitenicebooking'); ?></label>
							<div class="select-wrapper">
								<select name="room_<?php echo $quitenicebooking_room_number; ?>_adults" id="room_<?php echo $quitenicebooking_room_number; ?>_adults">
									<?php foreach (range(0, $quitenicebooking_max_persons_in_form) as $r) { ?>
										<option value="<?php echo $r; ?>" <?php selected(${'quitenicebooking_room_'.$quitenicebooking_room_number.'_adults'}, $r); ?>><?php echo $r; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						
						<?php if (empty($quitenicebooking_remove_children)) { ?>
							<div class="one-third-form last-col">
								<label for="room_<?php echo $quitenicebooking_room_number; ?>_children"><?php _e('Children','quitenicebooking'); ?></label>
								<div class="select-wrapper">
									<select name="room_<?php echo $quitenicebooking_room_number; ?>_children" id="room_<?php echo $quitenicebooking_room_number; ?>_children">
									<?php foreach (range(0, $quitenicebooking_max_persons_in_form) as $r) { ?>
										<option value="<?php echo $r; ?>" <?php selected(${'quitenicebooking_room_'.$quitenicebooking_room_number.'_children'}, $r); ?>><?php echo $r; ?></option>
									<?php } ?>
									</select>
								</div>
							</div>
						<?php } else { ?>
							<input type="hidden" name="room_<?php echo $quitenicebooking_room_number; ?>_children" value="0">
						<?php } ?>
						
					</div>
					<!-- END .room-1 -->
		
				<!-- END .rooms-wrapper -->
				</div>
				
				<hr class="space8" />
				
				<input type="submit" class="bookbutton" name="edit_reservation" value="<?php _e('Check Availability', 'quitenicebooking'); ?>">
				
			</form>
		<!-- END .display-reservation-edit -->
		</div>
	<!-- END .booking-side -->
	</div>
	
	<!-- BEGIN back-button -->
	<?php if ($quitenicebooking_prev_room_number !== NULL) { ?>
		<div class="booking-side clearfix back-wrapper">
			<form action="<?php echo $quitenicebooking_step_2_url; ?>" method="POST">
				<input type="hidden" name="booking_step_2_submit" value="1">
				<button type="submit" class="button3" name="room_<?php echo $quitenicebooking_prev_room_number; ?>_selection" value=""><?php _e('&larr; Edit previous room', 'quitenicebooking'); ?></button>
			</form>
		</div>
	<?php } // end if ?>
	<!-- END back-button -->
	
<!-- END .booking-side-wrapper -->
</div>

<div class="clearboth"></div>
