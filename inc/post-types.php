<?php
/**
 * Register custom post types.
 *
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 * @link https://developer.wordpress.org/reference/functions/get_post_type_labels/
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

/**
 * Config for all custom post types. Add an entry to register a new one —
 * WordPress derives the full labels set (add_new_item, edit_item, not_found,
 * menu_name, etc.) from just 'singular'/'plural', so only differences from
 * the defaults below need to be listed here.
 */
const CUSTOM_POST_TYPES = array(
  'cat' => array(
    'singular'    => 'Cat',
    'plural'      => 'Cats',
    'description' => 'A collection of cats.',
    'menu_icon'   => 'dashicons-schedule',
    'menu_position' => 5,
  ),
);

/**
 * Registers a single custom post type from a minimal config.
 *
 * @param string $slug   The post type slug.
 * @param array  $config Must include 'singular' and 'plural'; any other
 *                        register_post_type() arg may be added/overridden.
 */
function register_custom_post_type( $slug, $config ) {
  if ( isset( $config['description'] ) ) {
    $config['description'] = __( $config['description'], TEXT_DOMAIN );
  }

  $args = wp_parse_args(
    array_diff_key( $config, array_flip( array( 'singular', 'plural' ) ) ),
    array(
      'public'              => false,
      'hierarchical'        => false,
      'exclude_from_search' => true,
      'publicly_queryable'  => false,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'show_in_nav_menus'   => true,
      'show_in_admin_bar'   => true,
      'show_in_rest'        => true,
      'capability_type'     => 'post',
      'supports'            => array( 'title', 'custom-fields' ),
      'has_archive'         => false,
      'can_export'          => true,
    )
  );

  $args['label']  = __( $config['plural'], TEXT_DOMAIN );
  $args['labels'] = array(
    'name'          => __( $config['plural'], TEXT_DOMAIN ),
    'singular_name' => __( $config['singular'], TEXT_DOMAIN ),
  );

  register_post_type( $slug, $args );
}

/**
 * Registers every post type listed in CUSTOM_POST_TYPES.
 */
function register_custom_post_types() {
  foreach ( CUSTOM_POST_TYPES as $slug => $config ) {
    register_custom_post_type( $slug, $config );
  }
}
add_action( 'init', __NAMESPACE__ . '\register_custom_post_types' );
