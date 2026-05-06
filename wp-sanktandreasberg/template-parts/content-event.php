<?php
$date_str = sab_meta( 'event_date_start' );
$ts       = $date_str ? strtotime( $date_str ) : false;
$location = sab_meta( 'event_location' );
$price    = sab_meta( 'event_price' );
$terms    = get_the_terms( get_the_ID(), 'event_category' );
$term     = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0] : null;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'card event-card' ); ?>>
	<div class="photo" style="background-image:url('<?php echo sab_thumbnail_url( null, 'sab-card' ); ?>')" role="img" aria-label="<?php the_title_attribute(); ?>">
		<?php if ( $term ) : ?>
			<span class="label yellow" style="position:absolute;top:10px;left:10px"><?php echo esc_html( $term->name ); ?></span>
		<?php endif; ?>
		<?php if ( $ts ) : ?>
		<div class="date-badge" aria-label="<?php echo esc_attr( date_i18n( 'd. F', $ts ) ); ?>">
			<small><?php echo esc_html( strtoupper( date_i18n( 'M', $ts ) ) ); ?></small>
			<b><?php echo esc_html( date_i18n( 'd', $ts ) ); ?></b>
		</div>
		<?php endif; ?>
	</div>
	<div class="card-body">
		<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
		<div class="meta-list">
			<?php if ( $ts ) : ?>
				<span>◷ <?php echo esc_html( date_i18n( 'H:i \U\h\r', $ts ) ); ?></span>
			<?php endif; ?>
			<?php if ( $location ) : ?>
				<span>⌖ <?php echo esc_html( $location ); ?></span>
			<?php endif; ?>
			<?php if ( $price ) : ?>
				<span>€ <?php echo esc_html( $price ); ?></span>
			<?php endif; ?>
		</div>
		<a class="link" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Details', 'wp-sanktandreasberg' ); ?> ›</a>
	</div>
</article>
