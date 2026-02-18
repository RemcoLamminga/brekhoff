<?php
// Retrieve fields from ACF.
$title   = get_field( 'field_text_content_title' );
$content = get_field( 'field_text_content' );

// Check if preview mode is enabled.
if ( ! empty( $block['data']['_is_preview'] ) ) {
	// Get the current PHP file's URL for preview purposes.
	$file = __DIR__; // Current PHP file, but can be any.
	$url  = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $file );
	?>
	<figure style="margin: 0; width: 100%; height: auto;">
		<img src="<?php echo esc_url( $url . '/preview.jpg' ); ?>"
			alt="Preview of what the Accordion custom block appears minimized"
			style="width: 100%; height: auto;">
	</figure>
	<?php
} else {
	?>
	<section class="text-content">
		<div class="container">
			<div class="text-content__container">
				<?php if ( $title ) : ?>
					<h1 class="title"><?php echo esc_attr( $title ); ?></h1>
				<?php endif; ?>
				<?php if ( $content ) : ?>
					<p class="desc"><?php echo wp_kses_post( apply_filters( 'the_content', $content ) ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php
}
?>
