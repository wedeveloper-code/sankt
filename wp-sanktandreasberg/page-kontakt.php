<?php
/*
 * Template Name: Kontakt
 */

$sent    = false;
$errors  = [];
$values  = [];

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset( $_POST['sab_contact_nonce'] ) ) {
	if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sab_contact_nonce'] ) ), 'sab_contact_form' ) ) {
		$errors[] = __( 'Sicherheitsfehler. Bitte versuchen Sie es erneut.', 'wp-sanktandreasberg' );
	} else {
		$values['name']    = sanitize_text_field( wp_unslash( $_POST['contact_name']    ?? '' ) );
		$values['email']   = sanitize_email(      wp_unslash( $_POST['contact_email']   ?? '' ) );
		$values['phone']   = sanitize_text_field( wp_unslash( $_POST['contact_phone']   ?? '' ) );
		$values['subject'] = sanitize_text_field( wp_unslash( $_POST['contact_subject'] ?? '' ) );
		$values['message'] = sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ?? '' ) );
		$values['privacy'] = isset( $_POST['contact_privacy'] );

		if ( empty( $values['name'] ) ) $errors[] = __( 'Bitte geben Sie Ihren Namen an.', 'wp-sanktandreasberg' );
		if ( ! is_email( $values['email'] ) ) $errors[] = __( 'Bitte geben Sie eine gültige E-Mail-Adresse an.', 'wp-sanktandreasberg' );
		if ( empty( $values['message'] ) ) $errors[] = __( 'Bitte schreiben Sie eine Nachricht.', 'wp-sanktandreasberg' );
		if ( ! $values['privacy'] ) $errors[] = __( 'Bitte stimmen Sie der Datenschutzerklärung zu.', 'wp-sanktandreasberg' );

		if ( empty( $errors ) ) {
			$to      = get_theme_mod( 'sab_ti_email', get_option( 'admin_email' ) );
			$subject = sprintf( '[Sankt Andreasberg] %s', $values['subject'] ?: __( 'Kontaktanfrage', 'wp-sanktandreasberg' ) );
			$body    = sprintf(
				"Name: %s\nE-Mail: %s\nTelefon: %s\n\n%s",
				$values['name'], $values['email'], $values['phone'], $values['message']
			);
			$headers = [ 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $values['email'] ];

			if ( wp_mail( $to, $subject, $body, $headers ) ) {
				$sent   = true;
				$values = [];
			} else {
				$errors[] = __( 'Nachricht konnte nicht gesendet werden. Bitte versuchen Sie es später erneut.', 'wp-sanktandreasberg' );
			}
		}
	}
}

get_header(); ?>

