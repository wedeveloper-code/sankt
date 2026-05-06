<?php get_header(); ?>

<main id="main">

	<?php get_template_part( 'template-parts/hero', 'main' ); ?>

	<section class="stats" aria-label="<?php esc_attr_e( 'Kennzahlen', 'wp-sanktandreasberg' ); ?>">
		<div class="wrap">
			<div class="stat"><i>⛰</i><div><strong>870 m</strong><span><?php esc_html_e( 'Höhenlage', 'wp-sanktandreasberg' ); ?></span></div></div>
			<div class="stat"><i>↟</i><div><strong>200 km</strong><span><?php esc_html_e( 'Wanderwege', 'wp-sanktandreasberg' ); ?></span></div></div>
			<div class="stat"><i>⛷</i><div><strong>40 km</strong><span><?php esc_html_e( 'Loipen', 'wp-sanktandreasberg' ); ?></span></div></div>
			<div class="stat"><i>⚒</i><div><strong>500+ <?php esc_html_e( 'Jahre', 'wp-sanktandreasberg' ); ?></strong><span><?php esc_html_e( 'Bergbaugeschichte', 'wp-sanktandreasberg' ); ?></span></div></div>
		</div>
	</section>

	<section id="today" class="section cream">
		<div class="wrap">
			<div class="section-head">
				<h2><?php esc_html_e( 'Heute in Sankt Andreasberg', 'wp-sanktandreasberg' ); ?></h2>
			</div>
			<div class="today-grid">
				<article class="soft-card today-card">
					<div class="weather-main">
						<div class="weather-icon">🌤️</div>
						<div>
							<div class="today-top"><h3><?php esc_html_e( 'Wetter aktuell', 'wp-sanktandreasberg' ); ?></h3></div>
							<div class="temp">14°</div>
							<strong><?php esc_html_e( 'Bewölkt', 'wp-sanktandreasberg' ); ?></strong>
							<p class="muted"><?php esc_html_e( 'Gefühlt 13°', 'wp-sanktandreasberg' ); ?></p>
						</div>
					</div>
					<p class="muted">8° / 16°</p>
					<?php $weather_url = get_theme_mod( 'sab_weather_url', '' ); if ( $weather_url ) : ?>
						<a class="link" href="<?php echo esc_url( $weather_url ); ?>"><?php esc_html_e( 'Wetterdetails', 'wp-sanktandreasberg' ); ?> ›</a>
					<?php endif; ?>
				</article>

				<article class="soft-card today-card">
					<div class="today-top"><span class="icon-lg">⛷</span><h3><?php esc_html_e( 'Pisten & Loipen', 'wp-sanktandreasberg' ); ?></h3></div>
					<div class="mini-lines">
						<p><strong><?php esc_html_e( 'Loipen gut', 'wp-sanktandreasberg' ); ?></strong><span class="green-dot"></span><br><?php esc_html_e( '40 km gespurt', 'wp-sanktandreasberg' ); ?></p>
						<p><strong><?php esc_html_e( 'Pisten geöffnet', 'wp-sanktandreasberg' ); ?></strong><span class="green-dot"></span><br><?php esc_html_e( '3/5 Anlagen', 'wp-sanktandreasberg' ); ?></p>
					</div>
					<?php $webcam_url = get_theme_mod( 'sab_webcam_url', '' ); if ( $webcam_url ) : ?>
						<a class="link" href="<?php echo esc_url( $webcam_url ); ?>"><?php esc_html_e( 'Mehr Infos', 'wp-sanktandreasberg' ); ?> ›</a>
					<?php endif; ?>
				</article>

				<article class="soft-card today-card">
					<div class="today-top"><span class="icon-lg">▣</span><h3><?php esc_html_e( 'Veranstaltungen heute', 'wp-sanktandreasberg' ); ?></h3></div>
					<div class="mini-lines">
						<?php
						$today_events = new WP_Query( [
							'post_type'      => 'event',
							'posts_per_page' => 3,
							'meta_key'       => 'event_date_start',
							'meta_value'     => date( 'Y-m-d' ),
							'meta_compare'   => '>=',
							'orderby'        => 'meta_value',
							'order'          => 'ASC',
						] );
						if ( $today_events->have_posts() ) :
							while ( $today_events->have_posts() ) :
								$today_events->the_post();
								$ts = strtotime( sab_meta( 'event_date_start' ) );
								?>
								<p><?php if ( $ts ) echo esc_html( date_i18n( 'H:i', $ts ) ) . ' '; ?><?php the_title(); ?></p>
							<?php endwhile; wp_reset_postdata();
						else : ?>
							<p><?php esc_html_e( 'Keine Veranstaltungen heute', 'wp-sanktandreasberg' ); ?></p>
						<?php endif; ?>
					</div>
					<a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>"><?php esc_html_e( 'Alle anzeigen', 'wp-sanktandreasberg' ); ?> ›</a>
				</article>

				<article class="soft-card today-card">
					<div class="today-top"><span class="icon-lg">ⓘ</span><h3><?php esc_html_e( 'Tourist-Info', 'wp-sanktandreasberg' ); ?></h3></div>
					<div class="mini-lines">
						<p><?php esc_html_e( 'Geöffnet heute:', 'wp-sanktandreasberg' ); ?><br>
						<strong><?php echo esc_html( get_theme_mod( 'sab_ti_hours', '09:00 – 17:00 Uhr' ) ); ?></strong></p>
						<?php if ( $phone = get_theme_mod( 'sab_ti_phone', '' ) ) : ?>
							<p>☎ <?php echo esc_html( $phone ); ?></p>
						<?php endif; ?>
					</div>
					<a class="link" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>"><?php esc_html_e( 'Zum Kontakt', 'wp-sanktandreasberg' ); ?> ›</a>
				</article>

				<article class="soft-card today-card">
					<div class="today-top"><span class="icon-lg">🔔</span><h3><?php esc_html_e( 'Hinweis der Stadt', 'wp-sanktandreasberg' ); ?></h3></div>
					<?php
					$notice_query = new WP_Query( [
						'post_type'      => 'post',
						'posts_per_page' => 1,
						'category_name'  => 'hinweis',
					] );
					if ( $notice_query->have_posts() ) :
						$notice_query->the_post();
						?>
						<p class="muted"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
						<a class="link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Weiterlesen', 'wp-sanktandreasberg' ); ?> ›</a>
						<?php
						wp_reset_postdata();
					else : ?>
						<p class="muted"><?php esc_html_e( 'Aktuelle Informationen aus der Stadtverwaltung.', 'wp-sanktandreasberg' ); ?></p>
						<a class="link" href="<?php echo esc_url( home_url( '/aktuelles/' ) ); ?>"><?php esc_html_e( 'Alle Meldungen', 'wp-sanktandreasberg' ); ?> ›</a>
					<?php endif; ?>
				</article>
			</div>
		</div>
	</section>

	<?php
	get_template_part( 'template-parts/section', 'news' );
	get_template_part( 'template-parts/section', 'events' );
	get_template_part( 'template-parts/section', 'seasons' );
	get_template_part( 'template-parts/section', 'experiences' );
	get_template_part( 'template-parts/section', 'map' );
	get_template_part( 'template-parts/section', 'audience' );
	get_template_part( 'template-parts/section', 'lodging' );
	get_template_part( 'template-parts/section', 'history' );
	?>

</main>

<?php get_footer(); ?>
