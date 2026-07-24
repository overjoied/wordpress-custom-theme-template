<?php
/**
 * Shortcodes
 *
 * @author Joanne Joie Cabang
 * @package CustomTheme
 */

namespace CustomTheme;

function button_func( $atts, $content = null, $tag = '' ) {
	$atts = shortcode_atts(
		array(
			'text' => 'Button',
		),
		$atts
	);

	\CustomTheme\enqueue_assets( 'components', $tag );

	ob_start();
	?>

	<button><?php echo $atts['text']; ?></button>

	<?php
	return ob_get_clean();
}

// [button]
add_shortcode( 'button', __NAMESPACE__ . '\button_func' );

// [button-link]
add_shortcode( 'button-link', __NAMESPACE__ . '\button_func' );