<?php
$hero_url = has_post_thumbnail() ? get_the_post_thumbnail_url( null, 'sab-hero' ) : '';
$style    = $hero_url ? ' style="--hero-image:url(' . esc_url( $hero_url ) . ')"' : '';
$label    = get_query_var( 'sab_hero_label', '' );
?>
<section class="category-hero"<?php echo $style; // phpcs:ignore ?>>
	<div class="category-hero__content">
		<?php if ( $label ) : ?>
			<span class="label"><?php echo esc_html( $label ); ?></span>
		<?php endif; ?>
		<h1><?php the_title(); ?></h1>
		<?php if ( has_excerpt() ) : ?>
			<p><?php the_excerpt(); ?></p>
		<?php endif; ?>
	</div>
</section>
