<?php
/**
 * Login One User Instance
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Only allow one instance of a user to be logged in at any one time.
 */
class Login_One_User_Instance {

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {

		// Settings check.
		$do_run = apply_filters( MKDO_CORE_PREFIX . '_limit_login_instances', true );
		if ( ! $do_run ) {
			return;
		}

		add_action( 'setup_theme', array( $this, 'mkdo_core_login_one_user_instance' ), 0 );
	}

	/**
	 * Only allow one user to be logged on at a time.
	 */
	public function mkdo_core_login_one_user_instance() {
		global $mkdo_core_sessions;

		// Only allow one user to be logged in at a time.
		$mkdo_core_sessions = \WP_Session_Tokens::get_instance( get_current_user_id() );
		$mkdo_core_sessions->destroy_others( wp_get_session_token() );
	}
}
