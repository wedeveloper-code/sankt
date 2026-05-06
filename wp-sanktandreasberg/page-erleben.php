<?php
/*
 * Template Name: Erleben (Aktivitäten)
 */
get_header(); ?>

<main id="main" class="cream">

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<?php esc_html_e( 'Erleben', 'wp-sanktandreasberg' ); ?>
	</div>

	<?php
	$hero_img = get_the_post_thumbnail_url( get_the_ID(), 'full' )
		?: get_theme_mod( 'sab_hero_erleben', '' )
		?: 'https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=2200&q=85';
	?>
	<section class="wrap inner-hero" style="--hero:url('<?php echo esc_url( $hero_img ); ?>')">
		<div class="inner-hero__content">
			<span class="label"><?php esc_html_e( 'Erleben', 'wp-sanktandreasberg' ); ?></span>
			<h1><?php esc_html_e( 'Aktivitäten', 'wp-sanktandreasberg' ); ?></h1>
			<p><?php esc_html_e( 'Wandern, Mountainbike, Nordic Walking, Ski, Rodeln und Abenteuer für jede Jahreszeit.', 'wp-sanktandreasberg' ); ?></p>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="toolbar">
			<div class="filters" aria-label="<?php esc_attr_e( 'Aktivitäten-Filter', 'wp-sanktandreasberg' ); ?>">
				<a class="filter-chip active" href="<?php echo esc_url( get_permalink() ); ?>">◼ <?php esc_html_e( 'Alle', 'wp-sanktandreasberg' ); ?></a>
				<?php
				$act_types = get_terms( [ 'taxonomy' => 'activity_type', 'hide_empty' => true ] );
				foreach ( $act_types as $at ) :
				?>
					<a class="filter-chip" href="<?php echo esc_url( get_term_link( $at ) ); ?>"><?php echo esc_html( $at->name ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="page-grid">
			<div>
				<?php
				$routes = new WP_Query( [
					'post_type'      => 'route',
					'posts_per_page' => 6,
					'orderby'        => 'menu_order',
					'order'          => 'ASC',
				] );
				if ( $routes->have_posts() ) :
				?>
				<div class="tile-grid">
					<?php while ( $routes->have_posts() ) : $routes->the_post();
						$terms = get_the_terms( get_the_ID(), 'activity_type' );
						$term  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
						$thumb = sab_thumbnail_url( null, 'sab-card' );
					?>
					<article class="card tile">
						<div class="photo" style="background-image:url('<?php echo $thumb; ?>')" role="img" aria-label="<?php the_title_attribute(); ?>">
							<?php if ( $term ) : ?><span class="label" style="position:absolute;top:10px;left:10px"><?php echo esc_html( $term->name ); ?></span><?php endif; ?>
						</div>
						<div class="card-body">
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php if ( get_the_excerpt() ) : ?>
								<p><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
							<?php endif; ?>
							<a class="link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Mehr erfahren', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>
				<?php else : ?>
				<div class="tile-grid">
					<article class="card tile">
						<div class="photo hero-a"></div>
						<div class="card-body"><span class="label"><?php esc_html_e( 'Wandern', 'wp-sanktandreasberg' ); ?></span><h3><?php esc_html_e( 'Wanderwege rund um die Bergstadt', 'wp-sanktandreasberg' ); ?></h3><p><?php esc_html_e( 'Touren für Einsteiger, Familien und erfahrene Wanderer.', 'wp-sanktandreasberg' ); ?></p><a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'route' ) ); ?>"><?php esc_html_e( 'Routen ansehen', 'wp-sanktandreasberg' ); ?> →</a></div>
					</article>
					<article class="card tile">
						<div class="photo hero-c"></div>
						<div class="card-body"><span class="label"><?php esc_html_e( 'Mountainbike', 'wp-sanktandreasberg' ); ?></span><h3><?php esc_html_e( 'Trails am Matthias-Schmidt-Berg', 'wp-sanktandreasberg' ); ?></h3><p><?php esc_html_e( 'Flow, Aussicht und Abwechslung für aktive Gäste.', 'wp-sanktandreasberg' ); ?></p><a class="link" href="#"><?php esc_html_e( 'Mehr erfahren', 'wp-sanktandreasberg' ); ?> →</a></div>
					</article>
					<article class="card tile">
						<div class="photo hero-b"></div>
						<div class="card-body"><span class="label blue"><?php esc_html_e( 'Winter', 'wp-sanktandreasberg' ); ?></span><h3><?php esc_html_e( 'Ski, Langlauf & Rodeln', 'wp-sanktandreasberg' ); ?></h3><p><?php esc_html_e( 'Wintersport und verschneite Wege im Oberharz.', 'wp-sanktandreasberg' ); ?></p><a class="link" href="<?php echo esc_url( home_url( '/winter-sommer/' ) ); ?>"><?php esc_html_e( 'Winter erleben', 'wp-sanktandreasberg' ); ?> →</a></div>
					</article>
					<article class="card tile">
						<div class="photo hero-d"></div>
						<div class="card-body"><span class="label yellow"><?php esc_html_e( 'Familie', 'wp-sanktandreasberg' ); ?></span><h3><?php esc_html_e( 'Abenteuer für Groß und Klein', 'wp-sanktandreasberg' ); ?></h3><p><?php esc_html_e( 'Sommerrodelbahn, Naturerlebnisse und leichte Ausflüge.', 'wp-sanktandreasberg' ); ?></p><a class="link" href="#"><?php esc_html_e( 'Familienangebote', 'wp-sanktandreasberg' ); ?> →</a></div>
					</article>
					<article class="card tile">
						<div class="photo forest"></div>
						<div class="card-body"><span class="label"><?php esc_html_e( 'Natur', 'wp-sanktandreasberg' ); ?></span><h3><?php esc_html_e( 'Nationalpark entdecken', 'wp-sanktandreasberg' ); ?></h3><p><?php esc_html_e( 'Geführte Touren, stille Pfade und spannende Tierwelt.', 'wp-sanktandreasberg' ); ?></p><a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'place' ) ); ?>"><?php esc_html_e( 'Orte entdecken', 'wp-sanktandreasberg' ); ?> →</a></div>
					</article>
					<article class="card tile">
						<div class="photo town"></div>
						<div class="card-body"><span class="label red"><?php esc_html_e( 'Kultur', 'wp-sanktandreasberg' ); ?></span><h3><?php esc_html_e( 'Geschichte erleben', 'wp-sanktandreasberg' ); ?></h3><p><?php esc_html_e( 'Bergbau, Kurhaus und historische Rundgänge.', 'wp-sanktandreasberg' ); ?></p><a class="link" href="<?php echo esc_url( home_url( '/geschichte/' ) ); ?>"><?php esc_html_e( 'Zur Geschichte', 'wp-sanktandreasberg' ); ?> →</a></div>
					</article>
				</div>
				<?php endif; ?>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<div class="card article-body" style="padding:28px;margin-top:24px">
						<?php the_content(); ?>
					</div>
				<?php endwhile; endif; ?>
			</div>

			<?php get_sidebar(); ?>
		</div>
	</section>

	<?php get_template_part( 'template-parts/section', 'seasons' ); ?>

</main>

<?php get_footer(); ?>
