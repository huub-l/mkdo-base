<?php
/**
 * Custom Post Types.
 *
 * @package MKDO\Data_Model
 */

namespace MKDO\Data_Model\Post_Types;

use const MKDO\Data_Model\ROOT_DIR;

/**
 * Setup.
 */
function setup() : void {
	// This MUST fire at a EARLIER priority than taxonomy registrations.
	add_action( 'init', __NAMESPACE__ . '\\register_custom_post_types', 10 );
}

/**
 * Register custom post types.
 */
function register_custom_post_types() : void {
	// Automatically require any partials found in the /post-types/ directory
	// that begin with `cpt-` in the filename.
	foreach ( glob( dirname( ROOT_DIR ) . '/inc/post-types/cpt-*.php' ) as $filename ) {
		require_once $filename;
	}
}
