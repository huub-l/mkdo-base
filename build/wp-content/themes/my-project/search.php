<?php
/**
 * The template for displaying search results pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package MKDO_Theme
 */

get_header();
?>

	<main class="site-main">

	<?php
	do_action( 'mkdo_theme_before_main_content' );

	if ( have_posts() ) {
		?>

		<header class="page-header">

			<h1 class="page-title">
				<?php
				printf(
					/* translators: the search query text. */
					esc_html__( 'Search Results for: %s', 'mkdo-theme' ),
					'<span>' . get_search_query() . '</span>'
				);
				?>
			</h1>

		</header>

		<?php
		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', 'search' );
		}
		the_posts_navigation();
	} else {
		get_template_part( 'template-parts/content', 'none' );
	}

	do_action( 'mkdo_theme_after_main_content' );
	?>

	</main>

<?php
get_sidebar();
get_footer();
