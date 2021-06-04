<?php
/**
 * Custom entry content for this theme.
 *
 * @package MKDO_Theme
 */

/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function mkdo_theme_entry_info() {
	$time_string = '<time class="published dt-published" datetime="%1$s">%2$s</time>';

	$time_string = sprintf(
		$time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$posted_on = sprintf(
		/* translators:  1: date the post was published. */
		esc_html_x( 'Posted on %s', 'post date', 'mkdo-theme' ),
		'<a class="u-url" href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		/* translators:  1: author of the post. */
		esc_html_x( 'by %s', 'post author', 'mkdo-theme' ),
		'<span class="author vcard h-card p-author"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<p><span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span></p>'; // phpcs:ignore WordPress.Security.EscapeOutput
}

/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function mkdo_theme_entry_meta() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		$categories_list = get_the_category_list( esc_html__( ', ', 'mkdo-theme' ) );
		$tags_list       = get_the_tag_list( '', esc_html__( ', ', 'mkdo-theme' ) );

		if ( $categories_list && mkdo_theme_categorized_blog() || $tags_list ) {
			echo '<p>';
		}

		if ( $categories_list && mkdo_theme_categorized_blog() ) {
			printf( /* Translators: used between list items, there is a space after the comma. */
			'<span class="cat-links p-category">' . esc_html__( 'Posted in %1$s', 'mkdo-theme' ) . '</span>',
				wp_kses_post( $categories_list )
				); // phpcs:ignore WordPress.Security.EscapeOutput
		}

		if ( $tags_list ) {
			printf( /* Translators: used between list items, there is a space after the comma. */
			'<span class="tags-links p-category">' . esc_html__( 'Tagged %1$s', 'mkdo-theme' ) . '</span>',
				wp_kses_post( $tags_list )
				); // phpcs:ignore WordPress.Security.EscapeOutput
		}

		if ( $categories_list && mkdo_theme_categorized_blog() || $tags_list ) {
			echo '</p>';
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<p><span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'mkdo-theme' ), esc_html__( '1 Comment', 'mkdo-theme' ), esc_html__( '% Comments', 'mkdo-theme' ) );
		echo '</span></p>';
	}

	if ( get_edit_post_link() ) {
		edit_post_link( esc_html__( 'Edit', 'mkdo-theme' ), '<span class="edit-link">', '</span>' );
	}
}
