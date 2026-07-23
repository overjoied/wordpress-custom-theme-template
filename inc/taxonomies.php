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

function register_cat_breed() {

  $labels = array(
    'name'              => _x( 'Breeds', 'Taxonomy General Name', TEXT_DOMAIN ),
    'singular_name'     => _x( 'Breed', 'Taxonomy Singular Name', TEXT_DOMAIN ),
    'search_items'      => __( 'Search Breeds', TEXT_DOMAIN ),
    'popular_items'     => __( 'Popular Breeds', TEXT_DOMAIN ),
    'all_items'         => __( 'All Breeds', TEXT_DOMAIN ),
    'parent_item'       => null,
    'parent_item_colon' => null,
    'edit_item'         => __( 'Edit Breed', TEXT_DOMAIN ),
    'view_item'         => __( 'View Breed', TEXT_DOMAIN ),
    'update_item'       => __( 'Update Breed', TEXT_DOMAIN ),
    'add_new_item'      => __( 'Add Breed', TEXT_DOMAIN ),
    'new_item_name'     => __( 'New Breed Name', TEXT_DOMAIN ),
    'not_found'         => __( 'No breeds found', TEXT_DOMAIN ),
    'no_terms'          => __( 'No breeds', TEXT_DOMAIN ),
    'filter_by_item'    => __( 'Filter by breed', TEXT_DOMAIN ),
    'item_link'         => __( 'Breed Link', TEXT_DOMAIN ),
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

function register_custom_taxonomies() {
  register_cat_breed();
}
add_action( 'init', __NAMESPACE__ . '\register_custom_taxonomies' );