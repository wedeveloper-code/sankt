<?php get_header(); ?>

<main id="main" class="cream">

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<?php esc_html_e( 'Unterkunft & Gastronomie', 'wp-sanktandreasberg' ); ?>
	</div>

	<?php
	$business_hero = get_theme_mod( 'sab_hero_business', '' )
		?: 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=2000&q=85';
	?>
	<section class="wrap events-hero" style="background-image:linear-gradient(90deg,rgba(0,28,20,.86),rgba(0,43,31,.55),rgba(0,43,31,.15)),url('<?php echo esc_url( $business_hero ); ?>')">
		<div class="events-hero__content">
			<span class="label"><?php esc_html_e( 'Verzeichnis', 'wp-sanktandreasberg' ); ?></span>
			<h1><?php esc_html_e( 'Unterkunft & Gastronomie', 'wp-sanktandreasberg' ); ?></h1>
			<p><?php esc_html_e( 'Hotels, Ferienwohnungen, Restaurants und Cafés in Sankt Andreasberg.', 'wp-sanktandreasberg' ); ?></p>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="toolbar">
			<div class="filters" aria-label="<?php esc_attr_e( 'Kategorienfilter', 'wp-sanktandreasberg' ); ?>">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'business' ) ); ?>" class="filter-chip active">◼ <?php esc_html_e( 'Alle', 'wp-sanktandreasberg' ); ?></a>
				<?php
				$bus_types = get_terms( [ 'taxonomy' => 'business_type', 'hide_empty' => true ] );
				foreach ( $bus_types as $bt ) :
				?>
					<a href="<?php echo esc_url( get_term_link( $bt ) ); ?>" class="filter-chip"><?php echo esc_html( $bt->name ); ?></a>
				<?php endforeach; ?>
			</div>
		</div>

		<div class="page-grid">
			<div>
				<?php if ( have_posts() ) : ?>
					<div class="lodging-grid">
						<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content', 'business' ); endwhile; ?>
					</div>
					<nav class="pagination" aria-label="<?php esc_attr_e( 'Pagination', 'wp-sanktandreasberg' ); ?>" style="margin-top:24px">
						<?php the_posts_pagination( [ 'prev_text' => '‹', 'next_text' => '›' ] ); ?>
					</nav>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>

			<?php get_sidebar( 'directory' ); ?>
		</div>
	</section>

</main>

<?php get_footer(); ?>
