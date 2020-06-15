<?php
/**
 * Remove Site Health Menu.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Remove_Site_Health_Menu;

/**
 * Abort if a key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( isset( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Remove Dashboard Widgets.
 *
 * Hides the dashboard widget for 'Site Health'.
 *
 * @return void
 */
function remove_dashboard_widgets() : void {
	remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
}
add_action( 'admin_init', __NAMESPACE__ . '\\remove_dashboard_widgets' );

/**
 * Remove Submenus.
 *
 * Hides the submenu for 'Site Health'.
 *
 * @return void
 */
function remove_submenus() : void {
	remove_submenu_page( 'tools.php', 'site-health.php' );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\remove_submenus', 500 );
