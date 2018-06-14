<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */


/*
require_once 'sentry-php-master/lib/Raven/Autoloader.php';
Raven_Autoloader::register();

$client = new Raven_Client('https://c93fa01f7351471e94ad3751522fa5a9:a11e19815d3d473897f9619ad49c8bff@app.getsentry.com/84100');

$error_handler = new Raven_ErrorHandler($client);
$error_handler->registerExceptionHandler();
$error_handler->registerErrorHandler();
$error_handler->registerShutdownFunction();
*/


// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wp_prod');

/** MySQL database username */
define('DB_USER', 'wp_admin');

/** MySQL database password */
define('DB_PASSWORD', 'X2J2o4tpUhiXE7oCNwbR');

/** MySQL hostname */
define('DB_HOST', 'mysqlproddb.its.bethel.edu');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

//define('WPCAS_BYPASS',true);
//define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true );
//define('LDAP_DEBUG_MODE', true);


/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */

define('AUTH_KEY',         'J&6)~fl!|1e$J#}SG+:Tkd98.X&ISBCv)3%0BVGwZ[2B7f$E--: -#&--FdL;@,X');
define('SECURE_AUTH_KEY',  '^B%oTVyKP%kg*&rd/D-c)%`Lh@>%d`1Y*yjk#bkS0.k-t|x85:xfLz_8Mw^m.{V!');
define('LOGGED_IN_KEY',    'Ae#B}Q+6q,Z7:h-_q_)@M5|b`}Y-.3tT{DqvG D(*o=ZHN[$Xb&Ip4sut3W/)36I');
define('NONCE_KEY',        'x)U[=NU5I!W10C0MR15cLX[~&?Zq<@)lKr1*?<;4%EYYn`~{&N}|Wq~+,e}n59`;');
define('AUTH_SALT',        'H`?w7#U4M0D/4T]cqbaD5i<li(4UH|huUbHqRe^+M<Q+uvJe0M?o+;Vjw`hLlJ%2');
define('SECURE_AUTH_SALT', 'BF!x&af5[kVtO]<et?:F7Tx|]L0XF7e&o|34vg7wL*k_ufD<|OeFZ`O!VQBhBT;H');
define('LOGGED_IN_SALT',   'V-cH-Og[N7ks+SY:.g8&xF2T.D5$#2ah%^&@]GF]#)U|1N%,/fY%-aX$lk=-Bcfo');
define('NONCE_SALT',       '_0[QsDVn3l.a8^8n+aoIbo-a;h*7w#[%Ne1y`(Q|p:)0LyPyX(9<?pP.c-4!cLsF');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'bthl_tbl_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
//define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

// START MULTISITE

#To enable the Network menu item, define multisite 
define('WP_ALLOW_MULTISITE', true);
define('WP_DEFAULT_THEME', 'bethel-responsive');

#Forces login to happen through a ssl connection
define('FORCE_SSL_LOGIN', false);

#Forces admin login and the admin panel to happen through ssl
define('FORCE_SSL_ADMIN', false);

#multi-site configuration
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', false );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'blogs.bethel.edu' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 ); 

// END MULTISITE

/* That's all, stop editing! Happy blogging. */


/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
