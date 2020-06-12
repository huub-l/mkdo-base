<?php
/**
 * Allow_Svg
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

// Abort if this file is called directly.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Class Allow_Svg.
 *
 * Runs when the plugin is activated.
 */
class Allow_Svg {

	/**
	 * Run all of the plugin functions.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		add_filter( 'upload_mimes', array( $this, 'cc_mime_types' ) );
		add_filter( 'wp_check_filetype_and_ext', array( $this, 'allow_svg' ), 10, 4 );
		add_action( 'wp_ajax_svg_get_attachment_url', array( $this, 'get_attachment_url_media_library' ), 10 );
	}

	/** // @codingStandardsIgnoreLine
	 * Allow SVG MIME type.
	 */
	public function cc_mime_types( $mimes ) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}

	/** // @codingStandardsIgnoreLine
	 * Allow SVG's.
	 */
	public function allow_svg( $data, $file, $filename, $mimes ) {
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

	/**
	 * Ajax get_attachment_url_media_library
	 */
	public function get_attachment_url_media_library() {
		$url           = '';
		$attachment_id = isset( $_REQUEST['attachment_id'] ) ? $_REQUEST['attachment_id'] : ''; // @codingStandardsIgnoreLine
		if ( $attachment_id ) {
			$url = wp_get_attachment_url( $attachment_id );
		}
		echo esc_url( $url );
		die();
	}
}
