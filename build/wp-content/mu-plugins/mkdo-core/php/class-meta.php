<?php
/**
 * Meta Class.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Class Meta
 *
 * Register Meta fields and carry out related actions.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */
class Meta {

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
		// Only scaffold the meta if CMB2 is available.
		if ( defined( 'CMB2_LOADED' ) ) {
			add_action( 'cmb2_admin_init', array( $this, 'register_meta_boxes' ), 10 );
		}
	}

	/**
	 * Register CMB2 powered meta fields.
	 */
	public function register_meta_boxes() {
		// Automatically require any partials found in the meta/ directory
		// that begin with `meta-` in the filename.
		foreach ( glob( dirname( $this->plugin_root ) . '/php/meta/meta-*.php' ) as $filename ) {
			require_once $filename;
		}
	}
}
