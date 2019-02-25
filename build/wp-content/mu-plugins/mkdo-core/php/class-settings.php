<?php
/**
 * Settings Class.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */

namespace MKDO_Core;

/**
 * Class Settings
 *
 * @since   1.0.0
 *
 * @package MKDO_Core
 */
class Settings {

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
	 * Do Work
	 *
	 * @since   1.0.0
	 */
	public function run() {
		// @codingStandardsIgnoreStart
		// Uncomment these hooks to create a plugin settings page.
		// add_action( 'admin_init', array( $this, 'init_settings_page' ) );
		// add_action( 'admin_menu', array( $this, 'add_settings_page' ) );
		// @codingStandardsIgnoreEnd
	}

	/**
	 * Initialise the Settings Page.
	 *
	 * @since   1.0.0
	 */
	public function init_settings_page() {

		// Register settings.
		register_setting( $this->plugin_prefix . '_settings_group', $this->plugin_prefix . '_example_setting' );

		// Add sections.
		add_settings_section(
			$this->plugin_prefix . '_example_section',
			__( 'Example Section Heading', 'mkdo-core' ),
			array( $this, $this->plugin_prefix . '_example_section_cb' ),
			$this->plugin_prefix . '_settings'
		);

		// Add fields to a section.
		add_settings_field(
			$this->plugin_prefix . '_example_field',
			__( 'Example Field Label:', 'mkdo-core' ),
			array( $this, $this->plugin_prefix . '_example_field_cb' ),
			$this->plugin_prefix . '_settings',
			$this->plugin_prefix . '_example_section'
		);
	}

	/**
	 * Call back for the example section.
	 *
	 * @since   1.0.0
	 */
	public function example_section_cb() {
		echo '<p>' . esc_html( 'Example description for this section.', 'mkdo-core' ) . '</p>';
	}

	/**
	 * Call back for the example field.
	 *
	 * @since   1.0.0
	 */
	public function example_field_cb() {
		$example_option = get_option( $this->plugin_prefix . '_example_option', 'Default text...' );
		?>

		<div class="field field-example">
			<p class="field-description">
				<?php esc_html_e( 'This is an example field.', 'mkdo-core' ); ?>
			</p>
			<ul class="field-input">
				<li>
					<label>
						<input type="text" name="<?php echo esc_attr( $this->plugin_prefix . '_example_field' ); ?>" value="<?php echo esc_attr( $example_option ); ?>" />
					</label>
				</li>
			</ul>
		</div>

		<?php
	}

	/**
	 * Add the settings page.
	 *
	 * @since   1.0.0
	 */
	public function add_settings_page() {
		add_submenu_page(
			'settings-general.php',
			__( 'Example Settings', 'mkdo-core' ),
			__( 'My Project Core', 'mkdo-core' ),
			'manage_settings',
			$this->plugin_prefix,
			array( $this, 'render_settings_page' )
		);
	}

	/**
	 * Render the settings page.
	 *
	 * @since   1.0.0
	 */
	public function render_settings_page() {
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'My Project Core', 'mkdo-core' ); ?></h2>

			<form action="settings.php" method="POST">
				<?php settings_fields( $this->plugin_prefix . '_settings_group' ); ?>
				<?php do_settings_sections( $this->plugin_prefix . '_settings' ); ?>
				<?php submit_button(); ?>
			</form>
		</div>
	<?php
	}
}
