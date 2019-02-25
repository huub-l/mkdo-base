<?php
/**
 * Custom template tags for this theme.
 *
 * @package MKDO_Theme
 */

/**
 * Returns true if a blog has more than 1 category.
 */
function mkdo_theme_categorized_blog() {
	$all_the_cool_cats = get_transient( 'mkdo_theme_categories' );
	if ( false === $all_the_cool_cats ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,

				// We only need to know if there is more than one category.
				'number'     => 2,
			)
		);

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'mkdo_theme_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so mkdo_theme_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so mkdo_theme_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in mkdo_theme_categorized_blog.
 */
function mkdo_theme_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'mkdo_theme_categories' );
}
add_action( 'edit_category', 'mkdo_theme_category_transient_flusher' );
add_action( 'save_post', 'mkdo_theme_category_transient_flusher' );

/**
 * Wrapper function to enable us to reference renderer functions with BEM names.
 *
 * @param string $partial BEM-friendly template name.
 * @param array  $data     An array of variables to pass to the template.  Refer to template partial for details.
 */
function mkdo_theme_get_partial( $partial, $data = array() ) {
	$partial_function = 'mkdo_theme_partial_' . str_replace( '-', '_', $partial );

	if ( function_exists( $partial_function ) ) {
		if ( empty( $data ) ) {
			$partial_function();
		} else {
			// Check for `duplicate#...` data keys, and create duplicated data, if needed.
			foreach ( $data as $key => $value ) {
				if ( 'duplicate ' === substr( $key, 0, 10 ) ) {
					$key_parts = explode( ' ', $key );
					if ( isset( $key_parts[1] ) ) {
						for ( $i = 0; $i < $value; $i++ ) {
							$data[ $key_parts[1] ][] = $data[ $key_parts[1] ][0];
						}
					}
				}
			}

			// Run the function.
			$partial_function( $data );
		}
	} else {
		echo esc_html( 'Template not found' );
	}
}

/**
 * Include dynamic styleguide templates
 */
function mkdo_theme_load_dynamic_styleguide_templates() {
	$folders = array();
	foreach ( glob( MKDO_THEME_PARTIALS_DIR . '*', GLOB_ONLYDIR ) as $dir ) {
		$folders[] = basename( $dir );
	}
	foreach ( $folders as $folder ) {
		$glob = glob( MKDO_THEME_PARTIALS_DIR . $folder . '/*.php' );
		foreach ( $glob as $file ) {
			$file_lines = file( $file );
			foreach ( $file_lines as $line_number => $line ) {
				if ( strpos( $line, '@flags' ) !== false ) {
					// Array of flag values.
					$flagline = explode( ' ', $line );

					// Things to remove from the above.
					$removals = array( '', ' ', '*', '@flags' );
					$flags    = array_values( array_diff( $flagline, $removals ) );
					$flags    = array_map( 'trim', $flags );

					if ( in_array( 'dynamic', $flags, true ) ) {
						include $file;
					}
				}
			}
		}
	}
}
add_action( 'init', 'mkdo_theme_load_dynamic_styleguide_templates' );
