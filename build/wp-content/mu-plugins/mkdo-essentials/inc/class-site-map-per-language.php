<?php
/**
 * Yoast WPML Sitemap Per Trainslation
 *
 * @since 1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * If using WPML and Yoast SEO, create a sitemap per translation.
 */
class Site_Map_Per_Language {

	/**
	 * Go.
	 *
	 * @since 1.0.0
	 */
	public function run() {
		add_filter( 'wpseo_posts_join', array( $this, 'mkdo_core_yoast_wpml_sitemap_per_translation' ), 10, 2 );
	}

	/**
	 * Yoast SEO Posts Join
	 *
	 * Create a sitemap per page in WPML.
	 *
	 * @param  mixed  $join false or a join string.
	 * @param  string $type Post Type.
	 * @return mixed        false or a join string
	 */
	public function mkdo_core_yoast_wpml_sitemap_per_translation( $join, $type ) {
		global $wpdb, $sitepress;
		if ( isset( $sitepress ) ) {
			$lang = $sitepress->get_current_language();
			return ' JOIN ' . $wpdb->prefix . "icl_translations ON element_id = ID AND element_type = 'post_$type' AND language_code = '$lang'";
		}
		return $join;
	}
}
