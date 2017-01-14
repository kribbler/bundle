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
define('DB_NAME', 'wp_tyreworks');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

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
define('AUTH_KEY',         '6Iw7IN{`5Tv|`h].]pVgOljH2-Cn>t&%O1Ua) Go96/|[b*=Y>&{u{T!#[V+=0:C');
define('SECURE_AUTH_KEY',  'eI,/sn2@H)f&q#sRIIFp:T>Pn@yJHr (8^q75%$}n _R&^A1=W45%/&t*T6-aer<');
define('LOGGED_IN_KEY',    '|x&W3`:mD#!Sd=?pr9v1fV>_c/VGk l<,<+iqesNDpW<`c[}0,j8p8z_~>DS?R-!');
define('NONCE_KEY',        '06?ot;vZy:BuL6D$Fn;euM[5_p&sKRRRMA[a7A]0J1|+%Wcb7lBdNV)M+k!}~Bri');
define('AUTH_SALT',        'ERCS^_H-qQ[GX)|yfAaxdYYVE@R)RyI3@ [2dudd2d*>9*2yGo]Bc-6{! 2aARpr');
define('SECURE_AUTH_SALT', 'aV4v+9f5~ 3Y-O^qx/^nwm|qVoHERjlNhOqCI-IjUq>Nx;Bm^!2E!Gp>|r1W<0_$');
define('LOGGED_IN_SALT',   'PFSM;SlIM:l+KPzsG|;|Y3%BE_|;i4/p^cyd,pxscA}jc/+sA>h1cJ`ntz+!|Mt3');
define('NONCE_SALT',       'DB-t) -2UgzSri+P9uwBA$OG?|8|.d-See5S#)N/J}`>J9[J6>+GVM% X8wl;c(O');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
