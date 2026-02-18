#!/bin/bash
#
# Gebruik: ./makeblock.sh <block-naam>
# Voorbeeld: ./makeblock.sh call-to-action

set -euo pipefail

if [ "${1:-}" = "" ]; then
  echo "Gebruik: ./makeblock.sh <block-naam>"
  exit 1
fi

NAME="$1"
DIR="./blocks/$NAME"

# Stop als dit blok al bestaat (map bestaat al)
if [ -d "$DIR" ]; then
  echo "Blok '$NAME' bestaat al: $DIR"
  echo "Stop. Kies een andere naam of verwijder/rename de bestaande map."
  exit 1
fi


# Helper om een nette titel te maken: call-to-action -> Call To Action
TITLE="$(
  echo "$NAME" | awk -F- '{
    for (i=1;i<=NF;i++) {
      printf "%s%s", toupper(substr($i,1,1)) substr($i,2), (i<NF?" ":"")
    }
  }'
)"

mkdir -p "$DIR"

#################################
# block.json
#################################
cat > "$DIR/block.json" <<EOF
{
  "name": "acf/$NAME",
  "title": "$TITLE",
  "description": "A custom $NAME block that uses ACF fields.",
  "style": ["file:./$NAME.css"],
  "script": ["file:./$NAME.js"],
  "category": "category-slug",
  "icon": "star-filled",
  "keywords": ["text", "content", "$NAME"],
  "acf": {
    "mode": "preview",
    "renderTemplate": "$NAME.php",
    "validate": false
  },
  "supports": {
    "anchor": true
  },
  "example": {
    "attributes": {
      "mode": "preview",
      "data": {
        "_is_preview": true
      }
    }
  }
}
EOF

#################################
# NAME-config.php (WPCS)
#################################
cat > "$DIR/$NAME-config.php" <<EOF
<?php
/**
 * Registers the $TITLE block with ACF.
 *
 * @package YourThemeOrPlugin
 */

add_action(
	'init',
	function () {
		// Check if ACF is active and available.
		if ( ! function_exists( 'acf_register_block_type' ) ) {
			// ACF (Pro) is missing or not loaded yet.
			return;
		}

		\$block_name = '$NAME';

		// Register the field group.
		if ( function_exists( 'acf_add_local_field_group' ) ) {
			acf_add_local_field_group(
				array(
					'key'      => 'group_' . \$block_name,
					'title'    => '$TITLE Section',
					'fields'   => array(
						array(
							'key'           => 'field_' . \$block_name . '_title',
							'label'         => 'Titel',
							'name'          => \$block_name . '_title',
							'type'          => 'text',
							'default_value' => 'Lorem ipsum',
						),
						array(
							'key'          => 'field_' . \$block_name . '_content',
							'label'        => 'Inhoud',
							'name'         => \$block_name . '_content',
							'type'         => 'wysiwyg',
							'tabs'         => 'all',  // 'visual', 'text', or 'all'.
							'toolbar'      => 'full', // 'basic' or 'full'.
							'media_upload' => 0,      // Show media button (1) or hide (0).
							'delay'        => 0,      // Initialize editor immediately (0) or on focus (1).
						),
					),
					'location' => array(
						array(
							array(
								'param'    => 'block',
								'operator' => '==',
								'value'    => 'acf/' . \$block_name,
							),
						),
					),
				)
			);
		}
	},
	20
);
EOF

#################################
# NAME.php (WPCS)
#################################
cat > "$DIR/$NAME.php" <<EOF
<?php
/**
 * Render template for the $TITLE block.
 *
 * @package YourThemeOrPlugin
 */

\$block_name = '$NAME';

// Retrieve fields from ACF (field names, not field keys).
\$title   = get_field( \$block_name . '_title' );
\$content = get_field( \$block_name . '_content' );

// Preview mode (Gutenberg inserter example).
if ( ! empty( \$block['data']['_is_preview'] ) ) {
	\$dir_path = __DIR__;
	\$url      = str_replace( WP_CONTENT_DIR, WP_CONTENT_URL, \$dir_path );
	?>
	<figure style="margin: 0; width: 100%; height: auto;">
		<img
			src="<?php echo esc_url( \$url . '/preview.jpg' ); ?>"
			alt="<?php echo esc_attr( '$TITLE block preview' ); ?>"
			style="width: 100%; height: auto;"
		/>
	</figure>
	<?php
	return;
}

?>
<section class="<?php echo esc_attr( \$block_name ); ?>">
	<div class="container">
		<div class="<?php echo esc_attr( \$block_name ); ?>__container">
			<?php if ( ! empty( \$title ) ) : ?>
				<h2 class="title"><?php echo esc_html( \$title ); ?></h2>
			<?php endif; ?>

			<?php if ( ! empty( \$content ) ) : ?>
				<div class="desc">
					<?php echo wp_kses_post( wpautop( \$content ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
EOF

#################################
# NAME.css
#################################
cat > "$DIR/$NAME.css" <<EOF
/**
 * Styles for the $TITLE block.
 */

EOF

#################################
# NAME.js
#################################
cat > "$DIR/$NAME.js" <<EOF
/**
 * JS for the $TITLE block.
 */

/* global jQuery */
jQuery(function ($) {
	// Add interactions or enhancements here if needed.
});
EOF

echo "Block '$NAME' is succesvol aangemaakt in map: $DIR"