<main id="main" class="cream">

	<div class="wrap breadcrumb">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Startseite', 'wp-sanktandreasberg' ); ?></a> /
		<?php esc_html_e( 'Kontakt & Service', 'wp-sanktandreasberg' ); ?>
	</div>

	<?php
	$hero_img = get_the_post_thumbnail_url( get_the_ID(), 'full' )
		?: get_theme_mod( 'sab_hero_kontakt', '' )
		?: 'https://images.unsplash.com/photo-1500534314209-a25ddb2bd429?auto=format&fit=crop&w=2200&q=85';
	?>
	<section class="wrap inner-hero" style="--hero:url('<?php echo esc_url( $hero_img ); ?>')">
		<div class="inner-hero__content">
			<span class="label"><?php esc_html_e( 'Kontakt', 'wp-sanktandreasberg' ); ?></span>
			<h1><?php esc_html_e( 'Kontakt & Service', 'wp-sanktandreasberg' ); ?></h1>
			<p><?php esc_html_e( 'Wir helfen Ihnen gerne weiter – Tourist-Information, Stadtservice und wichtige Ansprechpartner auf einen Blick.', 'wp-sanktandreasberg' ); ?></p>
		</div>
	</section>

	<section class="wrap section" style="padding-top:0">
		<div class="page-grid">
			<div>
				<article class="card main-card">
					<h2><?php esc_html_e( 'Tourist-Information Sankt Andreasberg', 'wp-sanktandreasberg' ); ?></h2>
					<p><?php esc_html_e( 'Das Team der Tourist-Information berät Sie gerne zu Ihrem Aufenthalt, Ausflugstipps, Unterkünften, Veranstaltungen und Freizeitmöglichkeiten.', 'wp-sanktandreasberg' ); ?></p>
					<div class="stats-row">
						<?php if ( $phone = get_theme_mod( 'sab_ti_phone', '+49 5582 8033' ) ) : ?>
							<div class="mini-stat"><b>☎</b><span><?php echo esc_html( $phone ); ?></span></div>
						<?php endif; ?>
						<?php if ( $email = get_theme_mod( 'sab_ti_email', 'info@sankt-andreasberg.de' ) ) : ?>
							<div class="mini-stat"><b>✉</b><span><?php echo esc_html( $email ); ?></span></div>
						<?php endif; ?>
						<?php if ( $address = get_theme_mod( 'sab_ti_address', 'Am Kurpark 9, 37444 Sankt Andreasberg' ) ) : ?>
							<div class="mini-stat"><b>⌖</b><span><?php echo esc_html( $address ); ?></span></div>
						<?php endif; ?>
						<?php if ( $hours = get_theme_mod( 'sab_ti_hours', 'Mo–Fr 09–17 Uhr' ) ) : ?>
							<div class="mini-stat"><b>◷</b><span><?php echo esc_html( $hours ); ?></span></div>
						<?php endif; ?>
					</div>
				</article>

				<article class="card main-card" style="margin-top:14px">
					<h2><?php esc_html_e( 'Nachricht senden', 'wp-sanktandreasberg' ); ?></h2>

					<?php if ( $sent ) : ?>
						<div class="info-box" style="margin-bottom:0">
							<div class="info-icon">✓</div>
							<div>
								<h3><?php esc_html_e( 'Nachricht gesendet!', 'wp-sanktandreasberg' ); ?></h3>
								<p><?php esc_html_e( 'Vielen Dank für Ihre Nachricht. Wir melden uns so schnell wie möglich bei Ihnen.', 'wp-sanktandreasberg' ); ?></p>
							</div>
						</div>
					<?php else : ?>
						<?php if ( ! empty( $errors ) ) : ?>
							<div style="background:#fee;border:1px solid #fcc;border-radius:10px;padding:14px;margin-bottom:16px">
								<?php foreach ( $errors as $error ) : ?>
									<p style="margin:0 0 4px;color:#c00;font-size:14px">⚠ <?php echo esc_html( $error ); ?></p>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<form class="form" method="post" action="<?php the_permalink(); ?>">
							<?php wp_nonce_field( 'sab_contact_form', 'sab_contact_nonce' ); ?>
							<div class="form-grid">
								<input class="input" type="text" name="contact_name" placeholder="<?php esc_attr_e( 'Name *', 'wp-sanktandreasberg' ); ?>" value="<?php echo esc_attr( $values['name'] ?? '' ); ?>" required>
								<input class="input" type="email" name="contact_email" placeholder="<?php esc_attr_e( 'E-Mail *', 'wp-sanktandreasberg' ); ?>" value="<?php echo esc_attr( $values['email'] ?? '' ); ?>" required>
							</div>
							<div class="form-grid">
								<input class="input" type="tel" name="contact_phone" placeholder="<?php esc_attr_e( 'Telefon', 'wp-sanktandreasberg' ); ?>" value="<?php echo esc_attr( $values['phone'] ?? '' ); ?>">
								<input class="input" type="text" name="contact_subject" placeholder="<?php esc_attr_e( 'Betreff', 'wp-sanktandreasberg' ); ?>" value="<?php echo esc_attr( $values['subject'] ?? '' ); ?>">
							</div>
							<textarea class="input" name="contact_message" placeholder="<?php esc_attr_e( 'Ihre Nachricht *', 'wp-sanktandreasberg' ); ?>" rows="6" required><?php echo esc_textarea( $values['message'] ?? '' ); ?></textarea>
							<label>
								<input type="checkbox" name="contact_privacy" <?php checked( ! empty( $values['privacy'] ) ); ?> required>
								<?php
								printf(
									esc_html__( 'Ich habe die %s gelesen und stimme der Verarbeitung meiner Daten zu.', 'wp-sanktandreasberg' ),
									'<a href="' . esc_url( home_url( '/datenschutz/' ) ) . '">' . esc_html__( 'Datenschutzerklärung', 'wp-sanktandreasberg' ) . '</a>'
								);
								?>
							</label>
							<button class="btn btn-dark" type="submit"><?php esc_html_e( 'Nachricht senden', 'wp-sanktandreasberg' ); ?></button>
						</form>
					<?php endif; ?>
				</article>
			</div>

			<aside class="sidebar" aria-label="<?php esc_attr_e( 'Sidebar', 'wp-sanktandreasberg' ); ?>">
				<section class="card side-card">
					<h3><?php esc_html_e( 'Schnellkontakt', 'wp-sanktandreasberg' ); ?></h3>
					<div class="sidebar-list">
						<?php if ( $phone = get_theme_mod( 'sab_ti_phone', '+49 5582 8033' ) ) : ?>
							<span><b><?php esc_html_e( 'Telefon:', 'wp-sanktandreasberg' ); ?></b> <?php echo esc_html( $phone ); ?></span>
						<?php endif; ?>
						<?php if ( $email = get_theme_mod( 'sab_ti_email', 'info@sankt-andreasberg.de' ) ) : ?>
							<span><b><?php esc_html_e( 'E-Mail:', 'wp-sanktandreasberg' ); ?></b> <?php echo esc_html( $email ); ?></span>
						<?php endif; ?>
						<?php if ( $address = get_theme_mod( 'sab_ti_address', 'Am Kurpark 9, 37444 Sankt Andreasberg' ) ) : ?>
							<span><b><?php esc_html_e( 'Adresse:', 'wp-sanktandreasberg' ); ?></b> <?php echo esc_html( $address ); ?></span>
						<?php endif; ?>
					</div>
				</section>

				<section class="card side-card">
					<h3><?php esc_html_e( 'Öffnungszeiten', 'wp-sanktandreasberg' ); ?></h3>
					<div class="sidebar-list">
						<span><?php esc_html_e( 'Mo–Fr 09:00–17:00 Uhr', 'wp-sanktandreasberg' ); ?></span>
						<span><?php esc_html_e( 'Sa 10:00–14:00 Uhr', 'wp-sanktandreasberg' ); ?></span>
						<span><?php esc_html_e( 'So geschlossen', 'wp-sanktandreasberg' ); ?></span>
					</div>
				</section>

				<section class="card side-card">
					<h3><?php esc_html_e( 'Anfahrt', 'wp-sanktandreasberg' ); ?></h3>
					<div class="map-preview" role="img" aria-label="<?php esc_attr_e( 'Karte Tourist-Information', 'wp-sanktandreasberg' ); ?>"></div>
					<?php $anreise_url = get_theme_mod( 'sab_directions_url', '#' ); ?>
					<a class="link" style="margin-top:10px;display:block" href="<?php echo esc_url( $anreise_url ); ?>"><?php esc_html_e( 'Route planen', 'wp-sanktandreasberg' ); ?> →</a>
				</section>

				<section class="card side-card">
					<h3><?php esc_html_e( 'Weitere Ansprechpartner', 'wp-sanktandreasberg' ); ?></h3>
					<div class="sidebar-list">
						<a class="link" href="#"><?php esc_html_e( 'Stadtverwaltung', 'wp-sanktandreasberg' ); ?> →</a>
						<a class="link" href="#"><?php esc_html_e( 'Presse & Medien', 'wp-sanktandreasberg' ); ?> →</a>
						<a class="link" href="<?php echo esc_url( home_url( '/leben-vor-ort/' ) ); ?>"><?php esc_html_e( 'Bürgerservice', 'wp-sanktandreasberg' ); ?> →</a>
					</div>
				</section>
			</aside>
		</div>
	</section>

	<?php
	$img_aktuelles = get_theme_mod( 'sab_hero_aktuelles', '' ) ?: 'https://images.unsplash.com/photo-1585829365295-ab7cd400c167?auto=format&fit=crop&w=800&q=80';
	$img_events    = get_theme_mod( 'sab_hero_events',   '' ) ?: 'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?auto=format&fit=crop&w=800&q=80';
	$img_business  = get_theme_mod( 'sab_hero_business', '' ) ?: 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=800&q=80';
	$img_places    = get_theme_mod( 'sab_hero_places',   '' ) ?: 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?auto=format&fit=crop&w=800&q=80';
	?>
	<section class="wrap section">
		<div class="section-head">
			<h2><?php esc_html_e( 'Mehr entdecken', 'wp-sanktandreasberg' ); ?></h2>
		</div>
		<div class="tile-grid-4">
			<a class="card tile" href="<?php echo esc_url( home_url( '/aktuelles/' ) ); ?>">
				<div class="photo" style="background-image:url('<?php echo esc_url( $img_aktuelles ); ?>')"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Aktuelles', 'wp-sanktandreasberg' ); ?></h3><p class="muted"><?php esc_html_e( 'News & Mitteilungen', 'wp-sanktandreasberg' ); ?></p><span class="link"><?php esc_html_e( 'Lesen', 'wp-sanktandreasberg' ); ?> →</span></div>
			</a>
			<a class="card tile" href="<?php echo esc_url( get_post_type_archive_link( 'event' ) ); ?>">
				<div class="photo" style="background-image:url('<?php echo esc_url( $img_events ); ?>')"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Veranstaltungen', 'wp-sanktandreasberg' ); ?></h3><p class="muted"><?php esc_html_e( 'Alle Events & Termine', 'wp-sanktandreasberg' ); ?></p><span class="link"><?php esc_html_e( 'Entdecken', 'wp-sanktandreasberg' ); ?> →</span></div>
			</a>
			<a class="card tile" href="<?php echo esc_url( get_post_type_archive_link( 'business' ) ); ?>">
				<div class="photo" style="background-image:url('<?php echo esc_url( $img_business ); ?>')"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Unterkünfte', 'wp-sanktandreasberg' ); ?></h3><p class="muted"><?php esc_html_e( 'Hotels & Ferienwohnungen', 'wp-sanktandreasberg' ); ?></p><span class="link"><?php esc_html_e( 'Finden', 'wp-sanktandreasberg' ); ?> →</span></div>
			</a>
			<a class="card tile" href="<?php echo esc_url( get_post_type_archive_link( 'place' ) ); ?>">
				<div class="photo" style="background-image:url('<?php echo esc_url( $img_places ); ?>')"></div>
				<div class="card-body"><h3><?php esc_html_e( 'Sehenswürdigkeiten', 'wp-sanktandreasberg' ); ?></h3><p class="muted"><?php esc_html_e( 'Orte & Ausflüge', 'wp-sanktandreasberg' ); ?></p><span class="link"><?php esc_html_e( 'Entdecken', 'wp-sanktandreasberg' ); ?> →</span></div>
			</a>
		</div>
	</section>

</main>

<?php get_footer(); ?>
