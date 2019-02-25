<?php
/**
 * Template part for displaying single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MKDO_Theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'h-entry' ); ?>>

	<header class="entry-header">

		<?php
		do_action( 'mkdo_theme_featured_image' );

		the_title( '<h1 class="entry-title p-name">', '</h1>' );
		?>

		<div class="entry-info">
			<?php mkdo_theme_entry_info(); ?>
		</div>

	</header>

	<div class="entry-content e-content">

		<?php
		do_action( 'mkdo_theme_before_post_content' );

		the_content();

		do_action( 'mkdo_theme_after_post_content' );
		?>

	</div>

	<footer class="entry-footer">

		<div class="entry-meta">
			<?php mkdo_theme_entry_meta(); ?>
		</div>

	</footer>

</article>
