<?php
defined( 'ABSPATH' ) || exit;

/* ══════════════════════════════════════════════════════════════
   Register post meta for REST API + type safety
══════════════════════════════════════════════════════════════ */
add_action( 'init', 'sab_register_post_meta' );

function sab_register_post_meta(): void {
	$auth = fn() => current_user_can( 'edit_posts' );

	/* Event fields */
	$event_fields = [
		'event_date_start'       => 'string',
		'event_date_end'         => 'string',
		'event_location'         => 'string',
		'event_price'            => 'string',
		'event_organizer'        => 'string',
		'event_registration_url' => 'string',
	];
	foreach ( $event_fields as $key => $type ) {
		register_post_meta( 'event', $key, [
			'type'              => $type,
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => $auth,
		] );
	}

	/* Place fields */
	$place_fields = [
		'place_address'       => 'string',
		'place_entry_fee'     => 'string',
		'place_coordinates'   => 'string',
	];
	foreach ( $place_fields as $key => $type ) {
		register_post_meta( 'place', $key, [
			'type'              => $type,
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => $auth,
		] );
	}
	register_post_meta( 'place', 'place_opening_hours', [
		'type'              => 'string',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'sanitize_textarea_field',
		'auth_callback'     => $auth,
	] );

	/* Route fields */
	foreach ( [ 'route_duration', 'route_difficulty' ] as $key ) {
		register_post_meta( 'route', $key, [
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => $auth,
		] );
	}
	foreach ( [ 'route_distance', 'route_elevation' ] as $key ) {
		register_post_meta( 'route', $key, [
			'type'              => 'number',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'absint',
			'auth_callback'     => $auth,
		] );
	}

	/* Business fields */
	foreach ( [ 'business_address', 'business_phone', 'business_email', 'business_website' ] as $key ) {
		register_post_meta( 'business', $key, [
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => $auth,
		] );
	}
	register_post_meta( 'business', 'business_opening_hours', [
		'type'              => 'string',
		'single'            => true,
		'show_in_rest'      => true,
		'sanitize_callback' => 'sanitize_textarea_field',
		'auth_callback'     => $auth,
	] );
}

/* ══════════════════════════════════════════════════════════════
   Register meta boxes
══════════════════════════════════════════════════════════════ */
add_action( 'add_meta_boxes', 'sab_add_meta_boxes' );

function sab_add_meta_boxes(): void {
	add_meta_box( 'sab_event_details', __( 'Veranstaltungsdetails', 'wp-sanktandreasberg' ), 'sab_render_event_meta_box', 'event', 'normal', 'high' );
	add_meta_box( 'sab_place_details', __( 'Informationen', 'wp-sanktandreasberg' ), 'sab_render_place_meta_box', 'place', 'normal', 'high' );
	add_meta_box( 'sab_route_details', __( 'Routendetails', 'wp-sanktandreasberg' ), 'sab_render_route_meta_box', 'route', 'normal', 'high' );
	add_meta_box( 'sab_business_details', __( 'Kontakt & Informationen', 'wp-sanktandreasberg' ), 'sab_render_business_meta_box', 'business', 'normal', 'high' );
}

/* ── Render helpers ──────────────────────────────────────── */
function sab_mb_field( string $label, string $name, string $value, string $type = 'text', string $placeholder = '' ): void {
	printf(
		'<p><label for="%1$s"><strong>%2$s</strong></label><br>
		<input type="%3$s" id="%1$s" name="%1$s" value="%4$s" placeholder="%5$s" style="width:100%%"></p>',
		esc_attr( $name ),
		esc_html( $label ),
		esc_attr( $type ),
		esc_attr( $value ),
		esc_attr( $placeholder )
	);
}

function sab_mb_textarea( string $label, string $name, string $value ): void {
	printf(
		'<p><label for="%1$s"><strong>%2$s</strong></label><br>
		<textarea id="%1$s" name="%1$s" rows="3" style="width:100%%">%3$s</textarea></p>',
		esc_attr( $name ),
		esc_html( $label ),
		esc_textarea( $value )
	);
}

/* ── Event meta box ─────────────────────────────────────── */
function sab_render_event_meta_box( \WP_Post $post ): void {
	wp_nonce_field( 'sab_event_meta', 'sab_event_nonce' );
	$id = $post->ID;
	sab_mb_field( __( 'Datum (Start)', 'wp-sanktandreasberg' ), 'event_date_start', sab_meta( 'event_date_start', $id ), 'date' );
	sab_mb_field( __( 'Datum (Ende)', 'wp-sanktandreasberg' ), 'event_date_end', sab_meta( 'event_date_end', $id ), 'date' );
	sab_mb_field( __( 'Veranstaltungsort', 'wp-sanktandreasberg' ), 'event_location', sab_meta( 'event_location', $id ), 'text', 'z.B. Kurhaus' );
	sab_mb_field( __( 'Eintrittspreis', 'wp-sanktandreasberg' ), 'event_price', sab_meta( 'event_price', $id ), 'text', 'z.B. 8 € / kostenlos' );
	sab_mb_field( __( 'Veranstalter', 'wp-sanktandreasberg' ), 'event_organizer', sab_meta( 'event_organizer', $id ) );
	sab_mb_field( __( 'Anmelde-URL', 'wp-sanktandreasberg' ), 'event_registration_url', sab_meta( 'event_registration_url', $id ), 'url' );
}

