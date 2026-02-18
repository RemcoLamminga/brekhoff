<?php
// Block name for field keys and classes.
$block_name = 'footer';

// Retrieve fields from ACF.
$contact_info = get_field( 'field_' . $block_name . '_contact_info' );
$footer_links = get_field( 'field_' . $block_name . '_footer_links' );

// Check if preview mode is enabled.
if ( ! empty( $block['data']['_is_preview'] ) ) {
	// Get the current PHP file's URL for preview purposes.
	$file = __DIR__; // Current PHP file, but can be any.
	$url  = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $file );
	?>
	<figure style="margin: 0; width: 100%; height: auto;">
		<img src="<?php echo esc_url( $url . '/preview.jpg' ); ?>"
			alt="Preview of what the custom block appears minimized"
			style="width: 100%; height: auto;">
	</figure>
	<?php
} else {
	?>
	<section class="<?php echo esc_attr( $block_name ); ?>">
		<div class="container">
			<div class="<?php echo esc_attr( $block_name ); ?>__container">

				<!-- Contact Info -->
				<div class="contact-info">
					<?php if ( $contact_info ) : ?>
						<p><?php echo esc_html( $contact_info ); ?></p>
					<?php endif; ?>
				</div>

				<!-- Footer Navigation Links -->
				<div class="footer-links">
					<?php if ( $footer_links ) : ?>
						<ul>
							<?php foreach ( $footer_links as $footer_link ) : ?>
								<li><a href="<?php echo esc_url( $footer_link['footer_link_url'] ); ?>"><?php echo esc_html( $footer_link['footer_link_label'] ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
			</div>
			<span>Website door: <a class="credits" href="https://donderz.nl/">Donderz</a></span>
		</div>
	</section>
	<?php
}
?>
