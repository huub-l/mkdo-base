<?php
/**
 * The Footer.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package MKDO_Theme
 */

			do_action( 'mkdo_theme_after_main' );
			?>

			</div>

			<?php get_template_part( 'partials/structures/site-footer' ); ?>

		</div>

		<?php
		do_action( 'mkdo_theme_before_wp_footer' );

		wp_footer();
		?>

	</body>

</html>
