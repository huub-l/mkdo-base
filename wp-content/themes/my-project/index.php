<?php
/**
 * The main template file.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MKDO_Theme
 */

get_header();
?>

	<main class="site-main">

	<?php
	do_action( 'mkdo_theme_before_main_content' );

	if ( have_posts() ) {

		while ( have_posts() ) {
			the_post();

			get_template_part( 'template-parts/content', get_post_format() );
		}
		the_posts_navigation();
	} else {
		get_template_part( 'template-parts/content', 'none' );
	}

	do_action( 'mkdo_theme_before_main_content' );
	?>

	</main>

<?php
get_sidebar();
get_footer();
