<?php
/**
 * Register custom post types.
 * 
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

// Register Cat.
function register_cat_cpt() {
  $labels = array(
		"name"                     => _x( "Cats", "Post Type General Name", TEXT_DOMAIN ),
		"singular_name"            => _x( "Cat", "Post Type Singular Name", TEXT_DOMAIN ),
		"add_new"                  => __( "Add New", TEXT_DOMAIN ),
		"add_new_item"             => __( "Add New Cat", TEXT_DOMAIN ),
		"edit_item"                => __( "Edit Cat", TEXT_DOMAIN ),
		"new_item"                 => __( "New Cat", TEXT_DOMAIN ),
		"view_item"                => __( "View Cat", TEXT_DOMAIN ),
		"view_items"               => __( "View Cats", TEXT_DOMAIN ),
		"search_items"             => __( "Search Cat", TEXT_DOMAIN ),
		"not_found"                => __( "No cats found", TEXT_DOMAIN ),
		"not_found_in_trash"       => __( "Not cats found in Trash", TEXT_DOMAIN ),
		"parent_item_colon"        => __( "Parent Cat:", TEXT_DOMAIN ),
		"all_items"                => __( "All Cats", TEXT_DOMAIN ),
		"archives"                 => __( "Cat Archives", TEXT_DOMAIN ),
		"attributes"               => __( "Cat Attributes", TEXT_DOMAIN ),
		"insert_into_item"         => __( "Insert into cat", TEXT_DOMAIN ),
		"uploaded_to_this_item"    => __( "Uploaded to this cat", TEXT_DOMAIN ),
		"featured_image"           => __( "Featured Image", TEXT_DOMAIN ),
		"set_featured_image"       => __( "Set featured image", TEXT_DOMAIN ),
		"remove_featured_image"    => __( "Remove featured image", TEXT_DOMAIN ),
		"use_featured_image"       => __( "Use as featured image", TEXT_DOMAIN ),
		"menu_name"                => _x( "Cats", 'Admin Menu text', TEXT_DOMAIN ),
		"name_admin_bar"           => _x( "Cat", 'Admin New on Toolbar', TEXT_DOMAIN ),
		"filter_items_list"        => __( "Filter cats list", TEXT_DOMAIN ),
		"filter_by_date"           => __( "Filter by date", TEXT_DOMAIN ),
		"items_list_navigation"    => __( "Cats list navigation", TEXT_DOMAIN ),
		"items_list"               => __( "Cats list", TEXT_DOMAIN ),
    "item_published"           => __( "Cat published." ),
    "item_published_privately" => __( "Cat published privately." ),
    "item_reverted_to_draft"   => __( "Cat reverted to draft." ),
    "item_trashed"             => __( "Cat trashed." ),
    "item_scheduled"           => __( "Cat scheduled." ),
    "item_updated"             => __( "Cat updated." ),
    "item_link"                => __( "Cat Link." ),
    "item_link_description"    => __( "A link to a cat." ),
  );

  $supported_features = array(
    "title",
    // "editor",
    "custom-fields",
  );

  $args = array(
    "label"               => __( "Cats", TEXT_DOMAIN ),
    "labels"              => $labels,
    "description"         => __( "A collection of cats.", TEXT_DOMAIN ),
    "public"              => false,
    "hierarchical"        => false,
    "exclude_from_search" => true,
    "publicly_queryable"  => false,
    "show_ui"             => true,
    "show_in_menu"        => true,
    "show_in_nav_menus"   => true,
    "show_in_admin_bar"   => true,
    "show_in_rest"        => true,
    "menu_position"       => 5,
    "menu_icon"           => "dashicons-schedule",
    "capability_type"     => "post",
    "supports"            => $supported_features,
    "has_archive"         => false,
    "can_export"          => true,
  );

  register_post_type( 'cat', $args );
}

function register_custom_post_types() {
  register_cat_cpt();
}
add_action( 'init', __NAMESPACE__ . '\register_custom_post_types' );
?>