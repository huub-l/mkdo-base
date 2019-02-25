<?php
/**
 * Theme specific functions that act independently of the theme templates.
 *
 * @package MKDO_Theme
 */

/**
 * Function to help dynamic styleguide templates know whether they're being run inside the styleguide.
 */
function mkdo_theme_is_styleguide() {
	$output = false;
	if ( is_page_template( 'page-templates/page-static.php' ) ) {
		$output = true;
	}
	return $output;
}

/**
 * Function to check and return items from deep in a multi-dimenstional array, and avoid complex if statements.
 *
 * @param string $path  Path of array keys to search, with levels seperated by colons, eg, 'level-1:level-2:level-3'.
 *
 * @param array  $array The array you're searching through.
 *
 * @return mixed|false  Returns the value you're looking for, regardless of type; or false if that value can't be found, or is empty.
 */
function mkdo_theme_get_array_path( $path, $array ) {

	// If we're not searching an array, crap out.
	if ( ! is_array( $array ) ) {
		return false;
	}

	$levels     = explode( ':', $path ); // Break our path into pieces.
	$target     = end( $levels ); // The last piece is what we're ultimately after.
	$this_level = reset( $levels ); // The first piece is what we're looking for in the first (top) level.

	// If the current level is numeric, explicitly cast it as such, so we can run in_array() below in strict mode.
	if ( is_numeric( $this_level ) ) {
		$this_level = (int) $this_level;
	}

	if ( in_array( $this_level, array_keys( $array ), true ) ) {

		if ( $target === $this_level ) {
			// If we've found our target already, then return it if it's not empty.  Otherwise, return false.
			$result = $array[ $this_level ];
			if ( empty( $result ) ) {
				return false;
			} else {
				return $result;
			}
		} else {

			// Remove the first part of the path, as we've found it, and are looking for the next level now.
			unset( $levels[0] );

			// Start the recursive function, repeating all this again down through each level of the array.
			$result = mkdo_theme_get_array_path( implode( ':', $levels ), $array[ $this_level ] );

			// If the final result is not empty, return it.  Otherwise, return false.
			if ( empty( $result ) ) {
				return false;
			} else {
				return $result;
			}
		}
	}

	return false;
}

/**
 * Helper function to render the content in the components/meta partial.
 *
 * @param  array   $data The full $data array from the meta partial, so we've got all the context.
 *
 * @param  boolean $echo Whether to echo the HTML, or return it in a string.
 *
 * @return null|string
 */
function mkdo_theme_get_meta_content( $data, $echo = false ) {

	$content = mkdo_theme_get_array_path( 'content', $data );
	$label   = mkdo_theme_get_array_path( 'label', $data );

	if ( ! $content || ! $label ) {
		return;
	}

	$output = '';
	$label  = sprintf(
		'<span class="meta__label">%s</span>',
		$label
	);

	if ( is_numeric( $content ) && mkdo_theme_get_array_path( 'user', $data ) ) {

		// If it's one user ID.
		$user = get_userdata( $content );
		if ( $user ) {
			$output .= '<div class="user-avatar"></div>';
			$output .= $label;
			$output .= sprintf(
				'<a class="meta__content" href="%s">%s</a>',
				get_author_posts_url( $user->ID ),
				$user->display_name
			);
		}
	} elseif ( mkdo_theme_get_array_path( 'user', $data ) && is_array( $content ) && array_filter( $content, 'is_int' ) === $content ) {

		// If it's an array of user IDs.
		$output .= $label;
		$output .= '<ul class="meta__content-list">';
		foreach ( $content as $user_id ) {
			$user = get_userdata( $user_id );
			if ( $user ) {
				$output .= '<li class="meta__content-item">';
				$output .= sprintf(
					'<div class="user-avatar" style="background-image:%s;"></div><a href="%s">%s</a>',
					get_avatar_url( $user_id ),
					get_author_posts_url( $user->ID ),
					$user->display_name
				);
				$output .= '</li>';
			}
		}
		$output .= '</ul>';

	} elseif ( is_array( $content ) ) {

		// If it's an array of items.
		$output .= $label;
		$output .= '<ul class="meta__content-list">';
		foreach ( $content as $item ) {
			$output .= '<li class="meta__content-item">';
			$link    = mkdo_theme_get_array_path( 'link', $item );
			$title   = mkdo_theme_get_array_path( 'title', $item );
			if ( $link && $title ) {
				$output .= sprintf(
					'<a href="%s">%s</a>',
					$link,
					$title
				);
			} elseif ( is_string( $item ) ) {
				$output .= '<span>' . $item . '</span>';
			}
			$output .= '</li>';
		}
		$output .= '</ul>';

	} else {

		// Else, treat it as HTML.
		if ( mkdo_theme_get_array_path( 'link', $data ) ) {

?>
			<span class="meta__label"><?php echo esc_html( $data['label'] ); ?></span>
			<a class="meta__content" href="<?php echo esc_url( $data['link'] ); ?>">
				<?php echo wp_kses_post( $data['content'] ); ?>
			</a>
<?php
		} else {
?>
			<span class="meta__label"><?php echo esc_html( $data['label'] ); ?></span>
			<span class="meta__content"><?php echo wp_kses_post( $data['content'] ); ?></span>
<?php
		}
	}

	if ( true === $echo ) {
		echo wp_kses_post( $output );
	} else {
		return $output;
	}
}
