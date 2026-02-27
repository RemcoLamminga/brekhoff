<?php
/**
 * Template for Content USP block.
 */

$block_name = 'content-usp';


$title   = get_field($block_name . '_title');
$content = get_field($block_name . '_content');
$items   = get_field($block_name . '_items');


// Preview mode (Gutenberg inserter example).
if ( ! empty( $block['data']['_is_preview'] ) ) {
	$dir_path = __DIR__;
	$url      = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, $dir_path );
	?>
	<figure style="margin: 0; width: 100%; height: auto;">
		<img
			src="<?php echo esc_url( $url . '/preview.jpg' ); ?>"
			alt="<?php echo esc_attr( 'Content USP block preview' ); ?>"
			style="width: 100%; height: auto;"
		/>
	</figure>
	<?php
	return;
}


?>

<section class="<?php echo $block_name;?>">
<div class="container">
    <?php if (!empty($title)): ?>
        <h3 class="<?php echo $block_name;?>__title">
            <?= esc_html($title); ?>
        </h3>
    <?php endif; ?>

    <?php if (!empty($content)): ?>
        <div class="<?php echo $block_name;?>__intro">
            <?= wp_kses_post($content); ?>
        </div>
    <?php endif; ?>

    <div class="<?php echo $block_name;?>__grid" >

        <?php foreach ($items as $item): ?>
            <?php
            $icon = $item['icon'] ?? null;
            $item_title = trim($item['title'] ?? '');
            $item_text = trim($item['text'] ?? '');
            ?>
            
            <article class="<?php echo $block_name;?>__item">

                <?php if (!empty($icon)): ?>
                    <div class="<?php echo $block_name;?>__icon" aria-hidden="true">
                        <?php
                        $mime = $icon['mime_type'] ?? '';

                        // SVG inline output
                        if ($mime === 'image/svg+xml' && !empty($icon['ID'])) {
                            $path = get_attached_file($icon['ID']);
                            if ($path && file_exists($path)) {
                                echo file_get_contents($path); // eventueel sanitizen
                            }
                        } else {
                            // fallback naar image tag
                            printf(
                                '<img src="%s" alt="" loading="lazy" width="%d" height="%d" />',
                                esc_url($icon['url']),
                                isset($icon['width']) ? (int) $icon['width'] : 64,
                                isset($icon['height']) ? (int) $icon['height'] : 64
                            );
                        }
                        ?>
                    </div>
                <?php endif; ?>

                <?php if ($item_title): ?>
                    <h3 class="<?php echo $block_name;?>__item-title">
                        <?= esc_html($item_title); ?>
                    </h3>
                <?php endif; ?>

                <?php if ($item_text): ?>
                    <p class="<?php echo $block_name;?>__item-text">
                        <?= esc_html($item_text); ?>
                    </p>
                <?php endif; ?>

            </article>
        <?php endforeach; ?>

    </div>
</div>
</section>