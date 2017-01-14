<script>
(function($) {
$(document).ready(function() {
	/**
	 * Shows/hides deposit types
	 */
	function show_deposit_type(type) {
		// hide all boxes first
		$('#quitenicebooking_deposit_percentage').css('display', 'none');
		$('#quitenicebooking_deposit_flat').css('display', 'none');
		$('#quitenicebooking_deposit_duration').css('display', 'none');

		if (type == 'percentage') {
			// percentage
			$('#quitenicebooking_deposit_percentage').css('display', '');
		} else if (type == 'flat') {
			// flat
			$('#quitenicebooking_deposit_flat').css('display', '');
		} else if (type == 'duration') {
			// duration
			$('#quitenicebooking_deposit_duration').css('display', '');
		}
	}
	
	/**
	 * Shows/hides deposit types on change
	 */
	$('input[name="quitenicebooking[deposit_type]"]').on('change', function(e) {
		show_deposit_type($(this).val());
	});
	
	/**
	 * Shows/hides deposit type on load
	 */
	show_deposit_type($('input[name="quitenicebooking[deposit_type]"]:checked').val());
	
});

})(jQuery);
</script>
<div class="wrap">
	<?php include 'admin_header.htm.php'; ?>
	<form method="POST" action="options.php" id="admin_settings_form">
		<?php settings_fields('quitenicebooking_settings'); ?>
		
		<table class="form-table">
			<tbody>

				<tr>
					<td colspan="2"><h3><?php _e('Payment settings', 'quitenicebooking'); ?></h3></td>
				</tr>
				
				<tr>
					<th scope="row"><label for="quitenicebooking[currency_unit]"><?php _e('Currency symbol', 'quitenicebooking'); ?> *</label></th>
					<td><input type="text" class="regular-text" name="quitenicebooking[currency_unit]" id="quitenicebooking[currency_unit]" value="<?php echo $this->settings['currency_unit']; ?>"><p class="description"><?php _e('e.g. $, &pound;, &euro;, &yen;, USD', 'quitenicebooking'); ?></p></td>
				</tr>

				<tr>
					<th scope="row"><?php _e('Currency symbol position'); ?></th>
					<td><input type="hidden" name="quitenicebooking[currency_unit_suffix]" value=""><input type="checkbox" name="quitenicebooking[currency_unit_suffix]" id="quitenicebooking[currency_unit_suffix]" value="1" <?php checked(!empty($this->settings['currency_unit_suffix']) ? 1 : '', 1); ?>><label for="quitenicebooking[currency_unit_suffix]"> <?php _e('Display currency symbol right of the price', 'quitenicebooking'); ?></label></td>
				</tr>
				
				<tr>
					<th scope="row"><label for="quitenicebooking[deposit_type]"><?php _e('Deposit type', 'quitenicebooking'); ?></label></th>
					<td>
						<?php $quitenicebooking_deposit_type = isset($this->settings['deposit_type']) ? $this->settings['deposit_type'] : ''; ?>
						<input type="radio" name="quitenicebooking[deposit_type]" id="quitenicebooking[deposit_type_disabled]" value="" <?php checked($quitenicebooking_deposit_type, ''); ?>> <label for="quitenicebooking[deposit_type_disabled]"><?php _e('No deposit', 'quitenicebooking'); ?></label><br>
						<input type="radio" name="quitenicebooking[deposit_type]" id="quitenicebooking[deposit_type_percentage]" value="percentage" <?php checked($quitenicebooking_deposit_type, 'percentage'); ?>> <label for="quitenicebooking[deposit_type_percentage]"><?php _e('Percentage of total price', 'quitenicebooking'); ?></label><br>
						<input type="radio" name="quitenicebooking[deposit_type]" id="quitenicebooking[deposit_type_flat]" value="flat" <?php checked($quitenicebooking_deposit_type, 'flat'); ?>> <label for="quitenicebooking[deposit_type_flat]"><?php _e('Flat rate', 'quitenicebooking'); ?></label><br>
						<input type="radio" name="quitenicebooking[deposit_type]" id="quitenicebooking[deposit_type_duration]" value="duration" <?php checked($quitenicebooking_deposit_type, 'duration'); ?>> <label for="quitenicebooking[deposit_type_duration]"><?php _e('By length of stay', 'quitenicebooking'); ?></label><br>
					</td>
				</tr>
				
				<tr id="quitenicebooking_deposit_percentage">
					<th scope="row"><label for="quitenicebooking[deposit_percentage]"><?php _e('Percentage', 'quitenicebooking'); ?> *</label></th>
					<td><input type="text" class="small-text" name="quitenicebooking[deposit_percentage]" id="quitenicebooking[deposit_percentage]" value="<?php echo isset($this->settings['deposit_percentage']) ? $this->settings['deposit_percentage'] : ''; ?>">%
				</tr>
				<tr id="quitenicebooking_deposit_flat">
					<th scope="row"><label for="quitenicebooking[deposit_flat]"><?php _e('Price', 'quitenicebooking'); ?> *</label></th>
					<td><?php echo $this->settings['currency_unit']; ?><input type="text" class="small-text" name="quitenicebooking[deposit_flat]" id="quitenicebooking[deposit_flat]" value="<?php echo isset($this->settings['deposit_flat']) ? $this->settings['deposit_flat'] : ''; ?>">
				</tr>
				<tr id="quitenicebooking_deposit_duration">
					<?php $quitenicebooking_deposit_duration = isset($this->settings['deposit_duration']) ? $this->settings['deposit_duration'] : ''; ?>
					<th scope="row"><label for="quitenicebooking[deposit_duration]"><?php _e('Duration', 'quitenicebooking'); ?> *</label></th>
					<?php ob_start(); ?>
					<select name="quitenicebooking[deposit_duration]" id="quitenicebooking[deposit_duration]">
						<option value="" <?php selected($quitenicebooking_deposit_duration, ''); ?>></option>
						<?php foreach (range(1, 14) as $r) { ?>
						<option value="<?php echo $r; ?>" <?php selected($quitenicebooking_deposit_duration, $r); ?>><?php printf(_n('%d night', '%d nights', $r, 'quitenicebooking'), $r); ?></option>
						<?php } ?>
					</select>
					<?php $quitenicebooking_deposit_duration_html = ob_get_clean(); ?>
					<td><?php printf(__('A deposit for the price of %s will be taken for each room in the booking', 'quitenicebooking'), $quitenicebooking_deposit_duration_html) ; ?>
				</tr>				
				
				<tr>
					<td colspan="2"><h3><?php _e('Paypal', 'quitenicebooking'); ?></h3></td>
				</tr>

				<tr>
					<th scope="row"><label for="quitenicebooking[accept_paypal]"><?php _e('Accept deposit via Paypal', 'quitenicebooking'); ?></label></th>
					<td><input type="hidden" name="quitenicebooking[accept_paypal]" value=""><input type="checkbox" name="quitenicebooking[accept_paypal]" id="quitenicebooking[accept_paypal]" value="1" <?php checked(isset($this->settings['accept_paypal']) ? $this->settings['accept_paypal'] : 0, 1); ?>></td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[paypal_email_address]"><?php _e('Paypal email address', 'quitenicebooking'); ?></label></th>
					<td><input type="text" class="regular-text" name="quitenicebooking[paypal_email_address]" id="quitenicebooking[paypal_email_address]" value="<?php echo $this->settings['paypal_email_address']; ?>"></td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[paypal_currency]"><?php _e('Currency used for Paypal deposit', 'quitenicebooking'); ?></label></th>
					<td>
						<select name="quitenicebooking[paypal_currency]" id="quitenicebooking[paypal_currency]">
						<?php foreach ($this->settings['paypal_currencies'] as $code => $description) { ?>
							<option value="<?php echo $code; ?>" <?php selected($this->settings['paypal_currency'], $code); ?>><?php echo $description.' ('.$code.')'; ?></option>
						<?php } ?>
						</select>
					</td>
				</tr>
				
				<tr>
					<td colspan="2"><h3><?php _e('Bank transfer', 'quitenicebooking'); ?></h3></td>
				</tr>
				
				<tr>
					<th scope="row"><label for="quitenicebooking[accept_bank_transfer]"><?php _e('Accept bank transfer', 'quitenicebooking'); ?></label></th>
					<td><input type="hidden" name="quitenicebooking[accept_bank_transfer]" value=""><input type="checkbox" name="quitenicebooking[accept_bank_transfer]" id="quitenicebooking[accept_bank_transfer]" value="1" <?php checked(isset($this->settings['accept_bank_transfer']) ? $this->settings['accept_bank_transfer'] : 0, 1); ?>></td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[bank_transfer_details]"><?php _e('Bank transfer information', 'quitenicebooking'); ?></label></th>
					<td>
						<textarea class="large-text" name="quitenicebooking[bank_transfer_details]" id="quitenicebooking[bank_transfer_details]" rows="5"><?php echo $this->settings['bank_transfer_details']; ?></textarea>
						<p class="description"><?php _e('Banking details for transfers.  This will be shown on the payment screen.  HTML is allowed.', 'quitenicebooking'); ?></p>
					</td>
				</tr>

			</tbody>
		</table><!-- .form-table -->
		<?php submit_button(__('Save Changes', 'quitenicebooking')); ?>
	</form>
</div>
