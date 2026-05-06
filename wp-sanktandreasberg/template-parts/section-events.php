<?php
$events_query = new WP_Query( [
	'post_type'      => 'event',
	'posts_per_page' => 5,
	'post_status'    => 'publish',
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
if ( ! $events_query->have_posts() ) return;
?>
<section id="events" class="section cream">
	<div class="wrap">
		<div class="section-head">
			<h2><?php esc_html_e( 'Veranstaltungen', 'wp-sanktandreasberg' ); ?></h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>">
				<?php esc_html_e( 'Alle Veranstaltungen', 'wp-sanktandreasberg' ); ?> ›
			</a>
		</div>
		<div class="events-grid">
			<?php
			while ( $events_query->have_posts() ) :
				$events_query->the_post();
				$date_str = sab_meta( 'event_date_start' );
				$ts       = $date_str ? strtotime( $date_str ) : false;
				$location = sab_meta( 'event_location' );
				$thumb    = sab_thumbnail_url( null, 'sab-card' );
			?>
			<article class="card event-card">
				<div class="photo" style="background-image:url('<?php echo $thumb; ?>')" role="img" aria-label="<?php the_title_attribute(); ?>">
					<?php if ( $ts ) : ?>
					<div class="date-badge" aria-label="<?php echo esc_attr( date_i18n( 'd. F', $ts ) ); ?>">
						<small><?php echo esc_html( strtoupper( date_i18n( 'M', $ts ) ) ); ?></small>
						<b><?php echo esc_html( date_i18n( 'd', $ts ) ); ?></b>
					</div>
					<?php endif; ?>
				</div>
				<div class="card-body">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<div class="meta-list">
						<?php if ( $ts ) : ?>
							<span>◷ <?php echo esc_html( date_i18n( 'H:i \U\h\r', $ts ) ); ?></span>
						<?php endif; ?>
						<?php if ( $location ) : ?>
							<span>⌖ <?php echo esc_html( $location ); ?></span>
						<?php endif; ?>
					</div>
				</div>
			</article>
			<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
