<div id="validation_errors" class="error">
</div>

<?php for ($i = 1; $i <= $quitenicebooking_num_rooms; $i ++) { ?>
<div class="room">
	<h3><?php printf(__('Room %d', 'quitenicebooking'), $i); ?></h3>
	<div class="field-wrapper field-padding clearfix">
		<div class="one-half">
			<label for="quitenicebooking_room_booking_<?php echo $i; ?>_checkin"><?php _e('Check in date', 'quitenicebooking'); ?> (<?php echo $this->settings['date_format_strings'][$this->settings['date_format']]['display'];?>)</label>
			<input type="text" name="quitenicebooking_room_booking_<?php echo $i; ?>_checkin" id="quitenicebooking_room_booking_<?php echo $i; ?>_checkin" value="<?php echo isset(${'quitenicebooking_room_booking_'.$i.'_checkin'}) ? ${'quitenicebooking_room_booking_'.$i.'_checkin'} : ''; ?>" class="full-width datepicker" disabled="">
		</div>
		<div class="one-half">
			<label for="quitenicebooking_room_booking_<?php echo $i; ?>_checkout"><?php _e('Check out date', 'quitenicebooking'); ?> (<?php echo $this->settings['date_format_strings'][$this->settings['date_format']]['display'];?>)</label>
			<input type="text" name="quitenicebooking_room_booking_<?php echo $i; ?>_checkout" id="quitenicebooking_room_booking_<?php echo $i; ?>_checkout" value="<?php echo isset(${'quitenicebooking_room_booking_'.$i.'_checkout'}) ? ${'quitenicebooking_room_booking_'.$i.'_checkout'} : ''; ?>" class="full-width datepicker" disabled="">
		</div>
	</div>
	<div class="field-wrapper field-padding-below clearfix">
		<div class="one-half">
			<label for="quitenicebooking_room_booking_<?php echo $i; ?>_type"><?php _e('Room type', 'quitenicebooking'); ?></label>
			<select name="quitenicebooking_room_booking_<?php echo $i; ?>_type" id="quitenicebooking_room_booking_<?php echo $i; ?>_type" class="full-width" disabled="">
				<?php foreach ($quitenicebooking_all_rooms as $room) { ?>
					<option value="<?php echo $room['id']; ?>" <?php selected(${'quitenicebooking_room_booking_'.$i.'_type'}, $room['id']); ?>><?php echo $room['title']; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="one-half">
			<label for="quitenicebooking_room_booking_<?php echo $i; ?>_bed"><?php _e('Bed type', 'quitenicebooking'); ?></label>
			<select name="quitenicebooking_room_booking_<?php echo $i; ?>_bed" id="quitenicebooking_room_booking_<?php echo $i; ?>_bed" class="full-width" disabled="">
				<?php foreach ($quitenicebooking_beds->keys['beds'] as $bed => $defs) { ?>
					<?php if ( $quitenicebooking_all_rooms[${'quitenicebooking_room_booking_'.$i.'_type'}][$defs['meta_key']] == 1 ) { ?>
					<option value="<?php echo $bed; ?>" <?php selected(${'quitenicebooking_room_booking_'.$i.'_bed'}, $bed); ?>><?php echo $defs['description']; ?></option>
					<?php } ?>
				<?php } ?>
					<option value="0" <?php selected(${'quitenicebooking_room_booking_'.$i.'_bed'}, 0); ?>><?php echo $quitenicebooking_beds->keys['disabled']['description']; ?></option>
			</select>
		</div>
	</div>
	<div class="field-wrapper field-padding-below clearfix">
		<div class="one-half">
			<label for="quitenicebooking_room_booking_<?php echo $i; ?>_adults"><?php _e('Adults', 'quitenicebooking'); ?></label>
			<select name="quitenicebooking_room_booking_<?php echo $i; ?>_adults" id="quitenicebooking_room_booking_<?php echo $i; ?>_adults" class="full-width" disabled="">
				<?php for ($r = 0; $r <= 20; $r ++) { ?>
					<option value="<?php echo $r; ?>" <?php selected(${'quitenicebooking_room_booking_'.$i.'_adults'}, $r); ?>><?php echo $r; ?></option>
				<?php } ?>
			</select>
		</div>
		<div class="one-half">
			<label for="quitenicebooking_room_booking_<?php echo $i; ?>_children"><?php _e('Children', 'quitenicebooking'); ?></label>
			<select name="quitenicebooking_room_booking_<?php echo $i; ?>_children" id="quitenicebooking_room_booking_<?php echo $i; ?>_children" class="full-width" disabled="">
				<?php for ($r = 0; $r <= 20; $r ++) { ?>
					<option value="<?php echo $r; ?>" <?php selected(${'quitenicebooking_room_booking_'.$i.'_children'}, $r); ?>><?php echo $r; ?></option>
				<?php } ?>
			</select>
		</div>	
	</div>
	<div class="field-wrapper field-padding-below clearfix">
		<button class="edit_room button"><?php _e('Edit Room', 'quitenicebooking'); ?></button>
		<button type="button" class="remove_room button"><?php _e('Remove Room', 'quitenicebooking'); ?></button>
		<span class="ajax_messages"></span>
	</div>
</div>
<?php } ?>

<div id="dynamic_add_room"></div>
<div class="field-padding">
	<button type="button" id="add_room" class="button-primary"><?php _e('Add Room', 'quitenicebooking'); ?></button>
</div>
