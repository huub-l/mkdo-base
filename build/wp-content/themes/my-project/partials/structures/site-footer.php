<?php
/**
 * Styleguide partial for site-footer
 *
 * @package MKDO_Theme
 *
 * @flags offwhite allowoverflow dynamic
 */

if ( ! function_exists( 'mkdo_theme_partial_site_footer' ) ) {
	/**
	 * Declare the renderer function, if it hasn't already been declared.
	 *
	 * @param array $data Data to be displayed within the renderer.
	 */
	function mkdo_theme_partial_site_footer(
		$data = array(
			'legal' => '<p>&copy; My Project</p>',
		)
	) {
	?>
		<footer class="site-footer" role="contentinfo">

			<div class="site-footer__wrap">

				<?php
				do_action( 'mkdo_theme_before_footer_content' );

				if ( has_nav_menu( 'footer' ) ) {
					?>

					<div class="site-footer__row">

						<div class="site-footer__menu">
							<?php
								wp_nav_menu(
									array(
										'theme_location' => 'footer',
										'container'      => false,
										'menu_class'     => 'site-footer__menu-list',
										'depth'          => 1,
									)
								);
							?>
						</div>

					</div>

				<?php
				}
				if ( ! empty( $data ) && isset( $data['legal'] ) ) {
					?>

					<div class="site-footer__row">

						<div class="site-footer__legal">
							<?php echo wp_kses_post( $data['legal'] ); ?>
						</div>

					</div>

				<?php
				}

				do_action( 'mkdo_theme_after_footer_content' );
				?>

			</div>

		</footer>

	<?php
	}
}

if ( mkdo_theme_is_styleguide() ) {
	/**
	 * If we're in the styleguide, output our examples.
	 */

	mkdo_theme_get_partial(
		'site-footer',
		array(
			'legal' => '<p>&copy; My Project</p>',
		)
	);

}
?>
