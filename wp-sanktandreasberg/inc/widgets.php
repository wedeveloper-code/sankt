<?php
defined( 'ABSPATH' ) || exit;

add_action( 'widgets_init', 'sab_register_sidebars' );

function sab_register_sidebars(): void {
	$defaults = [
		'before_widget' => '<section id="%1$s" class="card side-card %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h3 class="side-title">',
		'after_title'   => '</h3>',
	];

	register_sidebar( $defaults + [
		'name' => __( 'News Sidebar', 'wp-sanktandreasberg' ),
		'id'   => 'sidebar-news',
		'description' => __( 'Widgets erscheinen in der Seitenleiste von News-Seiten.', 'wp-sanktandreasberg' ),
	] );

	register_sidebar( $defaults + [
		'name' => __( 'Veranstaltungen Sidebar', 'wp-sanktandreasberg' ),
		'id'   => 'sidebar-events',
		'description' => __( 'Widgets erscheinen in der Seitenleiste von Veranstaltungsseiten.', 'wp-sanktandreasberg' ),
	] );

	register_sidebar( $defaults + [
		'name' => __( 'Sehenswürdigkeiten Sidebar', 'wp-sanktandreasberg' ),
		'id'   => 'sidebar-places',
		'description' => __( 'Widgets erscheinen in der Seitenleiste von Sehenswürdigkeitsseiten.', 'wp-sanktandreasberg' ),
	] );

	register_sidebar( $defaults + [
		'name' => __( 'Verzeichnis Sidebar', 'wp-sanktandreasberg' ),
		'id'   => 'sidebar-directory',
		'description' => __( 'Widgets erscheinen in der Seitenleiste des Unterkunft- und Gastronomie-Verzeichnisses.', 'wp-sanktandreasberg' ),
	] );
}
