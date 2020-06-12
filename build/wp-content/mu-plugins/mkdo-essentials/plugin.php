<?php
/**
 * MKDO Essentials
 *
 * @package           MKDO\Essentials
 *
 * Plugin Name:       MKDO Essentials
 * Description:       Essential features to support the project.
 * Version:           1.0.0
 * Author:            Make Do <hello@makedo.net>
 * Author URI:        https://makedo.net
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       mkdo-essentials
 * Domain Path:       /languages
 */

namespace MKDO\Essentials;

if ( ! defined( 'WPINC' ) ) {
	die;
}

const ROOT_DIR = __DIR__;
const PREFIX   = 'mkdo_essentials';

require_once ROOT_DIR . '/inc/accessibility.php';
require_once ROOT_DIR . '/inc/admin.php';
require_once ROOT_DIR . '/inc/content.php';
require_once ROOT_DIR . '/inc/languages.php';
require_once ROOT_DIR . '/inc/security.php';
require_once ROOT_DIR . '/inc/media.php';
require_once ROOT_DIR . '/inc/seo.php';
require_once ROOT_DIR . '/inc/server.php';
require_once ROOT_DIR . '/inc/users.php';

load_plugin_textdomain( 'mkdo-essentials', false, ROOT_DIR . '\languages' );

add_action( 'plugins_loaded', __NAMESPACE__ . '\\Accessibility\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\Admin\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\Content\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\Language\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\Media\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\Security\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\SEO\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\Server\setup' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\User\setup' );
