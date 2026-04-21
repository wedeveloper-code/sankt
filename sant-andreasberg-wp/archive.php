<?php get_header(); sa_breadcrumb(); ?>

<main id="main" role="main">
  <div class="container">

    <header class="archive-header">
      <h1><?php the_archive_title(); ?></h1>
      <?php the_archive_description('<div class="lead">', '</div>'); ?>
    </header>

    <?php if (have_posts()): ?>
      <div class="posts-grid">
        <?php while (have_posts()): the_post(); ?>
          <?php get_template_part('templates/card', 'post'); ?>
        <?php endwhile; ?>
      </div>
      <div class="pagination">
        <?php echo paginate_links(['prev_text' => '&laquo;', 'next_text' => '&raquo;']); ?>
      </div>
    <?php else: ?>
      <p><?php esc_html_e('Keine Beiträge gefunden.', 'sant-andreasberg'); ?></p>
    <?php endif; ?>

  </div>
</main>

<?php get_footer(); ?>
