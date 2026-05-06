<?php
defined( 'ABSPATH' ) || exit;

/* ── Preconnect for Google Fonts (performance) ─────────────── */
add_action( 'wp_head', function (): void {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1 );

/* ── Inline critical CSS ────────────────────────────────────── */
add_action( 'wp_head', function (): void {
	$file = get_template_directory() . '/assets/css/critical.css';
	if ( file_exists( $file ) ) {
		echo '<style id="sab-critical">' . file_get_contents( $file ) . '</style>' . "\n"; // phpcs:ignore
	}
}, 2 );

/* ── Non-blocking Google Fonts ──────────────────────────────── */
add_action( 'wp_head', function (): void {
	$fonts = 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap';
	echo '<link rel="preload" as="style" href="' . esc_url( $fonts ) . '" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n";
	echo '<noscript><link rel="stylesheet" href="' . esc_url( $fonts ) . '"></noscript>' . "\n";
}, 3 );

/* ── Enqueue theme assets ────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', 'sab_enqueue_assets' );

function sab_enqueue_assets(): void {
	$ver = wp_get_theme()->get( 'Version' );

	wp_enqueue_style(
		'sab-main',
		get_template_directory_uri() . '/assets/css/style.css',
		[],
		$ver
	);

	wp_enqueue_script(
		'sab-main',
		get_template_directory_uri() . '/assets/js/main.js',
		[],
		$ver,
		true
	);
}

/* ── Editor styles ───────────────────────────────────────────── */
add_action( 'after_setup_theme', function (): void {
	add_editor_style( 'assets/css/editor-style.css' );
} );

/* ── Lazy-load filter (ensure loading=lazy on attachment images) */
add_filter( 'wp_get_attachment_image_attributes', function ( array $attr ): array {
	if ( ! isset( $attr['loading'] ) ) {
		$attr['loading'] = 'lazy';
	}
	return $attr;
} );
