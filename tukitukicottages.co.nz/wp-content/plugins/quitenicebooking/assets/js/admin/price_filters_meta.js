// get the existing number of price filters
var price_filter_num = parseInt(quitenicebooking_premium.num_price_filters) + 1;

(function($) {
$(document).ready(function() {
	
	/**
	 * Add datepicker to date fields (future)
	 */
	$(document).on('focusin', '.datepicker', function() {
		if ($(this).attr('name').indexOf('enddate') != -1) {
			var s = $(this).attr('name').replace('enddate', 'startdate');
			if ($('input[name="'+s+'"]').val().length != 0) {
				var d = new Date($.datepicker.parseDate(quitenicebooking.js_date_format, $('input[name="'+s+'"]').val()));
				$(this).datepicker({
					dateFormat: quitenicebooking.js_date_format
				});
				$(this).datepicker('option', 'minDate', d);
				return;
			}

		}
		$(this).datepicker({
			minDate: 0,
			dateFormat: quitenicebooking.js_date_format
		});
	});
	
	/**
	 * Add datepicker to date fields (existing)
	 */
	$('.datepicker').datepicker({
		minDate: 0,
		dateFormat: quitenicebooking.js_date_format
	});
	
	/**
	 * Make the datepicker fields read-only
	 */
	$('.datepicker').attr('readonly', true);
	
	/**
	 * Make price filter divs sortable
	 * Reorder the price filter names and ids after sorting
	 */
	$('#dynamic_add_price_filter').sortable({
		stop: function(e) {
			var num_filters = $('.price_filter').length;
			for (var i = 0; i < num_filters; i ++) {
				$('.price_filter').eq(i).children('h3').html('Filter '+(i+1));
				$('.price_filter').eq(i).find('input').each(function() {
					$(this).attr('name', function(index, value) {
						return value.replace(/price_filter_\d+/, 'price_filter_'+(i+1));
					});
					$(this).attr('id', function(index, value) {
						return value.replace(/price_filter_\d+/, 'price_filter_'+(i+1));
					});
				});
			}
		}
	});
	
	/**
	 * Add price filter button
	 */
	$('button#add_price_filter').on('click', function(e) {
		e.preventDefault();
		
		var price_column_header = '';
		for (var p in quitenicebooking_premium.price_keys) {
			price_column_header += '<div class="one-fifth"><label>'+quitenicebooking_premium.price_keys[p].description+'</label></div>';
		}
		var price_row = '';
		for (var e in quitenicebooking_premium.entity_keys) {
			price_row +=
'<div class="field-wrapper field-padding-below clearfix">'
	+'<div class="one-fifth">'+quitenicebooking_premium.entity_keys[e].description+'</div>';
			for (var p in quitenicebooking_premium.price_keys) {
				price_row +=
	'<div class="one-fifth">'
		+'<input type="text" name="quitenicebooking_price_filter_'+price_filter_num+'_'+quitenicebooking_premium.entity_keys[e].meta_part+'_'+quitenicebooking_premium.price_keys[p].meta_part+'" id="quitenicebooking_price_filter_'+price_filter_num+'_'+quitenicebooking_premium.entity_keys[e].meta_part+'_'+quitenicebooking_premium.price_keys[p].meta_part+'" class="full-width">'
	+'</div>';
			}
			price_row +=
'</div>';
		}
		
		var price_filter_html =
'<div class="price_filter" id="price_filter_'+price_filter_num+'">'
	+'<h3>Filter '+price_filter_num+'</h3>'
	+'<div class="field-wrapper field-padding clearfix">'
		+'<div class="one-fifth empty-label"></div>'
		+'<div class="one-fifth">'
			+'<label>From ('+quitenicebooking.date_format+')</label>'
		+'</div>'
		+'<div class="one-fifth">'
			+'<label>To ('+quitenicebooking.date_format+')</label>'
		+'</div>'
	+'</div>'
	+'<div class="field-wrapper field-padding-below clearfix">'
		+'<div class="one-fifth">'
			+'<label>Date range</label>'
		+'</div>'
		+'<div class="one-fifth">'
			+'<input type="text" name="quitenicebooking_price_filter_'+price_filter_num+'_startdate" id="quitenicebooking_price_filter_'+price_filter_num+'_startdate" class="full-width datepicker">'
		+'</div>'
		+'<div class="one-fifth">'
			+'<input type="text" name="quitenicebooking_price_filter_'+price_filter_num+'_enddate" id="quitenicebooking_price_filter_'+price_filter_num+'_enddate" class="full-width datepicker">'
		+'</div>'
	+'</div>'
	+'<hr class="space1">'
	+'<div class="field-wrapper field-padding clearfix">'
		+'<div class="one-fifth empty-label"></div>'
		+price_column_header
	+'</div>'
	+price_row
	+'<div class="field-wrapper field-padding-below clearfix">'
		+'<button type="button" class="remove_price_filter button">Remove Filter</button>'
	+'</div>'
+'</div>';
		$('div#dynamic_add_price_filter').append(price_filter_html);
		$('.datepicker').attr('readonly', true);
		price_filter_num ++;
	});
	
	/**
	 * Remove price filter button
	 */
	$(document).on('click', 'button.remove_price_filter', function(e) {
		e.preventDefault();
		$(this).parent().parent().remove();
		price_filter_num --;
		// reorder existing filters
		var count = 1;
		var price_filters = $('div.price_filter');
		for (var i = 0; i < price_filters.length; i ++) {
			$('div.price_filter').eq(i).children('h3').html('Filter '+count);
			$('div.price_filter').eq(i).find('input').each( function() {
				$(this).attr('name', function(index, value) {
					return value.replace(/price_filter_\d+/, 'price_filter_'+count);
				});
				$(this).attr('id', function(index, value) {
					return value.replace(/price_filter_\d+/, 'price_filter_'+count);
				});
			});
			count ++;
		}
	});
	
	/**
	 * Form submission and validation
	 */
	$('form').on('submit', function(e) {
		// get the total number of filters defined
		var num_filters = $('.price_filters').length;
		
		// create a new validationerrors array if it does not already exist
		if (typeof validationErrors == 'undefined') {
			var validationErrors = new Array();
		}
		
		// define error message booleans
		var missingFields = false;
		var invalidPrice = false;
		var invalidDateRange = false;
		
		// iterate through each price filter and validate their fields
		$('.price_filter').each(function() {
			$(this).find('input').each(function() {
				if ($(this).val().length == 0) {
					missingFields = true;
				}
			});
			
			var startdate = Date.parse($.datepicker.parseDate(quitenicebooking.js_date_format, $(this).find('input[name$=startdate]').val()));
			var enddate =  Date.parse($.datepicker.parseDate(quitenicebooking.js_date_format, $(this).find('input[name$=enddate]').val()));
			if (isNaN(startdate) || isNaN(enddate) || (startdate >= enddate)) {
				invalidDateRange = true;
			}
			
			$(this).find('input').not('[name$=startdate],[name$=enddate]').each(function() {
				if ($(this).val().match(/^\d+\.?\d*$/) == null) {
					invalidPrice = true;
				}
			});
				
			

		});
		// push error messages only once
		if (missingFields == true) {
			validationErrors.push('Please enter all price filter fields');
		}
		if (invalidPrice == true) {
			validationErrors.push('Please enter a valid price filter price');
		}
		if (invalidDateRange == true) {
			validationErrors.push('Please enter a valid price filter date range');
		}

		if (validationErrors.length > 0) {
			// validation failed, show errors
			$('#validation_errors').css('display', 'block');
			for (var i = 0; i < validationErrors.length; i ++) {
				$('#validation_errors').append('<p><strong>'+validationErrors[i]+'</strong></p>');
			}
			$('html, body').animate( { scrollTop: $('div#validation_errors').offset().top-50 }, 1000);
			$('#save-post').removeClass('button-disabled');
			$('#publish').removeClass('button-primary-disabled');
			$('.spinner').css('display', 'none');
			return false;
		}
	});
	
});
})(jQuery);