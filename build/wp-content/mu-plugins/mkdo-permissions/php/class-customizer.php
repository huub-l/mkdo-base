<?php
/**
 * Customizer Class.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core_Permissions
 */

namespace MKDO_Core_Permissions;

/**
 * Class Customizer
 *
 * Register Customizer settings, panels, section, controls,
 * and carry out related actions.
 *
 * @since   1.0.0
 *
 * @package MKDO_Core_Permissions
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
		$this->plugin_root   = MKDO_CORE_PERMISSIONS_ROOT;
		$this->plugin_name   = MKDO_CORE_PERMISSIONS_NAME;
		$this->plugin_slug   = MKDO_CORE_PERMISSIONS_SLUG;
		$this->plugin_prefix = MKDO_CORE_PERMISSIONS_PREFIX;
	}

	/**
	 * Unleash Hell.
	 *
	 * @since   1.0.0
	 */
	public function run() {
		add_action( 'customize_register', array( $this, 'register_customizer_fields' ), 10 );
	}

	/**
	 * Register Kirki powered customizer settings/sections/panels/controls.
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function register_customizer_fields( $wp_customize ) {

		// Get current user id.
		$user_id = get_current_user_id();

		// If we have a user id.
		if ( ! empty( $user_id ) ) {
			// Get user data to access email address.
			$user = get_userdata( $user_id );

			// If we have user data.
			if ( ! empty( $user ) ) {
				// If the email address contains 'makedo'.
				if ( strpos( $user->user_email, 'makedo' ) !== false ) {

					// Add setting.
					$wp_customize->add_setting(
						'mkdo_permission_emails',
						array(
							'transport' => 'refresh',
						)
					);

					// Add section.
					$wp_customize->add_section(
						'mkdo_permission_section',
						array(
							'title'    => __( 'MKDO Permission Emails', 'mkdo-core' ),
							'priority' => 30,
						)
					);

					// Add control.
					$wp_customize->add_control(
						new \WP_Customize_Control(
							$wp_customize,
							'mkdo_permission_emails',
							array(
								'label'       => __( 'Permitted Emails', 'mkdo-core' ),
								'description' => __( 'Make Do emails are auto allowed. Please enter comma separated entrys below.', 'mkdo-core' ),
								'section'     => 'mkdo_permission_section',
								'settings'    => 'mkdo_permission_emails',
								'type'        => 'text',
							)
						)
					);
				}
			}
		}
	}
}
