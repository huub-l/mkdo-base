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

			</div> <!-- site-content -->

			<?php
				mkdo_theme_get_partial(
					'site-footer',
					array(
						'legal' => '<p>&copy; My Project</p>',
					)
				);
			?>

		</div> <!-- hfeed site-container -->

		<?php
		do_action( 'mkdo_theme_before_wp_footer' );

		wp_footer();
		?>

	</body>

</html>
