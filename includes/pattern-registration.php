<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Fetches all pattern files.
 *
 * Supports .php and .html (and .htm).
 *
 * @return array List of absolute file paths.
 */
function fetch_pattern_files() {
	$patterns_directory = get_template_directory() . '/synced-patterns/';

	$files = glob( $patterns_directory . '*.{php,html,htm}', GLOB_BRACE );
	return is_array( $files ) ? $files : [];
}

/**
 * Read pattern header data (Title, Slug, Categories, etc.)
 *
 * Uses WordPress get_file_data(), same mechanism as theme headers.
 *
 * @param string $file Absolute file path.
 * @return array
 */
function read_pattern_header( $file ) {
	$headers = [
		'title'       => 'Title',
		'slug'        => 'Slug',
		'categories'  => 'Categories',
		'description' => 'Description',
		'keywords'    => 'Keywords',
	];

	$data = get_file_data( $file, $headers );

	// Normalize.
	$data = array_map( 'trim', (array) $data );

	// Categories / keywords may be comma-separated.
	$data['categories'] = ! empty( $data['categories'] )
		? array_filter( array_map( 'sanitize_key', array_map( 'trim', explode( ',', $data['categories'] ) ) ) )
		: [];

	$data['keywords'] = ! empty( $data['keywords'] )
		? array_filter( array_map( 'sanitize_text_field', array_map( 'trim', explode( ',', $data['keywords'] ) ) ) )
		: [];

	return $data;
}

/**
 * Render pattern content from a file.
 *
 * - For .php: includes file and captures output (allows PHP in patterns).
 * - For .html/.htm: reads raw file content.
 *
 * @param string $file Absolute file path.
 * @return string Rendered block markup.
 */
function render_pattern_content( $file ) {
	$ext = strtolower( pathinfo( $file, PATHINFO_EXTENSION ) );

	if ( $ext === 'php' ) {
		ob_start();
		include $file;
		$content = ob_get_clean();
		return is_string( $content ) ? trim( $content ) : '';
	}

	$content = file_get_contents( $file );
	return is_string( $content ) ? trim( $content ) : '';
}

/**
 * Make a safe wp_block post_name from a pattern slug.
 * Example: "dz/cta-synced" -> "dz-cta-synced"
 *
 * @param string $pattern_slug Pattern slug.
 */
function pattern_slug_to_post_name( $pattern_slug ) {
	$pattern_slug = trim( (string) $pattern_slug );
	if ( $pattern_slug === '' ) {
		return '';
	}

	// Replace slashes with dashes and sanitize.
	$post_name = str_replace( '/', '-', $pattern_slug );
	return sanitize_title( $post_name );
}

/**
 * Find an existing wp_block by our stored pattern slug meta.
 *
 * @param string $pattern_slug Pattern slug.
 * @return int Post ID or 0 if not found.
 */
function find_synced_pattern_post_id_by_slug( $pattern_slug ) {
	$q = new WP_Query(
		[
			'post_type'      => 'wp_block',
			'post_status'    => 'publish',
			'posts_per_page' => 1,
			'fields'         => 'ids',
			'meta_query'     => [
				[
					'key'   => '_dz_synced_pattern_slug',
					'value' => $pattern_slug,
				],
			],
		]
	);

	return ! empty( $q->posts[0] ) ? (int) $q->posts[0] : 0;
}

/**
 * Create or update synced patterns from theme /patterns directory.
 *
 * NOTE: This will update the wp_block content whenever the source file content hash changes.
 * If you want to avoid overwriting editor changes, see the comment inside (lock strategy).
 */
function sync_synced_patterns_from_theme() {
	$files = fetch_pattern_files();
	if ( empty( $files ) ) {
		return;
	}

	foreach ( $files as $file ) {
		$header  = read_pattern_header( $file );
		$content = render_pattern_content( $file );

		// You need at least title + slug + content.
		if ( empty( $header['title'] ) || empty( $header['slug'] ) || $content === '' ) {
			continue;
		}

		$pattern_slug = $header['slug'];
		$post_name    = pattern_slug_to_post_name( $pattern_slug );
		if ( $post_name === '' ) {
			continue;
		}

		$new_hash = sha1( $content );

		$post_id = find_synced_pattern_post_id_by_slug( $pattern_slug );

		// Optional overwrite protection:
		// If you DON'T want to overwrite edits made in the editor, only update when:
		// - post meta hash matches last known hash (i.e. not edited), OR
		// - you explicitly force updates (e.g. in WP_ENV=development).
		$should_update = true;

		if ( $post_id ) {
			$old_hash = (string) get_post_meta( $post_id, '_dz_synced_pattern_hash', true );

			// Only update when file changed.
			if ( $old_hash === $new_hash ) {
				$should_update = false;
			}

			// If you want “do not overwrite editor edits”:
			// uncomment this block and store an "edited in wp" flag elsewhere.
			// $current_content = get_post_field( 'post_content', $post_id );
			// if ( sha1( (string) $current_content ) !== $old_hash ) {
			// Content in DB differs from what we last generated -> someone edited it in admin.
			// $should_update = false;
			// }
		}

		if ( ! $post_id ) {
			$post_id = wp_insert_post(
				[
					'post_type'    => 'wp_block',
					'post_status'  => 'publish',
					'post_title'   => $header['title'],
					'post_name'    => $post_name,
					'post_content' => $content,
				]
			);

			if ( is_wp_error( $post_id ) || ! $post_id ) {
				continue;
			}

			update_post_meta( $post_id, '_dz_synced_pattern_slug', $pattern_slug );
			update_post_meta( $post_id, '_dz_synced_pattern_hash', $new_hash );
			update_post_meta( $post_id, '_dz_synced_pattern_source', wp_make_link_relative( str_replace( get_template_directory(), '', $file ) ) );
		} elseif ( $should_update ) {
			wp_update_post(
				[
					'ID'           => $post_id,
					'post_title'   => $header['title'],
					'post_name'    => $post_name,  // keep consistent if header slug changes
					'post_content' => $content,
				]
			);

			update_post_meta( $post_id, '_dz_synced_pattern_hash', $new_hash );
		}

		// (Optioneel) taxonomy “wp_pattern_category” is niet altijd stabiel beschikbaar,
		// dus laat ik het hier bewust weg. Je kunt categories wel gebruiken voor UI/organisatie
		// via eigen meta of via register_block_pattern_category + block patterns.
	}
}
add_action( 'init', 'sync_synced_patterns_from_theme' );
