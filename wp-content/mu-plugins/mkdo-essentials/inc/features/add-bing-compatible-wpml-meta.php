<?php
/**
 * Add Bing Compatible WPML Meta.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Add_Bing_Compatible_WPML_Meta;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( ! empty( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Add Bing Compatible language links
 *
 * @return void
 */
function add_bing_compatible_wpml_meta() : void {

	global $post;

	if ( ! function_exists( '\icl_get_languages' ) ) {
		return;
	}

	$langs = \icl_get_languages();

	foreach ( $langs as $lang ) {

		// Get the language ID.
		$id = \icl_object_id( $post->ID, $post->post_type, false, $lang['code'] );

		// If there is a translation.
		if ( ! empty( $id ) && (int) $id === (int) $post->ID ) {
			echo '<meta http-equiv="content-language" content="' . esc_attr( $lang['code'] ) . '"/>' . "\n";
		}
	}
}
add_filter( 'wp_head', __NAMESPACE__ . '\\add_bing_compatible_wpml_meta', 0 );
