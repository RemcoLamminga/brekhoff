<?php

/**
 * Filter ACF velden om tekst tussen {{ }} te vinden en te wrappen
 *
 * @param mixed $value De waarde van het ACF veld.
 * @return mixed De gewijzigde waarde met ingepakte tekst.
 */
function custom_acf_field_filter( $value ) {
	// Zoek naar tekst tussen {{ en }} en vervang deze door een <span> tag
	if ( is_string( $value ) ) {
		$value = preg_replace_callback(
			'/\{\{(.*?)\}\}/',
			function ( $matches ) {
				// Het resultaat wrappen in een span, voeg een class toe voor CSS styling
				return '<span class="custom-underline">' . esc_html( $matches[1] ) . '</span>';
			},
			$value
		);
	}

	return $value;
}
// Voeg de filter toe aan ACF velden
add_filter( 'acf/format_value', 'custom_acf_field_filter', 10, 3 );


/**
 * Footer credits met automatisch jaartal.
 *
 * @param string $company Naam van het bedrijf.
 * @return string
 */
function footer_copyright( $company = '' ) {
	$year = date( 'Y' ); // phpcs:ignore WordPress.DateTime.RestrictedFunctions.date_date

	if ( $company ) {
		return '© ' . $year . ' ' . esc_html( $company );
	}

	return '© ' . $year;
}


/**
 * Filters the next, previous and submit buttons.
 * Replaces the form's <input> buttons with <button> while maintaining attributes from original <input>.
 * Adds an icon span while keeping the button text from Gravity Forms settings (value attribute).
 */
add_filter( 'gform_next_button', 'dz_input_to_button_with_icon', 10, 2 );
add_filter( 'gform_previous_button', 'dz_input_to_button_with_icon', 10, 2 );
add_filter( 'gform_submit_button', 'dz_input_to_button_with_icon', 10, 2 );

/**
 *
 * Convert GF input knop naar button met icon.
 *
 * @param string $button De originele knop HTML.
 * @param array  $form   Het formulier object.
 */
function dz_input_to_button_with_icon( $button, $form ) {

	// Als WP_HTML_Processor niet beschikbaar is (oud WP), doe niets.
	if ( ! class_exists( 'WP_HTML_Processor' ) ) {
		return $button;
	}

	$fragment = WP_HTML_Processor::create_fragment( $button );
	$fragment->next_token();

	// Als het geen <input> is, laat hem met rust.
	if ( strtoupper( (string) $fragment->get_tag() ) !== 'INPUT' ) {
		// Bonus: als het al een <button> is, kun je eventueel alleen icon injecten.
		// Maar voor nu: behoud origineel.
		return $button;
	}

	// Attributes die je sowieso wil behouden
	$attributes = [ 'id', 'type', 'class', 'onclick', 'tabindex', 'disabled', 'title', 'aria-label' ];

	// Neem ook alle data-* attributes mee
	$data_attributes = $fragment->get_attribute_names_with_prefix( 'data-' );
	if ( ! empty( $data_attributes ) ) {
		$attributes = array_merge( $attributes, $data_attributes );
	}

	// Bouw attribute string opnieuw op (alleen die bestaan)
	$new_attributes = [];
	foreach ( $attributes as $attribute ) {
		$value = $fragment->get_attribute( $attribute );
		if ( $value !== null && $value !== '' ) {
			// disabled is boolean: in HTML is disabled="disabled" prima
			if ( $attribute === 'disabled' ) {
				$new_attributes[] = 'disabled="disabled"';
				continue;
			}
			$new_attributes[] = sprintf( '%s="%s"', $attribute, esc_attr( $value ) );
		}
	}

	// De knoptekst blijft wat GF instelt (value="")
	$label = (string) $fragment->get_attribute( 'value' );

	return sprintf(
		'<button %s><span class="label">%s</span> <span class="icon" aria-hidden="true"></span></button>',
		implode( ' ', $new_attributes ),
		esc_html( $label )
	);
}
