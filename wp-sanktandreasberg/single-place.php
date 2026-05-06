<?php get_header(); ?>

<main id="main" class="cream">

	<?php while ( have_posts() ) : the_post(); ?>

	<?php
	$address     = sab_meta( 'place_address' );
	$hours       = sab_meta( 'place_opening_hours' );
	$coords      = sab_meta( 'place_coordinates' );
	$entry_fee   = sab_meta( 'place_entry_fee' );
	$terms       = get_the_terms( get_the_ID(), 'place_category' );
	$term        = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
	$thumb_url   = get_the_post_thumbnail_url( null, 'sab-hero' );
	$tags        = get_the_tags();
	?>

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<a href="<?php echo esc_url( get_post_type_archive_link( 'place' ) ); ?>"><?php esc_html_e( 'Sehenswürdigkeiten', 'wp-sanktandreasberg' ); ?></a> /
		<?php the_title(); ?>
	</div>

	<section class="wrap place-hero">
		<div class="place-hero__photo" <?php if ( $thumb_url ) : ?>style="background-image:url('<?php echo esc_url( $thumb_url ); ?>')"<?php endif; ?> role="img" aria-label="<?php the_title_attribute(); ?>"></div>
		<div class="place-hero__content">
			<?php if ( $term ) : ?><span class="label yellow"><?php echo esc_html( $term->name ); ?></span><?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?><p><?php the_excerpt(); ?></p><?php endif; ?>
			<div class="hero-meta">
				<?php if ( $address ) : ?><span>⌖ <?php echo esc_html( $address ); ?></span><?php endif; ?>
				<?php if ( $hours ) : ?><span>◷ <?php echo esc_html( $hours ); ?></span><?php endif; ?>
				<span>● <?php esc_html_e( 'Familiengeeignet', 'wp-sanktandreasberg' ); ?></span>
			</div>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="page-grid">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'card place-main' ); ?>>
				<div class="article-body">
					<?php the_content(); ?>
				</div>

				<?php if ( $tags && ! is_wp_error( $tags ) ) : ?>
				<div class="tags">
					<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>" class="tag"><?php echo esc_html( $tag->name ); ?></a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

				<div class="share" aria-label="<?php esc_attr_e( 'Teilen', 'wp-sanktandreasberg' ); ?>">
					<span style="font-weight:800;font-size:13px"><?php esc_html_e( 'Teilen:', 'wp-sanktandreasberg' ); ?></span>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer">f Facebook</a>
					<a href="mailto:?subject=<?php echo rawurlencode( get_the_title() ); ?>&body=<?php echo rawurlencode( get_permalink() ); ?>">✉ E-Mail</a>
					<a href="https://api.whatsapp.com/send?text=<?php echo urlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" rel="noopener noreferrer">☏ WhatsApp</a>
				</div>
			</article>

			<aside class="sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'wp-sanktandreasberg' ); ?>">
				<?php if ( $address || $hours || $entry_fee ) : ?>
				<section class="card side-card">
					<h3><?php esc_html_e( 'Besuchsinformationen', 'wp-sanktandreasberg' ); ?></h3>
					<div class="sidebar-list">
						<?php if ( $term ) : ?><span><b><?php esc_html_e( 'Kategorie:', 'wp-sanktandreasberg' ); ?></b> <?php echo esc_html( $term->name ); ?></span><?php endif; ?>
						<?php if ( $entry_fee ) : ?><span><b><?php esc_html_e( 'Eintritt:', 'wp-sanktandreasberg' ); ?></b> <?php echo esc_html( $entry_fee ); ?></span><?php endif; ?>
						<?php if ( $hours ) : ?><span><b><?php esc_html_e( 'Öffnungszeiten:', 'wp-sanktandreasberg' ); ?></b> <?php echo esc_html( $hours ); ?></span><?php endif; ?>
					</div>
				</section>
				<?php endif; ?>

				<?php if ( $address ) : ?>
				<section class="card side-card">
					<h3><?php esc_html_e( 'Lage & Anfahrt', 'wp-sanktandreasberg' ); ?></h3>
					<div class="map-preview" role="img" aria-label="<?php esc_attr_e( 'Kartenansicht', 'wp-sanktandreasberg' ); ?>"></div>
					<div class="sidebar-list" style="margin-top:12px">
						<span><?php echo esc_html( $address ); ?></span>
						<?php
						$map_url = 'https://www.openstreetmap.org/search?query=' . urlencode( $address );
						?>
						<a class="link" href="<?php echo esc_url( $map_url ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Route planen', 'wp-sanktandreasberg' ); ?> →</a>
					</div>
				</section>
				<?php endif; ?>

				<?php get_sidebar( 'places' ); ?>
			</aside>
		</div>
	</section>

	<?php
	$related = new WP_Query( [
		'post_type'      => 'place',
		'posts_per_page' => 4,
		'post__not_in'   => [ get_the_ID() ],
		'tax_query'      => $term ? [ [ 'taxonomy' => 'place_category', 'field' => 'term_id', 'terms' => $term->term_id ] ] : [],
	] );
	if ( $related->have_posts() ) :
	?>
	<section class="wrap section">
		<div class="section-head">
			<h2><?php esc_html_e( 'Weitere Sehenswürdigkeiten', 'wp-sanktandreasberg' ); ?></h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'place' ) ); ?>"><?php esc_html_e( 'Alle Orte', 'wp-sanktandreasberg' ); ?> ›</a>
		</div>
		<div class="related-grid">
			<?php while ( $related->have_posts() ) : $related->the_post(); get_template_part( 'template-parts/content', 'place' ); endwhile; wp_reset_postdata(); ?>
		</div>
	</section>
	<?php endif; ?>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
