<?php
/**
 * Post Content Clean
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Automatically cleans up content on post save, to get rid of any non-html nasties.
 * Lovingly borrowed the idea from https://en-gb.wordpress.org/plugins/safe-paste/.
 */
class Post_Content_Clean {

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {

		// Settings check.
		$do_run = apply_filters( MKDO_CORE_PREFIX . '_clean_content', true );
		if ( ! $do_run ) {
			return;
		}

		add_filter( 'the_content', array( $this, 'mkdo_core_remove_empty_p' ), 20, 1 );
		add_filter( 'the_content', array( $this, 'mkdo_core_remove_image_ptags' ) );
	}

	/**
	 * Remove empty <p> tags.
	 *
	 * @see https://gist.github.com/Fantikerz/5557617
	 *
	 * @param  string $content Content to be cleaned.
	 * @return string
	 */
	public function mkdo_core_remove_empty_p( $content ) {
		$content = force_balance_tags( $content );
		$return  = preg_replace( '#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content );
		$return  = preg_replace( '~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $return );

		return $return;
	}

	/**
	 * Remove <p> tags around images.
	 *
	 * @param  string $content Content to be cleaned.
	 * @return string
	 */
	public function mkdo_core_remove_image_ptags( $content ) {
		return preg_replace( '/<p>\s*(<a .*>)?\s*(<img .* \/>|<iframe .*>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content );
	}
}
