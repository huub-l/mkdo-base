<?php
/**
 * Tax: Review Category.
 *
 * @package MKDO_Core
 *
 * @link http://aristath.github.io/kirki/docs/controls/
 */

// Unique variable name.
$mkdo_core_category_labels = array(
	'name'                  => __( 'Categories', 'mkdo-core' ),
	'singular_name'         => __( 'Category', 'mkdo-core' ),
	'search_items'          => __( 'Search Categories', 'mkdo-core' ),
	'popular_items'         => __( 'Popular Categories', 'mkdo-core' ),
	'all_items'             => __( 'All Categories', 'mkdo-core' ),
	'parent_item'           => __( 'Parent Category', 'mkdo-core' ),
	'parent_item_colon'     => __( 'Parent Category', 'mkdo-core' ),
	'edit_item'             => __( 'Edit Category', 'mkdo-core' ),
	'update_item'           => __( 'Update Category', 'mkdo-core' ),
	'add_new_item'          => __( 'Add New Category', 'mkdo-core' ),
	'new_item_name'         => __( 'New Category Name', 'mkdo-core' ),
	'add_or_remove_items'   => __( 'Add or remove Categories', 'mkdo-core' ),
	'choose_from_most_used' => __( 'Choose from most used', 'mkdo-core' ),
	'menu_name'             => __( 'Categories', 'mkdo-core' ),
);

// Unique variable name.
$mkdo_core_category_args = array(
	'labels'            => $review_category_labels,
	'public'            => true,
	'show_in_nav_menus' => false,
	'show_admin_column' => false,
	'hierarchical'      => true,
	'show_tagcloud'     => false,
	'show_ui'           => true,
	'query_var'         => true,
	'capabilities'      => array(),
	'rewrite'           => true,
);

register_taxonomy( 'review_category', 'review', $mkdo_core_category_args );
