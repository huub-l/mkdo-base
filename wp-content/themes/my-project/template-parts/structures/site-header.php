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
					do_action( 'mkdo_theme_before_header_nav' );

					// Check if there is a menu attached to this location.
					if ( has_nav_menu( 'header' ) ) {
						// Display menu.
						wp_nav_menu(
							array(
								'theme_location' => 'header',
								'container'      => false,
							)
						);
					}

					do_action( 'mkdo_theme_after_header_nav' );
					?>
				</nav>

				<button class="site-header__menu-toggle" title="Open/Close Menu">
					<?php mkdo_theme_get_svg( 'icon-mobile-menu' ); ?>
					<?php mkdo_theme_get_svg( 'icon-close' ); ?>
				</button>

			</div>

		</div>

	<?php do_action( 'mkdo_theme_after_header_content' ); ?>

	</div>

</header>
