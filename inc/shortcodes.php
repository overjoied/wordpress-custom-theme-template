<?php
/**
 * Shortcodes
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

/**
 * Button shortcode.
 *
 * @param array       $atts    Shortcode attributes.
 * @param string|null $content Shortcode content.
 * @param string      $tag     Shortcode tag.
 *
 * @return string
 */
function button_func( array $atts, $content = null, $tag = '' ) {
	$atts = shortcode_atts(
		array(
			'text' => 'Button',
		),
		$atts
	);

	\CustomTheme\enqueue_assets( 'components', $tag );

	ob_start();
	?>

	<button><?php echo esc_html( $atts['text'] ); ?></button>

	<?php
	return ob_get_clean();
}

// [button]
add_shortcode( 'button', __NAMESPACE__ . '\button_func' );

// [button-link]
add_shortcode( 'button-link', __NAMESPACE__ . '\button_func' );