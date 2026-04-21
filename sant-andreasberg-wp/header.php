<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="https://gmpg.org/xfn/11">
<?php
/* Custom meta description */
$meta_desc = sa_get_custom_meta('description');
if (!$meta_desc && is_singular()) {
    $meta_desc = wp_strip_all_tags(get_the_excerpt());
}
if ($meta_desc): ?>
<meta name="description" content="<?php echo esc_attr($meta_desc); ?>">
<?php endif; ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" role="banner">
  <div class="container">
    <div class="header-inner">

      <?php if (has_custom_logo()): ?>
        <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?>">
          <?php the_custom_logo(); ?>
        </a>
      <?php else: ?>
        <a class="site-logo" href="<?php echo esc_url(home_url('/')); ?>">
          <span><?php bloginfo('name'); ?></span>
        </a>
      <?php endif; ?>

      <button class="nav-toggle" aria-label="<?php esc_attr_e('Menü öffnen', 'sant-andreasberg'); ?>" aria-expanded="false" aria-controls="main-nav">
        <span></span><span></span><span></span>
      </button>

      <nav id="main-nav" aria-label="<?php esc_attr_e('Hauptnavigation', 'sant-andreasberg'); ?>">
        <?php
        wp_nav_menu([
            'theme_location' => 'primary',
            'menu_class'     => 'main-nav',
            'container'      => false,
            'fallback_cb'    => 'sa_default_menu',
        ]);
        ?>
      </nav>

    </div>
  </div>
</header>
