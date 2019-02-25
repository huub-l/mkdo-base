<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package MKDO_Theme
 */

?>

<section class="no-results not-found" aria-labelledby="not-found-heading">

	<header class="page-header">

		<h1 id="not-found-heading" class="page-title">
			<?php esc_html_e( 'Nothing Found', 'mkdo-theme' ); ?>
		</h1>

	</header>

	<div class="page-content">

		<?php
		do_action( 'mkdo_theme_before_post_content' );

		if ( is_home() && current_user_can( 'publish_posts' ) ) {
			?>

			<p>
				<?php
				printf(
					wp_kses(
						/* translators: the post permalink. */
						__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'mkdo-theme' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>

			<?php
		} elseif ( is_search() ) {
			?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'mkdo-theme' ); ?></p>

			<?php
			get_search_form();
		} else {
			?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'mkdo-theme' ); ?></p>

			<?php
			get_search_form();
		}

		do_action( 'mkdo_theme_after_post_content' );
		?>

	</div>

</section>
