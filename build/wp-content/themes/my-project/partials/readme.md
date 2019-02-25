# mkdo_theme Dynamic Templates

The `partials` directory can contain a combination of dynamic and static templates. Both types of template are used to generate the Styleguide. Dynamic templates can also be accessed with the `mkdo_theme_get_partial()` function to render front-end markup which mirrors the Styleguide and stays in sync with it. The `mkdo_theme_get_partial()` function takes in a flexible array of data, and deals with all display logic, allowing for clean WordPress templates.

## Creating a new partial from scratch

Once you've decided whether the partial is a component, module, structure, or template, create a file in the appropriate directory named in the same BEM-friendly way as our SASS and JS partials.

Here's a completely blank template to start you off:

```
<?php
/**
 * Styleguide partial for my-partial-name
 *
 * @package MKDO_Theme Name
 *
 * @flags dynamic
 */

if ( ! function_exists( 'mkdo_theme_partial_my_partial_name' ) ) {
	/**
	 * Declare the renderer function, if it hasn't already been declared.
	 *
	 * @param array $data Data to be displayed within the renderer.
	 */
	function mkdo_theme_partial_my_partial_name(
		$data = array(
			'title' => 'My default title', // Required.
		)
	) {
		// If our required fields aren't present, abort.
		if ( empty( array_intersect( array( 'title' ), array_keys( $data ) ) ) ) {
			return;
		}
?>
		<div class="my-partial-name">
			<?php echo esc_html( $data['title'] ); ?>
		</div>
<?php
	}
}

if ( mkdo_theme_is_styleguide() ) {
	/**
	 * If we're in the styleguide, output our examples.
	 */

	mkdo_theme_get_partial(
		'my-partial-name',
		array(
			'title' => 'My title',
		)
	);

}
?>
```

Notes:

- You can have multiple @flags, space seperated. But `dynamic` must be included for `mkdo_theme_get_partial()` to pick it up.
