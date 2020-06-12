<?php
/**
 * Post Formats
 *
 * Functions relating to Post Formats
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Functions relating to Post Formats
 */
class Post_Formats {

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {

		// Settings check.
		$do_run = apply_filters( MKDO_CORE_PREFIX . '_remove_post_formats', true );
		if ( ! $do_run ) {
			return;
		}

		add_action( 'after_setup_theme', array( $this, 'mkdo_core_remove_post_formats' ), 100 );
	}

	/**
	 * Remove Post Formats
	 */
	public function mkdo_core_remove_post_formats() {
		remove_theme_support( 'post-formats' );
	}
}
