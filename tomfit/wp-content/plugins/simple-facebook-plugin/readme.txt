=== Simple Facebook Plugin ===

Contributors: topdevs, fornyhucker
Tags: social, facebook, fb, fb like, like box, likebox, widget, shortcode, responsive, template tag, sidebar
Requires at least: 2.8
Tested up to: 3.9
Stable tag: trunk
License: GPLv2 or later

Allows you to integrate Facebook Like Box into your WordPress site using Widgets or Shortcodes. 

== Description ==

= Description =

Simple Facebook Plugin enables Facebook Page owners to attract and gain Likes from their own WordPress blogs. The **Like Box** enables users to:

* See how many users already like this Page, and which of their friends like it too
* Read recent posts from the Page
* Like the Page with one click, without needing to visit the Page

You can easily integrate Like Box using WordPress Widgets and Shortcodes.

= Add-ons =

Starting version 1.3 Simple Facebook Plugin is add-on ready. Visit our first [Responsive Like Box Add-on](http://plugins.topdevs.net/simple-facebook-plugin/responsive-like-box-addon/ "Visit Responsive Like Box Add-on Page") page to learn more.

= More =

Visit [Plugin Home Page](http://plugins.topdevs.net/simple-facebook-plugin/ "Simple Facebook Plugin Home Page") for more info and examples.
Visit [Our CodeCanyon Portfolio](http://codecanyon.net/user/topdevs/portfolio?ref=topdevs "Our CodeCanyon Portfolio") to see more awesome plugins we made.

== Installation ==
**Installation**

1. Upload `simple-facebook-plugin` directory to your `/wp-content/plugins` directory
1. Activate plugin in WordPress admin

**Customization**

1. In WordPress dashboard, go to **Appearance > Widgets**. 
1. Drag and Drop **SFP - Like Box** into your sidebar.
1. Click triangle near **SFP - Like Box** header.
1. Enter your Facebook Page URL (not your personal page URL!).
1. Choose colorscheme, size and other options you like.

**or**

Use `[sfp-like-box]` shortcode inside your post or page. This shortcode support all default parametrs:


* url - any Fan Page URL (not your personal page!)
* width - any number (e.g 250)
* height - any number (e.g 300)
* colorscheme - *light* or *dark*
* faces – *true* or *false*
* stream - *true* or *false*
* header - *true* or *false*
* border - *true* or *false*
* local - valid language code (e.g. *en_US* or *es_MX*) see [.xml file](http://www.facebook.com/translations/FacebookLocales.xml "Facebook locales XML") with all Facebook locales


If you want Like Box *220 pixels width*, *dark color scheme* and *showing stream* you need to use it next way:

`[sfp-like-box width=220 colorscheme=dark stream=true url=http://www.facebook.com/yourPageName]`

**or**

Use `sfp_like_box()` template tag in your theme files.

`<?php if ( function_exists("sfp_like_box") ) {
	$args = array(
		'url'			=> 'http://www.facebook.com/wordpress',
		'width'		=> '292',
		'faces'		=> false,
		'header'		=> false,
		'local'		=> 'en_US'
	);
	sfp_like_box( $args );
} ?>`

== Frequently Asked Questions ==

= I can get a box to display on the blog, but it contains the message “There was an error fetching the like box for the specified page”. What am I doing wrong? =

Like Box is only for Fan Pages and **not** for your personal page.

== Screenshots ==

1. Widget in the dashboard.
2. Widget on your site.
3. Shortcode inside your post.

== Changelog ==

= 1.3 =
* Add-on support added

= 1.2.2 =
* Option to show Like Box with no border changed to native Facebook data-show-border=false;

= 1.2.1 =
* Added option to show Like Box with no border;
* Added Norwegian(bokmal) locale to widget;

= 1.2 =
Plugin structure reorganized. Shortcode and template tag functionality added.

= 1.1 =
More than 20 Facebook Locales added.