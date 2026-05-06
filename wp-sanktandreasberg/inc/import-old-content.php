<?php
/**
 * One-time content importer — run via WP-CLI:
 *   wp eval-file wp-content/themes/wp-sanktandreasberg/inc/import-old-content.php
 *
 * Or add ?sab_import=1&sab_import_key=<SECRET> to any page URL (set SAB_IMPORT_KEY in wp-config.php).
 * Skips posts that already exist (checks by slug). Safe to re-run.
 */

if ( defined( 'ABSPATH' ) && ! defined( 'WP_CLI' ) ) {
	// Web-triggered: require secret key
	$key = defined( 'SAB_IMPORT_KEY' ) ? SAB_IMPORT_KEY : false;
	if ( ! $key || empty( $_GET['sab_import'] ) || $_GET['sab_import_key'] !== $key ) {
		return;
	}
}

if ( ! defined( 'ABSPATH' ) ) {
	// Standalone: bootstrap WordPress
	$wp_load = dirname( __DIR__, 4 ) . '/wp-load.php';
	if ( file_exists( $wp_load ) ) {
		require_once $wp_load;
	} else {
		die( 'WordPress not found. Run from theme root or via WP-CLI.' );
	}
}

define( 'SAB_IMPORT_RUNNING', true );

/**
 * Helper: create or get a taxonomy term.
 */
function sab_get_or_create_term( string $name, string $taxonomy ): int {
	$term = get_term_by( 'name', $name, $taxonomy );
	if ( $term ) {
		return $term->term_id;
	}
	$result = wp_insert_term( $name, $taxonomy );
	return is_wp_error( $result ) ? 0 : $result['term_id'];
}

/**
 * Helper: insert post if slug does not exist yet.
 */
function sab_insert_post( array $args, array $meta = [], array $terms = [] ): int {
	if ( ! isset( $args['post_name'] ) ) {
		$args['post_name'] = sanitize_title( $args['post_title'] );
	}
	// Check existing
	$existing = get_page_by_path( $args['post_name'], OBJECT, $args['post_type'] ?? 'post' );
	if ( $existing ) {
		echo "SKIP (exists): {$args['post_title']}\n";
		return $existing->ID;
	}
	$args['post_status'] = $args['post_status'] ?? 'publish';
	$id = wp_insert_post( $args, true );
	if ( is_wp_error( $id ) ) {
		echo "ERROR: {$args['post_title']}: " . $id->get_error_message() . "\n";
		return 0;
	}
	foreach ( $meta as $k => $v ) {
		update_post_meta( $id, $k, $v );
	}
	foreach ( $terms as $taxonomy => $term_ids ) {
		wp_set_object_terms( $id, $term_ids, $taxonomy );
	}
	echo "CREATED: {$args['post_title']} (ID $id)\n";
	return $id;
}

// =============================================================================
// 1. TAXONOMY TERMS
// =============================================================================

echo "\n=== Taxonomy terms ===\n";

// Route types
$term_wandern    = sab_get_or_create_term( 'Wandern',       'activity_type' );
$term_mtb        = sab_get_or_create_term( 'MTB-Touren',    'activity_type' );
$term_loipe      = sab_get_or_create_term( 'Loipen',        'activity_type' );
$term_nordic     = sab_get_or_create_term( 'Nordic Walking','activity_type' );
$term_winter_w   = sab_get_or_create_term( 'Winterwandern', 'activity_type' );

// Place categories
$term_local      = sab_get_or_create_term( 'Sehenswürdigkeit vor Ort', 'place_category' );
$term_regional   = sab_get_or_create_term( 'Ausflugsziel',              'place_category' );
$term_bergbau    = sab_get_or_create_term( 'Bergbau',                   'place_category' );
$term_natur      = sab_get_or_create_term( 'Natur & Nationalpark',      'place_category' );
$term_kultur     = sab_get_or_create_term( 'Kultur & Geschichte',       'place_category' );

// Business types
$term_hotel      = sab_get_or_create_term( 'Hotel',           'business_type' );
$term_pension    = sab_get_or_create_term( 'Pension',         'business_type' );
$term_restaurant = sab_get_or_create_term( 'Gastronomie',     'business_type' );
$term_service    = sab_get_or_create_term( 'Service & Freizeit', 'business_type' );
$term_bank       = sab_get_or_create_term( 'Banken',          'business_type' );
$term_museen     = sab_get_or_create_term( 'Museen',          'business_type' );

echo "Terms: OK\n";

// =============================================================================
// 2. ROUTES — WANDERTOUREN (Hiking)
// =============================================================================

echo "\n=== Wandertouren ===\n";

