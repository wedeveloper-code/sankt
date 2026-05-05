<?php
defined('ABSPATH') || exit;

/* =============================================
   SITEMAP GENERATOR
   Admin menu: Tools → Sitemap
   ============================================= */

add_action('admin_menu', function () {
    add_management_page(
        __('Карта сайта', 'sant-andreasberg'),
        __('Карта сайта', 'sant-andreasberg'),
        'manage_options',
        'sa-sitemap',
        'sa_sitemap_admin_page'
    );
});

function sa_sitemap_admin_page(): void {
    $sitemap_path = ABSPATH . 'sitemap.xml';
    $exists = file_exists($sitemap_path);
    $last_gen = $exists ? date_i18n(get_option('date_format') . ' ' . get_option('time_format'), filemtime($sitemap_path)) : '';
    ?>
    <div class="wrap">
      <h1><?php esc_html_e('Управление Sitemap.xml', 'sant-andreasberg'); ?></h1>
      <p>
        <?php esc_html_e('Здесь вы можете создать и обновить файл sitemap.xml для вашего сайта.', 'sant-andreasberg'); ?>
      </p>

      <?php if ($exists): ?>
        <div class="notice notice-success inline">
          <p>
            <?php printf(
                esc_html__('Карта сайта создана. Обновлена: %s', 'sant-andreasberg'),
                '<strong>' . esc_html($last_gen) . '</strong>'
            ); ?>
            &mdash;
            <a href="<?php echo esc_url(home_url('/sitemap.xml')); ?>" target="_blank">
              <?php esc_html_e('Посмотреть карту сайта', 'sant-andreasberg'); ?>
            </a>
          </p>
        </div>
      <?php else: ?>
        <div class="notice notice-warning inline">
          <p><?php esc_html_e('Карта сайта ещё не создана.', 'sant-andreasberg'); ?></p>
        </div>
      <?php endif; ?>

      <p style="margin-top:1.5rem">
        <button
          id="sa-generate-sitemap"
          class="button button-primary button-large"
          data-label="<?php esc_attr_e('Обновить сейчас', 'sant-andreasberg'); ?>"
          data-loading="<?php esc_attr_e('Генерация…', 'sant-andreasberg'); ?>"
        >
          <?php esc_html_e('Обновить сейчас', 'sant-andreasberg'); ?>
        </button>
      </p>
      <p id="sa-sitemap-msg" style="font-weight:600;margin-top:.75rem"></p>

      <hr>
      <h2><?php esc_html_e('Содержимое карты сайта', 'sant-andreasberg'); ?></h2>
      <p><?php esc_html_e('В карту сайта включены:', 'sant-andreasberg'); ?></p>
      <ul style="list-style:disc;padding-left:1.5em">
        <li><?php esc_html_e('Главная страница (приоритет 1.0, ежедневно)', 'sant-andreasberg'); ?></li>
        <li><?php esc_html_e('Все опубликованные страницы (приоритет 0.8, ежемесячно)', 'sant-andreasberg'); ?></li>
        <li><?php esc_html_e('Все категории с записями (приоритет 0.9, еженедельно)', 'sant-andreasberg'); ?></li>
        <li><?php esc_html_e('Все опубликованные записи (приоритет 0.7, еженедельно)', 'sant-andreasberg'); ?></li>
      </ul>
    </div>

    <script>
    (function(){
      var btn = document.getElementById('sa-generate-sitemap');
      var msg = document.getElementById('sa-sitemap-msg');
      if(!btn) return;
      btn.addEventListener('click', function(){
        btn.disabled = true;
        btn.textContent = btn.dataset.loading;
        var fd = new FormData();
        fd.append('action', 'sa_generate_sitemap');
        fd.append('nonce', '<?php echo esc_js(wp_create_nonce('sa_generate_sitemap')); ?>');
        fetch('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', { method: 'POST', body: fd })
          .then(function(r){ return r.json(); })
          .then(function(d){
            msg.textContent = d.success ? (d.data || '<?php echo esc_js(__('Карта сайта успешно создана!', 'sant-andreasberg')); ?>') : ('Ошибка: ' + (d.data || '?'));
            msg.style.color = d.success ? 'green' : 'red';
            btn.disabled = false;
            btn.textContent = btn.dataset.label;
          })
          .catch(function(){
            msg.textContent = '<?php echo esc_js(__('Ошибка сети', 'sant-andreasberg')); ?>';
            msg.style.color = 'red';
            btn.disabled = false;
            btn.textContent = btn.dataset.label;
          });
      });
    })();
    </script>
    <?php
}

