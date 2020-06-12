<?php
/**
 * WPML Set Content Language
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Set the server content language header.
 */
class Content_Language {

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		add_filter( 'wp_headers', array( $this, 'mkdo_core_wpml_set_content_language' ), 0 );
	}

	/**
	 * HTTP Headers
	 *
	 * @param array $headers The HTTP Headers.
	 * @return array         The modified HTTP Headers
	 */
	public function mkdo_core_wpml_set_content_language( $headers ) {

		if ( ! is_admin() && defined( 'ICL_LANGUAGE_CODE' ) ) {
			$headers['Content-Language'] = ICL_LANGUAGE_CODE;
		}

		return $headers;
	}
}
