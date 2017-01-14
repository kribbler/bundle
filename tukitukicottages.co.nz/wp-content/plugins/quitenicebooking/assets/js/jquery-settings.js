/**
 * Settings for the jQuery scripts
 *
 * Dependencies: jqueryui.datepicker, jqueryui.pulsate, prettyphoto
 *
 * global string quitenicebooking.date_format The date format from the plugin's settings: dd/mm/yy, mm/dd/yy, or yy/mm/dd
 * global string quitenicebooking.validationerror_requiredfield Validation error message
 * global string quitenicebooking.validationerror_email Validation error message
 * global string quitenicebooking.validationerror_paymentmethod Validation error message
 * global string quitenicebooking.validationerror_tos Validation error message
 */

// dictionary of unavailable dates
var blocked = {};

jQuery(document).ready(function() {
	
	'use strict';
	
	/**
	 * PrettyPhoto ============================================================
	 */
	jQuery('a[rel^="prettyPhoto"]').prettyPhoto({social_tools:false});
	
	// Calendar Message
	jQuery('.datepicker2').click(function(e){
        jQuery('.ui-datepicker-calendar').effect('pulsate', { times:2 }, 1000);
		jQuery('.calendar-notice').fadeIn(1200, function() {
			// Animation complete
		});
		e.stopPropagation();
    });

	/**
	 * Toggle rooms ===========================================================
	 */
	
	// initial procedures

	// hide all rooms except for room-1
	jQuery('.rooms-wrapper div[class^="room-"]:not(div.room-1)').hide();
	jQuery('div.room-1 p.label').hide();

	// if the form was reloaded and already populated, run once to prevent rooms from being hidden
	toggle_rooms(jQuery('#room_qty').val());

	// event listener for when the room quantity drop-down changes
	jQuery('#room_qty').on('change', function(e) {
		e.preventDefault();
		toggle_rooms(jQuery('#room_qty').val());
	});

	/**
	 * Shows the appropriate number of rooms depending how many are selected in the drop-down
	 *
	 * param int room_qty The number of rooms to show; pass in the value from #room_qty
	 */
	function toggle_rooms(room_qty) {
		jQuery('.rooms-wrapper div[class^="room-"]').hide(); // hide everything at first
		for (var i = 1; i <= room_qty; i++) {
			jQuery('div[class^=room-'+ i +']').show(); // show all rooms up to room_qty
		}
		// case for if room_qty == 1, hide its p label
		if (room_qty == 1) {
			jQuery('div.room-1 p.label').hide();
		} else {
			jQuery('div.room-1 p.label').show();
		}
	}

	/**
	 * Datepicker =============================================================
	 *
	 * Note: Since the availability checker AJAX is synchronous (to reduce server load), Datepicker should run last, to prevent holding up other functions
	 */

	/**
	 * Add a custom event for datepicker to fire after it renders
	 */
	jQuery(function() {
		jQuery.datepicker._updateDatepicker_original = jQuery.datepicker._updateDatepicker;
		jQuery.datepicker._updateDatepicker = function(inst) {
			jQuery.datepicker._updateDatepicker_original(inst);
			var afterShow = this._get(inst, 'afterShow');
			if (afterShow)
				afterShow.apply((inst.input ? inst.input[0] : null));  // trigger custom callback
		}
	});

	// Attach Datepicker to widget
	jQuery('.datepicker').datepicker({
		minDate: 0,
		dateFormat: quitenicebooking.date_format,
		beforeShowDay: open_datepicker_widget,
		onChangeMonthYear: show_throbber_widget,
		afterShow: hide_throbber_widget
	});
	
	// Make Datepicker Fields Read Only
	jQuery('#datefrom').attr('readonly', true);
	jQuery('#dateto').attr('readonly', true);

	// Attach Datepicker to step 1
    jQuery('#open_datepicker').datepicker({
        dateFormat: quitenicebooking.date_format,
        numberOfMonths: 2,
        minDate: 0,
        beforeShowDay: open_datepicker,
		onChangeMonthYear: show_throbber,
		afterShow: hide_throbber,
        onSelect: select_dates
    });
	// hide the throbber after calendar loads
	hide_throbber();

	// show the throbber when changing month/year
	function show_throbber() {
		jQuery('#datepicker-loading-spinner').css('display', '');
	}

	// hide the throbber after calendar loads
	function hide_throbber() {
		jQuery('#datepicker-loading-spinner').css('display', 'none');
	}

	// wrapper function when opening datepicker via widget
	function open_datepicker_widget(date) {
		if (blockedDates(date)) {
			return [true];
		}
		return [false];
	}

	// save the original background image before swapping out with the throbber
	var date_input_background = jQuery('#datefrom').css('background-image');
	var date_input_position = jQuery('#datefrom').css('background-position');

	// put the throbber in the input field if datepicker is being loaded for the first time, hence a delay in opening
	jQuery('#datefrom, #dateto').on('mousedown', function() {
		if (jQuery('#ui-datepicker-div').css('display') == 'none' && jQuery('#open_datepicker').length == 0) {
			jQuery(this).css({
				'background-image': 'url(\''+quitenicebooking.plugin_url+'assets/images/calendar_widget_loading.gif\')',
				'background-position': '95% 50%'
			});
		}
	});

	function show_throbber_widget() {
		jQuery('#ui-datepicker-div').css({
			'width': '217px',
			'height': '218px',
			'background-image': 'url(\''+quitenicebooking.plugin_url+'assets/images/calendar_loading.gif\')',
			'background-repeat': 'no-repeat',
			'background-position': '50% 50%'
		});
	}

	function hide_throbber_widget() {
		jQuery('#ui-datepicker-div').css({
			'width': '',
			'height': '',
			'background-image': ''
		});

		// restore the input field throbber
		if (jQuery('#datefrom').css('background-image') != date_input_background
			|| jQuery('#dateto').css('background-image') != date_input_background) {
			jQuery('#datefrom, #dateto').css({
				'background-image': date_input_background,
				'background-position': date_input_position
			});
		}
	}

	// wrapper function when opening datepicker
	function open_datepicker(date) {
		// check if dates blocked
		if (blockedDates(date)) {
			// if dates not blocked
			// highlight selected dates
			var date1 = jQuery.datepicker.parseDate(quitenicebooking.date_format, jQuery('#datefrom').val());
			var date2 = jQuery.datepicker.parseDate(quitenicebooking.date_format, jQuery('#dateto').val());
			return [true, date1 && ((date.getTime() == date1.getTime()) || (date2 && date >= date1 && date <= date2)) ? 'dp-highlight' : ''];
		}
		else {
			return [false];
		}
	}

	// select dates
	// inserts the clicked date into the appropriate datefrom/dateto field
	function select_dates(dateText, inst) {
		var dateTextForParse = (inst.currentMonth + 1) + '/' + inst.currentDay + '/' + inst.currentYear;
		var date1 = jQuery.datepicker.parseDate(quitenicebooking.date_format, jQuery('#datefrom').val());
		var date2 = jQuery.datepicker.parseDate(quitenicebooking.date_format, jQuery('#dateto').val());

		// if date1 .. date2 crosses over blocked dates, don't set date2
		// 1. for each day starting from date1 until date2:
		//    2. check if day is in blocked
		//       3. if blocked, set #dateto to ''
		var day = new Date(date1);
		var end = new Date(dateTextForParse);
		var dayblocked = false;
		if (date1) {
			while (day <= end) {
				if (jQuery.inArray(day.getDate(), blocked['y'+day.getFullYear()]['m'+(day.getMonth() + 1)]) != -1) {
					dayblocked = true;
					break;
				}
				day.setDate(day.getDate() + 1);
			}
		}

		if (!date1 || date2 || dayblocked == true) {
			jQuery('#datefrom').val(dateText);
			jQuery('#dateto').val('');
		} else {
			if (Date.parse(dateTextForParse) < Date.parse(date1))
			{
				jQuery('#datefrom').val(dateText);
				jQuery('#dateto').val('');
			}
			else
			{
				jQuery('#dateto').val(dateText);
			}
		}
	};

	/**
	 * Datepicker availability check
	 *
	 * @param Date date
	 * @return boolean true if date available, false if not
	 */
	function blockedDates(date) {
		var yy = 'y'+date.getFullYear();
		var mm = 'm'+(parseInt(date.getMonth())+1);

		var type = jQuery('input[name="highlight"]').val() || '';

		if (!blocked.hasOwnProperty(yy) || !blocked[yy].hasOwnProperty(mm)) {
			getBlockedDates(date.getFullYear(), parseInt(date.getMonth())+1, type);
		}

		if (jQuery.inArray(date.getDate(), blocked[yy][mm]) != -1) {
			return false;
		}

		return true;
	}

	/**
	 * Ajax call to get unavailable dates
	 *
	 * Adds array of blocked days to blocked
	 *
	 * @global object quitenicebooking
	 * @global object blocked
	 * @param int year
	 * @param int month
	 * @param int type or empty string
	 */
	function getBlockedDates(year, month, type) {
		jQuery.ajax({
			async: false, // wait for the function to finish before executing again
			type: 'GET',
			url: quitenicebooking.ajax_url,
			data: {year: year, month: month, action: 'quitenicebooking_ajax_calendar_availability', type: type},
			success: function(response) { // response is a json-encoded array of unavailable dates
				if (!blocked.hasOwnProperty('y'+year)) {
					blocked['y'+year] = {};
				}
				if (!blocked['y'+year].hasOwnProperty('m'+month)) {
					blocked['y'+year]['m'+month] = response;
				}
			},
			dataType: 'json'
		});
	}
	
	/**
	 * Widget, step 1, step 2 - Form validation ===============================
	 */
	
	// event listener for form submission
	// validate all data here.  if JS is disabled, WP's form handler will have a fallback
	jQuery('.booking-form').on('submit', function() {
	
		// validate dates
		// check for default or no values
		if (jQuery('#datefrom').val() == quitenicebooking.input_checkin || jQuery('#dateto').val() == quitenicebooking.input_checkout || jQuery('#datefrom').val() == '' || jQuery('#dateto').val() == '') {
			alert(quitenicebooking.alert_select_dates);
			jQuery('#datefrom').effect('pulsate', { times:2 }, 800);
			jQuery('#dateto').effect('pulsate', { times:2 }, 800);
			return false;
		}
		// check whether dates are the same
		if (jQuery('#datefrom').val() == jQuery('#dateto').val()) {
			alert(quitenicebooking.alert_cannot_be_same_day);
			jQuery('#datefrom').effect('pulsate', { times:2 }, 800);
			jQuery('#dateto').effect('pulsate', { times:2 }, 800);
			return false;
		}
		
		var dateFrom = jQuery.datepicker.parseDate(quitenicebooking.date_format, jQuery('#datefrom').val());
		var dateTo = jQuery.datepicker.parseDate(quitenicebooking.date_format, jQuery('#dateto').val());
		// check whether checkout is before checkin
		if (dateTo < dateFrom) {
			jQuery('#datefrom').effect('pulsate', { times:3 }, 800);
			jQuery('#dateto').effect('pulsate', { times:3 }, 800);
			alert(quitenicebooking.alert_checkin_before_checkout);
			return false;
		}
		
		// validate guests
		
		// each room must have at least 1 guest
		if (!jQuery('#room_qty').length) {
			// if on the front page form, or on step 2's "edit reservation" form, get the single n from room_n_adults
			var num_guests = jQuery('select[id$="_adults"]').first().get(0).attributes[0].nodeValue.match(/room_(\d)+_adults/)[1];
			// notes: get(0) gets the DOM of the element, attributes[0] gets the attribute, nodeValue gets the 'name', and match(...)[1] is the regex returning the captured match
		} else {
			var num_guests = jQuery('#room_qty').val();
		}
		
		for (var r = 1; r <= num_guests; r ++) {
			if (jQuery('#room_'+r+'_adults').val() + jQuery('#room_'+r+'_children').val() < 1) {
				alert(quitenicebooking.alert_at_least_1_guest+' '+r);
				jQuery('#room_'+r+'_adults').effect('pulsate', { times:2 }, 800);
				jQuery('#room_'+r+'_children').effect('pulsate', { times:2 }, 800);
				return false;
			}
		}
		
		// for step 1
		if (jQuery('#room_qty').length) {
			// entire booking must have at least 1 adult
			var totalAdults = 0;
			for (var r = 1; r <= jQuery('#room_qty').val(); r ++) {
				totalAdults += jQuery('#room_'+r+'_adults').val();
			}
			if (totalAdults < 1) {
				alert(quitenicebooking.alert_at_least_1_adult);
				for (var r = 1; r <= jQuery('#room_qty').val(); r ++) {
					jQuery('#room_'+r+'_adults').effect('pulsate', { times:2 }, 800);
				}
				return false;
			}
		}

	});
	
	// Booking Form Edit
	jQuery('.edit-reservation').on('click', function() {
		jQuery('.display-reservation').hide();
		jQuery('.display-reservation-edit').show();
		jQuery('.room-1').show();
		return false;
	});
	
	
	/**
	 * Step 3 - Form validation ===============================================
	 */
	
	jQuery('.booking-fields-form').on('submit', function(e) {
		// skip validation if coupon codes being applied
		if (e.originalEvent.explicitOriginalTarget.name == 'apply_coupon' || e.originalEvent.explicitOriginalTarget.name == 'remove_coupon') {
			return;
		}

		var validationErrors = new Array();

		var requiredfield_error = false;

		// check for missing fields
		if (jQuery('#guest_first_name').val().length == 0
			|| jQuery('#guest_last_name').val().length == 0
			|| jQuery('#guest_email').val().length == 0 ) {
			requiredfield_error = true;
		}

		jQuery('input[type=text][data-required], textarea[data-required]').each(function(){
			if (jQuery(this).val().length == 0) {
				requiredfield_error = true;
			}
		});

		// check for required checkboxes/radios/selects
		var checkbox_arr = new Array;
		// get the names of all checkbox groups
		jQuery('input[type=checkbox][data-required], input[type=radio][data-required]').each(function(){
			if (jQuery.inArray(jQuery(this).attr('name'), checkbox_arr) == -1) {
				checkbox_arr[jQuery(this).attr('name')] = false;
			}
		});
		// determine whether at least one checkbox is checked within the group
		for (var i in checkbox_arr) {
			jQuery('input[name="'+i+'"]').each(function() {
				if (jQuery(this).is(':checked')) {
					checkbox_arr[i] = true;
				}
			});
		}
		// get the names of all select groups
		var select_arr = new Array;
		jQuery('select[data-required]').each(function(){
			if (jQuery.inArray(jQuery(this).attr('name'), checkbox_arr) == -1) {
				select_arr[jQuery(this).attr('name')] = false;
			}
		});
		// determine whether at least one selection is made within the group
		for (var i in select_arr) {
			jQuery('select[name="'+i+'"] option').each(function() {
				if (jQuery(this).is(':selected')) {
					select_arr[i] = true;
				}
			});
		}
		// determine if any of checkbox_arr or select_arr are false
		for (var i in checkbox_arr) {
			if (checkbox_arr[i] == false) {
				requiredfield_error = true;
			}
		}
		for (var i in select_arr) {
			if (select_arr[i] == false) {
				requiredfield_error = true;
			}
		}

		if (requiredfield_error == true) {
			validationErrors.push(quitenicebooking.validationerror_requiredfield);
		}
		
		// check specific fields
		if (jQuery('#guest_email').val().match(/.+@.+\..+/) == null) {
			validationErrors.push(quitenicebooking.validationerror_email);
		}
		if (jQuery('input[name=payment_method]').length > 0 && jQuery('input[name="payment_method"]:checked').length == 0) {
			validationErrors.push(quitenicebooking.validationerror_paymentmethod);
		}
		if (jQuery('#terms_check').length == 1 && !jQuery('#terms_check').is(':checked')) {
			validationErrors.push(quitenicebooking.validationerror_tos);
		}
		
		if (validationErrors.length > 0) {
			jQuery('.booking-form-notice').html('');
			for (var i = 0; i < validationErrors.length; i ++) {
				jQuery('.booking-form-notice').append('<p>'+validationErrors[i]+'</p>');
			}
			jQuery('html, body').animate( { scrollTop: jQuery('.booking-main').offset().top }, 1000);
			// animation
			jQuery('.booking-form-notice').delay(1000).effect('pulsate', { times:2 }, 1200);
			jQuery('.booking-form-notice').delay(1000).fadeIn(1200, function() { } );
			
			return false;
		}
	});
	
	/**
	 * Step 3 - Payment method accordion
	 */
	jQuery('div.payment_method').accordion({event: 'mouseup'});
	jQuery('div.payment_method h3').on('click', function() {
		jQuery('input', this).prop('checked', true);
	});
	jQuery('div.payment_method h3 input').on('click', function() {
		jQuery(this).prop('checked', true);
	});
	// check first radio by default
	jQuery('div.payment_method h3 input').first().prop('checked', true);
});
