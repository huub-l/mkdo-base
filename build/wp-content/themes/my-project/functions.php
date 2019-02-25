<?php
/**
 * Functional theme includes and global constants/variables.
 *
 * @package MKDO_Theme
 */

// Constants.
define( 'MKDO_THEME_ROOT', __FILE__ );
define( 'MKDO_THEME_PARTIALS_DIR', __DIR__ . '/partials/' );

// Automatically import functional includes from the inc/ folder.
foreach ( glob( get_stylesheet_directory() . '/inc/*.php' ) as $mkdo_theme_filename ) {
	require_once $mkdo_theme_filename;
}
