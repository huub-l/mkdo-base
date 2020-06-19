<?php
/**
 * The Sidebar (containing the main widget area).
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MKDO_Theme
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<?php do_action( 'mkdo_theme_before_sidebars' ); ?>

<div class="sidebar widget-area">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div>

<?php do_action( 'mkdo_theme_after_sidebars' ); ?>
