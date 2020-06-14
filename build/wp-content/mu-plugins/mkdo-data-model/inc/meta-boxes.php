<?php
/**
 * Meta Class.
 *
 * @since   1.0.0
 *
 * @package MKDO\Data_Model
 */

namespace MKDO\Data_Model\Meta_Boxes;

use const MKDO\Data_Model\ROOT_DIR;
use const MKDO\Data_Model\PREFIX;

/**
 * Setup.
 */
function setup() {
	// Only scaffold the meta if CMB2 is available.
	if ( defined( 'CMB2_LOADED' ) ) {
		add_action( 'cmb2_admin_init', __NAMESPACE__ . '\\register_meta_boxes', 10 );
	}
}

/**
 * Register CMB2 meta fields.
 */
function register_meta_boxes() {
	// Automatically require any partials found in the /meta-boxes/ directory
	// that begin with `meta-` in the filename.
	foreach ( glob( ROOT_DIR . '/inc/meta-boxes/meta-*.php' ) as $filename ) {
		require_once $filename;
	}
}
