<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', 'sab_register_taxonomies' );

function sab_register_taxonomies(): void {

	/* ── Veranstaltungskategorien ──────────────────────────── */
	register_taxonomy( 'event_category', 'event', [
		'labels'            => [
			'name'              => __( 'Veranstaltungskategorien', 'wp-sanktandreasberg' ),
			'singular_name'     => __( 'Veranstaltungskategorie', 'wp-sanktandreasberg' ),
			'search_items'      => __( 'Kategorien suchen', 'wp-sanktandreasberg' ),
			'all_items'         => __( 'Alle Kategorien', 'wp-sanktandreasberg' ),
			'parent_item'       => __( 'Übergeordnete Kategorie', 'wp-sanktandreasberg' ),
			'edit_item'         => __( 'Kategorie bearbeiten', 'wp-sanktandreasberg' ),
			'update_item'       => __( 'Kategorie aktualisieren', 'wp-sanktandreasberg' ),
			'add_new_item'      => __( 'Neue Kategorie hinzufügen', 'wp-sanktandreasberg' ),
			'not_found'         => __( 'Keine Kategorien gefunden.', 'wp-sanktandreasberg' ),
		],
		'hierarchical'      => true,
		'public'            => true,
		'rewrite'           => [ 'slug' => 'veranstaltungskategorien' ],
		'show_admin_column' => true,
		'show_in_rest'      => true,
	] );

	/* ── Sehenswürdigkeiten-Kategorien ─────────────────────── */
	register_taxonomy( 'place_category', 'place', [
		'labels'            => [
			'name'          => __( 'Kategorien', 'wp-sanktandreasberg' ),
			'singular_name' => __( 'Kategorie', 'wp-sanktandreasberg' ),
			'all_items'     => __( 'Alle Kategorien', 'wp-sanktandreasberg' ),
			'add_new_item'  => __( 'Neue Kategorie', 'wp-sanktandreasberg' ),
		],
		'hierarchical'      => true,
		'public'            => true,
		'rewrite'           => [ 'slug' => 'sehenswuerdigkeiten-kategorien' ],
		'show_admin_column' => true,
		'show_in_rest'      => true,
	] );

	/* ── Aktivitäten-Typen ─────────────────────────────────── */
	register_taxonomy( 'activity_type', [ 'route', 'place' ], [
		'labels'            => [
			'name'          => __( 'Aktivitätstypen', 'wp-sanktandreasberg' ),
			'singular_name' => __( 'Aktivitätstyp', 'wp-sanktandreasberg' ),
			'all_items'     => __( 'Alle Aktivitätstypen', 'wp-sanktandreasberg' ),
			'add_new_item'  => __( 'Neuer Aktivitätstyp', 'wp-sanktandreasberg' ),
		],
		'hierarchical'      => true,
		'public'            => true,
		'rewrite'           => [ 'slug' => 'aktivitaeten' ],
		'show_admin_column' => true,
		'show_in_rest'      => true,
	] );

	/* ── Anbieter-Typen ────────────────────────────────────── */
	register_taxonomy( 'business_type', 'business', [
		'labels'            => [
			'name'          => __( 'Anbietertypen', 'wp-sanktandreasberg' ),
			'singular_name' => __( 'Anbietertyp', 'wp-sanktandreasberg' ),
			'all_items'     => __( 'Alle Anbietertypen', 'wp-sanktandreasberg' ),
			'add_new_item'  => __( 'Neuer Anbietertyp', 'wp-sanktandreasberg' ),
		],
		'hierarchical'      => true,
		'public'            => true,
		'rewrite'           => [ 'slug' => 'anbieter-typ' ],
		'show_admin_column' => true,
		'show_in_rest'      => true,
	] );
}

/**
 * Create default business type terms on theme activation.
 */
function sab_insert_default_terms(): void {
	$terms = [ 'Hotels', 'Ferienwohnungen', 'Restaurants', 'Cafés', 'Service' ];
	foreach ( $terms as $term ) {
		if ( ! term_exists( $term, 'business_type' ) ) {
			wp_insert_term( $term, 'business_type' );
		}
	}
}
add_action( 'after_switch_theme', 'sab_insert_default_terms' );