$hiking_routes = [
	[
		'title'    => 'Freibiersquelle',
		'slug'     => 'freibiersquelle',
		'excerpt'  => 'Nette Umrundung der Stadt. Perfekte Einstiegstour für Naturliebhaber und Familien.',
		'content'  => '<p>Nette Umrundung der Stadt. In ca. 3 Stunden wird dem aufmerksamen Wanderer der gesamte Ort nebst Wahrzeichen und den schönsten Ausblicken in den Südharz vorgeführt. Nicht zu anstrengend durch seine vielen geraden Ebenen, aber sich streckend durch die nette Länge – es ist eine perfekte Einstiegstour für Naturliebhaber oder auch für Familien mit Kindern, für diese gibt es nämlich eine ganze Menge zu entdecken.</p>',
		'distance' => '7,9 km',
		'duration' => '3 Stunden',
		'difficulty'=> 'easy',
		'elevation' => '120 m',
	],
	[
		'title'    => 'Galgenberg',
		'slug'     => 'galgenberg',
		'excerpt'  => 'Kleine Rundwanderung um die Bergstadt Sankt Andreasberg.',
		'content'  => '<p>Kleine Rundwanderung um die Bergstadt Sankt Andreasberg. Eine entspannte Tour, die die Umgebung der Stadt von ihrer besten Seite zeigt.</p>',
		'distance' => '7 km',
		'duration' => '2 Stunden',
		'difficulty'=> 'easy',
		'elevation' => '80 m',
	],
	[
		'title'    => 'Oderberg-Runde',
		'slug'     => 'oderberg-runde-wandern',
		'excerpt'  => 'Kleine Wanderung um die Bergstadt mit Blick auf den Oderberg.',
		'content'  => '<p>Kleine Wanderung um die Bergstadt mit Blick auf den Oderberg. Die Tour führt durch typische Harzer Landschaft mit Wäldern und Wiesen.</p>',
		'distance' => '10 km',
		'duration' => '2,5 Stunden',
		'difficulty'=> 'easy',
		'elevation' => '150 m',
	],
	[
		'title'    => 'Höhenwanderweg',
		'slug'     => 'hoehenwanderweg',
		'excerpt'  => 'Richtige Tour, um den Kreislauf in Schwung zu bringen – mit überwältigenden Ausblicken.',
		'content'  => '<p>Richtige Tour, um den Kreislauf ein wenig in Schwung zu bringen. Planen Sie lieber einen ganzen Tag ein, die erste Hälfte, um die Tour mit ihren Steigungen und überwältigenden Ausblicken zu genießen, die zweite, um vom Erlebten zu berichten! Die saftigen Bergwiesen wechseln sich stets mit immergrünen Harzer Wäldern ab, die Anstiege sind zwar anstrengend, aber nicht zu fordernd. Mit genug Zeit schaffen es auch Untrainierte nebenbei noch Augen für die schönsten Momente zu finden.</p>',
		'distance' => '15 km',
		'duration' => '5 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '340 m',
	],
	[
		'title'    => 'Rinderstall',
		'slug'     => 'rinderstall-wanderung',
		'excerpt'  => 'Halbtagestour mit Einkehrmöglichkeit am Rinderstall.',
		'content'  => '<p>Halbtagestour durch die Harzer Waldlandschaft mit lohnender Einkehrmöglichkeit am Rinderstall. Die Tour bietet schöne Ausblicke über die Südharzer Täler.</p>',
		'distance' => '12 km',
		'duration' => '3,5 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '250 m',
	],
	[
		'title'    => 'Rehberg-Runde',
		'slug'     => 'rehberg-runde',
		'excerpt'  => 'Halbtagestour direkt am Rehberger Graben entlang – einer der schönsten Blicke über Harzer Täler.',
		'content'  => '<p>Die Tour zeichnet sich aus durch seinen Weg: Die erste Hälfte zieht sich direkt entlang des Berges, eigentlich ist sie fast eingehauen. Man hat an der linken Schulter die Berge, den Rehberger Graben und die dichten Wälder, an der rechten direkt einen tiefen Abgrund. Was sich jetzt erst einmal schaurig anhört, ist in Wirklichkeit einer der schönsten Blicke über Harzer Täler – und das über viele Kilometer. Viele kleine Rastplätze laden zum Verweilen ein.</p>',
		'distance' => '13,2 km',
		'duration' => '4 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '280 m',
	],
	[
		'title'    => 'Sieberberg',
		'slug'     => 'sieberberg',
		'excerpt'  => 'Halbtagestour zum Sieberberg mit weiten Ausblicken.',
		'content'  => '<p>Halbtagestour zum Sieberberg. Die Tour bietet weite Ausblicke über den Südharz und führt durch schöne Waldabschnitte.</p>',
		'distance' => '11 km',
		'duration' => '3,5 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '260 m',
	],
	[
		'title'    => 'Silberteich',
		'slug'     => 'silberteich',
		'excerpt'  => 'Tagestour mit Ziel Silberteich – ein idyllischer Harzer Stausee.',
		'content'  => '<p>Tagestour zum idyllischen Silberteich, einem der schönsten Harzer Stauseen. Die längere Tour belohnt mit außergewöhnlichen Landschaftsbildern und der Stille des Nationalparks.</p>',
		'distance' => '18 km',
		'duration' => '6 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '380 m',
	],
	[
		'title'    => 'Skikreuz',
		'slug'     => 'skikreuz-wanderung',
		'excerpt'  => 'Halbtagestour zum Skikreuz mit guten Aussichten.',
		'content'  => '<p>Halbtagestour zum Skikreuz – einer der markanten Punkte rund um Sankt Andreasberg. Gute Aussichten und gepflegte Wege machen diese Tour besonders beliebt.</p>',
		'distance' => '10 km',
		'duration' => '3 Stunden',
		'difficulty'=> 'easy',
		'elevation' => '180 m',
	],
	[
		'title'    => 'Skikreuz-Runde',
		'slug'     => 'skikreuz-runde',
		'excerpt'  => 'Längere Tagestour über das Skikreuz mit großem Höhenpanorama.',
		'content'  => '<p>Längere Tagestour, die das Skikreuz in einer großen Runde umfasst. Großes Höhenpanorama und vielfältige Harzer Natur erwarten den Wanderer.</p>',
		'distance' => '20 km',
		'duration' => '7 Stunden',
		'difficulty'=> 'hard',
		'elevation' => '500 m',
	],
	[
		'title'    => 'Sonnenberg (Wanderung)',
		'slug'     => 'sonnenberg-wanderung',
		'excerpt'  => 'Halbtagestour zum Sonnenberg mit schönen Harzer Aussichten.',
		'content'  => '<p>Halbtagestour zum Sonnenberg. Die Tour führt durch lichte Wälder und über offene Höhen mit schönen Aussichten über den Harz.</p>',
		'distance' => '13 km',
		'duration' => '4 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '300 m',
	],
	[
		'title'    => 'Wolfswarte',
		'slug'     => 'wolfswarte',
		'excerpt'  => 'Halbtagestour zur Wolfswarte mit Blick auf den Nationalpark Harz.',
		'content'  => '<p>Halbtagestour zur Wolfswarte, einem der markanten Aussichtspunkte im Nationalpark Harz. Die Tour bietet eindrucksvolle Blicke auf das Hochmoor und die Harzer Bergwelt.</p>',
		'distance' => '14 km',
		'duration' => '4,5 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '320 m',
	],
	[
		'title'    => 'Bismarckturm',
		'slug'     => 'bismarckturm-wanderung',
		'excerpt'  => 'Halbtagestour zum historischen Bismarckturm bei Bad Sachsa.',
		'content'  => '<p>Halbtagestour zum historischen Bismarckturm. Der Turm bietet nach dem Aufstieg einen wunderbaren Rundblick über die Südharzlandschaft. Am Ziel kann man im gleichnamigen Ausflugslokal einkehren.</p>',
		'distance' => '16 km',
		'duration' => '5 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '350 m',
	],
	[
		'title'    => 'Clausthaler Flutgraben',
		'slug'     => 'clausthaler-flutgraben',
		'excerpt'  => 'Halbtagestour entlang des historischen Clausthaler Flutgrabens.',
		'content'  => '<p>Halbtagestour entlang des historischen Clausthaler Flutgrabens, einem Teil des UNESCO-Weltkulturerbes Oberharzer Wasserregal. Die Tour verbindet Naturerlebnis mit lebendiger Bergbaugeschichte.</p>',
		'distance' => '12 km',
		'duration' => '3,5 Stunden',
		'difficulty'=> 'easy',
		'elevation' => '150 m',
	],
	[
		'title'    => 'Achtermann (Wanderung)',
		'slug'     => 'achtermann-wanderung',
		'excerpt'  => 'Rundkurs um den Achtermann – beeindruckende Moorlandschaft im Nationalpark Harz.',
		'content'  => '<p>Rundwanderung um den Achtermann. Beeindruckende Moorlandschaft und ein großartiger Ausblick vom Gipfel machen diese Tour zu einem Highlight im Nationalpark Harz. Der Achtermann ist nach dem Brocken der zweithöchste Berg im Harz.</p>',
		'distance' => '12 km',
		'duration' => '4 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '280 m',
	],
];

foreach ( $hiking_routes as $r ) {
	sab_insert_post(
		[
			'post_type'    => 'route',
			'post_title'   => $r['title'],
			'post_name'    => $r['slug'],
			'post_content' => $r['content'],
			'post_excerpt' => $r['excerpt'],
		],
		[
			'route_distance'   => $r['distance'],
			'route_duration'   => $r['duration'],
			'route_difficulty' => $r['difficulty'],
			'route_elevation'  => $r['elevation'],
		],
		[ 'activity_type' => [ $term_wandern ] ]
	);
}

// =============================================================================
// 3. ROUTES — MTB-TOUREN
// =============================================================================

echo "\n=== MTB-Touren ===\n";

