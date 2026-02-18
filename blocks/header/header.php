<?php
// Block name for field keys and classes.
$block_name = 'header';

// Check if preview mode is enabled.
if ( ! empty( $block['data']['_is_preview'] ) ) {
	// Get the current PHP file's URL for preview purposes.
	$file = __DIR__; // Current PHP file, but can be any.
	$url  = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $file );
	?>
	<figure style="margin: 0; width: 100%; height: auto;">
		<img src="<?php echo esc_url( $url . '/preview.jpg' ); ?>" alt="Preview of what the custom block appears minimized"
			style="width: 100%; height: auto;">
	</figure>
	<?php
} else {
	?>
	<section class="<?php echo esc_attr( $block_name ); ?>">
		<div class="container">
			<div class="header-content">
				<!-- Logo aan de linkerkant -->
				<div class="logo">
					<?php
					// Haal het logo op via ACF
					$logo = get_field( 'logo' );

					if ( $logo ) :
						?>
						<a href="<?php echo esc_url( home_url() ); ?>" class="site-logo">
							<img src="<?php echo esc_url( $logo ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						</a>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url() ); ?>" class="site-logo">
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/default-logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
						</a>
					<?php endif; ?>
				</div>

				<!-- Menu aan de rechterkant -->
				<div class="menu">
					<?php
					if ( has_nav_menu( 'header-menu' ) ) {
						wp_nav_menu(
							[
								'theme_location' => 'header-menu',
								'menu_class'     => 'header-menu',
								'container'      => false,
							]
						);
					}
					?>
				</div>
			</div>
		</div>
	</section>
	<?php
}
?>