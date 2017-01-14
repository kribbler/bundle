jQuery(window).load(function(){
	// detect changes
	var changed = false;
	jQuery('#poststuff input, #poststuff select, #poststuff textarea').on('change', function() {
		changed = true;
	});
	window.onbeforeunload = function() {
		if (changed == true) {
			return 'The changes you made will be lost if you navigate away from this page.';
		}
	};
});

jQuery(document).ready(function() {
	// form validation
	jQuery('form').on('submit', function(e) {
		jQuery('#validation_errors').css('display', 'none');
		jQuery('#validation_errors').html('');
		var validationErrors = new Array();
		if (jQuery('#title').val().length == 0) {
			validationErrors.push('Please enter a title');
		}
		if (quitenicebooking.entity_scheme == 'per_person') {
			if (jQuery('#quitenicebooking_price_per_adult_weekday').val().trim().match(/^\d+\.?\d*$/) == null
			|| jQuery('#quitenicebooking_price_per_adult_weekend').val().trim().match(/^\d+\.?\d*$/) == null
			|| jQuery('#quitenicebooking_price_per_child_weekday').val().trim().match(/^\d+\.?\d*$/) == null
			|| jQuery('#quitenicebooking_price_per_child_weekend').val().trim().match(/^\d+\.?\d*$/) == null) {
				validationErrors.push('Please enter valid room prices (use the period . as decimal point)');
			}
		} else {
			if (jQuery('#quitenicebooking_price_per_room_weekday').val().trim().match(/^\d+\.?\d*$/) == null
			|| jQuery('#quitenicebooking_price_per_room_weekend').val().trim().match(/^\d+\.?\d*$/) == null) {
				validationErrors.push('Please enter valid room prices (use the period . as decimal point)');
			}
		}
		
		if (validationErrors.length > 0) {
			jQuery('#validation_errors').css('display', 'block');
			for (var i = 0; i < validationErrors.length; i ++) {
				jQuery('#validation_errors').append('<p><strong>'+validationErrors[i]+'</strong></p>');
			}
			jQuery('html, body').animate( { scrollTop: jQuery('div#validation_errors').offset().top-50 }, 1000);
			
			jQuery('#save-post').removeClass('button-disabled');
			jQuery('#publish').removeClass('button-primary-disabled');
			jQuery('.spinner').css('display', 'none');
			return false;
		}
	});
	
	/**
	 * Add jquery-ui-tabs to tabs
	 */
	jQuery('#quitenicebooking_tabs').tabs().addClass('ui-tabs-vertical ui-helper-clearfix');
	jQuery('#quitenicebooking_tabs').tabs().removeClass('ui-corner-top').addClass('ui-corner-left');
});
