<?php
/**
 * Prevent Multiple User Login Instances.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Prevent_Multiple_User_Login_Instances;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( isset( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Only allow one user to be logged on at a time.
 */
function prevent_multiple_user_login_instances() {
	global $mkdo_core_sessions;

	// Only allow one user to be logged in at a time.
	$mkdo_core_sessions = \WP_Session_Tokens::get_instance( get_current_user_id() );
	$mkdo_core_sessions->destroy_others( wp_get_session_token() );
}
add_action( 'setup_theme', __NAMESPACE__ . 'prevent_multiple_user_login_instances', 0 );
