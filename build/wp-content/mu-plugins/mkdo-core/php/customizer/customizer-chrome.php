<?php
/**
 * Customizer: Contact.
 *
 * @package MKDO_Core
 *
 * @link http://aristath.github.io/kirki/docs/controls/
 */

$mkdo_core_section_id = $this->plugin_prefix . 'chrome';

// Section.
\Kirki::add_section(
	$mkdo_core_section_id,
	array(
		'title'    => __( 'Chrome Colour', 'mkdo-core' ),
		'panel'    => $this->plugin_prefix . 'panel',
		'priority' => 10,
	)
);

// Fields.
\Kirki::add_field(
	$config_id,
	array(
		'type'     => 'color',
		'settings' => $mkdo_core_section_id . '_chrome',
		'label'    => __( 'Chrome Theme Colour', 'mkdo-core' ),
		'section'  => $mkdo_core_section_id,
		'priority' => 10,
	)
);
