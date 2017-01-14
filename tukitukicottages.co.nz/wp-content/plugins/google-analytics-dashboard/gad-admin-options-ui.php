<?php
/*  Copyright 2009  Carson McDonald  (carson@ioncannon.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

require_once( dirname( __FILE__ ) . '/ga-lib.php' );
require_once( dirname( __FILE__ ) . '/gauth-lib.php' );
require_once( dirname( __FILE__ ) . '/simplefilecache.php' );

class GADAdminOptionsUI {
	var $info_message;
	var $error_message;

	function GADAdminOptionsUI() {
		$this->__construct();
	}

	function __construct() {
		$this->info_message  = '';
		$this->error_message = '';
	}

	/**
	 * @todo get rid of inline styles
	 */
	function display_admin_halting_error() {
		?>
		<div class="wrap" style="padding-top: 50px;">
			<?php $this->display_messages(); ?>

			Please try again later.
		</div>
	<?php
	}

	/**
	 * @todo get rid of inline styles
	 */
	function display_admin_handle_other_options( $account_hash ) {
		?>

		<div class="wrap" style="padding-top: 50px;">

			<?php
			$this->display_messages();

			if ( sizeof( $account_hash ) != 0 ) {
				$current_account_id = isset( $_POST['ga_account_id'] ) ? $_POST['ga_account_id'] : get_option( 'gad_account_id' ) !== false ? get_option( 'gad_account_id' ) : '';
			}

			if ( ! isset( $current_account_id ) || $current_account_id == '' ) {
				?>
				<div class="updated">
					<p><?php _e( '<b>Note:</b> You will need to select an account and <b>click "Save Changes"</b> before the analytics dashboard will work.', 'google-analytics-dashboard' ); ?></p>
				</div>
			<?php
			}
			?>

			<form action="" method="post">
				<?php
				wp_nonce_field( 'update_ga_dashboard_' . get_current_user_id() );
				?>

				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<label for="ga_account_id"><?php _e( 'Available Accounts', 'google-analytics-dashboard' ); ?></label></th>
						<td>
							<?php
							if ( sizeof( $account_hash ) == 0 ) {
								echo '<span id="ga_account_id">' . __( 'No accounts available.', 'google-analytics-dashboard' ) . '</span>';
							} else {
								echo '<select id="ga_account_id" name="ga_account_id">';
								foreach ( $account_hash as $account_id => $account_name ) {
									echo '<option value="' . esc_attr( $account_id ) . '" ' . ( $current_account_id == $account_id ? 'selected' : '' ) . '>' . esc_attr( $account_name ) . '</option>';
								}
								echo '</select>';
							}
							?>

						</td>
					</tr>

					<?php if ( get_option( 'gad_login_pass' ) !== false ) : ?>
						<tr valign="top">
							<th scope="row">
								<label for="ga_forget_pass"><?php _e( 'Forget Password', 'google-analytics-dashboard' ); ?></label></th>
							<td><input name="ga_forget_pass" type="checkbox" id="ga_forget_pass" value="ga_forget_pass" /></td>
						</tr>
					<?php endif; ?>

					<tr valign="top">
						<th scope="row">
							<label for="ga_forget_auth"><?php _e( 'Forget Authentication', 'google-analytics-dashboard' ); ?></label>
						</th>
						<td><input name="ga_forget_auth" type="checkbox" id="ga_forget_auth" value="ga_forget_auth" /></td>
					</tr>

					<tr valign="top">
						<th scope="row">
							<label for="ga_forget_all"><?php _e( 'Forget Everything', 'google-analytics-dashboard' ); ?></label></th>
						<td><input name="ga_forget_all" type="checkbox" id="ga_forget_all" value="ga_forget_all" /></td>
					</tr>

					<tr valign="top">
						<th scope="row">
							<label for="ga_display_level"><?php _e( 'Dashboard Level', 'google-analytics-dashboard' ); ?></label></th>
						<td>
							<?php
							$ga_display_level = get_option( 'gad_display_level' );
							?>
							<select name="ga_display_level" id="ga_display_level">
								<option value="">None - Admin only</option>
								<option value="level_7" <?php echo ( $ga_display_level == 'level_7' ) ? 'selected' : ''; ?>><?php _e( 'Editor', 'google-analytics-dashboard' ); ?></option>
								<option value="level_2" <?php echo ( $ga_display_level == 'level_2' ) ? 'selected' : ''; ?>><?php _e( 'Author', 'google-analytics-dashboard' ); ?></option>
								<option value="level_1" <?php echo ( $ga_display_level == 'level_1' ) ? 'selected' : ''; ?>><?php _e( 'Contributor', 'google-analytics-dashboard' ); ?></option>
								<option value="level_0" <?php echo ( $ga_display_level == 'level_0' ) ? 'selected' : ''; ?>><?php _e( 'Subscriber', 'google-analytics-dashboard' ); ?></option>
							</select>
						</td>
					</tr>

					<?php
					if ( SimpleFileCache::canCache() ) {
						?>
						<tr valign="top">
							<th scope="row">
								<label for="ga_cache_timeout"><?php _e( 'Cache Timeout (seconds)', 'google-analytics-dashboard' ); ?></label>
							</th>
							<td>
								<input value="<?php echo esc_attr( get_option( 'gad_cache_timeout' ) !== false ? get_option( 'gad_cache_timeout' ) : '60' ); ?>" name="ga_cache_timeout" id="ga_cache_timeout" />
							</td>
						</tr>
					<?php
					} else {
						?>
						<tr valign="top">
							<th colspan="2">
								<span style="padding: 10px;" class="error"><?php _e( 'The configuration of your server will prevent response caching.', 'google-analytics-dashboard' ); ?></span>
							</th>
						</tr>
					<?php
					}
					?>

					<tr valign="top">
						<th scope="row">&nbsp;</th>
						<td>&nbsp;</td>
					</tr>

					<tr valign="top">
						<th scope="row">
							<label for="ga_goal_one"><?php _e( 'Goal #1 Label', 'google-analytics-dashboard' ); ?></label></th>
						<td><input value="<?php echo esc_attr( get_option( 'gad_goal_one' ) ); ?>" name="ga_goal_one" id="ga_goal_one" /></td>
					</tr>

					<tr valign="top">
						<th scope="row">
							<label for="ga_goal_two"><?php _e( 'Goal #2 Label', 'google-analytics-dashboard' ); ?></label></th>
						<td><input value="<?php echo esc_attr( get_option( 'gad_goal_two' ) ); ?>" name="ga_goal_two" id="ga_goal_two" /></td>
					</tr>

					<tr valign="top">
						<th scope="row">
							<label for="ga_goal_three"><?php _e( 'Goal #3 Label', 'google-analytics-dashboard' ); ?></label></th>
						<td><input value="<?php echo esc_attr( get_option( 'gad_goal_three' ) ); ?>" name="ga_goal_three" id="ga_goal_three" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row">
							<label for="ga_goal_four"><?php _e( 'Goal #4 Label', 'google-analytics-dashboard' ); ?></label></th>
						<td><input value="<?php echo esc_attr( get_option( 'gad_goal_four' ) ); ?>" name="ga_goal_four" id="ga_goal_four" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row">
							<label for="ga_disable_post_stats"><?php _e( 'Disable Post Stats Display', 'google-analytics-dashboard' ); ?></label>
						</th>
						<td>
							<input name="ga_disable_post_stats" type="checkbox" id="ga_disable_post_stats" value="ga_disable_post_stats" <?php echo ( get_option( 'gad_disable_post_stats' ) == 'true' ) ? 'checked' : ''; ?> />
						</td>
					</tr>
				</table>

				<p class="submit">
					<input type="submit" name="SubmitOptions" class="button-primary" value="<?php _e( 'Save Changes', 'google-analytics-dashboard' ); ?>" />
				</p>

			</form>

		</div>

	<?php
	}

	function display_admin_handle_login_options( $gauth ) {
		?>

		<div class="wrap" style="padding-top: 50px;">

			<?php $this->display_messages(); ?>

			<form action="" method="post">
				<input type="hidden" name="gad_login_type" value="oauth" />

				<table class="form-table">

					<tr valign="top">
						<th><?php _e( 'Login using Google\'s OAuth system.', 'google-analytics-dashboard' ); ?></th>
					</tr>

					<tr valign="top">
						<th><?php _e( 'This is the prefered method of attaching your Google account.<br/>
                Clicking the "Start the Login Process" button will redirect you to a login page at google.com.<br/>
                After accepting the login there you will be returned here.', 'google-analytics-dashboard' ); ?></th>
					</tr>

					<tr valign="top">
						<td><p class="submit">
								<input type="submit" name="SubmitLogin" class="button-primary" value="<?php _e( 'Start the Login Process &raquo;', 'google-analytics-dashboard' ); ?>" />
							</p></td>
					</tr>

				</table>

			</form>

			<p style="padding-top: 20px;" />

			<form action="" method="post">
				<input type="hidden" name="gad_login_type" value="client" />

				<table class="form-table">

					<tr valign="top" style="border-top: 1px solid;">
						<th scope="row" colspan="2"><?php _e( 'You can still use the older authentication system but it is not recommended.', 'google-analytics-dashboard' ); ?></th>
					</tr>

					<tr valign="top">
						<th scope="row">
							<label for="ga_email"><?php _e( 'Google Analytics Email', 'google-analytics-dashboard' ); ?></label></th>
						<td>
							<input name="ga_email" type="text" size="15" id="ga_email" class="regular-text" value="<?php echo isset( $_POST['ga_email'] ) ? $_POST['ga_email'] : get_option( 'gad_login_email' ); ?>" />
						</td>
					</tr>

					<tr valign="top">
						<th scope="row">
							<label for="ga_pass"><?php _e( 'Google Analytics Password', 'google-analytics-dashboard' ); ?></label>
						</th>
						<td><input name="ga_pass" type="password" size="15" id="ga_pass" class="regular-text" value="" /></td>
					</tr>

					<?php if ( isset( $gauth ) && $gauth->requiresCaptcha() ) : ?>
						<tr valign="top">
							<th scope="row">
								<label for="ga_captcha"><?php _e( 'Google CAPTCHA', 'google-analytics-dashboard' ); ?></label></th>
							<td>
								<img src="<?php echo $gauth->getCaptchaImageURL(); ?>" /><br /><br />
								<input name="ga_captcha" type="text" size="10" id="ga_captcha" class="regular-text" value="" />
								<input type="hidden" name="ga_captcha_token" value="<?php echo $gauth->getCaptchaToken(); ?>" />
							</td>
						</tr>
					<?php endif; ?>

					<tr valign="top">
						<th scope="row">
							<label for="ga_save_pass"><?php _e( 'Save Password', 'google-analytics-dashboard' ); ?></label></th>
						<td>
							<input name="ga_save_pass" type="checkbox" id="ga_save_pass" value="ga_save_pass" <?php if ( isset( $_POST['ga_save_pass'] ) || get_option( 'gad_login_pass' ) !== false ) {
								echo 'checked';
							} ?> />
						</td>
					</tr>

				</table>

				<p class="submit">
					<input type="submit" name="SubmitLogin" class="button-primary" value="<?php _e( 'Login &raquo;' ); ?>" />
				</p>
			</form>

		</div>

	<?php
	}

	function display_messages() {
		if ( isset( $this->info_message ) && trim( $this->info_message ) != '' ) {
			echo '<div id="message" class="updated fade"><p><strong>' . $this->info_message . '</strong></p></div>';
		}
		if ( isset( $this->error_message ) && trim( $this->error_message ) != '' ) {
			echo '<div id="message" class="error fade"><p><strong>' . $this->error_message . '</strong></p></div>';
		}
	}
}
