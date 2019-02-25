<?php
/**
 * Body Classes
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Adds usful body classes to the body tag.
 */
class Body_Classes {

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {

		// Settings check.
		$do_run = apply_filters( MKDO_CORE_PREFIX . '_add_body_classes', true );
		if ( ! $do_run ) {
			return;
		}

		add_filter( 'body_class', array( $this, 'mkdo_core_body_classes' ) );

		add_filter( 'body_class', array( $this, 'browser_body_class' ) );
	}

	/**
	 * Adds custom classes to the array of body classes
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function mkdo_core_body_classes( $classes ) {
		global $post;

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds the slug if this is a single page.
		if ( is_singular() ) {
			$classes[] = 'slug-' . $post->post_name;
		}

		// Add the slug of the parent page if this is a single post/page.
		if ( is_singular() ) {

			// Get an array of Ancestors and Parents if they exist.
			$ancestors = get_post_ancestors( $post->ID );

			if ( ! empty( $ancestors ) ) {

				// Get the ID of the immediate parent and the farthest ancestor.
				$parent_id   = ( $ancestors ) ? $ancestors[0] : '';
				$ancestor_id = ( $ancestors ) ? $ancestors[ count( $ancestors ) - 1 ] : '';

				// Parent.
				$parent    = get_post( $parent_id );
				$classes[] = 'slug-parent-' . $parent->post_name;

				// Ancestor.
				if ( ! empty( $ancestor_id ) && $parent_id !== $ancestor_id ) {
					$ancestor  = get_post( $ancestor_id );
					$classes[] = 'slug-ancestor-' . $ancestor->post_name;
				}
			}
		}

		return $classes;
	}

	/**
	 * Adds browser/device classes to the array of body classes
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function browser_body_class( $classes ) {

		global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

		if ( $is_lynx ) {
			$classes[] = 'lynx';
		} elseif ( $is_gecko ) {
			$classes[] = 'gecko';
		} elseif ( $is_opera ) {
			$classes[] = 'opera';
		} elseif ( $is_NS4 ) {
			$classes[] = 'ns4';
		} elseif ( $is_safari ) {
			$classes[] = 'safari';
		} elseif ( $is_chrome ) {
			$classes[] = 'chrome';
		} elseif ( $is_IE ) {
			$classes[] = 'ie';
		} else {
			$classes[] = 'unknown';
		}

		if ( $is_iphone ) {
			$classes[] = 'iphone';
		}

		return $classes;
	}
}
