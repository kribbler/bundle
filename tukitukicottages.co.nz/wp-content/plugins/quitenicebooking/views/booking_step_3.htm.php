<style>
.pp_content td {
	width: 50%;
}
.booking-form-notice-2 {
	display: block;
}
</style>
<!-- BEGIN .booking-step-wrapper -->
<div class="booking-step-wrapper clearfix">

	<div class="step-wrapper">
		<div class="step-icon-wrapper">
			<div class="step-icon">1.</div>
		</div>
		<div class="step-title"><?php _e('Choose Your Date','quitenicebooking'); ?></div>
	</div>

	<div class="step-wrapper">
		<div class="step-icon-wrapper">
			<div class="step-icon">2.</div>
		</div>
		<div class="step-title"><?php _e('Choose Your Room','quitenicebooking'); ?></div>
	</div>

	<div class="step-wrapper">
		<div class="step-icon-wrapper">
			<div class="step-icon step-icon-current">3.</div>
		</div>
		<div class="step-title"><?php _e('Place Your Reservation','quitenicebooking'); ?></div>
	</div>

	<div class="step-wrapper last-col">
		<div class="step-icon-wrapper">
			<div class="step-icon">4.</div>
		</div>
		<div class="step-title"><?php _e('Confirmation','quitenicebooking'); ?></div>
	</div>

	<div class="step-line"></div>

<!-- END .booking-step-wrapper -->
</div>

