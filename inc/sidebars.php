<?php
/**
 * Register custom sidebars.
 *
 * @link https://developer.wordpress.org/reference/functions/register_post_type/
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

/**
 * Returns the theme's custom sidebars, each paired with the page template
 * that displays it. Single source of truth for registration, sidebar
 * detection, and block detection.
 */
function get_custom_sidebars() {
	return array(
		array(
			'name'     => 'Custom Sidebar 1',
			'id'       => 'custom-sidebar-1',
			'template' => 'templates/left-sidebar.php',
		),
		array(
			'name'     => 'Custom Sidebar 2',
			'id'       => 'custom-sidebar-2',
			'template' => 'templates/right-sidebar.php',
		),
	);
}

/**
 * Registers every custom sidebar returned by get_custom_sidebars().
 */
function register_custom_sidebars() {
	// phpcs:disable WordPress.WP.I18n.NonSingularStringLiteralText -- Labels are intentionally sourced from get_custom_sidebars(), so they can't be static string literals.
	foreach ( get_custom_sidebars() as $sidebar ) {
		register_sidebar(
			array(
				'name'          => __( $sidebar['name'], 'custom-theme' ),
				'id'            => $sidebar['id'],
				'description'   => __( 'Widgets in this area will appear in ' . $sidebar['name'] . '.', 'custom-theme' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
	// phpcs:enable WordPress.WP.I18n.NonSingularStringLiteralText
}
add_action( 'widgets_init', __NAMESPACE__ . '\register_custom_sidebars' );
