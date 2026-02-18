<?php

/**
 * Registers the Hero block with ACF.
 */
add_action(
	'init',
	function () {
		// Check if ACF is active and available.
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			// ACF (Pro) is missing or not loaded yet.
			return;
		}

		$block_name = basename( __DIR__ );

		// Register field group.
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				[
					'key'      => 'group_hero',
					'title'    => 'Hero Sectie',
					'fields'   => [
						[
							'key'           => 'field_hero_eyebrow',
							'label'         => 'Eyebrow',
							'name'          => 'hero_eyebrow',
							'type'          => 'text',
							'default_value' => 'Lorem ipsum',
						],
						[
							'key'           => 'field_hero_title',
							'label'         => 'Titel',
							'name'          => 'hero_title',
							'type'          => 'text',
							'default_value' => 'Lorem ipsum',
						],
						[
							'key'           => 'field_hero_paragraph',
							'label'         => 'Paragraaf',
							'name'          => 'hero_paragraph',
							'type'          => 'textarea',
							'default_value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit…',
						],
						[
							'key'   => 'field_hero_button_text',
							'label' => 'Knop Tekst',
							'name'  => 'hero_button_text',
							'type'  => 'text',
						],
						[
							'key'   => 'field_hero_button_link',
							'label' => 'Knop Link',
							'name'  => 'hero_button_link',
							'type'  => 'url',
						],
						[
							'key'           => 'field_hero_image',
							'label'         => 'Afbeelding',
							'name'          => 'hero_image',
							'type'          => 'image',
							'return_format' => 'url',
							'preview_size'  => 'medium',
							'library'       => 'all',
						],
					],
					'location' => [
						[
							[
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/' . $block_name,
							],
						],
					],
				]
			);
		}
	},
	20
); // Priority 20 to ensure ACF (plugins) is loaded.
