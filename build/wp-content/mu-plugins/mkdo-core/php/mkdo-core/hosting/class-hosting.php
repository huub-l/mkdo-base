<?php
/**
 * Hosting - WP Engine
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Some specific WP Engine Overrides.
 */
class Hosting {

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {

		// Settings check.
		$do_run = apply_filters( MKDO_CORE_PREFIX . '_alter_hosting_menus', true );
		if ( ! $do_run ) {
			return;
		}

		add_action( 'admin_menu', array( $this, 'mkdo_core_change_wp_engine_name' ), 9999 );
		add_filter( 'pre_option_blog_public', array( $this, 'mkdo_core_override_robots_txt_save' ) );

		// Only run this action if the install is multisite.
		if ( is_multisite() ) {
			add_action( 'network_admin_menu', array( $this, 'mkdo_core_change_wp_engine_name' ), 9999 );
		}
	}

	/**
	 * Change the name of WP Engine in the menu.
	 *
	 * Also removes sub pages if the user isn't the one defined in the MKDO_CORE_PERMITTED_USERNAME
	 * constant.
	 */
	public function mkdo_core_change_wp_engine_name() {

		if ( is_admin() ) {
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

				// Get permitted user names.
				$user_names = apply_filters( MKDO_CORE_PREFIX . '_hosting_menu_permitted_user_names', array( 'makedo' ) );

				// Remove Sub Pages.
				if ( ! in_array( $user_name, (array) $user_names, true ) ) {
					remove_submenu_page( 'wpengine-common', 'wpe-user-portal' );
					remove_submenu_page( 'wpengine-common', 'wpe-support-portal' );
				}
			}
		}
	}

	/**
	 * Override robots.txt setting on save
	 *
	 * Dont allow the staging site to have robots.txt enabled.
	 */
	public function mkdo_core_override_robots_txt_save() {

		$allow_robots = '1';

		// @codingStandardsIgnoreStart
		if ( strpos( $_SERVER['HTTP_HOST'], '.staging' ) !== false ) { // @codingStandardsIgnoreEnd
			$allow_robots = '0';
		}

		return $allow_robots;
	}
}
