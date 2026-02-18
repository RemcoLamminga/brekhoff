<?php

/**
 * Registers the footer block with ACF.
 */

add_action(
	'init',
	function () {
		// Check if ACF is active and available.
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			// ACF (Pro) is missing or not loaded yet.
			return;
		}

		$block_name = 'footer';

		// Register the field group.
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				[
					'key'      => 'group_' . $block_name,
					'title'    => 'Footer Section',
					'fields'   => [
						// Contact email or phone
						[
							'key'           => 'field_' . $block_name . '_contact_info',
							'label'         => 'Contactgegevens',
							'name'          => $block_name . '_contact_info',
							'type'          => 'text',
							'default_value' => 'info@jouwsite.nl',
						],
						// Footer navigation links
						[
							'key'          => 'field_' . $block_name . '_footer_links',
							'label'        => 'Footer Navigatie',
							'name'         => $block_name . '_footer_links',
							'type'         => 'repeater',
							'sub_fields'   => [
								[
									'key'   => 'field_' . $block_name . '_footer_link_url',
									'label' => 'Link URL',
									'name'  => 'footer_link_url',
									'type'  => 'url',
								],
								[
									'key'   => 'field_' . $block_name . '_footer_link_label',
									'label' => 'Link Label',
									'name'  => 'footer_link_label',
									'type'  => 'text',
								],
							],
							'button_label' => 'Voeg Footer Link toe',
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
