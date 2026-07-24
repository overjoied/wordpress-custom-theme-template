<?php
/**
 * Functions and filters related to the menus.
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

/**
 * Appends a checkbox (is_cta) in the current menu item's settings.
 *
 * @param string         $item_id   The ID of the menu item.
 * @param \WP_Post      $menu_item The data object of the menu item.
 * @param int            $depth     The depth of the menu item.
 * @param \stdClass|null $args      An object of menu item arguments.
 */
function add_is_cta_checkbox( $item_id, $menu_item, $depth, $args ) {
	$is_cta = get_post_meta( $item_id, '_menu_item_is_cta', true );
?>

	<p class="field-cta description description-wide">
		<label for="edit-menu-item-is-cta-<?php echo esc_attr( $item_id ); ?>">
			<input
				type="checkbox"
				id="edit-menu-item-is-cta-<?php echo esc_attr( $item_id ); ?>"
				name="menu-item-is-cta[<?php echo esc_attr( $item_id ); ?>]"
				value="1"
				<?php checked( $is_cta, '1' ); ?>
			/>
			<?php esc_html_e( 'Make this a CTA button', TEXT_DOMAIN ); ?>
		</label>
	</p>

<?php
}
add_action( 'wp_nav_menu_item_custom_fields', __NAMESPACE__ . '\add_is_cta_checkbox', 10, 4 );

/**
 * Updates or deletes the _menu_item_is_cta meta for the current menu item.
 *
 * @param int $menu_id         The ID of the menu.
 * @param int $menu_item_db_id The ID of the menu item.
 */
function update_is_cta_meta( $menu_id, $menu_item_db_id ) {
	// phpcs:ignore WordPress.Security.NonceVerification.Missing -- This hook only fires from WP core's own nav-menu save handler, which already verifies its own nonce before calling it.
	if ( isset( $_POST['menu-item-is-cta'][ $menu_item_db_id ] ) ) {
		update_post_meta( $menu_item_db_id, '_menu_item_is_cta', '1' );
	} else {
		delete_post_meta( $menu_item_db_id, '_menu_item_is_cta' );
	}
}
add_action( 'wp_update_nav_menu_item', __NAMESPACE__ . '\update_is_cta_meta', 10, 2 );