$mtb_routes = [
	[
		'title'    => 'Drei-Türme-Tour',
		'slug'     => 'drei-tuerme-tour',
		'excerpt'  => 'Sehr anspruchsvolle Tagestour mit vielen Höhenmetern und unvergleichlichem Panorama.',
		'content'  => '<p>Nach einer kurzen Durchfahrt durch die Höhen St. Andreasbergs geht es auch schon in die wunderschöne Natur des Oberharzes: Viel Abwechslung zwischen Wiesen und Wäldern und die wohl kaum zu übertreffende Aussicht über die gesamte Tour machen sie zu einem visuellen Hochgenuss. Fit sollte man allerdings schon sein, denn die Anstiege sind weder in Länge noch in ihrer Steigung zu verachten. Aber auch für Ungeübte ist die Tour mit viel Zeit machbar.</p>',
		'distance' => '59 km',
		'duration' => '6–8 Stunden',
		'difficulty'=> 'hard',
		'elevation' => '1200 m',
	],
	[
		'title'    => 'Sonnenberg-Runde (MTB)',
		'slug'     => 'sonnenberg-runde-mtb',
		'excerpt'  => 'Anspruchsvolle Halbtagestour mit langen ebenen Strecken und knackigen Anstiegen.',
		'content'  => '<p>Die Tour zeichnet sich aus durch lange, fast ebene Strecken und knackige Anstiege. Wer nach dem ersten Anstieg schon eine kleine Erfrischung braucht, kommt im Rehberger Grabenhaus gewiss auf seine Kosten. Sieben Kilometer weiter kann man am Oderteich wieder eine kurze Rast einlegen und sich hier durch einen kurzen Sprung ins kühlende Nass Erleichterung verschaffen. Anschließend kommt man zum anspruchsvolleren Teil der Halbtagestour.</p>',
		'distance' => '38 km',
		'duration' => '3–4 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '700 m',
	],
	[
		'title'    => 'Einhornhöhle-Runde',
		'slug'     => 'einhornhoehle-runde',
		'excerpt'  => 'Sehr anspruchsvolle Tagestour mit Besuch der Einhornhöhle und Blick vom Großen Knollen.',
		'content'  => '<p>Eine anspruchsvolle Tagestour mit vielen Höhenmetern. Lange Abfahrten mit ordentlichem Tempo wechseln sich mit Steigungen ab, die einem das Blut kochen lassen! Selbst eingefleischte Radfahrer können hier schnell an ihre Grenzen stoßen. Aber es lohnt sich: Der Blick vom Großen Knollen geht viele Kilometer in den Harz hinein, ein kurzer Abstecher in die Einhornhöhle lässt einen verschnaufen und zu neuen Kräften finden.</p>',
		'distance' => '47 km',
		'duration' => '5–7 Stunden',
		'difficulty'=> 'hard',
		'elevation' => '1000 m',
	],
	[
		'title'    => 'Brockenritt',
		'slug'     => 'brockenritt',
		'excerpt'  => 'Die Königstour – 65 km direkt auf den Gipfel des Brockens und zurück.',
		'content'  => '<p>Der Reiz dieser Tour liegt in der Überwindung der vielen Höhen- und Streckenmeter auf dem direkten Weg hinauf zum Brocken. Nach netten ca. 10 Kilometern entlang der eigentlichen Berge und durch die wundervollen Moorlandschaften des Oderteichs beginnt die Strecke sich zu einem Monster zu entwickeln: Möchte man noch vor Einbruch der Nacht wieder die Ebenen erreichen, sollte man beginnen, ein wenig Tempo vorzulegen, was es nicht gerade einfacher macht, die starke Steigung auf den Gipfel zu bewältigen. Doch wer oben ankommt, wird reich belohnt.</p>',
		'distance' => '65 km',
		'duration' => '7–9 Stunden',
		'difficulty'=> 'hard',
		'elevation' => '1500 m',
	],
	[
		'title'    => 'Sperrlutter-Runde',
		'slug'     => 'sperrlutter-runde',
		'excerpt'  => 'Anspruchsvolle Halbtagestour durch das Sperrlutter-Tal.',
		'content'  => '<p>Anspruchsvolle Halbtagestour durch das Sperrlutter-Tal. Technisch abwechslungsreiche Strecke mit schönen Naturabschnitten im Harz.</p>',
		'distance' => '32 km',
		'duration' => '3–4 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '650 m',
	],
	[
		'title'    => 'Odertalsperren-Runde',
		'slug'     => 'odertalsperren-runde',
		'excerpt'  => 'Anspruchsvolle Tour rund um die Odertalsperre.',
		'content'  => '<p>Anspruchsvolle Halbtagestour rund um die Odertalsperre. Die Tour bietet herrliche Blicke auf das Stauseegebiet und führt durch abwechslungsreiche Harzer Waldlandschaft.</p>',
		'distance' => '35 km',
		'duration' => '3–5 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '720 m',
	],
	[
		'title'    => 'Odertal-Runde',
		'slug'     => 'odertal-runde',
		'excerpt'  => 'Anspruchsvolle Halbtagestour durch das wildromantische Odertal.',
		'content'  => '<p>Anspruchsvolle Halbtagestour durch das wildromantische Odertal. Der Oderfluss begleitet die Tour auf weiten Strecken, immer wieder eröffnen sich malerische Ausblicke.</p>',
		'distance' => '30 km',
		'duration' => '3–4 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '600 m',
	],
	[
		'title'    => 'Hans-Kühnen-Burg-Runde',
		'slug'     => 'hanskuehn-burg-runde',
		'excerpt'  => 'Anspruchsvolle Tour zur historischen Hanskühenburg.',
		'content'  => '<p>Anspruchsvolle Tour zur historischen Hanskühenburg. Das beliebte Ausflugslokal auf dem Gipfel ist Ziel und Belohnung zugleich. Die Strecke bietet abwechslungsreiche Harzer Landschaft.</p>',
		'distance' => '28 km',
		'duration' => '3–4 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '550 m',
	],
];

foreach ( $mtb_routes as $r ) {
	sab_insert_post(
		[
			'post_type'    => 'route',
			'post_title'   => $r['title'],
			'post_name'    => $r['slug'],
			'post_content' => $r['content'],
			'post_excerpt' => $r['excerpt'],
		],
		[
			'route_distance'   => $r['distance'],
			'route_duration'   => $r['duration'],
			'route_difficulty' => $r['difficulty'],
			'route_elevation'  => $r['elevation'],
		],
		[ 'activity_type' => [ $term_mtb ] ]
	);
}

// =============================================================================
// 4. ROUTES — LOIPEN (Cross-country ski)
// =============================================================================

echo "\n=== Loipen ===\n";

$loipen = [
	[
		'title'    => 'Beerberg-Loipe',
		'slug'     => 'beerberg-loipe',
		'excerpt'  => 'Loipe rund um den Beerberg – leichte Runde für die ganze Familie.',
		'content'  => '<p>Die Beerberg-Loipe führt rund um den Beerberg und ist die ideale Loipe für Einsteiger und Familien. Der Bergbaulehrpfad rund um den Beerberg zeigt die Montangeschichte des „auswendigen Zuges".</p>',
		'distance' => '8 km',
		'duration' => '1,5 Stunden',
		'difficulty'=> 'easy',
		'elevation' => '30 m',
	],
	[
		'title'    => 'Jordanshöhe-Loipe',
		'slug'     => 'jordanshoehe-loipe',
		'excerpt'  => 'Loipe oberhalb der Bergstadt mit schönem Blick auf Sankt Andreasberg.',
		'content'  => '<p>Die Jordanshöhe-Loipe führt oberhalb der Bergstadt und bietet immer wieder schöne Blicke auf Sankt Andreasberg. Eine mittlere Tour für geübte Skilangläufer.</p>',
		'distance' => '12 km',
		'duration' => '2 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '90 m',
	],
	[
		'title'    => 'Oderberg-Loipe',
		'slug'     => 'oderberg-loipe',
		'excerpt'  => 'Anspruchsvolle Loipe rund um den Oderberg mit 180 Höhenmetern.',
		'content'  => '<p>Die Oderberg-Loipe ist die anspruchsvollste der Sankt Andreasberger Loipen. Mit 180 Höhenmetern und technisch schwierigen Abschnitten ist sie erfahrenen Langläufern vorbehalten. Großartige Ausblicke belohnen die Mühe.</p>',
		'distance' => '15 km',
		'duration' => '3 Stunden',
		'difficulty'=> 'hard',
		'elevation' => '180 m',
	],
	[
		'title'    => 'Schneewittchen-Loipe',
		'slug'     => 'schneewittchen-loipe',
		'excerpt'  => 'Leichte Familienloipe am Sonnenberg – ideal für Einsteiger.',
		'content'  => '<p>Die Schneewittchen-Loipe am Sonnenberg ist die kürzeste und einfachste Loipe im Raum Sankt Andreasberg. Ideal für Einsteiger und Familien mit Kindern.</p>',
		'distance' => '5 km',
		'duration' => '1 Stunde',
		'difficulty'=> 'easy',
		'elevation' => '80 m',
	],
	[
		'title'    => 'Sonnenberg-Loipe',
		'slug'     => 'sonnenberg-loipe',
		'excerpt'  => 'Mittelschwere Loipe am Sonnenberg mit 240 Höhenmetern.',
		'content'  => '<p>Die Sonnenberg-Loipe ist eine der beliebtesten Loipen in der Region. Mit 240 Höhenmetern bietet sie ein gutes Training für geübte Langläufer. Die Strecke führt durch lichte Nadelwälder auf dem Sonnenberg.</p>',
		'distance' => '18 km',
		'duration' => '3 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '240 m',
	],
	[
		'title'    => 'Achtermann-Loipe',
		'slug'     => 'achtermann-loipe',
		'excerpt'  => 'Mittelschwere Loipe rund um den Achtermann – Start/Ende Königskrug.',
		'content'  => '<p>Die Achtermann-Loipe führt rund um den Achtermann, dem zweithöchsten Berg im Harz. Start und Endpunkt ist der Königskrug. Die Loipe bietet eindrucksvolle Hochmoorlandschaft und Nationalpark-Natur.</p><p>Verlängerung bis Sonnenberg möglich: Gesamtlänge 13,6 km.</p>',
		'distance' => '6 km',
		'duration' => '1,5 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '180 m',
	],
];

foreach ( $loipen as $r ) {
	sab_insert_post(
		[
			'post_type'    => 'route',
			'post_title'   => $r['title'],
			'post_name'    => $r['slug'],
			'post_content' => $r['content'],
			'post_excerpt' => $r['excerpt'],
		],
		[
			'route_distance'   => $r['distance'],
			'route_duration'   => $r['duration'],
			'route_difficulty' => $r['difficulty'],
			'route_elevation'  => $r['elevation'],
		],
		[ 'activity_type' => [ $term_loipe ] ]
	);
}

// =============================================================================
// 5. ROUTES — NORDIC WALKING
// =============================================================================

echo "\n=== Nordic Walking ===\n";

