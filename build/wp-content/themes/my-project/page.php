<?php
/**
 * The template for displaying all pages (that is, 'page' post type posts).

 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MKDO_Theme
 */

get_header();
?>

	<main class="site-main">

		<?php
		do_action( 'mkdo_theme_before_main_content' );

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', 'page' );
		}

		do_action( 'mkdo_theme_after_main_content' );
		?>

	</main>

<?php
get_sidebar();
get_footer();
