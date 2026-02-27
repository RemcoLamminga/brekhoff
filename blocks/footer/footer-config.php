<?php

/**
 * Registers the footer block with ACF.
 */

add_action(
    'init',
    function () {
        // Check if ACF is active and available.
        if ( ! function_exists( 'acf_register_block_type' ) ) {
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

                        /**
                         * A: Logo upload veld
                         */
                        [
                            'key'           => 'field_' . $block_name . '_logo',
                            'label'         => 'Footer Logo',
                            'name'          => $block_name . '_logo',
                            'type'          => 'image',
                            'return_format' => 'array',
                            'preview_size'  => 'medium',
                            'library'       => 'all',
                        ],

                        /**
                         * C: Rechtertekst (headline)
                         */
                        [
                            'key'           => 'field_' . $block_name . '_right_text',
                            'label'         => 'Rechter tekstblok',
                            'name'          => $block_name . '_right_text',
                            'type'          => 'textarea',
                            'rows'          => 2,
                        ],

                        /**
                         * C: Button URL
                         */
                        [
							'key' => 'field_' . $block_name . '_buttons',
							'label' => 'Buttons',
							'name' => $block_name . 'buttons',
							'type' => 'repeater',
							'instructions' => 'Max 1 button toevoegen.',
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
						],

                    ],

                    /**
                     * ACF location: assign fields to this block
                     */
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
); // Priority 20 to ensure ACF plugins are loaded.