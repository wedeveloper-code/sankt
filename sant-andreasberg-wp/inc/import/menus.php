<?php
defined('ABSPATH') || exit;

function sa_import_menus(): void {
    sa_build_primary_menu();
    sa_build_footer_menu();
}

function sa_build_primary_menu(): void {
    $menu_name = 'Hauptmenü';
    $menu = wp_get_nav_menu_object($menu_name);
    if ($menu) return;

    $menu_id = wp_create_nav_menu($menu_name);
    if (is_wp_error($menu_id)) return;

    /* Top-level items */
    $items = [
        [
            'title' => 'Startseite',
            'url'   => home_url('/'),
            'type'  => 'custom',
            'children' => [],
        ],
        [
            'title' => 'Über Sankt Andreasberg',
            'slug'  => 'about-sankt-andreasberg',
            'type'  => 'page',
            'children' => [
                ['title' => 'Geschichte', 'slug' => 'history', 'type' => 'page'],
            ],
        ],
        [
            'title'    => 'Winter',
            'slug'     => 'winter',
            'type'     => 'category',
            'children' => [
                ['title' => 'Skigebiete',           'slug' => 'ski-slopes',     'type' => 'post'],
                ['title' => 'Langlauf & Loipen',    'slug' => 'ski-trails',     'type' => 'post'],
                ['title' => 'Rodeln & Snowtubing',  'slug' => 'sledding',       'type' => 'post'],
                ['title' => 'Winterwandern',        'slug' => 'winter-hiking',  'type' => 'post'],
            ],
        ],
        [
            'title'    => 'Sommer',
            'slug'     => 'sommer',
            'type'     => 'category',
            'children' => [
                ['title' => 'Wandern',          'slug' => 'hiking',          'type' => 'post'],
                ['title' => 'Mountainbiking',   'slug' => 'mountain-biking', 'type' => 'post'],
                ['title' => 'Nordic Walking',   'slug' => 'nordic-walking',  'type' => 'post'],
                ['title' => 'Action & Abenteuer','slug' => 'adventure',      'type' => 'post'],
            ],
        ],
        [
            'title' => 'Sehenswürdigkeiten',
            'slug'  => 'sights',
            'type'  => 'page',
            'children' => [],
        ],
        [
            'title' => 'Neuigkeiten',
            'slug'  => 'news',
            'type'  => 'category',
            'children' => [],
        ],
        [
            'title' => 'Kontakt',
            'slug'  => 'contact',
            'type'  => 'page',
            'children' => [],
        ],
    ];

    foreach ($items as $item) {
        $parent_id = sa_add_menu_item($menu_id, $item, 0);
        foreach ($item['children'] ?? [] as $child) {
            sa_add_menu_item($menu_id, $child, $parent_id);
        }
    }

    $locations = get_theme_mod('nav_menu_locations', []);
    $locations['primary'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

function sa_add_menu_item(int $menu_id, array $item, int $parent_id): int {
    if ($item['type'] === 'custom') {
        return wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-title'  => $item['title'],
            'menu-item-url'    => $item['url'],
            'menu-item-status' => 'publish',
            'menu-item-parent-id' => $parent_id,
        ]);
    }

    if ($item['type'] === 'page') {
        $page = get_page_by_path($item['slug'] ?? '');
        if (!$page) return 0;
        return wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-type'      => 'post_type',
            'menu-item-object'    => 'page',
            'menu-item-object-id' => $page->ID,
            'menu-item-title'     => $item['title'],
            'menu-item-status'    => 'publish',
            'menu-item-parent-id' => $parent_id,
        ]);
    }

    if ($item['type'] === 'category') {
        $term = get_term_by('slug', $item['slug'] ?? '', 'category');
        if (!$term) return 0;
        return wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-type'      => 'taxonomy',
            'menu-item-object'    => 'category',
            'menu-item-object-id' => $term->term_id,
            'menu-item-title'     => $item['title'],
            'menu-item-status'    => 'publish',
            'menu-item-parent-id' => $parent_id,
        ]);
    }

    if ($item['type'] === 'post') {
        $post = get_page_by_path($item['slug'] ?? '', OBJECT, 'post');
        if (!$post) return 0;
        return wp_update_nav_menu_item($menu_id, 0, [
            'menu-item-type'      => 'post_type',
            'menu-item-object'    => 'post',
            'menu-item-object-id' => $post->ID,
            'menu-item-title'     => $item['title'],
            'menu-item-status'    => 'publish',
            'menu-item-parent-id' => $parent_id,
        ]);
    }

    return 0;
}

function sa_build_footer_menu(): void {
    $menu_name = 'Fußzeilen-Menü';
    if (wp_get_nav_menu_object($menu_name)) return;

    $menu_id = wp_create_nav_menu($menu_name);
    if (is_wp_error($menu_id)) return;

    $footer_items = [
        ['title' => 'Impressum',   'slug' => 'impressum',      'type' => 'page'],
        ['title' => 'Datenschutz', 'slug' => 'privacy-policy', 'type' => 'page'],
        ['title' => 'Kontakt',     'slug' => 'contact',        'type' => 'page'],
    ];
    foreach ($footer_items as $item) {
        sa_add_menu_item($menu_id, $item, 0);
    }

    $locations = get_theme_mod('nav_menu_locations', []);
    $locations['footer'] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}
