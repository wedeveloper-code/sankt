<?php get_header(); ?>

<main id="main" class="cream">

	<?php
	$cat         = get_queried_object();
	$cat_name    = $cat ? $cat->name : __( 'Aktuelles', 'wp-sanktandreasberg' );
	$cat_desc    = $cat ? $cat->description : '';
	$cat_url     = $cat ? get_term_link( $cat ) : home_url( '/aktuelles/' );
	$all_cats    = get_categories( [ 'hide_empty' => true ] );
	?>

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<?php if ( $cat && $cat->parent ) : ?>
			<a href="<?php echo esc_url( home_url( '/aktuelles/' ) ); ?>"><?php esc_html_e( 'Aktuelles', 'wp-sanktandreasberg' ); ?></a> /
		<?php endif; ?>
		<?php echo esc_html( $cat_name ); ?>
	</div>

	<?php
	$aktuelles_hero = get_theme_mod( 'sab_hero_aktuelles', '' )
		?: 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=2000&q=85';
	?>
	<section class="wrap category-hero" style="--hero-image:url('<?php echo esc_url( $aktuelles_hero ); ?>')">
		<div class="category-hero__content">
			<span class="label"><?php esc_html_e( 'News', 'wp-sanktandreasberg' ); ?></span>
			<h1><?php echo esc_html( $cat_name ); ?></h1>
			<?php if ( $cat_desc ) : ?>
				<p><?php echo esc_html( $cat_desc ); ?></p>
			<?php else : ?>
				<p><?php esc_html_e( 'Alle Neuigkeiten aus Sankt Andreasberg auf einen Blick.', 'wp-sanktandreasberg' ); ?></p>
			<?php endif; ?>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="toolbar">
			<div class="filters" aria-label="<?php esc_attr_e( 'Nachrichtenfilter', 'wp-sanktandreasberg' ); ?>">
				<a href="<?php echo esc_url( home_url( '/aktuelles/' ) ); ?>" class="filter-chip<?php echo ! is_category() || is_front_page() ? ' active' : ''; ?>">◼ <?php esc_html_e( 'Alle', 'wp-sanktandreasberg' ); ?></a>
				<?php foreach ( $all_cats as $c ) : ?>
					<a href="<?php echo esc_url( get_term_link( $c ) ); ?>" class="filter-chip<?php echo ( $cat && $cat->term_id === $c->term_id ) ? ' active' : ''; ?>">
						<?php echo esc_html( $c->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
			<div class="sortbar">
				<span><strong><?php esc_html_e( 'Ergebnisse:', 'wp-sanktandreasberg' ); ?></strong> <?php printf( esc_html( _n( '%s Meldung', '%s Meldungen', $cat ? $cat->count : 0, 'wp-sanktandreasberg' ) ), number_format_i18n( $cat ? $cat->count : 0 ) ); ?></span>
			</div>
		</div>

		<div class="page-grid">
			<div>
				<?php if ( have_posts() ) : ?>
					<?php
					$post_count = 0;
					while ( have_posts() ) :
						the_post();
						if ( $post_count === 0 ) :
							$cats  = get_the_category();
							$pcat  = $cats ? $cats[0] : null;
							$thumb = sab_thumbnail_url( null, 'sab-featured' );
					?>
					<article class="card category-featured">
						<div class="photo" style="background-image:url('<?php echo $thumb; ?>')">
							<?php if ( $pcat ) : ?>
								<span class="label" style="position:absolute;top:12px;left:12px"><?php echo esc_html( $pcat->name ); ?></span>
							<?php endif; ?>
							<div class="date-tile"><div><small><?php echo esc_html( strtoupper( get_the_date( 'M' ) ) ); ?></small><b><?php echo esc_html( get_the_date( 'd' ) ); ?></b></div></div>
						</div>
						<div class="card-body">
							<span class="label yellow"><?php esc_html_e( 'Top-Meldung', 'wp-sanktandreasberg' ); ?></span>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo wp_trim_words( get_the_excerpt(), 30 ); ?></p>
							<div class="meta">
								<span>▣ <?php echo esc_html( get_the_date( 'd. F Y' ) ); ?></span>
								<span>⌖ <?php esc_html_e( 'Sankt Andreasberg', 'wp-sanktandreasberg' ); ?></span>
							</div>
							<div style="margin-top:14px">
								<a class="link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Mehr lesen', 'wp-sanktandreasberg' ); ?> →</a>
							</div>
						</div>
					</article>
					<div class="category-news-grid">
					<?php else : ?>
						<?php
						$cats  = get_the_category();
						$pcat  = $cats ? $cats[0] : null;
						$thumb = sab_thumbnail_url( null, 'sab-card' );
						?>
						<article class="card news-card">
							<div class="photo" style="background-image:url('<?php echo $thumb; ?>')">
								<?php if ( $pcat ) : ?>
									<span class="label<?php echo ( $pcat->slug === 'stadt' ) ? ' red' : ( ( $pcat->slug === 'veranstaltungen' ) ? ' yellow' : '' ); ?>" style="position:absolute;top:10px;left:10px"><?php echo esc_html( $pcat->name ); ?></span>
								<?php endif; ?>
								<div class="date-tile"><div><small><?php echo esc_html( strtoupper( get_the_date( 'M' ) ) ); ?></small><b><?php echo esc_html( get_the_date( 'd' ) ); ?></b></div></div>
							</div>
							<div class="card-body">
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<p><?php echo wp_trim_words( get_the_excerpt(), 18 ); ?></p>
								<div class="meta"><span><?php echo esc_html( get_the_date( 'd. F Y' ) ); ?></span></div>
								<a class="link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Mehr lesen', 'wp-sanktandreasberg' ); ?> →</a>
							</div>
						</article>
					<?php endif; ?>
					<?php
						$post_count++;
					endwhile;
					if ( $post_count >= 1 ) echo '</div>'; // close category-news-grid
					?>

					<nav class="pagination" aria-label="<?php esc_attr_e( 'Pagination', 'wp-sanktandreasberg' ); ?>">
						<?php
						the_posts_pagination( [
							'prev_text'          => '‹',
							'next_text'          => '›',
							'before_page_number' => '',
						] );
						?>
					</nav>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>

			<?php get_sidebar( 'news' ); ?>
		</div>
	</section>

	<section class="wrap section">
		<div class="section-head">
			<h2><?php esc_html_e( 'Mehr entdecken', 'wp-sanktandreasberg' ); ?></h2>
		</div>
		<div class="discover-grid">
			<a class="card news-card" href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>">
				<div class="photo event" style="height:150px"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Veranstaltungen', 'wp-sanktandreasberg' ); ?></h3><p class="muted"><?php esc_html_e( 'Alle Events & Termine', 'wp-sanktandreasberg' ); ?></p><span class="link"><?php esc_html_e( 'Entdecken', 'wp-sanktandreasberg' ); ?> →</span></div>
			</a>
			<a class="card news-card" href="<?php echo esc_url( home_url( '/erleben/' ) ); ?>">
				<div class="photo forest" style="height:150px"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Erleben', 'wp-sanktandreasberg' ); ?></h3><p class="muted"><?php esc_html_e( 'Aktivitäten & Ausflugsziele', 'wp-sanktandreasberg' ); ?></p><span class="link"><?php esc_html_e( 'Entdecken', 'wp-sanktandreasberg' ); ?> →</span></div>
			</a>
			<a class="card news-card" href="<?php echo esc_url( get_post_type_archive_link( 'business' ) ); ?>">
				<div class="photo hotel" style="height:150px"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Unterkünfte', 'wp-sanktandreasberg' ); ?></h3><p class="muted"><?php esc_html_e( 'Übernachten & Wohlfühlen', 'wp-sanktandreasberg' ); ?></p><span class="link"><?php esc_html_e( 'Finden', 'wp-sanktandreasberg' ); ?> →</span></div>
			</a>
			<a class="card news-card" href="<?php echo esc_url( get_post_type_archive_link( 'business' ) ); ?>">
				<div class="photo gastro" style="height:150px"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Gastronomie', 'wp-sanktandreasberg' ); ?></h3><p class="muted"><?php esc_html_e( 'Essen & Genießen', 'wp-sanktandreasberg' ); ?></p><span class="link"><?php esc_html_e( 'Genießen', 'wp-sanktandreasberg' ); ?> →</span></div>
			</a>
		</div>
	</section>

</main>

<?php get_footer(); ?>
