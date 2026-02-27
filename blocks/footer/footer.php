<?php
// Block name for field keys and classes.
$block_name = 'footer';

// Retrieve fields from ACF.

$logo = get_field($block_name . '_logo');
$right_text = get_field($block_name . '_right_text');
$buttons = get_field($block_name . 'buttons'); // repeater (max 1)

// Menus (WordPress)
$footer_menu = 'footer-menu';      // Onder logo
$privacy_menu = 'privacy-menu';     // Onder de lijn


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

	<section class="<?php echo esc_attr($block_name); ?>">
		<div class="container">
			<div class="<?php echo esc_attr($block_name); ?>__container">

				<div class="<?php echo esc_attr($block_name); ?>__top">

					<!-- LEFT SIDE -->
					<div class="<?php echo esc_attr($block_name); ?>__left">

						<!-- Logo -->
						<?php if (!empty($logo)): ?>
							<div class="<?php echo esc_attr($block_name); ?>__logo">
								<img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>">
							</div>
						<?php endif; ?>

						<!-- Footer Navigation (left) -->
						<nav class="<?php echo esc_attr($block_name); ?>__menu">
							<?php
							wp_nav_menu([
								'theme_location' => $footer_menu,
								'container' => false,
								'menu_class' => $block_name . '__menu-list',
								'fallback_cb' => false,
								'depth' => 1,
							]);
							?>
						</nav>

					</div>

					<!-- RIGHT SIDE -->
					<div class="<?php echo esc_attr($block_name); ?>__right">

						<?php if (!empty($right_text)): ?>
							<div class="<?php echo esc_attr($block_name); ?>__text">
								<?php echo wp_kses_post(nl2br($right_text)); ?>
							</div>
						<?php endif; ?>

						<!-- Buttons Repeater -->
						<?php
						if (!empty($buttons) && is_array($buttons)) {
							echo '<div class="' . esc_attr($block_name) . '__buttons">';
							foreach ($buttons as $btn) {

								if (!empty($btn['link']) && is_array($btn['link'])) {
									$link = $btn['link']; ?>

									<a class="<?php echo esc_attr($block_name); ?>__button primary-button"
										href="<?php echo esc_url($link['url']); ?>"
										target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
										<?php echo esc_html($link['title']); ?>

										<img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/arrow-dark.svg'); ?>"
											class="btn-arrow" alt="">
									</a>

									<?php
								}
							}
							echo '</div>';
						}
						?>

					</div>

				</div>

				<hr class="<?php echo esc_attr($block_name); ?>__divider">

				<div class="<?php echo esc_attr($block_name); ?>__bottom">

					<!-- Privacy menu bottom-left -->
					<nav class="<?php echo esc_attr($block_name); ?>__privacy-menu">
						<?php
						wp_nav_menu([
							'theme_location' => $privacy_menu,
							'container' => false,
							'menu_class' => $block_name . '__privacy-list',
							'fallback_cb' => false,
							'depth' => 1,
						]);
						?>
					</nav>

					<!-- Credits bottom-right -->
					<div class="<?php echo esc_attr($block_name); ?>__credits">
						© <?php echo date('Y'); ?> Copyright Brekhoff - Realisatie:
						<a class="<?php echo esc_attr($block_name); ?>__credits-link" href="https://donderz.nl/"
							target="_blank">
							Donderz
						</a>
					</div>

				</div>

			</div>

		</div>
	</section>
