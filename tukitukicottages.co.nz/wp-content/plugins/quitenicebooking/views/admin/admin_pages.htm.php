<style>
select {
	width: 25em;
}
</style>
<div class="wrap">
	<?php include 'admin_header.htm.php'; ?>
	<form method="POST" action="options.php" id="admin_settings_form">
		<?php settings_fields('quitenicebooking_settings'); ?>
		
		<table class="form-table">
			<tbody>
				<tr>
					<td colspan="2"><h3><?php _e('Page configuration', 'quitenicebooking'); ?></h3></td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[accommodation_page_id]"><?php _e('Accommodation page', 'quitenicebooking'); ?></label></th>
					<td>
						<select name="quitenicebooking[accommodation_page_id]" id="quitenicebooking[accommodation_page_id]">
							<option value="" <?php selected($this->settings['accommodation_page_id'], ''); ?>>&nbsp;</option>
							<?php foreach ($all_pages as $page ) { ?>
								<option value="<?php echo $page->ID; ?>" <?php selected($this->settings['accommodation_page_id'], $page->ID); ?>><?php echo $page->post_title; ?> <?php printf(__('[Page ID: %d]', 'quitenicebooking'), $page->ID); ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[step_1_page_id]"><?php _e('Booking step 1', 'quitenicebooking'); ?></label></th>
					<td>
						<select name="quitenicebooking[step_1_page_id]" id="quitenicebooking[step_1_page_id]">
							<option value="" <?php selected($this->settings['step_1_page_id'], ''); ?>>&nbsp;</option>
							<?php foreach ($all_pages as $page ) { ?>
								<option value="<?php echo $page->ID; ?>" <?php selected($this->settings['step_1_page_id'], $page->ID); ?>><?php echo $page->post_title; ?> <?php printf(__('[Page ID: %d]', 'quitenicebooking'), $page->ID); ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[step_2_page_id]"><?php _e('Booking step 2', 'quitenicebooking'); ?></label></th>
					<td>
						<select name="quitenicebooking[step_2_page_id]" id="quitenicebooking[step_2_page_id]">
							<option value="" <?php selected($this->settings['step_2_page_id'], ''); ?>>&nbsp;</option>
							<?php foreach ($all_pages as $page ) { ?>
								<option value="<?php echo $page->ID; ?>" <?php selected($this->settings['step_2_page_id'], $page->ID); ?>><?php echo $page->post_title; ?> <?php printf(__('[Page ID: %d]', 'quitenicebooking'), $page->ID); ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[step_3_page_id]"><?php _e('Booking step 3', 'quitenicebooking'); ?></label></th>
					<td>
						<select name="quitenicebooking[step_3_page_id]" id="quitenicebooking[step_3_page_id]">
							<option value="" <?php selected($this->settings['step_3_page_id'], ''); ?>>&nbsp;</option>
							<?php foreach ($all_pages as $page ) { ?>
								<option value="<?php echo $page->ID; ?>" <?php selected($this->settings['step_3_page_id'], $page->ID); ?>><?php echo $page->post_title; ?> <?php printf(__('[Page ID: %d]', 'quitenicebooking'), $page->ID); ?></option>
							<?php } ?>
						</select>

					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[step_4_page_id]"><?php _e('Booking step 4', 'quitenicebooking'); ?></label></th>
					<td>
						<select name="quitenicebooking[step_4_page_id]" id="quitenicebooking[step_4_page_id]">
							<option value="" <?php selected($this->settings['step_4_page_id'], ''); ?>>&nbsp;</option>
							<?php foreach ($all_pages as $page ) { ?>
								<option value="<?php echo $page->ID; ?>" <?php selected($this->settings['step_4_page_id'], $page->ID); ?>><?php echo $page->post_title; ?> <?php printf(__('[Page ID: %d]', 'quitenicebooking'), $page->ID); ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[payment_success_page_id]"><?php _e('Payment success page', 'quitenicebooking'); ?></label></th>
					<td>
						<select name="quitenicebooking[payment_success_page_id]" id="quitenicebooking[payment_success_page_id]">
							<option value="" <?php selected($this->settings['payment_success_page_id'], ''); ?>>&nbsp;</option>
							<?php foreach ($all_pages as $page ) { ?>
								<option value="<?php echo $page->ID; ?>" <?php selected($this->settings['payment_success_page_id'], $page->ID); ?>><?php echo $page->post_title; ?> <?php printf(__('[Page ID: %d]', 'quitenicebooking'), $page->ID); ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[payment_fail_page_id]"><?php _e('Payment fail page', 'quitenicebooking'); ?></label></th>
					<td>
						<select name="quitenicebooking[payment_fail_page_id]" id="quitenicebooking[payment_fail_page_id]">
							<option value="" <?php selected($this->settings['payment_fail_page_id'], ''); ?>>&nbsp;</option>
							<?php foreach ($all_pages as $page ) { ?>
								<option value="<?php echo $page->ID; ?>" <?php selected($this->settings['payment_fail_page_id'], $page->ID); ?>><?php echo $page->post_title; ?> <?php printf(__('[Page ID: %d]', 'quitenicebooking'), $page->ID); ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				
			</tbody>
		</table><!-- .form-table -->
		<?php submit_button(__('Save Changes', 'quitenicebooking')); ?>
	</form>
</div>
