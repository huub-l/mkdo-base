<?php
/**
 * Remove Dashboard Widgets
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Remove_Dashboard_Widgets;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( ! empty( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Remove dashboard widgets.
 *
 * @return void
 */
function remove_dashboard_widgets() : void {

	global $wp_meta_boxes;

	// Welcome Panel.
	remove_action( 'welcome_panel', 'wp_welcome_panel' );

	// Normal Widgets.
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary'] );
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );

	// WP Engine Widgets.
	unset( $wp_meta_boxes['dashboard']['normal']['core']['wpe_dify_news_feed'] );
}
add_action( 'wp_dashboard_setup', __NAMESPACE__ . '\\remove_dashboard_widgets', 99 );
