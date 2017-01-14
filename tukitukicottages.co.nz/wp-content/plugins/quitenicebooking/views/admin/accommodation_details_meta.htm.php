<div class="field-wrapper field-padding clearfix">
	<div class="one-fifth">
		<label for="quitenicebooking_room_quantity"><?php _e('Number of rooms of this type available', 'quitenicebooking'); ?></label>
	</div>
	<div class="two-fifths">
		<?php $quitenicebooking_room_quantity = isset($quitenicebooking_room_quantity) ? $quitenicebooking_room_quantity : 1; ?>
		<select name="quitenicebooking_room_quantity" id="quitenicebooking_room_quantity" class="full-width">
			<?php foreach (range(1, 50) as $r) { ?>
				<option value="<?php echo $r; ?>" <?php selected($quitenicebooking_room_quantity, $r); ?>><?php echo $r; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="two-fifths">
	</div>
</div>
<hr class="space1" />
<div class="field-wrapper field-padding clearfix">
	<div class="one-fifth">
		<label for="quitenicebooking_max_occupancy"><?php _e('Maximum occupancy', 'quitenicebooking'); ?></label>
	</div>
	<div class="two-fifths">
		<?php $quitenicebooking_max_occupancy = isset($quitenicebooking_max_occupancy) ? $quitenicebooking_max_occupancy : 1; ?>
		<select name="quitenicebooking_max_occupancy" id="quitenicebooking_max_occupancy" class="full-width">
			<?php foreach (range(1, 20) as $r) { ?>
				<option value="<?php echo $r; ?>" <?php selected($quitenicebooking_max_occupancy, $r); ?>><?php echo $r; ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="two-fifths">
		<span class="description"><?php _e('The maximum number of guests this room can accommodate', 'quitenicebooking'); ?></span>
	</div>
</div>
<hr class="space1" />
<div class="field-wrapper field-padding clearfix">
	<div class="one-fifth">
		<label for="quitenicebooking_room_size"><?php _e('Size', 'quitenicebooking'); ?></label>
	</div>
	<div class="two-fifths">
		<input type="text" name="quitenicebooking_room_size" id="quitenicebooking_room_size" value="<?php echo isset($quitenicebooking_room_size) ? $quitenicebooking_room_size : ''; ?>" class="full-width">
	</div>
	<div class="two-fifths">
		<span class="description"><?php _e('e.g. "35-40 sqm / 375-430 sqf"', 'quitenicebooking'); ?></span>
	</div>
</div>
<hr class="space1" />
<div class="field-wrapper field-padding clearfix">
	<div class="one-fifth">
		<label for="quitenicebooking_room_view"><?php _e('View', 'quitenicebooking'); ?></label>
	</div>
	<div class="two-fifths">
		<input type="text" name="quitenicebooking_room_view" id="quitenicebooking_room_view" value="<?php echo isset($quitenicebooking_room_view) ? $quitenicebooking_room_view : ''; ?>" class="full-width">
	</div>
	<div class="two-fifths">
		<span class="description"><?php _e('e.g. "City"', 'quitenicebooking'); ?></span>
	</div>
</div>
<hr class="space1" />
<div class="field-wrapper field-padding clearfix">
	<div class="one-fifth">
		<label for="quitenicebooking_num_bedrooms"><?php _e('Number of Bedrooms', 'quitenicebooking'); ?></label>
	</div>
	<div class="two-fifths">
		<?php $quitenicebooking_num_bedrooms = isset($quitenicebooking_num_bedrooms) ? $quitenicebooking_num_bedrooms : 0; ?>
	<select name="quitenicebooking_num_bedrooms" id="quitenicebooking_num_bedrooms" class="full-width">
		<?php foreach (range(1, 10) as $r) { ?>
			<option value="<?php echo $r; ?>" <?php selected($quitenicebooking_num_bedrooms, $r); ?>><?php echo $r; ?></option>
		<?php } ?>
	</select>
	</div>
	<div class="two-fifths">
		<span class="description"><?php _e('Number of bedrooms in this unit. If it\'s a regular one-room hotel room, just leave it set at the default "1" value', 'quitenicebooking'); ?></span>
	</div>
</div>
