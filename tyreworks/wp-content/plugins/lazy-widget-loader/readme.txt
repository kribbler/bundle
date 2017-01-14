=== Lazy Widget Loader ===
Contributors: itthinx
Donate link: http://www.itthinx.com/plugins/itthinx-lazyloader
Tags: ad, addtoany, ads, adsense, async, asynchronous, asynchronous loading, del.icio.us, delicious, deviantart, facebook, facepile, flickr, lazy, lazy acquisition, lazy load, lazy loading, like box, likebox, linkedin, page load, page load time, page loading, page loading time, page rank, page speed, pagerank, pagespeed, twitter, seo, site, social, vimeo, widget, wordpress, xing, youtube, zork
Requires at least: 3.0
Tested up to: 3.6
Stable tag: 1.2.8
License: GPLv3

Lazy Widget Loader provides lazy loading for widgets to improve page loading. Use on slow widgets with content from Facebook, Twitter, AdSense ...

== Description ==

The Lazy Widget Loader plugin provides lazy loading for widgets to improve page loading.
Use it on slow widgets, especially those where external data is loaded, like widgets from Facebook, Twitter, AdSense, ...

What this plugin basically does is to postpone loading the content of those widgets you choose, so that their content is loaded after the main content of the page that is displayed.

You can choose which widgets should be loaded like that, by default the plugin does not “impose” itself on any widget. You may also choose to display a throbber while the content of a widget is loaded.

