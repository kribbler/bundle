<?php
/*
Plugin Name: WordPress Password
Version: 0.4
Plugin URI: http://broome.us/wp-password/
Description: Requires any visitor to a Wordpress post/page to know the password to access the site.  See <a href="options-general.php?page=wp-password.php">Wordpress Password Options</a> to configure.
Author: Jonathan Broome
Author URI: http://broome.us/

	Copyright 2007  Jonathan Broome  (email : jonathan@broome.us)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation; either version 2 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
	
*/

load_plugin_textdomain('WordpressPassword','wp-content/plugins/wp-password');

class us_broome_wordpress_password {

	function password_mechanism() {
		
		// defaults...
		global $wpdb;
		$source = 'none';
		$debugOption = false;
		if ($_GET['wp-password-debug'] == 1) $debugOption = true;
		$hiddenURIPrefix = ''; // '~' or '%7E' or just '' as needed.  '' is the default.
		$dest = $_POST['destination'];
		if (!$dest) $dest = $_GET['destination'];
		if (!$dest) $dest = $_SERVER['REQUEST_URI'];

		$logout = $_GET['wp-password-logout'];
		if (!$logout) {
			$logout = false;
		} else {
			$logout = true;
		}
		
		$thisURI = str_replace('/' . $hiddenURIPrefix, '/', $_SERVER['REQUEST_URI']);
		
		$siteRoot = get_option('siteurl') . '/';

		if ($debugOption == true) echo "\n<br/>WP-Password Debug| version : 0.4";

		$listMode = get_settings('password_list_mode'); // 'exclude' (default) or 'include'
		if ($debugOption == true) echo "\n<br/>WP-Password Debug| listMode : " . $listMode;
		if (!$listMode) $listMode = 'exclude';
		if ($listMode == 'exclude') {
			$matchThis = false;
			// If using standard 'exclude' mode for the list, then by default nothing is excluded until a pattern matches below.
		} else {
			$matchThis = true;
			// If using 'include' mode for the list, then by default everything is excluded until a pattern matches below.
		}		
		
		$domain_prefixes = get_settings('password_domain_prefix');
		if (!$domain_prefixes) $domain_prefixes = 'www'; // default to www or not.
		$domain_prefixes .= ','; // always also test the 'no prefix' option
		$sitePW = get_settings('password_password');
		$inputPW = '';
		$location = '';
		$patternList = get_settings('password_exclude_list');
		if (!$patternList) $patternList = '';
		if ($debugOption == true) echo "\n<br/>WP-Password Debug| patternList: " . $patternList;

		// If there's no password set, don't check anything
		if (!$sitePW) return;

		if ($debugOption == true) echo "\n<br/>WP-Password Debug| site password is set";

		// possible to reach the site by http(s)://domain.  AND http(s)://www.domain. ? Test.
		$arrDP = split(',', $domain_prefixes);
		for($i=0 ; $i< count($arrDP) ; $i++) {
			$dp = trim($arrDP[$i]);
			if (strlen($dp)>0) $dp .= '.';
			if ($debugOption == true) echo "\n<br/>WP-Password Debug| Testing Domain prefix: $dp";
			if (strlen($_SERVER['HTTPS']) == 0 or $_SERVER['HTTPS'] == "off") {
				$domainurl = "http://" . str_replace('..', '.', $dp . $_SERVER['HTTP_HOST']);
			} else {
				$domainurl = "https://" . str_replace('..', '.', $dp . $_SERVER['HTTP_HOST']);
			}
			if ($_SERVER['SERVER_PORT'] != "80") $domainurl .= ":" . $_SERVER['SERVER_PORT'];
			// If this domainurl is in $siteroot, we found our match, quit looking...
			if (strpos(strtolower($siteRoot), strtolower($domainurl)) !== FALSE) break;
		}
		
		$siteRoot = str_replace($domainurl, '', $siteRoot);
		if ($debugOption == true) echo "\n<br/>WP-Password Debug| Domain url: $domainurl";
		if ($debugOption == true) echo "\n<br/>WP-Password Debug| Site Root: $siteRoot";
		
		$invalidPWURL = $siteRoot.'wp-content/plugins/wp-password/login.php';
		if ($debugOption == true) echo "\n<br/>WP-Password Debug| invalidPWURL: " . $invalidPWURL;

		if ($listMode == 'exclude') {
			$patternList .= "\n" . $invalidPWURL . "*\n";
			// If using standard 'exclude' mode for the list, then by default the login page is excluded.
			// The problem with that is that it's already root-based, and the pattern check later adds the root again.
		}		

		$patternList = str_replace('\n\n', '\n', str_replace('\r', '\n', $patternList));
		// split it to an array
		$arrPattern = split("\n", $patternList);

		// was a logout requested?
		if ($logout == true) {
			if ($debugOption == true) echo "\n<br/>WP-Password Debug| Logout Requested";
			if (setcookie('wordpress_password', '', 0, '/') == TRUE) {
				// cookie re-set, redirect back here.
				$location = $thisURI;
			}
		} else {

			// was a password submitted?
			if ($debugOption == true) echo "\n<br/>WP-Password Debug| POSTed PW Len: " . strlen($_POST['wordpress_password']);
			if ($debugOption == true) echo "\n<br/>WP-Password Debug| GETed PW Len: " . strlen($_GET['wordpress_password']);
			if ($debugOption == true) echo "\n<br/>WP-Password Debug| COOKIEed PW Len: " . strlen($_COOKIE['wordpress_password']);
			if(strlen($_POST['wordpress_password']) > 0) {
				$inputPW = $_POST['wordpress_password'];
				if (setcookie('wordpress_password', $inputPW, 0, '/') == TRUE) // cookie set!;
				$source = 'form';
				$location = $dest;
				if ($sitePW != $inputPW) {
					$err='Wrong Password.';
					$location = $invalidPWURL .'?err='.$err.'&destination='.$dest;
					if ($debugOption == true) echo "\n<br/>WP-Password Debug| Wrong PW. Redirecting to Login, dest = $dest";
				}			
			} else {
				if(strlen($_COOKIE['wordpress_password'])>0) {
					$inputPW = $_COOKIE['wordpress_password'];
					$source = 'cookie';
					if ($debugOption == true) echo "\n<br/>WP-Password Debug| Submit PW = Site PW?: " . !(!($inputPW != $sitePW));
					if($inputPW != $sitePW) {
						$inputPW = "";
					}
				}
			}
		}

		if (strlen($location) == 0) {
			if ($debugOption == true) echo "\n<br/>WP-Password Debug| thisURI: " . $thisURI;
			for($i=0 ; $i< count($arrPattern) ; $i++) {
				$x = trim($arrPattern[$i]);
				if(strlen($x) > 0) {
					// Avoid the double-root issue:
					$w = str_replace($siteRoot, '', $x);
					$x = $w;
					if ($debugOption == true) echo "\n<br/>WP-Password Debug| pattern: " . $x;
					$y = '/^' . str_replace('/', '\/', str_replace('https:/', 'https://', str_replace('http:/', 'http://', str_replace('//', '/', str_replace($siteRoot . $siteRoot, $siteRoot, $siteRoot . str_replace('*', '.*', str_replace('?', '\?', str_replace('.', '\.', $x)))))))) . '$/i';
					if ($debugOption == true) echo "\n<br/>WP-Password Debug| pattern as site-based RegEx: " . $y;
					if ($debugOption == true) echo "\n<br/>WP-Password Debug| RegEx Match pattern to thisURI?: " . !(!(preg_match($y, $thisURI)));
					if (preg_match($y, $thisURI)>0) {
						if ($listMode == 'exclude') {
							$matchThis = true;
							// If using standard 'exclude' mode for the list, then this URI is excluded.
						} else {
							// if not already on the login page...
							$z = '/^' . str_replace('/', '\/', str_replace('.', '\.', $invalidPWURL)) . '\?/i';
							if ($debugOption == true) echo "\n<br/>WP-Password Debug| PW probably required here. Check if this is the login page " . $z;
							if ($debugOption == true) echo "\n<br/>WP-Password Debug| RegEx Match login page to thisURI?: " . !(!(preg_match($z, $thisURI)));
							if (!preg_match($z, $thisURI)>0) {
								$matchThis = false;
								if ($debugOption == true) echo "\n<br/>WP-Password Debug| No login page match";
								// If using 'include' mode for the list, then this URI is included (not excluded).
							}
						}		
						break;
					}
				}
			}

			if ($debugOption == true) echo "\n<br/>WP-Password Debug| Require PW for this request?: " . !(!($matchThis == false));
			if($matchThis == false) {
				// current url not found in the exclusion list.  check passwords
				if ($debugOption == true) echo "\n<br/>WP-Password Debug| POST Dest: " . $_POST['destination'];
				if ($debugOption == true) echo "\n<br/>WP-Password Debug| GET Dest: " . $_GET['destination'];
				$dest = $_POST['destination'];
				if (!$dest) $dest = $_GET['destination'];
				if (!$dest) $dest = $_SERVER['REQUEST_URI'];
				if ($debugOption == true) echo "\n<br/>WP-Password Debug| Using Dest: " . $dest;
	
				if (strlen($inputPW) == 0) {
					// no password, no passage.
					if ($debugOption == true) echo "\n<br/>WP-Password Debug| No password submitted. ";
					$location = $invalidPWURL .'?err='.$err.'&destination='.$dest;
					if ($debugOption == true) echo "\n<br/>WP-Password Debug| Location set to $location";
				}
	
				if (strlen($location) == 0 && (strlen($inputPW) > 0) && ($sitePW != $inputPW)) {
					$err='Wrong Password.';
					$location = $invalidPWURL .'?err='.$err.'&destination='.$dest;
					if ($debugOption == true) echo "\n<br/>WP-Password Debug| Wrong PW. Redirecting to location: $location";
				}
	
				if (strlen($location) == 0 && ($sitePW == $inputPW)) {
					// still here?  Welcome to Fantasy Island! (Cue the sexy, giggling beachgoers)
					if ($debugOption == true) echo "\n<br/>WP-Password Debug| Correct PW.";
					if ($source == 'form') {
						if (!$dest) $dest = $siteRoot;
						$location = $dest;
						if ($debugOption == true) echo "\n<br/>WP-Password Debug| Correct PW, not dest. Dest now = $dest";
					}
				}
			}
		}

		if (strlen($location) > 0) {
			if (strpos($location, '?') != strrchr($location, '?')) {
				$y = substr($location, 0, strpos($location, '?') ) . '?';
				$z = str_replace('?', '&', str_replace($y, '', $location));
				$location = $y.$z;
			}
			$search = preg_quote('wp-password-logout', "/");
			$location = preg_replace("/".$search."/i", 'wp-password-logged-out', $location); 
			if ($debugOption == true) {
				echo "\n<br/>WP-Password Debug| Redirecting... to $location";
			} else {
				// header( 'Location: ' . $location ) ;
				echo "\n<script type=\"text/javascript\">window.location=\"$location\";</script>\n";
				echo "\n<noscript>An automatic redirect has failed.  You should have been redirected to <a href=\"$location\">this url</a>.</noscript>\n";
				exit;
			}
			exit;
		}
	}
	
