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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dynamic_site' );

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
define( 'AUTH_KEY',         'QoqX5l<TSd3adZ;1n@Q6o~/{BxR7:rvveeUj{h5Ajt<y;C}c [#ZdQb7SAsu)D#T' );
define( 'SECURE_AUTH_KEY',  'NhwYuk5u:-74mTs=!^AOy}6FIK;NG!|zm/I/w`$vb|0t?.6A4Zm+gD={1751vY-m' );
define( 'LOGGED_IN_KEY',    '*k*rDr$pTM*gpMK|vkT:5MwcD:6.AL=`q&R)rFos&p+2M_[qSNX9d^ajMVjOMKfa' );
define( 'NONCE_KEY',        'i<OmK&B,Y^+*Uim>E-H(Z?bc79fiFw{Kns`!)<y_^r]|;.Zd2#KMJx<>TlwS0 y1' );
define( 'AUTH_SALT',        'B*p)1}:vq@WEr0j5${U8|DL9mJd4`^?s%aQY?CzYo/j.[G1Ien4M2 RYrmG-sQr-' );
define( 'SECURE_AUTH_SALT', ')$I~R1Ytc3Jtwad$8up@Pzv-CU<frxvTd>Y7&*N|aHb=|/<;3qHK*7TBH[F?az/:' );
define( 'LOGGED_IN_SALT',   ')Nz|j~$sd=.u513B9[H~;_b=)^eaK&)UD10OGj=!|hn,GIsm]%,[.~L<bhcOQo<z' );
define( 'NONCE_SALT',       'a(D]$SDE8ZcgQF,.9hs7f]|rjmAE,[l.v& 56&S*s`ZCmt?*uvb,yvP$3@QRA9J/' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'ds_';

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
