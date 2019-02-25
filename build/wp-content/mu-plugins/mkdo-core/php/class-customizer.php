<?php
/**
 * Customizer Class.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Class Customizer
 *
 * Register Customizer settings, panels, section, controls,
 * and carry out related actions.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */
class Customizer {

	/**
	 * Path to the root plugin file.
	 *
	 * @var     string
	 * @access  private
	 * @since   1.0.0
	 */
	private $plugin_root;

	/**
	 * Plugin name.
	 *
	 * @var     string
	 * @access  private
	 * @since   1.0.0
	 */
	private $plugin_name;

	/**
	 * Plugin slug.
	 *
	 * @var     string
	 * @access  private
	 * @since   1.0.0
	 */
	private $plugin_slug;

	/**
	 * Plugin prefix.
	 *
	 * @var     string
	 * @access  private
	 * @since   1.0.0
	 */
	private $plugin_prefix;

	/**
	 * Constructor.
	 *
	 * @since   1.0.0
	 */
	public function __construct() {
		$this->plugin_root   = MKDO_CORE_ROOT;
		$this->plugin_name   = MKDO_CORE_NAME;
		$this->plugin_slug   = MKDO_CORE_SLUG;
		$this->plugin_prefix = MKDO_CORE_PREFIX;
	}

	/**
	 * Unleash Hell.
	 *
	 * @since   1.0.0
	 */
	public function run() {
		// Only scaffold the customizer if Kirki is available.
		if ( function_exists( 'Kirki' ) ) {
			add_action( 'init', array( $this, 'register_customizer_fields' ), 10 );
		}
	}

	/**
	 * Register Kirki powered customizer settings/sections/panels/controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function register_customizer_fields( $wp_customize ) {

		// Silences WPCS!
		$wpc = $wp_customize;

		$config_id = $this->plugin_prefix . 'customizer';

		\Kirki::add_config(
			$config_id,
			array(
				'capability'  => 'edit_theme_options',
				'option_type' => 'option',
				'option_name' => $this->plugin_prefix . 'customizer_options',
			)
		);

		\Kirki::add_panel(
			$this->plugin_prefix . 'panel',
			array(
				'priority' => 10,
				'title'    => __( 'Theme Settings', 'mkdo-core' ),
			)
		);

		// Automatically require any partials found in the customizer/ directory
		// that begin with `customizer-` in the filename.
		foreach ( glob( dirname( $this->plugin_root ) . '/php/customizer/customizer-*.php' ) as $filename ) {
			require_once $filename;
		}
	}
}
