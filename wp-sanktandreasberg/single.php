<?php get_header(); ?>

<main id="main" class="cream">

	<?php while ( have_posts() ) : the_post(); ?>

	<?php
	$cats      = get_the_category();
	$cat       = $cats ? $cats[0] : null;
	$thumb_url = get_the_post_thumbnail_url( null, 'sab-hero' );
	$tags      = get_the_tags();
	?>

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<a href="<?php echo esc_url( home_url( '/aktuelles/' ) ); ?>"><?php esc_html_e( 'Aktuelles', 'wp-sanktandreasberg' ); ?></a>
		<?php if ( $cat ) : ?> / <a href="<?php echo esc_url( get_term_link( $cat ) ); ?>"><?php echo esc_html( $cat->name ); ?></a><?php endif; ?>
	</div>

	<section class="wrap article-hero">
		<?php if ( $thumb_url ) : ?>
			<div class="article-hero__photo" style="background-image:url('<?php echo esc_url( $thumb_url ); ?>')" role="img" aria-label="<?php the_title_attribute(); ?>"></div>
		<?php else : ?>
			<div class="article-hero__photo" role="img" aria-label="<?php the_title_attribute(); ?>"></div>
		<?php endif; ?>
		<div class="article-hero__content">
			<?php if ( $cat ) : ?>
				<span class="label"><?php echo esc_html( $cat->name ); ?></span>
			<?php endif; ?>
			<h1><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p><?php the_excerpt(); ?></p>
			<?php endif; ?>
			<div class="hero-meta">
				<span>▣ <?php echo esc_html( get_the_date( 'd. F Y' ) ); ?></span>
				<?php $author = get_the_author(); if ( $author ) : ?>
					<span>● <?php echo esc_html( $author ); ?></span>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="page-grid">
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'card article-card' ); ?>>
				<div class="article-body">
					<?php the_content(); ?>
				</div>

				<?php if ( $tags ) : ?>
				<div class="tags">
					<?php foreach ( $tags as $tag ) : ?>
						<a href="<?php echo esc_url( get_tag_link( $tag ) ); ?>" class="tag"><?php echo esc_html( $tag->name ); ?></a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>

				<div class="share" aria-label="<?php esc_attr_e( 'Artikel teilen', 'wp-sanktandreasberg' ); ?>">
					<span style="font-weight:800;font-size:13px"><?php esc_html_e( 'Teilen:', 'wp-sanktandreasberg' ); ?></span>
					<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode( get_permalink() ); ?>" target="_blank" rel="noopener noreferrer">f Facebook</a>
					<a href="https://twitter.com/intent/tweet?url=<?php echo urlencode( get_permalink() ); ?>&text=<?php echo urlencode( get_the_title() ); ?>" target="_blank" rel="noopener noreferrer">𝕏 Twitter</a>
					<a href="mailto:?subject=<?php echo rawurlencode( get_the_title() ); ?>&body=<?php echo rawurlencode( get_permalink() ); ?>">✉ E-Mail</a>
					<a href="https://api.whatsapp.com/send?text=<?php echo urlencode( get_the_title() . ' ' . get_permalink() ); ?>" target="_blank" rel="noopener noreferrer">☏ WhatsApp</a>
				</div>

				<div class="article-nav">
					<?php
					$prev = get_previous_post();
					$next = get_next_post();
					?>
					<?php if ( $prev ) : ?>
						<a class="nav-card" href="<?php echo esc_url( get_permalink( $prev ) ); ?>">
							<span>‹ <?php esc_html_e( 'Vorheriger Artikel', 'wp-sanktandreasberg' ); ?></span>
							<strong><?php echo esc_html( get_the_title( $prev ) ); ?></strong>
						</a>
					<?php else : ?>
						<div class="nav-card nav-card--empty"></div>
					<?php endif; ?>
					<?php if ( $next ) : ?>
						<a class="nav-card" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
							<span><?php esc_html_e( 'Nächster Artikel', 'wp-sanktandreasberg' ); ?> ›</span>
							<strong><?php echo esc_html( get_the_title( $next ) ); ?></strong>
						</a>
					<?php endif; ?>
				</div>
			</article>

			<?php get_sidebar( 'news' ); ?>
		</div>
	</section>

	<?php
	$related = new WP_Query( [
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post__not_in'   => [ get_the_ID() ],
		'category__in'   => $cat ? [ $cat->term_id ] : [],
	] );
	if ( $related->have_posts() ) :
	?>
	<section class="wrap section">
		<div class="section-head">
			<h2><?php esc_html_e( 'Mehr aus Aktuelles', 'wp-sanktandreasberg' ); ?></h2>
			<a href="<?php echo esc_url( home_url( '/aktuelles/' ) ); ?>"><?php esc_html_e( 'Alle Meldungen', 'wp-sanktandreasberg' ); ?> ›</a>
		</div>
		<div class="related-grid">
			<?php
			while ( $related->have_posts() ) :
				$related->the_post();
				$rcats  = get_the_category();
				$rcat   = $rcats ? $rcats[0] : null;
				$rthumb = sab_thumbnail_url( null, 'sab-card' );
			?>
			<article class="card news-card">
				<div class="photo" style="background-image:url('<?php echo $rthumb; ?>')">
					<?php if ( $rcat ) : ?>
						<span class="label<?php echo $rcat->slug === 'veranstaltungen' ? ' yellow' : ''; ?>" style="position:absolute;top:10px;left:10px"><?php echo esc_html( $rcat->name ); ?></span>
					<?php endif; ?>
				</div>
				<div class="card-body">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
					<p class="muted"><?php echo esc_html( get_the_date( 'd. F Y' ) ); ?></p>
					<a class="link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Mehr lesen', 'wp-sanktandreasberg' ); ?> ›</a>
				</div>
			</article>
			<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</section>
	<?php endif; ?>

	<?php
	$upcoming = new WP_Query( [
		'post_type'      => 'event',
		'posts_per_page' => 4,
		'meta_key'       => 'event_date_start',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => [ [ 'key' => 'event_date_start', 'value' => date( 'Y-m-d' ), 'compare' => '>=', 'type' => 'DATE' ] ],
	] );
	if ( $upcoming->have_posts() ) :
	?>
	<section class="wrap section">
		<div class="section-head">
			<h2><?php esc_html_e( 'Top-Veranstaltungen', 'wp-sanktandreasberg' ); ?></h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>"><?php esc_html_e( 'Alle Veranstaltungen', 'wp-sanktandreasberg' ); ?> ›</a>
		</div>
		<div class="event-row">
			<?php while ( $upcoming->have_posts() ) : $upcoming->the_post(); get_template_part( 'template-parts/content', 'event' ); endwhile; wp_reset_postdata(); ?>
		</div>
	</section>
	<?php endif; ?>

	<?php endwhile; ?>

</main>

<?php get_footer(); ?>
