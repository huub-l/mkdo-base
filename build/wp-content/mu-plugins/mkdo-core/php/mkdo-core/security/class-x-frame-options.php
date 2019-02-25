<?php
/**
 * X Frame Options
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * X Frame Options
 *
 * Prevent site form being loaded in an iFrame.
 */
class X_Frame_Options {

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {}

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {

		// Settings check.
		$do_run = apply_filters( MKDO_CORE_PREFIX . '_x_frame_options_header', true );
		if ( ! $do_run ) {
			return;
		}

		add_action( 'send_headers', array( $this, 'send_headers' ), 10, 1 );
	}

	/**
	 * Send Headers
	 */
	public function send_headers() {
		header( 'X-FRAME-OPTIONS: SAMEORIGIN' );
	}
}
