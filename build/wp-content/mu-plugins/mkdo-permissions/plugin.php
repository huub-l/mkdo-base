<?php
/**
 * MKDO Core - Permissions
 *
 * @package           MKDO_Core_Permissions
 *
 * Plugin Name:       MKDO Permissions
 * Description:       A micro plugin to control user file edit permissions
 * Version:           1.0.0
 * Author:            Gemma Plank <gemma@makedo.net>
 * Author URI:        https://makedo.net
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       mkdo-permissions
 * Domain Path:       /languages
 */

/**
 * Abort on Direct Call
 *
 * Abort if this file is called directly.
 */
if ( ! defined( 'WPINC' ) ) {
	die;
}

// @codingStandardsIgnoreStart
if ( ! empty( $_SERVER['HTTP_HOST'] ) && $_SERVER['REQUEST_URI'] ) {
	$url = ( isset( $_SERVER['HTTPS'] ) ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$parsed_url = wp_parse_url( $url );
	$url_chunks = explode( '.', $parsed_url['host'] );
	$tld = end( $url_chunks );
} else {
	$tld = 'test';
}
// @codingStandardsIgnoreEnd

/**
 * Constants.
 */
define( 'MKDO_CORE_PERMISSIONS_ROOT', __FILE__ );
define( 'MKDO_CORE_PERMISSIONS_NAME', 'MKDO Core' );
define( 'MKDO_CORE_PERMISSIONS_SLUG', 'mkdo-core' );
define( 'MKDO_CORE_PERMISSIONS_PREFIX', 'mkdo_core' );
define( 'MKDO_CORE_PERMISSIONS_TLD', $tld );
define( 'MKDO_CORE_PERMISSIONS_IS_LOCKOUT_GLOBAL', false );
define( 'MKDO_CORE_PERMISSIONS_MIN_PHP_VERSION', '7.2' );

/**
 * PHP Version Check
 *
 * Exit and display error if minium version of PHP is not met.
 *
 * Do this now before we start calling classes and namespaces, as the user may
 * be using a version of PHP that does not support those features.
 */
if ( version_compare( phpversion(), MKDO_CORE_PERMISSIONS_MIN_PHP_VERSION, '<' ) ) {
	$mkdo_core_php_version_notice = sprintf(
		/* translators: 1: PHP version 2: plugin name */
		__( 'Your web-server is running an un-supported version of PHP. Please upgrade to version %1$s  or higher to avoid potential issues with %2$s and other WordPress plugins.', 'mkdo-core' ),
		MKDO_CORE_PERMISSIONS_MIN_PHP_VERSION,
		MKDO_CORE_PERMISSIONS_NAME
	);
	wp_die( esc_html( $mkdo_core_php_version_notice ) );
}

/**
 * Security Constants
 *
 * WordPress lets people do things that they should never do in a controlled
 * environment. Lets fix that.
 */
require_once 'php/class-customizer.php';
require_once 'php/class-disallow-file-mods.php';

/**
 * Namespaces (Comment out as appropriate).
 */
// Generic.
use MKDO_Core_Permissions\Customizer;
use MKDO_Core_Permissions\Disallow_File_Mods;

/**
 * Instances (Comment out as appropriate).
 */
$mkdo_core_customizer    = new Customizer();
$mkdo_core_disallow_mods = new Disallow_File_Mods();

/**
 * Textdomain.
 *
 * First parameter must be a string, not a constant.
 */
load_plugin_textdomain(
	'mkdo-permissions',
	false,
	MKDO_CORE_PERMISSIONS_ROOT . '/languages'
);

/**
 * Unleash Hell  (Comment out as appropriate).
 *
 * No need for a main controller; just run all the things.
 */
$mkdo_core_customizer->run();
$mkdo_core_disallow_mods->run();
