<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wda_wp_batch_3' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'X[SDoQlybwW(@ o1Bz*lrbaL!9-LW-yUBn~?QztjL;px @%+~;[PDXe*%M##~E6`' );
define( 'SECURE_AUTH_KEY',  'VThKYcF]ti+@HlRVP7lN;44,p5ZUY:= 9d:]-OfYVu$?s)2(hgfj21b,=0CWzAP6' );
define( 'LOGGED_IN_KEY',    '/q k=O^e}s1/0l8~Xlj]MNu.O_q~hn`fusZ#uucSY9bJ1An%aw]PyzF|dqtg:D~1' );
define( 'NONCE_KEY',        '>2J3e.O7rkEI23p(6~?/(8|ou<Q|7|k7J[cg(oLDkGWeKj`-G5PeZM&E@eau((LU' );
define( 'AUTH_SALT',        'LAt3ukL#DXz(`*WNLaDqm/Z~YyvUww1A%e&A k[6 iKP@=zH$$M>#:vBtH}}M-r}' );
define( 'SECURE_AUTH_SALT', '_:H8`-gth+vu}rihO$;jInu+r}lf<`T_rkl_IIh:ol?9&X$>oR;2(y/H%>]8Yc7A' );
define( 'LOGGED_IN_SALT',   'ft$(p:C06N=M]5sTtXg1&ckf;uqwTJ@Z:iJD@|Fr3o$#%![aA8F*WXl>+,K|7KTU' );
define( 'NONCE_SALT',       'g&T~U?qxX&S*X36CajlvYT(8my+nwyS6y)L&oU4NS3hVO39KwdO8/A?Ul=8uO^2L' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
