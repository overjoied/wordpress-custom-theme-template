<?php
/**
 * Register custom taxonomies.
 *
 * @link https://developer.wordpress.org/reference/functions/register_taxonomy/
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

/**
 * Registers the 'breed' taxonomy for the 'cat' post type.
 */
function register_cat_breed() {

	$labels = array(
		'name'              => _x( 'Breeds', 'Taxonomy General Name', 'custom-theme' ),
		'singular_name'     => _x( 'Breed', 'Taxonomy Singular Name', 'custom-theme' ),
		'search_items'      => __( 'Search Breeds', 'custom-theme' ),
		'popular_items'     => __( 'Popular Breeds', 'custom-theme' ),
		'all_items'         => __( 'All Breeds', 'custom-theme' ),
		'parent_item'       => null,
		'parent_item_colon' => null,
		'edit_item'         => __( 'Edit Breed', 'custom-theme' ),
		'view_item'         => __( 'View Breed', 'custom-theme' ),
		'update_item'       => __( 'Update Breed', 'custom-theme' ),
		'add_new_item'      => __( 'Add Breed', 'custom-theme' ),
		'new_item_name'     => __( 'New Breed Name', 'custom-theme' ),
		'not_found'         => __( 'No breeds found', 'custom-theme' ),
		'no_terms'          => __( 'No breeds', 'custom-theme' ),
		'filter_by_item'    => __( 'Filter by breed', 'custom-theme' ),
		'item_link'         => __( 'Breed Link', 'custom-theme' ),
	);

	$args = array(
		'labels'             => $labels,
		'description'        => '',
		'public'             => true,
		'publicly_queryable' => true,
		'hierarchical'       => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'show_in_nav_menus'  => true,
		'show_in_rest'       => true,
		'show_tagcloud'      => true,
		'show_admin_column'  => true,
		'rewrite'            => array( 'slug' => 'breed' ),
	);

	register_taxonomy( 'breed', 'cat', $args );
}

/**
 * Registers every custom taxonomy.
 */
function register_custom_taxonomies() {
	register_cat_breed();
}
add_action( 'init', __NAMESPACE__ . '\register_custom_taxonomies' );
