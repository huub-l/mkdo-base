<?php
/**
 * Customizer Fields.
 *
 * @package MKDO\Data_Model
 */

namespace MKDO\Data_Model\Customizer_Fields;

use const MKDO\Data_Model\ROOT_DIR;
use const MKDO\Data_Model\PREFIX;

/**
 * Setup.
 */
function setup() {
	// Only scaffold the customizer if Kirki is available.
	if ( function_exists( 'Kirki' ) ) {
		add_action( 'init', __NAMESPACE__ . '\\register_customizer_fields', 10 );
	}
}

/**
 * Register Kirki powered customizer settings/sections/panels/controls.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function register_customizer_fields( $wp_customize ) {

	// Silences WPCS!
	$wpc = $wp_customize;

	$config_id = PREFIX . 'customizer';

	\Kirki::add_config(
		$config_id,
		[
			'capability'  => 'edit_theme_options',
			'option_type' => 'option',
			'option_name' => PREFIX . 'customizer_options',
		]
	);

	\Kirki::add_panel(
		PREFIX . 'panel',
		[
			'priority' => 10,
			'title'    => __( 'Theme Settings', 'mkdo-data-model' ),
		]
	);

	// Automatically require any partials found in the customizer/ directory
	// that begin with `customizer-` in the filename.
	foreach ( glob( dirname( ROOT_DIR ) . '/inc/customizer-fields/customizer-*.php' ) as $filename ) {
		require_once $filename;
	}
}
