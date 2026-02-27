<?php
/**
 * Render template for the Content Contact block.
 *
 * @package YourThemeOrPlugin
 */

$block_name = 'content-contact';

/**
 * 1. Velden ophalen (zonder helpers)
 */
$style = get_field($block_name . '_style') ?: 'none';
$title = get_field($block_name . '_title');
$content = get_field($block_name . '_content');
$form_shortcode = get_field($block_name . '_form_shortcode');

$show_contact_info = get_field($block_name . '_show_contact_info');
if ($show_contact_info === null) {
	$show_contact_info = 1; // default: tonen
}

// Contact tab
$contact_title = get_field($block_name . '_contact_title') ?: 'Direct contact';
$phone = get_field($block_name . '_phone');
$email = get_field($block_name . '_email');

// Spoed tab
$em_title = get_field($block_name . '_emergency_title') ?: 'Spoedkeuring nodig?';
$em_text = get_field($block_name . '_emergency_text');
$em_phone = get_field($block_name . '_emergency_phone');


/**
 * 2. Link formatting
 */
$tel_href = $phone ? 'tel:' . preg_replace('/[^0-9\+]/', '', $phone) : '';
$email_href = $email ? 'mailto:' . sanitize_email($email) : '';
$em_tel_href = $em_phone ? 'tel:' . preg_replace('/[^0-9\+]/', '', $em_phone) : '';


/**
 * 3. CSS classes
 */
$base_class = 'content-contact';
$style_class = ($style === 'dark') ? $base_class . '--dark' : $base_class . '--none';
$classes = $base_class . ' ' . $style_class;


/**
 * 4. Preview mode voor editor
 */
if (!empty($block['data']['_is_preview'])) {
	$dir_path = __DIR__;
	$url = str_replace(WP_CONTENT_DIR, WP_CONTENT_URL, $dir_path);
	?>
	<figure style="margin:0;width:100%;height:auto;">
		<img src="<?php echo esc_url($url . '/preview.jpg'); ?>"
			alt="<?php echo esc_attr('Content Contact block preview'); ?>" style="width:100%;height:auto;" />
	</figure>
	<?php
	return;
}
?>

<section class="<?php echo esc_attr($classes); ?>">
	<div class="container">
		<div class="<?php echo esc_attr($base_class); ?>__inner">

			<?php if ($title || $content): ?>
				<header class="<?php echo esc_attr($base_class); ?>__header">
					<?php if ($title): ?>
						<h2 class="<?php echo esc_attr($base_class); ?>__title"><?php echo esc_html($title); ?></h2>
					<?php endif; ?>

					<?php if ($content): ?>
						<div class="<?php echo esc_attr($base_class); ?>__intro">
							<?php echo wp_kses_post($content); ?>
						</div>
					<?php endif; ?>
				</header>
			<?php endif; ?>


			<?php
			$grid_class = $base_class . '__grid';
			if (!$show_contact_info) {
				$grid_class .= ' ' . $base_class . '__grid--single';
			}
			?>
			<div class="<?php echo esc_attr($grid_class); ?>">


				<!-- FORM -->
				<div class="<?php echo esc_attr($base_class); ?>__form">
					<?php if ($form_shortcode): ?>
						<?php echo do_shortcode($form_shortcode); ?>
					<?php elseif (current_user_can('edit_posts')): ?>
						<p class="<?php echo esc_attr($base_class); ?>__form--placeholder">
							<?php esc_html_e('Plaats een Gravity Forms shortcode in het blok om het formulier te tonen.', 'your-textdomain'); ?>
						</p>
					<?php endif; ?>
				</div>

				<!-- CONTACT & SPOED -->
				<?php if ($show_contact_info): ?>
					<aside class="<?php echo esc_attr($base_class); ?>__sidebar">

						<?php
						$has_contact = ($contact_title || $phone || $email);
						if ($has_contact):
							?>
							<div
								class="<?php echo esc_attr($base_class); ?>__panel <?php echo esc_attr($base_class); ?>__panel--contact">
								<?php if ($contact_title): ?>
									<h3 class="<?php echo esc_attr($base_class); ?>__panel-title">
										<?php echo esc_html($contact_title); ?>
									</h3>
								<?php endif; ?>

								<ul class="<?php echo esc_attr($base_class); ?>__list" role="list">
									<?php if ($phone): ?>
										<li class="<?php echo esc_attr($base_class); ?>__item">

											<div class="contact-info-row contact-info-phone">
												<span class="contact-info-icon"></span>
												<span class="contact-info-label">Telefoon</span>
											</div>

											<a class="<?php echo esc_attr($base_class); ?>__link"
												href="<?php echo esc_url($tel_href); ?>">
												<!-- <span class="<?php //echo esc_attr($base_class); ?>__icon"></span> -->
												<?php echo esc_html($phone); ?>
											</a>
										</li>
									<?php endif; ?>

									<?php if ($email): ?>
										<li class="<?php echo esc_attr($base_class); ?>__item">

											<div class="contact-info-row contact-info-email">
												<span class="contact-info-icon"></span>
												<span class="contact-info-label">E-mail</span>
											</div>

											<a class="<?php echo esc_attr($base_class); ?>__link"
												href="<?php echo esc_url($email_href); ?>">
												<!-- <span class="<?php //echo esc_attr($base_class); ?>__icon"></span> -->
												<?php echo esc_html($email); ?>
											</a>
										</li>
									<?php endif; ?>
								</ul>
							</div>
						<?php endif; ?>

						<?php
						$has_emergency = ($em_title || $em_text || $em_phone);
						if ($has_emergency):
							?>
							<div
								class="<?php echo esc_attr($base_class); ?>__panel <?php echo esc_attr($base_class); ?>__panel--emergency">
								<?php if ($em_title): ?>
									<h4 class="<?php echo esc_attr($base_class); ?>__panel-title">
										<?php echo esc_html($em_title); ?>
									</h4>
								<?php endif; ?>

								<?php if ($em_text): ?>
									<div class="<?php echo esc_attr($base_class); ?>__panel-text">
										<?php echo wp_kses_post(wpautop($em_text)); ?>
									</div>
								<?php endif; ?>

								<?php if ($em_phone): ?>
									<p class="<?php echo esc_attr($base_class); ?>__emergency-cta">
										<a class="<?php echo esc_attr($base_class); ?>__button <?php echo esc_attr($base_class); ?>__button--phone"
											href="<?php echo esc_url($em_tel_href); ?>">
											<?php echo esc_html($em_phone); ?><img class="btn-arrow" src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/arrow.svg'); ?>">
										</a>
									</p>
								<?php endif; ?>
							</div>
						<?php endif; ?>

					</aside>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>