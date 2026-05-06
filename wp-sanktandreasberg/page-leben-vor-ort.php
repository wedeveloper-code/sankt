<?php
/*
 * Template Name: Leben vor Ort
 */
get_header(); ?>

<main id="main" class="cream">

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<?php esc_html_e( 'Leben vor Ort', 'wp-sanktandreasberg' ); ?>
	</div>

	<?php
	$hero_img = get_the_post_thumbnail_url( get_the_ID(), 'full' )
		?: 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=2200&q=85';
	?>
	<section class="wrap inner-hero" style="--hero:url('<?php echo esc_url( $hero_img ); ?>')">
		<div class="inner-hero__content">
			<span class="label"><?php esc_html_e( 'Bürgerservice', 'wp-sanktandreasberg' ); ?></span>
			<h1><?php esc_html_e( 'Leben vor Ort', 'wp-sanktandreasberg' ); ?></h1>
			<p><?php esc_html_e( 'Alles Wichtige für Einwohnerinnen und Einwohner von Sankt Andreasberg.', 'wp-sanktandreasberg' ); ?></p>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="page-grid">
			<div>
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php if ( get_the_content() ) : ?>
					<article class="card article-body" style="padding:28px;margin-bottom:24px">
						<?php the_content(); ?>
					</article>
					<?php endif; ?>
				<?php endwhile; endif; ?>

				<div class="tile-grid">
					<article class="card tile">
						<div class="card-body">
							<span class="icon-lg">⌂</span>
							<h3><?php esc_html_e( 'Rathaus & Verwaltung', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Ämter, Ansprechpartner und Online-Dienste der Stadtverwaltung.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="#"><?php esc_html_e( 'Zum Rathaus', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
					<article class="card tile">
						<div class="card-body">
							<span class="icon-lg">▣</span>
							<h3><?php esc_html_e( 'Bürgerservice Online', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Anträge, Formulare und digitale Dienste für Bürgerinnen und Bürger.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="#"><?php esc_html_e( 'Online-Dienste', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
					<article class="card tile">
						<div class="card-body">
							<span class="icon-lg">●</span>
							<h3><?php esc_html_e( 'Vereine & Engagement', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Engagierte Bürger und vielfältiges Vereinsleben in der Bergstadt.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="#"><?php esc_html_e( 'Vereine ansehen', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
					<article class="card tile">
						<div class="card-body">
							<span class="icon-lg">🚨</span>
							<h3><?php esc_html_e( 'Notdienste', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Ärztlicher Notdienst, Apotheke und wichtige Notrufnummern.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="#"><?php esc_html_e( 'Notfallinfos', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
					<article class="card tile">
						<div class="card-body">
							<span class="icon-lg">☘</span>
							<h3><?php esc_html_e( 'Schulen & Bildung', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Schulen, Kindergärten und Bildungsangebote vor Ort.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="#"><?php esc_html_e( 'Bildungseinrichtungen', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
					<article class="card tile">
						<div class="card-body">
							<span class="icon-lg">♻</span>
							<h3><?php esc_html_e( 'Abfall & Entsorgung', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Müllabfuhr, Recycling und Entsorgungsstellen in der Region.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="#"><?php esc_html_e( 'Entsorgungsinfos', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
				</div>

				<?php
				$local_news = new WP_Query( [
					'post_type'      => 'post',
					'posts_per_page' => 3,
					'category_name'  => 'leben-vor-ort',
				] );
				if ( $local_news->have_posts() ) :
				?>
				<div style="margin-top:24px">
					<div class="section-head">
						<h2><?php esc_html_e( 'Aktuelle Nachrichten', 'wp-sanktandreasberg' ); ?></h2>
						<a href="<?php echo esc_url( home_url( '/aktuelles/' ) ); ?>"><?php esc_html_e( 'Alle anzeigen', 'wp-sanktandreasberg' ); ?> ›</a>
					</div>
					<div class="related-grid">
						<?php while ( $local_news->have_posts() ) : $local_news->the_post(); get_template_part( 'template-parts/content' ); endwhile; wp_reset_postdata(); ?>
					</div>
				</div>
				<?php endif; ?>
			</div>

			<?php get_sidebar(); ?>
		</div>
	</section>

</main>

<?php get_footer(); ?>
