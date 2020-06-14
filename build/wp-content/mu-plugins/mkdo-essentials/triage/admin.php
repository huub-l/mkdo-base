<?php
/**
 * Remove dashboard widgets
 *
 * @see http://www.wpbeginner.com/wp-tutorials/how-to-remove-wordpress-dashboard-widgets/
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Functions to remove the dashbaord widgets.
 */
class Dashboard_Widgets {

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {

		// Settings check.
		$do_run = apply_filters( MKDO_CORE_PREFIX . '_remove_widgets', true );
		if ( ! $do_run ) {
			return;
		}

		add_action( 'wp_dashboard_setup', array( $this, 'mkdo_core_remove_dashboard_widgets' ), 99 );
	}

	/**
	 * Remove dashbaord widgets.
	 */
	public function mkdo_core_remove_dashboard_widgets() {
		global $wp_meta_boxes;

		// Welcome Panel.
		remove_action( 'welcome_panel', 'wp_welcome_panel' );

		// Normal Widgets.
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts'] );
		unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
		unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );

		/**
		 * Additional
		 *
		 * We could also unset the 'right now' panel.
		 * `unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );`
		 */

		// WP Engine Widgets.
		unset( $wp_meta_boxes['dashboard']['normal']['core']['wpe_dify_news_feed'] );
	}
}

<?php
/**
 * Remove Comments
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Functionality to remove comments.
 */
class Comments {

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {

		// Settings check.
		$do_run = apply_filters( MKDO_CORE_PREFIX . '_disable_comments', true );
		if ( ! $do_run ) {
			return;
		}

		add_action( 'after_setup_theme', array( $this, 'mkdo_core_disable_all_comments_and_pings' ) );
		add_action( 'admin_menu', array( $this, 'mkdo_core_remove_comments_menu_item' ) );
		add_action( 'admin_menu', array( $this, 'remove_meta_boxes' ) );
	}

	/**
	 * Disable comments.
	 */
	public function mkdo_core_disable_all_comments_and_pings() {

		// Turn off comments.
		if ( '' !== get_option( 'default_ping_status' ) ) {
			update_option( 'default_ping_status', '' );
		}

		// Turn off pings.
		if ( '' !== get_option( 'default_comment_status' ) ) {
			update_option( 'default_comment_status', '' );
		}

	}

	/**
	 * Hide the comments menu item.
	 */
	public function mkdo_core_remove_comments_menu_item() {
		remove_menu_page( 'edit-comments.php' );
	}

	/**
	 * Remove comment meta boxes.
	 */
	public function remove_meta_boxes() {

		$post_types = get_post_types();

		foreach ( $post_types as $post_type ) {
			remove_meta_box( 'commentstatusdiv', $post_type, 'normal' );
			remove_meta_box( 'commentsdiv', $post_type, 'normal' );
		}
	}
}

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

