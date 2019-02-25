<?php
/**
 * The Header.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MKDO_Theme
 */

?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

	<?php
	do_action( 'mkdo_theme_before_wp_head' );

	wp_head();

	do_action( 'mkdo_theme_after_wp_head' );
	?>
</head>

<body <?php body_class(); ?>>

<a class="skip-link sr-only" href="#content"><?php esc_html_e( 'Skip to content', 'mkdo-theme' ); ?></a>
<a class="skip-link sr-only" href="#site-navigation"><?php esc_html_e( 'Skip to navigation', 'mkdo-theme' ); ?></a>

<div class="hfeed site-container">

	<?php mkdo_theme_get_partial( 'site-header' ); ?>

	<div id="content" class="site-content">

		<?php do_action( 'mkdo_theme_before_main' ); ?>
