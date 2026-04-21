<?php
defined('ABSPATH') || exit;

function sa_import_categories(): void {
    $cats = [
        [
            'name'        => 'Winter',
            'slug'        => 'winter',
            'description' => 'Wintersport in Sankt Andreasberg: Ski, Langlauf, Rodeln und Winterwandern im Nationalpark Harz.',
            'meta'        => [
                'h1'          => 'Wintersport in Sankt Andreasberg',
                'title'       => 'Wintersport in Sankt Andreasberg – Ski, Loipen & mehr',
                'description' => 'Skifahren, Langlauf, Rodeln und Winterwandern in Sankt Andreasberg. Snowsicher dank moderner Beschneiung am Matthias-Schmidt-Berg.',
            ],
        ],
        [
            'name'        => 'Sommer',
            'slug'        => 'sommer',
            'description' => 'Sommeraktivitäten in Sankt Andreasberg: Wandern, Mountainbiking, Nordic Walking und Abenteuer im Harz.',
            'meta'        => [
                'h1'          => 'Sommerurlaub in Sankt Andreasberg',
                'title'       => 'Sommer in Sankt Andreasberg – Wandern, MTB & Abenteuer',
                'description' => 'Wandern, Mountainbiken, Nordic Walking und Abenteueraktivitäten in Sankt Andreasberg im Nationalpark Harz.',
            ],
        ],
        [
            'name'        => 'News',
            'slug'        => 'news',
            'description' => 'Aktuelle Neuigkeiten aus Sankt Andreasberg und dem Nationalpark Harz.',
            'meta'        => [
                'h1'          => 'Neuigkeiten aus Sankt Andreasberg',
                'title'       => 'News aus Sankt Andreasberg im Harz',
                'description' => 'Aktuelle Veranstaltungen, Neuigkeiten und Infos aus der Bergstadt Sankt Andreasberg.',
            ],
        ],
    ];

    foreach ($cats as $cat) {
        $existing = get_term_by('slug', $cat['slug'], 'category');
        if ($existing) {
            $term_id = $existing->term_id;
        } else {
            $result  = wp_insert_term($cat['name'], 'category', [
                'slug'        => $cat['slug'],
                'description' => $cat['description'],
            ]);
            if (is_wp_error($result)) continue;
            $term_id = $result['term_id'];
        }
        foreach ($cat['meta'] as $key => $value) {
            update_term_meta($term_id, 'sa_meta_' . $key, $value);
        }
    }
}
