<?php
defined('ABSPATH') || exit;

/* =============================================
   IMAGE IMPORT: uploads content images from
   assets/images/content/ to the WP media
   library and sets them as post thumbnails.
   ============================================= */

function sa_import_images(): array {
    require_once ABSPATH . 'wp-admin/includes/image.php';
    require_once ABSPATH . 'wp-admin/includes/file.php';
    require_once ABSPATH . 'wp-admin/includes/media.php';

    $mapping = [
        /* Posts */
        ['slug' => 'ski-slopes',      'type' => 'post',  'image' => 'blick-msb.jpg',             'title' => 'Skigebiet am Matthias-Schmidt-Berg'],
        ['slug' => 'ski-trails',      'type' => 'post',  'image' => 'nordisch.jpg',               'title' => 'Nordisches Skifahren in Sankt Andreasberg'],
        ['slug' => 'sledding',        'type' => 'post',  'image' => 'rodeln3.jpg',                'title' => 'Rodeln in Sankt Andreasberg'],
        ['slug' => 'winter-hiking',   'type' => 'post',  'image' => 'winterwanderung1.jpg',       'title' => 'Winterwanderung im Nationalpark Harz'],
        ['slug' => 'hiking',          'type' => 'post',  'image' => 'jordanshoehe.jpg',           'title' => 'Wandern auf der Jordanshöhe'],
        ['slug' => 'mountain-biking', 'type' => 'post',  'image' => 'bike-beerberg.jpg',          'title' => 'Mountainbiking am Beerberg'],
        ['slug' => 'nordic-walking',  'type' => 'post',  'image' => 'blick-vom-glockenberg.jpg',  'title' => 'Blick vom Glockenberg'],
        ['slug' => 'adventure',       'type' => 'post',  'image' => 'hochseil1.jpg',              'title' => 'Hochseilgarten in Sankt Andreasberg'],
        /* Pages */
        ['slug' => 'about-sankt-andreasberg', 'type' => 'page', 'image' => 'rathaus.jpg',        'title' => 'Rathaus Sankt Andreasberg'],
        ['slug' => 'history',         'type' => 'page',  'image' => 'samson2003.jpg',             'title' => 'Grube Samson – UNESCO-Welterbe'],
        ['slug' => 'winter',          'type' => 'page',  'image' => 'winter-bank.jpg',            'title' => 'Winter in Sankt Andreasberg'],
        ['slug' => 'summer',          'type' => 'page',  'image' => 'kuhaustrieb.jpg',            'title' => 'Sommer im Nationalpark Harz'],
        ['slug' => 'sights',          'type' => 'page',  'image' => 'glockenturm.jpg',            'title' => 'Glockenturm in Sankt Andreasberg'],
    ];

    $results = ['ok' => 0, 'skip' => 0, 'error' => []];

    foreach ($mapping as $item) {
        $post = ($item['type'] === 'post')
            ? get_page_by_path($item['slug'], OBJECT, 'post')
            : get_page_by_path($item['slug']);

        if (!$post) {
            $results['skip']++;
            continue;
        }

        /* Skip if thumbnail already set */
        if (has_post_thumbnail($post->ID)) {
            $results['skip']++;
            continue;
        }

        $src = SA_DIR . '/assets/images/content/' . $item['image'];
        if (!file_exists($src)) {
            $results['error'][] = $item['image'] . ': file not found';
            continue;
        }

        $attach_id = sa_attach_image_to_post($src, $post->ID, $item['title']);
        if ($attach_id) {
            set_post_thumbnail($post->ID, $attach_id);
            $results['ok']++;
        } else {
            $results['error'][] = $item['image'] . ': upload failed';
        }
    }

    return $results;
}

function sa_attach_image_to_post(string $file_path, int $post_id, string $title): int|false {
    $filename  = basename($file_path);
    $contents  = file_get_contents($file_path);
    if ($contents === false) return false;

    $upload = wp_upload_bits($filename, null, $contents);
    if (!empty($upload['error'])) return false;

    $filetype  = wp_check_filetype($upload['file']);
    $attach_id = wp_insert_attachment([
        'post_mime_type' => $filetype['type'],
        'post_title'     => $title,
        'post_content'   => '',
        'post_status'    => 'inherit',
    ], $upload['file'], $post_id);

    if (is_wp_error($attach_id)) return false;

    wp_update_attachment_metadata(
        $attach_id,
        wp_generate_attachment_metadata($attach_id, $upload['file'])
    );

    return $attach_id;
}

