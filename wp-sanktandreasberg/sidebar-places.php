<aside class="sidebar" aria-label="<?php esc_attr_e( 'Seitenleiste Sehenswürdigkeiten', 'wp-sanktandreasberg' ); ?>">
	<?php if ( is_active_sidebar( 'sidebar-places' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-places' ); ?>
	<?php else : ?>
		<section class="card side-card">
			<h3><?php esc_html_e( 'Suche', 'wp-sanktandreasberg' ); ?></h3>
			<form class="search-box" role="search" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'place' ) ); ?>">
				<input type="search" name="s" placeholder="<?php esc_attr_e( 'Sehenswürdigkeit suchen …', 'wp-sanktandreasberg' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
				<button type="submit" aria-label="<?php esc_attr_e( 'Suchen', 'wp-sanktandreasberg' ); ?>">⌕</button>
			</form>
		</section>

		<?php
		$cats = get_terms( [ 'taxonomy' => 'place_category', 'hide_empty' => true ] );
		if ( ! is_wp_error( $cats ) && $cats ) : ?>
			<section class="card side-card">
				<h3><?php esc_html_e( 'Kategorien', 'wp-sanktandreasberg' ); ?></h3>
				<div class="topic-tags">
					<?php foreach ( $cats as $cat ) : ?>
						<a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<section class="card side-card">
			<h3><?php esc_html_e( 'Tourist-Information', 'wp-sanktandreasberg' ); ?></h3>
			<div class="contact-lines">
				<span>⌖ <?php echo esc_html( get_theme_mod( 'sab_ti_address', 'Am Kurpark 9, 37444 Sankt Andreasberg' ) ); ?></span>
				<span>☎ <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', get_theme_mod( 'sab_ti_phone', '+49 5582 8033' ) ) ); ?>"><?php echo esc_html( get_theme_mod( 'sab_ti_phone', '+49 5582 8033' ) ); ?></a></span>
			</div>
		</section>
	<?php endif; ?>
</aside>
