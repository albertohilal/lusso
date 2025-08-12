<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'lusso_wp' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'Gr8X:YxX;4a~!&N}ANm8#Y1.KHM*KRF@pZJX5iYMiMX7*6[kyuw<hg4CuHx1x<H|' );
define( 'SECURE_AUTH_KEY',   '].)LmU!%&$rSIvpSpybOhE1M7*{Q7m0Nj]`dsW!;lT7TK._|Pgr7A%4~_=h+t*Zg' );
define( 'LOGGED_IN_KEY',     'X(b=9$>~Baw*?@&N)hwOp^.]~3FE17ghbv`2T]{gTU;@R~}F},S-yGYqkMWI[%F:' );
define( 'NONCE_KEY',         'U1;Aqj]c|U#R5Tx7UX.gw-_]^.PvPNtp+w)&%Rx(.6YH9S4(*BPH]vNV/*wDwOte' );
define( 'AUTH_SALT',         'bEU&~l$Q%gcb}uDL84SVJ8EhCG08v7|A9=X9kA<HQWr]7{7=kOP>Cc}~[SCj=/QC' );
define( 'SECURE_AUTH_SALT',  'K1HNT~~eMNUBDj@Wkqm*`*l>mVzgB/PE6>5717O:7u;2u$x[9-?Zl7q3V=?mg5E(' );
define( 'LOGGED_IN_SALT',    'Z=5JevX0g}-sXm~JM#<!~Y(PyI30FrcYiwYWij.PFd CB^Ewt$6JVzsR^][&>Y*n' );
define( 'NONCE_SALT',        'vU*!Kp?*P6RnGoN20<+`Tz@uDy2bbahpfsl#@q0y`Ic+D)8zx8>{.w?GQ&NpGLk!' );
define( 'WP_CACHE_KEY_SALT', 'H2OF&vw>xG.6Xb2xg2~H0%#T=7DS]?|zN]p_TY6j0K-m_W.y~8#^iGE;G}9UuoID' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
