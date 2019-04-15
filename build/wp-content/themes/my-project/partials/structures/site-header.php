<?php
/**
 * Styleguide partial for my-partial-name
 *
 * @package MKDO_Theme
 *
 * @flags offwhite allowoverflow relativechild dynamic
 */

?>

<header class="site-header" role="banner">

	<div class="site-header__wrap">

	<?php do_action( 'mkdo_theme_before_header_content' ); ?>

		<div class="site-header__row">

			<a class="site-header__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
				Logo
			</a>

			<div class="site-header__navigation">

				<nav id="header-navigation" class="" role="navigation">

					<?php
					do_action( 'mkdo_theme_before_primary_nav' );

					// Check if there is a menu attached to this location.
					if ( has_nav_menu( 'primary' ) ) {
						// Display menu.
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => false,
							)
						);
					}

					do_action( 'mkdo_theme_after_primary_nav' );
					?>
				</nav>

			</div>

		</div>

	<?php do_action( 'mkdo_theme_after_header_content' ); ?>

	</div>

</header>
