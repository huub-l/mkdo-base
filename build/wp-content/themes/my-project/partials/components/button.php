<?php
/**
 * Button.
 *
 * @package MKDO_Theme
 *
 * @flags wrap spacing dynamic
 */

?>

<button class="button">
	Yes
</button>

<button class="button--primary">
	Sign up
</button>

<button class="button--secondary">
	Sign up
</button>

<button class="button--grey">
	Delete
</button>

<button class="button button--ghost-dark">
	Delete
</button>

<button class="button button--ghost-dark-blue">
	Delete
</button>

<button class="button button--secondary">
	<?php mkdo_theme_get_svg( 'icon-chat' ); ?>
	<span>Sign up</span>
</button>

<button class="button button--grey">
	<?php mkdo_theme_get_svg( 'icon-code' ); ?>
	<span>Delete</span>
</button>

<button class="button button--ghost-dark">
	<?php mkdo_theme_get_svg( 'icon-chevron-right' ); ?>
	<span>Dismiss</span>
</button>

<button class="button button--ghost-dark button--icon-right">
	<?php mkdo_theme_get_svg( 'icon-chevron-right' ); ?>
	<span>Take registration</span>
</button>

<button class="button button--ghost-dark-blue">
	<?php mkdo_theme_get_svg( 'icon-map' ); ?>
	<span>Take registration</span>
</button>

<button class="button button--ghost-dark-blue button--disabled">
	<span>Disabled (class)</span>
</button>

<button class="button button--secondary" disabled>
	<?php mkdo_theme_get_svg( 'icon-news' ); ?>
	<span>Disabled (attribute)</span>
</button>

<button class="button button--primary button--loading button--loading__active">
	Test Loading Button
</button>

<button class="button button--ghost-dark button--loading button--loading__active">
	<?php mkdo_theme_get_svg( 'icon-chevron-right' ); ?>
	<span>
		Test Loading Button
	</span>
</button>
