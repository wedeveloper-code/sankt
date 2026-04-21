<?php
defined('ABSPATH') || exit;

function sa_import_pages(): void {
    $pages = sa_get_pages_data();
    foreach ($pages as $p) {
        $existing = get_page_by_path($p['slug']);
        if ($existing) {
            $post_id = $existing->ID;
        } else {
            $post_id = wp_insert_post([
                'post_title'   => $p['title'],
                'post_name'    => $p['slug'],
                'post_content' => $p['content'],
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_date'    => $p['date'] ?? current_time('mysql'),
            ]);
        }
        if (is_wp_error($post_id) || !$post_id) continue;
        foreach (['title', 'description', 'h1'] as $key) {
            if (!empty($p['meta'][$key])) {
                update_post_meta($post_id, 'sa_meta_' . $key, $p['meta'][$key]);
            }
        }
        /* Set as front page if needed */
        if (!empty($p['front_page'])) {
            update_option('show_on_front', 'page');
            update_option('page_on_front', $post_id);
        }
    }
}

function sa_get_pages_data(): array {
    return [

        /* ---- ABOUT ---- */
        [
            'slug'    => 'about-sankt-andreasberg',
            'title'   => 'Über Sankt Andreasberg',
            'meta'    => [
                'h1'          => 'Über Sankt Andreasberg',
                'title'       => 'Über Sankt Andreasberg – Nationalpark-Gemeinde im Oberharz',
                'description' => 'Sankt Andreasberg ist eine alte Bergstadt im Oberharz, seit 2011 Teil von Braunlage. Nationalpark Harz, Luftkurort und UNESCO-Welterbe.',
            ],
            'content' => '<p>Sankt Andreasberg ist eine alte Bergstadt im Oberharz, seit November 2011 gehört sie zur Stadt Braunlage (Landkreis Goslar). Sie liegt zwischen 400 und 870 m über dem Meeresspiegel, mitten im Nationalpark Harz.</p>

<p>Das Stadtzentrum befindet sich auf einem sonnigen Hochplateau, eine weite Sicht über den Südharz ist garantiert. Aufgrund der Luftqualität und der therapeutischen Wirkung des Klimas ist Sankt Andreasberg ein Luftkurort. Die steilen verwinkelten Straßen der Bergstadt üben einen besonderen Reiz aus.</p>

<h2>Geschichte</h2>
<p>Sankt Andreasberg (damals »sanct andrews berges«) wurde 1487 erstmals urkundlich erwähnt. Über vier Jahrhunderte lang war der Bergbau die wichtigste Lebensgrundlage der Bevölkerung. Überall in der Stadt stößt man auf die Zeugnisse der Bergbauvergangenheit: die kleinen bunten Bergmannshäuser, die große Martini-Kirche, die Halden und natürlich die Bergwerke selbst.</p>

<p>Die <strong>Grube Samson</strong> ist seit 2010 UNESCO-Welterbestätte. Weil der Rehberger Graben seit mehr als 300 Jahren das Oder-Wasser in die Bergstadt führt, kann die Stadt heute zu ca. 90 % mit Strom aus Wasserkraft versorgt werden.</p>

<h2>Lage & Anreise</h2>
<p>Sankt Andreasberg liegt im Südostharz, ca. 20 km von Goslar und 30 km von Braunschweig entfernt. Die nächste Bahnstation ist in Herzberg am Harz. Mit dem PKW ist die Bergstadt über die B4 und B27 gut erreichbar.</p>',
        ],

        /* ---- HISTORY ---- */
        [
            'slug'    => 'history',
            'title'   => 'Geschichte von Sankt Andreasberg',
            'meta'    => [
                'h1'          => 'Die Geschichte der Bergstadt Sankt Andreasberg',
                'title'       => 'Geschichte Sankt Andreasberg – 500 Jahre Bergbau im Harz',
                'description' => 'Die Geschichte der Bergstadt Sankt Andreasberg ist eng mit dem Bergbau verknüpft. Von der ersten urkundlichen Erwähnung 1487 bis zur UNESCO-Anerkennung 2010.',
            ],
            'content' => '<p>Die Geschichte der Bergstadt Sankt Andreasberg ist natürlich eng mit der Bergbaugeschichte des Ortes verknüpft. Über vier Jahrhunderte lebte die Bevölkerung fast ausschließlich vom Bergbau. Weil der Rehberger Graben seit mehr als 300 Jahren das Oder-Wasser in die Bergstadt führt, kann die Stadt heute zu ca. 90 % mit Strom aus Wasserkraft versorgt werden.</p>

<h2>Chronik</h2>

<h3>1487</h3>
<p>Erste urkundliche Erwähnung von "sanct andrews berges". Zwei Gewerke (Bergbaubetriebe) streiten über Grubenfelder. Eine feste Ansiedlung von Bergleuten ist eher unwahrscheinlich.</p>

<h3>1521</h3>
<p>Die Hohnsteiner Grafen rufen die erste Bergfreiheit aus. Die Grube Samson wird in Betrieb genommen.</p>

<h3>1527</h3>
<p>Zweite erweiterte Bergfreiheit, diese zeigt schnell Wirkung, Bergleute aus dem Erzgebirge siedeln sich in Sankt Andreasberg an.</p>

<h3>1528</h3>
<p>Aufbau der Bergstadt beginnt. 116 Gruben sind in Betrieb.</p>

<h3>1537</h3>
<p>In Sankt Andreasberg stehen 300 Wohnhäuser, ca. 2000 Einwohner leben hier. Richter und Rat nehmen ihre Arbeit auf. Sehr gute Ausbeute.</p>

<h3>1577</h3>
<p>Die Pest wütet in der Bergstadt.</p>

<h3>Um 1590</h3>
<p>Bau des Sonnenberger Grabens.</p>

<h3>1593</h3>
<p>Andreasberg erhält eine Hammermünze, sie ist bis 1629 in Betrieb.</p>

<h3>1648</h3>
<p>Ende des Dreißigjährigen Krieges. Im gesamten Oberharz kein planmäßiger Bergbau (Ausnahme: einige Gruben in Clausthal).</p>

<h3>1663</h3>
<p>In Sankt Andreasberg entsteht ein Unterbergamt, die Silberhütte wird wieder aufgebaut.</p>

<h3>1674</h3>
<p>Erste Ausbeute seit 60 Jahren. Ausbeutetaler „Andreae montani Ludovici haec munera venae" wird geprägt.</p>

<h3>2010</h3>
<p>Die Grube Samson wird als Teil des Oberharzer Wasserregals in die UNESCO-Welterbeliste aufgenommen.</p>

<h3>2011</h3>
<p>Sankt Andreasberg wird Teil der Stadt Braunlage (Landkreis Goslar).</p>',
        ],

        /* ---- WINTER PAGE ---- */
        [
            'slug'    => 'winter',
            'title'   => 'Winter in Sankt Andreasberg',
            'meta'    => [
                'h1'          => 'Wintersport in Sankt Andreasberg',
                'title'       => 'Winter in Sankt Andreasberg – Ski, Langlauf & Rodeln im Harz',
                'description' => 'Wintersport pur in Sankt Andreasberg: Skifahren am Matthias-Schmidt-Berg, Langlauf auf 40 km Loipen, Rodeln und Winterwandern im Nationalpark Harz.',
            ],
            'content' => '<p>Wenn die weiße Winterpracht in Sankt Andreasberg Einzug hält, schlägt das Herz des Wintersportlers höher. Sei es in der Loipe oder auf den Hängen, beim Rodeln oder auf der Sonnenterasse, Erholung und Spaß sind vorprogrammiert.</p>

<h2>Skigebiete</h2>
<p>Der <strong>Matthias-Schmidt-Berg</strong> und der <strong>Große Sonnenberg</strong> bieten zusammen acht Lifte und moderne Pisten für Anfänger und Fortgeschrittene. Dank leistungsstarker Schneekanonen ist der Winter verlängerbar.</p>

<h2>Langlauf & Loipen</h2>
<p>Rund 40 km gespurte Loipen rund um die Bergstadt – zum Teil auch mit separater Skatingspur. Die bekanntesten Loipen führen um den Oderberg, Sonnenberg und Achtermann.</p>

<h2>Rodeln & Snowtubing</h2>
<p>Rodelhänge im Teichtal und auf dem Sonnenberg bieten Spaß für die ganze Familie. Snowtubing im Teichtal ist besonders bei Kindern beliebt.</p>

<h2>Winterwandern & Schneeschuhtouren</h2>
<p>Wer es ruhiger angehen lässt, kann die Winterwelt auf Schneeschuhen erkunden oder auf ausgeschilderten Winterwanderwegen durch den verschneiten Nationalpark spazieren.</p>',
        ],

        /* ---- SUMMER PAGE ---- */
        [
            'slug'    => 'summer',
            'title'   => 'Sommer in Sankt Andreasberg',
            'meta'    => [
                'h1'          => 'Sommerurlaub in Sankt Andreasberg',
                'title'       => 'Sommer in Sankt Andreasberg – Wandern, MTB & Abenteuer',
                'description' => 'Sommerurlaub in Sankt Andreasberg: 200 km Wanderwege, MTB-Touren, Nordic Walking und Abenteueraktivitäten im Nationalpark Harz.',
            ],
            'content' => '<p>Sankt Andreasberg ist ein idealer Ausgangspunkt für einen Aktivurlaub. Zu jeder Jahreszeit gibt es hier unzählige Möglichkeiten, etwas Aufregendes im Harz zu erleben.</p>

<h2>Wandern</h2>
<p>Rund 200 km Wanderwege rings um Sankt Andreasberg sorgen für viel Abwechselung. Auch der <strong>Harzer Hexenstieg</strong> führt mit der Brockenumgehung direkt an Sankt Andreasberg vorbei.</p>

<h2>Mountainbiking</h2>
<p>Sehr viele MTB-Touren sind ausgeschildert. GPS-Daten können Sie hier herunterladen – ideal für die Planung am heimischen PC (GARMIN-GPS erforderlich).</p>

<h2>Nordic Walking</h2>
<p>Ausgeschilderte Walking-Routen: Blaue Route (Drei-Jungfern), Rote Route (Matthias-Schmidt-Berg) und Schwarze Route (Höhenwanderweg) rund um die Bergstadt.</p>

<h2>Action & Abenteuer</h2>
<p>Der <strong>Hochseilgarten</strong> – der größte im Harz – bietet spannende Kletterabenteuer. Ergänzt durch Felsklettern, Kanutour auf der Rhume und Floßfahrt an der Odertalsperre.</p>',
        ],

        /* ---- SIGHTS ---- */
        [
            'slug'    => 'sights',
            'title'   => 'Sehenswürdigkeiten in der Umgebung',
            'meta'    => [
                'h1'          => 'Sehenswürdigkeiten rund um Sankt Andreasberg',
                'title'       => 'Sehenswürdigkeiten Harz – Ausflugsziele rund um Sankt Andreasberg',
                'description' => 'Ausflugsziele in der Umgebung von Sankt Andreasberg: von Goslar bis Wernigerode, Einhorn-Höhle, Harzquerbahn und mehr.',
            ],
            'content' => '<p>In der Umgebung von Sankt Andreasberg gibt es viel zu entdecken. Hier eine Auswahl der schönsten Ausflugsziele in der Region:</p>

<h2>Bad Lauterberg</h2>
<ul>
<li>Vitamar Erlebnisbad</li>
<li>Kirchberg-Therme</li>
<li>Scholmzeche</li>
<li>Königshütte</li>
<li>Odertalsperre</li>
</ul>

<h2>Clausthal-Zellerfeld</h2>
<ul>
<li>Oberharzer Wasserregal (UNESCO-Welterbe)</li>
<li>Oberharzer Bergwerksmuseum</li>
<li>GeoMuseum</li>
</ul>

<h2>Altenau</h2>
<ul>
<li>Kräuterpark Altenau</li>
<li>Heißer Brocken (Kristalltherme)</li>
<li>Okertalsperre</li>
</ul>

<h2>Hahnenklee</h2>
<ul>
<li>Stabkirche Hahnenklee</li>
</ul>

<h2>Scharzfeld</h2>
<ul>
<li>Einhornhöhle</li>
<li>Steinkirche</li>
<li>Karstwanderweg</li>
</ul>

<h2>Bad Sachsa</h2>
<ul>
<li>Falkenhof</li>
<li>Salztal Paradies</li>
<li>Kloster Walkenried</li>
</ul>

<h2>Goslar</h2>
<ul>
<li>UNESCO-Welterbe Goslar (Altstadt & Rammelsberg)</li>
<li>Kaiserpfalz</li>
<li>Zwinger</li>
</ul>

<h2>Wernigerode</h2>
<ul>
<li>Schloss Wernigerode</li>
<li>Harzquerbahn</li>
</ul>

<h2>Quedlinburg</h2>
<ul>
<li>UNESCO-Welterbe Quedlinburg</li>
</ul>',
        ],

        /* ---- IMPRESSUM ---- */
        [
            'slug'    => 'impressum',
            'title'   => 'Impressum',
            'meta'    => [
                'h1'          => 'Impressum',
                'title'       => 'Impressum – Sankt Andreasberg',
                'description' => 'Impressum der Website sankt-andreasberg.com. Angaben gemäß § 5 TMG.',
            ],
            'content' => '<h2>Angaben gemäß § 5 TMG</h2>

<p><strong>Herausgeber:</strong><br>
Bergsport Arena GmbH<br>
Hinterstraße 3<br>
37444 Sankt Andreasberg</p>

<p>Tel: +49 5582 8154<br>
Fax: +49 5582 999983<br>
E-Mail: info@bergsport-arena.de</p>

<p>USt-IdNr.: DE233056554<br>
Rechtsform: Gesellschaft mit beschränkter Haftung<br>
Handelsregister: Amtsgericht Braunschweig HRB 111377<br>
Sitz der Gesellschaft: Sankt Andreasberg<br>
Geschäftsführer: Rolf Krüger</p>

<h2>Verantwortlich für die Inhalte dieser Website</h2>
<p>Rolf Krüger</p>

<h2>Haftungsausschluss</h2>
<p>Auf unserer Website verweisen wir an verschiedenen Stellen auf die Internet-Seiten Dritter. Wir haben die Inhalte externer Links sorgfältig geprüft. Dennoch übernehmen wir keine Haftung für die Inhalte externer Links. Für den Inhalt der verlinkten Seiten sind ausschließlich deren Betreiber verantwortlich.</p>

<h2>Rechtlicher Hinweis</h2>
<p>Der Inhalt dieser Website ist urheberrechtlich geschützt. Texte, Bilder, Grafiken sowie Animationen und Videomaterial auf dieser Website unterliegen dem Urheberrecht und dürfen nicht ohne ausdrückliche, schriftliche Genehmigung der Bergsport Arena GmbH kopiert oder verändert werden.</p>

<p>© 2008–' . date('Y') . ' Bergsport Arena GmbH</p>',
        ],

        /* ---- PRIVACY POLICY ---- */
        [
            'slug'    => 'privacy-policy',
            'title'   => 'Datenschutz',
            'meta'    => [
                'h1'          => 'Datenschutzerklärung',
                'title'       => 'Datenschutz – Sankt Andreasberg',
                'description' => 'Datenschutzerklärung der Website sankt-andreasberg.com gemäß DSGVO.',
            ],
            'content' => '<h2>Datenschutzerklärung</h2>

<p>Der Schutz Ihrer persönlichen Daten ist uns ein besonderes Anliegen. Wir verarbeiten Ihre Daten daher ausschließlich auf Grundlage der gesetzlichen Bestimmungen (DSGVO, TMG).</p>

<h2>Erhebung und Verarbeitung personenbezogener Daten</h2>
<p>Beim Besuch unserer Website werden automatisch Informationen allgemeiner Natur erfasst. Diese Informationen (Server-Logfiles) beinhalten etwa die Art des Webbrowsers, das verwendete Betriebssystem, den Domainnamen Ihres Internet-Service-Providers und ähnliches. Hierbei handelt es sich ausschließlich um Informationen, welche keine Rückschlüsse auf Ihre Person zulassen.</p>

<h2>Ihre Rechte</h2>
<p>Ihnen stehen grundsätzlich die Rechte auf Auskunft, Berichtigung, Löschung, Einschränkung, Datenübertragbarkeit, Widerruf und Widerspruch zu. Wenn Sie glauben, dass die Verarbeitung Ihrer Daten gegen das Datenschutzrecht verstößt oder Ihre datenschutzrechtlichen Ansprüche sonst in einer Weise verletzt worden sind, können Sie sich bei der zuständigen Datenschutzbehörde beschweren.</p>

<h2>Kontakt</h2>
<p>Bei Fragen zum Datenschutz wenden Sie sich bitte an: info@bergsport-arena.de</p>',
        ],

        /* ---- CONTACT ---- */
        [
            'slug'    => 'contact',
            'title'   => 'Kontakt',
            'meta'    => [
                'h1'          => 'Kontakt & Anreise',
                'title'       => 'Kontakt – Sankt Andreasberg im Harz',
                'description' => 'Kontaktinformationen und Anreise nach Sankt Andreasberg im Nationalpark Harz.',
            ],
            'content' => '<h2>Bergsport Arena GmbH</h2>

<p>Hinterstraße 3<br>
37444 Sankt Andreasberg</p>

<p><strong>Telefon:</strong> +49 5582 8154<br>
<strong>Fax:</strong> +49 5582 999983<br>
<strong>E-Mail:</strong> info@bergsport-arena.de</p>

<h2>Anreise</h2>

<h3>Mit dem Auto</h3>
<p>Über die Bundesstraße B4 (Goslar–Braunlage) oder B27 (Herzberg–Clausthal-Zellerfeld). Sankt Andreasberg ist von Goslar ca. 25 km, von Hannover ca. 85 km entfernt.</p>

<h3>Mit der Bahn</h3>
<p>Die nächsten Bahnhöfe sind Herzberg am Harz (ca. 20 km) und Bad Lauterberg. Von dort sind Busverbindungen nach Sankt Andreasberg vorhanden.</p>

<h3>Mit dem Bus</h3>
<p>Regelmäßige Busverbindungen aus dem Umland (Goslar, Bad Lauterberg, Osterode). Aktuelle Fahrpläne beim Nahverkehrsverbund.</p>',
        ],
    ];
}
