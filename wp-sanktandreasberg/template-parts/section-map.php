<?php
$map_url        = get_theme_mod( 'sab_map_url', '#' );
$places_url     = get_post_type_archive_link( 'place' ) ?: home_url( '/sehenswuerdigkeiten/' );
$routes_url     = get_post_type_archive_link( 'route' ) ?: home_url( '/routen/' );
$business_url   = get_post_type_archive_link( 'business' ) ?: home_url( '/unterkunft-gastronomie/' );
?>
<section id="map" class="section cream">
	<div class="wrap">
		<div class="map-card">
			<div>
				<h2 style="margin:0 0 10px;font-size:24px"><?php esc_html_e( 'Entdecken mit Karte', 'wp-sanktandreasberg' ); ?></h2>
				<div class="map-visual" aria-hidden="true">
					<span class="pin">P</span>
					<span class="pin">☕</span>
					<span class="pin">↟</span>
					<span class="pin">⌂</span>
					<span class="pin">i</span>
				</div>
			</div>
			<div class="map-tags">
				<a class="map-tag" href="<?php echo esc_url( $places_url ); ?>">⌂ <b><?php esc_html_e( 'Sehenswürdigkeiten', 'wp-sanktandreasberg' ); ?><span><?php esc_html_e( 'Historie & Kultur', 'wp-sanktandreasberg' ); ?></span></b></a>
				<a class="map-tag" href="<?php echo esc_url( $routes_url ); ?>">↟ <b><?php esc_html_e( 'Routen', 'wp-sanktandreasberg' ); ?><span><?php esc_html_e( 'Wandern, Rad, Loipen', 'wp-sanktandreasberg' ); ?></span></b></a>
				<a class="map-tag" href="<?php echo esc_url( home_url( '/parken/' ) ); ?>">Ⓟ <b><?php esc_html_e( 'Parkplätze', 'wp-sanktandreasberg' ); ?><span><?php esc_html_e( 'Öffentlich & kostenfrei', 'wp-sanktandreasberg' ); ?></span></b></a>
				<a class="map-tag" href="<?php echo esc_url( $business_url ); ?>">☕ <b><?php esc_html_e( 'Gastronomie', 'wp-sanktandreasberg' ); ?><span><?php esc_html_e( 'Essen & Trinken', 'wp-sanktandreasberg' ); ?></span></b></a>
				<a class="map-tag" href="<?php echo esc_url( $business_url ); ?>">▰ <b><?php esc_html_e( 'Unterkünfte', 'wp-sanktandreasberg' ); ?><span><?php esc_html_e( 'Hotels, Ferienwohnungen', 'wp-sanktandreasberg' ); ?></span></b></a>
				<a class="btn btn-dark" href="<?php echo esc_url( $map_url ); ?>"><?php esc_html_e( 'Karte öffnen', 'wp-sanktandreasberg' ); ?> ›</a>
			</div>
		</div>
	</div>
</section>
