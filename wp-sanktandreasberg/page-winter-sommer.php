<?php
/*
 * Template Name: Winter & Sommer
 */
get_header(); ?>

<main id="main" class="cream">

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<?php esc_html_e( 'Winter & Sommer', 'wp-sanktandreasberg' ); ?>
	</div>

	<?php
	$hero_img = get_the_post_thumbnail_url( get_the_ID(), 'full' )
		?: 'https://images.unsplash.com/photo-1483921020237-2ff51e8e4b22?auto=format&fit=crop&w=2200&q=85';
	?>
	<section class="wrap inner-hero" style="--hero:url('<?php echo esc_url( $hero_img ); ?>')">
		<div class="inner-hero__content">
			<span class="label"><?php esc_html_e( 'Saison', 'wp-sanktandreasberg' ); ?></span>
			<h1><?php esc_html_e( 'Winter & Sommer', 'wp-sanktandreasberg' ); ?></h1>
			<p><?php esc_html_e( 'Sankt Andreasberg ist zu jeder Jahreszeit erlebbar: aktiv, naturnah und voller Harzer Atmosphäre.', 'wp-sanktandreasberg' ); ?></p>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div id="winter" class="season-split">
			<article class="season-panel" style="--bg:url('https://images.unsplash.com/photo-1551524559-8af4e6624178?auto=format&fit=crop&w=1600&q=85')">
				<h2><?php esc_html_e( 'Winter erleben', 'wp-sanktandreasberg' ); ?></h2>
				<p><?php esc_html_e( 'Ski Alpin, Langlauf, Rodeln und Winterwandern in der verschneiten Bergstadt.', 'wp-sanktandreasberg' ); ?></p>
				<p><a class="btn btn-white" href="#"><?php esc_html_e( 'Winterstatus ansehen', 'wp-sanktandreasberg' ); ?></a></p>
			</article>
			<article id="sommer" class="season-panel" style="--bg:url('https://images.unsplash.com/photo-1551632811-561732d1e306?auto=format&fit=crop&w=1600&q=85')">
				<h2><?php esc_html_e( 'Sommer erleben', 'wp-sanktandreasberg' ); ?></h2>
				<p><?php esc_html_e( 'Wandern, Mountainbike, Nationalpark und Familienausflüge im grünen Oberharz.', 'wp-sanktandreasberg' ); ?></p>
				<p><a class="btn btn-white" href="<?php echo esc_url( home_url( '/erleben/' ) ); ?>"><?php esc_html_e( 'Sommeraktivitäten', 'wp-sanktandreasberg' ); ?></a></p>
			</article>
		</div>
	</section>

	<section class="wrap section">
		<div class="section-head">
			<h2><?php esc_html_e( 'Saisonale Empfehlungen', 'wp-sanktandreasberg' ); ?></h2>
		</div>
		<div class="tile-grid-4">
			<article class="card tile">
				<div class="photo hero-b"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Langlauf & Loipen', 'wp-sanktandreasberg' ); ?></h3><p><?php esc_html_e( 'Routen, Status und Tipps für Wintersportler.', 'wp-sanktandreasberg' ); ?></p></div>
			</article>
			<article class="card tile">
				<div class="photo ski"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Matthias-Schmidt-Berg', 'wp-sanktandreasberg' ); ?></h3><p><?php esc_html_e( 'Ski, Rodeln und Ausblick.', 'wp-sanktandreasberg' ); ?></p></div>
			</article>
			<article class="card tile">
				<div class="photo hike"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Wandern im Sommer', 'wp-sanktandreasberg' ); ?></h3><p><?php esc_html_e( 'Routen für jeden Anspruch.', 'wp-sanktandreasberg' ); ?></p></div>
			</article>
			<article class="card tile">
				<div class="photo bike"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Mountainbike-Trails', 'wp-sanktandreasberg' ); ?></h3><p><?php esc_html_e( 'Flow und Technik für alle Levels.', 'wp-sanktandreasberg' ); ?></p></div>
			</article>
		</div>
	</section>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php if ( get_the_content() ) : ?>
		<section class="wrap section">
			<div class="card article-body" style="padding:28px">
				<?php the_content(); ?>
			</div>
		</section>
		<?php endif; ?>
	<?php endwhile; endif; ?>

</main>

<?php get_footer(); ?>
