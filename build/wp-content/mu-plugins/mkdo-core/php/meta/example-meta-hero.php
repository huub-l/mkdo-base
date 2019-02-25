<?php
/**
 * Meta: Hero.
 *
 * @package MKDO_Core
 *
 * @link http://aristath.github.io/kirki/docs/controls/
 */

$mkdo_core_cmb = new_cmb2_box(
	array(
		'id'           => $this->plugin_prefix . '_hero',
		'title'        => __( 'Hero Meta', 'mkdo-core' ),
		'object_types' => array(
			'post',
		),
		'priority'     => 'high',
		'context'      => 'advanced',
		'show_names'   => true,
	)
);

$mkdo_core_cmb->add_field(
	array(
		'name' => __( 'Title', 'mkdo-core' ),
		'id'   => $this->plugin_prefix . '_hero_title',
		'type' => 'text',
	)
);

$mkdo_core_cmb->add_field(
	array(
		'name'    => __( 'Content', 'mkdo-core' ),
		'id'      => $this->plugin_prefix . '_hero_content',
		'type'    => 'wysiwyg',
		'options' => array(
			'media_buttons' => false,
			'textarea_rows' => 5,
			'quicktags'     => array(
				'buttons' => 'strong,em,link,close',
			),
			'tinymce'       => array(
				'toolbar1' => 'bold, italic, link',
				'toolbar2' => '',
			),
		),
	)
);
