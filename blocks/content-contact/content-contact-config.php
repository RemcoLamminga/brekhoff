<?php
/**
 * Registers the Content Contact block with ACF.
 *
 * @package YourThemeOrPlugin
 */

add_action(
    'init',
    function () {
        if ( ! function_exists( 'acf_register_block_type' ) ) {
            return;
        }

        $block_name = 'content-contact';

        if ( function_exists( 'acf_add_local_field_group' ) ) {

            acf_add_local_field_group(
                array(
                    'key'      => 'group_' . $block_name,
                    'title'    => 'Content Contact Section',
                    'fields'   => array(

                        /**
                         * STYLE BUTTON GROUP
                         */
                        array(
                            'key'           => 'field_' . $block_name . '_style',
                            'label'         => 'Stijl',
                            'name'          => $block_name . '_style',
                            'type'          => 'button_group',
                            'choices'       => array(
                                'none' => 'Geen',
                                'dark'    => 'Donker',
                            ),
                            'default_value' => 'none',
                        ),

                        /**
                         * 1. Titel
                         */
                        array(
                            'key'           => 'field_' . $block_name . '_title',
                            'label'         => 'Titel',
                            'name'          => $block_name . '_title',
                            'type'          => 'text',
                            'default_value' => 'Vraag een keuring aan of stel je vraag',
                        ),

                        /**
                         * 2. Tekst
                         */
                        array(
                            'key'          => 'field_' . $block_name . '_content',
                            'label'        => 'Tekst',
                            'name'         => $block_name . '_content',
                            'type'         => 'wysiwyg',
                            'tabs'         => 'all',
                            'toolbar'      => 'full',
                            'media_upload' => 0,
                            'delay'        => 0,
                        ),

                        /**
                         * 3. Formulier shortcode
                         */
                        array(
                            'key'           => 'field_' . $block_name . '_form_shortcode',
                            'label'         => 'Formulier',
                            'name'          => $block_name . '_form_shortcode',
                            'type'          => 'text',
                            'placeholder'   => '[gravityform id="1" title="false" description="false" ajax="true"]',
                        ),

                        /**
                         * 4. Contact info toggle
                         */
                        array(
                            'key'           => 'field_' . $block_name . '_show_contact_info',
                            'label'         => 'Contact info tonen',
                            'name'          => $block_name . '_show_contact_info',
                            'type'          => 'true_false',
                            'ui'            => 1,
                            'default_value' => 1,
                        ),

                        /**
                         * TAB 1 – Contactgegevens
                         */
                        array(
                            'key'               => 'field_' . $block_name . '_tab_contact',
                            'label'             => 'Contact',
                            'type'              => 'tab',
                            'placement'         => 'top',
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field'    => 'field_' . $block_name . '_show_contact_info',
                                        'operator' => '==',
                                        'value'    => '1',
                                    ),
                                ),
                            ),
                        ),

                        array(
                            'key'               => 'field_' . $block_name . '_contact_title',
                            'label'             => 'Contact titel',
                            'name'              => $block_name . '_contact_title',
                            'type'              => 'text',
                            'default_value'     => 'Direct contact',
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field'    => 'field_' . $block_name . '_show_contact_info',
                                        'operator' => '==',
                                        'value'    => '1',
                                    ),
                                ),
                            ),
                        ),

                        array(
                            'key'               => 'field_' . $block_name . '_phone',
                            'label'             => 'Telefoon',
                            'name'              => $block_name . '_phone',
                            'type'              => 'text',
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field'    => 'field_' . $block_name . '_show_contact_info',
                                        'operator' => '==',
                                        'value'    => '1',
                                    ),
                                ),
                            ),
                        ),

                        array(
                            'key'               => 'field_' . $block_name . '_email',
                            'label'             => 'E-mail',
                            'name'              => $block_name . '_email',
                            'type'              => 'email',
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field'    => 'field_' . $block_name . '_show_contact_info',
                                        'operator' => '==',
                                        'value'    => '1',
                                    ),
                                ),
                            ),
                        ),

                        /**
                         * TAB 2 – Spoedgegevens
                         */
                        array(
                            'key'               => 'field_' . $block_name . '_tab_emergency',
                            'label'             => 'Spoed',
                            'type'              => 'tab',
                            'placement'         => 'top',
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field'    => 'field_' . $block_name . '_show_contact_info',
                                        'operator' => '==',
                                        'value'    => '1',
                                    ),
                                ),
                            ),
                        ),

                        array(
                            'key'               => 'field_' . $block_name . '_emergency_title',
                            'label'             => 'Spoed titel',
                            'name'              => $block_name . '_emergency_title',
                            'type'              => 'text',
                            'default_value'     => 'Spoedkeuring nodig?',
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field'    => 'field_' . $block_name . '_show_contact_info',
                                        'operator' => '==',
                                        'value'    => '1',
                                    ),
                                ),
                            ),
                        ),

                        array(
                            'key'               => 'field_' . $block_name . '_emergency_text',
                            'label'             => 'Spoed tekst',
                            'name'              => $block_name . '_emergency_text',
                            'type'              => 'textarea',
                            'rows'              => 3,
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field'    => 'field_' . $block_name . '_show_contact_info',
                                        'operator' => '==',
                                        'value'    => '1',
                                    ),
                                ),
                            ),
                        ),

                        array(
                            'key'               => 'field_' . $block_name . '_emergency_phone',
                            'label'             => 'Spoed telefoonnummer',
                            'name'              => $block_name . '_emergency_phone',
                            'type'              => 'text',
                            'placeholder'       => 'Bijv. 06 – 12 34 56 78',
                            'conditional_logic' => array(
                                array(
                                    array(
                                        'field'    => 'field_' . $block_name . '_show_contact_info',
                                        'operator' => '==',
                                        'value'    => '1',
                                    ),
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
