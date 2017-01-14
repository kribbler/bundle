<div class="wrap">
	<?php include 'admin_header.htm.php'; ?>
	<form method="POST" action="options.php" id="admin_settings_form">
		<?php settings_fields('quitenicebooking_settings'); ?>
		
		<table class="form-table">
			<tbody>

				<tr>
					<td colspan="2"><h3><?php _e('Message templates', 'quitenicebooking'); ?></h3></td>
				</tr>
				<?php if (has_action('quitenicebooking_settings_email_form')) { ?>
					<?php do_action('quitenicebooking_settings_email_form'); ?>
				<?php } else { ?>
				<tr>
					<th scope="row"><label for="quitenicebooking[email_message]"><?php _e('Confirmation email', 'quitenicebooking'); ?> *</label></th>
					<td>
						<textarea class="large-text" name="quitenicebooking[email_message]" id="quitenicebooking[email_message]" rows="8"><?php echo $this->settings['email_message']; ?></textarea>
						<p class="description"><?php _e('The following tags may be used in the email:', 'quitenicebooking'); ?><br>
						[CUSTOMER_FIRST_NAME] - <?php _e('Customer first name', 'quitenicebooking'); ?><br>
						[CUSTOMER_LAST_NAME] - <?php _e('Customer last name', 'quitenicebooking'); ?><br>
						[HOTEL_NAME] - <?php _e('Hotel name (from site title)', 'quitenicebooking'); ?><br>
						</p>
					</td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="2"><h3><?php _e('Outgoing mail server configuration', 'quitenicebooking'); ?></h3></td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[enable_smtp]"><?php _e( 'Send mail by SMTP', 'quitenicebooking' ); ?></label></th>
					<td>
						<input type="hidden" name="quitenicebooking[enable_smtp]" value=""><input type="checkbox" name="quitenicebooking[enable_smtp]" id="quitenicebooking[enable_smtp]" value="1" <?php checked( isset( $this->settings['enable_smtp'] ) ? $this->settings['enable_smtp'] : 0, 1 ); ?>/>
						<p class="description"><?php _e('If checked, emails will be sent by SMTP. Otherwise, it will be sent by Wordpress\' mailer.  Check this option if you are having trouble receiving email, as some providers block email sent by PHP', 'quitenicebooking'); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[smtp_host]"><?php _e( 'SMTP host name', 'quitenicebooking' ); ?></label></th>
					<td>
						<input type="text" name="quitenicebooking[smtp_host]" id="quitenicebooking[smtp_host]" value="<?php echo isset( $this->settings['smtp_host'] ) ? $this->settings['smtp_host'] : ''; ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[smtp_port]"><?php _e( 'SMTP port number', 'quitenicebooking' ); ?></label></th>
					<td>
						<input type="text" name="quitenicebooking[smtp_port]" id="quitenicebooking[smtp_port]" value="<?php echo isset( $this->settings['smtp_port'] ) ? $this->settings['smtp_port'] : ''; ?>" class="regular-text">
						<p class="description"><?php _e('Typically 25 or 587 if not using encryption; 465 if using encryption'); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[smtp_encryption]"><?php _e( 'Encryption', 'quitenicebooking' ); ?></label></th>
					<td>
						<select name="quitenicebooking[smtp_encryption]" id="quitenicebooking[smtp_encryption]">
							<option value="" <?php selected( isset( $this->settings['smtp_encryption'] ) ? $this->settings['smtp_encryption'] : 0 , '' ); ?>><?php _e( 'No encryption', 'quitenicebooking' ); ?></option>
							<option value="ssl" <?php selected( isset( $this->settings['smtp_encryption'] ) ? $this->settings['smtp_encryption'] : 0 , 'ssl' ); ?>><?php _e( 'Use SSL encryption', 'quitenicebooking' ); ?></option>
							<option value="tls" <?php selected( isset( $this->settings['smtp_encryption'] ) ? $this->settings['smtp_encryption'] : 0 , 'tls' ); ?>><?php _e( 'Use TLS encryption', 'quitenicebooking' ); ?></option>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[smtp_auth]"><?php _e( 'Enable SMTP authentication', 'quitenicebooking' ); ?></label></th>
					<td>
						<input type="hidden" name="quitenicebooking[smtp_auth]" value=""><input type="checkbox" name="quitenicebooking[smtp_auth]" id="quitenicebooking[smtp_auth]" value="1" <?php checked( isset( $this->settings['smtp_auth'] ) ? $this->settings['smtp_auth'] : 0, 1 ); ?>/>
						<p class="description"><?php _e('If your SMTP server requires authentication, check this box and fill in the credentials below.', 'quitenicebooking'); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[smtp_username]"><?php _e( 'User name', 'quitenicebooking' ); ?></label></th>
					<td>
						<input type="text" name="quitenicebooking[smtp_username]" id="quitenicebooking[smtp_username]" value="<?php echo isset( $this->settings['smtp_username'] ) ? $this->settings['smtp_username'] : ''; ?>" class="regular-text">
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="quitenicebooking[smtp_password]"><?php _e( 'Password', 'quitenicebooking' ); ?></label></th>
					<td>
						<input type="password" name="quitenicebooking[smtp_password]" id="quitenicebooking[smtp_password]" value="<?php echo isset( $this->settings['smtp_password'] ) ? $this->settings['smtp_password'] : ''; ?>" class="regular-text">
					</td>
				</tr>
				
			</tbody>
		</table><!-- .form-table -->
		<?php submit_button(__('Save Changes', 'quitenicebooking')); ?>
	</form>
</div>