<!-- BEGIN .booking-main-wrapper -->
<div class="booking-main-wrapper">

	<!-- BEGIN .booking-main -->
	<div class="booking-main">
		
		<!-- BEGIN .booking-errors -->
		<noscript>
			<div class="dark-notice booking-form-notice-2">
				<?php _e('Please enable Javascript in your web browser for an optimal browsing experience', 'quitenicebooking'); ?>
			</div>
		</noscript>
		<?php if (isset($quitenicebooking_errors) && count($quitenicebooking_errors) > 0) { ?>
		<div class="dark-notice booking-form-notice-2">
			<p><strong><?php _e('Please correct the following errors in your booking:', 'quitenicebooking'); ?></strong></p><br>
			<ul>
				<?php foreach ($quitenicebooking_errors as $e) { ?>
					<li><?php echo $e; ?></li>
				<?php } ?>
			</ul>
		</div><br>
		<?php } ?>
		<!-- END .booking-errors -->

		<div class="dark-notice booking-form-notice"></div>
	
		<h4 class="title-style4"><?php _e('Guest Details', 'quitenicebooking'); ?><span class="title-block"></span></h4>
		
		<form action="<?php echo $quitenicebooking_step_4_url; ?>" class="booking-fields-form clearfix" method="POST">
			<?php $colcount = 1; ?>
			<?php foreach ($quitenicebooking_form_fields as $field) { ?>
				<?php if ($field['type'] == 'guest_first_name') { // predefined ?>
					<div class="input-field <?php echo $colcount % 2 == 0 ? 'last-col' : ''; ?>">
						<label for="guest_first_name"><?php _e('First Name', 'quitenicebooking'); ?> *</label>
						<input type="text" name="guest_first_name" id="guest_first_name" value="<?php echo !empty($quitenicebooking_guest_first_name) ? $quitenicebooking_guest_first_name : ''; ?>">
					</div>
				<?php } elseif ($field['type'] == 'guest_last_name') { // predefined ?>
					<div class="input-field <?php echo $colcount % 2 == 0 ? 'last-col' : ''; ?>">
						<label for="guest_last_name"><?php _e('Last Name','quitenicebooking'); ?> *</label>
						<input type="text" name="guest_last_name" id="guest_last_name" value="<?php echo !empty($quitenicebooking_guest_last_name) ? $quitenicebooking_guest_last_name : ''; ?>">
					</div>
				<?php } elseif ($field['type'] == 'guest_email') { // predefined ?>
					<div class="input-field <?php echo $colcount % 2 == 0 ? 'last-col' : ''; ?>">
						<label for="guest_email"><?php _e('Email Address','quitenicebooking'); ?> *</label>
						<input type="text" name="guest_email" id="guest_email" value="<?php echo !empty($quitenicebooking_guest_email) ? $quitenicebooking_guest_email : ''; ?>">
					</div>
				<?php } elseif ($field['type'] == 'text') { // text field ?>
					<div class="input-field <?php echo $colcount % 2 == 0 ? 'last-col' : ''; ?>">
						<label for="guest_details_<?php echo $field['id']; ?>"><?php echo $field['label']; ?><?php echo !empty($field['required']) ? ' *' : ''; ?></label>
						<input type="text" name="guest_details_<?php echo $field['id']; ?>" id="guest_details_<?php echo $field['id']; ?>" value="<?php echo !empty(${'quitenicebooking_guest_details_'.$field['id']}) ? ${'quitenicebooking_guest_details_'.$field['id']} : ''; ?>" <?php echo !empty($field['required']) ? 'data-required="1"' : ''; ?> <?php echo !empty($field['class']) ? 'class="'.$field['class'].'"' : ''; ?> <?php echo !empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : ''; ?>>
					</div>
				<?php } elseif ($field['type'] == 'textarea') { // textarea field ?>
					<div class="input-field-full-width clearboth">
						<label for="guest_details_<?php echo $field['id']; ?>"><?php echo $field['label']; ?><?php echo !empty($field['required']) ? ' *' : ''; ?></label>
						<textarea name="guest_details_<?php echo $field['id']; ?>" id="guest_details_<?php echo $field['id']; ?>" rows="10" <?php echo !empty($field['required']) ? 'data-required="1"' : ''; ?> <?php echo !empty($field['class']) ? 'class="'.$field['class'].'"' : ''; ?> <?php echo !empty($field['maxlength']) ? 'maxlength="'.$field['maxlength'].'"' : ''; ?>><?php echo !empty(${'quitenicebooking_guest_details_'.$field['id']}) ? ${'quitenicebooking_guest_details_'.$field['id']} : ''; ?></textarea>
					</div>
				<?php } elseif ($field['type'] == 'checkbox') { // checkbox field ?>
					<div class="input-field <?php echo $colcount % 2 == 0 ? 'last-col' : ''; ?>">
						<label for="guest_details_<?php echo $field['id']; ?>"><?php echo $field['label']; ?><?php echo !empty($field['required']) ? ' *' : ''; ?></label>
						<input type="hidden" name="guest_details_<?php echo $field['id']; ?>" id="guest_details_<?php echo $field['id']; ?>" value="">
						<?php $c = 1; ?>
						<?php foreach ($field['choices'] as $choice) { ?>
							<input type="checkbox" name="guest_details_<?php echo $field['id']; ?>[]" id="guest_details_<?php echo $field['id']; ?>_<?php echo $c; ?>" value="<?php echo htmlentities($choice); ?>" <?php echo !empty($field['required']) ? 'data-required="1"' : ''; ?>><label for="guest_details_<?php echo $field['id']; ?>_<?php echo $c ++; ?>"><?php echo $choice; ?></label>
						<?php } ?>
					</div>
				<?php } elseif ($field['type'] == 'radio') { // radio field ?>
					<div class="input-field <?php echo $colcount % 2 == 0 ? 'last-col' : ''; ?>">
						<label for="guest_details_<?php echo $field['id']; ?>"><?php echo $field['label']; ?><?php echo !empty($field['required']) ? ' *' : ''; ?></label>
						<?php $c = 1; ?>
						<?php foreach ($field['choices'] as $choice) { ?>
							<input type="radio" name="guest_details_<?php echo $field['id']; ?>" id="guest_details_<?php echo $field['id']; ?>_<?php echo $c; ?>" value="<?php echo htmlentities($choice); ?>" <?php echo !empty($field['required']) ? 'data-required="1"' : ''; ?>><label for="guest_details_<?php echo $field['id']; ?>_<?php echo $c ++; ?>"><?php echo $choice; ?></label>
						<?php } ?>
					</div>
				<?php } elseif ($field['type'] == 'select') { // select field ?>
					<div class="input-field <?php echo $colcount % 2 == 0 ? 'last-col' : ''; ?>">
						<label for="guest_details_<?php echo $field['id']; ?>"><?php echo $field['label']; ?><?php echo !empty($field['required']) ? ' *' : ''; ?></label>
						<select name="guest_details_<?php echo $field['id']; ?>[]" id="guest_details_<?php echo $field['id']; ?>" <?php echo !empty($field['multiple']) ? 'multiple' : ''; ?> <?php echo !empty($field['required']) ? 'data-required="1"' : ''; ?>>
							<?php foreach ($field['choices'] as $choice) { ?>
								<option value="<?php echo htmlentities($choice); ?>"><?php echo $choice; ?></option>
							<?php } ?>
						</select>
					</div>
				<?php } ?>
				<?php $colcount ++; ?>
			<?php } // end foreach ?>

			<?php if (!empty($quitenicebooking_coupons_enabled)) { ?>
				<?php $couponcount = 1; ?>
				<?php if (isset($quitenicebooking_applied_coupons)) { ?>
					<?php foreach ($quitenicebooking_applied_coupons as $ac) { ?>
						<?php // display the applied coupons ?>
						<div class="coupon clearfix">
							<div class="input-field">
								<input type="hidden" name="<?php echo "coupon_code_{$couponcount}"; ?>" value="<?php echo $ac; ?>"> <?php printf(__('Coupon code applied: %s', 'quitenicebooking'), $ac); ?>
							</div>
							<div class="input-field last-col">
								<button type="submit" name="remove_coupon" value="<?php echo "coupon_code_{$couponcount}"; ?>" class="button2"><?php _e('Remove Coupon', 'quitenicebooking'); ?></button>
							</div>
						</div>
						<?php $couponcount ++; ?>
					<?php } ?>
				<?php } ?>
				<?php // display the input for the next coupon ?>
				<div class="coupon clearfix">
					<div class="input-field">
						<label for="<?php echo "coupon_code_{$couponcount}"; ?>"><?php _e('Coupon Code'); ?></label><input type="text" name="<?php echo "coupon_code_{$couponcount}"; ?>" id="<?php echo "coupon_code_{$couponcount}"; ?>">
					</div>
					<div class="input-field last-col">
						<label>&nbsp;</label>
						<button type="submit" name="apply_coupon" value="<?php echo "coupon_code_{$couponcount}"; ?>" class="button2"><?php _e('Apply Coupon', 'quitenicebooking'); ?></button>
					</div>
				</div>

			<?php } ?>

			<div class="payment_method">
			<?php $accept_deposit = FALSE; ?>
			<?php if ($quitenicebooking_deposit_type != '') { ?>
				<?php if (!empty($quitenicebooking_accept_paypal) && !empty($quitenicebooking_paypal_email_address)) { ?>
					<h3><input type="radio" name="payment_method" value="paypal" id="payment_method_paypal"><label for="payment_method_paypal"><?php _e('Paypal', 'quitenicebooking'); ?></label></h3>
					<div>
						<p><?php _e('Pay via Paypal.  Accepts MasterCard, VISA, American Express, and Discover cards.', 'quitenicebooking'); ?></p>
					</div>
					<?php $accept_deposit = TRUE; ?>
				<?php } // end if ?>
					
				<?php if (!empty($quitenicebooking_accept_bank_transfer)) { ?>
					<h3><input type="radio" name="payment_method" value="bank_transfer" id="payment_method_bank_transfer"><label for="payment_method_bank_transfer"><?php _e('Direct bank transfer', 'quitenicebooking'); ?></label></h3>
					<div>
						<p><?php _e('Make your payment directly into our bank account.', 'quitenicebooking'); ?></p>
					</div>
					<?php $accept_deposit = TRUE; ?>
				<?php } ?>				
			<?php } ?>
			</div>
			
			<div class="clearfix"></div>

			<?php if (!empty($quitenicebooking_terms_and_conditions)) { ?>
			<!-- BEGIN #terms_conditions -->
			<div id="terms_conditions" class="hide">
				<div class="lightbox-title">
					<h4 class="title-style4"><?php _e('Terms and Conditions','quitenicebooking'); ?><span class="title-block"></span></h4>
				</div>
				<div class="page-content">
					<?php echo nl2br($quitenicebooking_terms_and_conditions); ?>
				</div>
			<!-- END #terms_conditions -->
			</div>
			
			<p class="terms"><input type="checkbox" name="terms" id="terms_check"> <?php _e('I have read and accept the','quitenicebooking'); ?> <a rel="prettyPhoto" href="#terms_conditions"><?php _e('terms and conditions','quitenicebooking'); ?></a>.</p>
			<?php } ?>
	
			<input type="submit" class="submit" name="booking_step_3_submit" value="<?php $accept_deposit ? _e('Book Now &amp; Pay Deposit', 'quitenicebooking') : _e('Book Now', 'quitenicebooking') ?>">
	
		</form>
		
	<!-- END .booking-main -->
	</div>
