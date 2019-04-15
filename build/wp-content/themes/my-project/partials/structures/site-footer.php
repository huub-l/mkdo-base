<?php
/**
 * Styleguide partial for site-footer
 *
 * @package MKDO_Theme
 *
 * @flags offwhite allowoverflow dynamic
 */

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


			<div class="site-footer__row">

				<div class="site-footer__legal">
					<p>&copy; My Project</p>
				</div>

			</div>

		<?php
		}

		do_action( 'mkdo_theme_after_footer_content' );
		?>

	</div>

</footer>
