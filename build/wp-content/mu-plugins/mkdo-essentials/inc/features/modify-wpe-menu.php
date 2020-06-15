<?php
/**
 * Modify WPE Menu.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Modify_WPE_Menu;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( isset( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Change the name of WP Engine in the menu.
 *
 * Also removes sub pages if the user isn't the one defined in the MKDO_CORE_PERMITTED_USERNAME
 * constant.
 *
 * @return void
 */
function modify_wpe_menu() : void {

	if ( ! is_admin() ) {
		return;
	}

	global $menu, $submenu;

	// @codingStandardsIgnoreStart
	if ( strpos( $_SERVER['HTTP_HOST'], '.staging' ) !== false ) { // @codingStandardsIgnoreEnd
		remove_menu_page( 'wpengine-common' );
	} else {

		$current_user = wp_get_current_user();
		$user_name    = $current_user->user_login;

		// Change menu name and icon.
		if ( is_array( $menu ) ) {
			foreach ( $menu as &$m ) {
				if ( 'WP Engine' === $m[0] ) {
					$m[0] = 'Hosting';
					$m[6] = 'dashicons-admin-site';
				}
			}
		}

		// Change submenu name.
		if ( is_array( $submenu ) && isset( $submenu['wpengine-common'] ) ) {
			foreach ( $submenu['wpengine-common'] as &$m ) {
				if ( 'WP Engine' === $m[0] ) {
					$m[0] = 'Hosting';
				}
			}
		}

		// Permitted user names.
		$user_names = [ 'makedo' ];

		// Remove Sub Pages.
		if ( ! in_array( $user_name, (array) $user_names, true ) ) {
			remove_submenu_page( 'wpengine-common', 'wpe-user-portal' );
			remove_submenu_page( 'wpengine-common', 'wpe-support-portal' );
		}
	}
}
add_action( 'admin_menu', __NAMESPACE__ . 'modify_wpe_menu', 9999 );

// Only run this action if the install is multisite.
if ( is_multisite() ) {
	add_action( 'network_admin_menu', __NAMESPACE__ . 'modify_wpe_menu', 9999 );
}
