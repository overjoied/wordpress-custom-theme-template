<?php
/**
 * Hero ACF block template.
 *
 * @param array  $block      The block settings and attributes.
 * @param string $content    The block inner HTML (empty — this block has no InnerBlocks).
 * @param bool   $is_preview True during the editor's backend preview render.
 * @param int    $post_id    The post ID this block is rendering against.
 */

$heading          = get_field( 'heading' );
$background_image = get_field( 'background_image' );
$background_url   = $background_image['url'] ?? '';

$classes = array( 'hero' );
if ( ! empty( $block['className'] ) ) {
	$classes[] = $block['className'];
}
?>

<section
	id="<?php echo esc_attr( $block['anchor'] ?? "hero-{$block['id']}" ); ?>"
	class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
	<?php if ( $background_url ) : ?>
		style="background-image:url(<?php echo esc_url( $background_url ); ?>)"
	<?php endif; ?>
>
	<?php if ( $heading ) : ?>
		<h1 class="hero__heading"><?php echo esc_html( $heading ); ?></h1>
	<?php endif; ?>
</section>
