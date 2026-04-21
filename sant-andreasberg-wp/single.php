<?php get_header(); sa_breadcrumb(); ?>

<main id="main" role="main">
  <div class="container" style="padding-top:2.5rem;padding-bottom:3rem">
    <div class="content-sidebar">

      <?php while (have_posts()): the_post(); ?>
      <article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>

        <header class="entry-header">
          <?php
          $cats = get_the_category();
          if ($cats): ?>
            <div class="card-label" style="margin-bottom:.5rem">
              <a href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>">
                <?php echo esc_html($cats[0]->name); ?>
              </a>
            </div>
          <?php endif;
          $h1 = sa_get_custom_meta('h1');
          echo '<h1>' . esc_html($h1 ?: get_the_title()) . '</h1>';
          ?>
          <div class="entry-meta">
            <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
              <?php echo esc_html(get_the_date()); ?>
            </time>
            <?php
            $author = get_the_author();
            if ($author): ?>
              &bull; <?php echo esc_html($author); ?>
            <?php endif; ?>
          </div>
        </header>

        <?php if (has_post_thumbnail()): ?>
          <div class="entry-thumbnail">
            <?php the_post_thumbnail('sa-hero', ['loading' => 'lazy']); ?>
          </div>
        <?php endif; ?>

        <div class="entry-content">
          <?php the_content(); ?>
          <?php wp_link_pages(['before' => '<nav class="page-links">', 'after' => '</nav>']); ?>
        </div>

        <footer class="entry-footer" style="margin-top:2rem;padding-top:1rem;border-top:1px solid var(--color-border)">
          <?php
          $tags = get_the_tags();
          if ($tags):
              echo '<div style="font-size:.85rem;color:var(--color-text-light)">';
              echo esc_html__('Schlagwörter: ', 'sant-andreasberg');
              $tag_links = array_map(fn($t) => '<a href="' . esc_url(get_tag_link($t)) . '">' . esc_html($t->name) . '</a>', $tags);
              echo implode(', ', $tag_links);
              echo '</div>';
          endif;
          ?>
        </footer>

      </article>
      <?php endwhile; ?>

      <!-- Sidebar -->
      <aside class="sidebar" role="complementary">
        <?php
        if (is_active_sidebar('sidebar-main')) {
            dynamic_sidebar('sidebar-main');
        } else {
            /* Default sidebar: recent posts in same category */
            $cats = get_the_category();
            if ($cats):
                $related = new WP_Query([
                    'category__in'   => [$cats[0]->term_id],
                    'posts_per_page' => 5,
                    'post__not_in'   => [get_the_ID()],
                ]);
                if ($related->have_posts()): ?>
                  <div class="sidebar-widget">
                    <h3><?php printf(esc_html__('Mehr aus: %s', 'sant-andreasberg'), esc_html($cats[0]->name)); ?></h3>
                    <ul class="sidebar-links">
                      <?php while ($related->have_posts()): $related->the_post(); ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                      <?php endwhile; wp_reset_postdata(); ?>
                    </ul>
                  </div>
                <?php endif;
            endif;
        }
        ?>
      </aside>

    </div><!-- .content-sidebar -->
  </div>
</main>

<?php get_footer(); ?>
