<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'sab_register_nav_menus' );

function sab_register_nav_menus(): void {
	register_nav_menus( [
		'primary'           => __( 'Hauptnavigation', 'wp-sanktandreasberg' ),
		'utility'           => __( 'Utility-Leiste (oben)', 'wp-sanktandreasberg' ),
		'footer_quicklinks' => __( 'Footer: Quicklinks', 'wp-sanktandreasberg' ),
		'footer_legal'      => __( 'Footer: Rechtliches', 'wp-sanktandreasberg' ),
	] );
}

/**
 * Add aria-label to the primary nav container (WP 6.3+ via filter).
 * For older WP the fallback nav in header.php already has aria-label.
 */
add_filter( 'nav_menu_container_attributes', function ( array $atts, object $args ): array {
	if ( isset( $args->theme_location ) && 'primary' === $args->theme_location ) {
		$atts['aria-label'] = __( 'Hauptnavigation', 'wp-sanktandreasberg' );
	}
	return $atts;
}, 10, 2 );
