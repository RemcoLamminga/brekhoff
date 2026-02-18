<?php

/**
 * Registers the header block with ACF.
 */
add_action(
	'init',
	function () {
		// Check if ACF is active and available.
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			// ACF (Pro) is missing or not loaded yet.
			return;
		}

		$block_name = 'header';

		// Register the field group.
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				[
					'key'      => 'group_' . $block_name,
					'title'    => 'header Section',
					'fields'   => [
						[
							'key'           => 'field_' . $block_name . '_logo',
							'label'         => 'Logo',
							'name'          => 'logo',
							'type'          => 'image', // Veldtype is 'image'
							'instructions'  => 'Upload het logo voor de header.',
							'return_format' => 'url', // Zorg ervoor dat het de URL van het beeld retourneert.
							'preview_size'  => 'thumbnail', // Voorbeeldgrootte van de afbeelding in ACF.
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
