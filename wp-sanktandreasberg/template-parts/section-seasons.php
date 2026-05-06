<?php
$winter_url = get_theme_mod( 'sab_season_winter_url', home_url( '/winter-sommer/' ) . '#winter' );
$summer_url = get_theme_mod( 'sab_season_summer_url', home_url( '/winter-sommer/' ) . '#sommer' );
?>
<section id="season" class="section cream">
	<div class="wrap season-grid">
		<article class="season season-winter">
			<div>
				<h2><?php esc_html_e( 'Winter erleben', 'wp-sanktandreasberg' ); ?></h2>
				<div class="season-items">
					<span class="season-item"><i>⛷</i><?php esc_html_e( 'Ski Alpin', 'wp-sanktandreasberg' ); ?><br><small><?php esc_html_e( 'am Matthias-Schmidt-Berg', 'wp-sanktandreasberg' ); ?></small></span>
					<span class="season-item"><i>↟</i><?php esc_html_e( 'Langlauf', 'wp-sanktandreasberg' ); ?><br><small><?php esc_html_e( '40 km Loipen', 'wp-sanktandreasberg' ); ?></small></span>
					<span class="season-item"><i>◌</i><?php esc_html_e( 'Rodeln', 'wp-sanktandreasberg' ); ?><br><small><?php esc_html_e( 'Spaß für Groß & Klein', 'wp-sanktandreasberg' ); ?></small></span>
					<span class="season-item"><i>❄</i><?php esc_html_e( 'Winterwandern', 'wp-sanktandreasberg' ); ?><br><small><?php esc_html_e( 'Wandern im Schnee', 'wp-sanktandreasberg' ); ?></small></span>
				</div>
			</div>
			<a class="btn btn-white" href="<?php echo esc_url( $winter_url ); ?>"><?php esc_html_e( 'Mehr Winter-Infos', 'wp-sanktandreasberg' ); ?> ›</a>
		</article>
		<article class="season season-summer">
			<div>
				<h2><?php esc_html_e( 'Sommer erleben', 'wp-sanktandreasberg' ); ?></h2>
				<div class="season-items">
					<span class="season-item"><i>↟</i><?php esc_html_e( 'Wandern', 'wp-sanktandreasberg' ); ?><br><small><?php esc_html_e( '200 km Wanderwege', 'wp-sanktandreasberg' ); ?></small></span>
					<span class="season-item"><i>🚲</i><?php esc_html_e( 'Mountainbike', 'wp-sanktandreasberg' ); ?><br><small><?php esc_html_e( 'Trails & Touren', 'wp-sanktandreasberg' ); ?></small></span>
					<span class="season-item"><i>☘</i><?php esc_html_e( 'Nordic Walking', 'wp-sanktandreasberg' ); ?><br><small><?php esc_html_e( 'Gesund & aktiv', 'wp-sanktandreasberg' ); ?></small></span>
					<span class="season-item"><i>⚡</i><?php esc_html_e( 'Action & Abenteuer', 'wp-sanktandreasberg' ); ?><br><small><?php esc_html_e( 'Erlebnis pur', 'wp-sanktandreasberg' ); ?></small></span>
				</div>
			</div>
			<a class="btn btn-white" href="<?php echo esc_url( $summer_url ); ?>"><?php esc_html_e( 'Mehr Sommer-Infos', 'wp-sanktandreasberg' ); ?> ›</a>
		</article>
	</div>
</section>
