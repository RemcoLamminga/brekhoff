# 📦 Thema Werkwijze – Gutenberg Blokken

Dit thema maakt gebruik van **custom Gutenberg blokken** op basis van **ACF (Advanced Custom Fields)**.  
Elk blok wordt gedefinieerd in de map `/blocks` en bestaat uit een eigen map met configuratie-, template- en stijlbestanden.

---

## 🧱 Structuur van een blok

Om een nieuw Gutenberg blok aan te maken, maak je een nieuwe map aan in de folder: `/blocks`


De **naam van de map** moet:
- volledig **lowercase** zijn
- overeenkomen met de **bloknaam**

Voorbeeld: /blocks/hero


---

## 📁 Vereiste bestanden

Elk blok moet minimaal de volgende bestanden bevatten:

| Bestand | Omschrijving |
|----------|---------------|
| `[bloknaam]-config.php` | Registreert het blok met `acf_register_block_type()` en koppelt velden via `acf_add_local_field_group()`. |
| `[bloknaam].php` | Templatebestand voor de weergave van het blok. Hierin worden de ACF-velden uitgelezen en de HTML-output bepaald. |
| `[bloknaam].css` | Bevat de styling van het blok. Dit wordt op de frontend geladen. |
| `preview.jpg` | Preview-afbeelding van het blok, zoals zichtbaar in de Gutenberg-editor. Idealiter een export uit Figma. |

---

## ⚙️ Registratie van een blok

In het bestand `block.json` wordt het blok geregistreerd.  
Een voorbeeld van een minimale configuratie:

```json
{
    "name": "acf/hero",
    "title": "Hero",
    "description": "A custom hero block that uses ACF fields.",
    "style": [ "file:./hero.css" ],
    "script": [ "file:./hero.js" ],
    "category": "formatting",
    "icon": "star-filled",
    "keywords": ["hero", "banner"],
    "acf": {
        "mode": "preview",
        "renderTemplate": "hero.php",
        "validate": "false"
    },
    "supports": {
        "anchor": true
    }
}
```

## Daarnaast kunnen in het bijbehorende [blocknaam]-config.php bestand de bijbehorende ACF velden worden geregistreerd met acf_add_local_field_group().
Aanrader: Genereer deze code met ChatGPT
```php
 // Field group
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group([
            'key' => 'group_hero',
            'title' => 'Hero Sectie',
            'fields' => [
                ['key'=>'field_hero_eyebrow','label'=>'Eyebrow','name'=>'hero_eyebrow','type'=>'text','default_value'=>'Lorem ipsum'],
                ['key'=>'field_hero_title','label'=>'Titel','name'=>'hero_title','type'=>'text','default_value'=>'Lorem ipsum'],
                ['key'=>'field_hero_paragraph','label'=>'Paragraaf','name'=>'hero_paragraph','type'=>'textarea','default_value'=>'Lorem ipsum dolor sit amet, consectetur adipiscing elit…'],
                ['key'=>'field_hero_button_text','label'=>'Knop Tekst','name'=>'hero_button_text','type'=>'text'],
                ['key'=>'field_hero_button_link','label'=>'Knop Link','name'=>'hero_button_link','type'=>'url'],
                ['key'=>'field_hero_image','label'=>'Afbeelding','name'=>'hero_image','type'=>'image','return_format'=>'url','preview_size'=>'medium','library'=>'all'],
            ],
            'location' => [[['param'=>'block','operator'=>'==','value'=>'acf/'.$block_name]]],
        ]);
    }
```

## Het bouwen van een blok
Het blok wordt gemaakt met standaard PHP. Denk er om dat wanneer je een WYSIWYG-veld gebruikt je de content hiervan als volgt laat zien:

```php
    echo apply_filters( 'the_content', $content );
```

Hierdoor worden shortcodes ook ingeladen!

## 🎨 Styling ([bloknaam].css)
De CSS-bestanden worden per blok ingeladen via de enqueue_style-parameter in het configuratiebestand.
Zo blijft elk blok volledig modulair en zelfstandig.

## 🖼️ Preview (preview.jpg)
De preview-afbeelding wordt getoond in de Gutenberg-editor.
Maak bij voorkeur een export uit Figma met de juiste afmetingen en naamgeving: preview.jpg


## 🚀 Samenvatting Werkwijze
1. Maak een nieuwe map aan in /blocks (lowercase naam).
2. Voeg de 4 vereiste bestanden toe:
- block.json
- [bloknaam]-config.php
- [bloknaam].php
- [bloknaam].css
- preview.jpg
3. Registreer het blok in het config-bestand met acf_register_block_type().
4. Voeg velden toe via acf_add_local_field_group().
5. Bouw de frontend in [bloknaam].php.
6. Style het blok in [bloknaam].css.
7. Voeg een preview afbeelding toe.