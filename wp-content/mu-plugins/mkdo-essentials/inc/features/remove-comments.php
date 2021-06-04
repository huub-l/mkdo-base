<?php
/**
 * Remove Comments.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Remove_Comments;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( ! empty( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Disable comments.
 *
 * @return void
 */
function disable_all_comments_and_pings() : void {

	// Turn off comments.
	if ( '' !== get_option( 'default_ping_status' ) ) {
		update_option( 'default_ping_status', '' );
	}

	// Turn off pings.
	if ( '' !== get_option( 'default_comment_status' ) ) {
		update_option( 'default_comment_status', '' );
	}
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\\disable_all_comments_and_pings' );

/**
 * Hide the comments menu item.
 *
 * @return void
 */
function remove_comments_menu_item() : void {
	remove_menu_page( 'edit-comments.php' );
}
add_action( 'admin_menu', __NAMESPACE__ . '\\remove_comments_menu_item' );

/**
 * Remove comment meta boxes.
 *
 * @return void
 */
function remove_meta_boxes() : void {

	$post_types = get_post_types();

	foreach ( $post_types as $post_type ) {
		remove_meta_box( 'commentstatusdiv', $post_type, 'normal' );
		remove_meta_box( 'commentsdiv', $post_type, 'normal' );
	}
}
add_action( 'admin_menu', __NAMESPACE__ . '\\remove_meta_boxes' );
