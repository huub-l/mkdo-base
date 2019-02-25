<?php
/**
 * Customizer: Contact.
 *
 * @package MKDO_Core
 *
 * @link http://aristath.github.io/kirki/docs/controls/
 */

$mkdo_core_section_id = $this->plugin_prefix . 'contact';

// Section.
\Kirki::add_section(
	$mkdo_core_section_id,
	array(
		'title'       => __( 'Contact Details', 'mkdo-core' ),
		'description' => __( 'Contact details used across the site.', 'mkdo-core' ),
		'panel'       => $this->plugin_prefix . 'panel',
		'priority'    => 10,
	)
);

// Fields.
\Kirki::add_field(
	$config_id,
	array(
		'type'     => 'text',
		'settings' => $mkdo_core_section_id . '_telephone',
		'label'    => __( 'Telephone Number', 'mkdo-core' ),
		'section'  => $mkdo_core_section_id,
		'priority' => 10,
	)
);
