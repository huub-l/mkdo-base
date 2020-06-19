<?php
/**
 * Custom image functions for this theme.
 *
 * @package MKDO_Theme
 */

/**
 * Get SVGs
 *
 * @param string $slug   Slug name of the icon.
 * @param string $title  Optional title for screen readers.
 * @param bool   $return If set to true, SVG markup will return rather than echo.
 */
function mkdo_theme_get_svg( $slug, $title = '', $return = false ) {
	if ( empty( $slug ) ) {
		return;
	}

	foreach ( glob( get_stylesheet_directory() . '/assets/svgs/*.svg' ) as $file ) {

		$path_parts = pathinfo( $file );
		$file_slug  = $path_parts['filename'];

		if ( $file_slug === $slug ) {

			$text          = ( ! empty( $title ) ) ? $title : $file_slug;
			$old_svg       = file_get_contents( $file ); // @codingStandardsIgnoreLine
			$find_string   = '<svg';
			$str_to_insert = '<svg x="0px" y="0px" ';
			$pos           = strpos( $old_svg, $find_string );
			$new_svg       = str_replace( $find_string, $str_to_insert, $old_svg );

			// Replace the title text.
			$search    = '/<title[^>]*>.*?<\/title>/i';
			$new_title = '<title>' . $text . '</title>';

			if ( $return && true === $return ) {
				return preg_replace( $search, $new_title, $new_svg ); // phpcs:ignore WordPress.Security.EscapeOutput
			} else {
				echo preg_replace( $search, $new_title, $new_svg ); // phpcs:ignore WordPress.Security.EscapeOutput
			}
		}
	}
}

/**
 * Generate a responsive <picture> element.
 *
 * @param int    $img_id           Post ID of the image attachment.
 * @param array  $img_settings     Array of media query slugs and breakpoints.
 * @param string $default_img_size Slug name of the default size to be used.
 * @param bool   $retina_support   Whether to output markup that supports retina.
 */
function mkdo_theme_responsive_image( $img_id, $img_settings, $default_img_size = '', $retina_support = false ) {

	// If the ID is empty, return an error.
	if ( empty( $img_id ) ) {
		return;
	}

	// Handle a string being passed in.
	$img_id = intval( $img_id );

	// Is this a valid image?
	$status = get_post_status( $img_id );

	// If not, return an error.
	if ( empty( $status ) || empty( $img_settings ) ) {
		return;
	} else {

		// Get the alt tag.
		$img_alt = get_post_meta( $img_id, '_wp_attachment_image_alt', true );

		// Empty variable for the default image src.
		$default_img_src = '';

		// Build the srcset.
		//
		// We're expecting an array containing items
		// that hold the `size` and `breakpoint`
		// values for the name of the size and the
		// breakpoint, respectively.
		$srcsets = array();

		// Loop through the image settings.
		foreach ( $img_settings as $key => $setting ) {

			// Get the size and breakpoint.
			$img_size       = ( isset( $setting['size'] ) ) ? $setting['size'] : '';
			$img_breakpoint = ( isset( $setting['breakpoint'] ) ) ? $setting['breakpoint'] : '';

			// Check both values are valid.
			if ( ! empty( $img_size ) && ! empty( $img_breakpoint ) ) {

				// Get the standard image src.
				$img_src = wp_get_attachment_image_src( $img_id, $img_size );

				// If this is the first image in the array,
				// we'll use that as the default image.
				//
				// This can be overriden in the function
				// arguments.
				if ( 0 === $key ) {
					$default_img_src = $img_src[0];
				}

				// If retina support is enabled add the 2x image.
				if ( ! empty( $retina_support ) ) {

					// Try to get the retina image src.
					$retina_img_src = wp_get_attachment_image_src( $img_id, $img_size . '_2x' );

					// Carry out a check so that if the filename does not
					// contain -123x123 we do not include the 2x image below.
					// Add the info to the srcset array if
					// the retina size is available.
					if ( ! empty( $retina_img_src ) && 1 === preg_match( '/-\d\d\d[x]\d\d\d/', $retina_img_src[0] ) ) {
						$srcsets[] = array( $retina_img_src[0] . ' 2x', $img_breakpoint );
					}
				}

				// Add the standard 1x image.
				$srcsets[] = array( $img_src[0] . ' 1x', $img_breakpoint );
			}
		}

		// If the default image size has been passed in.
		if ( ! empty( $default_img_size ) ) {

			// Get the standard version of default image src.
			$default_img = wp_get_attachment_image_src( $img_id, $default_img_size );

			// Override the default default.
			if ( ! empty( $default_img ) ) {
				$default_img_src = $default_img[0];
			}
		}

		// Open.
		echo '<picture>';

		// Output each source.
		foreach ( $srcsets as $srcset ) {
			echo '<source srcset="' . esc_attr( $srcset[0] ) . '" media="(min-width: ' . esc_attr( $srcset[1] ) . ')" />';
		}

		// Output the image class and default src.
		echo '<img src="' . esc_url( $default_img_src ) . '"';

		// Output the alt tag.
		if ( ! empty( $img_alt ) ) {
			echo 'alt="' . esc_attr( $img_alt ) . '"';
		}

		// Close.
		echo '/></picture>';
	}
}

