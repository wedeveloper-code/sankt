<?php
defined( 'ABSPATH' ) || exit;

/* ── Theme setup ─────────────────────────────────────────────── */
add_action( 'after_setup_theme', 'sab_theme_setup' );

function sab_theme_setup(): void {
	load_theme_textdomain( 'wp-sanktandreasberg', get_template_directory() . '/languages' );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo', [
		'width'       => 276,
		'height'      => 112,
		'flex-width'  => true,
		'flex-height' => true,
	] );
	add_theme_support( 'html5', [
		'comment-list',
		'comment-form',
		'search-form',
		'gallery',
		'caption',
		'style',
		'script',
	] );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'automatic-feed-links' );

	/* Image sizes matching card dimensions in CSS */
	add_image_size( 'sab-card',     640,  420, true );
	add_image_size( 'sab-featured', 960,  540, true );
	add_image_size( 'sab-hero',    2200, 1000, true );
	add_image_size( 'sab-thumb',    320,  240, true );
	add_image_size( 'sab-square',   300,  300, true );
}

/* ── Includes ─────────────────────────────────────────────────── */
require get_template_directory() . '/inc/helpers.php';
require get_template_directory() . '/inc/post-types.php';
require get_template_directory() . '/inc/taxonomies.php';
require get_template_directory() . '/inc/nav-menus.php';
require get_template_directory() . '/inc/widgets.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/meta-boxes.php';
require get_template_directory() . '/inc/seo.php';

/* ── Skip link ───────────────────────────────────────────────── */
add_action( 'wp_body_open', function (): void {
	echo '<a class="skip-link" href="#main">' . esc_html__( 'Zum Hauptinhalt springen', 'wp-sanktandreasberg' ) . '</a>';
} );

/* ── Custom image sizes in media library ─────────────────────── */
add_filter( 'image_size_names_choose', function ( array $sizes ): array {
	return array_merge( $sizes, [
		'sab-card'     => __( 'Karte (640×420)', 'wp-sanktandreasberg' ),
		'sab-featured' => __( 'Featured (960×540)', 'wp-sanktandreasberg' ),
		'sab-hero'     => __( 'Hero (2200×1000)', 'wp-sanktandreasberg' ),
		'sab-thumb'    => __( 'Thumbnail (320×240)', 'wp-sanktandreasberg' ),
	] );
} );

/* ── Template redirect: flush rules reminder ─────────────────── */
add_action( 'after_switch_theme', function (): void {
	flush_rewrite_rules();
} );

add_action( 'switch_theme', function (): void {
	flush_rewrite_rules();
} );
