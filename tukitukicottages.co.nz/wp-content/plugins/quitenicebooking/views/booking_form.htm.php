<div class="home-reservation-box clearfix">
	<form class="booking-form" action="<?php echo $quitenicebooking_step_1_url; ?>" method="POST">
		<input type="text" id="datefrom" name="room_all_checkin" value="<?php _e('Check In','quitenicebooking'); ?>" class="datepicker">
		<input type="text" id="dateto" name="room_all_checkout" value="<?php _e('Check Out','quitenicebooking'); ?>" class="datepicker">
		<input type="hidden" name="room_qty" id="room_qty" value="1">
		<div class="select-wrapper">
			<select id="room_1_adults" name="room_1_adults">
				<option value="0" selected><?php _e('Adults', 'quitenicebooking'); ?></option>
				<?php foreach (range(0, $quitenicebooking_max_persons_in_form) as $r) { ?>
					<option value="<?php echo $r; ?>"><?php echo $r; ?></option>
				<?php } ?>
			</select>
		</div>
		
		<?php if (empty($quitenicebooking_remove_children)) { ?>
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
		
		<input class="bookbutton" name="booking_step_1_submit" type="submit" value="<?php _e('Check Availability', 'quitenicebooking'); ?>" />
	</form>
	<?php if (!empty($quitenicebooking_multiroom_link)) { ?>
	<p class="multiroom-link"><a href="<?php echo $quitenicebooking_step_1_url; ?>"><?php _e('Multi-room booking?', 'quitenicebooking'); ?></a></p>
	<?php } ?>
</div>
