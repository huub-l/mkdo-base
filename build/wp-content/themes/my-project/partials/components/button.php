<?php
/**
 * Styleguide partial for button.
 *
 * @package MKDO_Theme
 *
 * @flags wrap spacing dynamic
 */

if ( ! function_exists( 'mkdo_theme_partial_button' ) ) {
	/**
	 * Declare the renderer function, if it hasn't already been declared.
	 *
	 * @param array $data Data to be displayed within the renderer.
	 */
	function mkdo_theme_partial_button(
		$data = array(
			'label'     => 'Button label', // Required.
			'classes'   => 'button--primary',
			'icon-name' => 'cog',
		)
	) {
		// If our required fields aren't present, abort.
		if ( empty( array_intersect( array( 'label' ), array_keys( $data ) ) ) ) {
			return;
		}
?>
	<button class="button <?php echo esc_attr( $data['classes'] ); ?>">
		<?php
			if ( isset( $data['icon-name'] ) && ! empty( $data['icon-name'] ) ) {
				mkdo_theme_get_svg( $data['icon-name'] );
			}
		?>
		<?php echo esc_html( $data['label'] ); ?>
	</button>
<?php
	}
}

if ( mkdo_theme_is_styleguide() ) {
	/**
	 * If we're in the styleguide, output our examples.
	 */

	mkdo_theme_get_partial(
		'button',
		array(
			'label'   => 'Yes',
			'classes' => '',
		)
	);

	mkdo_theme_get_partial(
		'button',
		array(
			'label'   => 'Sign up',
			'classes' => 'button--primary',
		)
	);

	mkdo_theme_get_partial(
		'button',
		array(
			'label'   => 'Sign up',
			'classes' => 'button--secondary',
		)
	);

	mkdo_theme_get_partial(
		'button',
		array(
			'label'   => 'Delete', // Required.
			'classes' => 'button--grey',
		)
	);

	mkdo_theme_get_partial(
		'button',
		array(
			'label'   => 'Dismiss',
			'classes' => 'button--ghost-dark',
		)
	);

	mkdo_theme_get_partial(
		'button',
		array(
			'label'   => 'Load more',
			'classes' => 'button--ghost-dark-blue',
		)
	);

	mkdo_theme_get_partial(
		'button',
		array(
			'label'     => 'Sign up',
			'classes'   => 'button--secondary',
			'icon-name' => 'edit-pencil',
		)
	);

	mkdo_theme_get_partial(
		'button',
		array(
			'label'     => 'Delete', // Required.
			'classes'   => 'button--grey',
			'icon-name' => 'trash',
		)
	);

	mkdo_theme_get_partial(
		'button',
		array(
			'label'     => 'Dismiss',
			'classes'   => 'button--ghost-dark',
			'icon-name' => 'cog',
		)
	);

	mkdo_theme_get_partial(
		'button',
		array(
			'label'     => 'Take registration',
			'classes'   => 'button--ghost-dark button--icon-right',
			'icon-name' => 'cog',
		)
	);

	mkdo_theme_get_partial(
		'button',
		array(
			'label'     => 'Take registration',
			'classes'   => 'button--ghost-dark-blue',
			'icon-name' => 'cog',
		)
	);

	?>
		<button class="button button--ghost-dark-blue button--disabled">
			Disabled (class)
		</button>
		<button class="button button--secondary" disabled>
			<?php mkdo_theme_get_svg( 'cog' ); ?>
			<span>Disabled (attribute)</span>
		</button>

		<button class="button button--primary button--loading button--loading__active">
			Test Loading Button
		</button>
		<button class="button button--ghost-dark button--loading button--loading__active">
			<?php mkdo_theme_get_svg( 'cog' ); ?>
			<span>
				Test Loading Button
			</span>
		</button>
	<?php
}
?>
