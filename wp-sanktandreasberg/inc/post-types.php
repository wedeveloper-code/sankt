<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', 'sab_register_post_types' );

function sab_register_post_types(): void {

	/* ── Veranstaltungen (Events) ──────────────────────────── */
	register_post_type( 'event', [
		'labels'       => [
			'name'               => __( 'Veranstaltungen', 'wp-sanktandreasberg' ),
			'singular_name'      => __( 'Veranstaltung', 'wp-sanktandreasberg' ),
			'add_new'            => __( 'Neue Veranstaltung', 'wp-sanktandreasberg' ),
			'add_new_item'       => __( 'Neue Veranstaltung hinzufügen', 'wp-sanktandreasberg' ),
			'edit_item'          => __( 'Veranstaltung bearbeiten', 'wp-sanktandreasberg' ),
			'all_items'          => __( 'Alle Veranstaltungen', 'wp-sanktandreasberg' ),
			'search_items'       => __( 'Veranstaltungen suchen', 'wp-sanktandreasberg' ),
			'not_found'          => __( 'Keine Veranstaltungen gefunden.', 'wp-sanktandreasberg' ),
			'not_found_in_trash' => __( 'Keine Veranstaltungen im Papierkorb.', 'wp-sanktandreasberg' ),
		],
		'public'        => true,
		'has_archive'   => 'veranstaltungen',
		'rewrite'       => [ 'slug' => 'veranstaltung', 'with_front' => false ],
		'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
		'menu_icon'     => 'dashicons-calendar-alt',
		'menu_position' => 5,
		'show_in_rest'  => true,
	] );

	/* ── Sehenswürdigkeiten (Places) ───────────────────────── */
	register_post_type( 'place', [
		'labels'       => [
			'name'               => __( 'Sehenswürdigkeiten', 'wp-sanktandreasberg' ),
			'singular_name'      => __( 'Sehenswürdigkeit', 'wp-sanktandreasberg' ),
			'add_new'            => __( 'Neue Sehenswürdigkeit', 'wp-sanktandreasberg' ),
			'add_new_item'       => __( 'Neue Sehenswürdigkeit hinzufügen', 'wp-sanktandreasberg' ),
			'edit_item'          => __( 'Sehenswürdigkeit bearbeiten', 'wp-sanktandreasberg' ),
			'all_items'          => __( 'Alle Sehenswürdigkeiten', 'wp-sanktandreasberg' ),
			'not_found'          => __( 'Keine Sehenswürdigkeiten gefunden.', 'wp-sanktandreasberg' ),
			'not_found_in_trash' => __( 'Keine Sehenswürdigkeiten im Papierkorb.', 'wp-sanktandreasberg' ),
		],
		'public'        => true,
		'has_archive'   => 'sehenswuerdigkeiten',
		'rewrite'       => [ 'slug' => 'sehenswuerdigkeit', 'with_front' => false ],
		'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
		'menu_icon'     => 'dashicons-location',
		'menu_position' => 6,
		'show_in_rest'  => true,
	] );

	/* ── Routen (Routes) ───────────────────────────────────── */
	register_post_type( 'route', [
		'labels'       => [
			'name'               => __( 'Routen', 'wp-sanktandreasberg' ),
			'singular_name'      => __( 'Route', 'wp-sanktandreasberg' ),
			'add_new'            => __( 'Neue Route', 'wp-sanktandreasberg' ),
			'add_new_item'       => __( 'Neue Route hinzufügen', 'wp-sanktandreasberg' ),
			'edit_item'          => __( 'Route bearbeiten', 'wp-sanktandreasberg' ),
			'all_items'          => __( 'Alle Routen', 'wp-sanktandreasberg' ),
			'not_found'          => __( 'Keine Routen gefunden.', 'wp-sanktandreasberg' ),
			'not_found_in_trash' => __( 'Keine Routen im Papierkorb.', 'wp-sanktandreasberg' ),
		],
		'public'        => true,
		'has_archive'   => 'routen',
		'rewrite'       => [ 'slug' => 'route', 'with_front' => false ],
		'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
		'menu_icon'     => 'dashicons-admin-generic',
		'menu_position' => 7,
		'show_in_rest'  => true,
	] );

	/* ── Unterkunft & Gastronomie (Businesses) ─────────────── */
	register_post_type( 'business', [
		'labels'       => [
			'name'               => __( 'Unterkunft & Gastronomie', 'wp-sanktandreasberg' ),
			'singular_name'      => __( 'Anbieter', 'wp-sanktandreasberg' ),
			'add_new'            => __( 'Neuer Anbieter', 'wp-sanktandreasberg' ),
			'add_new_item'       => __( 'Neuen Anbieter hinzufügen', 'wp-sanktandreasberg' ),
			'edit_item'          => __( 'Anbieter bearbeiten', 'wp-sanktandreasberg' ),
			'all_items'          => __( 'Alle Anbieter', 'wp-sanktandreasberg' ),
			'not_found'          => __( 'Keine Anbieter gefunden.', 'wp-sanktandreasberg' ),
			'not_found_in_trash' => __( 'Keine Anbieter im Papierkorb.', 'wp-sanktandreasberg' ),
		],
		'public'        => true,
		'has_archive'   => 'unterkunft-gastronomie',
		'rewrite'       => [ 'slug' => 'anbieter', 'with_front' => false ],
		'supports'      => [ 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ],
		'menu_icon'     => 'dashicons-store',
		'menu_position' => 8,
		'show_in_rest'  => true,
	] );
}
