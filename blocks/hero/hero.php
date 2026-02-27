<?php

$block_name = 'hero';
// Retrieve fields from ACF.
$eyebrow = get_field('hero_eyebrow');
$title = get_field('hero_title');
$paragraph = get_field('hero_paragraph');
$text_rows = get_field('hero_text_repeater');
$buttons = get_field('hero_buttons'); // repeater (max 2)
$image = get_field('hero_image');

// Check if an image exists, otherwise fallback to a default image.
$image_url = $image ? esc_url($image) : '';

//text_class = !empty($text_rows) ? $block_name . '--gap' : $block_name . '--none';

$is_page_img = is_page('9') ? '' : 'page-img' ;


if (!empty($block['data']['_is_preview'])) {
	// Get the current PHP file's URL for preview purposes.
	$file = __DIR__; // Current PHP file, but can be any.
	$url = str_replace(WP_CONTENT_DIR, WP_CONTENT_URL, $file);
	?>
	<figure style="margin: 0;">
		<img src="<?php echo esc_url($url . '/preview.jpg'); ?>"
			alt="Preview of what the Accordion custom block appears minimized" style="width: 100%; height: auto;">
	</figure>
	<?php
} else {
	?>
	<section class="hero" style="--hero-bg-image: url('<?php echo $image_url; ?>');">
		<div class="container">
			<div class="hero-content__container">
					<div class="left hero--gap">
							<?php if ($eyebrow): ?>
								<span class="eyebrow"><?php echo esc_html($eyebrow); ?></span>
							<?php endif; ?>
							<?php if ($title): ?>
								<h1 class="title"><?php echo esc_attr($title); ?></h1>
							<?php endif; ?>
							<?php if ($paragraph): ?>
								<p class="desc"><?php echo wp_kses_post(apply_filters('the_content', $paragraph)); ?></p>
							<?php endif; ?>
							<?php if ($text_rows): ?>
								<div class="hero-extra-text">
									<?php foreach ($text_rows as $row) {
										echo '<p><img src="/wp-content/themes/brekhoff/assets/images/check-hero.svg" alt="" class="hero-text-icon">' . esc_html($row['text_item']) . '</p>';
									} ?>
								</div>
							<?php endif; ?>
							<?php
							$index = 0; // Teller voor de knoppen
							if ($buttons && is_array($buttons)) { ?>

								<div class="hero__buttons__inner">
									<?php foreach ($buttons as $btn) {
										if (!empty($btn['link'])) {
											$link = $btn['link'];


											// Eenvoudige button-class op basis van positie
											$button_class = $index === 0 ? 'primary-button' : 'secondary-button';

											?>
											<a class="hero__button <?php echo esc_attr($button_class); ?>"
												href="<?php echo esc_url($link['url']); ?>"
												target="<?php echo esc_attr($link['target'] ?: '_self'); ?>">
												<?php echo esc_html($link['title']); ?><img
													src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/arrow-dark.svg'); ?>"
													class="btn-arrow" alt="">
											</a>
											<?php
											$index++;
										}
									} ?>
								</div>
							<?php }
							?>
						
				</div>
				<div class="right">
					<?php if ($image_url): ?>
						<img class="image <?php echo $is_page_img;?>" src="<?php echo esc_url($image_url); ?>" width="800px" height="800px" />
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}
?>