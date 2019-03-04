<?php
/**
 * Theme specific functions that act independently of the theme templates.
 *
 * @package MKDO_Theme
 */

/**
 * Function to help dynamic styleguide templates know whether they're being run inside the styleguide.
 */
function mkdo_theme_is_styleguide() {
	$output = false;
	if ( 'page-static.php' === basename( get_page_template() ) ) {
		$output = true;
	}
	return $output;
}

/**
 * Function to check and return items from deep in a multi-dimenstional array, and avoid complex if statements.
 *
 * @param string $path  Path of array keys to search, with levels seperated by colons, eg, 'level-1:level-2:level-3'.
 *
 * @param array  $array The array you're searching through.
 *
 * @return mixed|false  Returns the value you're looking for, regardless of type; or false if that value can't be found, or is empty.
 */
function mkdo_theme_get_array_path( $path, $array ) {

	// If we're not searching an array, crap out.
	if ( ! is_array( $array ) ) {
		return false;
	}

	$levels     = explode( ':', $path ); // Break our path into pieces.
	$target     = end( $levels ); // The last piece is what we're ultimately after.
	$this_level = reset( $levels ); // The first piece is what we're looking for in the first (top) level.

	// If the current level is numeric, explicitly cast it as such, so we can run in_array() below in strict mode.
	if ( is_numeric( $this_level ) ) {
		$this_level = (int) $this_level;
	}

	if ( in_array( $this_level, array_keys( $array ), true ) ) {

		if ( $target === $this_level ) {
			// If we've found our target already, then return it if it's not empty.  Otherwise, return false.
			$result = $array[ $this_level ];
			if ( empty( $result ) ) {
				return false;
			} else {
				return $result;
			}
		} else {

			// Remove the first part of the path, as we've found it, and are looking for the next level now.
			unset( $levels[0] );

			// Start the recursive function, repeating all this again down through each level of the array.
			$result = mkdo_theme_get_array_path( implode( ':', $levels ), $array[ $this_level ] );

			// If the final result is not empty, return it.  Otherwise, return false.
			if ( empty( $result ) ) {
				return false;
			} else {
				return $result;
			}
		}
	}

	return false;
}
