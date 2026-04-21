<?php get_header(); sa_breadcrumb(); ?>

<main id="main" role="main">
  <div class="container" style="padding-top:2.5rem;padding-bottom:3rem">

    <?php
    $use_sidebar = is_active_sidebar('sidebar-main');
    echo $use_sidebar ? '<div class="content-sidebar">' : '';
    ?>

    <article id="page-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
      <header class="entry-header">
        <?php
        $h1 = sa_get_custom_meta('h1');
        echo '<h1>' . esc_html($h1 ?: get_the_title()) . '</h1>';
        ?>
      </header>

      <?php if (has_post_thumbnail()): ?>
        <div class="entry-thumbnail">
          <?php the_post_thumbnail('sa-wide', ['loading' => 'lazy']); ?>
        </div>
      <?php endif; ?>

      <div class="entry-content">
        <?php the_content(); ?>
        <?php wp_link_pages(['before' => '<nav class="page-links">', 'after' => '</nav>']); ?>
      </div>
    </article>

    <?php if ($use_sidebar): ?>
      <aside class="sidebar" role="complementary">
        <?php dynamic_sidebar('sidebar-main'); ?>
      </aside>
    </div>
    <?php endif; ?>

  </div>
</main>

<?php get_footer(); ?>
