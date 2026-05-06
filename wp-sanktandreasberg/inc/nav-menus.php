<?php
defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'sab_register_nav_menus' );

function sab_register_nav_menus(): void {
	register_nav_menus( [
		'primary'          => __( 'Hauptnavigation', 'wp-sanktandreasberg' ),
		'utility'          => __( 'Utility-Leiste (oben)', 'wp-sanktandreasberg' ),
		'footer_quicklinks' => __( 'Footer: Quicklinks', 'wp-sanktandreasberg' ),
		'footer_legal'     => __( 'Footer: Rechtliches', 'wp-sanktandreasberg' ),
	] );
}
