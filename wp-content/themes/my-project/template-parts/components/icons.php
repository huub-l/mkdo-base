<?php
/**
 * Icons.
 *
 * @package MKDO_Theme
 *
 * @flags wrap spacing icon flex
 */

// Output all svgs.
foreach ( glob( get_stylesheet_directory() . '/assets/dist/svgs/*.svg' ) as $mkdo_theme_file ) {
	$mkdo_theme_path_parts    = pathinfo( $mkdo_theme_file );
	$mkdo_theme_file_slug     = $mkdo_theme_path_parts['filename'];
	$mkdo_theme_text          = ( ! empty( $mkdo_theme_title ) ) ? $mkdo_theme_title : $mkdo_theme_file_slug;
 	$mkdo_theme_old_svg       = file_get_contents( $mkdo_theme_file ); // @codingStandardsIgnoreLine
	$mkdo_theme_find_string   = '<svg';
	$mkdo_theme_str_to_insert = '<svg x="0px" y="0px" ';
	$mkdo_theme_pos           = strpos( $mkdo_theme_old_svg, $mkdo_theme_find_string );
	$mkdo_theme_new_svg       = str_replace( $mkdo_theme_find_string, $mkdo_theme_str_to_insert, $mkdo_theme_old_svg );
	// Replace the title text.
	$mkdo_theme_search    = '/<title[^>]*>.*?<\/title>/i';
	$mkdo_theme_new_title = '<title>' . $mkdo_theme_text . '</title>';
	echo preg_replace( $mkdo_theme_search, $mkdo_theme_new_title, $mkdo_theme_new_svg ); // phpcs:ignore WordPress.Security.EscapeOutput
}
