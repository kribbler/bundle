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

var room_num = parseInt(quitenicebooking.num_rooms) + 1;
jQuery(document).ready(function() {
	// add datepicker to date fields (future)
	jQuery(document).on('focusin', '.datepicker', function() {
		jQuery(this).datepicker({
			minDate: 0,
			dateFormat: quitenicebooking.js_date_format
		});
	});
	// add datepicker to date fields (existing)
	jQuery('.datepicker').datepicker({
		minDate: 0,
		dateFormat: quitenicebooking.js_date_format
	});
	
	/**
	 * Add room button
	 */
	jQuery('button#add_room').on('click', function(e) {
		e.preventDefault();
		var guestStr = '';
		for (var n = 0; n <= 20; n ++) {
			guestStr += '<option value="'+n+'">'+n+'</option>';
		}
		var typeStr = '';
		for (var k in quitenicebooking.all_rooms) {
			typeStr += '<option value="'+k+'">'+quitenicebooking.all_rooms[k].title+'</option>';
		}
		var bedStr = '';
		// load bed_types for the first room only
		// because js converted the php array into an unordered object, here, get the "first" element
		var first_room = 0;
		for (var f in quitenicebooking.all_rooms) {
			first_room = f;
			break;
		}
		for (var k in quitenicebooking.bed_types) {
			if ( quitenicebooking.all_rooms[first_room]['quitenicebooking_beds_'+k] == 1 ) {
				bedStr += '<option value="'+k+'">'+quitenicebooking.bed_types[k].description+'</option>';
			}
		}
		bedStr += '<option value="0">Room</option>';
		jQuery('div#dynamic_add_room').append(
'<div class="room">'
	+'<h3>Room '+room_num+'</h3>'
	+'<div class="field-wrapper field-padding clearfix">'
		+'<div class="one-half">'
			+'<label for="quitenicebooking_room_booking_'+room_num+'_checkin">Check in date ('+quitenicebooking.date_format+')</label>'
			+'<input type="text" name="quitenicebooking_room_booking_'+room_num+'_checkin" id="quitenicebooking_room_booking_'+room_num+'_checkin" class="full-width datepicker">'
		+'</div>'
		+'<div class="one-half">'
			+'<label for="quitenicebooking_room_booking_'+room_num+'_checkout">Check out date ('+quitenicebooking.date_format+')</label>'
			+'<input type="text" name="quitenicebooking_room_booking_'+room_num+'_checkout" id="quitenicebooking_room_booking_'+room_num+'_checkout" class="full-width datepicker">'
		+'</div>'
	+'</div>'
	+'<div class="field-wrapper field-padding-below clearfix">'
		+'<div class="one-half">'
			+'<label for="quitenicebooking_room_booking_'+room_num+'_type">Room type</label>'
			+'<select name="quitenicebooking_room_booking_'+room_num+'_type" id="quitenicebooking_room_booking_'+room_num+'_type" class="full-width">'+typeStr+'</select>'
		+'</div>'
		+'<div class="one-half">'
			+'<label for="quitenicebooking_room_booking_'+room_num+'_bed">Bed type</label>'
			+'<select name="quitenicebooking_room_booking_'+room_num+'_bed" id="quitenicebooking_room_booking_'+room_num+'_bed" class="full-width">'+bedStr+'</select>'
		+'</div>'
		+'</div>'
	+'<div class="field-wrapper field-padding-below clearfix">'
		+'<div class="one-half">'
			+'<label for="quitenicebooking_room_booking_'+room_num+'_adults">Adults</label>'
			+'<select name="quitenicebooking_room_booking_'+room_num+'_adults" id="quitenicebooking_room_booking_'+room_num+'_adults" class="full-width">'+guestStr+'</select>'
		+'</div>'
		+'<div class="one-half">'
			+'<label for="quitenicebooking_room_booking_'+room_num+'_children">Children</label>'
			+'<select name="quitenicebooking_room_booking_'+room_num+'_children" id="quitenicebooking_room_booking_'+room_num+'_children" class="full-width">'+guestStr+'</select>'
		+'</div>'
	+'</div>'
	+'<div class="field-wrapper field-padding-below clearfix">'
		+'<button type="button" class="check_availability button">Check Availability</button>'
		+' <button type="button" class="remove_room button">Remove Room</button>'
		+' <span class="ajax_messages"></span>'
	+'</div>'
+'</div>'
		);
		room_num++;
	});
	
	/**
	 * Remove room button
	 */
	jQuery(document).on('click', 'button.remove_room', function(e) {
		e.preventDefault();
		jQuery(this).parent().parent().remove();
		room_num --;
		// reorder existing rooms
		var count = 1;
		var rooms = jQuery('div.room');
		for (var i = 0; i < rooms.length; i ++) {
			jQuery('div.room').eq(i).children('h3').html('Room '+count);
			jQuery('div.room').eq(i).find('input, select').each( function(){
				jQuery(this).attr('name', function(index, value) {
					return value.replace(/room_booking_\d+/, 'room_booking_'+count);
				});
				jQuery(this).attr('id', function(index, value) {
					return value.replace(/room_booking_\d+/, 'room_booking_'+count);
				});
			});
			count ++;
		}
	});
	
	/**
	 * Populate bed_types when room_type changes
	 */
	jQuery(document).on('change', 'select[name$=_type]', function(e) {
		e.preventDefault();
//		console.log(jQuery(this));
		jQuery(this).parentsUntil('.room').eq(1).find('select[name$=_bed] option').remove();
		for (var k in quitenicebooking.bed_types) {
			if ( quitenicebooking.all_rooms[jQuery(this).val()]['quitenicebooking_beds_'+k] == 1 ) {
//				console.log('quitenicebooking_beds_'+k);
				jQuery(this).parentsUntil('.room').eq(1).find('select[name$=_bed]').append('<option value="'+k+'">'+quitenicebooking.bed_types[k].description+'</option>');
			}
		}
		jQuery(this).parentsUntil('.room').eq(1).find('select[name$=_bed]').append('<option value="0">Room</option>');
	});
	
	/**
	 * Availability checker ajax
	 */
	jQuery(document).on('click', 'button.check_availability', function(e) {
		e.preventDefault();
//		console.log(jQuery(this)); // debug
		// validation
		// check that all fields have been filled before submitting
		if (jQuery(this).parentsUntil('#dynamic_add_room').eq(1).find('input[name$="checkin"]').val().length == 0 || jQuery(this).parentsUntil('#dynamic_add_room').eq(1).find('input[name$="checkout"]').val().length == 0) {
			jQuery(this).siblings('.ajax_messages').html('<img src="'+quitenicebooking.assets_url+'images/no.png" alt="" />Please fill in check in/check out dates');
			return false;
		}
		// validate checkin < checkout
		var checkin = Date.parse(jQuery.datepicker.parseDate(quitenicebooking.js_date_format, jQuery(this).parentsUntil('#dynamic_add_room').eq(1).find('input[name$="checkin"]').val()));
		var checkout = Date.parse(jQuery.datepicker.parseDate(quitenicebooking.js_date_format, jQuery(this).parentsUntil('#dynamic_add_room').eq(1).find('input[name$="checkout"]').val()));
		if (checkin >= checkout) {
			jQuery(this).siblings('.ajax_messages').html('<img src="'+quitenicebooking.assets_url+'images/no.png" alt="" />Check out date must be after check in date');
			return false;
		}
		
		// update the status
		jQuery(this).siblings('.ajax_messages').html('<img src="'+quitenicebooking.assets_url+'images/wpspin_light.gif" alt="" />Checking availability, please wait...');
		
		// create current_room object
		// get the button's parent and get all the values from the fields
		var current_room = new Object();
		current_room.checkin = jQuery(this).parentsUntil('#dynamic_add_room').eq(1).find('input[name$="checkin"]').val();
		current_room.checkout = jQuery(this).parentsUntil('#dynamic_add_room').eq(1).find('input[name$="checkout"]').val();
		current_room.adults = parseInt(jQuery(this).parentsUntil('#dynamic_add_room').eq(1).find('select[name$="adults"]').val());
		current_room.children = parseInt(jQuery(this).parentsUntil('#dynamic_add_room').eq(1).find('select[name$="children"]').val());
		current_room.type = jQuery(this).parentsUntil('#dynamic_add_room').eq(1).find('select[name$="type"]').val();
		current_room.bed = jQuery(this).parentsUntil('#dynamic_add_room').eq(1).find('select[name$="bed"]').val();
		
//		console.log(current_room);
		
		// create the checked_rooms array of objects
		// each checked_room has an edit_room button, use its existence as the criteria
		var checked_rooms = new Array();
		var checked_rooms_selector = jQuery('.edit_room');
		for (var i = 0; i < checked_rooms_selector.length; i ++) {
			checked_rooms[i] = new Object();
			checked_rooms[i].checkin = checked_rooms_selector.eq(i).parentsUntil('#dynamic_add_room').eq(1).find('input[name$="checkin"]').val();
			checked_rooms[i].checkout = checked_rooms_selector.eq(i).parentsUntil('#dynamic_add_room').eq(1).find('input[name$="checkout"]').val();
			checked_rooms[i].adults = parseInt(checked_rooms_selector.eq(i).parentsUntil('#dynamic_add_room').eq(1).find('select[name$="adults"]').val());
			checked_rooms[i].children = parseInt(checked_rooms_selector.eq(i).parentsUntil('#dynamic_add_room').eq(1).find('select[name$="children"]').val());
			checked_rooms[i].type = checked_rooms_selector.eq(i).parentsUntil('#dynamic_add_room').eq(1).find('select[name$="type"]').val();			
			checked_rooms[i].bed = checked_rooms_selector.eq(i).parentsUntil('#dynamic_add_room').eq(1).find('select[name$="bed"]').val();			
		}
		
//		console.log(checked_rooms);

		var formdata = {
			action: 'quitenicebooking_ajax_check_availability',
			current_room: current_room,
			checked_rooms: checked_rooms,
			post_id: quitenicebooking.post_id
		};
		var check_availability_button = jQuery(this);
		jQuery.post(quitenicebooking.ajax_url, formdata, function(response) {
			if (response == 'true') {
				// room available
//				console.log(check_availability_button);
				check_availability_button.siblings('.ajax_messages').html('<img src="'+quitenicebooking.assets_url+'images/yes.png" alt="" />Room added');
				// change all fields to read-only/disabled (if disabled, enable before submit)
				check_availability_button.parentsUntil('#dynamic_add_room').eq(1).find('input, select').prop('disabled', true);
				
				// swap check_availability button for edit_room button
				check_availability_button.after('<button class="edit_room button">Edit Room</button>');
//				console.log(check_availability_button.siblings('.edit_room'));
				check_availability_button.remove();
			} else if (response == '"room_qty"') {
				check_availability_button.siblings('.ajax_messages').html('<img src="'+quitenicebooking.assets_url+'images/no.png" alt="" />Room unavailable - fully booked');
			} else if (response == '"guest_qty"') {
				check_availability_button.siblings('.ajax_messages').html('<img src="'+quitenicebooking.assets_url+'images/no.png" alt="" />Room unavailable - too many guests');
			} else if (response == '"room_blocked"') {
				check_availability_button.siblings('.ajax_messages').html('<img src="'+quitenicebooking.assets_url+'images/no.png" alt="" />Room unavailable - dates blocked');
			}
		});
		
	});
	
	/**
	 * Edit room button
	 */
	jQuery(document).on('click', 'button.edit_room', function(e) {
		e.preventDefault();
		
		// enable fields to be edited
		jQuery(this).parentsUntil('#dynamic_add_room').eq(1).find('input, select').removeProp('disabled');
		
		// replace edit_room button with check_availability button
		jQuery(this).siblings('.ajax_messages').html('');
		jQuery(this).after('<button class="check_availability button">Check Availability</button>');
		jQuery(this).remove();
		
	});
	
	
	// show the error div for a new booking
//	if (jQuery('input[id$="_checkin"]').last().length == 0) {
//		jQuery('#validation_errors').css('display', 'block');
//	}
	
	/**
	 * Form submission and validation
	 */
	jQuery('form').on('submit', function(e) {
		// re-enable all the fields
		jQuery('.room').find('input, select').removeProp('disabled');
		
		// remove all the rooms that have a check_availability button
		// 1. get the number of unchecked rooms to remove
		var remove_rooms = jQuery('.check_availability').parentsUntil('#dynamic_add_room').filter('.room');
		room_num -= remove_rooms.length;
		// 2. remove the unchecked rooms
		remove_rooms.remove();
		// 3. reorder existing rooms (same as above)
		var count = 1;
		var rooms = jQuery('div.room');
		for (var i = 0; i < rooms.length; i ++) {
			jQuery('div.room').eq(i).children('h3').html('Room '+count);
			jQuery('div.room').eq(i).find('input, select').each( function(){
				jQuery(this).attr('name', function(index, value) {
					return value.replace(/room_booking_\d+/, 'room_booking_'+count);
				});
				jQuery(this).attr('id', function(index, value) {
					return value.replace(/room_booking_\d+/, 'room_booking_'+count);
				});
			});
			count ++;
		}
		
		jQuery('#validation_errors').css('display', 'none');
		jQuery('#validation_errors').html('');
		var validationErrors = new Array();

		if (jQuery('#quitenicebooking_guest_last_name').val().trim().length == 0
			|| jQuery('#quitenicebooking_guest_first_name').val().trim().length == 0
			|| jQuery('#quitenicebooking_guest_email').val().trim().length == 0) {
			validationErrors.push('Please enter required guest information');
		}
		
		if (jQuery('#quitenicebooking_guest_email').val().trim().match(/.+@.+\..+/) == null) {
			validationErrors.push('Please enter a valid guest email address');
		}
		if (jQuery('#quitenicebooking_deposit_amount').val().trim().length > 0
			&& jQuery('#quitenicebooking_deposit_amount').val().trim().match(/\d+\.?\d*/) == null) {
			validationErrors.push('Please enter a valid deposit amount');
		}

		if (jQuery('#quitenicebooking_total_price').val().trim().length > 0
			&& jQuery('#quitenicebooking_total_price').val().trim().match(/\d+\.?\d*/) == null) {
			validationErrors.push('Please enter a valid total price');
		}
		
		// count number of rooms
		if (jQuery('input[id$="_checkin"]').last().length == 0) {
			validationErrors.push('Please add a room to this booking');
		} else {
			var num_rooms = jQuery('input[id$="_checkin"]').last().get(0).name.match(/room_booking_(\d)+_checkin/)[1];
			
			for (var n = 1; n <= num_rooms; n++) {
				// check for empty fields
				if (jQuery('#quitenicebooking_room_booking_'+n+'_checkin').val().trim().length == 0
					|| jQuery('#quitenicebooking_room_booking_'+n+'_checkout').val().trim().length == 0
					|| jQuery('#quitenicebooking_room_booking_'+n+'_type').val().trim().length == 0
					|| jQuery('#quitenicebooking_room_booking_'+n+'_bed').val().trim().length == 0
					|| jQuery('#quitenicebooking_room_booking_'+n+'_adults').val().trim().length == 0
					|| jQuery('#quitenicebooking_room_booking_'+n+'_children').val().trim().length == 0) {
					validationErrors.push('Please enter all information for room '+n);
				}
				// TODO date format strings for checkin and checkout
				
				if (jQuery('#quitenicebooking_room_booking_'+n+'_adults').val().trim().match(/\d+/) == null
					|| jQuery('#quitenicebooking_room_booking_'+n+'_children').val().trim().match(/\d+/) == null) {
					validationErrors.push('Number of guests in room '+(n+1)+' must be 0 or higher');
				}
			}
		}
		
		if (validationErrors.length > 0) {
			// disable rooms
			jQuery('.room').find('input, select').prop('disabled', true);
			
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
		
		// automatically generate a title for this post
		var title_str = '';
		// "n room booking for first_name last_name (first_checkin - last_checkout)"
		// 1. count number of rooms
		title_str += rooms.length + ' room booking for ' + jQuery('#quitenicebooking_guest_first_name').val() + ' ' + jQuery('#quitenicebooking_guest_last_name').val();
		// 2. get the first checkin
		// 2.1. get all the checkin dates and convert them to js time
		var checkins = new Array();
		jQuery('.room').find('input[name$=_checkin]').each(function(index, elem){
			checkins.push(Date.parse(jQuery.datepicker.parseDate(quitenicebooking.js_date_format, jQuery(elem).val())));
		});
		// 2.2. find the first checkin
		var first_checkin = checkins[0];
		for (var i = 0; i < checkins.length; i ++) {
			if (checkins[i] < first_checkin) {
				first_checkin = checkins[i];
			}
		}
		// 2.3. convert the first checkin back to js_date_format
		first_checkin = jQuery.datepicker.formatDate(quitenicebooking.js_date_format, new Date(first_checkin));
		
		// 3. get the last checkout
		var checkouts = new Array();
		// 3.1. get all the checkout dates and convert them to js time
		jQuery('.room').find('input[name$=_checkout]').each(function(index, elem){
			checkouts.push(Date.parse(jQuery.datepicker.parseDate(quitenicebooking.js_date_format, jQuery(elem).val())));
		});
		// 3.2. find the last checkout
		var last_checkout = checkouts[0];
		for (var i = 0; i < checkouts.length; i ++) {
			if (checkouts[i] > last_checkout) {
				last_checkout = checkouts[i];
			}
		}
		// 3.3. convert the last checkout back into js_date_format
		last_checkout = jQuery.datepicker.formatDate(quitenicebooking.js_date_format, new Date(last_checkout));
		
		// 4. put it all together
		title_str += ' (' + first_checkin + ' - ' + last_checkout + ')';
		
		jQuery('#title-prompt-text').addClass('screen-reader-text');
		jQuery('#title').val(title_str);

	});
});
