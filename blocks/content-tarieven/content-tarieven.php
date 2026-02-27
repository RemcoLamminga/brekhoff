<?php
/**
 * Render template for the Content Tarieven block.
 */

$block_name = 'content-tarieven';

$eyebrow = get_field($block_name . '_eyebrow');
$title = get_field($block_name . '_title');
$content = get_field($block_name . '_content');
$items = get_field($block_name . '_items');

// Preview mode (Gutenberg inserter example).
if (!empty($block['data']['_is_preview'])) {
    $dir_path = __DIR__;
    $url = str_replace(WP_CONTENT_DIR, WP_CONTENT_URL, $dir_path);
    ?>
    <figure style="margin: 0; width: 100%; height: auto;">
        <img src="<?php echo esc_url($url . '/preview.jpg'); ?>"
            alt="<?php echo esc_attr('Content Tarieven block preview'); ?>" style="width: 100%; height: auto;" />
    </figure>
    <?php
    return;
}
?>

<section class="<?php echo $block_name; ?>">
	<div class="container">
		<div class="<?php echo $block_name; ?>__inner">

			

			<?php if ($title): ?>
				<h2 class="<?php echo $block_name; ?>__title">
					<?php echo esc_html($title); ?>
				</h2>
			<?php endif; ?>

			<?php if ($content): ?>
				<div class="<?php echo $block_name; ?>__content">
					<?php echo wp_kses_post($content); ?>
				</div>
			<?php endif; ?>

			<?php if (!empty($items)): ?>
				<div class="<?php echo $block_name; ?>__cards">

					<?php foreach ($items as $item): ?>
						<?php
						$dienst = $item['dienst'];
						$prijs = $item['prijs'];
						$text = $item['text'];
						$points = $item['checklist'];
						$buttons = $item['buttons'] ?? [];
						?>

						<div class="<?php echo $block_name; ?>__card">


							<?php if ($dienst): ?>
								<h3 class="<?php echo $block_name; ?>__card-title">
									<?php echo esc_html($dienst); ?>
								</h3>
							<?php endif; ?>

							<?php if ($prijs): ?>

								<span class="<?php echo $block_name; ?>__card-price-amount">
									<?php echo esc_html($prijs); ?>
								</span>


							<?php endif; ?>


							<?php if ($text): ?>
								<p class="<?php echo $block_name; ?>__card-text">
									<?php echo esc_html($text); ?>
								</p>
							<?php endif; ?>

							<?php if (!empty($points)): ?>
								<ul class="<?php echo $block_name; ?>__card-checklist">
									<?php foreach ($points as $point): ?>
										<li class="<?php echo $block_name; ?>__card-check">
											<span class="<?php echo $block_name; ?>__card-check-icon"><img
													src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/check.svg'); ?>"></span>
											<?php echo esc_html($point['checklistitem']); ?>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>

							<div class="<?php echo $block_name; ?>__card-footer">

								<?php if (!empty($buttons)): ?>
									<?php
									$btn = $buttons[0]['link'] ?? null; // max 1 in jouw config
									if ($btn && !empty($btn['url'])):
										?>
										<div class="<?php echo $block_name; ?>__card-footer">
											<a class="<?php echo $block_name; ?>__button" href="<?php echo esc_url($btn['url']); ?>"
												target="<?php echo esc_attr($btn['target'] ?: '_self'); ?>">
												<?php echo esc_html($btn['title'] ?: 'Offerte aanvragen'); ?>
											</a>
										</div>
									<?php endif; ?>
								<?php endif; ?>

							</div>
						</div>

					<?php endforeach; ?>

				</div>
			<?php endif; ?>

		</div>
	</div>
</section>