Google Analytics Dashboard
==========================

Adds a Google Analytics widget to your Dashboard and more nice features.

Change log
==========

2.1.1
-----
 * Small bug fix that prevents a die in the constructor.

2.1
---
 * Made the entire plugin i18n compatible.
 * Replace deprecated `update_usermeta` and `get_usermeta` calls.
 * Several security fixes.

2.0.5
-----
 * Use proper call for escaping post id in draft query

2.0.4
-----
 * Updated to use version 2.4 of the Google Analytics API 
 * Fixed bug with PHP reference passing.

2.0.3
-----
 * Changed included javascript to use AJAX url instead of getting it by calling a php function.
 * Fixed date range display.

2.0.2
-----
 * Added more error checking to curl responses
 * Changed warning when options haven't been saved on the options page
 * Use newer version of admin URL generator for WordPress 3.0 and later
 * Use plugins_url to locate the Javascript needed in the dashboard
 * Added ability to turn off stats display on posts/pages list

2.0.1
-----
 * Fixed problem when other plugins include the same OAuth library

2.0.0
-----
 * Stop unlink warnings when caching won't work
 * Refactored code so that major parts are split into classes
 * Refactored code to better separate UI code
 * Fixed mime type not being sent correctly for admin area javascript file
 * Made the dashboard panel load asynchronously so the entire dashboard 
    doesn't block while it is loading
 * Made the analytics column in posts and pages not block the loading of the page
 * Use transient API support with WordPress version 2.8+
 * Fix bug in WordPress version checking
 * Added ability to support multiple analytics sources
 * Added support for Google OAuth login
