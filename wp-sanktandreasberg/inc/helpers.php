<?php
defined( 'ABSPATH' ) || exit;

/**
 * Get post meta with fallback.
 */
function sab_meta( string $key, ?int $post_id = null, string $fallback = '' ): string {
	return (string) ( get_post_meta( $post_id ?? get_the_ID(), $key, true ) ?: $fallback );
}

/**
 * Difficulty label mapping.
 */
function sab_difficulty_label( string $difficulty ): string {
	$map = [ 'easy' => 'Leicht', 'medium' => 'Mittel', 'hard' => 'Schwer' ];
	return $map[ $difficulty ] ?? esc_html( $difficulty );
}

/**
 * Difficulty CSS class.
 */
function sab_difficulty_class( string $difficulty ): string {
	$map = [ 'easy' => 'green', 'medium' => 'yellow', 'hard' => 'red' ];
	return $map[ $difficulty ] ?? '';
}

/**
 * Get post thumbnail URL with Unsplash placeholder fallback.
 */
function sab_thumbnail_url( ?int $post_id = null, string $size = 'sab-card' ): string {
	$id  = $post_id ?? get_the_ID();
	$url = get_the_post_thumbnail_url( $id, $size );
	if ( ! $url ) {
		$url = 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80';
	}
	return esc_url( $url );
}

/**
 * Format a date string in German locale.
 */
function sab_format_date( string $date, string $format = 'd. F Y' ): string {
	$ts = strtotime( $date );
	return $ts ? date_i18n( $format, $ts ) : '';
}

/**
 * Format event date range.
 */
function sab_format_date_range( string $start, string $end = '' ): string {
	if ( ! $start ) return '';
	$s = sab_format_date( $start );
	if ( $end && $end !== $start ) {
		return $s . ' – ' . sab_format_date( $end );
	}
	return $s;
}

/**
 * Output a breadcrumb trail.
 */
function sab_breadcrumb(): void {
	$items   = [];
	$items[] = '<a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Startseite', 'wp-sanktandreasberg' ) . '</a>';

	if ( is_category() ) {
		$items[] = esc_html( single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$items[] = esc_html( single_tag_title( '', false ) );
	} elseif ( is_tax() ) {
		$term    = get_queried_object();
		$items[] = esc_html( $term->name );
	} elseif ( is_post_type_archive() ) {
		$items[] = esc_html( post_type_archive_title( '', false ) );
	} elseif ( is_singular() ) {
		$post = get_queried_object();
		$type = get_post_type( $post );
		if ( 'post' === $type ) {
			$cats = get_the_category( $post->ID );
			if ( $cats ) {
				$items[] = '<a href="' . esc_url( get_category_link( $cats[0] ) ) . '">' . esc_html( $cats[0]->name ) . '</a>';
			}
		} elseif ( in_array( $type, [ 'event', 'place', 'route', 'business' ], true ) ) {
			$archive = get_post_type_archive_link( $type );
			if ( $archive ) {
				$obj     = get_post_type_object( $type );
				$items[] = '<a href="' . esc_url( $archive ) . '">' . esc_html( $obj->labels->name ) . '</a>';
			}
		}
		$items[] = esc_html( get_the_title( $post ) );
	} elseif ( is_search() ) {
		$items[] = esc_html__( 'Suchergebnisse', 'wp-sanktandreasberg' );
	} elseif ( is_404() ) {
		$items[] = esc_html__( 'Seite nicht gefunden', 'wp-sanktandreasberg' );
	} elseif ( is_page() ) {
		$post = get_queried_object();
		if ( $post->post_parent ) {
			$ancestors = array_reverse( get_post_ancestors( $post ) );
			foreach ( $ancestors as $anc_id ) {
				$items[] = '<a href="' . esc_url( get_permalink( $anc_id ) ) . '">' . esc_html( get_the_title( $anc_id ) ) . '</a>';
			}
		}
		$items[] = esc_html( get_the_title( $post ) );
	}

	if ( count( $items ) <= 1 ) return;

	echo '<nav class="breadcrumb" aria-label="' . esc_attr__( 'Brotkrümelnavigation', 'wp-sanktandreasberg' ) . '">';
	echo '<div class="wrap">';
	echo implode( ' <span aria-hidden="true">›</span> ', $items );
	echo '</div></nav>';
}

/**
 * Output JSON-LD structured data.
 *
 * @param array<string,mixed> $schema
 */
function sab_json_ld( array $schema ): void {
	echo '<script type="application/ld+json">'
		. wp_json_encode( $schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES )
		. '</script>' . "\n";
}

/**
 * Nav menu active-state filter — maps WP classes to .active.
 */
add_filter( 'nav_menu_link_attributes', function ( array $atts, \WP_Post $item ): array {
	if ( array_intersect( $item->classes, [ 'current-menu-item', 'current-menu-ancestor', 'current-menu-parent' ] ) ) {
		$atts['class'] = trim( ( $atts['class'] ?? '' ) . ' active' );
	}
	return $atts;
}, 10, 2 );

/**
 * Wrap WP nav menu <ul> in a <nav> without extra wrapper when container = false.
 * (We use container='nav' in wp_nav_menu calls, so this is a safety filter.)
 */
add_filter( 'nav_menu_css_class', function ( array $classes, \WP_Post $item ) use ( &$classes ): array {
	return array_filter( $classes, fn( $c ) => '' !== trim( $c ) );
}, 10, 2 );
