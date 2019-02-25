<?php
/**
 * Post_Types Class.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Class Post_Types
 *
 * Register custom post types and carry out related actions.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */
class Post_Types {

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
		// This MUST fire at a EARLIER priority than taxonomy registrations.
		add_action( 'init', array( $this, 'register_custom_post_types' ), 10 );
	}

	/**
	 * Register custom post types
	 */
	public function register_custom_post_types() {
		// Automatically require any partials found in the post-types/ directory
		// that begin with `cpt-` in the filename.
		foreach ( glob( dirname( $this->plugin_root ) . '/php/post-types/cpt-*.php' ) as $filename ) {
			require_once $filename;
		}
	}
}
