<?php
/**
 * The template for displaying archive pages.
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
		?>

		<header class="page-header">
			<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			?>
		</header>

		<?php
		while ( have_posts() ) {

			the_post();

			get_template_part( 'template-parts/content', get_post_format() );
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
