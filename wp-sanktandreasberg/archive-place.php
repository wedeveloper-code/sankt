<?php get_header(); ?>

<main id="main" class="cream">

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<?php esc_html_e( 'Sehenswürdigkeiten', 'wp-sanktandreasberg' ); ?>
	</div>

	<section class="wrap events-hero" style="background-image:none">
		<div class="events-hero__content">
			<span class="label"><?php esc_html_e( 'Entdecken', 'wp-sanktandreasberg' ); ?></span>
			<h1><?php esc_html_e( 'Sehenswürdigkeiten', 'wp-sanktandreasberg' ); ?></h1>
			<p><?php esc_html_e( 'Historische Stätten, Naturhighlights und besondere Orte in Sankt Andreasberg und im Oberharz.', 'wp-sanktandreasberg' ); ?></p>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="toolbar">
			<div class="filters" aria-label="<?php esc_attr_e( 'Kategorienfilter', 'wp-sanktandreasberg' ); ?>">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'place' ) ); ?>" class="filter-chip active">◼ <?php esc_html_e( 'Alle', 'wp-sanktandreasberg' ); ?></a>
				<?php
				$place_cats = get_terms( [ 'taxonomy' => 'place_category', 'hide_empty' => true ] );
				foreach ( $place_cats as $pcat ) :
				?>
					<a href="<?php echo esc_url( get_term_link( $pcat ) ); ?>" class="filter-chip"><?php echo esc_html( $pcat->name ); ?></a>
				<?php endforeach; ?>
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
							$terms    = get_the_terms( get_the_ID(), 'place_category' );
							$term     = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
							$thumb    = sab_thumbnail_url( null, 'sab-featured' );
							$location = sab_meta( 'place_address' );
							$first    = false;
					?>
					<article class="card featured-event">
						<div class="photo" style="background-image:url('<?php echo $thumb; ?>')">
							<?php if ( $term ) : ?><span class="label yellow" style="position:absolute;top:12px;left:12px"><?php echo esc_html( $term->name ); ?></span><?php endif; ?>
						</div>
						<div class="card-body">
							<?php if ( $term ) : ?><span class="label"><?php echo esc_html( $term->name ); ?></span><?php endif; ?>
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
							<p><?php echo wp_trim_words( get_the_excerpt(), 30 ); ?></p>
							<?php if ( $location ) : ?>
							<div class="event-meta">
								<span>⌖ <?php echo esc_html( $location ); ?></span>
							</div>
							<?php endif; ?>
							<div style="margin-top:14px">
								<a class="link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Mehr erfahren', 'wp-sanktandreasberg' ); ?> →</a>
							</div>
						</div>
					</article>
					<div class="place-grid">
					<?php else : ?>
						<?php get_template_part( 'template-parts/content', 'place' ); ?>
					<?php endif; ?>
					<?php endwhile; ?>
					</div>

					<nav class="pagination" aria-label="<?php esc_attr_e( 'Pagination', 'wp-sanktandreasberg' ); ?>">
						<?php the_posts_pagination( [ 'prev_text' => '‹', 'next_text' => '›' ] ); ?>
					</nav>
				<?php else : ?>
					<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<?php endif; ?>
			</div>

			<?php get_sidebar( 'places' ); ?>
		</div>
	</section>

</main>

<?php get_footer(); ?>
