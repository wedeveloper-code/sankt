<?php get_header(); sa_breadcrumb(); ?>

<main id="main" role="main">
  <div class="container" style="padding-top:2.5rem;padding-bottom:3rem">

    <header class="archive-header">
      <h1>
        <?php
        printf(
            esc_html__('Suchergebnisse für: %s', 'sant-andreasberg'),
            '<span>' . esc_html(get_search_query()) . '</span>'
        );
        ?>
      </h1>
      <?php get_search_form(); ?>
    </header>

    <?php if (have_posts()): ?>
      <div class="posts-grid" style="margin-top:2rem">
        <?php while (have_posts()): the_post(); ?>
          <?php get_template_part('templates/card', 'post'); ?>
        <?php endwhile; ?>
      </div>
      <div class="pagination">
        <?php the_posts_pagination(); ?>
      </div>
    <?php else: ?>
      <p style="margin-top:1.5rem">
        <?php esc_html_e('Keine Ergebnisse gefunden. Bitte versuchen Sie einen anderen Suchbegriff.', 'sant-andreasberg'); ?>
      </p>
    <?php endif; ?>

  </div>
</main>

<?php get_footer(); ?>
