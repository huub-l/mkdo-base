<?php
/**
 * Dynamically register settings.
 *
 * @package MKDO\Essentials
 */

namespace MKDO\Essentials\Settings;

use const MKDO\Essentials\ROOT_DIR;
use const MKDO\Essentials\PREFIX;

/**
 * Setup.
 *
 * @return void
 */
function register_settings_page() : void {

	\add_settings_section(
		PREFIX . '_settings_section',
		__( 'Feature Settings', 'mkdo-essentials' ),
		'MKDO\Essentials\Settings\render_settings_section',
		PREFIX . '_settings'
	);

	$options = get_option( PREFIX . '_settings' );

	// Get all of the files in question.
	foreach ( glob( ROOT_DIR . '/inc/features/*.php' ) as $filename ) {

		$base  = basename( $filename, '.php' );
		$slug  = strtolower( $base );
		$label = ucfirst( str_replace( '-', ' ', $base ) );

		\register_setting( PREFIX . '_settings', PREFIX . '_setting_' . $slug );

		\add_settings_field(
			PREFIX . '_setting_' . $slug,
			$label,
			'MKDO\Essentials\Settings\render_settings_field',
			PREFIX . '_settings',
			PREFIX . '_settings_section',
			[
				'filename' => $slug,
				'options'  => $options,
			]
		);
	}
}

/**
 * Register settings menu.
 *
 * @return void
 */
function register_settings_menu() : void {

	\add_submenu_page(
		'options-general.php',
		__( 'MKDO Essentials', 'mkdo-essentials' ),
		__( 'MKDO Essentials', 'mkdo-essentials' ),
		'manage_options',
		PREFIX . '_settings',
		'MKDO\Essentials\Settings\render_settings_page'
	);
}

/**
 * Render the settings page.
 *
 * @return void
 */
function render_settings_page() : void {
	?>
	<div class="wrap">
		<h2><?php esc_html_e( 'MKDO Essentials', 'mkdo-essentials' ); ?></h2>

		<form action="options-general.php?page=mkdo_essentials_settings" method="POST" novalidate="novalidate" autocomplete="off">
			<?php \settings_fields( PREFIX . '_settings' ); ?>
			<?php \do_settings_sections( PREFIX . '_settings' ); ?>
			<?php \submit_button(); ?>
		</form>
	</div>
<?php
}

/**
 * Render the settings section.
 *
 * @return void
 */
function render_settings_section() : void {
	echo '<p>' . esc_html( 'Each of the features settings listed below are ENABLED by default. By checking the relevant box below you will marking it as DISABLED.', 'mkdo-essentials' ) . '</p>';
}

/**
 * Render a settings field.
 *
 * @param array $args Array of arguments passed to the callback.
 * @return void
 */
function render_settings_field( $args ) : void {
	$setting_slug = str_replace( '-', '_', basename( $args['filename'], '.php' ) );
	?>
	<label for="<?php esc_attr( $setting_slug ); ?>">
		<input
		id="<?php esc_attr( $setting_slug ); ?>"
		type="checkbox"
		name="mkdo_essentials[<?php echo esc_attr( $setting_slug ); ?>]"
		<?php echo ( ! empty( $args['options'] ) && array_key_exists( $setting_slug, $args['options'] ) ) ? 'checked' : ''; ?>
		/>
		Disable?
	</label>

	<?php
}

/**
 * Save the settings to the option.
 *
 * @return void
 */
function save_settings_options() : void {

	if (
		! isset( $_POST['_wpnonce'] )
		|| ! isset( $_POST['option_page'] )
		|| PREFIX . '_settings' !== $_POST['option_page']
		) {
		return;
	}

	// phpcs:disable WordPress.Security.ValidatedSanitizedInput.InputNotValidated
	wp_verify_nonce(
		sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ),
		'update'
	);

	delete_option( PREFIX . '_settings' );

	if ( ! empty( $_POST['mkdo_essentials'] ) ) {
		add_option( PREFIX . '_settings', $_POST['mkdo_essentials'] );
	}

	wp_safe_redirect(
		add_query_arg(
			[
				'page'    => PREFIX . '_settings',
				'updated' => 'true',
			],
			admin_url( 'options-general.php' )
		)
	);

	exit;
}
