<?php
/**
 * Remove Emoji Support.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Remove_Emoji_Support;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( isset( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 *  Disable WP Emoji
 */
function disable_emoji() {

	// Remove emoji scripts.
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );

	// Remove emoji styles.
	remove_action( 'wp_print_styles', 'print_emoji_styles' );

	// Remove emoji from email.
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	// Remove emoji from feeds.
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

	// Remove TinyMCE emojis.
	add_filter( 'tiny_mce_plugins', __NAMESPACE__ . 'disable_emoji_tinymce' );
}
add_action( 'init', __NAMESPACE__ . 'disable_emoji' );

/**
 * Remove TinyMCE Emoji
 *
 * @param array $plugins Array of TinyMCE plugins.
 * @return array         The modified plugin array.
 */
function disable_emoji_tinymce( $plugins ) {

	// Make sure that the array is an array.
	if ( ! is_array( $plugins ) ) {
		$plugins = array();
	}

	// Remove the emoji plugin from the array.
	return array_diff( $plugins, array( 'wpemoji' ) );
}
