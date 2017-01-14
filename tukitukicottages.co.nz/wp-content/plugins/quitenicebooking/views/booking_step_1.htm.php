<style>
	.booking-form-notice {
		display: block;
	}
</style>
<style>
	#datepicker-loading-spinner {
		text-align: center;
		font-size: 13px;
		height: 60px;
		background: url('<?php echo QUITENICEBOOKING_URL; ?>assets/images/calendar_loading.gif') no-repeat center bottom;
	}
</style>
<noscript>
	<style>
		.datepicker-key {
			display: none;
		}
	</style>
</noscript>
<!-- BEGIN .booking-step-wrapper -->
<div class="booking-step-wrapper clearfix">

	<div class="step-wrapper">
		<div class="step-icon-wrapper">
			<div class="step-icon step-icon-current">1.</div>
		</div>
		<div class="step-title"><?php _e('Choose Your Date','quitenicebooking'); ?></div>
	</div>

	<div class="step-wrapper">
		<div class="step-icon-wrapper">
			<div class="step-icon">2.</div>
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
		
		<div class="dark-notice calendar-notice"><p><?php _e('Please select your dates from the calendar','quitenicebooking'); ?></p></div>
		
		<div id="open_datepicker"><div id="datepicker-loading-spinner"><?php _e('Please wait; loading available dates...', 'quitenicebooking'); ?></div></div>
		
		<div class="clearboth"></div>
		
		<div class="datepicker-key clearfix">
			
			<div class="key-unavailable-wrapper clearfix">
				<div class="key-unavailable-icon"></div>
				<div class="key-unavailable-text"><?php _e('Unavailable','quitenicebooking'); ?></div>
			</div>
			
			<div class="key-available-wrapper clearfix">
				<div class="key-available-icon"></div>
				<div class="key-available-text"><?php _e('Available','quitenicebooking'); ?></div>
			</div>
			
			<div class="key-selected-wrapper clearfix">
				<div class="key-selected-icon"></div>
				<div class="key-selected-text"><?php _e('Selected Dates','quitenicebooking'); ?></div>
			</div>
			
		</div>
	
	<!-- END .booking-main -->
	</div>

<!-- END .booking-main-wrapper -->
</div>

<!-- BEGIN .booking-side-wrapper -->
<div class="booking-side-wrapper">
	
	<!-- BEGIN .booking-side -->
	<div class="booking-side">
	
		<h4 class="title-style4"><?php _e('Your Reservation','quitenicebooking'); ?><span class="title-block"></span></h4>
		
		<form class="booking-form" action="<?php echo $quitenicebooking_step_1_url; ?>" method="POST">
			
			<div class="clearfix">
				
				<div class="one-half-form">
					<label for="datefrom"><?php _e('Check In','quitenicebooking'); ?></label>
					<input name="room_all_checkin" type="text" id="datefrom" size="10" class="datepicker2" value="<?php echo (isset($quitenicebooking_room_all_checkin) && !empty($quitenicebooking_room_all_checkin)) ? $quitenicebooking_room_all_checkin : ''; ?>">
				</div>
			
				<div class="one-half-form last-col">
					<label for="dateto"><?php _e('Check Out','quitenicebooking'); ?></label>
					<input name="room_all_checkout" type="text" id="dateto" size="10" class="datepicker2" value="<?php echo (isset($quitenicebooking_room_all_checkout) && !empty($quitenicebooking_room_all_checkout)) ? $quitenicebooking_room_all_checkout : ''; ?>">
				</div>
			
			</div>
			
			<?php if ( $quitenicebooking_max_rooms == 1 ) { ?>
			<input type="hidden" name="room_qty" id="room_qty" value="1" />
			<?php } else { ?>
			<hr class="space8" />
			<label for="book_room"><?php _e('Bedrooms Required','quitenicebooking'); ?></label>
			<div class="select-wrapper">
				<select name="room_qty" id="room_qty">
					<?php if (!isset($quitenicebooking_room_qty)) { ?>
						<?php $quitenicebooking_room_qty = 1; ?>
					<?php } ?>
					<?php foreach (range(1, $quitenicebooking_max_rooms) as $r) { ?>
						<option value="<?php echo $r; ?>" <?php selected($quitenicebooking_room_qty, $r); ?>><?php echo $r; ?></option>
					<?php } ?>
				</select>
			</div>
			<?php } ?>
			
			<!-- BEGIN .rooms-wrapper -->
			<div class="rooms-wrapper">
			
				<!-- BEGIN .room-n -->
				<?php foreach (range(1, $quitenicebooking_max_rooms) as $n) { ?>
				<div class="room-<?php echo $n; ?> clearfix">
					<hr class="space8" />
					<p class="label"><?php printf(__('Room %d','quitenicebooking'), $n); ?></p>
					<div class="one-third-form">
						<label for="<?php echo 'room_'.$n.'_adults'; ?>"><?php _e('Adults','quitenicebooking'); ?></label>
						<div class="select-wrapper">
							<select name="<?php echo 'room_'.$n.'_adults'; ?>" id="<?php echo 'room_'.$n.'_adults'; ?>">
								<?php if (!isset(${'quitenicebooking_room_'.$n.'_adults'})) { ?>
									<?php ${'quitenicebooking_room_'.$n.'_adults'} = 0; ?>
								<?php } ?>
								<?php foreach (range(0, $quitenicebooking_max_persons_in_form) as $r) { ?>
									<option value="<?php echo $r; ?>" <?php selected(${'quitenicebooking_room_'.$n.'_adults'}, $r); ?>><?php echo $r; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					
					<?php if (empty($quitenicebooking_remove_children)) { ?>
					
					<div class="one-third-form last-col">
						<label for="<?php echo 'room_'.$n.'_children'; ?>"><?php _e('Children','quitenicebooking'); ?></label>
						<div class="select-wrapper">
							<select name="<?php echo 'room_'.$n.'_children'; ?>" id="<?php echo 'room_'.$n.'_children'; ?>">
								<?php if (!isset(${'quitenicebooking_room_'.$n.'_children'})) { ?>
									<?php ${'quitenicebooking_room_'.$n.'_children'} = 0; ?>
								<?php } ?>
								<?php foreach (range(0, $quitenicebooking_max_persons_in_form) as $r) { ?>
									<option value="<?php echo $r; ?>" <?php selected(${'quitenicebooking_room_'.$n.'_children'}, $r); ?>><?php echo $r; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					
					<?php } else { ?>
						<input type="hidden" name="<?php echo 'room_'.$n.'_children'; ?>" id="<?php echo 'room_'.$n.'_children'; ?>" value="0">
					<?php } ?>
					
				<!-- END .room-n -->
				</div>
				<?php } ?>

			<!-- END .rooms-wrapper -->
			</div>

			<hr class="space8" />
			<?php if (!empty($quitenicebooking_highlight)) { ?>
				<input type="hidden" name="highlight" value="<?php echo $quitenicebooking_highlight; ?>">
			<?php } ?>
			<input class="bookbutton" type="submit" name="booking_step_1_submit" value="<?php _e('Check Availability','quitenicebooking'); ?>" />

		</form>
	
	<!-- END .booking-side -->
	</div>

<!-- END .booking-side-wrapper -->
</div>

<div class="clearboth"></div>
