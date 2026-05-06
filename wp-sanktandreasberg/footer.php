<footer id="footer" class="footer" role="contentinfo">
	<div class="wrap footer-main">

		<!-- Newsletter column -->
		<div class="newsletter">
			<div class="newsletter-icon" aria-hidden="true">✉</div>
			<div>
				<h3><?php esc_html_e( 'Immer informiert bleiben', 'wp-sanktandreasberg' ); ?></h3>
				<p><?php esc_html_e( 'Abonnieren Sie unseren Newsletter und erhalten Sie aktuelle Nachrichten, Veranstaltungshinweise und Neuigkeiten aus Sankt Andreasberg.', 'wp-sanktandreasberg' ); ?></p>
				<p style="margin-top:14px">
					<a class="btn btn-white" href="<?php echo esc_url( get_theme_mod( 'sab_newsletter_url', '#' ) ); ?>">
						<?php esc_html_e( 'Zum Newsletter', 'wp-sanktandreasberg' ); ?> ›
					</a>
				</p>
			</div>
		</div>

		<!-- Quicklinks -->
		<div>
			<h4><?php esc_html_e( 'Quicklinks', 'wp-sanktandreasberg' ); ?></h4>
			<?php if ( has_nav_menu( 'footer_quicklinks' ) ) :
				wp_nav_menu( [
					'theme_location' => 'footer_quicklinks',
					'container'      => false,
					'menu_class'     => '',
				] );
			else : ?>
				<ul>
					<li><a href="<?php echo esc_url( home_url( '/aktuelles/' ) ); ?>"><?php esc_html_e( 'Aktuelles', 'wp-sanktandreasberg' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>"><?php esc_html_e( 'Veranstaltungen', 'wp-sanktandreasberg' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'place' ) ); ?>"><?php esc_html_e( 'Sehenswürdigkeiten', 'wp-sanktandreasberg' ); ?></a></li>
					<li><a href="<?php echo esc_url( get_post_type_archive_link( 'route' ) ); ?>"><?php esc_html_e( 'Wandern & Routen', 'wp-sanktandreasberg' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/erleben/' ) ); ?>"><?php esc_html_e( 'Erleben', 'wp-sanktandreasberg' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/geschichte/' ) ); ?>"><?php esc_html_e( 'Geschichte', 'wp-sanktandreasberg' ); ?></a></li>
				</ul>
			<?php endif; ?>
		</div>

		<!-- Service -->
		<div>
			<h4><?php esc_html_e( 'Service', 'wp-sanktandreasberg' ); ?></h4>
			<ul>
				<li><a href="<?php echo esc_url( home_url( '/kontakt/' ) ); ?>"><?php esc_html_e( 'Kontakt', 'wp-sanktandreasberg' ); ?></a></li>
				<li><a href="<?php echo esc_url( get_post_type_archive_link( 'business' ) ); ?>"><?php esc_html_e( 'Unterkunft & Gastronomie', 'wp-sanktandreasberg' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/leben-vor-ort/' ) ); ?>"><?php esc_html_e( 'Leben vor Ort', 'wp-sanktandreasberg' ); ?></a></li>
				<li><a href="<?php echo esc_url( get_theme_mod( 'sab_map_url', '#' ) ); ?>"><?php esc_html_e( 'Karte', 'wp-sanktandreasberg' ); ?></a></li>
				<li><a href="<?php echo esc_url( get_theme_mod( 'sab_directions_url', '#' ) ); ?>"><?php esc_html_e( 'Anreise', 'wp-sanktandreasberg' ); ?></a></li>
				<li><a href="<?php echo esc_url( get_theme_mod( 'sab_webcam_url', '#' ) ); ?>"><?php esc_html_e( 'Webcams', 'wp-sanktandreasberg' ); ?></a></li>
			</ul>
		</div>

		<!-- Kontakt -->
		<div>
			<h4><?php esc_html_e( 'Kontakt', 'wp-sanktandreasberg' ); ?></h4>
			<ul>
				<li><?php esc_html_e( 'Tourist-Information', 'wp-sanktandreasberg' ); ?></li>
				<?php
				$addr = get_theme_mod( 'sab_ti_address', 'Am Kurpark 9, 37444 Sankt Andreasberg' );
				if ( $addr ) echo '<li>' . esc_html( $addr ) . '</li>';
				$phone = get_theme_mod( 'sab_ti_phone', '+49 5582 8033' );
				if ( $phone ) echo '<li><a href="tel:' . esc_attr( preg_replace( '/\s+/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a></li>';
				$email = get_theme_mod( 'sab_ti_email', 'info@sant-andreasberg.de' );
				if ( $email ) echo '<li><a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a></li>';
				$hours = get_theme_mod( 'sab_ti_hours', '' );
				if ( $hours ) echo '<li>' . esc_html( $hours ) . '</li>';
				?>
			</ul>
		</div>

		<!-- Stadt-Info -->
		<div>
			<h4><?php esc_html_e( 'Sankt Andreasberg', 'wp-sanktandreasberg' ); ?></h4>
			<p><?php esc_html_e( '870 m ü. NN', 'wp-sanktandreasberg' ); ?><br>
			<?php esc_html_e( 'Landkreis Göttingen', 'wp-sanktandreasberg' ); ?><br>
			<?php esc_html_e( 'Niedersachsen', 'wp-sanktandreasberg' ); ?></p>
		</div>

	</div><!-- .footer-main -->

	<div class="wrap footer-bottom">
		<div>
			<?php
			$copyright = get_theme_mod( 'sab_footer_copyright', '' );
			echo $copyright ? esc_html( $copyright ) : '&copy; ' . esc_html( gmdate( 'Y' ) ) . ' ' . esc_html__( 'Stadt Sankt Andreasberg', 'wp-sanktandreasberg' );
			?>
		</div>
		<div class="footer-links">
			<?php if ( has_nav_menu( 'footer_legal' ) ) :
				wp_nav_menu( [
					'theme_location' => 'footer_legal',
					'container'      => false,
					'menu_class'     => 'footer-links',
				] );
			else : ?>
				<a href="<?php echo esc_url( home_url( '/impressum/' ) ); ?>"><?php esc_html_e( 'Impressum', 'wp-sanktandreasberg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/datenschutz/' ) ); ?>"><?php esc_html_e( 'Datenschutz', 'wp-sanktandreasberg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/barrierefreiheit/' ) ); ?>"><?php esc_html_e( 'Barrierefreiheit', 'wp-sanktandreasberg' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/sitemap/' ) ); ?>"><?php esc_html_e( 'Sitemap', 'wp-sanktandreasberg' ); ?></a>
			<?php endif; ?>
		</div>
	</div>

</footer>

<?php wp_footer(); ?>
</body>
</html>
