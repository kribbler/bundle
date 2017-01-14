<div class="wrap">
	<?php include 'admin_header.htm.php'; ?>
	<form method="POST" action="options.php" id="admin_settings_form">
		<?php settings_fields('quitenicebooking_settings'); ?>
		
		<table class="form-table">
			<tbody>

				<tr>
					<td colspan="2"><h3><?php _e('Messages', 'quitenicebooking'); ?></h3></td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[booking_success_message]"><?php _e('Booking success message', 'quitenicebooking'); ?> *</label></th>
					<td><textarea class="large-text" name="quitenicebooking[booking_success_message]" id="quitenicebooking[booking_success_message]"><?php echo $this->settings['booking_success_message']; ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[payment_success_message]"><?php _e('Payment success message', 'quitenicebooking'); ?></label></th>
					<td><textarea class="large-text" name="quitenicebooking[payment_success_message]" id="quitenicebooking[payment_success_message]"><?php echo $this->settings['payment_success_message']; ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[payment_fail_message]"><?php _e('Payment fail message', 'quitenicebooking'); ?></label></th>
					<td><textarea class="large-text" name="quitenicebooking[payment_fail_message]" id="quitenicebooking[payment_fail_message]"><?php echo $this->settings['payment_fail_message']; ?></textarea></td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[terms_and_conditions]"><?php _e('Terms and conditions', 'quitenicebooking'); ?></label></th>
					<td><textarea class="large-text" name="quitenicebooking[terms_and_conditions]" id="quitenicebooking[terms_and_conditions]" rows="5"><?php echo $this->settings['terms_and_conditions']; ?></textarea></td>
				</tr>
				
			</tbody>
		</table><!-- .form-table -->
		<?php submit_button(__('Save Changes', 'quitenicebooking')); ?>
	</form>
</div>
