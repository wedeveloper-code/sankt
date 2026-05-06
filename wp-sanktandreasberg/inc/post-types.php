<?php
defined( 'ABSPATH' ) || exit;

add_action( 'init', 'sab_register_post_types' );

function sab_register_post_types(): void {

	/* ── Veranstaltungen (Events) ──────────────────────────── */
	register_post_type( 'event', [
		'labels'       => [
			'name'               => __( 'Veranstaltungen (Мероприятия)', 'wp-sanktandreasberg' ),
			'singular_name'      => __( 'Veranstaltung (Мероприятие)', 'wp-sanktandreasberg' ),
			'menu_name'          => __( 'Veranstaltungen', 'wp-sanktandreasberg' ),
			'add_new'            => __( 'Neue Veranstaltung (Добавить)', 'wp-sanktandreasberg' ),
			'add_new_item'       => __( 'Neue Veranstaltung hinzufügen (Добавить мероприятие)', 'wp-sanktandreasberg' ),
			'edit_item'          => __( 'Veranstaltung bearbeiten (Редактировать мероприятие)', 'wp-sanktandreasberg' ),
			'all_items'          => __( 'Alle Veranstaltungen (Все мероприятия)', 'wp-sanktandreasberg' ),
			'search_items'       => __( 'Veranstaltungen suchen (Поиск)', 'wp-sanktandreasberg' ),
			'not_found'          => __( 'Keine Veranstaltungen gefunden. (Ничего не найдено)', 'wp-sanktandreasberg' ),
			'not_found_in_trash' => __( 'Keine Veranstaltungen im Papierkorb. (Корзина пуста)', 'wp-sanktandreasberg' ),
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
			'name'               => __( 'Sehenswürdigkeiten (Достопримечательности)', 'wp-sanktandreasberg' ),
			'singular_name'      => __( 'Sehenswürdigkeit (Достопримечательность)', 'wp-sanktandreasberg' ),
			'menu_name'          => __( 'Sehenswürdigkeiten', 'wp-sanktandreasberg' ),
			'add_new'            => __( 'Neue Sehenswürdigkeit (Добавить)', 'wp-sanktandreasberg' ),
			'add_new_item'       => __( 'Neue Sehenswürdigkeit hinzufügen (Добавить достопримечательность)', 'wp-sanktandreasberg' ),
			'edit_item'          => __( 'Sehenswürdigkeit bearbeiten (Редактировать)', 'wp-sanktandreasberg' ),
			'all_items'          => __( 'Alle Sehenswürdigkeiten (Все достопримечательности)', 'wp-sanktandreasberg' ),
			'not_found'          => __( 'Keine Sehenswürdigkeiten gefunden. (Ничего не найдено)', 'wp-sanktandreasberg' ),
			'not_found_in_trash' => __( 'Keine Sehenswürdigkeiten im Papierkorb. (Корзина пуста)', 'wp-sanktandreasberg' ),
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
			'name'               => __( 'Routen (Маршруты)', 'wp-sanktandreasberg' ),
			'singular_name'      => __( 'Route (Маршрут)', 'wp-sanktandreasberg' ),
			'menu_name'          => __( 'Routen', 'wp-sanktandreasberg' ),
			'add_new'            => __( 'Neue Route (Добавить)', 'wp-sanktandreasberg' ),
			'add_new_item'       => __( 'Neue Route hinzufügen (Добавить маршрут)', 'wp-sanktandreasberg' ),
			'edit_item'          => __( 'Route bearbeiten (Редактировать маршрут)', 'wp-sanktandreasberg' ),
			'all_items'          => __( 'Alle Routen (Все маршруты)', 'wp-sanktandreasberg' ),
			'not_found'          => __( 'Keine Routen gefunden. (Ничего не найдено)', 'wp-sanktandreasberg' ),
			'not_found_in_trash' => __( 'Keine Routen im Papierkorb. (Корзина пуста)', 'wp-sanktandreasberg' ),
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
			'name'               => __( 'Unterkunft & Gastronomie (Размещение и рестораны)', 'wp-sanktandreasberg' ),
			'singular_name'      => __( 'Anbieter (Заведение)', 'wp-sanktandreasberg' ),
			'menu_name'          => __( 'Unterkunft & Gastronomie', 'wp-sanktandreasberg' ),
			'add_new'            => __( 'Neuer Anbieter (Добавить)', 'wp-sanktandreasberg' ),
			'add_new_item'       => __( 'Neuen Anbieter hinzufügen (Добавить заведение)', 'wp-sanktandreasberg' ),
			'edit_item'          => __( 'Anbieter bearbeiten (Редактировать заведение)', 'wp-sanktandreasberg' ),
			'all_items'          => __( 'Alle Anbieter (Все заведения)', 'wp-sanktandreasberg' ),
			'not_found'          => __( 'Keine Anbieter gefunden. (Ничего не найдено)', 'wp-sanktandreasberg' ),
			'not_found_in_trash' => __( 'Keine Anbieter im Papierkorb. (Корзина пуста)', 'wp-sanktandreasberg' ),
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