__Feedback__ is welcome!
If you need help, have problems, want to leave feedback or want to provide constructive criticism, please do so here at the [Lazy Widget Loader plugin page](http://www.itthinx.com/plugins/lazy-widget-loader).

Please try to solve problems there before you rate this plugin or say it doesn't work.

A _lot_ of work goes into providing you with free quality plugins! Please appreciate that and help with your feedback. Thanks!

[Follow me on Twitter](http://twitter.com/itthinx) for updates on this and other plugins.

__Translations__

* Lithuanian translation provided by Vincent G from [Host1Free](http://www.Host1Free.com) - Thanks for your help!

= Advanced lazy loading integration =

The Lazy Widget Loader can take advantage of the *advanced asynchronous loading* mechanism provided by the [Itthinx LazyLoader](http://www.itthinx.com/plugins/itthinx-lazyloader) for content and widgets.
This plugin helps to optimize site speed by greatly improving page load time and bandwidth usage.
Instead of deferred loading in the footer, it provides advanced options that allow to load any content only when needed.
These include shortcodes that allow to lazy-load content anywhere on a page, the option to load content on sight and an automatic noscript feature that helps to provide alternative content for visitors that have disabled JavaScript.
You can see a [demo of the Itthinx LazyLoader here](http://www.itthinx.com/plugins/itthinx-lazyloader-demo).

== Installation ==

1. Upload or extract the `lazy-widget-loader` folder to your site's `/wp-content/plugins/` directory. Or you could use the *Add new* option found in the *Plugins* menu in WordPress.  
2. Enable the plugin from the *Plugins* menu in WordPress.

You're ready to go. To enable lazy loading for any widget, go to your *Widgets* section under the *Appearance* menu and check *Lazy Loading* on every widget that should be loaded after the main page's content is ready.

Please also visit the [Lazy Widget Loader plugin page](http://www.itthinx.com/plugins/lazy-widget-loader) for the latest info.

== Frequently Asked Questions ==

= What is 'lazy loading'? =

The term *lazy loading* (also *lazy acquisition*) refers to a technique that postpones loading (acquisition) of an object (content, resources, ...) until it is really needed.
In our case, this means that we still have to get the content that is to be displayed in the widget, but we postpone its acquisition until the latest possible moment,
so that its possibly negative impact on loading the rest of the page is minimized.

How does Lazy Widget Loader accomplish its goal? The contents of chosen widgets are loaded in the page's footer and once the page has loaded completely, these contents
are moved to where they should appear. As we postpone loading of these contents until the very last moment, our page will render its contents and will not be affected
by those contents in slow widgets that take more time to load.

Note that *lazy loading* is often understood as to retrieve resources when they come into view, for example if you have an image at the bottom of your page and you want to make sure that this
image is not loaded, unless the viewer scrolls down to where that image should appear. But that is not this plugin's strategy; if you want to be able to load content on sight, take a look at the [Itthinx LazyLoader](http://www.itthinx.com/plugins/itthinx-lazyloader).

= Can I choose which widget is loaded lazily? =

Yes.

Go to the *Widgets* section under the *Appearance* menu and check *Lazy Loading* on those widgets that tend to slow down your page.

= Do I get a throbber while the widget loads? =

Yes you do if you want to.

Go to the *Widgets* section under the *Appearance* menu and check *Throbber* on those widgets that should show one.
Of course, for this to happen, you must also check the *Lazy Loading* option.
Also note that in this case the minimum height of a widget will be set to the height of the throbber or the height given in the appropriate field, whichever is greater.

= Does this improve the page loading time of my site? =

It improves the way widgets are loaded, especially those that take a while to load. It does not make your pages load faster.
So if you have one widget that appears in, say, the middle of a page and this widget really takes a looong time to load, then your entire page will take ... looong to load because whatever is displayed in that particular widget takes quite a while to show up.
Now here is why you would want to use this plugin. In the case of said widget, you would activate the *Lazy Loading* option for it. After that, what you should see is that first your page renders, after that, the content of your slow widget will appear as well.
The result of that is: your page renders within a reasonable time and the content of the slow widget(s) is displayed when available, without slowing down the visualization of your entire page.

= Does this work with more than one widget? =

Yes. You can activate lazy loading for any active widget.

= Should I enable the 'Lazy Loading' option for all my widgets? =

*No!*

Widgets handled by Lazy Widget Loader will be shown after everything on the page has been loaded, including images etc.
So widgets that load normally should NOT be loaded using Lazy Widget Loader.
Only those that really can slow down page rendering should be loaded using Lazy Widget Loader.

= Help! =

... [this](http://www.itthinx.com/plugins/lazy-widget-loader) is the right place to ask for help.

= I really appreciate this, how can I contribute? =

Your contribution to the [Itthinx LazyLoader](http://www.itthinx.com/plugins/itthinx-lazyloader) will provide you with advanced loading options and support. 

== Screenshots ==

1. Basic plugin option displayed for a widget: enable/disable lazy loading.

2. Advanced options can be expanded individually on each widget. These include the option to display a throbber and to set fixed or minimum dimensions.

[Custom Post Widget](http://wordpress.org/extend/plugins/custom-post-widget) and [Lazy Widget Loader](http://wordpress.org/extend/plugins/lazy-widget-loader) are quite useful together.
Embed widgets based on code from external sources like Facebook, Twitter etc. with *Custom Post Widget* and let *Lazy Widget Loader* handle the lazy loading.

== Changelog ==

= 1.2.8 =
* Fixed bug related to widget container parent when it is not present
* WP 3.6 compatibility checked

= 1.2.7 =
* No changes, tested for WP 3.5 compatibility.

= 1.2.6 =
* WP 3.4.1 compatibility

= 1.2.5 =
* Lithuanian translation added

= 1.2.4 =
* Performance improved through better widget CSS handling

= 1.2.3 =
* Corrected formatting
* Added support for Itthinx LazyLoader's offset parameter that triggers load
on sight at a predetermined distance before a widget enters the viewport.

= 1.2.2 =
* Improved compatibility for widgets, including those without controls.

= 1.2.1 =
* Adjusted to avoid compatibility issues with older plugins.

= 1.2.0 =
* Initial public release.
* Mesosense option

= 1.1.0 =
* Added administrative option: delete plugin settings on deactivation.
* Adjusted font size in widget controls.

= 1.0.0 =
* Initial internal release.

== Upgrade Notice ==

= 1.2.8 =
* Bug fixed and WordPress 3.6 compatibility checked

= 1.2.7 =
* WP 3.5 compatibility

= 1.2.6 =
* WP 3.4.1 compatibility

= 1.2.5 =
- Added Lithuanian translation.
- Added missing domain on some language labels.

= 1.2.4 =
Please update: performance improvement - better widget CSS handling - generating file instead of on the fly.

= 1.2.3 =
Now supports Itthinx LazyLoader's offset parameter that triggers load
on sight at a predetermined distance before a widget enters the viewport.

= 1.2.2 =
Further improved widget compatibility, please update. 

= 1.2.1 =
Please update to this release if you get "Warning: Cannot use a scalar value as an array ..."

= 1.2.0 =
There is no need to upgrade yet.
