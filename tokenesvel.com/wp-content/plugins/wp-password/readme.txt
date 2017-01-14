=== WP-Password-HageMedia ===
Contributors: jpbroome
Donate link: http://broome.us/wp-password
Tags: restriction, password, password protect, password protection
Requires At Least: 2.1
Tested Up To: 2.3.2
Stable tag: trunk

== Description ==
Wordpress Password is a plugin written for Wordpress 2.0+ for requiring
visitors to enter a password to view wordpress-powered pages of a web site.


== Installation ==
1. Unzip the archive and upload/copy the "Password" directory to your plugins
   folder.  i.e.: 
	* /wp-content/plugins/wp-password/wp-password.php
	* /wp-content/plugins/wp-password/login.php

2. Go to the WordPress plugins admin panel then activate the Wordpress Password
   plugin.
  
3. Go to WordPress Options then select "Wordpress Password" from the Options
   submenu to set a password.


== Notes ==
When the plugin is inactive, or active but a password has not been set,
no password is required.

The password gets reset automatically when the plugin is activated.

Your WP-Admin Administrator password is still required to reach your WP Admin.
This WP-Password plugin just adds an extra layer of password requirement
before you can reach WP-admin (remember, it affects ALL WP powered pages).


== Forgot Your Password? ==
1. FTP into your plugins/wp-password folder
2. Delete wp-password.php
3. Log in to your wp admin, view the plugins page 
	(notice Wordpress Password is missing now)
4. Re-upload wp-password.php
5. Re-activate the Wordpress Password plugin.
	Activating it resets the password.
6. Visit Options|Wordpress Password and set a new password.


== Features ==
* *ver 0.4*
	* Fixed use for sites not on port 80
	* Changed redirection code from header to javascript
	* Fixed use for sites aliasing the blog directory
* *ver 0.3*
	* New features: Logout and Include/Exclude.
* *ver 0.2*
	* Bug fixes, no new features.
* *ver 0.1*
	* You can define a single password to protect an entire site.
	* Password is set via the "Password" subpanel in the Options menu after
	  activation
	* Exclusions allow you to specify certain pages of your site to be password-free.


== Questions/Suggestions/Bugs ==
Visit http://broome.us/wp-password to find my blog entry about the Wordpress
Password plugin where you can post comments/suggestions/bugs.


== Version History ==
* *0.4 - 2008-01-09*
	* Fixed use for sites not on port 80
	* Changed redirection code from header to javascript
	* Fixed use for sites aliasing the blog directory
* *0.3 - 2007-02-24*
	* Added Logout and Include/Exclude features per request.
	* Added Logout option: visit any WP powered url of your site with this
		value pair in the querystring: wp-password-logout=true
		e.g. http://mysite.com/myWppage/?wp-password-logout=true
		The logout function clears any cookie password value saved and then
		refreshes the browser.
	* Added the choice to either Exclude certain urls from password protection (default)
		or Include certain urls (excluding all others).
		This is controlled by the Exclude/Include radiobutton in the admin page.
* *0.2 - 2007-02-02*
	* Fixed bugs:
		* excluded items weren't forced to match beginning of urls, 
		 so it was possible to see protected urls by adding a querystring that
		 included an excluded url.  Bad.
		* some special regex characters weren't properly escaped when evaluating 
		 exclusions (.,)
	* added wp-password-debug=1 querystring option for troubleshooting 
		 what's happening on a page. Ruins redirects, but useful.
* *0.1 - 2007-01-31*
	* Initial (public) release.


== Show Your Support ==
If you like the Wordpress Password plugin and want to give me a pat on the
back, a kind word, a suggestion, etc., I welcome your visit to my web site:
[Broome.us/wp-password](http://broome.us/wp-password)
