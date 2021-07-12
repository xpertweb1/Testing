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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'multisite' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '<Gk)kH[=Q]p).=T6+.lyM~y+iz#(#-83W&mc=+N0zU`T a%W?Oa(RIc;?r~(IL?3' );
define( 'SECURE_AUTH_KEY',  'Hmi|]KS_07XbY`.W-3mej-oe}4n[xd>GKpVoJ^[F#Eu(EwUvi|fd7&!s7Q$e/OI@' );
define( 'LOGGED_IN_KEY',    'JYlie%%6/;2|Bsr#YSK?ZF7z!ObA.<]fLgQ%y;B 8ZWPF;S,E9wf1xu:6Qa@|;l|' );
define( 'NONCE_KEY',        'P7?$3<oxD3QMaq)>F?;uO&$sX(j^bW$=n+@`5[!DcbH@qS<}(KLVxLtd=97]kn_L' );
define( 'AUTH_SALT',        '[v4i~{6{ac)ef1UWhV)6+RLvCG4GV9G}3pkaI48Q]G,2u}HypUu:.FPMb@mUpBbq' );
define( 'SECURE_AUTH_SALT', 'matF/iG3x7tE$ F)6m?<x54*tAnrS=H;emg2[E;u|0`#~gM:8Ay^FMUvd OPqmB>' );
define( 'LOGGED_IN_SALT',   '$z[0G9n0v:MC+wCrya2>VSO2*aTyyr)=(d}ecKF@1v&hCUUbce?F-o.-Ue*=OKZV' );
define( 'NONCE_SALT',       '!wP8V*0gr0k^RUkYBu_z$:}Aztp-=5@hoHQWMYkR?HwFB&_BRMq]?}pXG%UxA;/}' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Multisite */
define( 'WP_ALLOW_MULTISITE', true );

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
define('DOMAIN_CURRENT_SITE', 'localhost');
define('PATH_CURRENT_SITE', '/multisite/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);


/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
