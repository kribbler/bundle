var gbtr_order_review_content_global_var = 'close';

jQuery(document).ready(function($) {
	
	"use strict";

	$(".gbtr_menu_mobiles select").customSelect({customClass:'menu_select'});
	$(".woocommerce_ordering select").customSelect({customClass:'theretailer_product_sort'});
	$(".woocommerce-ordering select").customSelect({customClass:'theretailer_product_sort'});

	$('.gbtr_menu_mobiles_inside').css('visibility', 'visible').animate({opacity: 1.0}, 200);
	
	$(".gbtr_menu_mobiles select").change(function() {
		window.location.href = this.options[this.selectedIndex].value;
	});
	
	//dropdown menu
	$('#menu').superfish({
		hoverClass	: 'sfHover',
		pathClass	: 'overideThisToUse',
		pathLevels	: 1,
		delay		: 300,
		animation	: {opacity:'show'},
		speed		: 300,
		autoArrows	: true,
		disableHI	: false,		// true disables hoverIntent detection
		onInit		: function(){}, // callback functions
		onBeforeShow: function(){},
		onShow		: function(){},
		onHide		: function(){},
		onIdle		: function(){}
	});
	
	//light/dark footer clears
	$('.gbtr_light_footer_wrapper .grid_3:nth-child(4n)').after("<div class='clr'></div>");
	$('.gbtr_dark_footer_wrapper .grid_3:nth-child(4n)').after("<div class='clr'></div>");
	
	//tools bar search
	if ( $.trim( $('.gbtr_tools_search_inputtext').val() ) ) {
		$('.gbtr_tools_search_inputtext').show();
	}
	$('.gbtr_tools_search').mouseenter(function(){
		//$('.gbtr_tools_search_inputtext').show(200);
		$('.gbtr_tools_search_inputtext').animate({width: "show"}, 150);
    }).mouseleave(function(){
		if ( !$.trim( $('.gbtr_tools_search_inputtext').val() ) && ( !$('.gbtr_tools_search_inputtext').is(":focus") ) ) {
			$('.gbtr_tools_search_inputtext').hide(200);
		}
    });
	$('.gbtr_tools_search_inputtext').blur(function() {
		if ( !$.trim( $('.gbtr_tools_search_inputtext').val() ) ) {
			$(this).hide(200);
		}
	});
	
	//minicart	
	//fix hoverIntent() with live()
	$(".gbtr_little_shopping_bag_wrapper").live("mouseenter", function() {
		if(!$(this).data('init'))
        {
            $(this).data('init', true);
            $(this).hoverIntent
            (
                function()
                {
					$('.gbtr_minicart_wrapper').fadeIn(200);
					$('.gbtr_little_shopping_bag').css("background","none");
                },

                function()
                {
                    $('.gbtr_minicart_wrapper').fadeOut(200);
					$('.gbtr_little_shopping_bag').css("background","#fff");
                }
            );
            $(this).trigger('mouseenter');
        }
	});
	
	$("ul.cart_list li").mouseenter(function(){
		$(this).children('.remove').fadeIn(0);
	}).mouseleave(function(){
		$(this).children('.remove').fadeOut(0);
	});
	
	//woocommerce widget filters
	$('.product_list_widget > li > a > img').each(function() {
		$(this).parent().before(this);
		$(this).wrap('<div class="product_list_widget_img_wrapper" />');
	});
	
	$('.product_list_widget > li > a').each(function() {
		if ($.trim($(this).text()).length > 30 ) { $(this).text($.trim($(this).text()).substr(0, 30) + "..."); }
	});
	
	$('.product_list_widget > li > .product_list_widget_img_wrapper').each(function() {
		$(this).parent().children('a').prepend(this);
	});
	
	// responsive tables
	$('.footable').footable();
	
	// home slideshow
	$('.gbtr_slideshow .default-slider').iosSlider({
		snapToChildren: true,
		scrollbar: true,
		scrollbarHide: true,
		desktopClickDrag: true,
		scrollbarLocation: 'top',
		scrollbarHeight: '2px',
		scrollbarBackground: '#fff',
		scrollbarBorder: '0',
		scrollbarMargin: '10px',
		scrollbarOpacity: '0.3',
		navNextSelector: $('.default-slider-next'),
		navPrevSelector: $('.default-slider-prev')
	});
	
	/*content tabs*/	
	$('.shortcode_tabgroup').find("div.panel").hide();
	$('.shortcode_tabgroup').find("div.panel:first").show();
	$('.shortcode_tabgroup').find("ul li:first").addClass('active');
	 
	$('.shortcode_tabgroup ul li a').click(function(){
		//$('.shortcode_tabgroup ul li').removeClass('active');
		$(this).parent().parent().parent().find('ul li').removeClass('active');
		$(this).parent().addClass('active');
		var currentTab = $(this).attr('href');
		$(this).parent().parent().parent().find('div.panel').hide();
		$(currentTab).fadeIn(300);
		return false;
	});
	
	/*content accordion*/
	$('.accordion').each(function(){
		var acc = $(this).attr("rel") * 2;
		$(this).find('.accordion-inner:nth-child(' + acc + ')').show();
		$(this).find('.accordion-inner:nth-child(' + acc + ')').prev().addClass("active");
	});
	
	$('.accordion .accordion-title').click(function() {
		if($(this).next().is(':hidden')) {
			$(this).parent().find('.accordion-title').removeClass('active').next().slideUp(200);
			$(this).toggleClass('active').next().slideDown(200);
		} else {
			$(this).parent().find('.accordion-title').removeClass('active').next().slideUp(200);
		}
		return false;
	});

	$('.gbtr_login_register_reg .button').click(function() {
		
		$('.gbtr_login_register_slider').animate({
			left: -$('.gbtr_login_register_wrapper').width()
		}, 300, function() {
			// Animation complete.
		});
	
		$('.gbtr_login_register_wrapper').animate({
			height: $('.gbtr_login_register_slide_2').height() + 100
		}, 300, function() {
			// Animation complete.
		});
		
		$('.gbtr_login_register_label_slider').animate({
			top: -$('.gbtr_login_register_switch').height()
		}, 300, function() {
			// Animation complete.
		});
	
	});
	
	$('.gbtr_login_register_log .button').click(function() {
		$('.gbtr_login_register_slider').animate({
			left: '0'
		}, 300, function() {
			// Animation complete.
		});
		
		$('.gbtr_login_register_wrapper').animate({
			height: $('.gbtr_login_register_slide_1').height() + 100
		}, 300, function() {
			// Animation complete.
		});
		
		$('.gbtr_login_register_label_slider').animate({
			top: '0'
		}, 300, function() {
			// Animation complete.
		});
	});

	
	/* button show */	
	$('.product_item').mouseenter(function(){
		$(this).find('.product_button').fadeIn(100, function() {
			// Animation complete.
		});
    }).mouseleave(function(){
		$(this).find('.product_button').fadeOut(100, function() {
			// Animation complete.
		});
    });
	
	// Begin Checkout
	
	$('.accordion_header').addClass('gbtr_checkout_header_nonactive');
	$('.gbtr_checkout_method_header').removeClass('gbtr_checkout_header_nonactive');
	
	$('.gbtr_checkout_method_header').click(function() {
		$(this).toggleClass('gbtr_checkout_header_nonactive');
		$('.gbtr_checkout_method_content').slideToggle(500, function() {
			// Animation complete.
		});
	});
	
	$('.gbtr_billing_address_header').click(function() {
		$(this).toggleClass('gbtr_checkout_header_nonactive');
		$('.gbtr_billing_address_content').slideToggle(500, function() {
			// Animation complete.
		});
		
	});
	
	$('.gbtr_shipping_address_header').click(function() {
		gbtr_order_review_content_global_var = 'close';
		$(this).toggleClass('gbtr_checkout_header_nonactive');
		$('.gbtr_shipping_address_content').slideToggle(200, function() {
			// Animation complete.
		});
		$('.gbtr_order_notes_content').slideToggle(500, function() {
			// Animation complete.
		});
	});
	
	$('.gbtr_additional_information_header').click(function() {
		$(this).toggleClass("gbtr_checkout_header_nonactive");
		$('.gbtr_order_notes_content').slideToggle(500, function() {
			// Animation complete.
		});
	});
	
	$('.gbtr_order_review_header').live('click', function () {
		$(this).toggleClass("gbtr_checkout_header_nonactive");
		$('.gbtr_order_review_content').slideToggle(500, function() {
			// Animation complete.
			gbtr_order_review_content_global_var = "open";
		});
	});
	
	$('.gbtr_payment_header').click(function() {
		$(this).toggleClass("gbtr_checkout_header_nonactive");
		$('.gbtr_payment_content').slideToggle(500, function() {
			// Animation complete.
		});
	});
	
	$('.gbtr_create_account_header').click(function() {
		$(this).toggleClass("gbtr_checkout_header_nonactive");
		$('.gbtr_create_account_content').slideToggle(500, function() {
			// Animation complete.
		});
	});

    setTimeout(function() {
		$('#gbtr_order_review input[name=payment_method]:checked').trigger('click');
    },10);

	// Begin Checkout radio-checkbox
	$("#checkout_method_radio_account").attr('checked', true);
	$("#checkout_method_radio_guest_wrapper").hide();
	var checkout_method = "account";
	
	if( $("#createaccount").length > 0 ) {
	
		$("#checkout_method_radio_guest_wrapper").show();
		
		if (!$("#createaccount").is(':checked')) {
			$("#checkout_method_radio_guest").attr('checked', true);
			checkout_method = "guest";
			$(".gbtr_create_account_block").hide();
		} else {
			$("#checkout_method_radio_account").attr('checked', true);
			checkout_method = "account";
			$(".gbtr_create_account_block").show();
		}

		$('input[name=checkout_method_radio]').click(function () {
			if ($('input[name=checkout_method_radio]:checked').val() === 'account') {
				if (checkout_method === "guest") {
					setTimeout(function() {
						$('#createaccount').trigger('click');
						$('.gbtr_create_account_content').hide();
						$(".gbtr_create_account_block").slideDown(300);
						checkout_method = "account";
					},10);
				}
			} else {
				if (checkout_method === "account") {
					setTimeout(function() {
						$('#createaccount').trigger('click');
						$(".gbtr_create_account_block").slideUp(300);
						checkout_method = "guest";
					},10);
				}
			}
		});
		
	}
	// End Checkout radio-checkbox
	
	//Continue Buttons
	$('.button_checkout_method_continue').click(function () {		
		if ($('input[name=checkout_method_radio]:checked').val() === 'account') {
			$(".accordion_content").slideUp(300);
			$(".accordion_header").addClass("gbtr_checkout_header_nonactive");
			$('.gbtr_create_account_header').toggleClass("gbtr_checkout_header_nonactive");
			$('.gbtr_create_account_content').slideDown(500, function() {
				// Animation complete.
			});
		} else {
			$(".accordion_content").slideUp(300);
			$(".accordion_header").addClass("gbtr_checkout_header_nonactive");
			$('.gbtr_billing_address_header').toggleClass("gbtr_checkout_header_nonactive");
			$('.gbtr_billing_address_content').slideDown(500, function() {
				// Animation complete.
			});
		}		
	});
	
	$('.button_create_account_continue').click(function () {		
		$(".accordion_content").slideUp(300);
		$(".accordion_header").addClass("gbtr_checkout_header_nonactive");
		$('.gbtr_billing_address_header').toggleClass("gbtr_checkout_header_nonactive");
		$('.gbtr_billing_address_content').slideDown(500, function() {
			// Animation complete.
		});		
	});
	
	$('.button_billing_address_continue').click(function () {		
		gbtr_order_review_content_global_var = "close";
		$(".accordion_content").slideUp(300);
		$(".accordion_header").addClass("gbtr_checkout_header_nonactive");
		
		
		if( $(".gbtr_order_notes_content").length > 0 ) {
			
			$('.gbtr_shipping_address_header').toggleClass("gbtr_checkout_header_nonactive");
			$('.gbtr_additional_information_header').toggleClass("gbtr_checkout_header_nonactive");
			
			$('.gbtr_shipping_address_content').slideDown(500, function() {
				// Animation complete.
			});
			$('.gbtr_order_notes_content').slideDown(500, function() {
				// Animation complete.
			});
			
		} else {
			
			$('.gbtr_order_review_header').toggleClass("gbtr_checkout_header_nonactive");
			$('.gbtr_order_review_content').slideDown(500, function() {
				// Animation complete.
			});
		}
		
		if( $(".gbtr_shipping_address_header").length <= 0 ) {
			$('.gbtr_billing_address_header').toggleClass("gbtr_checkout_header_nonactive");
		}
	});
	
	$('.button_shipping_address_continue').click(function () {		
		$(".accordion_content").slideUp(300);
		$(".accordion_header").addClass("gbtr_checkout_header_nonactive");
		$('.gbtr_order_review_header').toggleClass("gbtr_checkout_header_nonactive");
		$('.gbtr_order_review_content').slideDown(500, function() {
			gbtr_order_review_content_global_var = "open";
		});			
	});
	
	$('.button_order_review_continue').live('click', function () {		
		//$('.button_order_review_continue_wrapper').slideUp(100);
		$(".accordion_content").slideUp(300);
		$(".accordion_header").addClass("gbtr_checkout_header_nonactive");
		$('.gbtr_payment_header').toggleClass("gbtr_checkout_header_nonactive");
		$('.gbtr_payment_content').slideDown(500);		
	});
	
	// End Checkout
	
	$('p').filter(function() {
		return $.trim($(this).text()) === '' && $(this).children().length === 0;
	}).remove();
	
	
	//prettyPhoto
	
	$("a[rel^='theretailer_prettyPhoto']").prettyPhoto({
		social_tools: false,
		inline_markup: false,
		show_title: false,
		theme: 'pp_woocommerce',
		horizontal_padding: 40,
		opacity: 0.9,
		deeplinking: false
	});	
	
});

jQuery(document).ajaxStop(function() {
	
	"use strict";

	if (gbtr_order_review_content_global_var === "open") {
		
		jQuery('.gbtr_order_review_content').show();
		jQuery(".gbtr_order_review_header").removeClass("gbtr_checkout_header_nonactive");
		
	} else {
		
		jQuery(".gbtr_order_review_header").addClass("gbtr_checkout_header_nonactive");
		
	}
	
});