<?php
/**
 * Enqueue script and style assets.
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_scripts/
 * @link https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
 * @link https://developer.wordpress.org/reference/hooks/customize_preview_init/
 *
 * @package MKDO_Theme
 */

// Setup variables.
$mkdo_theme_debug_mode   = false;
$mkdo_theme_asset_suffix = '.min';

// Check if WordPress is in debug mode, if it is then we do not want to
// load the minified assets.
if ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) {
	$mkdo_theme_debug_mode   = true;
	$mkdo_theme_asset_suffix = '';
}

/**
 * Enqueue assets for the front-end.
 */
function mkdo_theme_enqueue_assets() {

	global $mkdo_theme_asset_suffix;

	// Header JS.
	$header_js_url  = get_stylesheet_directory_uri() . '/assets/js/header' . $mkdo_theme_asset_suffix . '.js';
	$header_js_path = dirname( MKDO_THEME_ROOT ) . '/assets/js/header' . $mkdo_theme_asset_suffix . '.js';

	wp_enqueue_script(
		'mkdo-theme-header-js',
		$header_js_url,
		array(),
		filemtime( $header_js_path ),
		true
	);

	// Footer JS.
	$footer_js_url  = get_stylesheet_directory_uri() . '/assets/js/footer' . $mkdo_theme_asset_suffix . '.js';
	$footer_js_path = dirname( MKDO_THEME_ROOT ) . '/assets/js/footer' . $mkdo_theme_asset_suffix . '.js';

	wp_enqueue_script(
		'mkdo-theme-footer-js',
		$footer_js_url,
		array( 'jquery' ),
		filemtime( $footer_js_path ),
		true
	);

	// Comments JS.
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// Stylesheet.
	$mkdo_theme_style_url  = get_stylesheet_uri();
	$mkdo_theme_style_path = dirname( MKDO_THEME_ROOT ) . '/style.css';

	wp_enqueue_style(
		'mkdo-theme-style',
		$mkdo_theme_style_url,
		array(),
		filemtime( $mkdo_theme_style_path )
	);
}
add_action( 'wp_enqueue_scripts', 'mkdo_theme_enqueue_assets', 10 );

/**
 * Enqueue assets for the admin area.
 */
function mkdo_theme_enqueue_admin_assets() {

	global $mkdo_theme_asset_suffix;

	// Admin stylesheet.
	$admin_style_url  = get_stylesheet_directory_uri() . '/assets/css/admin' . $mkdo_theme_asset_suffix . '.css';
	$admin_style_path = dirname( MKDO_THEME_ROOT ) . '/assets/css/admin' . $mkdo_theme_asset_suffix . '.css';
	wp_enqueue_script(
		'mkdo-theme-admin-style',
		$admin_style_url,
		array(),
		filemtime( $admin_style_path ),
		false
	);

	// Editor stylesheet.
	$editor_css_url  = get_stylesheet_directory_uri() . '/assets/css/editor' . $mkdo_theme_asset_suffix . '.css';
	$editor_css_path = dirname( MKDO_THEME_ROOT ) . '/assets/css/editor' . $mkdo_theme_asset_suffix . '.css';
	add_editor_style( $editor_css_url . '?v=' . filemtime( $editor_css_path ) );
}
add_action( 'admin_enqueue_scripts', 'mkdo_theme_enqueue_admin_assets', 10 );

/**
 * Enqueue JS handlers to make the Customizer
 * live preview reload changes asynchronously.
 */
function mkdo_theme_enqueue_customize_preview_js() {

	global $mkdo_theme_asset_suffix;

	$live_preview_js_url  = get_stylesheet_directory_uri() . '/assets/js/customizer' . $mkdo_theme_asset_suffix . '.js';
	$live_preview_js_path = dirname( MKDO_THEME_ROOT ) . '/assets/js/customizer' . $mkdo_theme_asset_suffix . '.js';

	wp_enqueue_script(
		'mkdo-theme-customizer',
		$live_preview_js_url,
		array( 'customize-preview' ),
		filemtime( $live_preview_js_path ),
		true
	);
}
add_action( 'customize_preview_init', 'mkdo_theme_enqueue_customize_preview_js', 10 );
