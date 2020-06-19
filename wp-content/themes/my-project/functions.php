<?php
/**
 * Functional theme includes and global constants/variables.
 *
 * @package MKDO_Theme
 */

// Constants.
define( 'MKDO_THEME_ROOT', __FILE__ );
define( 'MKDO_THEME_PARTS_DIR', __DIR__ . '/template-parts/' );

// Automatically import functional includes from the inc/ folder.
foreach ( glob( get_stylesheet_directory() . '/includes/*.php' ) as $mkdo_theme_filename ) {
	require_once $mkdo_theme_filename;
}
