<?php
/**
 * Taxonomies Class.

 * @package MKDO\Data_Model
 */

namespace MKDO\Data_Model\Taxonomies;

use const MKDO\Data_Model\ROOT_DIR;

/**
 * Setup.
 */
function setup() : void {
	// This MUST fire at a later priority than custom post type registrations.
	add_action( 'init', __NAMESPACE__ . '\\register_taxonomies', 20 );
}

/**
 * Register custom taxonomies.
 */
function register_taxonomies() : void {
	// Automatically require any partials found in the /taxonomies/ directory
	// that begin with `tax-` in the filename.
	foreach ( glob( dirname( ROOT_DIR ) . '/inc/taxonomies/tax-*.php' ) as $filename ) {
		require_once $filename;
	}
}
