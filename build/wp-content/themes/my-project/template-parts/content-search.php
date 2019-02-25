<?php
/**
 * Template part for displaying results in search pages.
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

		the_title( sprintf( '<h2 class="entry-title p-name"><a href="%s" rel="bookmark" class="u-url">', esc_url( get_permalink() ) ), '</a></h2>' );

		if ( 'post' === get_post_type() ) {
			?>

			<div class="entry-info">
				<?php mkdo_theme_entry_info(); ?>
			</div>

			<?php
		}
		?>

	</header>

	<div class="entry-summary p-summary">

		<?php
		do_action( 'mkdo_theme_before_search_excerpt' );

		the_excerpt();

		do_action( 'mkdo_theme_before_search_excerpt' );
		?>

	</div>

	<footer class="entry-footer">

		<div class="entry-meta">
			<?php mkdo_theme_entry_meta(); ?>
		</div>

	</footer>

</article>
