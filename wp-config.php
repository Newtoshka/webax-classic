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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'webax' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', '' );

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
define( 'AUTH_KEY',         'Ea;W_RqV{{FSM]YRZu$!NxI986@{G9EXW]rgzZ&?{6k-Z?[Y[laV`vz$(?kG!z?E' );
define( 'SECURE_AUTH_KEY',  'X/$H&}V5H z@Q7~L-*Unt6c5EP|(c10{jk^9YnD69)iH?lt1-^vhi4U| 0U^~t%>' );
define( 'LOGGED_IN_KEY',    '_rdW[l0zPx2C<-xY[%&zzPHJyvI~qb.A2)X Qo_uo}#mxZOyEN<BDs`:!3C%%)Ms' );
define( 'NONCE_KEY',        'ng6O|8Jg;B[|[!(ZW;MV3smw7s0v.5/A_5tcIC4~/dB(VLb;V4R9c3K`^?7s:4pz' );
define( 'AUTH_SALT',        'b<Bt(>txLjZ]>[JoQfi3Niw*GaAS#uZ]s|g?eFpJI7*[g%s-bZ|a;!K_LqID3=0v' );
define( 'SECURE_AUTH_SALT', 'OX_S)L[1DD*J~Jg[{^sswpgBp3AR&|bYex>2E._s5t-A:(OCQ}1TZg@9(-B$1&[_' );
define( 'LOGGED_IN_SALT',   'tx7 7PF~+)Q@hMrLzmN4O%{u51+:1u&yDq-_C+kaPQ736XXL 6Y-h&K%VNf`zbx,' );
define( 'NONCE_SALT',       'd82r9H)*q+W_zCz8$c,M^)#q2UV~S>oV#a&[T$HeBkv{U`2G,6(kw5EM9r[QT>km' );

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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
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
