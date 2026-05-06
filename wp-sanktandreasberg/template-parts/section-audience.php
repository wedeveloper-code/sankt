<?php
$anreise_url = get_theme_mod( 'sab_anreise_url', home_url( '/anreise/' ) );
$info_url    = home_url( '/leben-vor-ort/' );
?>
<section id="audience" class="section cream">
	<div class="wrap audience-grid">
		<article class="card audience">
			<div class="card-body">
				<h2><?php esc_html_e( 'Für Besucher', 'wp-sanktandreasberg' ); ?></h2>
				<ul>
					<li>⛰ <?php esc_html_e( 'Urlaub planen', 'wp-sanktandreasberg' ); ?></li>
					<li>⌖ <?php esc_html_e( 'Anreise & Mobilität', 'wp-sanktandreasberg' ); ?></li>
					<li>ⓘ <?php esc_html_e( 'Service vor Ort', 'wp-sanktandreasberg' ); ?></li>
					<li>▣ <?php esc_html_e( 'Prospekte & Downloads', 'wp-sanktandreasberg' ); ?></li>
				</ul>
				<a class="btn btn-green" href="<?php echo esc_url( $anreise_url ); ?>" style="margin-top:20px"><?php esc_html_e( 'Urlaub planen', 'wp-sanktandreasberg' ); ?> ›</a>
			</div>
			<div class="photo" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/hike.jpg')" role="img" aria-label="Wandern in Sankt Andreasberg"></div>
		</article>
		<article class="card audience">
			<div class="card-body">
				<h2><?php esc_html_e( 'Für Einwohner', 'wp-sanktandreasberg' ); ?></h2>
				<ul>
					<li>⌂ <?php esc_html_e( 'Rathaus & Verwaltung', 'wp-sanktandreasberg' ); ?></li>
					<li>☘ <?php esc_html_e( 'Leben vor Ort', 'wp-sanktandreasberg' ); ?></li>
					<li>▣ <?php esc_html_e( 'Bürgerservice Online', 'wp-sanktandreasberg' ); ?></li>
					<li>● <?php esc_html_e( 'Vereine & Engagement', 'wp-sanktandreasberg' ); ?></li>
				</ul>
				<a class="btn btn-green" href="<?php echo esc_url( $info_url ); ?>" style="margin-top:20px"><?php esc_html_e( 'Leben vor Ort', 'wp-sanktandreasberg' ); ?> ›</a>
			</div>
			<div class="photo" style="background-image:url('<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/town.jpg')" role="img" aria-label="Sankt Andreasberg Stadtleben"></div>
		</article>
	</div>
</section>
