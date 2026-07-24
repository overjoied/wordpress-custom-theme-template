<?php
/**
 * Custom Walker for Navigation Menu
 *
 * @package CustomTheme
 */

class Custom_Theme_Walker_Nav_Menu extends Walker_Nav_Menu {
	/**
	 * Starts the element output.
	 *
	 * @param string   $output            Used to append additional content (passed by reference).
	 * @param WP_Post  $data_object       Menu item data object.
	 * @param int      $depth             Depth of menu item. Used for padding.
	 * @param stdClass $args              An object of wp_nav_menu() arguments.
	 * @param int      $current_object_id Optional. ID of the current menu item. Default 0.
	 */
	function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$classes = ! empty( $item->classes ) ? ( array ) $item->classes : array();
		$has_children = in_array( 'menu-item-has-children', $classes );
		$is_cta = get_post_meta( $item->ID, '_menu_item_is_cta', true );

		// Define class list
		$li_classes = ['menu-item'];
		if ( $has_children ) $li_classes[] = 'menu-item--is-dropdown';
		if ( $is_cta ) $li_classes[] = 'menu-item--is-cta';

		// Open list item
		$output .= '<li class="' . esc_attr( implode( ' ', $li_classes ) ) . '">';

		// Menu link
		// TODO: Make CTA links look like a button.
		$output .= '<a href="' . esc_url( $item->url ) . '" class="menu-item__link">';
		$output .= esc_html( $item->title );

		// Add a toggle element to top-level menu items that has sub-menus.
		if ( ! $is_cta && $has_children ) {
			$output .= '<span class="menu-item__sub-menu-toggler" aria-expanded="false">';
			$output .= \CustomTheme\get_icon( 'arrow-right' );
			/* translators: Hidden accessibility text. */
			$output .= '<span class="screen-reader-text">' . esc_html__( 'Open menu', TEXT_DOMAIN ) . '</span>';
			$output .= '</span>';
		}

		$output .= '</a>';
	}
}
