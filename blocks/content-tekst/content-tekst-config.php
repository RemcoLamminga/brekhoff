<?php
/**
 * Registers the Content Tekst block with ACF.
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

		$block_name = 'content-tekst';

		// Register the field group.
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $block_name,
					'title'    => 'Content Tekst Section',
					'fields'   => array(
						array(
							'key' => 'field_' . $block_name . '_eyebrow',
							'label' => 'Eyebrow',
							'name' => $block_name . '_eyebrow',
							'type' => 'text',
							'default_value' => '',
						),
						array(
							'key'           => 'field_' . $block_name . '_title',
							'label'         => 'Titel',
							'name'          => $block_name . '_title',
							'type'          => 'text',
							'default_value' => 'Lorem ipsum',
						),
						array(
							'key'          => 'field_' . $block_name . '_content',
							'label'        => 'Inhoud',
							'name'         => $block_name . '_content',
							'type'         => 'wysiwyg',
							'tabs'         => 'all',  // 'visual', 'text', or 'all'.
							'toolbar'      => 'full', // 'basic' or 'full'.
							'media_upload' => 0,      // Show media button (1) or hide (0).
							'delay'        => 0,      // Initialize editor immediately (0) or on focus (1).
							'default_value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.'
						),
					),
					'location' => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/' . $block_name,
							),
						),
					),
				)
			);
		}
	},
	20
);
