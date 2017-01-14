<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'theretailer_demo_1_6');

/** MySQL database username */
define('DB_USER', 'gb_retailer_16');

/** MySQL database password */
define('DB_PASSWORD', 'FxwHKSWT');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '/ur:JRV{hV,Q^vq(-GbAjfkr(2[=#t(#Q/3&k 3@oXE!| b+d.Ulakxe-/%.=$Ij');
define('SECURE_AUTH_KEY',  'j q>Fpq0-je#Rxh,{yNTQ=70B?1`v} 83g?.`GU#pTCo6Cw,OVU#-(,~eS,c=HMT');
define('LOGGED_IN_KEY',    'KL9=,F1i[I`,&||._W-s%5<uxM$U2/~!K/Yngei.CcUQu@94YC/)|n/F7yy:3|ku');
define('NONCE_KEY',        'upxnO@1n(V){W+Yj g3&QZ_r[-bHCZ3on&f0;xyzD4a:p.TK!GG8a4JEMT,kUC}J');
define('AUTH_SALT',        '`M;V;++D4j`5fg>@nlQ6Y4S?6f]-F$2r~-w;hu)6b}HMuN^=D`gga%lQ0&P/4+|9');
define('SECURE_AUTH_SALT', 'V6]WlffBX+8fsBzbpMw=;hGz{H1lS;!lN%M2h,FlFd!@t9(T#qk|VJFVMGrHH1{;');
define('LOGGED_IN_SALT',   ';]6} |}Db2!z/|w(cJjox,Y2QD7$+2WTnYA0:j9 eIl05oM{!09UuPcWIT?WntL`');
define('NONCE_SALT',       'a_e`&s6>B8jE$@=#k_<9h|X+U4_bbEi~1+t-HohO8)s9N`P+wKX|bh|p[80jnoHQ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_retailr';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
