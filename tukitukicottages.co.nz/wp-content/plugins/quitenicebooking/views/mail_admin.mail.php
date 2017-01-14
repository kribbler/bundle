<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title><?php echo $mailsubject; ?></title>
</head>
<body>
<?php printf(__('A new booking has been made. Please <a href="%s">log in</a> to your website for complete details.', 'quitenicebooking'), site_url('/wp-admin')); ?>
<hr />
<p><strong><?php _e('Booking ID', 'quitenicebooking'); ?>:</strong> <?php echo $data['booking_id']; ?></p>
<?php $n = 1; ?>
<?php foreach ($data['summary'] as $room) { ?>
<?php if (count($data['summary']) == 1) { ?>
<h4><?php _e('Room Info', 'quitenicebooking'); ?></h4>
<?php } else { ?>
<h4><?php printf(__('Room %d Info', 'quitenicebooking'), $n++); ?></h4>
<?php } ?>
<ul style="margin: 0px;padding:0 0 0 15px;">
<li style="margin-bottom: 3px;"><strong><?php _e('Room Type', 'quitenicebooking'); ?>:</strong> <?php echo $room['type']; ?></li>
<li style="margin-bottom: 3px;"><strong><?php _e('Date', 'quitenicebooking'); ?>:</strong> <?php echo $room['checkin']; ?> - <?php echo $room['checkout']; ?></li>
<li style="margin-bottom: 3px;"><strong><?php _e('Guests', 'quitenicebooking'); ?>:</strong> <?php echo $room['guests']; ?></li>
</ul>
<?php } // end foreach ?>
<h4><?php _e('Guest Info', 'quitenicebooking'); ?></h4>
<ul style="margin: 0px;padding:0 0 0 15px;">
<li style="margin-bottom: 3px;"><strong><?php _e('Name', 'quitenicebooking'); ?>:</strong> <?php echo $booking['guest_first_name'].' '.$booking['guest_last_name']; ?></li>
<li style="margin-bottom: 3px;"><strong><?php _e('Email Address', 'quitenicebooking'); ?>:</strong> <?php echo $booking['guest_email']; ?></li>
<?php foreach ($data['guest_details'] as $key => $field) { ?>
<li style="margin-bottom: 3px;"><strong><?php echo $field['label']; ?>:</strong> <?php echo is_string($field['value']) ? $field['value'] : (is_array($field['value']) ? implode(', ', $field['value']) : ''); ?></li>
<?php } ?>
<li style="margin-bottom: 3px;"><strong><?php _e('IP Address', 'quitenicebooking'); ?>:</strong> <?php echo $_SERVER['REMOTE_ADDR']; ?></li>
</ul>
<h4><?php _e('Payment', 'quitenicebooking'); ?></h4>
<ul style="margin: 0px;padding:0 0 0 15px;">
<?php if (!empty($this->settings['deposit_type']) && ((!empty($this->settings['accept_paypal']) && !empty($this->settings['paypal_email_address'])) || !empty($this->settings['accept_bank_transfer']))) { ?>
<li style="margin-bottom: 3px;"><strong><?php _e('Deposit Due', 'quitenicebooking'); ?>:</strong> <?php echo Quitenicebooking_Utilities::format_price(number_format($data['deposit']), $this->settings); ?></li>
<?php } // end if ?>
<li style="margin-bottom: 3px;"><strong><?php _e('Total Price', 'quitenicebooking'); ?>:</strong> <?php echo Quitenicebooking_Utilities::format_price(number_format($data['total']), $this->settings); ?></li>
</ul>
</body>
</html>
