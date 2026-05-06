<?php
$places_query = new WP_Query( [
	'post_type'      => 'place',
	'posts_per_page' => 6,
	'post_status'    => 'publish',
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
] );
if ( ! $places_query->have_posts() ) return;
?>
<section id="experiences" class="section cream">
	<div class="wrap">
		<div class="section-head">
			<h2><?php esc_html_e( 'Top-Erlebnisse', 'wp-sanktandreasberg' ); ?></h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'place' ) ); ?>">
				<?php esc_html_e( 'Alle Erlebnisse', 'wp-sanktandreasberg' ); ?> ›
			</a>
		</div>
		<div class="experience-grid">
			<?php
			while ( $places_query->have_posts() ) :
				$places_query->the_post();
				$thumb = sab_thumbnail_url( null, 'sab-card' );
			?>
			<article class="card experience">
				<div class="photo" style="background-image:url('<?php echo $thumb; ?>')" role="img" aria-label="<?php the_title_attribute(); ?>"></div>
				<div class="card-body">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<?php if ( get_the_excerpt() ) : ?>
						<p class="muted"><?php echo wp_trim_words( get_the_excerpt(), 8 ); ?></p>
					<?php endif; ?>
				</div>
			</article>
			<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
