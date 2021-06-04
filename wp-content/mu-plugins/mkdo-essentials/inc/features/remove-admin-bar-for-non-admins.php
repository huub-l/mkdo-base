<?php
/**
 * Remove Admin Bar For Non Admins.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Remove_Admin_Bar_For_Non_Admins;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( ! empty( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Prevent non-administrators from viewing the admin bar.
 *
 * @return void
 */
function remove_admin_bar() : void {

	$hide_menu            = true;
	$user                 = wp_get_current_user();
	$permitted_user_roles = [ 'administrator' ];

	foreach ( (array) $permitted_user_roles as $user_role ) {
		if ( ! in_array( $user_role, (array) $user->roles, true ) && ! is_admin() ) {
			$hide_menu = false;
		}
	}

	if ( $hide_menu ) {
		// @codingStandardsIgnoreStart
		show_admin_bar( false );
		// @codingStandardsIgnoreEnd
	}
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\remove_admin_bar' );
