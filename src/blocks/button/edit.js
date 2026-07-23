/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { InspectorControls, useBlockProps } from '@wordpress/block-editor';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './edit.scss';

import { PanelBody, SelectControl, Button, TextControl } from '@wordpress/components';

import { useEffect } from "react";

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */
export default function Edit( { attributes, setAttributes } ) {
	const { size, text, url } = attributes;
	let cta = '';

	useEffect(() => {
		setAttributes({ size: size || 'md', text: text || "Click Here" });
	}, []);

	// useEffect(() => {
	// 	cta = url ? <a href="url" {...props}>{text}</a> : <button {...props}>{text}</button>
	// }, [url]);

	const props = useBlockProps();

	return (
		<>
			<InspectorControls>
				<PanelBody title={ __( 'Settings', 'button' ) }>
					<SelectControl
						label="Size"
						value={ size }
						options={ [
								{ label: 'Large', value: 'lg' },
								{ label: 'Medium', value: 'md' },
								{ label: 'Small', value: 'sm' },
						] }
						onChange={ ( newSize ) => setAttributes( { size: newSize }) }
						__next40pxDefaultSize
						__nextHasNoMarginBottom
					/>
					<TextControl
						__nextHasNoMarginBottom
						__next40pxDefaultSize
						label='Text'
						value={ text }
						onChange={ ( val ) => {
								setAttributes( { text: val } );
						}}
					/>
				</PanelBody>
			</InspectorControls>
			<div {...props}>
				<button class={`btn--${size} wp-block-custom-theme-button`}>{text}</button>
			</div>
		</>
	);
}
