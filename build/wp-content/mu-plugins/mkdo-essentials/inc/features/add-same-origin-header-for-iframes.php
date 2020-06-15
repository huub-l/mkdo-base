<?php
/**
 * Add Same Origin Header for Iframes.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Add_Same_Origin_Header_For_Iframes;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( isset( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Send Headers
 */
function add_same_origin_header_for_iframes() {
	header( 'X-FRAME-OPTIONS: SAMEORIGIN' );
}
add_action( 'send_headers', __NAMESPACE__ . 'add_same_origin_header_for_iframes', 10, 1 );
