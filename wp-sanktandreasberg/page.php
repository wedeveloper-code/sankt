<?php get_header(); ?>

<main id="main">
	<?php get_template_part( 'template-parts/hero', 'inner' ); ?>

	<div class="wrap" style="padding-top:32px;padding-bottom:56px">
		<?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'article-body' ); ?>>
				<?php the_content(); ?>
				<?php
				wp_link_pages( [
					'before' => '<div class="page-links">' . __( 'Seiten:', 'wp-sanktandreasberg' ),
					'after'  => '</div>',
				] );
				?>
			</article>
		<?php endwhile; ?>
	</div>
</main>

<?php get_footer(); ?>