$nordic_routes = [
	[
		'title'    => 'Andreasheim-Runde (Nordic Walking)',
		'slug'     => 'andreasheim-nordic',
		'excerpt'  => 'Kurze Nordic-Walking-Runde rund ums Andreasheim.',
		'content'  => '<p>Kurze, angenehme Nordic-Walking-Runde rund ums Andreasheim. Ideal für einen aktiven Start in den Tag.</p>',
		'distance' => '4,4 km',
		'duration' => '1 Stunde',
		'difficulty'=> 'easy',
		'elevation' => '60 m',
	],
	[
		'title'    => 'Inliner-Sieber (Nordic Walking)',
		'slug'     => 'inliner-sieber-nordic',
		'excerpt'  => 'Nordic-Walking-Strecke durch das Siebertal.',
		'content'  => '<p>Nordic-Walking-Strecke durch das idyllische Siebertal. Die gut befestigte Strecke ist ideal für Inline-Skater und Nordic Walker.</p>',
		'distance' => '15 km',
		'duration' => '3 Stunden',
		'difficulty'=> 'easy',
		'elevation' => '100 m',
	],
	[
		'title'    => 'Höhenweg (Nordic Walking)',
		'slug'     => 'hoehenweg-nordic',
		'excerpt'  => 'Nordic-Walking entlang des Höhenweges oberhalb der Stadt.',
		'content'  => '<p>Nordic-Walking-Tour entlang des Höhenweges mit herrlichen Ausblicken über Sankt Andreasberg und das Umland.</p>',
		'distance' => '10 km',
		'duration' => '2 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '180 m',
	],
	[
		'title'    => 'Dreijungfern-Runde',
		'slug'     => 'dreijungfern-nordic',
		'excerpt'  => 'Nordic-Walking zur sagenumwobenen Dreijungfernquelle.',
		'content'  => '<p>Nordic-Walking zur sagenumwobenen Dreijungfernquelle. Eine schöne mittlere Tour durch Harzer Wälder mit Quellbesuch als Highlight.</p>',
		'distance' => '12 km',
		'duration' => '2,5 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '200 m',
	],
	[
		'title'    => 'Kleiner Oderberg (Nordic Walking)',
		'slug'     => 'kleiner-oderberg-nordic',
		'excerpt'  => 'Nordic-Walking-Tour zum Kleinen Oderberg.',
		'content'  => '<p>Nordic-Walking-Tour zum Kleinen Oderberg. Die Tour bietet schöne Ausblicke und führt durch abwechslungsreiche Harzer Natur.</p>',
		'distance' => '9 km',
		'duration' => '2 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '160 m',
	],
];

foreach ( $nordic_routes as $r ) {
	sab_insert_post(
		[
			'post_type'    => 'route',
			'post_title'   => $r['title'],
			'post_name'    => $r['slug'],
			'post_content' => $r['content'],
			'post_excerpt' => $r['excerpt'],
		],
		[
			'route_distance'   => $r['distance'],
			'route_duration'   => $r['duration'],
			'route_difficulty' => $r['difficulty'],
			'route_elevation'  => $r['elevation'],
		],
		[ 'activity_type' => [ $term_nordic ] ]
	);
}

// =============================================================================
// 6. ROUTES — WINTERWANDERN / SCHNEESCHUH
// =============================================================================

echo "\n=== Winterwandern ===\n";

$winter_routes = [
	[
		'title'    => 'Matthias-Schmidt-Berg (Winter)',
		'slug'     => 'msb-winter',
		'excerpt'  => 'Winterwanderung auf den Matthias-Schmidt-Berg mit Blick auf die Bergstadt.',
		'content'  => '<p>Winterwanderung auf den Matthias-Schmidt-Berg. Vom Gipfel hat man einen wunderschönen Blick auf die schneebedeckte Bergstadt Sankt Andreasberg. Im Winter besonders stimmungsvoll.</p>',
		'distance' => '8 km',
		'duration' => '2,5 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '200 m',
	],
	[
		'title'    => 'Sieberberg (Winter)',
		'slug'     => 'sieberberg-winter',
		'excerpt'  => 'Winterwanderung zum Sieberberg mit Schneeschuhverleih möglich.',
		'content'  => '<p>Winterwanderung zum Sieberberg. Im Winter besonders eindrucksvoll, wenn die Harzer Natur unter einer Schneedecke liegt. Schneeschuhe können bei der Bergsport Arena GmbH ausgeliehen werden.</p>',
		'distance' => '11 km',
		'duration' => '3,5 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '280 m',
	],
	[
		'title'    => 'Sonnenberg (Winter)',
		'slug'     => 'sonnenberg-winter',
		'excerpt'  => 'Schneeschuhwanderung am Sonnenberg – traumhafte Winterlandschaft.',
		'content'  => '<p>Schneeschuhwanderung am Sonnenberg. Das Hochmoor auf dem Sonnenberg verwandelt sich im Winter in eine traumhafte Landschaft. Schneeschuhe können bei der Bergsport Arena GmbH ausgeliehen werden.</p>',
		'distance' => '10 km',
		'duration' => '3 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '240 m',
	],
	[
		'title'    => 'Rehberg (Winter)',
		'slug'     => 'rehberg-winter',
		'excerpt'  => 'Winterwanderung am Rehberger Graben mit Schnee und Stille.',
		'content'  => '<p>Winterwanderung am Rehberger Graben. Der historische Wassergraben im Schnee ist ein besonderes Erlebnis. Die Strecke führt durch ruhige Waldgebiete – Stille und Einsamkeit garantiert.</p>',
		'distance' => '13 km',
		'duration' => '4 Stunden',
		'difficulty'=> 'medium',
		'elevation' => '250 m',
	],
];

foreach ( $winter_routes as $r ) {
	sab_insert_post(
		[
			'post_type'    => 'route',
			'post_title'   => $r['title'],
			'post_name'    => $r['slug'],
			'post_content' => $r['content'],
			'post_excerpt' => $r['excerpt'],
		],
		[
			'route_distance'   => $r['distance'],
			'route_duration'   => $r['duration'],
			'route_difficulty' => $r['difficulty'],
			'route_elevation'  => $r['elevation'],
		],
		[ 'activity_type' => [ $term_winter_w ] ]
	);
}

// =============================================================================
// 7. PLACES — LOCAL SIGHTS
// =============================================================================

echo "\n=== Sehenswürdigkeiten (lokal) ===\n";

