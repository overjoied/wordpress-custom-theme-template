<?php
/**
 * Helper functions
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

/**
 * Retrieves template directory build URI for the active theme.
 */
function get_build_directory_uri() {
	return get_template_directory_uri() . '/build';
}

/**
 * Retrieves template directory build path for the active theme.
 */
function get_build_directory() {
	return get_template_directory() . '/build';
}

/**
 * Enqueues styles and scripts.
 *
 * @param string $type      The type of asset to enqueue.
 * @param string $name      Filenames of the assets to enqueue. Applicable only to
 *                          component and layout types.
 * @param bool   $in_footer Whether to print the script in the footer.
 * @param bool   $defer_css Whether to defer the stylesheet.
 * @param bool   $defer_js  Whether to defer the script or load it asynchronously.
 */
function enqueue_assets( $type = 'main', $name = '', $in_footer = true, $defer_css = true, $defer_js = true ) {
	global $deferred_styles;

	$allowed_types = array( 'admin', 'editor', 'main', 'components', 'layout' );

	if ( ! in_array( $type, $allowed_types, true ) ) {
		return;
	}

	$has_subdir = in_array( $type, array( 'components', 'layout' ), true );
	$path       = 'main' === $type ? 'main' : ( $has_subdir ? "{$type}/{$name}/{$name}" : "{$type}/{$type}" );
	$handle     = 'custom-theme-' . $type . ( $has_subdir ? "-{$name}" : '' );

	// Enqueue CSS.
	// We won't enqueue styles for the editor since it is already added thru add_editor_style().
	if ( 'editor' !== $type ) {
		\CustomTheme\enqueue_style(
			$handle,
			$path,
			array(),
			_S_VERSION
		);

		if ( $defer_css ) {
			$deferred_styles[] = $handle;
		}
	}

	// Enqueue JS.
	\CustomTheme\enqueue_script(
		$handle,
		$path,
		array(),
		_S_VERSION,
		$defer_js,
		$in_footer
	);
}

/**
 * Checks whether a build file exists, caching the filesystem lookup for the
 * remainder of the request since build output never changes mid-request.
 *
 * @param string $file Path to the build file.
 * @return bool
 */
function build_file_exists( string $file ): bool {
	static $cache = array();

	if ( ! array_key_exists( $file, $cache ) ) {
		$cache[ $file ] = file_exists( $file );
	}

	return $cache[ $file ];
}

/**
 * Enqueues a script.
 *
 * @param string $handle    Script handle.
 * @param string $path      Path to the build file.
 * @param array  $depth     Script dependencies.
 * @param string $version   Version string.
 * @param bool   $defer     Whether to defer or async the script.
 * @param bool   $in_footer Whether to print the script in the footer.
 */
function enqueue_script( string $handle, string $path, array $depth, string $version, bool $defer = true, bool $in_footer = false ) {
	if ( build_file_exists( get_build_directory() . "/{$path}.js" ) ) {
		$src  = get_build_directory_uri() . "/{$path}.js";
		$args = array(
			'strategy'  => $defer ? 'defer' : 'async',
			'in_footer' => $in_footer,
		);

		wp_enqueue_script( $handle, $src, $depth, $version, $args );
	}
}

/**
 * Enqueues a CSS stylesheet.
 *
 * @param string $handle  Style handle.
 * @param string $path    Path to the build file.
 * @param array  $depth   Style dependencies.
 * @param string $version Version string.
 * @param string $media   Media attribute.
 */
function enqueue_style( string $handle, string $path, array $depth, string $version, string $media = 'all' ) {
	if ( build_file_exists( get_build_directory() . "/{$path}.css" ) ) {
		$src = get_build_directory_uri() . "/{$path}.css";

		wp_enqueue_style( $handle, $src, $depth, $version, $media );
	}
}

/**
 * Checks if the current page has a sidebar.
 *
 * @return boolean
 */
function has_sidebar() {
	return is_page_template( wp_list_pluck( get_custom_sidebars(), 'template' ) );
}

/**
 * Generates an SVG icon element.
 *
 * @param string $icon    The filename of the icon without the extension.
 * @param array  $classes The list of classes to add in array format.
 *
 * @return string
 */
function get_icon( $icon, $classes = array() ) {
	$class_str   = '';
	$sprite_path = \CustomTheme\get_build_directory_uri() . '/assets/svg/sprite.svg';

	// If $classes are passed, add the classes to the SVG class.
	if ( count( $classes ) ) {
		$class_str .= ' ' . join( ' ', $classes );
	}

	return (
		"<svg class='icon" . $class_str . "'>" .
			"<use xlink:href='" . ( $sprite_path . '#' . $icon ) . "'></use>" .
		'</svg>'
	);
}
