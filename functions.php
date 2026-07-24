<?php
/**
 * WP Custom Theme Boilerplate functions and definitions
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! defined( 'TEXT_DOMAIN' ) ) {
	// Replace the version number of the theme on each release.
	define( 'TEXT_DOMAIN', 'custom-theme' );
}

global $deferred_styles;
$deferred_styles = [];

if ( ! function_exists( 'custom_theme_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @return void
	 */
    function custom_theme_setup() {
        
		// Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * WordPress will provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 1568, 9999 );

        register_nav_menus(
            array(
                'primary' => __( 'Header Menu', TEXT_DOMAIN),
                'footer'  => __( 'Footer Menu', TEXT_DOMAIN ),
            ),
        );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
        add_theme_support( 'html5', array(
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
            'style',
            'script',
            'navigation-widgets',
        ));

		/*
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		$logo_width  = 300;
		$logo_height = 100;

		add_theme_support(
			'custom-logo',
			array(
				'height'               => $logo_height,
				'width'                => $logo_width,
				'flex-width'           => true,
				'flex-height'          => true,
				'unlink-homepage-logo' => true,
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for editor styles.
	    add_theme_support( "editor-styles" );
	    add_editor_style( \CustomTheme\get_build_directory() . "/editor/editor.css" );


        // remove_theme_support( "core-block-patterns" );
    }
}

add_action('after_setup_theme', 'custom_theme_setup');

/**
 * Load Custom_Theme_Walker_Nav_Menu class.
 */
require get_template_directory() . "/classes/class-custom-theme-walker-nav-menu.php";

/**
 * Load utilities.
 */
require get_template_directory() . "/inc/utilities.php";

/**
 * Load template functions.
 */
require get_template_directory() . "/inc/template-functions.php";

/**
 * Load template tags.
 */
require get_template_directory() . "/inc/template-tags.php";

/**
 * Load menu functions.
 */
require get_template_directory() . "/inc/menu-functions.php";

/**
 * Load custom blocks.
 */
require get_template_directory() . "/inc/blocks.php";

/**
 * Load shortcodes.
 */
require get_template_directory() . "/inc/shortcodes.php";

/**
 * Load custom post types.
 */
require get_template_directory() . "/inc/post-types.php";

/**
 * Load custom taxonomies.
 */
require get_template_directory() . "/inc/taxonomies.php";

/**
 * Load custom sidebars.
 */
require get_template_directory() . "/inc/sidebars.php";

/**
 * Load image sizes.
 */
// require get_template_directory() . "/inc/image-sizes.php";

/**
 * Register Theme Settings.
 */
require get_template_directory() . "/inc/theme-settings.php";

/**
 * Restrict Gutenberg blocks.
 */
function restrict_predefined_blocks( $allowed_block_types ) {
    // get all enabled blocks
    $enabled_blocks = WP_Block_Type_Registry::get_instance()->get_all_registered();

    return array_keys(
        array_filter(
            $enabled_blocks,
            fn( $block ): bool => explode( '/', $block->name )[0] === TEXT_DOMAIN
        )
    );
}
add_filter( 'allowed_block_types_all', 'restrict_predefined_blocks', 10, 2 );

/**
 * Enqueue admin assets.
 */
function enqueue_admin_assets() {
	\CustomTheme\enqueue_assets( 'admin' );
}
add_action( 'admin_enqueue_scripts', 'enqueue_admin_assets' );

/**
 * Enqueue editor assets.
 */
function enqueue_editor_assets() {
	\CustomTheme\enqueue_assets( 'editor' );
}
add_action( 'wp_enqueue_editor', 'enqueue_editor_assets' );

/**
 * Enqueue main assets.
 */
function enqueue_main_assets() {
	\CustomTheme\enqueue_assets( 'main', '', false, false, false);
}
add_action( 'wp_enqueue_scripts', 'enqueue_main_assets' );

/**
 * Enqueue layout assets.
 */
function enqueue_layout_assets() {
  // Header
	\CustomTheme\enqueue_assets( 'layout', 'header', false, false, false );
	
  // Sidebar
  if ( \CustomTheme\has_sidebar() ) {
    \CustomTheme\enqueue_assets( 'layout', 'sidebar' );
  }
	
  // Footer
  \CustomTheme\enqueue_assets( 'layout', 'footer' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_layout_assets' );