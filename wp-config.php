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
define( 'DB_NAME', 'property' );

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
define( 'AUTH_KEY',         '>@*|1^Oo6VE2?zAj7WXR>&9Le!u{x~,Dg[XuLde:eR?rVJcsagz=4i)!N@zGRWP=' );
define( 'SECURE_AUTH_KEY',  'ON~HV,Q8[/@m$g)mh]8[ pXTMbZDr#5Be45P5tE4]SWTjzua(.)yXK_tAWQs?nZW' );
define( 'LOGGED_IN_KEY',    '5=(.7~R+OIJ m]9aHoAsLn4oLv,&bilm^wZ=CKZ7x<faVGsQz,:}XYGzq#o^(bme' );
define( 'NONCE_KEY',        'lD`>9[b[Ha6R5]4hozW$th6On`:i{x%#)/cBCo^syc7gFX;M{{0$jr]M.14 }_8|' );
define( 'AUTH_SALT',        ']O6B+f#-!5yxDY_5<W[Fhe6@%lmWz~t$qHHH|_<m6?NLqMe _o#@PcB-,0|Fp)|4' );
define( 'SECURE_AUTH_SALT', 'G-c8g=Abk=,yEii B3TAOk);l&:u4CcFjl!nNxuufHK -=OQ!JY+Lq4-x$Z&okEK' );
define( 'LOGGED_IN_SALT',   '1,:=;.^)Msno;|/vdM$3B#.w[d!baBJS@qi|Llg$xnzUEPvjc~C<s2J#o&cuclXU' );
define( 'NONCE_SALT',       'mQQ=mY<v ]j>cEAYmh;5AMl`Um^65[=U.Ec3F%i0T:FTNv.K(W01b/Xn{;?D;)Tm' );

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