/* ---- Admin page: Tools → Импорт изображений ---- */
add_action('admin_menu', function () {
    add_management_page(
        __('Импорт изображений', 'sant-andreasberg'),
        __('Импорт изображений', 'sant-andreasberg'),
        'manage_options',
        'sa-import-images',
        'sa_import_images_admin_page'
    );
});

function sa_import_images_admin_page(): void {
    $done = (int) get_option('sa_images_imported', 0);
    ?>
    <div class="wrap">
      <h1><?php esc_html_e('Импорт изображений', 'sant-andreasberg'); ?></h1>
      <p><?php esc_html_e('Загружает фотографии из бэкапа старого сайта в медиабиблиотеку WordPress и назначает их как обложки статей и страниц.', 'sant-andreasberg'); ?></p>

      <?php if ($done): ?>
        <div class="notice notice-success inline">
          <p><?php esc_html_e('Изображения уже импортированы. Нажмите кнопку, чтобы повторить импорт (пропустит записи, у которых уже есть обложка).', 'sant-andreasberg'); ?></p>
        </div>
      <?php endif; ?>

      <p style="margin-top:1.5rem">
        <button id="sa-import-images-btn" class="button button-primary button-large"
          data-loading="<?php esc_attr_e('Импортирую…', 'sant-andreasberg'); ?>">
          <?php esc_html_e('Импортировать изображения', 'sant-andreasberg'); ?>
        </button>
      </p>
      <p id="sa-import-images-msg" style="font-weight:600;margin-top:.75rem"></p>

      <hr>
      <h2><?php esc_html_e('Что будет импортировано', 'sant-andreasberg'); ?></h2>
      <ul style="list-style:disc;padding-left:1.5em">
        <li>Ski-Pisten → blick-msb.jpg</li>
        <li>Loipen → nordisch.jpg</li>
        <li>Rodeln/Tubing → rodeln3.jpg</li>
        <li>Winterwandern → winterwanderung1.jpg</li>
        <li>Wandern → jordanshoehe.jpg</li>
        <li>Mountainbike → bike-beerberg.jpg</li>
        <li>Nordic Walking → blick-vom-glockenberg.jpg</li>
        <li>Abenteuer → hochseil1.jpg</li>
        <li><?php esc_html_e('Страница «О городе» → rathaus.jpg', 'sant-andreasberg'); ?></li>
        <li><?php esc_html_e('История → samson2003.jpg', 'sant-andreasberg'); ?></li>
        <li><?php esc_html_e('Страница Зима → winter-bank.jpg', 'sant-andreasberg'); ?></li>
        <li><?php esc_html_e('Страница Лето → kuhaustrieb.jpg', 'sant-andreasberg'); ?></li>
        <li><?php esc_html_e('Достопримечательности → glockenturm.jpg', 'sant-andreasberg'); ?></li>
      </ul>
    </div>

    <script>
    (function(){
      var btn = document.getElementById('sa-import-images-btn');
      var msg = document.getElementById('sa-import-images-msg');
      if(!btn) return;
      btn.addEventListener('click', function(){
        btn.disabled = true;
        btn.textContent = btn.dataset.loading;
        var fd = new FormData();
        fd.append('action', 'sa_run_import_images');
        fd.append('nonce', '<?php echo esc_js(wp_create_nonce('sa_import_images')); ?>');
        fetch('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', {method:'POST', body:fd})
          .then(function(r){ return r.json(); })
          .then(function(d){
            msg.textContent = d.success ? d.data : ('Ошибка: ' + (d.data || '?'));
            msg.style.color = d.success ? 'green' : 'red';
            btn.disabled = false;
            btn.textContent = '<?php echo esc_js(__('Импортировать изображения', 'sant-andreasberg')); ?>';
          })
          .catch(function(){
            msg.textContent = '<?php echo esc_js(__('Ошибка сети', 'sant-andreasberg')); ?>';
            msg.style.color = 'red';
            btn.disabled = false;
            btn.textContent = '<?php echo esc_js(__('Импортировать изображения', 'sant-andreasberg')); ?>';
          });
      });
    })();
    </script>
    <?php
}

add_action('wp_ajax_sa_run_import_images', function () {
    check_ajax_referer('sa_import_images', 'nonce');
    if (!current_user_can('manage_options')) {
        wp_send_json_error(__('Нет доступа.', 'sant-andreasberg'));
    }

    $results = sa_import_images();
    update_option('sa_images_imported', 1);

    $msg = sprintf(
        __('Готово: %d загружено, %d пропущено.', 'sant-andreasberg'),
        $results['ok'],
        $results['skip']
    );
    if (!empty($results['error'])) {
        $msg .= ' ' . __('Ошибки:', 'sant-andreasberg') . ' ' . implode('; ', $results['error']);
    }

    wp_send_json_success($msg);
});
