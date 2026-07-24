<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function custom_theme_body_classes( $classes ) {

	// Helps detect if JS is enabled or not.
	$classes[] = 'no-js';

	// Adds `singular` to singular pages, and `hfeed` to all other pages.
	$classes[] = is_singular() ? 'singular' : 'hfeed';

	// Add a body class if main navigation is active.
	if ( has_nav_menu( 'primary' ) ) {
		$classes[] = 'has-main-navigation';
	}

	// Add a body class if there are no footer widgets.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-widgets';
	}

	return $classes;
}
add_filter( 'body_class', __NAMESPACE__ . '\custom_theme_body_classes' );

/**
 * Adds custom class to the array of posts classes.
 *
 * @param array $classes An array of CSS classes.
 * @return array
 */
function custom_theme_post_classes( $classes ) {
	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', __NAMESPACE__ . '\custom_theme_post_classes', 10, 3 );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 *
 * @return void
 */
function custom_theme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', __NAMESPACE__ . '\custom_theme_pingback_header' );

/**
 * Determines if post thumbnail can be displayed.
 *
 * @return bool
 */
function custom_theme_can_show_post_thumbnail() {
	/**
	 * Filters whether post thumbnail can be displayed.
	 *
	 * @param bool $show_post_thumbnail Whether to show post thumbnail.
	 */
	return apply_filters(
		'custom_theme_can_show_post_thumbnail',
		! post_password_required() && ! is_attachment() && has_post_thumbnail()
	);
}

/**
 * Creates continue reading text.
 */
function custom_theme_continue_reading_text() {
	$continue_reading = sprintf(
		/* translators: %s: Post title. Only visible to screen readers. */
		esc_html__( 'Continue reading %s', 'custom-theme' ),
		the_title( '<span class="screen-reader-text">', '</span>', false )
	);

	return $continue_reading;
}

/**
 * Retrieves theme settings, fetched once per request.
 *
 * @return array
 */
function get_theme_settings() {
	static $settings;

	if ( null === $settings ) {
		$settings = get_option( 'theme-settings', array() );
	}

	return $settings;
}

/**
 * Append the custom code in the <head>.
 */
function head_custom_code() {
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Intentional raw output; only editable by manage_options-capable admins via the Theme Settings page.
	echo get_theme_settings()['head'] ?? '';
}
add_action( 'wp_head', __NAMESPACE__ . '\head_custom_code' );

/**
 * Append the custom code after the opening <body> tag.
 */
function body_custom_code() {
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Intentional raw output; only editable by manage_options-capable admins via the Theme Settings page.
	echo get_theme_settings()['body'] ?? '';
}
add_action( 'wp_body_open', __NAMESPACE__ . '\body_custom_code' );

/**
 * Append the custom code after the <footer>.
 */
function footer_custom_code() {
	// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Intentional raw output; only editable by manage_options-capable admins via the Theme Settings page.
	echo get_theme_settings()['footer'] ?? '';
}
add_action( 'wp_footer', __NAMESPACE__ . '\footer_custom_code' );

/**
 * Filters enqueued stylesheets.
 *
 * @param string $html   HTML markup for the stylesheet link.
 * @param string $handle Style handle.
 * @param string $href   Stylesheet URL.
 * @param string $media  Media attribute.
 * @return string
 */
function filter_stylesheet( $html, $handle, $href, $media ) {
	global $deferred_styles;

	if ( in_array( $handle, $deferred_styles, true ) ) {
		$html = '<link rel="preload" href="' . $href . '" as="style" id="' . $handle . '" media="' . $media . '" onload="this.onload=null;this.rel=\'stylesheet\'">'
			. '<noscript>' . $html . '</noscript>';
	}

	return $html;
}
add_filter( 'style_loader_tag', __NAMESPACE__ . '\filter_stylesheet', 10, 4 );
