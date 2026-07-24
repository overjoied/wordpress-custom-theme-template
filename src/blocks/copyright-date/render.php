<?php
/**
 * Renders the copyright-date block.
 *
 * @package CustomTheme
 *
 * @var array    $attributes Block attributes.
 * @var string   $content    Block default content.
 * @var WP_Block $block      Block instance.
 */

$current_year = gmdate( 'Y' );

// Determine which content to display.
if ( isset( $attributes['fallbackCurrentYear'] ) && $attributes['fallbackCurrentYear'] === $current_year ) {

	// The current year is the same as the fallback, so use the block content saved in the database (by the save.js function).
	$block_content = $content;
} else {

	// The current year is different from the fallback, so render the updated block content.
	if ( ! empty( $attributes['startingYear'] ) && ! empty( $attributes['showStartingYear'] ) ) {
		$display_date = $attributes['startingYear'] . '–' . $current_year;
	} else {
		$display_date = $current_year;
	}

	$block_content = '<p ' . get_block_wrapper_attributes() . '>© ' . esc_html( $display_date ) . '</p>';
}

echo wp_kses_post( $block_content );
