<?php
$news_query = new WP_Query( [
	'post_type'      => 'post',
	'posts_per_page' => 6,
	'post_status'    => 'publish',
] );
if ( ! $news_query->have_posts() ) return;
?>
<section id="news" class="section cream">
	<div class="wrap">
		<div class="section-head">
			<h2><?php esc_html_e( 'Aktuelles', 'wp-sanktandreasberg' ); ?></h2>
			<a href="<?php echo esc_url( home_url( '/aktuelles/' ) ); ?>">
				<?php esc_html_e( 'Alle News anzeigen', 'wp-sanktandreasberg' ); ?> ›
			</a>
		</div>
		<div class="news-grid">
			<?php
			$count = 0;
			while ( $news_query->have_posts() ) :
				$news_query->the_post();
				$cats = get_the_category();
				$cat  = $cats ? $cats[0] : null;
				$thumb = sab_thumbnail_url( null, 'sab-card' );

				if ( $count === 0 ) : // Featured news
			?>
				<article class="card featured-news">
					<div class="photo" style="background-image:url('<?php echo $thumb; ?>')">
						<?php if ( $cat ) : ?>
							<span class="label" style="position:absolute;top:12px;left:12px"><?php echo esc_html( $cat->name ); ?></span>
						<?php endif; ?>
					</div>
					<div class="card-body">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<div class="card-date"><?php echo esc_html( get_the_date( 'd. F Y' ) ); ?></div>
						<p class="muted"><?php echo wp_trim_words( get_the_excerpt(), 20 ); ?></p>
						<a class="link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Weiterlesen', 'wp-sanktandreasberg' ); ?> ›</a>
					</div>
				</article>
			<?php else : // Regular news cards ?>
				<article class="card news-card">
					<div class="photo" style="background-image:url('<?php echo $thumb; ?>')">
						<?php if ( $cat ) : ?>
							<span class="label<?php echo $cat->slug === 'stadt' ? ' red' : ''; ?>" style="position:absolute;top:10px;left:10px">
								<?php echo esc_html( $cat->name ); ?>
							</span>
						<?php endif; ?>
					</div>
					<div class="card-body">
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<div class="card-date"><?php echo esc_html( get_the_date( 'd. F Y' ) ); ?></div>
					</div>
				</article>
			<?php
				endif;
				$count++;
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
