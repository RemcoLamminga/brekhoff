<?php

/**
 * Registers the Hero block with ACF.
 */
add_action(
	'init',
	function () {
		// Check if ACF is active and available.
		if (!function_exists('acf_register_block_type')) {
			// ACF (Pro) is missing or not loaded yet.
			return;
		}

		$block_name = 'hero';

		// Register field group.
		if (function_exists('acf_add_local_field_group')) {
			acf_add_local_field_group(
				[
					'key' => 'group_hero',
					'title' => 'Hero Sectie',
					'fields' => [
						[
							'key' => 'field_hero_eyebrow',
							'label' => 'Eyebrow',
							'name' => 'hero_eyebrow',
							'type' => 'text',
							'default_value' => 'Eyebrow',
						],
						[
							'key' => 'field_hero_title',
							'label' => 'Titel',
							'name' => 'hero_title',
							'type' => 'text',
							'default_value' => 'Titel',
						],
						[
							'key' => 'field_hero_paragraph',
							'label' => 'Paragraaf',
							'name' => 'hero_paragraph',
							'type' => 'textarea',
							'default_value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit…',
						],

						[
							'key' => 'field_hero_text_repeater',
							'label' => 'Kenmerken',
							'name' => 'hero_text_repeater',
							'type' => 'repeater',
							'instructions' => 'Voeg maximaal 3 tekstregels toe.',
							'min' => 0,
							'max' => 3,
							'layout' => 'table',
							'button_label' => 'Kenmerk toevoegen',
							'sub_fields' => [
								[
									'key' => 'field_hero_text_item',
									'label' => 'Tekstregel',
									'name' => 'text_item',
									'type' => 'text',
									'wrapper' => [
										'width' => '100',
									],
								],
							],
						],
						[
							'key' => 'field_hero_buttons',
							'label' => 'Buttons',
							'name' => 'hero_buttons',
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
							'button_label' => 'Voeg maximaal 2 buttons toe',
							'min' => 0,
							'max' => 2,
						],
						[
							'key' => 'field_hero_image',
							'label' => 'Afbeelding',
							'name' => 'hero_image',
							'type' => 'image',
							'return_format' => 'url',
							'preview_size' => 'medium',
							'library' => 'all',
						],
					],
					'location' => [
						[
							[
								'param' => 'block',
								'operator' => '==',
								'value' => 'acf/' . $block_name,
							],
						],
					],
				]
			);
		}
	},
	20
); // Priority 20 to ensure ACF (plugins) is loaded.
