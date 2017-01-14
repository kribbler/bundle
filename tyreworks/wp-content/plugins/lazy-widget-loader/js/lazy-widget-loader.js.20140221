/**
 * lazy-widget-loader.js
 * 
 * Copyright (c) 2011 "kento" Karim Rahimpur www.itthinx.com
 * 
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 * 
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * This header and all notices must be kept intact.
 * 
 * @author Karim Rahimpur
 * @package lazy-widget-loader
 * @since lazy-widget-loader 1.0.0
 */
jQuery(window).load(function(){
	jQuery.each(jQuery('.lwl-widget'), function() {
		var widget_id = this.id.replace('lwl-widget-','');
		var widget_container = document.getElementById('lwl-container-'+widget_id);
		if (typeof widget_container != 'undefined') {
			if (typeof widget_container.parentNode != 'undefined') {
				widget_container.parentNode.replaceChild(this, widget_container);
			}
		}
	});
	jQuery('#lwl-widget-contents').remove();
});