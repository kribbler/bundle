<?php
/**
 * lwl-widget-css.php
* 
 * Copyright 2010, 2011 kento (Karim Rahimpur) www.itthinx.com
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
?>
<?php
// bootstrap WordPress
if ( !defined( 'ABSPATH' ) ) {
	$wp_load = 'wp-load.php';
	$max_depth = 100; // prevent death by depth
	while ( !file_exists( $wp_load ) && ( $max_depth > 0 ) ) {
		$wp_load = '../' . $wp_load;
		$max_depth--;
	}
	if ( file_exists( $wp_load ) ) {
		require_once $wp_load;		
	}
}
if ( defined( 'ABSPATH' ) ) {
	header('Content-type: text/css');
	echo LWL_generate_CSS();
}