<?php if ( is_active_sidebar( 'sidebar-news' ) ) : ?>
<aside class="sidebar" aria-label="<?php esc_attr_e( 'Seitenleiste', 'wp-sanktandreasberg' ); ?>">
	<?php dynamic_sidebar( 'sidebar-news' ); ?>
</aside>
<?php endif; ?>
