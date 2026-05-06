<?php
$cats = get_the_category();
$cat  = $cats ? $cats[0] : null;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card news-card' ); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="photo" style="background-image:url('<?php echo sab_thumbnail_url( null, 'sab-card' ); ?>')" role="img" aria-label="<?php the_title_attribute(); ?>">
		<?php if ( $cat ) : ?>
			<span class="label" style="position:absolute;top:10px;left:10px"><?php echo esc_html( $cat->name ); ?></span>
		<?php endif; ?>
	</div>
	<?php endif; ?>
	<div class="card-body">
		<h3>
			<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</h3>
		<?php if ( get_the_excerpt() ) : ?>
			<p class="muted"><?php echo wp_trim_words( get_the_excerpt(), 18 ); ?></p>
		<?php endif; ?>
		<div class="card-date">
			<span><?php echo esc_html( get_the_date( 'd. F Y' ) ); ?></span>
		</div>
		<a class="link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Weiterlesen', 'wp-sanktandreasberg' ); ?> ›</a>
	</div>
</article>