/* ---- AJAX handler ---- */
add_action('wp_ajax_sa_generate_sitemap', function () {
    check_ajax_referer('sa_generate_sitemap', 'nonce');
    if (!current_user_can('manage_options')) {
        wp_send_json_error(__('Нет доступа.', 'sant-andreasberg'));
    }
    $result = sa_build_sitemap();
    if ($result === true) {
        wp_send_json_success(__('Карта сайта успешно создана!', 'sant-andreasberg'));
    } else {
        wp_send_json_error($result);
    }
});

function sa_build_sitemap(): bool|string {
    $urls = [];

    /* Homepage */
    $urls[] = [
        'loc'        => home_url('/'),
        'lastmod'    => date('c'),
        'changefreq' => 'daily',
        'priority'   => '1.0',
    ];

    /* Static pages */
    $pages = get_posts([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'modified',
        'order'          => 'DESC',
    ]);
    foreach ($pages as $page) {
        if ((int) get_option('page_on_front') === $page->ID) continue;
        $urls[] = [
            'loc'        => get_permalink($page),
            'lastmod'    => get_the_modified_date('c', $page),
            'changefreq' => 'monthly',
            'priority'   => '0.8',
        ];
    }

    /* Categories with posts */
    $cats = get_categories(['hide_empty' => true]);
    foreach ($cats as $cat) {
        $urls[] = [
            'loc'        => get_category_link($cat->term_id),
            'lastmod'    => date('c'),
            'changefreq' => 'weekly',
            'priority'   => '0.9',
        ];
    }

    /* Posts */
    $posts = get_posts([
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        'orderby'        => 'modified',
        'order'          => 'DESC',
    ]);
    foreach ($posts as $post) {
        $urls[] = [
            'loc'        => get_permalink($post),
            'lastmod'    => get_the_modified_date('c', $post),
            'changefreq' => 'weekly',
            'priority'   => '0.7',
        ];
    }

    /* Build XML */
    $xml  = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
    foreach ($urls as $u) {
        $xml .= "\t<url>\n";
        $xml .= "\t\t<loc>" . esc_url(trailingslashit($u['loc'])) . "</loc>\n";
        $xml .= "\t\t<lastmod>" . esc_html($u['lastmod']) . "</lastmod>\n";
        $xml .= "\t\t<changefreq>" . esc_html($u['changefreq']) . "</changefreq>\n";
        $xml .= "\t\t<priority>" . esc_html($u['priority']) . "</priority>\n";
        $xml .= "\t</url>\n";
    }
    $xml .= '</urlset>';

    $path = ABSPATH . 'sitemap.xml';
    $written = file_put_contents($path, $xml);
    if ($written === false) {
        return __('Ошибка: не удалось записать файл. Проверьте права доступа на сервере.', 'sant-andreasberg');
    }
    return true;
}

/* Auto-regenerate sitemap on publish/update */
add_action('save_post', function (int $post_id, WP_Post $post) {
    if ($post->post_status === 'publish' && !wp_is_post_revision($post_id)) {
        sa_build_sitemap();
    }
}, 10, 2);

add_action('create_category', fn() => sa_build_sitemap());
add_action('edit_category', fn() => sa_build_sitemap());
add_action('delete_category', fn() => sa_build_sitemap());