$local_places = [
	[
		'title'   => 'Bergwerksmuseum Grube Samson',
		'slug'    => 'grube-samson',
		'excerpt' => 'Das bedeutendste Bergbau-Denkmal im Oberharz – UNESCO-Weltkulturerbe seit 2010.',
		'content' => '<p>Das Bergwerksmuseum Grube Samson ist das bedeutendste Bergbau-Denkmal im Oberharz und seit 2010 UNESCO-Weltkulturerbe. Das einzigartige Wasserkunstwerk aus dem 19. Jahrhundert ist heute als Besucherbergwerk zugänglich.</p><p>Besucher erleben die 810 m tief reichenden Förderstollen und das beeindruckende Kehrrad – eines der größten erhaltenen Holzkunstgespräche der Welt. Die Grube Samson wurde 1521 in Betrieb genommen und war über vier Jahrhunderte Herzstück des Andreasberger Silberbergbaus.</p><p>Eintritt: 8 €/Person. Führungen finden regelmäßig statt.</p>',
		'address' => 'Am Samson 2, 37444 Sankt Andreasberg',
		'hours'   => 'April–Oktober: täglich 9–17 Uhr',
		'fee'     => '8 €',
		'coords'  => '51.7195,10.5398',
		'terms'   => [ $term_local, $term_bergbau ],
	],
	[
		'title'   => 'Glockenturm',
		'slug'    => 'glockenturm',
		'excerpt' => 'Das Wahrzeichen von Sankt Andreasberg – historischer Bergbauturm aus dem 16. Jahrhundert.',
		'content' => '<p>Der Glockenturm ist das unverwechselbare Wahrzeichen von Sankt Andreasberg. Der historische Schachtturm stammt aus dem 16. Jahrhundert und steht heute unter Denkmalschutz. Er erinnert an die jahrhundertelange Bergbautradition der Stadt.</p><p>Der Turm ist von außen frei zugänglich und bietet einen schönen Fotomotiv im Zentrum der Stadt.</p>',
		'address' => 'Glockenturmstraße, 37444 Sankt Andreasberg',
		'hours'   => 'Außenbereich: jederzeit',
		'fee'     => 'kostenlos',
		'coords'  => '51.7202,10.5372',
		'terms'   => [ $term_local, $term_bergbau, $term_kultur ],
	],
	[
		'title'   => 'Ev. Martini-Kirche',
		'slug'    => 'martini-kirche',
		'excerpt' => 'Die große Bergmannskirche – eines der schönsten Kirchengebäude im Harz.',
		'content' => '<p>Die Evangelische Martini-Kirche ist eines der schönsten Kirchengebäude im Harz und ein wichtiges Zeugnis der Bergmannskultur. Die barocke Kirche wurde im 17. Jahrhundert erbaut und beherbergt wertvolle historische Ausstattung.</p><p>Die Kirche ist bei Gottesdiensten und zu Besichtigungszeiten geöffnet.</p>',
		'address' => 'Am Kirchplatz 5, 37444 Sankt Andreasberg',
		'hours'   => 'Mo–Fr nach Gottesdiensten',
		'fee'     => 'kostenlos',
		'coords'  => '51.7198,10.5365',
		'terms'   => [ $term_local, $term_kultur ],
	],
	[
		'title'   => 'Nationalparkhaus Sankt Andreasberg',
		'slug'    => 'nationalparkhaus',
		'excerpt' => 'Das Besucherzentrum des Nationalparks Harz mit Ausstellungen zur Natur und Tierwelt.',
		'content' => '<p>Das Nationalparkhaus Sankt Andreasberg ist das Tor zum Nationalpark Harz. Mit abwechslungsreichen Ausstellungen zur Flora und Fauna des Nationalparks lädt es Besucher ein, die einzigartige Harzer Natur zu entdecken.</p><p>Das Nationalparkhaus bietet auch geführte Wanderungen in den Nationalpark an.</p>',
		'address' => 'Erzwäsche 1, 37444 Sankt Andreasberg',
		'hours'   => 'Di–So 10–17 Uhr',
		'fee'     => 'kostenlos',
		'coords'  => '51.7185,10.5380',
		'terms'   => [ $term_local, $term_natur ],
	],
	[
		'title'   => 'Rathaus Sankt Andreasberg',
		'slug'    => 'rathaus-sanktandreasberg',
		'excerpt' => 'Das historische Rathaus im Zentrum der Bergstadt.',
		'content' => '<p>Das historische Rathaus liegt im Zentrum der Bergstadt Sankt Andreasberg. Es wurde im 19. Jahrhundert erbaut und prägt das Stadtbild. Heute beherbergt es das Bürgerbüro der Stadt Braunlage, Ortsteil Sankt Andreasberg.</p>',
		'address' => 'Dr.-Willi-Bergmann-Straße 23, 37444 Sankt Andreasberg',
		'hours'   => 'Mo–Fr 9–17 Uhr',
		'fee'     => 'kostenlos',
		'coords'  => '51.7207,10.5360',
		'terms'   => [ $term_local, $term_kultur ],
	],
	[
		'title'   => 'Hochseilgarten Bergsport Arena',
		'slug'    => 'hochseilgarten',
		'excerpt' => 'Der größte Hochseilgarten im Harz – Kletterabenteuer für die ganze Familie.',
		'content' => '<p>Der Hochseilgarten der Bergsport Arena GmbH ist der größte Hochseilgarten im Harz. Mit zahlreichen Parcours für unterschiedliche Schwierigkeitsgrade bietet er Nervenkitzel und Spaß für die ganze Familie.</p><p>Kinder ab 6 Jahren können unter Aufsicht mitmachen. Ausrüstung wird gestellt. Voranmeldung empfohlen.</p>',
		'address' => 'An der Skiwiese, 37444 Sankt Andreasberg',
		'hours'   => 'Sommer: täglich 10–18 Uhr (wetterabhängig)',
		'fee'     => 'ab 15 €',
		'coords'  => '51.7175,10.5340',
		'terms'   => [ $term_local, $term_natur ],
	],
	[
		'title'   => 'Grube Roter Bär',
		'slug'    => 'grube-roter-baer',
		'excerpt' => 'Historisches Bergwerk im Stadtgebiet – Teil des UNESCO-Welterbes Oberharzer Wasserwirtschaft.',
		'content' => '<p>Die Grube Roter Bär ist ein weiteres historisches Bergwerk im Stadtgebiet von Sankt Andreasberg. Als Teil des UNESCO-Welterbes „Oberharzer Wasserwirtschaft" erzählt sie von der jahrhundertelangen Bergbautradition des Ortes.</p>',
		'address' => 'Dr.-Willi-Bergmann-Straße 28, 37444 Sankt Andreasberg',
		'hours'   => 'Nach Anfrage',
		'fee'     => 'Nach Vereinbarung',
		'coords'  => '51.7210,10.5355',
		'terms'   => [ $term_local, $term_bergbau ],
	],
	[
		'title'   => 'Harzer Roller-Kanarien-Museum',
		'slug'    => 'harzer-roller-museum',
		'excerpt' => 'Einzigartiges Museum über die Harzer Roller-Kanarien – weltberühmte Singvögel aus dem Harz.',
		'content' => '<p>Das Harzer Roller-Kanarien-Museum ist eine einzigartige Sehenswürdigkeit: Die Harzer Roller sind weltberühmte Singvögel, die seit dem 17. Jahrhundert im Harz gezüchtet werden. Das Museum zeigt die Geschichte dieser besonderen Kanarienvögel und ihre Rolle in der Bergbaukultur.</p>',
		'address' => 'Am Samson 2, 37444 Sankt Andreasberg',
		'hours'   => 'April–Oktober: täglich 9–17 Uhr',
		'fee'     => 'Im Eintritt Grube Samson enthalten',
		'coords'  => '51.7195,10.5398',
		'terms'   => [ $term_local, $term_kultur ],
	],
	[
		'title'   => 'Rehberger Grabenhaus',
		'slug'    => 'rehberger-grabenhaus',
		'excerpt' => 'Historisches Grabenhaus am Rehberger Graben – Gaststätte mit langer Tradition.',
		'content' => '<p>Das Rehberger Grabenhaus liegt direkt am historischen Rehberger Graben, einem der ältesten Wasserläufe im Oberharz (erbaut um 1600). Das beliebte Ausflugslokal ist Ziel vieler Wanderer und Radfahrer.</p><p>Hier lässt sich eine Wanderpause im historischen Ambiente genießen, während der Rehberger Graben Seit über 300 Jahren das Oderwasser in die Bergstadt leitet.</p>',
		'address' => 'Rehberger Graben, 37444 Sankt Andreasberg',
		'hours'   => 'Täglich ab 10 Uhr (saisonal)',
		'fee'     => 'kostenlos (Gaststätte)',
		'coords'  => '51.7330,10.5120',
		'terms'   => [ $term_local, $term_bergbau ],
	],
	[
		'title'   => 'Bergbaulehrpfad Beerberg',
		'slug'    => 'bergbaulehrpfad-beerberg',
		'excerpt' => 'Lehrpfad zur Bergbaugeschichte rund um den Beerberg mit Hinweistafeln.',
		'content' => '<p>Der Bergbaulehrpfad rund um den Beerberg zeigt die Montangeschichte des „auswendigen Zuges". Auf Hinweistafeln wird die Bergbauvergangenheit der Region anschaulich und verständlich erklärt.</p><p>Der Lehrpfad ist ein kostenloser und lehrreicher Spaziergang für die ganze Familie.</p>',
		'address' => 'Am Beerberg, 37444 Sankt Andreasberg',
		'hours'   => 'Jederzeit',
		'fee'     => 'kostenlos',
		'coords'  => '51.7220,10.5420',
		'terms'   => [ $term_local, $term_bergbau, $term_natur ],
	],
];

foreach ( $local_places as $p ) {
	sab_insert_post(
		[
			'post_type'    => 'place',
			'post_title'   => $p['title'],
			'post_name'    => $p['slug'],
			'post_content' => $p['content'],
			'post_excerpt' => $p['excerpt'],
		],
		[
			'place_address'       => $p['address'],
			'place_opening_hours' => $p['hours'],
			'place_entry_fee'     => $p['fee'],
			'place_coordinates'   => $p['coords'],
		],
		[ 'place_category' => $p['terms'] ]
	);
}

// =============================================================================
// 8. PLACES — REGIONAL ATTRACTIONS
// =============================================================================

echo "\n=== Sehenswürdigkeiten (regional) ===\n";

