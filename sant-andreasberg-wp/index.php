<?php get_header(); sa_breadcrumb(); ?>

<main id="main" role="main">
  <div class="container" style="padding-top:2.5rem;padding-bottom:3rem">

    <header class="archive-header">
      <h1><?php esc_html_e('Neuigkeiten', 'sant-andreasberg'); ?></h1>
    </header>

    <?php if (have_posts()): ?>
      <div class="posts-grid">
        <?php while (have_posts()): the_post(); ?>
          <?php get_template_part('templates/card', 'post'); ?>
        <?php endwhile; ?>
      </div>
      <div class="pagination">
        <?php the_posts_pagination(['prev_text' => '&laquo; ' . __('Zurück', 'sant-andreasberg'), 'next_text' => __('Weiter', 'sant-andreasberg') . ' &raquo;']); ?>
      </div>
    <?php else: ?>
      <p><?php esc_html_e('Keine Beiträge gefunden.', 'sant-andreasberg'); ?></p>
    <?php endif; ?>

  </div>
</main>

<?php get_footer(); ?>
