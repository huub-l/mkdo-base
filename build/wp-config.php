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

/**
 * Don't edit this file directly, instead, create a local-config.php file and add your database
 * settings and defines in there. This file contains the production settings
 */
if ( file_exists( dirname( __FILE__ ) . '/local-config.php' ) ) {
	require_once dirname( __FILE__ ) . '/local-config.php';
}

/**
 * Production settings.
 */
defined( 'DB_NAME' ) || define( 'DB_NAME', '' );
defined( 'DB_USER' ) || define( 'DB_USER', '' );
defined( 'DB_PASSWORD' ) || define( 'DB_PASSWORD', '' );
defined( 'DB_HOST' ) || define( 'DB_HOST', '' );
defined( 'DB_CHARSET' ) || define( 'DB_CHARSET', 'utf8' );
defined( 'DB_COLLATE' ) || define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * If you have run the `composer create-project` command these salts should be automatically generated for you in a file called build/salt.php
 *
 * @since 2.6.0
 */
if ( file_exists( __DIR__ . '/salt.php' ) ) {
	require __DIR__ . '/salt.php';
} else {
	define( 'AUTH_KEY', '' );
	define( 'SECURE_AUTH_KEY', '' );
	define( 'LOGGED_IN_KEY', '' );
	define( 'NONCE_KEY', '' );
	define( 'AUTH_SALT', '' );
	define( 'SECURE_AUTH_SALT', '' );
	define( 'LOGGED_IN_SALT', '' );
	define( 'NONCE_SALT', '' );
}

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-wp-content/languages. For example, install
 * de_DE.mo to wp-wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define( 'WPLANG', '' );

/**
 * Define Site URL: WordPress in a subdirectory.
 */
defined( 'WP_SITEURL' ) || define( 'WP_SITEURL', 'https://my-project.test/wordpress' );
defined( 'WP_HOME' ) || define( 'WP_HOME', 'https://my-project.test' );

/**
 * Define path and url for wp-content.
 */
define( 'WP_CONTENT_DIR', dirname( __FILE__ ) . '/wp-content' );
define( 'WP_CONTENT_URL', WP_HOME . '/wp-content' );

/**
 * Define path and url for must use plugins.
 */
define( 'WPMU_PLUGIN_DIR', dirname( __FILE__ ) . '/wp-content/mu-plugins' );
define( 'WPMU_PLUGIN_URL', WP_HOME . '/wp-content/mu-plugins' );

/**
 * Define the default theme.
 */
define( 'WP_DEFAULT_THEME', 'my-project' );

/**
 * Prevent editing of files through the admin.
 */
define( 'DISALLOW_FILE_EDIT', true );

/* That's all, stop editing! Happy blogging. */

// GForms Key.
define( 'GF_LICENSE_KEY', '2875c979d155b8a8868f5db398292747' );

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' ); }

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
