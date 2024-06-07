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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'practice_project' );

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
define( 'AUTH_KEY',         '!~kti-A_{88qXpQRz7te]0c1/m(cC<O=[F;A+uB`Ed&HKd=SO&.|m-#V?;TIH<I:' );
define( 'SECURE_AUTH_KEY',  '&hNwDv mw4b;&JeM/l5b0J!QGME8{J@w+md4j]I5bfPJ~6f,MsN)OCizGYrxzy5S' );
define( 'LOGGED_IN_KEY',    'U?Dv$n2y}&)#ND$.&]75}?wuJTu?r[-KdAba`[!I5J8wpbK/[q!18U c^je3d9sB' );
define( 'NONCE_KEY',        '5nw5M4F-J!pa+(6G&?Nh4~:;5]dF8g{BOFg[KEkMYpLpBw&DDM^=xvCYf1S<ew%9' );
define( 'AUTH_SALT',        '1E{1BV|9-7CT!PiS|%7_CVO%|4h(yR gk$a4s0.a)Eg<)wF.=i][=22RC[^LMwMs' );
define( 'SECURE_AUTH_SALT', '+b&+__v@)<4JI7^4@i~tpab:8$IW!*&cGq]l^pLg:)i[Vz$ePbY`US<l!j*pZD,&' );
define( 'LOGGED_IN_SALT',   's~/VQdt)E83b4N14IYm]|(-EAN}TEg1ju1)0]l7rfym?/}wK>KUw[]M*hFEyW/=+' );
define( 'NONCE_SALT',       'C+rIeMfq%SM:gFyl2BK{4]LYY{+k(TrK!*=^K}ZwX66wD.+VEsX$E|+!OX&tyd1w' );

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
