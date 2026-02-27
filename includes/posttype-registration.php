<?php
// Registreer hier custom posttypes


add_action('init', function () {

    $labels = [
        'name' => 'Keuringen',
        'singular_name' => 'Keuring',
        'menu_name' => 'Keuring',
        'name_admin_bar' => 'Keuring',
        'add_new' => 'Nieuwe keuring',
        'add_new_item' => 'Nieuwe keuring toevoegen',
        'edit_item' => 'Keuring bewerken',
        'new_item' => 'Nieuwe keuring',
        'view_item' => 'Keuringen bekijken',
        'search_items' => 'Keuring zoeken',
        'not_found' => 'Geen keuringen gevonden',
        'not_found_in_trash' => 'Geen keuringen gevonden in prullenbak',
        'all_items' => 'Alle keuringen',
        'archives' => 'Keuringen archief',
    ];

    $args = [
        'label' => 'Keuring',
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_rest' => true, // Gutenberg + ACF
        'menu_position' => 20,
        'menu_icon' => 'dashicons-welcome-write-blog',
        'supports' => [
            'title',
            'editor',
            'thumbnail',   // BELANGRIJK voor slider
            'excerpt',
        ],
        'has_archive' => false,
        'rewrite' => [
            'slug' => 'diensten',
            'with_front' => false,
        ],
        'hierarchical' => false,
        'exclude_from_search' => false,
        'capability_type' => 'post',
    ];

    register_post_type('keuring', $args);
    
});
