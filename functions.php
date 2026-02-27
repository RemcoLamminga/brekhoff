<?php



add_action('init', function () {
    $blocks = fetch_blocks(); // jouw eigen functie
    error_log('BLOCK FOLDERS FOUND BY SCRIPT:');
    foreach ($blocks as $b) {
        error_log($b);
    }
});


// Include necessary files for theme functionality.
require get_parent_theme_file_path( 'includes/block-registration.php' );
require get_parent_theme_file_path( 'includes/posttype-registration.php' );
require get_parent_theme_file_path( 'includes/pattern-registration.php' );
require get_parent_theme_file_path( 'includes/posttype-presets.php' );
require get_parent_theme_file_path( 'includes/helpers.php' );
require get_parent_theme_file_path( 'includes/admin/admin-functions.php' );

/**
 * Theme setup function to initialize theme features.
 */
function theme_setup() {
	// Support for various theme features.
	add_theme_support( 'title-tag' );  // Automatically sets the title in the browser.
	add_theme_support( 'post-thumbnails' );  // Enables featured images.
	add_theme_support( 'custom-logo' );  // Enable Logo
	add_theme_support( 'block-patterns' ); // Enable block patterns.

	// Register navigation menus.
	register_nav_menus(
		[
			'header-menu'  => __( 'Header Menu' ),  // Header menu location.
			'privacy-menu' => __( 'Privacy Menu' ),  // Privacy page menu location.
			'footer-menu' => __( 'Footer Menu' ),  // Privacy page menu location.
		]
	);
}
add_action( 'after_setup_theme', 'theme_setup' );

/**
 * Deactivates Gutenberg styles in the admin and frontend.
 */
function donderz_deactivate_gutenberg_styles() {

	$script_path = get_template_directory_uri() . '/assets/js/script.js';

	// Register the script
	wp_register_script(
		'theme-script', // Unique handle for the script
		$script_path,   // Path to the script
		[ 'jquery' ],        // Dependencies (if any)
		filemtime( get_template_directory() . '/assets/js/script.js' ), // Version based on the file's modification time
		true            // Load in footer (true for footer, false for header)
	);

	// Enqueue custom admin styles in the editor.
	if ( is_admin() ) {
		wp_enqueue_style( 'admin-styles', get_template_directory_uri() . '/includes/admin/admin-styles.css' );
	}

	// Enqueue theme stylesheet.
	wp_enqueue_style( 'themename-style', get_stylesheet_uri() );

	// Enqueue the script
	wp_enqueue_script( 'theme-script' );
}
add_action( 'wp_enqueue_scripts', 'donderz_deactivate_gutenberg_styles', 100 ); // Frontend
add_action( 'admin_enqueue_scripts', 'donderz_deactivate_gutenberg_styles', 100 ); // Editor

/**
 * Register vendor styles and scripts.
 */
function register_vendor_assets() {
	$swiper_script = get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.js';
	$swiper_style  = get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.css';

	// Register and enqueue vendor scripts.
	wp_register_script(
		'swiper-script', // Unique handle for the script
		$swiper_script,   // Path to the script
		[ 'jquery' ],        // Dependencies (if any)
		filemtime( get_template_directory() . '/assets/vendor/swiper/swiper-bundle.min.js' ), // Version based on the file's modification time
		false            // Load in footer (true for footer, false for header)
	);
	wp_enqueue_script( 'swiper-script' );
	wp_register_style(
		'swiper-style', // Unique handle for the style
		$swiper_style,   // Path to the style
		[],        // Dependencies (if any)
		filemtime( get_template_directory() . '/assets/vendor/swiper/swiper-bundle.min.css' ) // Version based on the file's modification time
	);
	wp_enqueue_style( 'swiper-style' );
}

add_action( 'wp_enqueue_scripts', 'register_vendor_assets', 1 );

/**
 * Fonts registreren
 */
function theme_load_fonts() {

	// Preconnect naar Google Fonts
	// echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
	// echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';

	// Registreer een Google Font
	// wp_enqueue_style(
	// 'google-bricolage',
	// 'https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wdth,wght@12..96,75..100,200..800&display=swap',
	// array(),
	// null
	// );

	// Registreer een Adobe Font
	wp_enqueue_style(
	'adobe-typekit',
	'https://use.typekit.net/ecw6cfy.css',  // vervang xxxxxxx door jouw kit ID
	array(),
	null
	);
}
add_action( 'wp_head', 'theme_load_fonts' );
add_action( 'enqueue_block_editor_assets', 'theme_load_fonts' );



	