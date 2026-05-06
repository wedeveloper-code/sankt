<?php get_header(); ?>

<main id="main">
	<section class="section" style="padding:80px 0 100px;text-align:center">
		<div class="wrap">
			<div class="error-404">
				<div class="error-num" aria-hidden="true">404</div>
				<h1><?php esc_html_e( 'Seite nicht gefunden', 'wp-sanktandreasberg' ); ?></h1>
				<p class="muted" style="max-width:460px;margin:0 auto 28px"><?php esc_html_e( 'Die gewünschte Seite konnte nicht gefunden werden. Sie wurde möglicherweise verschoben oder gelöscht.', 'wp-sanktandreasberg' ); ?></p>
				<div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
					<a class="btn btn-gold" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Zur Startseite', 'wp-sanktandreasberg' ); ?></a>
					<a class="btn btn-green" href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>"><?php esc_html_e( 'Kontakt', 'wp-sanktandreasberg' ); ?></a>
				</div>
				<div style="margin-top:40px">
					<?php get_search_form(); ?>
				</div>
			</div>
		</div>
	</section>
</main>

<?php get_footer(); ?>
