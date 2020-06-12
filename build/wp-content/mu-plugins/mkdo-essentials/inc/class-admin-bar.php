<?php
/**
 * Remove Admin Bar
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Prevent certain users from viewing the admin bar.
 */
class Admin_Bar {

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {

		// Settings check.
		$do_run = apply_filters( MKDO_CORE_PREFIX . '_remove_admin_bar', false );
		if ( ! $do_run ) {
			return;
		}

		add_action( 'after_setup_theme', array( $this, 'mkdo_core_remove_admin_bar' ) );
	}

	/**
	 * Prevent non-administrators from viewing the admin bar.
	 */
	public function mkdo_core_remove_admin_bar() {

		$hide_menu            = true;
		$user                 = wp_get_current_user();
		$permitted_user_roles = apply_filters(
			MKDO_CORE_PREFIX . '_admin_bar_permitted_user_roles',
			array(
				'administrator',
			)
		);

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
}
