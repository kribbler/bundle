<div class="field-wrapper field-padding clearfix">
	<div class="one-fifth">
		<label for="<?php echo $quitenicebooking_beds->keys['disabled']['meta_key']; ?>"><?php _e('Do not specify bed type', 'quitenicebooking'); ?></label>
	</div>
	<div class="four-fifths">
		
		<div class="check-wrapper">
			<?php ${$quitenicebooking_beds->keys['disabled']['meta_key']} = !empty(${$quitenicebooking_beds->keys['disabled']['meta_key']}) ? 1 : ''; ?>
			<input type="hidden" name="<?php echo $quitenicebooking_beds->keys['disabled']['meta_key']; ?>" value="">
			<input type="checkbox" name="<?php echo $quitenicebooking_beds->keys['disabled']['meta_key']; ?>" id="<?php echo $quitenicebooking_beds->keys['disabled']['meta_key']; ?>" value="1" <?php checked(${$quitenicebooking_beds->keys['disabled']['meta_key']}, 1); ?>>
		</div>
		
		<span class="description"><?php _e('If this option is selected, a generic "Select Room" button will be displayed', 'quitenicebooking'); ?></span>
	</div>
</div>
<hr class="space1" />

<div class="field-wrapper field-padding-above">
<?php foreach ($quitenicebooking_beds->keys['beds'] as $key => $defs) { ?>
	<div class="field-padding-none clearfix">
		<div class="one-fifth">
			<label for="<?php echo $defs['meta_key']; ?>"><?php echo $defs['description']; ?></label>
		</div>
		<div class="four-fifths">
			<div class="check-wrapper">
				<?php ${$defs['meta_key']} = !empty(${$defs['meta_key']}) ? 1 : 0; ?>
				<input type="hidden" name="<?php echo $defs['meta_key']; ?>" value="">
				<input type="checkbox" name="<?php echo $defs['meta_key']; ?>" id="<?php echo $defs['meta_key']; ?>" value="1" <?php checked(${$defs['meta_key']}, 1); ?>>
			</div>
		</div>
	</div>
<?php } ?>
</div>
