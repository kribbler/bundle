// Set Variables
var mobile_toggle = 'closed';

jQuery(document).ready(function() { 
	
	"use strict";
	
	// Main Menu Drop Down
	jQuery('ul#navigation').superfish({ 
        delay:       600,
        animation:   {opacity:'show',height:'show'},
        speed:       'fast',
        autoArrows:  true,
        dropShadows: false
    });

	// Language Drop Down
	jQuery('ul#language-selection').superfish({ 
        delay:       600,
        animation:   {opacity:'show',height:'show'},
        speed:       'fast',
        autoArrows:  true,
        dropShadows: false
    });
	
	// Accordion
	jQuery( ".accordion" ).accordion( { autoHeight: false } );

	// Toggle	
	jQuery( ".toggle > .inner" ).hide();
	jQuery(".toggle .title").bind('click',function() {
		jQuery(this).toggleClass('active');
		if (jQuery(this).hasClass('active')) {
			jQuery(this).closest('.toggle').find('.inner').slideDown(200, 'easeOutCirc');
		} else {
			jQuery(this).closest('.toggle').find('.inner').slideUp(200, 'easeOutCirc');
		}
	});
	
	// Tabs
	jQuery(function() {
		jQuery( ".tabs" ).tabs();
	});
	
	// PrettyPhoto
	jQuery("a[rel^='prettyPhoto']").prettyPhoto({social_tools:false});
	
	// Search Button Toggle
	jQuery(".menu-search-button").click(function() {
		jQuery(".menu-search-field").toggleClass("menu-search-focus", 200);
	});
	
	// Mobile Menu
	jQuery(".mobile-menu-button").click(function(){
		jQuery(".mobile-menu-inner").stop().slideToggle(350);
		return false;
	});
	
	// Header Google Map
	jQuery(".gmap-button").click(function(){
		jQuery('#header-gmap').slideToggle(900);
		if (!map) {
			initialize(headerLat,headerLong);
		}
		jQuery('.gmap-button').toggleClass('gmap-button-hover');
	});
	
});

jQuery(window).load(function(){
	
	"use strict";
	
	// Main Slider
	jQuery('.slider, .slideshow-shortcode').flexslider({
		animation: "fade",
		controlNav: false,
		directionNav: true,
		slideshow: true,
		start: function(slider){
			jQuery('body').removeClass('loading');
		}
	});
	
	// Text Slider
	jQuery('.text-slider').flexslider({
		animation: "fade",
		controlNav: false,
		directionNav: true,
		slideshow: true,
		start: function(slider){
			jQuery('body').removeClass('loading');
		}
	});
	
});