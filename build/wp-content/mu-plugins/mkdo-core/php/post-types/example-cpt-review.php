<?php
/**
 * CPT: Review.
 *
 * @package MKDO_Core
 *
 * @link http://aristath.github.io/kirki/docs/controls/
 */

// Unique variable name.
$mkdo_core_review_labels = array(
	'name'                  => _x( 'Reviews', 'Post Type General Name', 'mkdo-core' ),
	'singular_name'         => _x( 'Review', 'Post Type Singular Name', 'mkdo-core' ),
	'menu_name'             => __( 'Reviews', 'mkdo-core' ),
	'name_admin_bar'        => __( 'Reviews', 'mkdo-core' ),
	'archives'              => __( 'Review Archives', 'mkdo-core' ),
	'attributes'            => __( 'Review Attributes', 'mkdo-core' ),
	'parent_item_colon'     => __( 'Parent Review:', 'mkdo-core' ),
	'all_items'             => __( 'All Reviews', 'mkdo-core' ),
	'add_new_item'          => __( 'Add New Review', 'mkdo-core' ),
	'add_new'               => __( 'Add New Review', 'mkdo-core' ),
	'new_item'              => __( 'New Review', 'mkdo-core' ),
	'edit_item'             => __( 'Edit Review', 'mkdo-core' ),
	'update_item'           => __( 'Update Review', 'mkdo-core' ),
	'view_item'             => __( 'View Review', 'mkdo-core' ),
	'view_items'            => __( 'View Reviews', 'mkdo-core' ),
	'search_items'          => __( 'Search Reviews', 'mkdo-core' ),
	'not_found'             => __( 'Not found', 'mkdo-core' ),
	'not_found_in_trash'    => __( 'Not found in Trash', 'mkdo-core' ),
	'featured_image'        => __( 'Featured Image', 'mkdo-core' ),
	'set_featured_image'    => __( 'Set featured image', 'mkdo-core' ),
	'remove_featured_image' => __( 'Remove featured image', 'mkdo-core' ),
	'use_featured_image'    => __( 'Use as featured image', 'mkdo-core' ),
	'insert_into_item'      => __( 'Insert into Review', 'mkdo-core' ),
	'uploaded_to_this_item' => __( 'Uploaded to this Review', 'mkdo-core' ),
	'items_list'            => __( 'Review list', 'mkdo-core' ),
	'items_list_navigation' => __( 'Review list navigation', 'mkdo-core' ),
	'filter_items_list'     => __( 'Filter Review list', 'mkdo-core' ),
);

// Unique variable name.
$mkdo_core_review_args = array(
	'label'               => __( 'Reviews', 'mkdo-core' ),
	'description'         => __( 'Custom Post Type for Review', 'mkdo-core' ),
	'labels'              => $review_labels,
	'supports'            => array(
		'title',
		'editor',
		'revisions',
		'thumbnail',
	),
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
	'taxonomies'          => array( 'review_category' ),
	'rewrite'             => array(
		'with_front' => false,
		'slug'       => _x( 'reviews', 'Reviews URL', 'mkdo-core' ),
	),
);

register_post_type( 'review', $mkdo_core_review_args );
