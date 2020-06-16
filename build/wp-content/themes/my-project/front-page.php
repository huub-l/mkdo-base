<?php
/**
 * The template for displaying the front page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MKDO_Theme
 */

get_header();

do_action( 'mkdo_theme_front_page_intro' );
?>

	<main class="site-main">

		<div class="template-front-page">

			<?php
			do_action( 'mkdo_theme_before_main_content' );

			while ( have_posts() ) {

				the_post();

				do_action( 'mkdo_theme_before_post_content' );

				the_content();

				do_action( 'mkdo_theme_after_post_content' );
			}

			do_action( 'mkdo_theme_after_main_content' );
			?>

		</div>

	</main>

<?php
get_footer();
