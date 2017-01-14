<?php
/*
	To add translations for Datepicker (the calendar used in the widgets and
	booking form), first obtain a localization file:

	1. Go to http://jqueryui.com/ and download the stable release of jQuery UI
	2. Extract the downloaded file
	3. The localization files are located in /ui/i18n/.  Copy the one for your
		language into wp-content/plugins/quitenicebooking/assets/js/

	Then, register the localization file by pasting the following line into the
	bottom of this file (this example is for French; replace 'fr' with the
	language you've chosen):

		wp_register_script('datepicker-fr', plugins_url('assets/js/jquery.ui.datepicker-fr.js', dirname(__FILE__)));
		wp_enqueue_script('datepicker-fr');
*/
// paste your Datepicker translation functions after this line