/**
 * Responsive background image attributes
 *
 * Example `$img_settings` array...
 *
 * ```php
 * $settings = array(
 *   array(
 *      'size' => 'featured-image-mobile',
 *      'breakpoint' => '480',
 *   ),
 *   array(
 *      'size' => 'featured-image-tablet',
 *      'breakpoint' => '768',
 *   ),
 *   array(
 *      'size' => 'featured-image-desktop',
 *      'breakpoint' => '1024',
 *   ),
 * );
 * ```
 *
 * @param int    $img_id           Post ID of the image attachment.
 * @param array  $img_settings     Array of image sizes and breakpoints.
 * @param string $default_img_size Slug name of the default size to be used.
 * @param string $retina_support   Whether to enable retina support.
 * @param bool   $return           Whether to return or echo the attributes.
 */
function mkdo_theme_responsive_bg_image_attrs( $img_id, $img_settings, $default_img_size, $retina_support = false, $return = true ) {

	// If the ID is empty, return an error.
	if ( empty( $img_id ) ) {
		return;
	}

	// Handle a string being passed in.
	$img_id = intval( $img_id );

	// Is this a valid image?
	$status = get_post_status( $img_id );

	// Only proceed if the image has a published status,
	// an array of settings and a default image size.
	if ( empty( $status ) || empty( $img_settings ) || empty( $default_img_size ) ) {
		return;
	} else {

		$data_attributes = '';

		// Loop through the image settings.
		foreach ( $img_settings as $key => $setting ) {

			// Get the size.
			$img_size       = ( isset( $setting['size'] ) ) ? $setting['size'] : '';
			$img_breakpoint = ( isset( $setting['breakpoint'] ) ) ? $setting['breakpoint'] : '';

			// Check both values are valid.
			if ( ! empty( $img_size ) && ! empty( $img_breakpoint ) ) {

				$img_src = wp_get_attachment_image_src( $img_id, $img_size );
				$img_url = ( ! empty( $img_src ) ) ? $img_src[0] : '';

				if ( ! empty( $img_url ) ) {
					$data_attributes .= 'data-bg-' . esc_attr( $img_breakpoint ) . '="' . esc_url( $img_url ) . '" '; // Must be a space at the end!.
				}

				// If retina support is enabled.
				if ( ! empty( $retina_support ) ) {
					// Try to get the retina image src.
					$retina_img_src = wp_get_attachment_image_src( $img_id, $img_size . '_2x' );
					$retina_img_url = ( ! empty( $retina_img_src ) ) ? $retina_img_src[0] : '';

					// Add the info to the srcset array if
					// the retina size is available.
					if ( ! empty( $retina_img_url ) ) {
						$data_attributes .= 'data-bg-' . esc_attr( $img_breakpoint ) . '-2x="' . esc_url( $retina_img_url ) . '" '; // Must be a space at the end!.
					}
				}
			}
		}

		$default_img_src = wp_get_attachment_image_src( $img_id, $default_img_size );

		if ( ! empty( $default_img_src ) ) {
			$data_attributes .= 'data-default-bg="' . esc_url( $default_img_src[0] ) . '" ';
		}

		if ( $return ) {
			return $data_attributes;
		} else {
			echo $data_attributes; // phpcs:ignore WordPress.Security.EscapeOutput
		}
	}
}
