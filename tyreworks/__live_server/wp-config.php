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
define('DB_NAME', '');
//define('DB_NAME', 'cl51-daniel');

/** MySQL database username */
define('DB_USER', '');
//define('DB_NAME', 'cl51-daniel');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'rKg-lHRUYisBx3EpMWeIbhOJ4uIJjWrMrub^/_GAV7ca^kNliPY_NhdhRLINwe!c');
define('SECURE_AUTH_KEY',  '4KP=06Y41r=rEuj)2!7bjXf1b12JrsBawBnZC2BedhUeYFtlKHklIK=uX062-VpW');
define('LOGGED_IN_KEY',    '#+p(N58Gy1mWhA70f3n/K2latxpS6jmyevQLzDvaNqCjAk(iuL)50A-WAPvGQves');
define('NONCE_KEY',        '4xka5!bt1ROpfnO5YsNU7ES7ejLP=s_UjEtIFaQp8ReAC0lpNXWTrzFPRBdo9gKP');
define('AUTH_SALT',        'kVJbwV2g^wG#CDmN#dXG=kkO1#(kWSL=(Ci6waILiEFiWHKhenSumD/HpDGT9d9u');
define('SECURE_AUTH_SALT', 'o)_V2HISGFAmX^nQKYe+zLPQ8MD3J-LVTujkEl/s8zIsps1(U2Uy/Ogn8SgqD))I');
define('LOGGED_IN_SALT',   'FmYn7CjxhG3UUQ6(l/Mf4wzWVuDMl4MvOc4u)JtsMHSPx1OMSjMNVgtQjU#JHCMP');
define('NONCE_SALT',       'Mkrn=LkHb9_A3(sllQmufVlVhSEBY9eFMh5m^Vbf/KAU=XPiY7EAp(EvtlDl1Mry');

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
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
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

/**
 *  Change this to true to run multiple blogs on this installation.
 *  Then login as admin and go to Tools -> Network
 */
define('WP_ALLOW_MULTISITE', false);

/* That's all, stop editing! Happy blogging. */

define( 'WP_MEMORY_LIMIT', '96M' );


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/* Destination directory for file streaming */
define('WP_TEMP_DIR', ABSPATH . 'wp-content/');

