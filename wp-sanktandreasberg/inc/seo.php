<?php
defined( 'ABSPATH' ) || exit;

/* ── Open Graph + Twitter Card + Canonical ──────────────────── */
add_action( 'wp_head', 'sab_output_meta_seo', 5 );

function sab_output_meta_seo(): void {
	$title       = wp_title( ' | ', false ) . get_bloginfo( 'name' );
	$description = get_bloginfo( 'description' );
	$url         = get_permalink() ?: home_url( '/' );
	$image       = '';
	$type        = 'website';

	if ( is_singular() ) {
		$type        = 'article';
		$description = wp_strip_all_tags( get_the_excerpt() ) ?: $description;
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( null, 'sab-featured' );
		}
	}

	if ( is_front_page() ) {
		$title       = get_bloginfo( 'name' ) . ' – ' . get_bloginfo( 'description' );
		$description = get_bloginfo( 'description' );
		$url         = home_url( '/' );
		$type        = 'website';
	}

	$out = [];
	$out[] = '<meta name="description" content="' . esc_attr( $description ) . '">';
	$out[] = '<link rel="canonical" href="' . esc_url( $url ) . '">';
	$out[] = '<meta property="og:type"  content="' . esc_attr( $type ) . '">';
	$out[] = '<meta property="og:title" content="' . esc_attr( $title ) . '">';
	$out[] = '<meta property="og:description" content="' . esc_attr( $description ) . '">';
	$out[] = '<meta property="og:url"  content="' . esc_url( $url ) . '">';
	$out[] = '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
	if ( $image ) {
		$out[] = '<meta property="og:image" content="' . esc_url( $image ) . '">';
	}
	$out[] = '<meta name="twitter:card"  content="summary_large_image">';
	$out[] = '<meta name="twitter:title" content="' . esc_attr( $title ) . '">';
	$out[] = '<meta name="twitter:description" content="' . esc_attr( $description ) . '">';
	if ( $image ) {
		$out[] = '<meta name="twitter:image" content="' . esc_url( $image ) . '">';
	}

	echo implode( "\n", $out ) . "\n";
}

/* ── JSON-LD structured data ─────────────────────────────────── */
add_action( 'wp_head', 'sab_output_json_ld', 6 );

function sab_output_json_ld(): void {
	if ( is_front_page() ) {
		sab_json_ld( [
			'@context'    => 'https://schema.org',
			'@type'       => 'TouristDestination',
			'name'        => 'Sankt Andreasberg',
			'url'         => home_url( '/' ),
			'description' => get_bloginfo( 'description' ),
			'address'     => [
				'@type'            => 'PostalAddress',
				'addressLocality'  => 'Sankt Andreasberg',
				'addressRegion'    => 'Niedersachsen',
				'postalCode'       => '37444',
				'addressCountry'   => 'DE',
			],
			'geo'         => [
				'@type'     => 'GeoCoordinates',
				'latitude'  => 51.6547,
				'longitude' => 10.5269,
			],
			'keywords'    => 'Wandern, Wintersport, Familien, Kultur, Harz, Nationalpark',
		] );
		return;
	}

	if ( is_singular( 'event' ) ) {
		$id    = get_the_ID();
		$start = sab_meta( 'event_date_start', $id );
		sab_json_ld( array_filter( [
			'@context'  => 'https://schema.org',
			'@type'     => 'Event',
			'name'      => get_the_title(),
			'startDate' => $start,
			'endDate'   => sab_meta( 'event_date_end', $id ) ?: $start,
			'description' => wp_strip_all_tags( get_the_excerpt() ),
			'location'  => [
				'@type'   => 'Place',
				'name'    => sab_meta( 'event_location', $id, 'Sankt Andreasberg' ),
				'address' => [
					'@type'           => 'PostalAddress',
					'addressLocality' => 'Sankt Andreasberg',
					'addressCountry'  => 'DE',
				],
			],
			'offers' => array_filter( [
				'@type' => 'Offer',
				'price' => sab_meta( 'event_price', $id ),
				'url'   => sab_meta( 'event_registration_url', $id ) ?: get_permalink(),
				'priceCurrency' => 'EUR',
			] ),
			'url'       => get_permalink(),
			'image'     => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'sab-featured' ) : null,
			'organizer' => sab_meta( 'event_organizer', $id ) ? [
				'@type' => 'Organization',
				'name'  => sab_meta( 'event_organizer', $id ),
			] : null,
		] ) );
		return;
	}

	if ( is_singular( 'place' ) ) {
		$id     = get_the_ID();
		$coords = explode( ',', sab_meta( 'place_coordinates', $id ) );
		sab_json_ld( array_filter( [
			'@context'    => 'https://schema.org',
			'@type'       => 'TouristAttraction',
			'name'        => get_the_title(),
			'description' => wp_strip_all_tags( get_the_excerpt() ),
			'url'         => get_permalink(),
			'image'       => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'sab-featured' ) : null,
			'address'     => [
				'@type'           => 'PostalAddress',
				'streetAddress'   => sab_meta( 'place_address', $id ),
				'addressLocality' => 'Sankt Andreasberg',
				'addressCountry'  => 'DE',
			],
			'openingHours' => sab_meta( 'place_opening_hours', $id ) ?: null,
			'geo'         => count( $coords ) === 2 ? [
				'@type'     => 'GeoCoordinates',
				'latitude'  => (float) trim( $coords[0] ),
				'longitude' => (float) trim( $coords[1] ),
			] : null,
		] ) );
		return;
	}

	if ( is_singular( 'business' ) ) {
		$id = get_the_ID();
		sab_json_ld( array_filter( [
			'@context'     => 'https://schema.org',
			'@type'        => 'LocalBusiness',
			'name'         => get_the_title(),
			'description'  => wp_strip_all_tags( get_the_excerpt() ),
			'url'          => sab_meta( 'business_website', $id ) ?: get_permalink(),
			'telephone'    => sab_meta( 'business_phone', $id ) ?: null,
			'email'        => sab_meta( 'business_email', $id ) ?: null,
			'image'        => has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'sab-featured' ) : null,
			'address'      => [
				'@type'           => 'PostalAddress',
				'streetAddress'   => sab_meta( 'business_address', $id ),
				'addressLocality' => 'Sankt Andreasberg',
				'addressCountry'  => 'DE',
			],
			'openingHours' => sab_meta( 'business_opening_hours', $id ) ?: null,
		] ) );
	}
}
