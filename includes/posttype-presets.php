<?php
function acf_block(string $name): array
{
    $block_name = 'acf/' . $name;

    $data = [];

    if (function_exists('acf_get_field_groups') && function_exists('acf_get_fields')) {
        $groups = acf_get_field_groups(['block' => $block_name]);

        foreach ($groups as $group) {
            $fields = acf_get_fields($group);

            if (empty($fields) || !is_array($fields))
                continue;

            foreach ($fields as $field) {
                $field_name = $field['name'] ?? '';
                if (!$field_name)
                    continue;

                // Alleen zetten als er echt een default is
                if (!array_key_exists('default_value', $field))
                    continue;

                $default = $field['default_value'];

                // Skip lege defaults, anders ga je lege waarden "forceren"
                if ($default === null || $default === '' || (is_array($default) && empty($default)))
                    continue;

                $data[$field_name] = $default;
            }
        }
    }

    return [
        'blockName' => $block_name,
        'attrs' => [
            // Optioneel maar wel netjes: een stabiele id voor het block.
            'id' => 'block_' . wp_generate_uuid4(),
            'data' => $data,
        ],
    ];
}

/**
 * Standaard Gutenberg/ACF blokken injecten bij NIEUWE posts van CPT: ons-werk
 * Zonder register_post_type template.
 */
add_filter(
	'default_content',
	function ( $content, $post ) {

		// Default: altijd bestaande content teruggeven
		if ( ! is_admin() || ! $post ) {
			return $content;
		}

		// Alleen bij NIEUWE, lege posts
		if ( ! empty( trim( (string) $content ) ) ) {
			return $content;
		}

		if ( isset( $post->post_status ) && $post->post_status !== 'auto-draft' ) {
			return $content;
		}

    // Alleen dit posttype krijgt standaard blokken
    if ($post->post_type === 'post') {

        $pattern_ref = find_synced_pattern_post_id_by_slug('thema/pattern-slug');

        $blocks = [
            acf_block('hero'),
            [
                'blockName' => 'core/block',
                'attrs' => [
                    'ref' => $pattern_ref,
                ],
            ]
            // Gebruik onderstaande om patterns / template parts standaard in te laden.
        ];

			return function_exists( 'serialize_blocks' )
			? serialize_blocks( $blocks )
			: $content;
		}

		// Alle andere posttypes: niets doen
		return $content;
	},
	10,
	2
);
