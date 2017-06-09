<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */
//define this in .htaccess or vhost
/** e.g.
 *
SetEnv APPLICATION_ENV "development"
*/

define('WP_CACHE', true);

$env = getenv('APPLICATION_ENV');
if(empty($env)) {
	define('ENVIRONMENT', 'development');
} else {
	define('ENVIRONMENT', $env);
}

define('VENDOR_PATH', dirname(__FILE__) . '/vendor');
define('TMP', dirname(__FILE__) . '/.tmp');
define('DISABLE_WP_CRON', true);

//speed up dashboard
//define('WP_HTTP_BLOCK_EXTERNAL', true);

/**
 * Automatic Url + Content Dir/Url Detection for Wordpress
 */
$pattern        = array('/', '\'');
$document_root  = rtrim(str_replace($pattern, '/', $_SERVER['DOCUMENT_ROOT']), '/');
$root_dir       = $document_root;
$wp_dir         = $document_root . '/wordpress';
$wp_content_dir = $document_root . '/wp-content';
$root_url       = substr_replace($root_dir, '', stripos($root_dir, $document_root), strlen($document_root));
$wp_url         = substr_replace($wp_dir, '', stripos($wp_dir, $document_root), strlen($document_root));
$wp_content_url = substr_replace($wp_content_dir, '', stripos($wp_content_dir, $document_root), strlen($document_root));

if(ENVIRONMENT == 'production') {
   define( 'FORCE_SSL_LOGIN', true );
   define( 'FORCE_SSL_ADMIN', true );
}

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
    $_SERVER['HTTPS'] = 'on';
}

$scheme         = (isset($_SERVER['HTTPS']) AND $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
$host           = rtrim($_SERVER['SERVER_NAME'], '/');
$port           = (isset($_SERVER['SERVER_PORT']) AND $_SERVER['SERVER_PORT'] != '80' AND $_SERVER['SERVER_PORT'] != '443') ? ':' . $_SERVER['SERVER_PORT'] : '';
$root_url       = $scheme . $host . $port . $root_url;
$wp_url         = $scheme . $host . $port . $wp_url;
$wp_content_url = $scheme . $host . $port . $wp_content_url;

define('SERVER_SCHEME', $scheme);
define('SERVER_HOSTNAME', $host);

define('WP_HOME', $root_url); //url to index.php
define('WP_SITEURL', $wp_url); //url to wordpress installation
define('WP_CONTENT_DIR', $wp_content_dir); //wp-content dir
define('WP_CONTENT_URL', $wp_content_url); //wp-content url

define('WP_POST_REVISIONS', 3);

//load configuration data into scope
require_once('config.php');
$app = Config::load();

//MYSQL and Memcached
global $slaves, $memcached_servers;

if (!empty($app['config']['database_slaves'])) {
    $slaves = $app['config']['database_slaves'];
}
$memcached_servers 			= $app['config']['memcached_servers'];


define('DB_NAME',     $app['config']['database_name']);
define('DB_USER',     $app['config']['database_user']);
define('DB_PASSWORD', $app['config']['database_pass']);
define('DB_HOST',     $app['config']['database_host']);
define('DB_CHARSET', 'utf8');
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

define('AUTH_KEY',         $app['config']['auth_key']);
define('SECURE_AUTH_KEY',  $app['config']['secure_auth_key']);
define('LOGGED_IN_KEY',    $app['config']['logged_in_key']);
define('NONCE_KEY',        $app['config']['nonce_key']);
define('AUTH_SALT',        $app['config']['auth_salt']);
define('SECURE_AUTH_SALT', $app['config']['secure_auth_salt']);
define('LOGGED_IN_SALT',   $app['config']['logged_in_salt']);
define('NONCE_SALT',       $app['config']['nonce_salt']);

//destroy config
unset($app);

/**#@-*/
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'av_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */

define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/community');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
