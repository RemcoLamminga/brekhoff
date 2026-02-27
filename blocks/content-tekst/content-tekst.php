<?php
/**
 * Render template for the Content Tekst block.
 *
 * @package YourThemeOrPlugin
 */

$block_name = 'content-tekst';

// Retrieve fields from ACF (field names, not field keys).
$eyebrow = get_field($block_name . '_eyebrow');
$title   = get_field( $block_name . '_title' );
$content = get_field( $block_name . '_content' );

// Preview mode (Gutenberg inserter example).
if ( ! empty( $block['data']['_is_preview'] ) ) {
	$dir_path = __DIR__;
	$url      = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $dir_path );
	?>
	<figure style="margin: 0; width: 100%; height: auto;">
		<img
			src="<?php echo esc_url( $url . '/preview.jpg' ); ?>"
			alt="<?php echo esc_attr( 'Content Tekst block preview' ); ?>"
			style="width: 100%; height: auto;"
		/>
	</figure>
	<?php
	return;
}

?>
<section class="<?php echo esc_attr( $block_name ); ?>">
	<div class="container">
		<div class="<?php echo esc_attr( $block_name ); ?>__container">
			<?php if ($eyebrow): ?>
						<div class="<?php echo esc_attr($block_name); ?>__eyebrow eyebrow"><?php echo esc_html($eyebrow); ?>
						</div>
					<?php endif; ?>
			<?php if ( ! empty( $title ) ) : ?>
				<h2 class="title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( $content ) ) : ?>
				<div class="<?php echo esc_attr( $block_name ); ?>__desc">
					<?php echo wp_kses_post( wpautop( $content ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
