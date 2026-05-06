<?php get_header(); ?>

<main id="main" class="cream">

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<?php esc_html_e( 'Veranstaltungen', 'wp-sanktandreasberg' ); ?>
	</div>

	<section class="wrap events-hero">
		<div class="events-hero__content">
			<span class="label"><?php esc_html_e( 'Kalender', 'wp-sanktandreasberg' ); ?></span>
			<h1><?php esc_html_e( 'Veranstaltungen', 'wp-sanktandreasberg' ); ?></h1>
			<p><?php esc_html_e( 'Konzerte, Führungen, Wanderungen, Feste und Familienangebote in Sankt Andreasberg und im Oberharz.', 'wp-sanktandreasberg' ); ?></p>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="toolbar">
			<div class="filters" aria-label="<?php esc_attr_e( 'Veranstaltungsfilter', 'wp-sanktandreasberg' ); ?>">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>" class="filter-chip active">◼ <?php esc_html_e( 'Alle', 'wp-sanktandreasberg' ); ?></a>
				<?php
				$event_cats = get_terms( [ 'taxonomy' => 'event_category', 'hide_empty' => true ] );
				foreach ( $event_cats as $ecat ) :
				?>
					<a href="<?php echo esc_url( get_term_link( $ecat ) ); ?>" class="filter-chip"><?php echo esc_html( $ecat->name ); ?></a>
				<?php endforeach; ?>
			</div>
			<div class="sortbar">
				<span><strong><?php esc_html_e( 'Zeitraum:', 'wp-sanktandreasberg' ); ?></strong> <?php echo esc_html( date_i18n( 'F Y' ) ); ?></span>
			</div>
		</div>

		<div class="page-grid">
			<div>
				<?php if ( have_posts() ) : ?>
					<?php
					$first = true;
					while ( have_posts() ) :
						the_post();
						if ( $first ) :
							$date_str = sab_meta( 'event_date_start' );
							$ts       = $date_str ? strtotime( $date_str ) : false;
							$location = sab_meta( 'event_location' );
							$organizer = sab_meta( 'event_organizer' );
							$terms    = get_the_terms( get_the_ID(), 'event_category' );
							$term     = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
							$thumb    = sab_thumbnail_url( null, 'sab-featured' );
							$first    = false;
					?>
					<article class="card featured-event">
						<div class="photo" style="background-image:url('<?php echo $thumb; ?>')">
							<span class="label yellow" style="position:absolute;top:12px;left:12px"><?php esc_html_e( 'Highlight', 'wp-sanktandreasberg' ); ?></span>
							<?php if ( $ts ) : ?>
								<div class="date-tile"><div><small><?php echo esc_html( strtoupper( date_i18n( 'M', $ts ) ) ); ?></small><b><?php echo esc_html( date_i18n( 'd', $ts ) ); ?></b></div></div>
							<?php endif; ?>
						</div>
						<div class="card-body">
							<?php if ( $term ) : ?><span class="label"><?php echo esc_html( $term->name ); ?></span><?php endif; ?>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo wp_trim_words( get_the_excerpt(), 30 ); ?></p>
							<div class="event-meta">
								<?php if ( $ts ) : ?><span>◷ <?php echo esc_html( date_i18n( 'H:i \U\h\r', $ts ) ); ?></span><?php endif; ?>
								<?php if ( $location ) : ?><span>⌖ <?php echo esc_html( $location ); ?></span><?php endif; ?>
								<?php if ( $organizer ) : ?><span>● <?php echo esc_html( $organizer ); ?></span><?php endif; ?>
							</div>
							<div style="margin-top:14px">
								<a class="link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Details ansehen', 'wp-sanktandreasberg' ); ?> →</a>
							</div>
						</div>
					</article>
					<div class="event-list-grid">
					<?php else : ?>
						<?php get_template_part( 'template-parts/content', 'event' ); ?>
					<?php endif; ?>
					<?php endwhile; ?>
					</div>

					<nav class="pagination" aria-label="<?php esc_attr_e( 'Pagination', 'wp-sanktandreasberg' ); ?>">
						<?php the_posts_pagination( [ 'prev_text' => '‹', 'next_text' => '›' ] ); ?>
					</nav>

					<div class="submit-card">
						<div>
							<h2><?php esc_html_e( 'Veranstaltung eintragen', 'wp-sanktandreasberg' ); ?></h2>
							<p><?php esc_html_e( 'Haben Sie eine Veranstaltung? Tragen Sie sie kostenlos in unseren Kalender ein.', 'wp-sanktandreasberg' ); ?></p>
						</div>
						<a class="btn btn-gold" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>"><?php esc_html_e( 'Jetzt eintragen', 'wp-sanktandreasberg' ); ?> ›</a>
					</div>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>

			<?php get_sidebar( 'events' ); ?>
		</div>
	</section>

</main>

<?php get_footer(); ?>
