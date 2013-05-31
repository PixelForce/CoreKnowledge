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
define('DB_NAME', 'corek_db');

/** MySQL database username */
define('DB_USER', 'corek');

/** MySQL database password */
define('DB_PASSWORD', 'utr911NMD764');

/** MySQL hostname */
define('DB_HOST', 'n6-mysql5-3.smartyhost.com.au');

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
define('AUTH_KEY',         'VTB;>8)}qe=uvTW<Ps6ZMPWF_}3wy5gThW#Vph+8kt-FHU{W$%]%+5u$|hqXq#{~');
define('SECURE_AUTH_KEY',  '*?=.]J(d3/w$5apy=*v[#G?_k+!-ZgG.2C}]IlKS9=Q,s:AVw#Yqz|Xi*%fb!uV.');
define('LOGGED_IN_KEY',    'Y]x.S%5=+a=Zb.+K4|PkloU}`o+e|8<eqXuZu+9DF 1W@kJoI>%Xo |P|R ,B)FL');
define('NONCE_KEY',        '=^KdJ5}<-|xSU(eV|<J3Wge<PwoL~+X&|eg&3;!Hw`94(aGwnRhw57<_yaV`Dyj.');
define('AUTH_SALT',        'ZTL(sK%]2FF9+YafHt&hBN3Hc>.QZf8-%}+iV[eQDc6bqw!C^J9#s:CL`u3|y}]I');
define('SECURE_AUTH_SALT', 'qyE75cIw3X>+w._Sw-=C, +8q`l+^+8Zgtajl|-X0lPKp3nxn-`%0^H!=J0=`ow6');
define('LOGGED_IN_SALT',   '@(QmJQb>cg@O83tfDngC<H(+*j h|AUw)CLofR)]E{:-8fmYLZ1/UBsqliLsasDz');
define('NONCE_SALT',       'i_>h@*xSPJr]$UWHtBpMd6s5-R9Q+R#JnD&|#~yY0L1^sFk0*@m.exD%#a:fpsF}');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'ck_';

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
