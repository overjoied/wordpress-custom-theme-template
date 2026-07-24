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

<button <?php echo $attr; ?>>
	<?php echo $text; ?>
</button>

<?php echo ob_get_clean(); ?>