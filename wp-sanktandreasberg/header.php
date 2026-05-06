<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="utility">
	<div class="wrap">
		<?php if ( has_nav_menu( 'utility' ) ) :
			wp_nav_menu( [
				'theme_location' => 'utility',
				'container'      => false,
				'menu_class'     => '',
				'link_before'    => '',
				'link_after'     => '',
			] );
		else : ?>
			<a href="<?php echo esc_url( get_theme_mod( 'sab_weather_url', '#' ) ); ?>">
				<span aria-hidden="true">☁</span> <?php esc_html_e( 'Wetter', 'wp-sanktandreasberg' ); ?>
			</a>
			<a href="<?php echo esc_url( get_theme_mod( 'sab_webcam_url', '#' ) ); ?>">
				<span aria-hidden="true">▣</span> <?php esc_html_e( 'Webcams', 'wp-sanktandreasberg' ); ?>
			</a>
			<a href="<?php echo esc_url( get_theme_mod( 'sab_map_url', '#' ) ); ?>">
				<span aria-hidden="true">⌖</span> <?php esc_html_e( 'Karte', 'wp-sanktandreasberg' ); ?>
			</a>
			<a href="<?php echo esc_url( get_theme_mod( 'sab_directions_url', '#' ) ); ?>">
				<span aria-hidden="true">⌂</span> <?php esc_html_e( 'Anreise', 'wp-sanktandreasberg' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/?s=' ) ); ?>" aria-label="<?php esc_attr_e( 'Suche', 'wp-sanktandreasberg' ); ?>">
				<span aria-hidden="true">⌕</span> <?php esc_html_e( 'Suche', 'wp-sanktandreasberg' ); ?>
			</a>
		<?php endif; ?>
	</div>
</div>

<header class="header" id="header" role="banner">
	<div class="wrap">

		<a class="brand" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ' ' . esc_html__( 'Startseite', 'wp-sanktandreasberg' ) ); ?>">
			<?php if ( has_custom_logo() ) :
				the_custom_logo();
			else : ?>
				<svg class="logo" viewBox="0 0 220 90" aria-hidden="true" focusable="false">
					<path d="M5 60 L47 27 L70 45 L102 15 L151 60" fill="none" stroke="currentColor" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
					<path d="M3 73 H210" stroke="currentColor" stroke-width="7" stroke-linecap="round"/>
					<path d="M130 66 V33 L150 18 L170 33 V66" fill="none" stroke="currentColor" stroke-width="6" stroke-linejoin="round"/>
					<path d="M150 18 V3" stroke="currentColor" stroke-width="6" stroke-linecap="round"/>
					<path d="M78 68 L91 37 L104 68 M38 69 L48 47 L58 69 M177 68 L190 41 L203 68" fill="none" stroke="currentColor" stroke-width="6" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
				<span class="brand-text">
					<strong><?php bloginfo( 'name' ); ?></strong>
					<span><?php bloginfo( 'description' ); ?></span>
				</span>
			<?php endif; ?>
		</a>

		<button
			class="menu-btn"
			aria-label="<?php esc_attr_e( 'Menü öffnen', 'wp-sanktandreasberg' ); ?>"
			aria-expanded="false"
			aria-controls="primary-navigation"
			type="button"
		>
			<span aria-hidden="true">☰</span>
		</button>

		<?php
		wp_nav_menu( [
			'theme_location'  => 'primary',
			'container'       => 'nav',
			'container_class' => 'nav',
			'container_id'    => 'primary-navigation',
			'menu_class'      => '',
			'fallback_cb'     => 'sab_fallback_nav',
		] );
		?>

	</div>
</header>

<?php
/**
 * Fallback navigation when no menu is assigned.
 */
function sab_fallback_nav(): void {
	echo '<nav class="nav" id="primary-navigation" aria-label="' . esc_attr__( 'Hauptnavigation', 'wp-sanktandreasberg' ) . '">';
	echo '<a ' . ( is_front_page() ? 'class="active"' : '' ) . ' href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Startseite', 'wp-sanktandreasberg' ) . '</a>';
	echo '<a href="' . esc_url( home_url( '/aktuelles/' ) ) . '">' . esc_html__( 'Aktuelles', 'wp-sanktandreasberg' ) . '</a>';
	echo '<a href="' . esc_url( get_post_type_archive_link( 'place' ) ) . '">' . esc_html__( 'Sehenswürdigkeiten', 'wp-sanktandreasberg' ) . '</a>';
	echo '<a href="' . esc_url( get_post_type_archive_link( 'event' ) ) . '">' . esc_html__( 'Veranstaltungen', 'wp-sanktandreasberg' ) . '</a>';
	echo '<a href="' . esc_url( get_post_type_archive_link( 'business' ) ) . '">' . esc_html__( 'Unterkunft & Gastronomie', 'wp-sanktandreasberg' ) . '</a>';
	echo '<a href="' . esc_url( home_url( '/kontakt/' ) ) . '">' . esc_html__( 'Kontakt', 'wp-sanktandreasberg' ) . '</a>';
	echo '</nav>';
}
