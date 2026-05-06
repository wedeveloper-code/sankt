<?php get_header(); ?>

<main id="main">
	<section class="category-hero">
		<div class="wrap">
			<div class="hero-content" style="padding:40px 0 36px">
				<?php sab_breadcrumb(); ?>
				<h1>
					<?php if ( get_search_query() ) : ?>
						<?php printf( esc_html__( 'Suchergebnisse für: %s', 'wp-sanktandreasberg' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?>
					<?php else : ?>
						<?php esc_html_e( 'Suche', 'wp-sanktandreasberg' ); ?>
					<?php endif; ?>
				</h1>
				<?php if ( have_posts() ) : global $wp_query; ?>
					<p><?php printf( esc_html( _n( '%s Ergebnis gefunden', '%s Ergebnisse gefunden', $wp_query->found_posts, 'wp-sanktandreasberg' ) ), number_format_i18n( $wp_query->found_posts ) ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<div class="wrap page-grid" style="padding-top:28px;padding-bottom:40px">
		<div>
			<?php if ( have_posts() ) : ?>
				<div class="category-news-grid">
					<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content' ); endwhile; ?>
				</div>
				<div style="margin-top:24px">
					<?php the_posts_pagination( [ 'prev_text' => '‹ ' . __( 'Zurück', 'wp-sanktandreasberg' ), 'next_text' => __( 'Weiter', 'wp-sanktandreasberg' ) . ' ›' ] ); ?>
				</div>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
				<div style="margin-top:24px">
					<?php get_search_form(); ?>
				</div>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>
