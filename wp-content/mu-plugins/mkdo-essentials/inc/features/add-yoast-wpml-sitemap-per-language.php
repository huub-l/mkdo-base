<?php
/**
 * Add Yoast WPML Sitemap Per Language.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Add_Yoast_WPML_Sitemap_Per_Language;

/**
 * Abort if the key in our options array exists;
 * this means the feature has been disabled.
 */
$base = strtolower( str_replace( '-', '_', basename( __FILE__, '.php' ) ) );

if ( ! empty( $options ) && array_key_exists( $base, $options ) ) {
	return;
}

/**
 * Filter URL entry before it gets added to the sitemap.
 *
 * We are using this to calculate the xhtml:link sitemap parts for later use
 *
 * @param array  $url  Array of URL parts.
 * @param string $type URL type.
 * @param object $post Post Object.
 * @return array       The modified URL parts
 */
function yoast_wpml_alternate_links_to_site_map_setup( $url, $type, $post ) : array {

	$url['id']   = 0;
	$url['type'] = 'post';

	if ( 'post' === $type ) {
		$url['id']   = $post->ID;
		$url['type'] = $post->post_type;
	} else {
		$url['id']   = $post->term_id;
		$url['type'] = $post->taxonomy;
	}

	// If the relevent WPML function exists.
	if ( function_exists( '\icl_object_id' ) ) {
		$url['wpml']               = array();
		$url['wpml']['xhtml:link'] = array();
		$langs                     = \icl_get_languages(); // Already checked WPML so assume this exists.

		// Loop through the site languages.
		foreach ( $langs as $lang ) {

			// Get the language ID.
			$id = \icl_object_id( $url['id'], $url['type'], false, $lang['code'] );

			// If there is a translation.
			if ( ! empty( $id ) ) {
				$url['wpml'][ $lang['code'] ]['id'] = \icl_object_id( $url['id'], $url['type'], false, $lang['code'] );

				if ( (int) $id === (int) $url['id'] ) {
					// If the translation is the current post.
					$url['wpml'][ $lang['code'] ]['current_lang'] = true;
				} else {

					$link = get_the_permalink( $id );

					if ( 'post' !== $type ) {
						$link = get_term_link( $id ); // WPCS: ok.
					}

					// The translation is an alternative, create the xhtml:link.
					$xhtml_link  = '<xhtml:link ';
					$xhtml_link .= 'rel="alternate" ' . "\n\t\t\t";
					$xhtml_link .= 'hreflang="' . $lang['code'] . '" ' . "\n\t\t\t";
					$xhtml_link .= 'href="' . $link . '" ' . "\n\t\t";
					$xhtml_link .= '/>';

					$url['wpml']['xhtml:link'][] = $xhtml_link;
				}
			}
		}
	}
	return $url;
}
add_filter( 'wpseo_sitemap_entry', __NAMESPACE__ . '\\yoast_wpml_alternate_links_to_site_map_setup', 100, 3 );

/**
 * Hook into the sitemap links
 *
 * We use the xhtml:link param we defined earlier to add this to the sitemap.
 *
 * @param string $output The sitemap URL.
 * @param array  $url    Array of URL parts.
 * @return string        The transformed sitemap URL
 */
function yoast_wpml_alternate_links_to_site_map( $output, $url ) : string {

	// If we have some xhtml:link's.
	if (
		isset( $url['wpml'] ) &&
		isset( $url['wpml']['xhtml:link'] ) &&
		is_array( $url['wpml']['xhtml:link'] ) &&
		! empty( $url['wpml']['xhtml:link'] )
	) {
		$insert = '';

		// Loop through the links and append them to the $insert string.
		foreach ( $url['wpml']['xhtml:link'] as $key => $xhtml_link ) {
			if ( 0 === $key ) {
				$insert .= "\t" . $xhtml_link;
			} else {
				$insert .= "\n\t\t" . $xhtml_link;
			}
		}

		// Replace the last part of the URL with the new links.
		$output = str_replace( '</url>', $insert . "\n\t" . '</url>', $output );
	}
	return $output;
}
add_filter( 'wpseo_sitemap_url', __NAMESPACE__ . '\\yoast_wpml_alternate_links_to_site_map', 100, 2 );

/**
 * Yoast SEO Posts Join
 *
 * Create a sitemap per page in WPML.
 *
 * @param  mixed  $join false or a join string.
 * @param  string $type Post Type.
 * @return mixed        false or a join string
 */
function yoast_wpml_sitemap_per_translation( $join, $type ) {

	global $wpdb, $sitepress;

	if ( isset( $sitepress ) ) {
		$lang = $sitepress->get_current_language();
		return ' JOIN ' . $wpdb->prefix . "icl_translations ON element_id = ID AND element_type = 'post_$type' AND language_code = '$lang'";
	}
	return $join;
}
add_filter( 'wpseo_posts_join', __NAMESPACE__ . '\\yoast_wpml_sitemap_per_translation', 10, 2 );
