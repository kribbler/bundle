/**
 * affiliates.js
 * 
 * Copyright (c) 2010, 2011 "kento" Karim Rahimpur www.itthinx.com
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
 * @package affiliates
 * @since affiliates 1.0.0
 */
function LWLToggler(element) {
	if (!jQuery(element).hasClass("clickToggler")) {
		jQuery(element).addClass("clickToggler");
		jQuery(element).live('click', function() {
			var content = jQuery(this).parent().children(".options-view-content");
			var option = jQuery(this).parent().children(".options-view-expand");
			if ( content.is(":hidden") ) {
				content.slideDown("fast");
				jQuery(this).removeClass("expand");
				jQuery(this).addClass("retract");
				option.val("1");
			} else {
				content.slideUp("fast");
				jQuery(this).removeClass("retract");
				jQuery(this).addClass("expand");
				option.val("0");
			}
		});
	}
}
