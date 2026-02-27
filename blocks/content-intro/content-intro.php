<?php
/**
 * Render template for the Content Intro block.
 *
 * @package YourThemeOrPlugin
 */

$block_name = 'content-intro';

// ACF velden ophalen
$image = get_field($block_name . '_image');
$focal_group = get_field($block_name . '_image_focal_point');
$focal_x = $focal_group['focal_x'] ?? 50;
$focal_y = $focal_group['focal_y'] ?? 50;
$switch = get_field($block_name . '_switch_image_text'); // links | rechts

$eyebrow = get_field($block_name . '_eyebrow');
$title = get_field($block_name . '_title');
$content = get_field($block_name . '_content');
$buttons = get_field($block_name . 'buttons'); // repeater (max 1)

// Bepaal layout class
$layout_class = ($switch === 'links')
	? 'layout-left'
	: 'layout-right';


	// Preview mode (Gutenberg inserter example).
if (!empty($block['data']['_is_preview'])) {
    $dir_path = __DIR__;
    $url = str_replace(WP_CONTENT_DIR, WP_CONTENT_URL, $dir_path);
    ?>
    <figure style="margin: 0; width: 100%; height: auto;">
        <img src="<?php echo esc_url($url . '/preview.jpg'); ?>"
            alt="<?php echo esc_attr('Content Intro block preview'); ?>" style="width: 100%; height: auto;" />
    </figure>
    <?php
    return;
}
?>

<section  class="<?php echo esc_attr($block_name); ?> ">
	<div class="container">
		<div class="<?php echo esc_attr($block_name); ?>__inner <?php echo $layout_class; ?>">

			<!-- Afbeeldingskolom -->
			<div class="<?php echo esc_attr($block_name); ?>__image" style="
				background-image:url('<?php echo esc_url($image); ?>');
				background-size:cover;
				background-position: <?php echo intval($focal_x); ?>% <?php echo intval($focal_y); ?>%;
			 ">
			</div>

			<!-- Tekstkolom -->
			<div class="<?php echo esc_attr($block_name); ?>__content">
				<div class="<?php echo esc_attr($block_name); ?>__content-inner">
					<?php if ($eyebrow): ?>
						<div class="<?php echo esc_attr($block_name); ?>__eyebrow eyebrow"><?php echo esc_html($eyebrow); ?>
						</div>
					<?php endif; ?>

					<?php if ($title): ?>
						<h2 class="<?php echo esc_attr($block_name); ?>__title"><?php echo esc_html($title); ?></h2>
					<?php endif; ?>

					<?php if ($content): ?>
						<div class="<?php echo esc_attr($block_name); ?>__text"><?php echo wp_kses_post($content); ?></div>
					<?php endif; ?>

					<?php
					if ($buttons && is_array($buttons)) {
						foreach ($buttons as $btn) {
							if (!empty($btn['link'])) {
								$link = $btn['link'];
								?>
								<a class="<?php echo esc_attr($block_name); ?>__button primary-button" href="<?php echo esc_url($link['url']); ?>"
									target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
									<?php echo esc_html($link['title']); ?><img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/arrow.svg'); ?>"
                            class="btn-arrow" alt="">
								</a>
								<?php
							}
						}
					}
					?>
				</div>
			</div>
		</div>
	</div>
</section>