<?php get_header(); ?>

<main id="main" class="cream">

	<?php while ( have_posts() ) : the_post(); ?>

	<?php
	$distance   = sab_meta( 'route_distance' );
	$duration   = sab_meta( 'route_duration' );
	$difficulty = sab_meta( 'route_difficulty' );
	$elevation  = sab_meta( 'route_elevation' );
	$thumb_url  = get_the_post_thumbnail_url( null, 'sab-hero' );
	$terms      = get_the_terms( get_the_ID(), 'activity_type' );
	$term       = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;

	$difficulty_label = $difficulty ? sab_difficulty_label( $difficulty ) : '';
	?>

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<a href="<?php echo esc_url( get_post_type_archive_link( 'route' ) ); ?>"><?php esc_html_e( 'Routen', 'wp-sanktandreasberg' ); ?></a> /
		<?php the_title(); ?>
	</div>

	<section class="wrap place-hero">
		<div class="place-hero__photo" <?php if ( $thumb_url ) : ?>style="background-image:url('<?php echo esc_url( $thumb_url ); ?>')"<?php endif; ?> role="img" aria-label="<?php the_title_attribute(); ?>"></div>
		<div class="place-hero__content">
			<?php if ( $term ) : ?><span class="label"><?php echo esc_html( $term->name ); ?></span><?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?><p><?php the_excerpt(); ?></p><?php endif; ?>
			<div class="hero-meta">
				<?php if ( $distance ) : ?><span>↟ <?php echo esc_html( $distance ); ?> km</span><?php endif; ?>
				<?php if ( $duration ) : ?><span>◷ <?php echo esc_html( $duration ); ?></span><?php endif; ?>
				<?php if ( $difficulty_label ) : ?><span>◎ <?php echo esc_html( $difficulty_label ); ?></span><?php endif; ?>
				<?php if ( $elevation ) : ?><span>⛰ <?php echo esc_html( $elevation ); ?> hm</span><?php endif; ?>
			</div>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="page-grid">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'card place-main' ); ?>>

				<?php if ( $distance || $duration || $difficulty || $elevation ) : ?>
				<div class="route-stats">
					<?php if ( $distance ) : ?>
					<div class="route-stat"><b><?php echo esc_html( $distance ); ?> km</b><span><?php esc_html_e( 'Länge', 'wp-sanktandreasberg' ); ?></span></div>
					<?php endif; ?>
					<?php if ( $duration ) : ?>
					<div class="route-stat"><b><?php echo esc_html( $duration ); ?></b><span><?php esc_html_e( 'Dauer', 'wp-sanktandreasberg' ); ?></span></div>
					<?php endif; ?>
					<?php if ( $elevation ) : ?>
					<div class="route-stat"><b><?php echo esc_html( $elevation ); ?> hm</b><span><?php esc_html_e( 'Höhenmeter', 'wp-sanktandreasberg' ); ?></span></div>
					<?php endif; ?>
					<?php if ( $difficulty_label ) : ?>
					<div class="route-stat"><b><?php echo esc_html( $difficulty_label ); ?></b><span><?php esc_html_e( 'Schwierigkeitsgrad', 'wp-sanktandreasberg' ); ?></span></div>
					<?php endif; ?>
				</div>
				<?php endif; ?>

				<div class="route-map" role="img" aria-label="<?php esc_attr_e( 'Routenkarte', 'wp-sanktandreasberg' ); ?>"></div>

				<div class="article-body">
					<?php the_content(); ?>
				</div>

				<div class="share" aria-label="<?php esc_attr_e( 'Teilen', 'wp-sanktandreasberg' ); ?>">
					<span style="font-weight:800;font-size:13px"><?php esc_html_e( 'Teilen:', 'wp-sanktandreasberg' ); ?></span>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer">f Facebook</a>
					<a href="mailto:?subject=<?php echo rawurlencode( get_the_title() ); ?>&body=<?php echo rawurlencode( get_permalink() ); ?>">✉ E-Mail</a>
					<a href="https://api.whatsapp.com/send?text=<?php echo urlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" rel="noopener noreferrer">☏ WhatsApp</a>
				</div>
			</article>

			<?php get_sidebar(); ?>
		</div>
	</section>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
