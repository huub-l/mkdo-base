<?php
/**
 * Tax: Review Category.
 *
 * @package MKDO\Data_Model
 *
 * @link http://aristath.github.io/kirki/docs/controls/
 */

$category_labels = [
	'name'                  => __( 'Categories', 'mkdo-data-model' ),
	'singular_name'         => __( 'Category', 'mkdo-data-model' ),
	'search_items'          => __( 'Search Categories', 'mkdo-data-model' ),
	'popular_items'         => __( 'Popular Categories', 'mkdo-data-model' ),
	'all_items'             => __( 'All Categories', 'mkdo-data-model' ),
	'parent_item'           => __( 'Parent Category', 'mkdo-data-model' ),
	'parent_item_colon'     => __( 'Parent Category', 'mkdo-data-model' ),
	'edit_item'             => __( 'Edit Category', 'mkdo-data-model' ),
	'update_item'           => __( 'Update Category', 'mkdo-data-model' ),
	'add_new_item'          => __( 'Add New Category', 'mkdo-data-model' ),
	'new_item_name'         => __( 'New Category Name', 'mkdo-data-model' ),
	'add_or_remove_items'   => __( 'Add or remove Categories', 'mkdo-data-model' ),
	'choose_from_most_used' => __( 'Choose from most used', 'mkdo-data-model' ),
	'menu_name'             => __( 'Categories', 'mkdo-data-model' ),
];

$category_args = [
	'labels'            => $review_category_labels,
	'public'            => true,
	'show_in_nav_menus' => false,
	'show_admin_column' => false,
	'hierarchical'      => true,
	'show_tagcloud'     => false,
	'show_ui'           => true,
	'query_var'         => true,
	'capabilities'      => [],
	'rewrite'           => true,
];

register_taxonomy( 'review_category', 'review', $category_args );