	function password_subpanel() {
		if (isset($_POST['info_update'])) {
?>
			<div class="updated"><p><strong>
<?php
				update_option("password_password", $_POST['password_password']);
				update_option("password_exclude_list", $_POST['password_exclude_list']);
				update_option("password_list_mode", $_POST['password_list_mode']);
				_e('Wordpress Password options updated.', 'WordpressPassword')
?>
			</strong></p></div>
<?php
		}
	add_option("password_password", "", "Password to protect this blog", "yes");
	add_option("password_exclude_list", "", "root-relative, newline separated paths to exclude", "yes");
	add_option("password_list_mode", "", "Does the exclude_list excuse URIs from testing or force them into it?", "yes");
	$sitePW = get_option("password_password");
	// $invalidPWURL = get_option("password_invalid_pw_url");
	$excludeList = get_option("password_exclude_list");
	$listMode = get_option("password_list_mode");
	$listModeE = 'checked';
	$listModeI = '';
	if ($listMode == 'include') {
		$listModeE = '';
		$listModeI = 'checked';
	}
?>
		<div class=wrap>
		<form method="post">
		<h2>Wordpress Password Options</h2>
		<fieldset name="set1">
		<legend><?php _e('Password', 'WordpressPassword') ?></legend>
		<?php _e('Site Password: (blank = no password required):', 'WordpressPassword') ?>
		<input type="text" name="password_password" value="<?php echo stripslashes(str_replace('"', '\'', $sitePW)) ?>" size="20" maxlength="20" />
		</fieldset>

		<br/>
		<fieldset name="set3">
		<legend><?php _e('List Mode', 'WordpressPassword') ?></legend>
		<?php _e('Should the list below be used to Exclude listed URIs from Password Requirement, or Include them?:', 'WordpressPassword') ?><br/>
		<input type="radio" name="password_list_mode" value="exclude" <?php echo $listModeE ?> /> <?php _e('exclude (default)', 'WordpressPassword') ?><br/>
		<input type="radio" name="password_list_mode" value="include" <?php echo $listModeI ?> /> <?php _e('include', 'WordpressPassword') ?><br/>
		<ul>
		<li><?php _e('In Exclude mode, the URL patterns defined below will let visitors see a matching URL without requiring the password.', 'WordpressPassword') ?></li>
		<li><?php _e('In Include mode, the URL patterns defined below will let visitors see all URLs at your site without requiring the password, except matching URLs.', 'WordpressPassword') ?></li>
		</ul>
		</fieldset>

		<br/>
		<fieldset name="set3">
		<legend><?php _e('URL Matching', 'WordpressPassword') ?></legend>
		<ul>
		<li><?php _e('List relative urls, one per line (relative urls start with "/" - i.e. /wp-login.php).', 'WordpressPassword') ?></li>
		<li><?php _e('urls are case in-sensitive /THIS = /this', 'WordpressPassword') ?></li>
		<li><?php _e('* may be used as a wildcard at the beginning or end of a url to match any occurrence in the url.', 'WordpressPassword') ?></li>
		<li><?php _e('Examples:', 'WordpressPassword') ?>
		<ul>
			<li><?php _e('/wp-admin* <em>matches all /wp-admin pages</em>', 'WordpressPassword') ?></li>
			<li><?php _e('/wp-login.php <em>matches /wp-login.php</em>', 'WordpressPassword') ?></li>
			<li><?php _e('/?feed=* <em>matches feed urls</em>', 'WordpressPassword') ?></li>
		</ul>
		</li>
		</ul>
		<textarea name="password_exclude_list"><?php echo stripslashes(str_replace('"', '\'', $excludeList)) ?></textarea>
		</fieldset>

		<div class="submit">
		<input type="submit" name="info_update" value="<?php _e('Save Wordpress Password Options', 'WordpressPassword') ?>" /></div>
		</form>
		<p>For updates, feature requests, feedback or gratuities, visit <a href="http://www.broome.us/wp-password">http://www.broome.us/wp-password</a></p>
		</div>
<?php
	}

	function password_add_menu() {
		if (function_exists('add_options_page')) {
			add_options_page('Wordpress Password', 'Wordpress Password', 8, basename(__FILE__), array('us_broome_wordpress_password', 'password_subpanel'));
		}
	 }

	function password_reset() {
	// reset this, so you can escape the doom of having forgotten your password.
	// To recover, just delete the wp-password.php plugin, verify it's fone from the WP admin, then re-upload it, then re-activate it.  Password reset!
	add_option("password_password", "", "Password to protect this blog", "yes");
	update_option("password_password", "");
	 }
	 
	function do_nothing() {
		 // Nothing
	 }

	// end of us_broome_wordpress_password class
}

add_action('activate_wp-password/wp-password.php', array('us_broome_wordpress_password', 'password_reset'));
add_action('admin_menu', array('us_broome_wordpress_password', 'password_add_menu'));
add_action('init', array('us_broome_wordpress_password', 'password_mechanism'));
?>
