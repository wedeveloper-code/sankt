<?php
/*
 * Template Name: Geschichte
 */
get_header(); ?>

<main id="main" class="cream">

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<?php esc_html_e( 'Geschichte', 'wp-sanktandreasberg' ); ?>
	</div>

	<?php
	$hero_img = get_the_post_thumbnail_url( get_the_ID(), 'full' )
		?: 'https://images.unsplash.com/photo-1534870330274-5f7a3485702b?auto=format&fit=crop&w=2200&q=85';
	?>
	<section class="wrap inner-hero" style="--hero:url('<?php echo esc_url( $hero_img ); ?>')">
		<div class="inner-hero__content">
			<span class="label"><?php esc_html_e( 'Bergstadt', 'wp-sanktandreasberg' ); ?></span>
			<h1><?php esc_html_e( 'Geschichte', 'wp-sanktandreasberg' ); ?></h1>
			<p><?php esc_html_e( 'Über 500 Jahre Bergbau, Glaube und Bergstädtisches Leben im Oberharz.', 'wp-sanktandreasberg' ); ?></p>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="page-grid">
			<article class="card place-main">

				<div class="history" style="margin-bottom:24px">
					<div class="history-inner">
						<div>
							<h2><?php esc_html_e( 'Eine Stadt mit tiefen Wurzeln', 'wp-sanktandreasberg' ); ?></h2>
							<p><?php esc_html_e( 'Seit dem 15. Jahrhundert geprägt vom Bergbau. Die Grube Samson und das historische Stadtbild erzählen von einer bewegten Vergangenheit.', 'wp-sanktandreasberg' ); ?></p>
						</div>
						<div class="timeline">
							<div class="time"><b>1487</b><span><?php esc_html_e( 'Erste urkundliche Erwähnung', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>1527</b><span><?php esc_html_e( 'Beginn des Erzbergbaus', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>1902</b><span><?php esc_html_e( 'Grube Samson in Betrieb', 'wp-sanktandreasberg' ); ?></span></div>
							<div class="time"><b>1992</b><span><?php esc_html_e( 'Besucherbergwerk', 'wp-sanktandreasberg' ); ?></span></div>
						</div>
					</div>
				</div>

				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php if ( get_the_content() ) : ?>
					<div class="article-body">
						<?php the_content(); ?>
					</div>
					<?php endif; ?>
				<?php endwhile; endif; ?>

				<div class="tile-grid" style="margin-top:24px">
					<article class="card tile">
						<div class="photo mine"></div>
						<div class="card-body">
							<h3><?php esc_html_e( 'Grube Samson', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Das bedeutendste Bergbau-Denkmal im Oberharz.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="<?php echo esc_url( get_post_type_archive_link( 'place' ) ); ?>"><?php esc_html_e( 'Mehr erfahren', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
					<article class="card tile">
						<div class="photo forest"></div>
						<div class="card-body">
							<h3><?php esc_html_e( 'Bergbau-Erbe', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Oberharz als UNESCO-Weltkulturerbe.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="#"><?php esc_html_e( 'Zum UNESCO-Erbe', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
					<article class="card tile">
						<div class="photo town"></div>
						<div class="card-body">
							<h3><?php esc_html_e( 'Stadtgeschichte', 'wp-sanktandreasberg' ); ?></h3>
							<p><?php esc_html_e( 'Die Entwicklung der Bergstadt vom Mittelalter bis heute.', 'wp-sanktandreasberg' ); ?></p>
							<a class="link" href="#"><?php esc_html_e( 'Stadtgeschichte', 'wp-sanktandreasberg' ); ?> →</a>
						</div>
					</article>
				</div>
			</article>

			<?php get_sidebar(); ?>
		</div>
	</section>

</main>

<?php get_footer(); ?>
