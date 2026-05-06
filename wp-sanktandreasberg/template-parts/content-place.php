<?php
$terms = get_the_terms( get_the_ID(), 'place_category' );
$term  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card' ); ?>>
	<div class="photo" style="background-image:url('<?php echo sab_thumbnail_url( null, 'sab-card' ); ?>');height:168px" role="img" aria-label="<?php the_title_attribute(); ?>">
		<?php if ( $term ) : ?>
			<span class="label" style="position:absolute;top:10px;left:10px"><?php echo esc_html( $term->name ); ?></span>
		<?php endif; ?>
	</div>
	<div class="card-body">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( get_the_excerpt() ) : ?>
			<p class="muted"><?php echo wp_trim_words( get_the_excerpt(), 15 ); ?></p>
		<?php endif; ?>
		<?php if ( $addr = sab_meta( 'place_address' ) ) : ?>
			<div class="meta" style="margin-top:8px"><span>⌖ <?php echo esc_html( $addr ); ?></span></div>
		<?php endif; ?>
		<a class="link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Mehr erfahren', 'wp-sanktandreasberg' ); ?> ›</a>
	</div>
</article>
