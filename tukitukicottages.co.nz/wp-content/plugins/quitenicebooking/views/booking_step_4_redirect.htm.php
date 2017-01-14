<?php if (isset($quitenicebooking_redirect) && !empty($quitenicebooking_redirect)) { ?>
	<script>
		setTimeout('window.location = "<?php echo $quitenicebooking_redirect; ?>"', 3000);
	</script>
<?php } ?>
<style>
	.booking-form-notice {
		display: block;
	}
	.booking-form-notice p a {
		color: #fff;
	}
</style>
<!-- BEGIN .booking-main-wrapper -->
<div class="booking-main-wrapper booking-main-wrapper-full">
	
	<!-- BEGIN .booking-main -->
	<div class="booking-main">
		<div class="dark-notice booking-form-notice">
			<p><?php _e('Please wait while we forward you to the payment page', 'quitenicebooking'); ?></p>
			<p><a href="<?php echo $quitenicebooking_redirect; ?>"><?php _e('Click here if it does not load', 'quitenicebooking'); ?></a></p>
		</div>		
	<!-- END .booking-main -->
	</div>
	
<!-- END .booking-main-wrapper -->
</div>
