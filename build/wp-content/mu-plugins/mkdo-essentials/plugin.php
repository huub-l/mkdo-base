<?php
/**
 * MKDO Essentials
 *
 * @package           MKDO\Essentials
 *
 * Plugin Name:       MKDO Essentials
 * Description:       Essential re-usable features to support the project.
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

add_action(
	'plugins_loaded',
	function() {

		$options = get_option( PREFIX . '_settings' );

		foreach ( glob( ROOT_DIR . '/inc/features/*.php' ) as $filename ) {
			// NOTE: We are not invoking setup() here because we cannot
			// use dynamic namespaces.
			//
			// Each imported feature should just contain the relevant hook
			// and filter calls without any kind of wrapper function that
			// we would normally use to initialise them.
			require_once $filename;
		}
	}
);

add_action(
	'admin_init',
	function() {

		require_once ROOT_DIR . '/inc/settings.php';
		Settings\register_settings_page();
		Settings\save_settings_options();
	}
);

add_action(
	'admin_menu',
	function() {

		require_once ROOT_DIR . '/inc/settings.php';
		Settings\register_settings_menu();
	}
);

load_plugin_textdomain( 'mkdo-essentials', false, ROOT_DIR . '\languages' );
