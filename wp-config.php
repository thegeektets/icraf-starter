<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link https://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'starter');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

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
define('AUTH_KEY',         'M<?/yh=q(pS34>h-hw;a!])^n&S16`].A!l*jWE6* Tky+N/%Zab8ay8g++Mz<,S');
define('SECURE_AUTH_KEY',  'EKK|--RGs8[O?3oNzAIvk^W_QY;!`K5q<P]H@UiZj8Gt&X{Zn-vP+!C_TP6q9#H!');
define('LOGGED_IN_KEY',    'PGGI0qyBzwDV<)pw$@{|tTN]i.rDwp6VKH-+-Dl-`;8K(=dJ; ICN=(y!,FQDUt~');
define('NONCE_KEY',        'KI`U.yQ[kmST~P1vA1Sa^`87*`_>vyTY<-1c/LROecFOZ*7m#FjqEuvX_i;gD+|C');
define('AUTH_SALT',        'Ne1:KU|kk[K[A/J0E2|d^@+M+ SpTu:F>Do7X042:/][c?#ZoHtE0$p=#Xlr%}aU');
define('SECURE_AUTH_SALT', 'sT)%4vnI--|o*IOU=Q7I)%by<XCx-L=D9Qc+MoMafSWn9EyD@I--rg++$-|:jKY2');
define('LOGGED_IN_SALT',   'flhMJD?oLfpI*kQaWjv4*V*o;=Vl>j|(ujfGS7a1CKpj=|hN(S,9(T|[J8.a9W[:');
define('NONCE_SALT',       ': ZqK~ie5pS7`Y:DHe<4&}|j Nbp9Gta#qiN8o:-z=b<K[+n~gKfANuLu)~5uid-');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
