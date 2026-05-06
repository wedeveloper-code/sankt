<?php get_header(); ?>

<main id="main">
	<?php get_template_part( 'template-parts/hero', 'inner' ); ?>
	<div class="wrap page-grid" style="padding-top:28px;padding-bottom:40px">
		<div>
			<?php if ( have_posts() ) : ?>
				<div class="category-news-grid" style="margin-bottom:28px">
					<?php while ( have_posts() ) : the_post(); get_template_part( 'template-parts/content' ); endwhile; ?>
				</div>
				<?php the_posts_pagination( [ 'prev_text' => '‹ ' . __( 'Zurück', 'wp-sanktandreasberg' ), 'next_text' => __( 'Weiter', 'wp-sanktandreasberg' ) . ' ›' ] ); ?>
			<?php else : ?>
				<?php get_template_part( 'template-parts/content', 'none' ); ?>
			<?php endif; ?>
		</div>
		<?php get_sidebar(); ?>
	</div>
</main>

<?php get_footer(); ?>
