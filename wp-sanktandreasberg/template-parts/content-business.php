<?php
$terms = get_the_terms( get_the_ID(), 'business_type' );
$term  = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
$phone = sab_meta( 'business_phone' );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card lodging' ); ?>>
	<div class="photo" style="background-image:url('<?php echo sab_thumbnail_url( null, 'sab-thumb' ); ?>')" role="img" aria-label="<?php the_title_attribute(); ?>"></div>
	<div class="card-body">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<?php if ( $term ) : ?>
			<div class="stars"><?php echo esc_html( $term->name ); ?></div>
		<?php endif; ?>
		<?php if ( get_the_excerpt() ) : ?>
			<p class="muted"><?php echo wp_trim_words( get_the_excerpt(), 12 ); ?></p>
		<?php endif; ?>
		<?php if ( $phone ) : ?>
			<p class="muted" style="margin-top:4px">☎ <?php echo esc_html( $phone ); ?></p>
		<?php endif; ?>
	</div>
</article>
