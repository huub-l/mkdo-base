<?php
/**
 * Customizer: Contact.
 *
 * @package MKDO\Data_Model
 *
 * @link http://aristath.github.io/kirki/docs/controls/
 */

$section_id = PREFIX . 'contact';

// Section.
\Kirki::add_section(
	$section_id,
	[
		'title'       => __( 'Contact Details', 'mkdo-data-model' ),
		'description' => __( 'Contact details used across the site.', 'mkdo-data-model' ),
		'panel'       => PREFIX . 'panel',
		'priority'    => 10,
	]
);

// Fields.
\Kirki::add_field(
	$config_id,
	[
		'type'     => 'text',
		'settings' => $section_id . '_telephone',
		'label'    => __( 'Telephone Number', 'mkdo-data-model' ),
		'section'  => $section_id,
		'priority' => 10,
	]
);

\Kirki::add_field(
	$config_id,
	[
		'type'     => 'text',
		'settings' => $section_id . '_email',
		'label'    => __( 'Email Address', 'mkdo-data-model' ),
		'section'  => $section_id,
		'priority' => 10,
	]
);

\Kirki::add_field(
	$config_id,
	[
		'type'     => 'text',
		'settings' => $section_id . '_facebook',
		'label'    => __( 'Facebook URL', 'mkdo-data-model' ),
		'section'  => $section_id,
		'priority' => 10,
	]
);

\Kirki::add_field(
	$config_id,
	[
		'type'     => 'text',
		'settings' => $section_id . '_twitter',
		'label'    => __( 'Twitter URL', 'mkdo-data-model' ),
		'section'  => $section_id,
		'priority' => 10,
	]
);

\Kirki::add_field(
	$config_id,
	[
		'type'     => 'text',
		'settings' => $section_id . '_linkedin',
		'label'    => __( 'Linkedin URL', 'mkdo-data-model' ),
		'section'  => $section_id,
		'priority' => 10,
	]
);

\Kirki::add_field(
	$config_id,
	[
		'type'     => 'text',
		'settings' => $section_id . '_instagram',
		'label'    => __( 'Instagram URL', 'mkdo-data-model' ),
		'section'  => $section_id,
		'priority' => 10,
	]
);
