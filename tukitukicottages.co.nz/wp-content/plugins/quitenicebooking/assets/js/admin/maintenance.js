(function($){
$(document).ready(function(){

	/**
	 * Diagnostics script
	 */
	$('#quitenicebooking_diagnostics').on('click', function(e) {
		e.preventDefault();
		var formdata = {
			action: 'quitenicebooking_maintenance_ajax',
			run: 'diagnostics'
		};
		$.post(quitenicebooking.ajax_url, formdata, function(response) {
			$('#quitenicebooking_ajax_output').css('display', 'block');
			$('#quitenicebooking_ajax_output').html(response);
		});
	});

	/**
	 * Reset script
	 */
	$('#quitenicebooking_reset').on('click', function(e) {
		e.preventDefault();
		var p = confirm('Warning: You are about to reset the plugin.  Your current settings will be discarded.  Proceed?');
		if (!p) {
			return false;
		}
		var formdata = {
			action: 'quitenicebooking_maintenance_ajax',
			run: 'reset'
		};
		$.post(quitenicebooking.ajax_url, formdata, function(response) {
			$('#quitenicebooking_ajax_output').css('display', 'block');
			alert(response);
		});
	});

	/**
	 * Repair settings script
	 */
	$('#quitenicebooking_repair_settings').on('click', function(e) {
		e.preventDefault();
		var formdata = {
			action: 'quitenicebooking_maintenance_ajax',
			run: 'repair_settings'
		};
		$.post(quitenicebooking.ajax_url, formdata, function(response) {
			$('#quitenicebooking_ajax_output').css('display', 'block');
			$('#quitenicebooking_ajax_output').html(response);
		});
	});

	/**
	 * Repair accommodations script
	 */
	$('#quitenicebooking_repair_accommodations').on('click', function(e) {
		e.preventDefault();
		var p = confirm('Warning: If you have switched pricing schemes, this will remove data attached to the previous pricing scheme.  Your accommodations will be set to "pending review" status if any price fields are missing.  Proceed?');
		if (!p) {
			return false;
		}
		var formdata = {
			action: 'quitenicebooking_maintenance_ajax',
			run: 'repair_accommodations'
		};
		$.post(quitenicebooking.ajax_url, formdata, function(response) {
			$('#quitenicebooking_ajax_output').css('display', 'block');
			$('#quitenicebooking_ajax_output').html(response);
		});
	});

	/**
	 * Repair bookings script
	 */
	$('#quitenicebooking_repair_bookings').on('click', function(e) {
		e.preventDefault();
		var formdata = {
			action: 'quitenicebooking_maintenance_ajax',
			run: 'repair_bookings'
		};
		$.post(quitenicebooking.ajax_url, formdata, function(response) {
			$('#quitenicebooking_ajax_output').css('display', 'block');
			$('#quitenicebooking_ajax_output').html(response);
		});
	});

});
})(jQuery);