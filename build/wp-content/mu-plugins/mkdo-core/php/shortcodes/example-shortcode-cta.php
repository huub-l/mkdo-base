<?php
/**
 * Shortcode: CTA
 *
 * @package MKDO_Core
 */

$mkdo_core_shortcode_id = 'cta';

// Render the shortcode.
// NOTE: Anonymous function is being used here as a workaround
// because we are no longer registering a class per shortcode.
add_shortcode(
	$mkdo_core_shortcode_id,
	function( $attr, $content = '' ) {

		// To please WPCS!
		$content = $content;

		$attr = wp_parse_args(
			$attr,
			array(
				'title'   => '',
				'content' => '',
			)
		);

		ob_start();
		include Helper::render_view( 'view-shortcode-' . $mkdo_core_shortcode_id );
		return ob_get_clean();
	}
);

// Make sure this variable is unique for each shortcode's fields.
$mkdo_core_cta_fields = array();

$mkdo_core_cta_fields[] = array(
	'label'       => __( 'Title', 'mkdo-core' ),
	'description' => __( 'The content for this shortcode.', 'mkdo-core' ),
	'attr'        => 'title',
	'type'        => 'text',
);

$mkdo_core_cta_fields[] = array(
	'label'       => __( 'Content', 'mkdo-core' ),
	'description' => __( 'The content for this shortcode.', 'mkdo-core' ),
	'attr'        => 'content',
	'type'        => 'textarea',
	'encode'      => true,
	'meta'        => array(
		'class' => 'shortcake-richtext',
	),
);

// Register the UI for the Shortcode.
// Supported field types: text, checkbox, textarea, radio, select, email, url, number, and date.
shortcode_ui_register_for_shortcode(
	$mkdo_core_shortcode_id,
	array(
		'label'         => __( 'CTA', 'mkdo-core' ),
		'listItemImage' => 'dashicons-megaphone',
		'post_type'     => get_post_types(),
		'attrs'         => $mkdo_core_cta_fields,
	)
);
