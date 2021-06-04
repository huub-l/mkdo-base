<?php
/**
 * Meta: Hero.
 *
 * @package MKDO\Data_Model
 *
 * @link http://aristath.github.io/kirki/docs/controls/
 */

$cmb = new_cmb2_box(
	[
		'id'           => PREFIX . '_hero',
		'title'        => __( 'Hero Meta', 'mkdo-data-model' ),
		'object_types' => [
			'post',
		],
		'priority'     => 'high',
		'context'      => 'advanced',
		'show_names'   => true,
	]
);

$cmb->add_field(
	[
		'name' => __( 'Title', 'mkdo-data-model' ),
		'id'   => PREFIX . '_hero_title',
		'type' => 'text',
	]
);

$cmb->add_field(
	[
		'name'    => __( 'Content', 'mkdo-data-model' ),
		'id'      => PREFIX . '_hero_content',
		'type'    => 'wysiwyg',
		'options' => [
			'media_buttons' => false,
			'textarea_rows' => 5,
			'quicktags'     => [
				'buttons' => 'strong,em,link,close',
			],
			'tinymce'       => [
				'toolbar1' => 'bold, italic, link',
				'toolbar2' => '',
			],
		],
	]
);