$regional_places = [
	[
		'title'   => 'UNESCO-Welterbe Goslar & Rammelsberg',
		'slug'    => 'goslar-rammelsberg-unesco',
		'excerpt' => 'UNESCO-Welterbe: Kaiserstadt Goslar mit Kaiserpfalz und Erzbergwerk Rammelsberg.',
		'content' => '<p>Goslar zählt mit seinem historischen Stadtkern, der Kaiserpfalz und dem Erzbergwerk Rammelsberg zum UNESCO-Welterbe. Die mittelalterliche Kaiserstadt liegt nur 30 km von Sankt Andreasberg entfernt und ist ein absolutes Muss für Kulturinteressierte.</p><p>Sehenswert: Kaiserpfalz, Rammelsberg-Museum, Goslarer Altstadt, Zwinger.</p>',
		'address' => 'Goslar, Niedersachsen',
		'terms'   => [ $term_regional, $term_kultur ],
	],
	[
		'title'   => 'UNESCO-Welterbe Quedlinburg',
		'slug'    => 'quedlinburg-unesco',
		'excerpt' => 'UNESCO-Welterbe: Stiftskirche St. Servatius und Schloss Quedlinburg.',
		'content' => '<p>Quedlinburg mit seiner über 1.000-jährigen Geschichte ist ebenfalls UNESCO-Welterbe. Die romanische Stiftskirche St. Servatius und das Schloss auf dem Schlossberg sind die Höhepunkte. Die mittelalterliche Fachwerkstadt liegt ca. 50 km von Sankt Andreasberg.</p>',
		'address' => 'Quedlinburg, Sachsen-Anhalt',
		'terms'   => [ $term_regional, $term_kultur ],
	],
	[
		'title'   => 'Schloss Wernigerode',
		'slug'    => 'schloss-wernigerode',
		'excerpt' => 'Das Märchenschloss am Harzrand – heute Museum mit herrlicher Aussicht.',
		'content' => '<p>Das Schloss Wernigerode thront majestätisch über der bunten Fachwerkstadt am Harzrand. Das romantische Schloss aus dem Mittelalter (heute neugotisch) beherbergt ein Museum zur Feudalkultur. Die Harzquerbahn verbindet Wernigerode mit dem Brocken.</p>',
		'address' => 'Wernigerode, Sachsen-Anhalt',
		'terms'   => [ $term_regional, $term_kultur ],
	],
	[
		'title'   => 'Einhornhöhle Scharzfeld',
		'slug'    => 'einhornhoehle-scharzfeld',
		'excerpt' => 'Schauhöhle mit urzeitlichen Funden – Höhle des Einhorns bei Scharzfeld.',
		'content' => '<p>Die Einhornhöhle bei Scharzfeld ist eine der ältesten bekannten Schauhöhlen Deutschlands. Hier wurden Knochen prähistorischer Tiere und früher Menschen gefunden. Die sagenhafte „Einhornjagd" gab der Höhle ihren Namen.</p>',
		'address' => 'Scharzfeld, Niedersachsen',
		'terms'   => [ $term_regional, $term_natur ],
	],
	[
		'title'   => 'Bismarckturm (Ausflugsziel)',
		'slug'    => 'bismarckturm-ausflug',
		'excerpt' => 'Aussichtsturm mit Blick über den Südharz – beliebtes Wanderziel.',
		'content' => '<p>Der Bismarckturm auf dem Großen Knollen ist ein beliebtes Wanderziel mit hervorragendem Rundblick über den Südharz. Das Ausflugslokal am Turm lädt zur Einkehr ein.</p>',
		'address' => 'Großer Knollen, Niedersachsen',
		'terms'   => [ $term_regional, $term_natur ],
	],
	[
		'title'   => 'Oberharzer Wasserregal',
		'slug'    => 'oberharzer-wasserregal',
		'excerpt' => 'UNESCO-Welterbe: Das größte vorindustrielle Wasserwirtschaftssystem Europas.',
		'content' => '<p>Das Oberharzer Wasserregal ist das größte vorindustrielle Wasserwirtschaftssystem Europas und seit 2010 UNESCO-Welterbe. Das System von Gräben, Teichen und Tunneln wurde ab dem 16. Jahrhundert angelegt, um die Bergwerke mit Aufschlagwasser zu versorgen. Der Rehberger Graben gehört dazu.</p>',
		'address' => 'Clausthal-Zellerfeld, Niedersachsen',
		'terms'   => [ $term_regional, $term_bergbau ],
	],
	[
		'title'   => 'Bad Harzburger Sole-Therme',
		'slug'    => 'bad-harzburg-therme',
		'excerpt' => 'Sole-Therme in Bad Harzburg – Entspannung und Wellness am Harzrand.',
		'content' => '<p>Die Sole-Therme Bad Harzburg bietet Entspannung und Wellness in wohltuenden Solebädern. Der Kurort Bad Harzburg liegt ca. 35 km von Sankt Andreasberg entfernt am nördlichen Harzrand.</p>',
		'address' => 'Bad Harzburg, Niedersachsen',
		'terms'   => [ $term_regional ],
	],
	[
		'title'   => 'Kloster Walkenried',
		'slug'    => 'kloster-walkenried',
		'excerpt' => 'Beeindruckendes Zisterzienserkloster aus dem 12. Jahrhundert bei Bad Sachsa.',
		'content' => '<p>Das Kloster Walkenried ist eines der bedeutendsten mittelalterlichen Denkmäler im Harz. Die imposante Ruine des Zisterzienserklosters aus dem 12. Jahrhundert begeistert Besucher mit ihrer gotischen Architektur.</p>',
		'address' => 'Walkenried, Niedersachsen',
		'terms'   => [ $term_regional, $term_kultur ],
	],
	[
		'title'   => 'Odertalsperre',
		'slug'    => 'odertalsperre',
		'excerpt' => 'Idyllischer Stausee bei Sankt Andreasberg – ideal für Ausflüge und Spaziergänge.',
		'content' => '<p>Die Odertalsperre liegt in unmittelbarer Nähe von Sankt Andreasberg und ist eines der beliebtesten Ausflugsziele in der Region. Der idyllische Stausee lädt zu Spaziergängen und Radtouren ein. Das Tal der Oder ist auch Ziel zahlreicher Wandertouren.</p>',
		'address' => 'Odertal, 37444 Sankt Andreasberg',
		'terms'   => [ $term_regional, $term_natur ],
	],
];

foreach ( $regional_places as $p ) {
	sab_insert_post(
		[
			'post_type'    => 'place',
			'post_title'   => $p['title'],
			'post_name'    => $p['slug'],
			'post_content' => $p['content'],
			'post_excerpt' => $p['excerpt'],
		],
		[
			'place_address'       => $p['address'] ?? '',
			'place_opening_hours' => $p['hours']   ?? '',
			'place_entry_fee'     => $p['fee']      ?? '',
			'place_coordinates'   => $p['coords']   ?? '',
		],
		[ 'place_category' => $p['terms'] ]
	);
}

// =============================================================================
// 9. BUSINESSES
// =============================================================================

echo "\n=== Businesses ===\n";

