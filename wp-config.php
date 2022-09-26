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
define( 'DB_NAME', 'b1lewoyjlfpi4mpbwmjt' );

/** Database username */
define( 'DB_USER', 'ubhyof6kajtc2qrs' );

/** Database password */
define( 'DB_PASSWORD', 'pyQf2MaouTqBXeWdM8XD' );

/** Database hostname */
define( 'DB_HOST', 'b1lewoyjlfpi4mpbwmjt-mysql.services.clever-cloud.com' );

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
define( 'AUTH_KEY',         'F-ZduSCP/r#y~}QZ6[e=PV1A]_BD|ZL]AcpcW8Zw~hTm{4?O@J YeRIsuW?(b-dX' );
define( 'SECURE_AUTH_KEY',  'V)66|D(oj;]>Z!tTLQTcSaV6ty(t?#)NGE4q,.;b<?$@Emxr-}w/U, MopNX4S@G' );
define( 'LOGGED_IN_KEY',    ')5TC@&x8&.:G3Lll<,TY/_h96#2gtb#Z;IH{;eoT[[6>5BPMB*x{*I:cm5NCtQ#^' );
define( 'NONCE_KEY',        'SNg>8}}ebua4A}sV4u40_}sV1>I4X>ZabaL@IfOw$+@C+nAX]Bzya&@^amqiB]b%' );
define( 'AUTH_SALT',        '@Bdccu0~?G]|Mx{}V$^=3@gu[,GgF#Jthq]F0g1{$vu</qEi;.QHy2w~HnI.dv2?' );
define( 'SECURE_AUTH_SALT', '=9jcqETZEtI]d%sJgJN$NDqOLM..Ti-).E49,tgW^8HUl]a/~NPVr{LT1*3tpUMV' );
define( 'LOGGED_IN_SALT',   'y+WHY9Qj6aEum?~Fmac#/%2FSZU~?)m{&jV{cx3G=zQy+)EMS^bq%U?<|u.m 8dp' );
define( 'NONCE_SALT',       'pB e.mfxz7,VLI;mj8iI_h!M9;@+,fo+p/#F9EBf]0,XXLDpw;gsKQr.@} Hlhi`' );

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
