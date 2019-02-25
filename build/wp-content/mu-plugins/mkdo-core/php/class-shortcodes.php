<?php
/**
 * Shortcodes Class.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Class Shortcodes
 *
 * Register Shortcodes and carry out related actions.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */
class Shortcodes {

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
		// Only scaffold the shortcodes if Shortcake UI is available.
		if ( function_exists( 'shortcode_ui_init' ) ) {
			add_action( 'init', array( $this, 'register_shortcodes' ), 10 );
		}
	}

	/**
	 * Register Shortcodes.
	 */
	public function register_shortcodes() {
		// Automatically require any partials found in the shortcodes/ directory
		// that begin with `shortcode-` in the filename.
		foreach ( glob( dirname( $this->plugin_root ) . '/php/shortcodes/shortcode-*.php' ) as $filename ) {
			require_once $filename;
		}
	}
}
