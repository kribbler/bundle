<div class="field-wrapper field-padding clearfix">
	<div class="one-third">
		<label for="quitenicebooking_deposit_amount"><?php _e('Deposit amount', 'quitenicebooking'); ?> (<?php echo $quitenicebooking_currency_unit; ?>)</label>
	</div>
	<div class="two-thirds">
		<input type="text" name="quitenicebooking_deposit_amount" id="quitenicebooking_deposit_amount" value="<?php echo isset($quitenicebooking_deposit_amount) ? $quitenicebooking_deposit_amount : ''; ?>" class="full-width">
	</div>
</div>
<hr class="space1" />
<div class="field-wrapper field-padding clearfix">
	<div class="one-third">
		<label for="quitenicebooking_total_price"><?php _e('Total price quoted', 'quitenicebooking'); ?> (<?php echo $quitenicebooking_currency_unit; ?>)</label>
	</div>
	<div class="two-thirds">
		<input type="text" name="quitenicebooking_total_price" id="quitenicebooking_total_price" value="<?php echo isset($quitenicebooking_total_price) ? $quitenicebooking_total_price : ''; ?>" class="full-width">
	</div>
</div>
<?php if (!empty($quitenicebooking_coupons_enabled)) { ?>
<hr class="space1" />
<div class="field-wrapper field-padding clearfix">
	<div class="one-third">
		<label for="quitenicebooking_coupon_code"><?php _e('Coupons used', 'quitenicebooking'); ?></label>
	</div>
	<div class="two-thirds">
		<input type="text" name="quitenicebooking_coupon_codes" id="quitenicebooking_coupon_codes" value="<?php echo isset($quitenicebooking_coupon_codes) ? $quitenicebooking_coupon_codes : ''; ?>" class="full-width">
	</div>
</div>
<?php } ?>
<hr class="space1" />
<div class="field-wrapper field-padding clearfix">
	<div class="one-third">
		<label for="quitenicebooking_deposit_method"><?php _e('Deposit method', 'quitenicebooking'); ?></label>
	</div>
	<div class="two-thirds">
		<input type="text" name="quitenicebooking_deposit_method" id="quitenicebooking_deposit_method" value="<?php echo isset($quitenicebooking_deposit_method) ? $quitenicebooking_deposit_method : ''; ?>" class="full-width">
		<p class="description"><?php _e('Method chosen by guest during booking; you may change this for your own records', 'quitenicebooking'); ?></p>
	</div>
</div>
<hr class="space1" />
<div class="field-wrapper field-padding clearfix">
	<div class="one-third">
		<label for="quitenicebooking_deposit_status"><?php _e('Deposit status', 'quitenicebooking'); ?></label>
	</div>
	<div class="two-thirds">
		<input type="text" name="quitenicebooking_deposit_status" id="quitenicebooking_deposit_status" value="<?php echo isset($quitenicebooking_deposit_status) ? $quitenicebooking_deposit_status : ''; ?>" class="full-width">
		<p class="description"><?php _e('Enter your memo here', 'quitenicebooking'); ?></p>
	</div>
</div>
