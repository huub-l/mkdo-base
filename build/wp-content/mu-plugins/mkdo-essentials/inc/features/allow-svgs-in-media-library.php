<?php
/**
 * Allow SVGs in Media Library
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Allow_SVGs_In_Media_Library;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( isset( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Allow SVG MIME type.
 *
 * @param array $mimes Array of mime types.
 */
function cc_mime_types( $mimes ) : array {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', __NAMESPACE__ . 'cc_mime_types' );

/**
 * Allow SVG files.
 *
 * @param array  $data     Array of file data.
 * @param string $file     Full path to the file.
 * @param string $filename The name of the file.
 * @param array  $mimes    An array of mime types.
 *
 * @return void|array
 */
function allow_svg( $data, $file, $filename, $mimes ) {

	global $wp_version;

	// Satisfy WPCS.
	$f = $file;

	if ( '4.7' === $wp_version || ( (float) $wp_version < 4.7 ) ) {
		return $data;
	}

	$filetype = wp_check_filetype( $filename, $mimes );

	return [
		'ext'             => $filetype['ext'],
		'type'            => $filetype['type'],
		'proper_filename' => $data['proper_filename'],
	];
}
add_filter( 'wp_check_filetype_and_ext', __NAMESPACE__ . 'allow_svg', 10, 4 );

/**
 * Ajax get_attachment_url_media_library
 *
 * @return void
 */
function get_attachment_url_media_library() : void {

	$url           = '';
	$attachment_id = isset( $_REQUEST['attachment_id'] ) ? $_REQUEST['attachment_id'] : ''; // @codingStandardsIgnoreLine

	if ( $attachment_id ) {
		$url = wp_get_attachment_url( $attachment_id );
	}

	echo esc_url( $url );

	die();
}
add_action( 'wp_ajax_svg_get_attachment_url', __NAMESPACE__ . 'get_attachment_url_media_library', 10 );
