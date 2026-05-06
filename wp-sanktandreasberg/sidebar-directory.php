<aside class="sidebar" aria-label="<?php esc_attr_e( 'Seitenleiste Verzeichnis', 'wp-sanktandreasberg' ); ?>">
	<?php if ( is_active_sidebar( 'sidebar-directory' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-directory' ); ?>
	<?php else : ?>
		<section class="card side-card">
			<h3><?php esc_html_e( 'Anbieter suchen', 'wp-sanktandreasberg' ); ?></h3>
			<form class="search-box" role="search" method="get" action="<?php echo esc_url( get_post_type_archive_link( 'business' ) ); ?>">
				<input type="search" name="s" placeholder="<?php esc_attr_e( 'Hotel, Restaurant …', 'wp-sanktandreasberg' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
				<button type="submit" aria-label="<?php esc_attr_e( 'Suchen', 'wp-sanktandreasberg' ); ?>">⌕</button>
			</form>
		</section>

		<?php
		$types = get_terms( [ 'taxonomy' => 'business_type', 'hide_empty' => true ] );
		if ( ! is_wp_error( $types ) && $types ) : ?>
			<section class="card side-card">
				<h3><?php esc_html_e( 'Kategorien', 'wp-sanktandreasberg' ); ?></h3>
				<div class="topic-tags">
					<?php foreach ( $types as $type ) : ?>
						<a href="<?php echo esc_url( get_term_link( $type ) ); ?>"><?php echo esc_html( $type->name ); ?></a>
					<?php endforeach; ?>
				</div>
			</section>
		<?php endif; ?>

		<section class="card side-card">
			<h3><?php esc_html_e( 'Eintrag hinzufügen', 'wp-sanktandreasberg' ); ?></h3>
			<p class="muted"><?php esc_html_e( 'Ihr Betrieb ist noch nicht vertreten?', 'wp-sanktandreasberg' ); ?></p>
			<p style="margin-top:12px">
				<a class="btn btn-dark" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>" style="width:100%;justify-content:center">
					<?php esc_html_e( 'Jetzt eintragen', 'wp-sanktandreasberg' ); ?>
				</a>
			</p>
		</section>
	<?php endif; ?>
</aside>
