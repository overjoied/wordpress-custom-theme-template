<?php
/**
 * SCF (Secure Custom Fields) local JSON configuration.
 *
 * ACF-powered blocks (e.g. src/blocks/hero) are registered the same way as
 * every other block — via block.json + register_blocks() in inc/blocks.php —
 * the "acf" key in their block.json is what tells SCF to drive the block's
 * edit UI from fields instead of an editorScript.
 *
 * Field groups for those blocks are defined as local JSON files under
 * /acf-json, not registered in PHP. SCF auto-loads field groups from that
 * folder and auto-saves back to it whenever a field group is edited via
 * wp-admin, so the JSON files stay the source of truth in version control.
 *
 * @link https://www.advancedcustomfields.com/resources/local-json/
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

/**
 * Points SCF's local JSON save path at the theme's /acf-json folder.
 */
function acf_json_save_point() {
	return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', __NAMESPACE__ . '\acf_json_save_point' );

/**
 * Points SCF's local JSON load path at the theme's /acf-json folder.
 *
 * @param array $paths Existing ACF JSON load paths.
 * @return array Modified ACF JSON load paths.
 */
function acf_json_load_point( array $paths ): array {
	unset( $paths[0] );

	$paths[] = get_stylesheet_directory() . '/acf-json';

	return $paths;
}
add_filter( 'acf/settings/load_json', __NAMESPACE__ . '\acf_json_load_point' );

/**
 * Hides the Custom Fields admin UI (menu, field group editor) from anyone
 * who isn't an administrator, now that field groups are built and synced via
 * local JSON above — prevents lower-privilege users from editing them
 * directly in wp-admin.
 */
function hide_acf_admin_ui() {
	if ( function_exists( 'acf_update_setting' ) ) {
		\acf_update_setting( 'show_admin', current_user_can( 'manage_options' ) );
	}
}
add_action( 'acf/init', __NAMESPACE__ . '\hide_acf_admin_ui' );
