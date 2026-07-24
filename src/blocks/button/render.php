<?php

$size = $attributes['size'];
$text = $attributes['text'];

$attr = get_block_wrapper_attributes(
	array(
		'class' => 'btn--' . $size . ' wp-block-custom-theme-button',
	)
);

ob_start();
?>

<button <?php echo $attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- get_block_wrapper_attributes() returns pre-escaped, ready-to-echo HTML attributes. ?>>
	<?php echo esc_html( $text ); ?>
</button>

<?php
echo ob_get_clean(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Re-emits the buffer above, whose dynamic values are already handled at their point of output.
?>