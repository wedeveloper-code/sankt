<?php get_header(); ?>

<main id="main" class="cream">

	<?php while ( have_posts() ) : the_post(); ?>

	<?php
	$date_str      = sab_meta( 'event_date_start' );
	$date_end_str  = sab_meta( 'event_date_end' );
	$ts            = $date_str ? strtotime( $date_str ) : false;
	$ts_end        = $date_end_str ? strtotime( $date_end_str ) : false;
	$date_range    = sab_format_date_range( $date_str, $date_end_str );
	$location      = sab_meta( 'event_location' );
	$price         = sab_meta( 'event_price' );
	$organizer     = sab_meta( 'event_organizer' );
	$reg_url       = sab_meta( 'event_registration_url' );
	$terms         = get_the_terms( get_the_ID(), 'event_category' );
	$term          = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
	$thumb_url     = get_the_post_thumbnail_url( null, 'sab-hero' );
	?>

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>"><?php esc_html_e( 'Veranstaltungen', 'wp-sanktandreasberg' ); ?></a> /
		<?php the_title(); ?>
	</div>

	<section class="wrap event-hero">
		<div class="event-hero__photo" <?php if ( $thumb_url ) : ?>style="background-image:url('<?php echo esc_url( $thumb_url ); ?>')"<?php endif; ?> role="img" aria-label="<?php the_title_attribute(); ?>"></div>
		<div class="event-hero__content">
			<?php if ( $term ) : ?><span class="label yellow"><?php echo esc_html( $term->name ); ?></span><?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?><p><?php the_excerpt(); ?></p><?php endif; ?>
			<div class="hero-meta">
				<?php if ( $date_range ) : ?>
					<span>▣ <?php echo esc_html( $date_range ); ?></span>
				<?php endif; ?>
				<?php if ( $ts ) : ?>
					<span>◷ <?php echo esc_html( date_i18n( 'H:i \U\h\r', $ts ) ); ?></span>
				<?php endif; ?>
				<?php if ( $location ) : ?><span>⌖ <?php echo esc_html( $location ); ?></span><?php endif; ?>
				<?php if ( $organizer ) : ?><span>● <?php echo esc_html( $organizer ); ?></span><?php endif; ?>
			</div>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="page-grid">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'card event-card-main' ); ?>>
				<div class="article-body">
					<?php the_content(); ?>
				</div>

				<?php
				$tags = get_the_terms( get_the_ID(), 'post_tag' );
				if ( $tags && ! is_wp_error( $tags ) ) :
				?>
				<div class="tags">
					<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_term_link( $tag ) ); ?>" class="tag"><?php echo esc_html( $tag->name ); ?></a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

				<div class="share" aria-label="<?php esc_attr_e( 'Teilen', 'wp-sanktandreasberg' ); ?>">
					<span style="font-weight:800;font-size:13px"><?php esc_html_e( 'Teilen:', 'wp-sanktandreasberg' ); ?></span>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer">f Facebook</a>
					<a href="mailto:?subject=<?php echo rawurlencode( get_the_title() ); ?>&body=<?php echo rawurlencode( get_permalink() ); ?>">✉ E-Mail</a>
					<a href="https://api.whatsapp.com/send?text=<?php echo urlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" rel="noopener noreferrer">☏ WhatsApp</a>
				</div>

				<div class="article-nav">
					<?php $prev = get_previous_post( true, '', 'event_category' ); $next = get_next_post( true, '', 'event_category' ); ?>
					<?php if ( $prev ) : ?>
						<a class="nav-card" href="<?php echo esc_url( get_permalink( $prev ) ); ?>"><span>‹ <?php esc_html_e( 'Vorherige', 'wp-sanktandreasberg' ); ?></span><strong><?php echo esc_html( get_the_title( $prev ) ); ?></strong></a>
					<?php else : ?><div class="nav-card nav-card--empty"></div><?php endif; ?>
					<?php if ( $next ) : ?>
						<a class="nav-card" href="<?php echo esc_url( get_permalink( $next ) ); ?>"><span><?php esc_html_e( 'Nächste', 'wp-sanktandreasberg' ); ?> ›</span><strong><?php echo esc_html( get_the_title( $next ) ); ?></strong></a>
					<?php endif; ?>
				</div>
			</article>

			<aside class="sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'wp-sanktandreasberg' ); ?>">
				<?php if ( $ts || $location || $price ) : ?>
				<section class="card side-card ticket-card">
					<h3><?php esc_html_e( 'Veranstaltungsdetails', 'wp-sanktandreasberg' ); ?></h3>
					<?php if ( $ts ) : ?>
					<div class="price-row">
						<span class="price-label">◷ <?php esc_html_e( 'Datum', 'wp-sanktandreasberg' ); ?></span>
						<span><?php echo esc_html( $date_range ?: sab_format_date( $date_str ) ); ?></span>
					</div>
					<div class="price-row">
						<span class="price-label">⌚ <?php esc_html_e( 'Uhrzeit', 'wp-sanktandreasberg' ); ?></span>
						<span><?php echo esc_html( date_i18n( 'H:i \U\h\r', $ts ) ); ?></span>
					</div>
					<?php if ( $ts_end ) : ?>
					<div class="price-row">
						<span class="price-label">⌚ <?php esc_html_e( 'Ende', 'wp-sanktandreasberg' ); ?></span>
						<span><?php echo esc_html( date_i18n( 'H:i \U\h\r', $ts_end ) ); ?></span>
					</div>
					<?php endif; ?>
					<?php endif; ?>
					<?php if ( $location ) : ?>
					<div class="price-row">
						<span class="price-label">⌖ <?php esc_html_e( 'Ort', 'wp-sanktandreasberg' ); ?></span>
						<span><?php echo esc_html( $location ); ?></span>
					</div>
					<?php endif; ?>
					<?php if ( $price ) : ?>
					<div class="price-row">
						<span class="price-label">€ <?php esc_html_e( 'Preis', 'wp-sanktandreasberg' ); ?></span>
						<span><?php echo esc_html( $price ); ?></span>
					</div>
					<?php endif; ?>
					<?php if ( $organizer ) : ?>
					<div class="price-row">
						<span class="price-label">● <?php esc_html_e( 'Veranstalter', 'wp-sanktandreasberg' ); ?></span>
						<span><?php echo esc_html( $organizer ); ?></span>
					</div>
					<?php endif; ?>
					<?php if ( $reg_url ) : ?>
						<a class="btn btn-gold" href="<?php echo esc_url( $reg_url ); ?>" target="_blank" rel="noopener noreferrer" style="margin-top:14px;width:100%;text-align:center"><?php esc_html_e( 'Jetzt anmelden', 'wp-sanktandreasberg' ); ?> ›</a>
					<?php endif; ?>
				</section>
				<?php endif; ?>

				<?php get_sidebar( 'events' ); ?>
			</aside>
		</div>
	</section>

	<?php
	$related = new WP_Query( [
		'post_type'      => 'event',
		'posts_per_page' => 4,
		'post__not_in'   => [ get_the_ID() ],
		'meta_key'       => 'event_date_start',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => [ [ 'key' => 'event_date_start', 'value' => date( 'Y-m-d' ), 'compare' => '>=', 'type' => 'DATE' ] ],
	] );
	if ( $related->have_posts() ) :
	?>
	<section class="wrap section">
		<div class="section-head">
			<h2><?php esc_html_e( 'Weitere Veranstaltungen', 'wp-sanktandreasberg' ); ?></h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>"><?php esc_html_e( 'Alle Veranstaltungen', 'wp-sanktandreasberg' ); ?> ›</a>
		</div>
		<div class="events-grid">
			<?php while ( $related->have_posts() ) : $related->the_post(); get_template_part( 'template-parts/content', 'event' ); endwhile; wp_reset_postdata(); ?>
		</div>
	</section>
	<?php endif; ?>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
