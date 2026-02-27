<?php
/**
 * Registers the Content Diensten block with ACF.
 *
 * @package YourThemeOrPlugin
 */

add_action(
    'init',
    function () {
        // Check ACF.
        if ( ! function_exists( 'acf_register_block_type' ) ) {
            return;
        }

        $block_name = 'content-diensten';

        /**
         * Minimalistisch field group:
         * Alleen een informatieve melding voor redacteuren.
         */
        if ( function_exists( 'acf_add_local_field_group' ) ) {
            acf_add_local_field_group(
                array(
                    'key'      => 'group_' . $block_name,
                    'title'    => 'Content Diensten Section',
                    'fields'   => array(

                        // Informerende admin-message
                        array(
                            'key'   => 'field_' . $block_name . '_info',
                            'label' => 'Informatie',
                            'type'  => 'message',
                            'name'  => '',
                            'message' =>
                                '<strong>Let op:</strong><br>' .
                                'Dit blok bevat geen instelbare velden.<br><br>' .
                                '- De keuringen worden automatisch geladen via een <code>WP_Query</code> op het custom post type <strong>keuring</strong>.<br>' .
                                '- De afwisseling van tekst/afbeelding gebeurt automatisch met CSS (op basis van index).<br>' .
                                '- Achtergrondkleuren worden eveneens automatisch toegepast via CSS.<br><br>' .
                                'Je hoeft hier dus niets in te vullen.',
                            'wrapper' => array( 'class' => 'acf-warning' ),
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