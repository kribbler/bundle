<style>
#quitenicebooking_ajax_output {
	width: 100%;
	height: 300px;
	display: none;
	border: 1px solid #f00;
}
</style>
<div class="wrap">
	<?php include 'admin_header.htm.php'; ?>
	
	<table class="form-table">
		<tbody>
			<tr>
				<td colspan="2"><h3><?php _e('Uninstall', 'quitenicebooking'); ?></h3></td>
			</tr>
			<tr>
				<th scope="row"><label for="quitenicebooking[uninstall_wipe]"><?php _e('Wipe data when uninstalling', 'quitenicebooking'); ?></label></th>
				<td>
					<form method="POST" action="options.php" id="admin_settings_form">
						<?php settings_fields('quitenicebooking_settings'); ?>
						<input type="hidden" name="quitenicebooking[uninstall_wipe]" value="">
						<input type="checkbox" name="quitenicebooking[uninstall_wipe]" id="quitenicebooking[uninstall_wipe]" value="1" <?php checked(isset($this->settings['uninstall_wipe']) ? $this->settings['uninstall_wipe'] : 0, 1); ?>>
						<p class="description"><?php _e('Checking this option will <strong>delete all accommodations and bookings</strong> when uninstalling the plugin via <em>Installed plugins &rarr; Quite Nice Booking &rarr; Delete</em>', 'quitenicebooking'); ?></p>
						<?php submit_button(__('Save Changes', 'quitenicebooking')); ?>
					</form>
				</td>
			</tr>
			<tr>
				<td colspan="2"><h3><?php _e('Backup', 'quitenicebooking'); ?></h3></td>
			</tr>
			<tr>
				<th scope="row"><label for="quitenicebooking_download_backup"><?php _e('Create backup', 'quitenicebooking'); ?></label></th>
				<td>
					<form method="POST" action="<?php echo admin_url( 'admin.php?page=quitenicebooking_settings&tab=maintenance' ); ?>">
						<button class="button" name="quitenicebooking_download_backup" id="quitenicebooking_download_backup"><?php _e('Download'); ?></button>
						<p class="description"><?php _e('Download a backup of the current plugin settings.  Note that it does not contain any of the accommodation or booking data', 'quitenicebooking'); ?></p>
					</form>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="quitenicebooking_upload_backup_file"><?php _e('Restore', 'quitenicebooking'); ?></label></th>
				<td>
					<form enctype="multipart/form-data" method="POST" action="options.php" id="admin_settings_form">
	<?php settings_fields('quitenicebooking_settings'); ?>
						<input type="file" class="regular-text" name="quitenicebooking_upload_backup_file" id="quitenicebooking_upload_backup_file">
						<button class="button" name="quitenicebooking_upload_backup" id="quitenicebooking_download_backup"><?php _e('Upload'); ?></button>
						<p class="description"><?php _e('Restore a backup of plugin settings', 'quitenicebooking'); ?></p>
					</form>
				</td>
			</tr>
			<tr>
				<td colspan="2"><h3><?php _e('Clean up and repair', 'quitenicebooking'); ?></h3>
				<p>It is recommended that you <a href="http://codex.wordpress.org/WordPress_Backups" target="_blank">back up your Wordpress installation</a> before running these tasks.</p></td>
			</tr>
			<tr>
				<th scope="row"><label for="quitenicebooking_repair_accommodations"><?php _e('Repair accommodations', 'quitenicebooking'); ?></label></th>
				<td>
					<button class="button" id="quitenicebooking_repair_accommodations"><?php _e('Run'); ?></button>
					<p class="description"><?php _e('Run this to clean up unused accommodation data'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="quitenicebooking_repair_bookings"><?php _e('Repair bookings', 'quitenicebooking'); ?></label></th>
				<td>
					<button class="button" id="quitenicebooking_repair_bookings"><?php _e('Run'); ?></button>
					<p class="description"><?php _e('Run this to clean up unused booking data and repair database errors'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="quitenicebooking_repair_settings"><?php _e('Repair plugin settings', 'quitenicebooking'); ?></label></th>
				<td>
					<button class="button" name="quitenicebooking_repair_settings" id="quitenicebooking_repair_settings"><?php _e('Run'); ?></button>
					<p class="description"><?php _e('Run this to clean up unused plugin settings'); ?></p>
				</td>
			</tr>
			<tr>
				<th scope="row"><label for="quitenicebooking_reset"><?php _e('Reset plugin', 'quitenicebooking'); ?></label></th>
				<td>
					<button class="button" id="quitenicebooking_reset"><?php _e('Run'); ?></button>
					<p class="description"><?php _e('Run this to restore the plugin to its default settings', 'quitenicebooking'); ?></p>
				</td>
			</tr>
			<tr>
				<td colspan="2"><h3><?php _e('Troubleshooting', 'quitenicebooking'); ?></h3></td>
			</tr>
			<tr>
				<th scope="row"><label for="quitenicebooking_diagnostics"><?php _e('Diagnostics', 'quitenicebooking'); ?></label></th>
				<td>
					<button class="button" name="quitenicebooking_diagnostics" id="quitenicebooking_diagnostics"><?php _e('Run'); ?></button>
					<p class="description"><?php _e('If asked by QNS Support, run this to generate diagnostics to help troubleshoot your Wordpress installation', 'quitenicebooking'); ?></p>
				</td>
			</tr>

			<tr>
				<td colspan="2"><textarea id="quitenicebooking_ajax_output"></textarea></td>
			</tr>

		</tbody>
	</table><!-- .form-table -->

</div>
