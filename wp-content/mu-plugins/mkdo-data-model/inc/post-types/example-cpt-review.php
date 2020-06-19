<?php
/**
 * CPT: Review.
 *
 * @package MKDO\Data_Model
 *
 * @link http://aristath.github.io/kirki/docs/controls/
 */

$review_labels = [
	'name'                  => _x( 'Reviews', 'Post Type General Name', 'mkdo-data-model' ),
	'singular_name'         => _x( 'Review', 'Post Type Singular Name', 'mkdo-data-model' ),
	'menu_name'             => __( 'Reviews', 'mkdo-data-model' ),
	'name_admin_bar'        => __( 'Reviews', 'mkdo-data-model' ),
	'archives'              => __( 'Review Archives', 'mkdo-data-model' ),
	'attributes'            => __( 'Review Attributes', 'mkdo-data-model' ),
	'parent_item_colon'     => __( 'Parent Review:', 'mkdo-data-model' ),
	'all_items'             => __( 'All Reviews', 'mkdo-data-model' ),
	'add_new_item'          => __( 'Add New Review', 'mkdo-data-model' ),
	'add_new'               => __( 'Add New Review', 'mkdo-data-model' ),
	'new_item'              => __( 'New Review', 'mkdo-data-model' ),
	'edit_item'             => __( 'Edit Review', 'mkdo-data-model' ),
	'update_item'           => __( 'Update Review', 'mkdo-data-model' ),
	'view_item'             => __( 'View Review', 'mkdo-data-model' ),
	'view_items'            => __( 'View Reviews', 'mkdo-data-model' ),
	'search_items'          => __( 'Search Reviews', 'mkdo-data-model' ),
	'not_found'             => __( 'Not found', 'mkdo-data-model' ),
	'not_found_in_trash'    => __( 'Not found in Trash', 'mkdo-data-model' ),
	'featured_image'        => __( 'Featured Image', 'mkdo-data-model' ),
	'set_featured_image'    => __( 'Set featured image', 'mkdo-data-model' ),
	'remove_featured_image' => __( 'Remove featured image', 'mkdo-data-model' ),
	'use_featured_image'    => __( 'Use as featured image', 'mkdo-data-model' ),
	'insert_into_item'      => __( 'Insert into Review', 'mkdo-data-model' ),
	'uploaded_to_this_item' => __( 'Uploaded to this Review', 'mkdo-data-model' ),
	'items_list'            => __( 'Review list', 'mkdo-data-model' ),
	'items_list_navigation' => __( 'Review list navigation', 'mkdo-data-model' ),
	'filter_items_list'     => __( 'Filter Review list', 'mkdo-data-model' ),
];

$review_args = [
	'label'               => __( 'Reviews', 'mkdo-data-model' ),
	'description'         => __( 'Custom Post Type for Review', 'mkdo-data-model' ),
	'labels'              => $review_labels,
	'supports'            => [
		'title',
		'editor',
		'revisions',
		'thumbnail',
	],
	'hierarchical'        => false,
	'public'              => true,
	'show_ui'             => true,
	'show_in_menu'        => true,
	'menu_position'       => 20,
	'menu_icon'           => 'dashicons-thumbs-up',
	'show_in_admin_bar'   => true,
	'show_in_nav_menus'   => true,
	'show_in_rest'        => true,
	'can_export'          => true,
	'has_archive'         => true,
	'exclude_from_search' => false,
	'publicly_queryable'  => true,
	'capability_type'     => 'post',
	'taxonomies'          => [ 'review_category' ],
	'rewrite'             => [
		'with_front' => false,
		'slug'       => _x( 'reviews', 'Reviews URL', 'mkdo-data-model' ),
	],
];

register_post_type( 'review', $review_args );
