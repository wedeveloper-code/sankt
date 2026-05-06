<aside class="sidebar" aria-label="<?php esc_attr_e( 'Seitenleiste Aktuelles', 'wp-sanktandreasberg' ); ?>">
	<?php if ( is_active_sidebar( 'sidebar-news' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-news' ); ?>
	<?php else : ?>
		<section class="card side-card">
			<h3><?php esc_html_e( 'Nachrichten suchen', 'wp-sanktandreasberg' ); ?></h3>
			<form class="search-box" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<input class="search-field" type="search" name="s" placeholder="<?php esc_attr_e( 'Stichwort …', 'wp-sanktandreasberg' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
				<button type="submit" aria-label="<?php esc_attr_e( 'Suchen', 'wp-sanktandreasberg' ); ?>">⌕</button>
			</form>
		</section>

		<?php
		$cats = get_categories( [ 'hide_empty' => true ] );
		if ( $cats ) : ?>
		<section class="card side-card">
			<h3><?php esc_html_e( 'Kategorien', 'wp-sanktandreasberg' ); ?></h3>
			<div class="sidebar-list">
				<?php foreach ( $cats as $c ) : ?>
					<a class="link" href="<?php echo esc_url( get_category_link( $c ) ); ?>">
						<?php echo esc_html( $c->name ); ?>
						<span class="muted">(<?php echo absint( $c->count ); ?>)</span>
					</a>
				<?php endforeach; ?>
			</div>
		</section>
		<?php endif; ?>

		<section class="card side-card">
			<h3><?php esc_html_e( 'Neueste Meldungen', 'wp-sanktandreasberg' ); ?></h3>
			<?php
			$recent = new WP_Query( [
				'post_type'      => 'post',
				'posts_per_page' => 5,
				'post_status'    => 'publish',
			] );
			if ( $recent->have_posts() ) : ?>
			<div class="sidebar-list">
				<?php while ( $recent->have_posts() ) : $recent->the_post(); ?>
					<a class="link" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
			<?php endif; ?>
		</section>
	<?php endif; ?>
</aside>
