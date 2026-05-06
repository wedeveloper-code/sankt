<?php
defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', 'sab_customizer_register' );

function sab_customizer_register( \WP_Customize_Manager $wp_customize ): void {

	/* ── Panel: Sankt Andreasberg ────────────────────────── */
	$wp_customize->add_panel( 'sab_panel', [
		'title'    => __( 'Sankt Andreasberg', 'wp-sanktandreasberg' ),
		'priority' => 30,
	] );

	/* ── Section: Tourist-Information ───────────────────── */
	$wp_customize->add_section( 'sab_tourist_info', [
		'title' => __( 'Tourist-Information', 'wp-sanktandreasberg' ),
		'panel' => 'sab_panel',
	] );
	foreach ( [
		'sab_ti_phone'   => [ 'label' => __( 'Telefon', 'wp-sanktandreasberg' ), 'default' => '+49 5582 8033' ],
		'sab_ti_email'   => [ 'label' => __( 'E-Mail', 'wp-sanktandreasberg' ), 'default' => 'info@sant-andreasberg.de' ],
		'sab_ti_address' => [ 'label' => __( 'Adresse', 'wp-sanktandreasberg' ), 'default' => 'Am Kurpark 9, 37444 Sankt Andreasberg' ],
		'sab_ti_hours'   => [ 'label' => __( 'Öffnungszeiten', 'wp-sanktandreasberg' ), 'default' => 'Mo–Fr 09:00–17:00' ],
	] as $id => $args ) {
		$wp_customize->add_setting( $id, [ 'default' => $args['default'], 'sanitize_callback' => 'sanitize_text_field' ] );
		$wp_customize->add_control( $id, [ 'label' => $args['label'], 'section' => 'sab_tourist_info', 'type' => 'text' ] );
	}

	/* ── Section: Links ─────────────────────────────────── */
	$wp_customize->add_section( 'sab_links', [
		'title' => __( 'Service-Links', 'wp-sanktandreasberg' ),
		'panel' => 'sab_panel',
	] );
	foreach ( [
		'sab_weather_url'    => __( 'Wetter-URL', 'wp-sanktandreasberg' ),
		'sab_webcam_url'     => __( 'Webcam-URL', 'wp-sanktandreasberg' ),
		'sab_map_url'        => __( 'Karte-URL', 'wp-sanktandreasberg' ),
		'sab_directions_url' => __( 'Anreise-URL', 'wp-sanktandreasberg' ),
		'sab_newsletter_url' => __( 'Newsletter-URL', 'wp-sanktandreasberg' ),
	] as $id => $label ) {
		$wp_customize->add_setting( $id, [ 'default' => '#', 'sanitize_callback' => 'esc_url_raw' ] );
		$wp_customize->add_control( $id, [ 'label' => $label, 'section' => 'sab_links', 'type' => 'url' ] );
	}

	/* ── Section: Hero ───────────────────────────────────── */
	$wp_customize->add_section( 'sab_hero', [
		'title' => __( 'Startseite Hero', 'wp-sanktandreasberg' ),
		'panel' => 'sab_panel',
	] );
	$wp_customize->add_setting( 'sab_hero_image', [
		'default'           => '',
		'sanitize_callback' => 'esc_url_raw',
	] );
	$wp_customize->add_control( new \WP_Customize_Image_Control( $wp_customize, 'sab_hero_image', [
		'label'   => __( 'Hero-Hintergrundbild', 'wp-sanktandreasberg' ),
		'section' => 'sab_hero',
	] ) );

	$wp_customize->add_setting( 'sab_hero_title', [
		'default'           => 'Willkommen in Sankt Andreasberg',
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'sab_hero_title', [
		'label'   => __( 'Hero-Überschrift', 'wp-sanktandreasberg' ),
		'section' => 'sab_hero',
		'type'    => 'text',
	] );

	$wp_customize->add_setting( 'sab_hero_subtitle', [
		'default'           => 'Ihre Bergstadt im Harz – Natur, Nachrichten und Erlebnisse zu jeder Jahreszeit.',
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'sab_hero_subtitle', [
		'label'   => __( 'Hero-Unterzeile', 'wp-sanktandreasberg' ),
		'section' => 'sab_hero',
		'type'    => 'textarea',
	] );

	/* ── Section: Footer ─────────────────────────────────── */
	$wp_customize->add_section( 'sab_footer', [
		'title' => __( 'Footer', 'wp-sanktandreasberg' ),
		'panel' => 'sab_panel',
	] );
	$wp_customize->add_setting( 'sab_footer_copyright', [
		'default'           => '© ' . gmdate( 'Y' ) . ' Stadt Sankt Andreasberg',
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'sab_footer_copyright', [
		'label'   => __( 'Copyright-Text', 'wp-sanktandreasberg' ),
		'section' => 'sab_footer',
		'type'    => 'text',
	] );
}
