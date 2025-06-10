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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'user' );

/** Database password */
define( 'DB_PASSWORD', 'bonjour' );

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
define( 'AUTH_KEY',         'ypI}Cv ~7I?FdMupylR^LI=htku q%H^ZtXkh:xHn;~NA@{qB4PGGCf;OzQd#rc5' );
define( 'SECURE_AUTH_KEY',  '%xk]%+Ts7A0VvWVTn{A+d[Y/E5T8 Jxj+S[.dZRxIN.2,&x }KEQJtoKHl!p`Ef_' );
define( 'LOGGED_IN_KEY',    'jd/)H.2K=|Y[Ps~}YFH<EB%2WVb*l*+PT T$Yi}qZRH-b~1K@E@[y6sq8S[-a,uh' );
define( 'NONCE_KEY',        '1@MJzlg<e~wZn]&>p0_22P?S>Z!if$#FB.L[?v4bBf_[B.9:I2=8gCk[7{nUNP59' );
define( 'AUTH_SALT',        '&&4~~4&p|`4sl}w3$G&5,Q{Q7,:-~?ohke8^(kP!m1ES(m*i${wY%hJ2F*4sen@X' );
define( 'SECURE_AUTH_SALT', '==kj{d{$PrT&Lum}`.>ZtC=L%hq`9 z+ws3r7`rg()L%lY!jaWqs+C^Cf]{< >5?' );
define( 'LOGGED_IN_SALT',   '=vilA{rJ$%Zh?KsJe^[fTM<.fuFoi&_d)F.fU-Pgri$TW4.KB4AoW`TQNtn0mpmU' );
define( 'NONCE_SALT',       'wf(sqQ!84VjHda)pu+tzPW.Gj!;(w?to&h{@Qx+4pa|UCi[elb3ZS5gSHTc}c8>y' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
