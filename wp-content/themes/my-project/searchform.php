<?php
/**
 * Search Form.
 *
 * @package MKDO_Theme
 */

?>

<form method="get" id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">

	<label for="s" class="sr-only">
		<?php esc_html_e( 'Search', 'mkdo-theme' ); ?>
		<input
		type="text"
		class="search-form--field"
		name="s"
		id="s"
		placeholder="<?php esc_attr_e( 'Search', 'mkdo-theme' ); ?>"
		/>
	</label>

	<input
	type="submit"
	class="search-form--submit"
	name="submit"
	id="search-submit"
	value="<?php esc_attr_e( 'Search', 'mkdo-theme' ); ?>" />

</form>
