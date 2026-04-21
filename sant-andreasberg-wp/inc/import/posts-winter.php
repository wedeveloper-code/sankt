<?php
defined('ABSPATH') || exit;

function sa_import_posts_winter(): void {
    $cat = get_term_by('slug', 'winter', 'category');
    if (!$cat) return;
    $cat_id = $cat->term_id;

    foreach (sa_get_winter_posts() as $p) {
        sa_insert_post($p, $cat_id);
    }
}

function sa_get_winter_posts(): array {
    return [

        [
            'slug'  => 'ski-slopes',
            'title' => 'Skigebiete in Sankt Andreasberg',
            'meta'  => [
                'h1'          => 'Skigebiete am Matthias-Schmidt-Berg und Sonnenberg',
                'title'       => 'Skifahren in Sankt Andreasberg – Pisten & Lifte im Harz',
                'description' => 'Skifahren und Snowboarden in Sankt Andreasberg: Matthias-Schmidt-Berg und Großer Sonnenberg mit je vier Liften und moderner Beschneiung.',
            ],
            'content' => '<p>Sankt Andreasberg verfügt mit dem Sonnenberg über das schneesicherste Skigebiet im Harz. Hier liegt auch das Landesleistungszentrum Biathlon für nationale und internationale Wettkämpfe.</p>

<h2>Matthias-Schmidt-Berg</h2>
<p>Das Skizentrum Matthias-Schmidt-Berg verfügt über vier Lifte und bietet Pisten für alle Könnerstufen. Dank moderner Beschneiungsanlagen wird der Winter auf dem Berg etwas verlängert, wenn der natürliche Schnee ausbleibt.</p>

<ul>
<li>4 Lifte</li>
<li>Beschneiungsanlage</li>
<li>Snowboard-Kicker</li>
<li>Skischule vor Ort</li>
</ul>

<h2>Großer Sonnenberg</h2>
<p>Das Skizentrum Großer Sonnenberg ist ebenfalls mit vier Liften ausgestattet. Von hier hat man einen herrlichen Blick zum Brocken. Telemarker und Nordic Skifahrer sind hier ebenso willkommen.</p>

<ul>
<li>4 Lifte</li>
<li>Panoramablick zum Brocken</li>
<li>Biathlon-Schießanlage</li>
<li>Gastronomie vor Ort</li>
</ul>

<div class="info-box">
<strong>Tipp:</strong> Sollte der Schnee einmal ausbleiben, stehen diverse Schneekanonen zur Verfügung, um die Pisten in Schuss zu halten.
</div>',
        ],

        [
            'slug'  => 'ski-trails',
            'title' => 'Loipen rund um Sankt Andreasberg',
            'meta'  => [
                'h1'          => 'Langlauf-Loipen in Sankt Andreasberg',
                'title'       => 'Langlauf & Loipen in Sankt Andreasberg – 40 km im Nationalpark Harz',
                'description' => 'Rund 40 km gespurte Langlauf-Loipen rund um Sankt Andreasberg. Schneewittchen-Loipe, Sonnenberg-Loipe, Oderberg-Loipe – mit GPS-Daten zum Download.',
            ],
            'content' => '<p>Ganz in der Nähe der Bergstadt gibt es bestens präparierte Skating-Loipen. Rings um die Bergstadt sind ca. 40 km Loipe gespurt, zum Teil auch mit separater Skatingspur.</p>

<h2>Übersicht der Loipen</h2>

<h3>Beerberg-Loipe</h3>
<p>Loipe rund um den Beerberg. Abwechslungsreiche Strecke durch den Nationalpark.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Jordanshöhe-Loipe</h3>
<p>Loipe oberhalb der Bergstadt mit herrlichem Ausblick.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Oderberg-Loipe</h3>
<p>Loipe rund um den Oderberg. Besonders schöne Winterlandschaft.</p>
<ul><li>GPS-Daten verfügbar</li><li>Separater Skatingbereich</li></ul>

<h3>Schneewittchen-Loipe</h3>
<p>Loipe am Sonnenberg. Benannt nach dem gleichnamigen Harz-Märchen.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Sonnenberg-Loipe</h3>
<p>Loipe am Sonnenberg mit Blick auf den Brocken. Eine der schönsten Loipen im Harz.</p>
<ul><li>GPS-Daten verfügbar</li><li>Skating-Spur</li></ul>

<h3>Achtermann-Loipe</h3>
<p>Anspruchsvolle Loipe rund um den Achtermann (926 m).</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<div class="info-box">
<strong>Hinweis:</strong> Die GPS-Daten (GARMIN-Format) können Sie direkt im Tourismusbüro Sankt Andreasberg erhalten.
</div>',
        ],

        [
            'slug'  => 'sledding',
            'title' => 'Rodeln & Snowtubing in Sankt Andreasberg',
            'meta'  => [
                'h1'          => 'Rodeln und Snowtubing im Teichtal',
                'title'       => 'Rodeln in Sankt Andreasberg – Teichtal & Sonnenberg',
                'description' => 'Rodelspaß für die ganze Familie: Rodelhänge im Teichtal und auf dem Sonnenberg. Snowtubing im Teichtal – ein Erlebnis für Groß und Klein.',
            ],
            'content' => '<p>Rodeln und Snowtubing gehören zu den beliebtesten Winteraktivitäten in Sankt Andreasberg. Hier kommen Groß und Klein auf ihre Kosten.</p>

<h2>Rodelhang Teichtal</h2>
<p>Der Rodelhang im Teichtal ist der klassische Treffpunkt für Rodelfans. Gut präpariert und für alle Altersgruppen geeignet.</p>

<h2>Rodelhang Sonnenberg</h2>
<p>Der Sonnenberg bietet einen weiteren Rodelhang mit herrlichem Panorama. Ideal für etwas anspruchsvollere Rodelabfahrten.</p>

<h2>Snowtubing im Teichtal</h2>
<p>Snowtubing – das Rutschen auf aufblasbaren Reifen – ist besonders bei Kindern und Jugendlichen beliebt. Im Teichtal steht eine eigene Snowtubing-Anlage zur Verfügung.</p>

<div class="info-box">
<strong>Tipp:</strong> Eigene Schlitten können mitgebracht werden. Vor Ort gibt es auch Möglichkeiten zur Ausleihe.
</div>',
        ],

        [
            'slug'  => 'winter-hiking',
            'title' => 'Winterwandern & Schneeschuhtouren',
            'meta'  => [
                'h1'          => 'Winterwandern und Schneeschuhlaufen im Nationalpark Harz',
                'title'       => 'Winterwandern Sankt Andreasberg – Schneeschuhtouren im Harz',
                'description' => 'Winterwandern und Schneeschuhtouren rund um Sankt Andreasberg: Kleiner Oderberg, Andreasheim, John-Kothe-Weg – durch den verschneiten Nationalpark Harz.',
            ],
            'content' => '<p>Wer es lieber ruhiger angehen lässt, kann die Winterwelt auf Schneeschuhen erkunden. Ausgeschilderte Winterwanderwege führen durch den verschneiten Nationalpark Harz.</p>

<h2>Schneeschuhtouren</h2>

<h3>Kleiner Oderberg</h3>
<p>Schneeschuhwanderung oberhalb der Bergstadt. Wunderschöne Aussichten über das verschneite Harzvorland.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: leicht bis mittel</li></ul>

<h3>Andreasheim</h3>
<p>Winterwanderung oberhalb der Bergstadt zum historischen Andreasheim.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: leicht</li></ul>

<h2>Winterwanderwege</h2>

<h3>John-Kothe-Weg</h3>
<p>Winterwanderung um den Glockenberg. Landschaftlich sehr reizvoll, gut ausgeschildert.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Sieberberg-Runde</h3>
<p>Winterwanderung um den Sieberberg. Für geübte Winterwanderer.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: mittel</li></ul>

<div class="info-box">
<strong>Ausrüstung:</strong> Für Schneeschuhtouren im Nationalpark empfehlen wir feste Wanderstiefel und wetterfeste Kleidung. Schneeschuhe können in Sankt Andreasberg ausgeliehen werden.
</div>',
        ],
    ];
}

function sa_insert_post(array $p, int $cat_id): void {
    $existing = get_page_by_path($p['slug'], OBJECT, 'post');
    if ($existing) {
        $post_id = $existing->ID;
    } else {
        $post_id = wp_insert_post([
            'post_title'    => $p['title'],
            'post_name'     => $p['slug'],
            'post_content'  => $p['content'],
            'post_status'   => 'publish',
            'post_type'     => 'post',
            'post_category' => [$cat_id],
            'post_date'     => $p['date'] ?? '2011-01-01 10:00:00',
        ]);
    }
    if (is_wp_error($post_id) || !$post_id) return;
    wp_set_post_categories($post_id, [$cat_id]);
    foreach (['title', 'description', 'h1'] as $key) {
        if (!empty($p['meta'][$key])) {
            update_post_meta($post_id, 'sa_meta_' . $key, $p['meta'][$key]);
        }
    }
}
