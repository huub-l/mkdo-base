<?php
/**
 * MKDO Core
 *
 * @package           MKDO_Core
 *
 * Plugin Name:       MKDO Core
 * Description:       A brief description of the plugin.
 * Version:           1.0.0
 * Author:            Make Do <hello@makedo.net>
 * Author URI:        https://makedo.net
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       mkdo-core
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
define( 'MKDO_CORE_ROOT', __FILE__ );
define( 'MKDO_CORE_NAME', 'MKDO Core' );
define( 'MKDO_CORE_SLUG', 'mkdo-core' );
define( 'MKDO_CORE_PREFIX', 'mkdo_core' );
define( 'MKDO_CORE_TLD', $tld );
define( 'MKDO_CORE_IS_LOCKOUT_GLOBAL', false );
define( 'MKDO_CORE_MIN_PHP_VERSION', '7.2' );

/**
 * PHP Version Check
 *
 * Exit and display error if minium version of PHP is not met.
 *
 * Do this now before we start calling classes and namespaces, as the user may
 * be using a version of PHP that does not support those features.
 */
if ( version_compare( phpversion(), MKDO_CORE_MIN_PHP_VERSION, '<' ) ) {
	$mkdo_core_php_version_notice = sprintf(
		/* translators: 1: PHP version 2: plugin name */
		__( 'Your web-server is running an un-supported version of PHP. Please upgrade to version %1$s  or higher to avoid potential issues with %2$s and other WordPress plugins.', 'mkdo-core' ),
		MKDO_CORE_MIN_PHP_VERSION,
		MKDO_CORE_NAME
	);
	wp_die( esc_html( $mkdo_core_php_version_notice ) );
}

/**
 * Security Constants
 *
 * WordPress lets people do things that they should never do in a controlled
 * environment. Lets fix that.
 */
require_once 'php/mkdo-core/security/const-disallow-file-edit.php'; // Disallow file edit.
require_once 'php/mkdo-core/security/const-disallow-file-mods.php'; // Disallow file installs unless on .test domain.

/**
 * Classes (Comment out as appropriate).
 */
// Generic.
require_once 'php/mkdo-core/comments/class-comments.php';
require_once 'php/mkdo-core/dashboard/class-dashboard-widgets.php';
require_once 'php/mkdo-core/hosting/class-hosting.php';
require_once 'php/mkdo-core/content/class-post-content-clean.php';
require_once 'php/mkdo-core/emoji/class-emoji.php';
require_once 'php/mkdo-core/post-formats/class-post-formats.php';
require_once 'php/mkdo-core/formatting/class-body-classes.php';
require_once 'php/mkdo-core/formatting/class-iframes.php';
require_once 'php/mkdo-core/security/class-limit-login-attempts.php';
require_once 'php/mkdo-core/security/class-login-one-user-instance.php';
require_once 'php/mkdo-core/security/class-x-frame-options.php';
require_once 'php/mkdo-core/seo/class-bing-header.php';
require_once 'php/mkdo-core/seo/class-content-language.php';
require_once 'php/mkdo-core/seo/class-site-map-links.php';
require_once 'php/mkdo-core/seo/class-site-map-per-language.php';
require_once 'php/mkdo-core/user/class-admin-bar.php';

// Specific.
require_once 'php/class-customizer.php';
require_once 'php/class-helpers.php';
require_once 'php/class-meta.php';
require_once 'php/class-post-types.php';
require_once 'php/class-settings.php';
require_once 'php/class-shortcodes.php';
require_once 'php/class-taxonomies.php';
require_once 'php/class-allow-svg.php';

/**
 * Namespaces (Comment out as appropriate).
 */
// Generic.
use MKDO_Core\Comments;
use MKDO_Core\Dashboard_Widgets;
use MKDO_Core\Hosting;
use MKDO_Core\Post_Content_Clean;
use MKDO_Core\Emoji;
use MKDO_Core\Post_Formats;
use MKDO_Core\Body_Classes;
use MKDO_Core\IFrames;
use MKDO_Core\Limit_Login_Attempts;
use MKDO_Core\Login_One_User_Instance;
use MKDO_Core\X_Frame_Options;
use MKDO_Core\Bing_Header;
use MKDO_Core\Content_Language;
use MKDO_Core\Site_Map_Links;
use MKDO_Core\Site_Map_Per_Language;
use MKDO_Core\Admin_Bar;

// Specific.
use MKDO_Core\Customizer;
use MKDO_Core\Helpers;
use MKDO_Core\Meta;
use MKDO_Core\Post_Types;
use MKDO_Core\Settings;
use MKDO_Core\Shortcodes;
use MKDO_Core\Taxonomies;
use MKDO_Core\Allow_Svg;

/**
 * Instances (Comment out as appropriate).
 */
// Generic.
$mkdo_core_comments                = new Comments();
$mkdo_core_dashboard_widgets       = new Dashboard_Widgets();
$mkdo_core_hosting                 = new Hosting();
$mkdo_core_post_content_clean      = new Post_Content_Clean();
$mkdo_core_emoji                   = new Emoji();
$mkdo_core_post_formats            = new Post_Formats();
$mkdo_core_body_classes            = new Body_Classes();
$mkdo_core_iframes                 = new IFrames();
$mkdo_core_limit_login_attempts    = new Limit_Login_Attempts();
$mkdo_core_login_one_user_instance = new Login_One_User_Instance();
$mkdo_core_x_frame_options         = new X_Frame_Options();
$mkdo_core_bing_header             = new Bing_Header();
$mkdo_core_content_language        = new Content_Language();
$mkdo_core_site_map_links          = new Site_Map_Links();
$mkdo_core_site_map_per_language   = new Site_Map_Per_Language();
$mkdo_core_admin_bar               = new Admin_Bar();

// Specific.
$mkdo_core_customizer = new Customizer();
$mkdo_core_meta       = new Meta();
$mkdo_core_post_types = new Post_Types();
$mkdo_core_settings   = new Settings();
$mkdo_core_shortcodes = new Shortcodes();
$mkdo_core_taxonomies = new Taxonomies();
$mkdo_core_allow_svg  = new Allow_Svg();

/**
 * Textdomain.
 *
 * First parameter must be a string, not a constant.
 */
load_plugin_textdomain(
	'mkdo-core',
	false,
	MKDO_CORE_ROOT . '/languages'
);

/**
 * Unleash Hell  (Comment out as appropriate).
 *
 * No need for a main controller; just run all the things.
 */
// Generic.
$mkdo_core_comments->run();
$mkdo_core_dashboard_widgets->run();
$mkdo_core_hosting->run();
$mkdo_core_post_content_clean->run();
$mkdo_core_emoji->run();
$mkdo_core_post_formats->run();
$mkdo_core_body_classes->run();
$mkdo_core_iframes->run();
$mkdo_core_limit_login_attempts->run();
$mkdo_core_login_one_user_instance->run();
$mkdo_core_x_frame_options->run();
$mkdo_core_bing_header->run();
$mkdo_core_content_language->run();
$mkdo_core_site_map_links->run();
$mkdo_core_site_map_per_language->run();
$mkdo_core_admin_bar->run();

// Specific.
$mkdo_core_customizer->run();
$mkdo_core_meta->run();
$mkdo_core_post_types->run();
$mkdo_core_settings->run();
$mkdo_core_shortcodes->run();
$mkdo_core_taxonomies->run();
$mkdo_core_allow_svg->run();
