<?php
$hero_image = get_theme_mod( 'sab_hero_image', '' );
$hero_title = get_theme_mod( 'sab_hero_title', __( 'Willkommen in<br>Sankt Andreasberg', 'wp-sanktandreasberg' ) );
$hero_sub   = get_theme_mod( 'sab_hero_subtitle', __( 'Ihre Bergstadt im Harz – Natur, Nachrichten und Erlebnisse zu jeder Jahreszeit.', 'wp-sanktandreasberg' ) );
$bg_style   = $hero_image ? ' style="--hero-image:url(' . esc_url( $hero_image ) . ')"' : '';
?>
<section class="hero"<?php echo $bg_style; // phpcs:ignore ?>>
	<div class="wrap">
		<div class="hero-content">
			<h1><?php echo wp_kses( $hero_title, [ 'br' => [] ] ); ?></h1>
			<p><?php echo esc_html( $hero_sub ); ?></p>
			<div class="hero-actions">
				<a class="btn btn-gold" href="<?php echo esc_url( home_url( '/aktuelles/' ) ); ?>">
					<span aria-hidden="true">▣</span> <?php esc_html_e( 'Aktuelles lesen', 'wp-sanktandreasberg' ); ?>
				</a>
				<a class="btn btn-green" href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>">
					<span aria-hidden="true">▣</span> <?php esc_html_e( 'Veranstaltungen', 'wp-sanktandreasberg' ); ?>
				</a>
				<a class="btn btn-green" href="<?php echo esc_url( get_post_type_archive_link( 'business' ) ); ?>">
					<span aria-hidden="true">♙</span> <?php esc_html_e( 'Urlaub planen', 'wp-sanktandreasberg' ); ?>
				</a>
				<a class="btn btn-green" href="<?php echo esc_url( get_post_type_archive_link( 'route' ) ); ?>">
					<span aria-hidden="true">✶</span> <?php esc_html_e( 'Wandern & Winter', 'wp-sanktandreasberg' ); ?>
				</a>
			</div>
			<div class="badges">
				<span class="badge"><span aria-hidden="true">◎</span> <?php esc_html_e( 'Nationalpark Harz', 'wp-sanktandreasberg' ); ?></span>
				<span class="badge"><span aria-hidden="true">⛏</span> <?php esc_html_e( 'Bergstadt seit 1487', 'wp-sanktandreasberg' ); ?></span>
				<span class="badge"><span aria-hidden="true">◉</span> <?php esc_html_e( 'UNESCO', 'wp-sanktandreasberg' ); ?></span>
				<span class="badge"><span aria-hidden="true">♨</span> <?php esc_html_e( 'Luftkurort', 'wp-sanktandreasberg' ); ?></span>
			</div>
		</div>
	</div>
</section>
