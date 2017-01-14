<!-- BEGIN .booking-main-wrapper -->
<div class="booking-main-wrapper booking-main-wrapper-full">
	
	<!-- BEGIN .booking-main -->
	<div class="booking-main">
		
		<!-- BEGIN .booking-left -->
		<div class="booking-left">
			<h4 class="title-style4"><?php _e('Payment Canceled', 'quitenicebooking'); ?><span class="title-block"></span></h4>
			<p><?php echo $quitenicebooking_payment_fail_message; ?></p>
		<!-- END .booking-left -->
		</div>
		
		<!-- BEGIN .booking-right -->
		<div class="booking-right">
			<ul class="contact_details_list contact_details_list_dark">
				<?php if (!empty($quitenicebooking_phone_number)) { ?>
					<li class="phone_list"><strong><?php _e('Phone', 'quitenicebooking'); ?>:</strong> <?php echo $quitenicebooking_phone_number; ?></li>
				<?php } ?>
				
				<?php if (!empty($quitenicebooking_fax_number)) { ?>
					<li class="fax_list"><strong><?php _e('Fax', 'quitenicebooking'); ?>:</strong> <?php echo $quitenicebooking_fax_number; ?></li>
				<?php } ?>
				
				<?php if (!empty($quitenicebooking_email_address)) { ?>
					<li class="email_list"><strong><?php _e('Email', 'quitenicebooking'); ?>:</strong> <a href="mailto:<?php echo $quitenicebooking_email_address; ?>"><?php echo $quitenicebooking_email_address; ?></a></li>
				<?php } ?>
			</ul>
		<!-- END .booking-right -->
		</div>
		
		<div class="clearboth"></div>
	
	<!-- END .booking-main -->
	</div>
	
<!-- END .booking-main-wrapper -->
</div>
