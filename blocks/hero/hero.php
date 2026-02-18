<?php
// Retrieve fields from ACF.
$eyebrow     = get_field( 'hero_eyebrow' );
$title       = get_field( 'hero_title' );
$paragraph   = get_field( 'hero_paragraph' );
$button_text = get_field( 'hero_button_text' );
$button_link = get_field( 'hero_button_link' );
$image       = get_field( 'hero_image' );

// Check if an image exists, otherwise fallback to a default image.
$image_url = $image ? $image : '';

if ( ! empty( $block['data']['_is_preview'] ) ) {
	// Get the current PHP file's URL for preview purposes.
	$file = __DIR__; // Current PHP file, but can be any.
	$url  = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $file );
	?>
	<figure style="margin: 0;">
		<img src="<?php echo esc_url( $url . '/preview.jpg' ); ?>"
			alt="Preview of what the Accordion custom block appears minimized"
			style="width: 100%; height: auto;">
	</figure>
	<?php
} else {
	?>
	<section class="hero">
		<div class="container">
			<div class="hero-content__container">
				<div class="left">
					<?php if ( $eyebrow ) : ?>
						<span class="eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
					<?php endif; ?>
					<?php if ( $title ) : ?>
						<h1 class="title"><?php echo esc_attr( $title ); ?></h1>
					<?php endif; ?>
					<?php if ( $paragraph ) : ?>
						<p class="desc"><?php echo wp_kses_post( apply_filters( 'the_content', $paragraph ) ); ?></p>
					<?php endif; ?>
					<?php if ( $button_text && $button_link ) : ?>
						<a href="<?php echo esc_url( $button_link ); ?>"
							class="primary-button hero-button"><?php echo esc_html( $button_text ); ?></a>
					<?php endif; ?>
				</div>
				<div class="right">
					<?php if ( $image_url ) : ?>
						<img class="image" src="<?php echo esc_url( $image_url ); ?>" width="800px" height="800px" />
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
	<?php
}
?>
