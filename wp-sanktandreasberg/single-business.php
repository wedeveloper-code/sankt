<?php get_header(); ?>

<main id="main" class="cream">

	<?php while ( have_posts() ) : the_post(); ?>

	<?php
	$address  = sab_meta( 'business_address' );
	$phone    = sab_meta( 'business_phone' );
	$email    = sab_meta( 'business_email' );
	$website  = sab_meta( 'business_website' );
	$hours    = sab_meta( 'business_opening_hours' );
	$terms    = get_the_terms( get_the_ID(), 'business_type' );
	$term     = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
	$thumb_url = get_the_post_thumbnail_url( null, 'sab-hero' );
	?>

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<a href="<?php echo esc_url( get_post_type_archive_link( 'business' ) ); ?>"><?php esc_html_e( 'Unterkunft & Gastronomie', 'wp-sanktandreasberg' ); ?></a> /
		<?php the_title(); ?>
	</div>

	<section class="wrap business-hero">
		<div class="business-hero__photo" <?php if ( $thumb_url ) : ?>style="background-image:url('<?php echo esc_url( $thumb_url ); ?>')"<?php endif; ?> role="img" aria-label="<?php the_title_attribute(); ?>"></div>
		<div class="business-hero__content">
			<?php if ( $term ) : ?><span class="label"><?php echo esc_html( $term->name ); ?></span><?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?><p><?php the_excerpt(); ?></p><?php endif; ?>
			<div class="hero-meta">
				<?php if ( $address ) : ?><span>⌖ <?php echo esc_html( $address ); ?></span><?php endif; ?>
				<?php if ( $phone ) : ?><span>☎ <?php echo esc_html( $phone ); ?></span><?php endif; ?>
			</div>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="page-grid">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'card place-main' ); ?>>
				<div class="article-body">
					<?php the_content(); ?>
				</div>

				<div class="share" aria-label="<?php esc_attr_e( 'Teilen', 'wp-sanktandreasberg' ); ?>">
					<span style="font-weight:800;font-size:13px"><?php esc_html_e( 'Teilen:', 'wp-sanktandreasberg' ); ?></span>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer">f Facebook</a>
					<a href="mailto:?subject=<?php echo rawurlencode( get_the_title() ); ?>&body=<?php echo rawurlencode( get_permalink() ); ?>">✉ E-Mail</a>
				</div>
			</article>

			<aside class="sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'wp-sanktandreasberg' ); ?>">
				<section class="card side-card">
					<h3><?php esc_html_e( 'Kontakt & Infos', 'wp-sanktandreasberg' ); ?></h3>
					<div class="sidebar-list">
						<strong><?php the_title(); ?></strong>
						<?php if ( $address ) : ?><span>⌖ <?php echo esc_html( $address ); ?></span><?php endif; ?>
						<?php if ( $phone ) : ?><span>☎ <a href="tel:<?php echo esc_attr( preg_replace( '/\s+/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></span><?php endif; ?>
						<?php if ( $email ) : ?><span>✉ <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></span><?php endif; ?>
						<?php if ( $hours ) : ?><span>◷ <?php echo esc_html( $hours ); ?></span><?php endif; ?>
						<?php if ( $website ) : ?><a class="btn btn-dark" href="<?php echo esc_url( $website ); ?>" target="_blank" rel="noopener noreferrer" style="margin-top:12px;width:100%;text-align:center"><?php esc_html_e( 'Zur Website', 'wp-sanktandreasberg' ); ?> ›</a><?php endif; ?>
					</div>
				</section>

				<?php if ( $address ) : ?>
				<section class="card side-card">
					<h3><?php esc_html_e( 'Lage', 'wp-sanktandreasberg' ); ?></h3>
					<div class="map-preview" role="img" aria-label="<?php esc_attr_e( 'Kartenansicht', 'wp-sanktandreasberg' ); ?>"></div>
					<div style="margin-top:12px">
						<a class="link" href="<?php echo esc_url( 'https://www.openstreetmap.org/search?query=' . urlencode( $address ) ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Route planen', 'wp-sanktandreasberg' ); ?> →</a>
					</div>
				</section>
				<?php endif; ?>

				<?php get_sidebar( 'directory' ); ?>
			</aside>
		</div>
	</section>

	<?php
	$related = new WP_Query( [
		'post_type'      => 'business',
		'posts_per_page' => 4,
		'post__not_in'   => [ get_the_ID() ],
		'tax_query'      => $term ? [ [ 'taxonomy' => 'business_type', 'field' => 'term_id', 'terms' => $term->term_id ] ] : [],
	] );
	if ( $related->have_posts() ) :
	?>
	<section class="wrap section">
		<div class="section-head">
			<h2><?php esc_html_e( 'Ähnliche Angebote', 'wp-sanktandreasberg' ); ?></h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'business' ) ); ?>"><?php esc_html_e( 'Alle anzeigen', 'wp-sanktandreasberg' ); ?> ›</a>
		</div>
		<div class="lodging-grid">
			<?php while ( $related->have_posts() ) : $related->the_post(); get_template_part( 'template-parts/content', 'business' ); endwhile; wp_reset_postdata(); ?>
		</div>
	</section>
	<?php endif; ?>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
