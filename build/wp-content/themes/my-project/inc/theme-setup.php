<?php
/**
 * Theme setup.
 *
 * @link https://developer.wordpress.org/reference/hooks/after_setup_theme/
 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
 *
 * @package MKDO_Theme
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mkdo_theme_theme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on MKDO Theme, use a find and replace
	 * to change 'mkdo-theme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'mkdo-theme', get_stylesheet_directory() . '/languages' );

	/*
	 * Register navigation menus.
	 */
	register_nav_menus(
		array(
			'primary' => esc_html__( 'Primary Menu', 'mkdo-theme' ),
			'footer'  => esc_html__( 'Footer Menu', 'mkdo-theme' ),
		)
	);

	/*
	 * Add default posts and comments RSS feed links to head.
	 */
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	/*
	 * Enable support Selective Refresh in the Customizer.
	 */
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		)
	);

	/**
	 * Add yoast breadcrumb support if the plugin is enabled.
	 */
	include_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
		add_theme_support( 'yoast-seo-breadcrumbs' );
	}

	/**
	 * Gutenberg support.
	 */
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support(
		'editor-color-palette',
		array(
			array(
				'name'  => __( 'Offwhite', 'mkdo-theme' ),
				'slug'  => 'Offwhite',
				'color' => '#ededed',
			),
		)
	);

	/**
	 * Gutenberg disables.
	 */
	add_theme_support( 'disable-custom-colors' );

	// @codingStandardsIgnoreStart
	// add_theme_support(
	// 	'editor-font-sizes',
	// 	array(
	// 		array(
	// 			'name' => __( 'Normal', 'mkdo-theme' ),
	// 			'size' => 18,
	// 			'slug' => 'normal',
	// 		),
	// 	)
	// );
	//
	// add_theme_support( 'disable-custom-font-sizes' );
	//
	// @codingStandardsIgnoreEnd
}
add_action( 'after_setup_theme', 'mkdo_theme_theme_setup', 10 );
