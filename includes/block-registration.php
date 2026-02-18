<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Fetches all block directories.
 *
 * @return array List of block directories.
 */
function fetch_blocks() {
	// Path to the root of your blocks.
	$blocks_directory = get_template_directory() . '/blocks/';

	// Get a list of all directories within the block-registration folder.
	$block_folders = glob( $blocks_directory . '*/', GLOB_ONLYDIR );

	return $block_folders;
}

/**
 * Read block.json from a block directory.
 *
 * @param string $block_dir Absolute directory path, trailing slash allowed.
 * @return array|null
 */
function read_block_json( $block_dir ) {
	$path = rtrim( $block_dir, '/' ) . '/block.json';

	if ( ! file_exists( $path ) ) {
		return null;
	}

	$json = file_get_contents( $path );
	if ( ! $json ) {
		return null;
	}

	$data = json_decode( $json, true );
	if ( json_last_error() !== JSON_ERROR_NONE || ! is_array( $data ) ) {
		return null;
	}

	return $data;
}

/**
 * Determine if a category is a core WordPress category.
 *
 * @param string $category Category slug.
 * @return bool
 */
function is_core_block_category( $category ) {
	$core = [
		'text',
		'media',
		'design',
		'widgets',
		'theme',
		'embed',
		'formatting',
		'reusable',
	];

	return in_array( $category, $core, true );
}

/**
 * Convert a slug to a human readable title.
 * Example: "donderz-hero" -> "Donderz Hero"
 *
 * @param string $slug Category slug.
 * @return string
 */
function category_slug_to_title( $slug ) {
	$slug = str_replace( [ '-', '_' ], ' ', $slug );
	$slug = preg_replace( '/\s+/', ' ', $slug );
	$slug = trim( $slug );

	return $slug ? ucwords( $slug ) : 'Blocks';
}

/**
 * Collect unique custom categories from all block.json files.
 *
 * @return array Array of category slugs.
 */
function get_custom_block_categories_from_blocks() {
	$blocks = fetch_blocks();

	$categories = [];

	foreach ( $blocks as $block_dir ) {
		$data = read_block_json( $block_dir );
		if ( empty( $data['category'] ) ) {
			continue;
		}

		$cat = sanitize_key( $data['category'] );
		if ( ! $cat ) {
			continue;
		}

		// Skip core categories. Only add custom ones.
		if ( is_core_block_category( $cat ) ) {
			continue;
		}

		$categories[ $cat ] = true;
	}

	return array_keys( $categories );
}

/**
 * Add custom Gutenberg block categories based on block.json categories.
 *
 * WordPress 5.8+ uses block_categories_all.
 *
 * @param array                  $block_categories Existing block categories.
 * @param WP_Editor_Context|null $editor_context Editor context.
 */
function register_custom_block_categories( $block_categories, $editor_context = null ) {
	$custom_cats = get_custom_block_categories_from_blocks();

	if ( empty( $custom_cats ) ) {
		return $block_categories;
	}

	// Existing slugs for dedupe.
	$existing = [];
	foreach ( (array) $block_categories as $cat ) {
		if ( ! empty( $cat['slug'] ) ) {
			$existing[ $cat['slug'] ] = true;
		}
	}

	foreach ( $custom_cats as $slug ) {
		if ( isset( $existing[ $slug ] ) ) {
			continue;
		}

		$block_categories[] = [
			'slug'  => $slug,
			'title' => category_slug_to_title( $slug ),
			'icon'  => null, // Optioneel: 'star-filled' werkt niet altijd hier, vaak null laten.
		];
	}

	return $block_categories;
}
add_filter( 'block_categories_all', 'register_custom_block_categories', 10, 2 );

// Fallback for older WP versions.
add_filter( 'block_categories', 'register_custom_block_categories', 10, 2 );

/**
 * Registers all blocks.
 */
function block_registration() {
	$blocks = fetch_blocks();

	foreach ( $blocks as $block ) {
		$block_name = basename( $block );

		register_block_type( $block );

		include_once $block . $block_name . '-config.php';
	}
}
add_action( 'init', 'block_registration' );

/**
 * Filter to allow only specific blocks.
 *
 * @param array  $allowed_blocks Array of allowed block types.
 * @param object $editor_context Editor context.
 *
 * @return array Filtered list of allowed blocks.
 */
function allowed_block_types( $allowed_blocks, $editor_context ) {
	$blocks             = fetch_blocks();
	$allowed_blocks_arr = [ 'core/block' ];

    if (isset($editor_context->post)) {
        $post_type = $editor_context->post->post_type;
        // Specifiek posttype: alleen een paar core blokken toestaan
        // if ($post_type === 'post') { // vervang 'post' door jouw posttype
        //     return array(
        //         'core/paragraph',
        //         'core/heading',
        //         'core/image',
        //         'core/list',
        //     );
        // }
    }

	// Loop through each directory and register the CSS.
	foreach ( $blocks as $block ) {
		$block_name           = basename( $block );
		$allowed_blocks_arr[] = 'acf/' . $block_name;
	}

	return $allowed_blocks_arr;
}
add_filter( 'allowed_block_types_all', 'allowed_block_types', 25, 2 );