/* ── Place meta box ─────────────────────────────────────── */
function sab_render_place_meta_box( \WP_Post $post ): void {
	wp_nonce_field( 'sab_place_meta', 'sab_place_nonce' );
	$id = $post->ID;
	sab_mb_field( __( 'Adresse', 'wp-sanktandreasberg' ), 'place_address', sab_meta( 'place_address', $id ) );
	sab_mb_textarea( __( 'Öffnungszeiten', 'wp-sanktandreasberg' ), 'place_opening_hours', sab_meta( 'place_opening_hours', $id ) );
	sab_mb_field( __( 'Koordinaten (lat,lng)', 'wp-sanktandreasberg' ), 'place_coordinates', sab_meta( 'place_coordinates', $id ), 'text', '51.6547,10.5269' );
	sab_mb_field( __( 'Eintrittspreis', 'wp-sanktandreasberg' ), 'place_entry_fee', sab_meta( 'place_entry_fee', $id ), 'text', 'z.B. 5 € Erwachsene' );
}

/* ── Route meta box ─────────────────────────────────────── */
function sab_render_route_meta_box( \WP_Post $post ): void {
	wp_nonce_field( 'sab_route_meta', 'sab_route_nonce' );
	$id = $post->ID;
	sab_mb_field( __( 'Länge (km)', 'wp-sanktandreasberg' ), 'route_distance', sab_meta( 'route_distance', $id ), 'number' );
	sab_mb_field( __( 'Dauer', 'wp-sanktandreasberg' ), 'route_duration', sab_meta( 'route_duration', $id ), 'text', 'z.B. 2–3 Std.' );
	echo '<p><label><strong>' . esc_html__( 'Schwierigkeitsgrad', 'wp-sanktandreasberg' ) . '</strong></label><br>';
	echo '<select name="route_difficulty" style="width:100%">';
	$diff = sab_meta( 'route_difficulty', $id );
	foreach ( [ '' => '– wählen –', 'easy' => 'Leicht', 'medium' => 'Mittel', 'hard' => 'Schwer' ] as $v => $l ) {
		printf( '<option value="%s"%s>%s</option>', esc_attr( $v ), selected( $diff, $v, false ), esc_html( $l ) );
	}
	echo '</select></p>';
	sab_mb_field( __( 'Höhenunterschied (m)', 'wp-sanktandreasberg' ), 'route_elevation', sab_meta( 'route_elevation', $id ), 'number' );
}

/* ── Business meta box ──────────────────────────────────── */
function sab_render_business_meta_box( \WP_Post $post ): void {
	wp_nonce_field( 'sab_business_meta', 'sab_business_nonce' );
	$id = $post->ID;
	sab_mb_field( __( 'Adresse', 'wp-sanktandreasberg' ), 'business_address', sab_meta( 'business_address', $id ) );
	sab_mb_field( __( 'Telefon', 'wp-sanktandreasberg' ), 'business_phone', sab_meta( 'business_phone', $id ), 'tel' );
	sab_mb_field( __( 'E-Mail', 'wp-sanktandreasberg' ), 'business_email', sab_meta( 'business_email', $id ), 'email' );
	sab_mb_field( __( 'Website', 'wp-sanktandreasberg' ), 'business_website', sab_meta( 'business_website', $id ), 'url' );
	sab_mb_textarea( __( 'Öffnungszeiten', 'wp-sanktandreasberg' ), 'business_opening_hours', sab_meta( 'business_opening_hours', $id ) );
}

/* ══════════════════════════════════════════════════════════════
   Save meta box data
══════════════════════════════════════════════════════════════ */
add_action( 'save_post_event', 'sab_save_event_meta' );
function sab_save_event_meta( int $post_id ): void {
	if ( ! isset( $_POST['sab_event_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sab_event_nonce'] ) ), 'sab_event_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	foreach ( [ 'event_date_start', 'event_date_end', 'event_location', 'event_price', 'event_organizer', 'event_registration_url' ] as $f ) {
		if ( isset( $_POST[ $f ] ) ) update_post_meta( $post_id, $f, sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) );
	}
}

add_action( 'save_post_place', 'sab_save_place_meta' );
function sab_save_place_meta( int $post_id ): void {
	if ( ! isset( $_POST['sab_place_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sab_place_nonce'] ) ), 'sab_place_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	foreach ( [ 'place_address', 'place_coordinates', 'place_entry_fee' ] as $f ) {
		if ( isset( $_POST[ $f ] ) ) update_post_meta( $post_id, $f, sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) );
	}
	if ( isset( $_POST['place_opening_hours'] ) ) {
		update_post_meta( $post_id, 'place_opening_hours', sanitize_textarea_field( wp_unslash( $_POST['place_opening_hours'] ) ) );
	}
}

add_action( 'save_post_route', 'sab_save_route_meta' );
function sab_save_route_meta( int $post_id ): void {
	if ( ! isset( $_POST['sab_route_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sab_route_nonce'] ) ), 'sab_route_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	foreach ( [ 'route_duration', 'route_difficulty' ] as $f ) {
		if ( isset( $_POST[ $f ] ) ) update_post_meta( $post_id, $f, sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) );
	}
	foreach ( [ 'route_distance', 'route_elevation' ] as $f ) {
		if ( isset( $_POST[ $f ] ) ) update_post_meta( $post_id, $f, absint( $_POST[ $f ] ) );
	}
}

add_action( 'save_post_business', 'sab_save_business_meta' );
function sab_save_business_meta( int $post_id ): void {
	if ( ! isset( $_POST['sab_business_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sab_business_nonce'] ) ), 'sab_business_meta' ) ) return;
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;
	foreach ( [ 'business_address', 'business_phone', 'business_email', 'business_website' ] as $f ) {
		if ( isset( $_POST[ $f ] ) ) update_post_meta( $post_id, $f, sanitize_text_field( wp_unslash( $_POST[ $f ] ) ) );
	}
	if ( isset( $_POST['business_opening_hours'] ) ) {
		update_post_meta( $post_id, 'business_opening_hours', sanitize_textarea_field( wp_unslash( $_POST['business_opening_hours'] ) ) );
	}
}