$businesses = [
	// Hotels
	[
		'title'   => 'Hotel Glockenberg',
		'slug'    => 'hotel-glockenberg',
		'excerpt' => 'Hotel mit Panoramablick auf die Bergstadt – direkt am Glockenberg.',
		'content' => '<p>Das Hotel Glockenberg bietet einen herrlichen Panoramablick auf die Bergstadt Sankt Andreasberg. In ruhiger Lage am Glockenberg gelegen, ist es ideale Ausgangspunkt für Wanderungen und Skitouren.</p>',
		'phone'   => '+49 5582 219',
		'address' => 'Sankt Andreasberg',
		'type'    => [ $term_hotel ],
	],
	[
		'title'   => 'Hotel In der Sonne',
		'slug'    => 'hotel-in-der-sonne',
		'excerpt' => 'Traditionelles Bergstadthotel im Herzen von Sankt Andreasberg.',
		'content' => '<p>Das Hotel „In der Sonne" ist ein traditionelles Haus im Herzen der Bergstadt. Mit seiner langen Geschichte und gemütlichen Atmosphäre ist es ein beliebter Treffpunkt für Gäste und Einheimische.</p>',
		'phone'   => '+49 5582 91800',
		'address' => 'Sankt Andreasberg',
		'type'    => [ $term_hotel ],
	],
	[
		'title'   => 'Hotel Rehberg',
		'slug'    => 'hotel-rehberg',
		'excerpt' => 'Hotel am Rehberg mit direktem Zugang zu Wanderwegen.',
		'content' => '<p>Das Hotel Rehberg liegt in ruhiger Lage mit direktem Zugang zu den Wanderwegen am Rehberg. Das Haus bietet komfortable Zimmer und ist idealer Ausgangspunkt für Aktivurlaub im Harz.</p>',
		'phone'   => '+49 5582 1009',
		'address' => 'Sankt Andreasberg',
		'type'    => [ $term_hotel ],
	],
	[
		'title'   => 'Hotel Skandinavia',
		'slug'    => 'hotel-skandinavia',
		'excerpt' => 'Modernes Hotel in Sankt Andreasberg mit gemütlicher Atmosphäre.',
		'content' => '<p>Das Hotel Skandinavia bietet moderne Zimmer und ein freundliches Team. Das Haus ist ideal für Familien und Wanderer und verfügt über einen angenehmen Aufenthaltsbereich.</p>',
		'phone'   => '+49 5582 644',
		'address' => 'Sankt Andreasberg',
		'type'    => [ $term_hotel ],
	],
	// Gastronomie
	[
		'title'   => 'Kurhaus Café-Restaurant',
		'slug'    => 'kurhaus-cafe-restaurant',
		'excerpt' => 'Das Restaurant im Kurpark – Treffpunkt am Herzen der Stadt.',
		'content' => '<p>Das Kurhaus Café-Restaurant liegt direkt am Kurpark im Zentrum von Sankt Andreasberg. Das Haus bietet regionale Küche und ist beliebter Treffpunkt für Gäste und Einheimische. Die Bücherei im Kurhaus befindet sich ebenfalls hier.</p>',
		'phone'   => '+49 5582 1356',
		'address' => 'Am Kurpark 9, 37444 Sankt Andreasberg',
		'type'    => [ $term_restaurant ],
	],
	[
		'title'   => 'Speise-Restaurant Fischer',
		'slug'    => 'restaurant-fischer',
		'excerpt' => 'Traditionelles Restaurant mit regionaler Harzer Küche.',
		'content' => '<p>Das Speise-Restaurant Fischer ist für seine traditionelle regionale Harzer Küche bekannt. Frische Zutaten und herzliche Gastfreundschaft machen es zu einem echten Geheimtipp.</p>',
		'phone'   => '+49 5582 739',
		'address' => 'Sankt Andreasberg',
		'type'    => [ $term_restaurant ],
	],
	[
		'title'   => 'Maarten\'s Restaurant',
		'slug'    => 'maartens-restaurant',
		'excerpt' => 'Internationales Restaurant in Sankt Andreasberg.',
		'content' => '<p>Maarten\'s Restaurant bietet eine abwechslungsreiche internationale Küche. Das Restaurant ist bekannt für seine kreative Speisekarte und angenehme Atmosphäre.</p>',
		'phone'   => '+49 5582 7904430',
		'address' => 'Sankt Andreasberg',
		'type'    => [ $term_restaurant ],
	],
	[
		'title'   => 'Pizzeria La Capri',
		'slug'    => 'pizzeria-la-capri',
		'excerpt' => 'Pizzeria mit mediterranem Flair in der Bergstadt.',
		'content' => '<p>Die Pizzeria La Capri bringt mediterranes Flair in die Bergstadt. Mit frisch zubereiteten Pizzen und weiteren italienischen Gerichten ist sie bei Einheimischen und Urlaubern beliebt.</p>',
		'phone'   => '+49 5582 1672',
		'address' => 'Sankt Andreasberg',
		'type'    => [ $term_restaurant ],
	],
	[
		'title'   => 'Café Kunze',
		'slug'    => 'cafe-kunze',
		'excerpt' => 'Gemütliches Café für Kaffeepause und Kuchen.',
		'content' => '<p>Das Café Kunze lädt zu einer gemütlichen Kaffeepause mit selbst gebackenem Kuchen ein. Ein Treffpunkt für Einheimische und Urlaubsgäste in der Bergstadt.</p>',
		'phone'   => '+49 5582 211',
		'address' => 'Sankt Andreasberg',
		'type'    => [ $term_restaurant ],
	],
	[
		'title'   => 'Schützenbaude',
		'slug'    => 'schuetzenbaude',
		'excerpt' => 'Traditionelle Schützenbaude – beliebte Einkehr nach der Wanderung.',
		'content' => '<p>Die Schützenbaude ist eine traditionelle Gaststätte und beliebter Treffpunkt nach der Wanderung. Regionale Speisen und Getränke werden in gemütlicher Atmosphäre serviert.</p>',
		'phone'   => '+49 5582 999728',
		'address' => 'Sankt Andreasberg',
		'type'    => [ $term_restaurant ],
	],
	[
		'title'   => 'Bistro Alanya',
		'slug'    => 'bistro-alanya',
		'excerpt' => 'Türkisches Bistro mit Döner und mediterranen Gerichten.',
		'content' => '<p>Das Bistro Alanya bietet türkische Küche, darunter Döner und andere mediterranen Gerichte. Schneller, freundlicher Service und gute Preise.</p>',
		'phone'   => '+49 5582 999430',
		'address' => 'Sankt Andreasberg',
		'type'    => [ $term_restaurant ],
	],
	[
		'title'   => 'Café Roter Bär',
		'slug'    => 'cafe-roter-baer',
		'excerpt' => 'Café am Roten Bär – nahe dem historischen Bergwerk.',
		'content' => '<p>Das Café Roter Bär liegt in unmittelbarer Nähe der historischen Grube Roter Bär. Ein schöner Ort für eine Pause nach dem Besuch der Bergwerksanlage.</p>',
		'phone'   => '+49 5582 8216',
		'address' => 'Dr.-Willi-Bergmann-Straße 28, 37444 Sankt Andreasberg',
		'type'    => [ $term_restaurant ],
	],
	// Service
	[
		'title'   => 'Bergsport Arena GmbH',
		'slug'    => 'bergsport-arena',
		'excerpt' => 'Das Naturerlebnis im Harz – Skiverleih, Skischule, Hochseilgarten und mehr.',
		'content' => '<p>Die Bergsport Arena GmbH ist der führende Anbieter für Outdoor-Aktivitäten in Sankt Andreasberg. Das Angebot umfasst Skiverleih, Skischule, Skiservice, Hochseilgarten, Sommerrodelbahn und Touren-Guides.</p><p>Im Winter steht der Betrieb der Skilifte und Loipen im Vordergrund, im Sommer lockt der größte Hochseilgarten im Harz.</p>',
		'phone'   => '+49 5582 8154',
		'email'   => 'info@bergsport-arena.de',
		'address' => 'Hinterstraße 3, 37444 Sankt Andreasberg',
		'hours'   => 'Sommer: täglich 9–18 Uhr | Winter: täglich 8–17 Uhr',
		'type'    => [ $term_service ],
	],
	[
		'title'   => 'Alberti-Lift GmbH',
		'slug'    => 'alberti-lift',
		'excerpt' => 'Skiliftbetrieb am Matthias-Schmidt-Berg.',
		'content' => '<p>Der Alberti-Lift betreibt die Skilifte am Matthias-Schmidt-Berg. Im Winter können hier Anfänger und geübte Skifahrer die Hänge rund um Sankt Andreasberg genießen.</p>',
		'phone'   => '+49 5582 265',
		'address' => 'Matthias-Schmidt-Berg 4, 37444 Sankt Andreasberg',
		'type'    => [ $term_service ],
	],
	[
		'title'   => 'Sparkasse Goslar/Harz',
		'slug'    => 'sparkasse-goslar-harz',
		'excerpt' => 'Zweigstelle der Sparkasse Goslar/Harz mit ec-Karten-Automat.',
		'content' => '<p>Die Zweigstelle der Sparkasse Goslar/Harz in Sankt Andreasberg bietet alle wichtigen Bankdienstleistungen und einen ec-Karten-Automaten.</p>',
		'phone'   => '+49 5582 91710',
		'address' => 'Dr.-Willi-Bergmann-Straße 33, 37444 Sankt Andreasberg',
		'hours'   => 'Mo–Fr nach Geschäftszeiten',
		'type'    => [ $term_bank ],
	],
];

foreach ( $businesses as $b ) {
	sab_insert_post(
		[
			'post_type'    => 'business',
			'post_title'   => $b['title'],
			'post_name'    => $b['slug'],
			'post_content' => $b['content'],
			'post_excerpt' => $b['excerpt'],
		],
		[
			'business_phone'         => $b['phone']   ?? '',
			'business_email'         => $b['email']   ?? '',
			'business_address'       => $b['address'] ?? '',
			'business_opening_hours' => $b['hours']   ?? '',
		],
		[ 'business_type' => $b['type'] ]
	);
}

// =============================================================================
// 10. WORDPRESS NAVIGATION MENU
// =============================================================================

echo "\n=== Navigation Menus ===\n";

function sab_ensure_menu( string $name, string $location ): int {
	$menu_obj = wp_get_nav_menu_object( $name );
	if ( ! $menu_obj ) {
		$id = wp_create_nav_menu( $name );
		if ( is_wp_error( $id ) ) {
			echo "ERROR creating menu '$name': " . $id->get_error_message() . "\n";
			return 0;
		}
		echo "CREATED MENU: $name\n";
	} else {
		$id = $menu_obj->term_id;
		echo "SKIP MENU (exists): $name\n";
	}
	// Assign to location
	$locations = get_theme_mod( 'nav_menu_locations', [] );
	$locations[ $location ] = $id;
	set_theme_mod( 'nav_menu_locations', $locations );
	return $id;
}

