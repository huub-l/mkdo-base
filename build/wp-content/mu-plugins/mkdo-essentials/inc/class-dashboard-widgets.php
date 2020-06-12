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
