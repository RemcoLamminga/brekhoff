<?php
/**
 * Registers the Content Intro block with ACF.
 *
 * @package YourThemeOrPlugin
 */

add_action(
	'init',
	function () {
		// Check if ACF is active and available.
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			// ACF (Pro) is missing or not loaded yet.
			return;
		}

		$block_name = 'content-intro';

		// Register the field group.
		if (function_exists('acf_add_local_field_group')) {
			acf_add_local_field_group(
				array(
					'key' => 'group_' . $block_name,
					'title' => 'Content Tekst Afbeelding Section',
					'fields' => array(
						array(
							'key' => 'field_' . $block_name . '_image',
							'label' => 'Afbeelding',
							'name' => $block_name . '_image',
							'type' => 'image',
							'return_format' => 'url',
							'preview_size' => 'medium',
							'library' => 'all',
						),
						array(
							'key' => 'field_' . $block_name . '_image_focal_point',
							'label' => 'Focal Point (X & Y)',
							'name' => $block_name . '_image_focal_point',
							'type' => 'group',
							'sub_fields' => array(
								array(
									'key' => 'field_' . $block_name . '_image_focal_x',
									'label' => 'Focal Point X',
									'name' => 'focal_x',
									'type' => 'range',
									'default_value' => 50,
									'min' => 0,
									'max' => 100,
								),
								array(
									'key' => 'field_' . $block_name . '_image_focal_y',
									'label' => 'Focal Point Y',
									'name' => 'focal_y',
									'type' => 'range',
									'default_value' => 50,
									'min' => 0,
									'max' => 100,
								),
							),
						),
						array(
							'key' => 'field_' . $block_name . '_switch_image_text',
							'label' => 'Wissel afbeelding',
							'name' => $block_name . '_switch_image_text',
							'type' => 'button_group',
							'message' => 'Afbeelding links of rechts',
							'choices' => [
								'links' => 'Links',
								'rechts' => 'Rechts',
							],
							'default_value' => 1,
						),
						array(
							'key' => 'field_' . $block_name . '_eyebrow',
							'label' => 'Eyebrow',
							'name' => $block_name . '_eyebrow',
							'type' => 'text',
							'default_value' => '',
						),
						array(
							'key' => 'field_' . $block_name . '_title',
							'label' => 'Titel',
							'name' => $block_name . '_title',
							'type' => 'text',
							'default_value' => 'Lorem ipsum',
						),
						array(
							'key' => 'field_' . $block_name . '_content',
							'label' => 'Inhoud',
							'name' => $block_name . '_content',
							'type' => 'wysiwyg',
							'tabs' => 'all',  // 'visual', 'text', or 'all'.
							'toolbar' => 'full', // 'basic' or 'full'.
							'media_upload' => 0,      // Show media button (1) or hide (0).
							'delay' => 0,      // Initialize editor immediately (0) or on focus (1).
						),
						array(
							'key' => 'field_' . $block_name . '_buttons',
							'label' => 'Buttons',
							'name' => $block_name . 'buttons',
							'type' => 'repeater',
							'instructions' => 'Voeg knoppen toe.',
							'sub_fields' => [
								[
									'key' => 'field_' . $block_name . '_button_link',
									'label' => 'Link',
									'name' => 'link',
									'type' => 'link',
									'return_format' => 'array', // array: url/title/target
								],
							],
							'button_label' => 'Voeg Button toe',
							'min' => 0,
							'max' => 1,
						),
					),
					'location' => array(
						array(
							array(
								'param' => 'block',
								'operator' => '==',
								'value' => 'acf/' . $block_name,
							),
						),
					),
				)
			);
		}
	},
	20
);



