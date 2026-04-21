<?php
defined('ABSPATH') || exit;

function sa_import_posts_summer(): void {
    $cat = get_term_by('slug', 'sommer', 'category');
    if (!$cat) return;
    $cat_id = $cat->term_id;

    foreach (sa_get_summer_posts() as $p) {
        sa_insert_post($p, $cat_id);
    }
}

function sa_get_summer_posts(): array {
    return [

        [
            'slug'  => 'hiking',
            'title' => 'Wandern rund um Sankt Andreasberg',
            'meta'  => [
                'h1'          => 'Wandertouren rund um Sankt Andreasberg',
                'title'       => 'Wandern in Sankt Andreasberg – Touren im Nationalpark Harz',
                'description' => 'Wandertouren rund um Sankt Andreasberg: von leichten Rundwegen bis zur Tagestour. 200 km Wanderwege, GPS-Daten, Harzer Hexenstieg.',
            ],
            'content' => '<p>Rings um die Stadt können Sie auf vielen Kilometern Wanderweg die Umgebung erkunden. Auch der Harzer Hexenstieg führt mit der Brockenumgehung direkt an Sankt Andreasberg vorbei.</p>

<p>Rund 200 km Wanderwege rings um Sankt Andreasberg sorgen für viel Abwechselung. Kultur, Geschichte, Sport und Erholung – alles finden Sie bei uns im Harz!</p>

<h2>Kurze Rundwanderungen</h2>

<h3>Freibiersquelle</h3>
<p>Kleine Wanderung rund um die Bergstadt. Ideal für Familien und Einsteiger.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: leicht</li></ul>

<h3>Galgenberg</h3>
<p>Kleine Wanderung um die Bergstadt mit historisch interessanten Stationen.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: leicht</li></ul>

<h3>Oderberg-Runde</h3>
<p>Kleine Wanderung um die Bergstadt mit Blick auf den Oderberg.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: leicht bis mittel</li></ul>

<h2>Halbtagstouren</h2>

<h3>Höhenwanderweg</h3>
<p>Halbtagestour rund um die Bergstadt. Herrlicher Ausblick über den Südharz vom Höhenwanderweg oberhalb der Stadt.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: mittel</li></ul>

<h3>Rinderstall-Runde</h3>
<p>Abwechslungsreiche Halbtagestour durch Wald und Wiesen.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Rehberg-Runde</h3>
<p>Halbtagestour mit Blick auf das Rehberger Grabensystem.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Sieberberg</h3>
<p>Halbtagestour zum Sieberberg mit weitem Panorama.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Skikreuz</h3>
<p>Halbtagestour zum historischen Skikreuz.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Wolfswarte</h3>
<p>Halbtagestour zur Wolfswarte, einem der markantesten Aussichtspunkte im Harz.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h2>Tagestouren</h2>

<h3>Silberteich</h3>
<p>Tagestour zum malerischen Silberteich.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: mittel bis anspruchsvoll</li></ul>

<h3>Skikreuz-Runde</h3>
<p>Anspruchsvolle Tagestour – die große Variante der Skikreuz-Wanderung.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<div class="info-box">
<strong>GPS-Daten:</strong> Alle Tourenvorschläge sind auch mit GPS-Daten im GARMIN-Format erhältlich. Informationen erhalten Sie im Tourismusbüro Sankt Andreasberg.
</div>',
        ],

        [
            'slug'  => 'mountain-biking',
            'title' => 'Mountainbike-Touren im Harz',
            'meta'  => [
                'h1'          => 'MTB-Touren rund um Sankt Andreasberg',
                'title'       => 'Mountainbiking Sankt Andreasberg – MTB-Touren mit GPS im Harz',
                'description' => 'Mountainbike-Touren rund um Sankt Andreasberg: Drei-Türme-Tour, Brockenritt, Odertal-Runde – für alle Schwierigkeitsstufen mit GPS-Daten.',
            ],
            'content' => '<p>Viel schneller lässt sich der Harz auf dem Mountainbike entdecken. Sehr viele MTB-Touren sind ausgeschildert, und Sie können sich mit Hilfe eines GPS-Gerätes durch den Nationalpark Harz führen lassen.</p>

<h2>Anspruchsvolle Halbtagstouren</h2>

<h3>Sonnenberg-Runde</h3>
<p>Anspruchsvolle Halbtagestour rund um den Sonnenberg – technisch und konditionell fordernd.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: anspruchsvoll</li></ul>

<h3>Sperrlutter-Runde</h3>
<p>Anspruchsvolle Halbtagestour durch das Sperrlutter-Tal.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Odertalsperren-Runde</h3>
<p>Anspruchsvolle Halbtagestour entlang der Odertalsperre.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Odertal-Runde</h3>
<p>Anspruchsvolle Halbtagestour durch das malerische Odertal.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Hans-Kühnen-Burg-Runde</h3>
<p>Anspruchsvolle Halbtagestour zu den Resten der historischen Burg.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h2>Tagestouren (sehr anspruchsvoll)</h2>

<h3>Drei-Türme-Tour</h3>
<p>Sehr anspruchsvolle Tagestour mit vielen Höhenmetern – zu den drei markanten Aussichtstürmen im Harz.</p>
<ul><li>GPS-Daten verfügbar</li><li>Höhenmeter: hoch</li><li>Schwierigkeit: sehr anspruchsvoll</li></ul>

<h3>Einhornhöhle-Tour</h3>
<p>Sehr anspruchsvolle Tagestour zur berühmten Einhornhöhle bei Scharzfeld.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Brockenritt</h3>
<p>Das Highlight für ambitionierte MTB-Fahrer: Auffahrt zum Brocken (1141 m). Sehr anspruchsvoll, aber unvergesslich.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: sehr anspruchsvoll</li></ul>

<div class="info-box">
<strong>GPS-Daten im GARMIN-Format</strong> können direkt im Tourismusbüro oder bei der Bergsport Arena GmbH abgeholt werden.
</div>',
        ],

        [
            'slug'  => 'nordic-walking',
            'title' => 'Nordic Walking Routen',
            'meta'  => [
                'h1'          => 'Nordic Walking rund um Sankt Andreasberg',
                'title'       => 'Nordic Walking Sankt Andreasberg – Routen & GPS-Daten',
                'description' => 'Nordic Walking in Sankt Andreasberg: Blaue Route (Drei-Jungfern), Rote Route (Matthias-Schmidt-Berg), Schwarze Route (Höhenwanderweg) – alle mit GPS.',
            ],
            'content' => '<p>Sankt Andreasberg bietet ausgeschilderte Nordic Walking Routen für alle Fitnessniveaus. Die Routen sind farblich markiert und mit GPS-Daten hinterlegt.</p>

<h2>Ausgeschilderte Walking-Routen</h2>

<h3>Blaue Route – Drei-Jungfern</h3>
<p>Kleine Tour oberhalb der Bergstadt. Als "Blaue Route" ausgeschildert. Ideal für Einsteiger und als tägliches Training.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: leicht</li><li>Kennzeichnung: blaue Markierung</li></ul>

<h3>Rote Route – Matthias-Schmidt-Berg</h3>
<p>Kleine Tour oberhalb der Bergstadt zum Matthias-Schmidt-Berg. Als "Rote Route" ausgeschildert.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: leicht bis mittel</li><li>Kennzeichnung: rote Markierung</li></ul>

<h3>Schwarze Route – Höhenwanderweg</h3>
<p>Halbtagestour rund um die Bergstadt. Als "Schwarze Route" ausgeschildert. Die anspruchsvollste der drei Standardrouten.</p>
<ul><li>GPS-Daten verfügbar</li><li>Schwierigkeit: mittel</li><li>Kennzeichnung: schwarze Markierung</li></ul>

<h2>Inline-Touren im Südharz</h2>

<h3>Kulmketal-Tour</h3>
<p>Inlinertour im Südharz durch das schöne Kulmketal. Gut ausgebaute Wege.</p>
<ul><li>GPS-Daten verfügbar</li></ul>

<h3>Siebertal-Tour</h3>
<p>Inlinertour durch das Siebertal – flach und familienfreundlich.</p>
<ul><li>GPS-Daten verfügbar</li></ul>',
        ],

        [
            'slug'  => 'adventure',
            'title' => 'Abenteuer & Action im Harz',
            'meta'  => [
                'h1'          => 'Action und Abenteuer in Sankt Andreasberg',
                'title'       => 'Abenteuer im Harz – Hochseilgarten, Klettern, Kanu in Sankt Andreasberg',
                'description' => 'Action und Abenteuer in Sankt Andreasberg: Hochseilgarten, Felsklettern, Kanutour auf der Rhume und Floßfahrt an der Odertalsperre.',
            ],
            'content' => '<p>Sankt Andreasberg ist ein idealer Ausgangspunkt für Abenteuerurlaub. Wer wollte das nicht auch schon einmal ausprobieren? Bei uns ist es möglich, jeden Tag vor eine neue Herausforderung gestellt zu werden.</p>

<h2>Hochseilgarten</h2>
<p>Unser Hochseilgarten ist ein Hindernisparcours an naturbelassenen Bäumen, der eine besondere Herausforderung darstellt. Diverse Seil- und Hängebrücken, Netze, Balken- und Kletterwände bieten den Teilnehmern spannende Aufgaben. Schon nach kurzer Zeit stellt sich eine spürbare Trittsicherheit ein und der Spaß am Klettern beginnt.</p>

<p>Die Benutzung des Hochseilgartens stellt keine besonderen Anforderungen an die körperliche Fitness. Es sollten jedoch bequeme Freizeitkleidung und festes Schuhwerk getragen werden. Die Teilnehmer erhalten von einem ausgebildeten Kletterlehrer eine ausführliche Sicherheitseinweisung.</p>

<p>Der Hochseilgarten ist jeden Samstag und Sonntag von 10:00 bis 14:00 Uhr geöffnet. <strong>Preis: 16 € pro Person.</strong></p>

<h2>Felsklettern</h2>
<p>Bei unserem Kletterschnupper-Kurs legen wir großen Wert darauf, dass Sie Ihre Bewegungserfahrung in der Vertikalen erweitern können. Immer nach der Devise „Der Weg ist das Ziel" werden erfahrene Kletterlehrer Ihnen zeigen, wie man die Schwerkraft überlistet.</p>

<p>Die Tour findet jeweils am Dienstag ab 10 Uhr statt. Treffpunkt ist an der Bergsport Arena, wo Sie auch die nötige Ausrüstung erhalten. Es sollten Turnschuhe und bequeme Freizeitbekleidung sowie Proviant mitgebracht werden. <strong>Preis: 29 € pro Person.</strong></p>

<h2>Kanutour auf der Rhume</h2>
<p>Wir bieten eine Kanu-Erlebnistour auf der Rhume, einem Harzer Fluss, an. Nach einer kurzen Einweisungsphase beherrschen Sie das Manövrieren und es kann auf Entdeckungsfahrt gehen.</p>

<p>Alle Teilnehmer sollten über ausreichende Schwimmkenntnisse verfügen. Start ist um 10 Uhr an der Bergsport Arena. Sie sollten sich genügend Proviant mitnehmen. Rückfahrt ist gegen 15:00 Uhr. <strong>Preis: 39 € pro Person (Tagesausflug).</strong></p>

<h2>Floßfahrt an der Odertalsperre</h2>
<p>Mit Mountainbikes fahren wir morgens zur Odertalsperre. Am Ufer liegt bereits ein Floßbausatz bereit, der nur noch zusammen gebaut werden muss. Auf der großen Überfahrt darf auch "gebadet" werden. Ein absoluter Spaß für die ganze Familie. Schwimmkenntnisse sind hier vorausgesetzt.</p>

<p><strong>Preis: 39 € pro Person (Tagesausflug).</strong></p>

<div class="info-box">
<strong>Action-Wochenprogramm:</strong> Montags bis sonntags sind verschiedene Aktivitäten buchbar. Buchen Sie direkt bei der Bergsport Arena GmbH, Hinterstraße 3, Sankt Andreasberg. Tel: +49 5582 8154.
</div>',
        ],
    ];
}
