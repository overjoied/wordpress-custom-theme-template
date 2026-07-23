<?php
// This file is generated. Do not modify it manually.
return array(
	'button' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'custom-theme/button',
		'version' => '0.1.0',
		'title' => 'Button',
		'category' => 'custom',
		'icon' => 'smiley',
		'description' => 'A button block with different sizes.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'button',
		'editorScript' => 'file:./edit.js',
		'editorStyle' => 'file:./edit.css',
		'script' => 'file:./index.js',
		'style' => 'file:./index.css',
		'render' => 'file:./render.php',
		'attributes' => array(
			'size' => array(
				'type' => 'string',
				'enum' => array(
					'sm',
					'md',
					'lg'
				)
			),
			'text' => array(
				'type' => 'string'
			),
			'url' => array(
				'type' => 'string'
			)
		)
	),
	'copyright-date' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'custom-theme/copyright-date',
		'version' => '0.1.0',
		'title' => 'Copyright Date',
		'category' => 'custom',
		'icon' => 'smiley',
		'description' => 'A block that displays a copyright with an optional starting year.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'copyright-date',
		'editorScript' => 'file:./edit.js',
		'editorStyle' => 'file:./edit.css',
		'script' => 'file:./index.js',
		'render' => 'file:./render.php',
		'attributes' => array(
			'fallbackCurrentYear' => array(
				'type' => 'string'
			),
			'showStartingYear' => array(
				'type' => 'boolean'
			),
			'startingYear' => array(
				'type' => 'string'
			)
		)
	)
);
