<?php
$lodging_query = new WP_Query( [
	'post_type'      => 'business',
	'posts_per_page' => 4,
	'post_status'    => 'publish',
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
] );
if ( ! $lodging_query->have_posts() ) return;
?>
<section id="lodging" class="section cream">
	<div class="wrap">
		<div class="section-head">
			<h2><?php esc_html_e( 'Unterkunft & Gastronomie', 'wp-sanktandreasberg' ); ?></h2>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'business' ) ); ?>">
				<?php esc_html_e( 'Alle Unterkünfte & Restaurants', 'wp-sanktandreasberg' ); ?> ›
			</a>
		</div>
		<div class="lodging-grid">
			<?php
			while ( $lodging_query->have_posts() ) :
				$lodging_query->the_post();
				get_template_part( 'template-parts/content', 'business' );
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
