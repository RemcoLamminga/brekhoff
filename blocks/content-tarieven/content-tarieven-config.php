<?php
/**
 * Registers the Content Tarieven block with ACF.
 *
 * @package YourThemeOrPlugin
 */

add_action(
	'init',
	function () {
		// Check if ACF is active and available.
		if (!function_exists('acf_register_block_type')) {
			// ACF (Pro) is missing or not loaded yet.
			return;
		}

		$block_name = 'content-tarieven';

		// Register the field group.
		if (function_exists('acf_add_local_field_group')) {
			acf_add_local_field_group(
				array(
					'key' => 'group_' . $block_name,
					'title' => 'Content Tarieven Section',
					'fields' => array(
						
						array(
							'key' => 'field_' . $block_name . '_title',
							'label' => 'Titel',
							'name' => $block_name . '_title',
							'type' => 'text',
							'default_value' => 'Titel',
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
						// --- Repeater: Tarieven items ---
						array(
							'key' => 'field_' . $block_name . '_items',
							'label' => 'Keuring item',
							'name' => $block_name . '_items',
							'type' => 'repeater',
							'layout' => 'block',
							'button_label' => 'Item toevoegen',
							'collapsed' => 'field_' . $block_name . '_item_title',
							'min' => 0,
							'max' => 3,
							'sub_fields' => array(
								array(
									'key' => 'field_' . $block_name . '_item_title',
									'label' => 'Titel dienst',
									'name' => 'dienst',
									'type' => 'text',
									'placeholder' => 'NEN 1010',
								),
								array(
									'key' => 'field_' . $block_name . '_item_price',
									'label' => 'Prijs',
									'name' => 'prijs',
									'type' => 'text',
									'placeholder' => '',
								),
								array(
									'key' => 'field_' . $block_name . '_item_text',
									'label' => 'Tekst',
									'name' => 'text',
									'type' => 'textarea',
									'rows' => 2,
									'new_lines' => '', // '' (no formatting), 'br', or 'wpautop'.
									'placeholder' => 'Korte toelichting',
								),
								array(
									'key' => 'field_' . $block_name . '_item_points',
									'label' => 'Punten checklist',
									'name' => 'checklist',
									'type' => 'repeater',
									'layout' => 'block',
									'button_label' => 'Punt toevoegen',
									'collapsed' => 'field_' . $block_name . '_item_points',
									'min' => 0,
									'max' => 5,
									'sub_fields' => array(
										array(
											'key' => 'field_' . $block_name . '_item_point_text',
											'label' => 'Titel punt checklist',
											'name' => 'checklistitem',
											'type' => 'text',
											'placeholder' => 'Lorem ipsum dolor sit amet',
										),
									),
								),
								array(
									'key' => 'field_' . $block_name . '_buttons',
									'label' => 'Buttons',
									'name' => 'buttons',
									'type' => 'repeater',
									'instructions' => 'Voeg knoppen toe.',
									'sub_fields' => array(
										array(
											'key' => 'field_' . $block_name . '_button_link',
											'label' => 'Link',
											'name' => 'link',
											'type' => 'link',
											'return_format' => 'array', // array: url/title/target
										),
									),
									'button_label' => 'Voeg Button toe',
									'min' => 0,
									'max' => 1,
								),
							),
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
