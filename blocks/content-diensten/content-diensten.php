<?php
/**
 * Render template for the Content Diensten block.
 *
 * @package YourThemeOrPlugin
 */

$block_name = 'content-diensten';


$keuringen = new WP_Query([
	'post_type' => 'keuring',
	'posts_per_page' => -1,
	
	'order' => 'ASC',
]);



// Preview mode (Gutenberg inserter example).
if (!empty($block['data']['_is_preview'])) {
	$dir_path = __DIR__;
	$url = str_replace(WP_CONTENT_DIR, WP_CONTENT_URL, $dir_path);
	?>
	<figure style="margin: 0; width: 100%; height: auto;">
		<img src="<?php echo esc_url($url . '/preview.jpg'); ?>"
			alt="<?php echo esc_attr('Content Diensten block preview'); ?>" style="width: 100%; height: auto;" />
	</figure>
	<?php
	return;
}

?>
<section class="<?php echo esc_attr($block_name); ?>">
	<div class="container">
		<?php if ($keuringen->have_posts()):
			$i = 0; ?>


			<div class="diensten-list">

				<?php while ($keuringen->have_posts()):
					$keuringen->the_post(); ?>

					<?php
					// Bepaal even/oneven → layout
					$is_even = $i % 2 === 0;
					$layout_class = $is_even ? 'layout-text-left' : 'layout-text-right';
					?>


					<article class="dienst-item <?php echo $layout_class; ?>">
						<div class="dienst-item__inner">
							<div class="dienst-image">
								<?php the_post_thumbnail('large'); ?>
							</div>

							<div class="dienst-text">
								<h3><?php the_title(); ?></h3>
								<p><?php echo get_the_excerpt(); ?></p>
								<a href="<?php the_permalink(); ?>" class="primary-button btn">Meer informatie <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/arrow.svg'); ?>"
                            class="btn-arrow" alt=""></a>
							</div>
						</div>
					</article>

					<?php $i++; endwhile; ?>
			</div>

			<?php wp_reset_postdata(); ?>

		<?php endif; ?>

	</div>
</section>