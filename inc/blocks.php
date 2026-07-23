<?php
/**
 * Custom Gutenberg Blocks
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

/**
 * Registers blocks using a `blocks-manifest.php` file, which improves the performance of block type registration.
 * Behind the scenes, it also registers all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function register_blocks() {
	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
	 * based on the registered block metadata.
	 * Added in WordPress 6.8 to simplify the block metadata registration process added in WordPress 6.7.
	 *
	 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
	 */
    if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( get_build_directory() . '/blocks', get_build_directory() . '/blocks/blocks-manifest.php' );
		return;
	}

	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` file.
	 * Added to WordPress 6.7 to improve the performance of block type registration.
	 *
	 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
	 */
	if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
		wp_register_block_metadata_collection( get_build_directory() . '/blocks', get_build_directory() . '/blocks/blocks-manifest.php' );
	}

	/**
	 * Registers the block type(s) in the `blocks-manifest.php` file.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	$manifest_data = require get_build_directory() . '/blocks/blocks-manifest.php';
	foreach ( array_keys( $manifest_data ) as $block_type ) {
		register_block_type( get_build_directory() . "/blocks/{$block_type}" );
	}
}
add_action( 'init', __NAMESPACE__ . '\register_blocks' );

/**
 * Defines a custom blocks' editor category.
 */
function add_custom_block_category( $categories, $post ) {
  $custom_category = array(
    'slug'  => 'custom',
    'title' => __( 'Custom', 'wp-block-theme-boilerplate' ),
  );

  $categories = array_merge( $categories, array( $custom_category ) );

  return $categories;
}
add_filter( 'block_categories_all', __NAMESPACE__ . '\add_custom_block_category', 10, 2 );

/**
 * Enqueue custom block additional assets.
 *
 * @param string $block_content The normal block HTML that would be sent to the screen.
 * @param array  $block         An array of data about the block, and the way the user configured it.
 */
function enqueue_custom_block_styles() {
  if ( is_admin() ) {
    return;
  }

  $blocks = array_keys(
    array_filter(
      \WP_Block_Type_Registry::get_instance()->get_all_registered(),
      fn( $block ): bool => explode( '/', $block->name )[0] === TEXT_DOMAIN
    )
  );

  foreach ( $blocks as $block_name ) {
    if ( page_has_block( $block_name ) ) {

      // Conditionally enqueue the styles and scripts of the components used in a specific block.
      // if ( $block_name === 'custom-theme/block-name' ) {
      //   enqueue_assets('components', 'component-name');
      // }
    }
  }
}
add_action( 'enqueue_block_assets', __NAMESPACE__ . '\enqueue_custom_block_styles', 10, 2 );

/**
 * Collects the names of blocks rendered in the active sidebar widget area for
 * the current page, once per request.
 *
 * @return string[]
 */
function get_sidebar_block_names() {
  static $block_names = null;

  if ( null !== $block_names ) {
    return $block_names;
  }

  $block_names = array();

  foreach ( get_custom_sidebars() as $sidebar ) {
    if ( ! is_page_template( $sidebar['template'] ) || ! is_active_sidebar( $sidebar['id'] ) ) {
      continue;
    }

    $widgets       = wp_get_sidebars_widgets();
    $block_widgets = get_option( 'widget_block' );

    foreach ( $widgets[ $sidebar['id'] ] as $widget ) {
      $widget_id = str_replace( 'block-', '', $widget );
      $block     = parse_blocks( $block_widgets[ $widget_id ]['content'] ?? '' );

      if ( ! empty( $block ) ) {
        $block_names[] = $block[0]['blockName'];
      }
    }

    break;
  }

  return $block_names;
}

/**
 * Checks if the page has rendered the given block.
 *
 * @param string $block_name The block's name.
 */
function page_has_block( $block_name ) {
  return has_block( $block_name ) || in_array( $block_name, get_sidebar_block_names(), true );
}

/**
 * Disables inline styles.
 */
add_filter( 'styles_inline_size_limit', '__return_zero' );