<!-- END .booking-main-wrapper -->
</div>

<!-- BEGIN .booking-side-wrapper -->
<div class="booking-side-wrapper">

	<!-- BEGIN .booking-side -->
	<div class="booking-side clearfix">

		<?php $n = 1; ?>
		<?php foreach ($quitenicebooking_summary as $room) { ?>
			<?php if (count($quitenicebooking_summary) == 1) { ?>
				<h4 class="title-style4"><?php _e('Your Reservation', 'quitenicebooking'); ?><span class="title-block"></span></h4>
			<?php } else { ?>
				<h4 class="title-style4"><?php printf(__('Room %d of %d', 'quitenicebooking'), $n++, $quitenicebooking_total_rooms); ?><span class="title-block"></span></h4>
			<?php } ?>
			<ul>
				<li><span><?php _e('Room', 'quitenicebooking'); ?>:</span> <?php echo $room['type'];?> </li>
				<li><span><?php _e('Check In', 'quitenicebooking'); ?>:</span> <?php echo $room['checkin'];?> </li>
				<li><span><?php _e('Check Out', 'quitenicebooking'); ?>:</span> <?php echo $room['checkout'];?> </li>
				<li><span><?php _e('Guests', 'quitenicebooking'); ?>:</span> <?php echo $room['guests'];?> </li>
			</ul>
		<?php } // end foreach ?>
		
		<!-- BEGIN .price-details -->
		<div class="price-details">
			<?php if ($accept_deposit && $quitenicebooking_deposit_type == 'percentage') { ?>
				
				
				<hr class="total-line" />
				<p class="total"><?php _e('Total Price', 'quitenicebooking'); ?></p>
			<?php } elseif ($accept_deposit && ($quitenicebooking_deposit_type == 'flat' || $quitenicebooking_deposit_type == 'duration')) { ?>
				
				<h3 class="price"><?php echo Quitenicebooking_Utilities::format_price(number_format($quitenicebooking_deposit), $this->settings); ?></h3>
				<hr class="total-line" />
				<p class="total"><?php _e('Total Price', 'quitenicebooking'); ?></p>
			<?php } else { ?>
				<p class="total-only"><?php _e('Total Price', 'quitenicebooking'); ?></p>
			<?php } ?>
				<h3 class="total-price"><?php echo Quitenicebooking_Utilities::format_price(number_format($quitenicebooking_total), $this->settings); ?></h3>
			<p class="price-breakdown"><a rel="prettyPhoto" href="#price_break_hotel_room_all"><?php _e('View Price Breakdown', 'quitenicebooking'); ?></a></p>
			<div id="price_break_hotel_room_all" class="hide">
				
				<!-- BEGIN .lightbox-title -->
				<div class="lightbox-title">
					<h4 class="title-style4"><?php _e('Price Breakdown','quitenicebooking'); ?><span class="title-block"></span></h4>
				<!-- END .lightbox-title -->
				</div>
				
				<!-- BEGIN .page-content -->
				<div class="page-content">
					
					<?php $i = 1; ?>
					<?php foreach ($quitenicebooking_breakdown as $b) { ?>
						<?php if (count($quitenicebooking_breakdown) > 1) { ?>
							<h4 class="room-title"><?php printf(__('Room %d: %s', 'quitenicebooking'), $i ++, $b['type']); ?></h4>
						<?php } ?>
						<table><tbody>
							<?php foreach ($b['breakdown'] as $day) { ?>
								<tr>
									<td data-title="<?php _e('Date', 'quitenicebooking'); ?>"><?php echo $day['date_string']; ?></td>
									<td data-title="<?php _e('Price', 'quitenicebooking'); ?>"><?php echo $day['price_string']; ?></td>
								</tr>
							<?php } ?>
							<tr>
								<td><?php _e('Subtotal', 'quitenicebooking'); ?></td>
								<td><?php echo Quitenicebooking_Utilities::format_price(number_format($b['total']), $this->settings); ?></td>
							</tr>
						</tbody></table>
					<?php } // end foreach ?>
					<?php if (!empty($quitenicebooking_discounts)) { ?>
					<table><tbody>
						<?php foreach ($quitenicebooking_discounts as $d) { ?>
							<tr>
								<td><?php echo $d['description']; ?></td>
								<td><?php echo $d['amount']; ?></td>
							</tr>
						<?php } ?>
					</tbody></table>
					<?php } ?>
					<table><tbody>
						<tr>
							<td><?php _e('Total', 'quitenicebooking'); ?></td>
							<td><?php echo Quitenicebooking_Utilities::format_price(number_format($quitenicebooking_total), $this->settings); ?></td>
						</tr>
					</tbody></table>
				<!-- END .page-content -->
				</div>
			<!-- END #price_break_hotel_room_all -->
			</div>
		<!-- END .price-details -->
		</div>
		
		<hr class="space9" />
		
	<!-- END .booking-side -->
	</div>
	
<!-- END .booking-side-wrapper -->
</div>

<div class="clearboth"></div>
