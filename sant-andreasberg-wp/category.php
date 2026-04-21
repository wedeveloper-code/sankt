<?php get_header(); sa_breadcrumb(); ?>

<main id="main" role="main">
  <div class="container">

    <header class="archive-header">
      <?php
      $h1 = sa_get_custom_meta('h1');
      if ($h1): ?>
        <h1><?php echo esc_html($h1); ?></h1>
      <?php else: ?>
        <h1><?php single_cat_title(); ?></h1>
      <?php endif;

      $desc = sa_get_custom_meta('description');
      if (!$desc) $desc = category_description();
      if ($desc): ?>
        <p class="lead"><?php echo wp_kses_post($desc); ?></p>
      <?php endif; ?>
    </header>

    <?php if (have_posts()): ?>
      <div class="posts-grid">
        <?php while (have_posts()): the_post(); ?>
          <?php get_template_part('templates/card', 'post'); ?>
        <?php endwhile; ?>
      </div>

      <div class="pagination">
        <?php
        echo paginate_links([
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
            'type'      => 'list',
        ]);
        ?>
      </div>

    <?php else: ?>
      <p><?php esc_html_e('Keine Beiträge gefunden.', 'sant-andreasberg'); ?></p>
    <?php endif; ?>

  </div>
</main>

<?php get_footer(); ?>
