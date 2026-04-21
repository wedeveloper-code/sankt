<article class="card" id="post-<?php the_ID(); ?>">
  <a href="<?php the_permalink(); ?>" class="card-img" tabindex="-1" aria-hidden="true">
    <img
      src="<?php echo esc_url(sa_the_post_thumbnail_url('sa-card')); ?>"
      alt="<?php echo esc_attr(get_the_title()); ?>"
      loading="lazy"
      width="640" height="360"
    >
  </a>
  <div class="card-body">
    <?php $cats = get_the_category(); if ($cats): ?>
      <div class="card-label">
        <a href="<?php echo esc_url(get_category_link($cats[0]->term_id)); ?>">
          <?php echo esc_html($cats[0]->name); ?>
        </a>
      </div>
    <?php endif; ?>
    <h3 class="card-title">
      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </h3>
    <p class="card-excerpt"><?php the_excerpt(); ?></p>
    <div class="entry-meta">
      <time datetime="<?php echo esc_attr(get_the_date('c')); ?>">
        <?php echo esc_html(get_the_date()); ?>
      </time>
    </div>
    <a href="<?php the_permalink(); ?>" class="card-link">
      <?php esc_html_e('Weiterlesen', 'sant-andreasberg'); ?>
    </a>
  </div>
</article>
