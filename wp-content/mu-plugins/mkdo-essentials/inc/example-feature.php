<?php
/**
 * Description Matching File Name.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Namespace_Matching_File_Name;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( isset( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Feature Hooks/Filters.
 *
 * NOTE: Remember to use the __NAMESPACE__ prefix with callbacks.
 */
