<?php
/**
 * Styleguide partial for meta
 *
 * @package MKDO_Theme
 *
 * @flags wrap spacing flex dynamic
 */

if ( ! function_exists( 'mkdo_theme_partial_meta' ) ) {
	/**
	 * Declare the renderer function, if it hasn't already been declared.
	 *
	 * @param array $data Data to be displayed within the renderer.
	 */
	function mkdo_theme_partial_meta(
		$data = array(
			'label'   => 'Label', // Required.
			'content' => 'Content', // Required.
			'link'    => '#',
			'user'    => true,
		)
	) {
		// If our required fields aren't present, abort.
		if ( ! mkdo_theme_get_array_path( 'label', $data ) || ! mkdo_theme_get_array_path( 'content', $data ) ) {
			return;
		}

		$meta_classes = array( 'meta' );

		if ( mkdo_theme_get_array_path( 'user', $data ) && is_numeric( mkdo_theme_get_array_path( 'content', $data ) ) ) {
			$meta_classes[] = 'meta--user';
			$user_avatar    = true;
		}
	?>
		<div class="<?php echo esc_attr( implode( ' ', $meta_classes ) ); ?>">

			<?php mkdo_theme_get_meta_content( $data, true ); ?>

		</div>
	<?php
	}
}

if ( mkdo_theme_is_styleguide() ) {
	/**
	 * If we're in the styleguide, output our examples.
	 */

	// Linked.
	mkdo_theme_get_partial(
		'meta',
		array(
			'label'   => 'Area of Study',
			'content' => 'Health & Social Care',
			'link'    => '#',
		)
	);

	// Linked.
	mkdo_theme_get_partial(
		'meta',
		array(
			'label'   => 'Area of Study',
			'content' => 'Health & Social Care',
			'link'    => '#',
		)
	);

	// Not linked.
	mkdo_theme_get_partial(
		'meta',
		array(
			'label'   => 'Phase',
			'content' => 'Year 3/4',
		)
	);

	// The full monty: a linked user.
	mkdo_theme_get_partial(
		'meta',
		array(
			'label'   => 'Tutor',
			'content' => 'Rick Sanchez',
			'link'    => '#',
			'user'    => true,
		)
	);

	// A single user, by ID.
	mkdo_theme_get_partial(
		'meta',
		array(
			'label'   => 'Tutor',
			'content' => 2,
			'user'    => true,
		)
	);

	// Multiple users, by ID.
	mkdo_theme_get_partial(
		'meta',
		array(
			'label'   => 'Tutors',
			'content' => array( 2, 3, 4 ),
			'user'    => true,
		)
	);

	// List of linked things.
	mkdo_theme_get_partial(
		'meta',
		array(
			'label'   => 'Multiple linked meta under one label',
			'content' => array(
				array(
					'link'  => '#',
					'title' => 'Link 1',
				),
				array(
					'link'  => '#',
					'title' => 'Link 2',
				),
				array(
					'link'  => '#',
					'title' => 'Link 3',
				),
			),
			'user'    => true,
		)
	);

	// List of non-linked things.
	mkdo_theme_get_partial(
		'meta',
		array(
			'label'   => 'Multiple meta under one label',
			'content' => array( 'Item 1', 'Item 2', 'Item 3' ),
			'user'    => true,
		)
	);
}
