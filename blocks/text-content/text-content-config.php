<?php

/**
 * Registers the Text Content block with ACF.
 */
add_action(
	'init',
	function () {
		// Check if ACF is active and available.
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			// ACF (Pro) is missing or not loaded yet.
			return;
		}

		$block_name = 'text-content';

		// Register the field group.
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				[
					'key'      => 'group_text-content',
					'title'    => 'Textcontent Section',
					'fields'   => [
						[
							'key'           => 'field_text_content_title',
							'label'         => 'Titel',
							'name'          => 'text_content_title',
							'type'          => 'text',
							'default_value' => 'Lorem ipsum',
						],
						[
							'key'          => 'field_text_content',
							'label'        => 'Inhoud',
							'name'         => 'text_content',
							'type'         => 'wysiwyg',
							'tabs'         => 'all',     // 'visual', 'text', or 'all'
							'toolbar'      => 'full',    // 'basic' or 'full' (custom toolbars can also be set via ACF)
							'media_upload' => 0,         // Show media button (1) or hide (0)
							'delay'        => 0,         // Initialize editor immediately (0) or on focus (1)
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
