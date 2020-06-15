<?php
/**
 * Add WPML Content Language Header
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Add_WPML_Content_Language_Header;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( isset( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * HTTP Headers
 *
 * @param array $headers The HTTP Headers.
 *
 * @return array         The modified HTTP Headers
 */
function add_wpml_content_language_header( $headers ) {

	if ( ! is_admin() && defined( '\ICL_LANGUAGE_CODE' ) ) {
		$headers['Content-Language'] = \ICL_LANGUAGE_CODE;
	}

	return $headers;
}
add_filter( 'wp_headers', __NAMESPACE__ . 'add_wpml_content_language_header', 0 );
