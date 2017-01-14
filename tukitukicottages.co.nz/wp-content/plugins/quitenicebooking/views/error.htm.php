<?php if (isset($quitenicebooking_redirect) && !empty($quitenicebooking_redirect)) { ?>
	<script>
		setTimeout('window.location = "<?php echo $quitenicebooking_redirect; ?>"', 4000);
	</script>
<?php } ?>
<style>
	.booking-form-notice {
		display: block;
	}
</style>
<noscript>
	<style>
		.booking-form-notice p a {
			color: #fff;
		}
	</style>
</noscript>
<!-- BEGIN .booking-main-wrapper -->
<div class="booking-main-wrapper booking-main-wrapper-full">
	
	<!-- BEGIN .booking-main -->
	<div class="booking-main">
		<div class="dark-notice booking-form-notice">
			<?php foreach ($quitenicebooking_errors as $error ) { ?>
				<p><?php echo $error; ?></p>
			<?php } ?>
			<?php if (isset($quitenicebooking_redirect) && !empty($quitenicebooking_redirect)) { ?><noscript><p><a href="<?php echo $quitenicebooking_redirect; ?>"><?php _e('( Click here if page does not reload. )', 'quitenicebooking'); ?></a></p></noscript><?php } ?>
		</div>		
	<!-- END .booking-main -->
	</div>
	
<!-- END .booking-main-wrapper -->
</div>