function sab_add_menu_item( int $menu_id, string $label, string $url, int $parent = 0 ): int {
	// Check if item already exists in menu
	$items = wp_get_nav_menu_items( $menu_id );
	if ( $items ) {
		foreach ( $items as $item ) {
			if ( $item->title === $label && $item->url === $url ) {
				return $item->ID;
			}
		}
	}
	return wp_update_nav_menu_item( $menu_id, 0, [
		'menu-item-title'  => $label,
		'menu-item-url'    => $url,
		'menu-item-status' => 'publish',
		'menu-item-parent-id' => $parent,
	] );
}

$primary_id = sab_ensure_menu( 'Hauptnavigation', 'primary' );
$utility_id = sab_ensure_menu( 'Utility-Leiste', 'utility' );
$ql_id      = sab_ensure_menu( 'Footer Quicklinks', 'footer_quicklinks' );
$legal_id   = sab_ensure_menu( 'Footer Rechtliches', 'footer_legal' );

if ( $primary_id ) {
	$home_url = home_url( '/' );
	sab_add_menu_item( $primary_id, 'Startseite',                 $home_url );
	sab_add_menu_item( $primary_id, 'Aktuelles',                  home_url( '/aktuelles/' ) );
	sab_add_menu_item( $primary_id, 'Erleben',                    home_url( '/erleben/' ) );
	sab_add_menu_item( $primary_id, 'Sehenswürdigkeiten',         home_url( '/sehenswuerdigkeiten/' ) );
	sab_add_menu_item( $primary_id, 'Veranstaltungen',            home_url( '/veranstaltungen/' ) );
	sab_add_menu_item( $primary_id, 'Unterkunft & Gastronomie',   home_url( '/unterkunft-gastronomie/' ) );
	sab_add_menu_item( $primary_id, 'Leben vor Ort',              home_url( '/leben-vor-ort/' ) );
	sab_add_menu_item( $primary_id, 'Geschichte',                 home_url( '/geschichte/' ) );
	sab_add_menu_item( $primary_id, 'Kontakt',                    home_url( '/kontakt/' ) );
}

if ( $utility_id ) {
	sab_add_menu_item( $utility_id, 'Wetter',   '#wetter' );
	sab_add_menu_item( $utility_id, 'Webcams',  '#webcams' );
	sab_add_menu_item( $utility_id, 'Karte',    '#karte' );
	sab_add_menu_item( $utility_id, 'Anreise',  home_url( '/anreise/' ) );
}

if ( $ql_id ) {
	sab_add_menu_item( $ql_id, 'Startseite',           home_url( '/' ) );
	sab_add_menu_item( $ql_id, 'Aktuelles',            home_url( '/aktuelles/' ) );
	sab_add_menu_item( $ql_id, 'Veranstaltungen',      home_url( '/veranstaltungen/' ) );
	sab_add_menu_item( $ql_id, 'Sehenswürdigkeiten',   home_url( '/sehenswuerdigkeiten/' ) );
	sab_add_menu_item( $ql_id, 'Unterkunft',           home_url( '/unterkunft-gastronomie/' ) );
	sab_add_menu_item( $ql_id, 'Erleben',              home_url( '/erleben/' ) );
	sab_add_menu_item( $ql_id, 'Geschichte',           home_url( '/geschichte/' ) );
	sab_add_menu_item( $ql_id, 'Kontakt',              home_url( '/kontakt/' ) );
}

if ( $legal_id ) {
	sab_add_menu_item( $legal_id, 'Impressum',       home_url( '/impressum/' ) );
	sab_add_menu_item( $legal_id, 'Datenschutz',     home_url( '/datenschutz/' ) );
	sab_add_menu_item( $legal_id, 'Barrierefreiheit',home_url( '/barrierefreiheit/' ) );
}

echo "Menus: OK\n";

// =============================================================================
// 11. SAMPLE NEWS POSTS
// =============================================================================

echo "\n=== Sample News Posts ===\n";

// Ensure WP category 'Aktuelles' exists
$cat_aktuelles = get_term_by( 'slug', 'aktuelles', 'category' );
if ( ! $cat_aktuelles ) {
	$r = wp_insert_term( 'Aktuelles', 'category', [ 'slug' => 'aktuelles' ] );
	$cat_aktuelles_id = is_wp_error( $r ) ? 1 : $r['term_id'];
} else {
	$cat_aktuelles_id = $cat_aktuelles->term_id;
}

$cat_highlight = get_term_by( 'slug', 'top-meldung', 'category' );
if ( ! $cat_highlight ) {
	$r = wp_insert_term( 'Top-Meldung', 'category', [ 'slug' => 'top-meldung' ] );
	$cat_highlight_id = is_wp_error( $r ) ? 1 : $r['term_id'];
} else {
	$cat_highlight_id = $cat_highlight->term_id;
}

$news = [
	[
		'title'   => 'Grube Samson: Saison 2025 startet am 1. April',
		'slug'    => 'grube-samson-saison-2025',
		'excerpt' => 'Das beliebte Besucherbergwerk öffnet pünktlich zum Frühjahr seine Tore für Besucher.',
		'content' => '<p>Das Bergwerksmuseum Grube Samson startet in die neue Saison 2025. Ab dem 1. April sind täglich Führungen durch das UNESCO-Welterbe möglich. Die Grube Samson, seit 2010 UNESCO-Weltkulturerbe, bietet einzigartige Einblicke in die jahrhundertelange Bergbaugeschichte des Oberharzes.</p><p>Neu in dieser Saison: Eine erweiterte Ausstellung zur Geschichte des Harzer Bergbaus und spezielle Kinderführungen jeden Samstag.</p>',
		'cats'    => [ $cat_aktuelles_id, $cat_highlight_id ],
	],
	[
		'title'   => 'Walpurgisfeier 2025 – Traditionelles Frühlingsfest',
		'slug'    => 'walpurgis-2025',
		'excerpt' => 'Sankt Andreasberg feiert die Walpurgisnacht mit dem traditionellen Hexenumzug und Festveranstaltungen.',
		'content' => '<p>Die Walpurgisnacht ist das größte Frühlingsfest im Harz. Wie jedes Jahr lädt Sankt Andreasberg zum traditionellen Festumzug durch die Dr.-Willi-Bergmann-Straße ein. Musik, Tanz und die Vertreibung des Winters stehen im Mittelpunkt dieses jahrhundertealten Brauches.</p><p>Die Feierlichkeiten beginnen am Abend des 30. April und gehen bis tief in die Nacht. Besucher sind herzlich willkommen!</p>',
		'cats'    => [ $cat_aktuelles_id ],
	],
	[
		'title'   => 'Wanderwegenetz frisch markiert für die Sommersaison',
		'slug'    => 'wanderwegenetz-sommersaison',
		'excerpt' => 'Die Wanderwege rund um Sankt Andreasberg sind neu markiert und für die Sommersaison vorbereitet.',
		'content' => '<p>Pünktlich zur Sommersaison wurden alle Wanderwege rund um Sankt Andreasberg kontrolliert und neu markiert. Das ca. 200 km umfassende Wegenetz bietet für jeden Wandertyp die passende Tour – von der leichten Familienrunde bis zur anspruchsvollen Tagestour.</p><p>Neu in diesem Jahr: Der Bergbaulehrpfad rund um den Beerberg wurde um zwei Informationstafeln zur Geschichte des Oberharzer Wasserwirtschaft ergänzt.</p>',
		'cats'    => [ $cat_aktuelles_id ],
	],
	[
		'title'   => 'Harzfest 2025 – Das Sommerfest der Bergstadt',
		'slug'    => 'harzfest-2025',
		'excerpt' => 'Das traditionelle Harzfest lädt wieder zum großen Festumzug und Bühnenprogramm ein.',
		'content' => '<p>Das Harzfest ist ein Höhepunkt des Sommers in Sankt Andreasberg. Der große Festumzug durch die Dr.-Willi-Bergmann-Straße mit Musikkapellen, Vereinen und historischen Kostümen ist bei Jung und Alt beliebt.</p><p>Neben dem Umzug gibt es ein umfangreiches Bühnenprogramm, Fahrgeschäfte für die Kleinen und regionale Spezialitäten. Eintritt frei!</p>',
		'cats'    => [ $cat_aktuelles_id, $cat_highlight_id ],
	],
];

foreach ( $news as $n ) {
	sab_insert_post(
		[
			'post_type'     => 'post',
			'post_title'    => $n['title'],
			'post_name'     => $n['slug'],
			'post_content'  => $n['content'],
			'post_excerpt'  => $n['excerpt'],
			'post_category' => $n['cats'],
		]
	);
}

echo "\n=== Import complete! ===\n";
echo "Run 'Settings > Permalinks > Save Changes' to flush rewrite rules.\n";
