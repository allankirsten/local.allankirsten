<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'allankirsten');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '1,L.Xc[FFbOTK~sMGX125F@}QClm@1p(+;Z@iz 4:/<#h8jnH|?U,~X+RtEISbW2');
define('SECURE_AUTH_KEY',  'DSMhPbf;CA-wQ1Key=Pa|R5G`q-4fVI6gX3UyDXn~p@f<<Lyyo)rj_/ox {%)K)A');
define('LOGGED_IN_KEY',    '!D<]jpFCN8Z{In/3C_BSnS ;?!f}xqtaIMMvoY]=SiTu3f$dj(Y%naEAb+C5zD|/');
define('NONCE_KEY',        '}5[braNr9Mt<JjwCZw--PeRnpEZ&:^3a4AR3p5w!v@Ca@:auql$<yTF^0IeRYoUZ');
define('AUTH_SALT',        '^X!S<Bc66gFj}8c8B#pY+HG(#BDeCuzBU?=|r1[M^<^%.$%AY|bC-=wKbCBLCT%h');
define('SECURE_AUTH_SALT', 'T21m%W|x`FLaGGibkUH^|%r_<*z@mNf8fdA>N,moY)&Ok+E(-:6#gmj4gP/$|o4P');
define('LOGGED_IN_SALT',   'uIqEeUmO=HD yytd)rYDQon#`BKPZC]Y?DMMycY93:N}jnHakgmN[Tn!n;|60:{B');
define('NONCE_SALT',       'ppO+JIg~osVPm/P}4CeEm0`UwDV]#49&>~tob>U@8{R}GcBf+dkcF+CYw*@A tS?');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
