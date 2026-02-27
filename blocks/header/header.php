<?php
// Block name for field keys and classes.
$block_name = 'header';

// Preview mode (Gutenberg inserter example).
if (!empty($block['data']['_is_preview'])) {
    $dir_path = __DIR__;
    $url = str_replace(WP_CONTENT_DIR, WP_CONTENT_URL, $dir_path);
    ?>
    <figure style="margin: 0; width: 100%; height: auto;">
        <img src="<?php echo esc_url($url . '/preview.jpg'); ?>"
            alt="<?php echo esc_attr('Header block preview'); ?>" style="width: 100%; height: auto;" />
    </figure>
    <?php
    return;
}
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
				<a href="/offerte" class="primary-button offerte">Offerte aanvragen
					
				</a>
				</div>
				<!-- Header actions -->
				<div class="header-actions">

					<!-- Hamburger menu button voor mobiel -->
					<button class="hamburger-menu" aria-label="Open menu" aria-expanded="false">
						<span class="hamburger-line"></span>
						<span class="hamburger-line"></span>
						<span class="hamburger-line"></span>
					</button>
				</div>
			</div>
		</div>
	</section>
