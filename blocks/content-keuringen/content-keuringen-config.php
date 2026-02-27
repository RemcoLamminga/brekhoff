<?php
/**
 * Registers the Content Keuringen block with ACF.
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

		$block_name = 'content-keuringen';

		// Register the field group.
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_' . $block_name,
					'title'    => 'Content Keuringen Section',
					'fields'   => array(
						array(
							'key'           => 'field_' . $block_name . '_eyebrow',
							'label'         => 'Eyebrow',
							'name'          => $block_name . '_eyebrow',
							'type'          => 'text',
							'default_value' => 'Waarom keuringen?',
						),
						array(
							'key'           => 'field_' . $block_name . '_title',
							'label'         => 'Titel',
							'name'          => $block_name . '_title',
							'type'          => 'text',
							'default_value' => 'Keuringen zijn verplicht én essentieel',
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
							'default_value' => 'In Nederland zijn bedrijven wettelijk verplicht om periodieke keuringen uit te voeren. Dit is niet alleen om boetes te voorkomen, maar vooral om veiligheid te garanderen.',
						),
						// --- Repeater: USP items ---
                        array(
                            'key'          => 'field_' . $block_name . '_items',
                            'label'        => 'Keuring item',
                            'name'         => $block_name . '_items',
                            'type'         => 'repeater',
                            'layout'       => 'block',
                            'button_label' => 'Item toevoegen',
                            'collapsed'    => 'field_' . $block_name . '_item_title',
                            'min'          => 0,
                            'max'          => 3,
                            'sub_fields'   => array(
                                array(
                                    'key'           => 'field_' . $block_name . '_item_icon',
                                    'label'         => 'Icon',
                                    'name'          => 'icon',
                                    'type'          => 'image',
                                    'return_format' => 'array', // 'id', 'url', or 'array'.
                                    'preview_size'  => 'thumbnail',
                                    'library'       => 'all',
                                    'mime_types'    => 'svg,png,webp,jpg,jpeg',
                                    'instructions'  => 'Upload een icoon (bij voorkeur SVG).',
                                ),
                                array(
                                    'key'           => 'field_' . $block_name . '_item_title',
                                    'label'         => 'Titel',
                                    'name'          => 'title',
                                    'type'          => 'text',
                                    'placeholder'   => '',
                                ),
                                array(
                                    'key'           => 'field_' . $block_name . '_item_text',
                                    'label'         => 'Tekst',
                                    'name'          => 'text',
                                    'type'          => 'textarea',
                                    'rows'          => 2,
                                    'new_lines'     => '', // '' (no formatting), 'br', or 'wpautop'.
                                    'placeholder'   => 'Korte toelichting',
                                ),
                            ),
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
