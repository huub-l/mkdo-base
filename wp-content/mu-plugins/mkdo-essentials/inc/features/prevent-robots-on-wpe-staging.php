<?php
/**
 * Prevent Robots on WPE Staging.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Prevent_Robots_On_WPE_Staging;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( ! empty( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Override robots.txt setting on save
 *
 * Dont allow the staging site to have robots.txt enabled.
 *
 * @return string;
 */
function prevent_robots_on_wpe_staging() : string {

	$allow_robots = '1';

	// @codingStandardsIgnoreStart
	if ( strpos( $_SERVER['HTTP_HOST'], '.staging' ) !== false ) { // @codingStandardsIgnoreEnd
		$allow_robots = '0';
	}

	return $allow_robots;
}
add_filter( 'pre_option_blog_public', __NAMESPACE__ . '\\prevent_robots_on_wpe_staging' );
