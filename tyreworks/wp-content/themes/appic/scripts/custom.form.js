jQuery(document).ready(function($) {
	//placeholder for old brousers and IE
	if(!Modernizr.input.placeholder){
		$('[placeholder]').focus(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
					input.val('');
					input.removeClass('placeholder');
				}
			})
			.blur(function() {
				var input = $(this);
				if (input.val() == '' || input.val() == input.attr('placeholder')) {
					input.addClass('placeholder');
					input.val(input.attr('placeholder'));
				}
			})
			.blur();
		$('[placeholder]').parents('form').submit(function() {
			$(this).find('[placeholder]').each(function() {
				var input = $(this);
				if (input.val() == input.attr('placeholder')) {
					input.val('');
				}
			})
		});
	}


	/* replace native Contact Form 7 with Appic error styling */
	if (typeof $.fn.wpcf7NotValidTip == 'function') {
		$.fn.wpcf7NotValidTip = function(message) {
			
			return this.each(function() {
				
				var span = $(this);
				var field = span.find(':input');
				
				span.css({position: 'static'})
				span.parent().css({position: 'relative'})

				jQuery('<p />', {
					'class':'inv-em',
					'text':message,
				})
					.css({'position': 'absolute','top':jQuery(field).position().top,'left':jQuery(field).position().left})
					.appendTo(jQuery(span).parent()) 
					.delay(3000)
					.fadeOut(300, function(){
						jQuery(this).remove()
					});
			});
		};
	}
});
