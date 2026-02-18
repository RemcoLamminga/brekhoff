<?php

/**
 * Disable comments and pings on the site.
 */
add_filter( 'comments_open', '__return_false', 20, 2 );
add_filter( 'pings_open', '__return_false', 20, 2 );

/**
 * Disable displaying comments.
 *
 * @param array $comments List of comments.
 * @return array Empty array to disable comments.
 */
add_filter(
	'comments_array',
	function ( $comments ) {
		return [];
	},
	20,
	2
);

/**
 * Remove Comments from the admin menu.
 */
add_action(
	'admin_menu',
	function () {
		remove_menu_page( 'edit-comments.php' );
	}
);

/**
 * Redirect any access attempt to the comments page in the admin.
 */
add_action(
	'admin_init',
	function () {
		global $pagenow;

		if ( 'edit-comments.php' === $pagenow ) {
			wp_safe_redirect( admin_url() );
			exit;
		}
	}
);

/**
 * Remove the 'Recent Comments' meta box from the dashboard.
 */
add_action(
	'wp_dashboard_setup',
	function () {
		remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
	}
);

/**
 * Remove the comments menu item from the admin bar.
 */
add_action(
	'wp_before_admin_bar_render',
	function () {
		if ( is_admin_bar_showing() ) {
			global $wp_admin_bar;
			$wp_admin_bar->remove_menu( 'comments' );
		}
	}
);

/**
 * Remove the Comments endpoint from the REST API.
 *
 * @param array $endpoints List of REST API endpoints.
 * @return array Modified list of REST API endpoints.
 */
add_filter(
	'rest_endpoints',
	function ( $endpoints ) {
		if ( isset( $endpoints['comments'] ) ) {
			unset( $endpoints['comments'] );
		}
		if ( isset( $endpoints['/wp/v2/comments'] ) ) {
			unset( $endpoints['/wp/v2/comments'] );
		}

		return $endpoints;
	}
);

/**
 * Modify Editor role capabilities.
 */
function add_editor_menu_access() {
	// Get the Editor role.
	$role = get_role( 'editor' );

	// Add 'edit_theme_options' capability to Editors.
	$role->add_cap( 'edit_theme_options' );

	// Remove access to theme-related options.
	$role->remove_cap( 'customize' ); // Customizer access.
	$role->remove_cap( 'edit_theme_editor' ); // Theme Editor access.
	$role->remove_cap( 'edit_patterns' ); // Patterns access.
	$role->remove_cap( 'manage_options' ); // Remove access to all other theme options (just in case).
	$role->remove_cap( 'activate_plugins' ); // Prevent plugin activation.
	$role->remove_cap( 'edit_plugins' ); // Prevent plugin editing.
	$role->remove_cap( 'edit_files' ); // Prevent file editing.
}
add_action( 'admin_init', 'add_editor_menu_access' );

/**
 * Checks for ACF plugin to be active
 */
function mytheme_acf_required_notice() {
	if ( ! class_exists( 'ACF' ) ) {
		echo '<div class="notice notice-error"><p>';
		echo 'Dit thema vereist <strong>ACF PRO</strong>. Installeer en activeer de plugin om het thema goed te laten werken.';
		echo '</p></div>';
	}
}
add_action( 'admin_notices', 'mytheme_acf_required_notice' );

/**
 * Enable SVG upload support
 *
 * @param array $mimes Existing mime types.
 * @return array Modified mime types.
 */
function enable_svg_upload( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'enable_svg_upload' );
