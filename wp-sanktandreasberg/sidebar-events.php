<aside class="sidebar" aria-label="<?php esc_attr_e( 'Seitenleiste Veranstaltungen', 'wp-sanktandreasberg' ); ?>">
	<?php if ( is_active_sidebar( 'sidebar-events' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-events' ); ?>
	<?php else : ?>
		<!-- Default events sidebar content -->
		<section class="card side-card">
			<h3><?php esc_html_e( 'Veranstaltung suchen', 'wp-sanktandreasberg' ); ?></h3>
			<form class="search-box" role="search" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>">
				<input class="search-field" type="search" name="s" placeholder="<?php esc_attr_e( 'Event, Ort, Kategorie …', 'wp-sanktandreasberg' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
				<button type="submit" aria-label="<?php esc_attr_e( 'Suchen', 'wp-sanktandreasberg' ); ?>">⌕</button>
			</form>
		</section>

		<!-- Upcoming events in sidebar -->
		<?php
		$upcoming = new WP_Query( [
			'post_type'      => 'event',
			'posts_per_page' => 4,
			'meta_key'       => 'event_date_start',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
			'meta_query'     => [ [
				'key'     => 'event_date_start',
				'value'   => date( 'Y-m-d' ),
				'compare' => '>=',
				'type'    => 'DATE',
			] ],
		] );
		if ( $upcoming->have_posts() ) : ?>
			<section class="card side-card">
				<h3><?php esc_html_e( 'Nächste Veranstaltungen', 'wp-sanktandreasberg' ); ?></h3>
				<?php while ( $upcoming->have_posts() ) : $upcoming->the_post();
					$date = sab_meta( 'event_date_start' );
					$ts   = $date ? strtotime( $date ) : false;
				?>
					<div class="mini-event">
						<?php if ( $ts ) : ?>
						<div class="date-box" aria-hidden="true">
							<small><?php echo esc_html( strtoupper( date_i18n( 'M', $ts ) ) ); ?></small>
							<b><?php echo esc_html( date_i18n( 'd', $ts ) ); ?></b>
						</div>
						<?php endif; ?>
						<div class="mini-text">
							<b><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></b>
							<span><?php echo esc_html( sab_meta( 'event_location' ) ); ?></span>
						</div>
					</div>
				<?php endwhile; wp_reset_postdata(); ?>
			</section>
		<?php endif; ?>

		<section class="card side-card">
			<h3><?php esc_html_e( 'Veranstaltung eintragen', 'wp-sanktandreasberg' ); ?></h3>
			<p class="muted"><?php esc_html_e( 'Sie möchten eine Veranstaltung bekanntmachen?', 'wp-sanktandreasberg' ); ?></p>
			<p style="margin-top:12px">
				<a class="btn btn-dark" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>" style="width:100%;justify-content:center">
					<?php esc_html_e( 'Kontakt aufnehmen', 'wp-sanktandreasberg' ); ?>
				</a>
			</p>
		</section>
	<?php endif; ?>
</aside>
